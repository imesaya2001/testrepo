<?php

/**
 * Author: Mikołaj `iClyde` Chodorowski
 * Contact: kontakt@iclyde.pl
 * Package: Backup Migration – WP Plugin
 */

// Namespace
namespace BMI\Plugin\Database;

// Use
use BMI\Plugin\BMI_Logger AS Logger;
use BMI\Plugin\Backup_Migration_Plugin as BMP;
use BMI\Plugin\Progress\BMI_ZipProgress AS Progress;
use BMI\Plugin\Database\BMI_Search_Replace_Engine as BMISearchReplace;

// Exit on direct access
if (!defined('ABSPATH')) exit;

/**
 * Database Restore Enginge v3
 */
class BMI_Even_Better_Database_Restore {

  /**
   * __construct - Make connection
   *
   * @return @self
   */
  function __construct($storage, $firstDB, &$manifest, &$logger, $splitting, $isCLI) {

    $this->isCLI = $isCLI;
    $this->splitting = $splitting;
    $this->storage = $storage;
    $this->logger = &$logger;
    $this->manifest = &$manifest;
    $this->tablemap = BMI_INCLUDES . DIRECTORY_SEPARATOR . 'htaccess' . DIRECTORY_SEPARATOR . '.table_map';

    if ($firstDB) $this->initMessage();

    $this->map = $this->getTableMap();
    $this->seek = &$this->map['seek'];

  }

  public function start() {

    if ($this->isCLI) {

      while ($nextFile = $this->getNextFile()) {
        $this->processFile($nextFile);
      }

      return true;

    } else {

      $nextFile = $this->getNextFile();
      if ($nextFile === false) return true;
      else {

        $this->processFile($nextFile);

        return false;

      }

    }

  }

  private function getTableMap() {

    if (file_exists($this->tablemap)) {

      $data = json_decode(file_get_contents($this->tablemap), true);
      $this->map = $data;

    } else {

      $data = [
        'tables' => [],
        'seek' => [
          'last_seek' => 0,
          'last_file' => '...',
          'last_start' => 0,
          'total_tables' => sizeof(array_diff(scandir($this->storage), ['..', '.'])),
          'active_plugins' => 'a:1:{i:0;s:31:"backup-backup/backup-backup.php";}'
        ]
      ];

      file_put_contents($this->tablemap, json_encode($data));

    }

    return $data;

  }

  private function getTableProgress() {

    $total_tables = $this->seek['total_tables'];
    $tables_left = sizeof(array_diff(scandir($this->storage), ['..', '.']));

    $finished_tables = ($total_tables - $tables_left) + 1;
    $percentage = number_format(($finished_tables / $total_tables) * 100, 2);

    $this->logger->progress(50 + ((number_format($percentage, 0) / 2) - 10));

    return $finished_tables . '/' . $total_tables . ' (' . $percentage . '%)';

  }

  private function queryFile(&$objFile, $tableName, $realTableName) {

    global $wpdb;

    $seek = &$this->seek['last_seek'];
    if ($seek == 0) {
      $seek = 19;
      $wpdb->query("DROP TABLE IF EXISTS `" . $tableName . "`;");

      $str = __("Started restoration of %table_name% %total_tables% table", 'backup-backup');
      $str = str_replace('%table_name%', $realTableName, $str);
      $str = str_replace('%total_tables%', $this->getTableProgress(), $str);
      $this->logger->log($str, 'INFO');
    }

    $qs = "/* QUERY START */\n";
    $qe = "/* QUERY END */\n";

    $vs = "/* VALUES START */\n";
    $ve = "/* VALUES END */\n";

    $wpdb->suppress_errors();

    $wpdb->query('SET autocommit = 0;');
    $wpdb->query('SET foreign_key_checks = 0;');
    $wpdb->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';");
    $wpdb->query('START TRANSACTION;');

    $sqlStarted = false;

    $sql = '';
    while (!$objFile->eof()) {
      $objFile->seek($seek); $seek++;

      if ($objFile->current() == $qs) { $sqlStarted = true; continue; }
      else if ($objFile->current() == $vs || $objFile->current() == $ve) {
        continue;
      } else if ($objFile->current() == $qe) {
        $sqlStarted = false;
        break;
      }

      if ($sqlStarted == true) $sql .= rtrim($objFile->current(), "\n");
    }

    $wpdb->query($sql); unset($sql);
    $wpdb->query('COMMIT;');
    $wpdb->query('SET autocommit = 1;');
    $wpdb->query('SET foreign_key_checks = 1;');

    $str = __("Progress of %table_name%: %progress%", 'backup-backup');
    $str = str_replace('%table_name%', $realTableName, $str);

    $objFile->seek($objFile->getSize());
    $total_size = $objFile->key();
    $objFile->seek($seek);

    $progress = ($seek - 1) . '/' . $total_size . " (" . number_format(($seek - 1) / $total_size * 100, 2) . "%)";
    $str = str_replace('%progress%', $progress, $str);
    $this->logger->log($str, 'INFO');

    $wpdb->show_errors();

    if ($objFile->eof()) {
      return true;
    } else {
      return false;
    }

  }

  private function addNewTableToMap($from, $to, $file) {

    if (!array_key_exists($from, $this->map['tables'])) {
      $this->map['tables'][$from] = $to;
    }

    file_put_contents($this->tablemap, json_encode($this->map));

  }

  private function processFile($file) {

    if ($this->seek['last_seek'] == 0) {
      $this->seek['last_start'] = microtime(true);
    }

    $objFile = new \SplFileObject($file);

    $objFile->seek(17);
    $realTableName = explode('`', $objFile->current())[1];

    $objFile->seek(18);
    $tmpTableName = explode('`', $objFile->current())[1];

    $finished = $this->queryFile($objFile, $tmpTableName, $realTableName);

    if ($finished && file_exists($file)) {
      $this->seek['last_seek'] = 0;
      $this->seek['last_file'] = '...';
      @unlink($file);

      $totalTime = microtime(true) - intval($this->seek['last_start']);
      $totalTime = number_format($totalTime, 5);

      $str = __("Table %table_name% restoration took %time% seconds", 'backup-backup');
      $str = str_replace('%table_name%', $realTableName, $str);
      $str = str_replace('%time%', $totalTime, $str);

      $this->logger->log($str, 'SUCCESS');
      $this->seek['last_start'] = 0;
    }

    $this->addNewTableToMap($tmpTableName, $realTableName, $file);

    return true;

  }

  private function parseDomain($domain) {

    if (substr($domain, 0, 8) == 'https://') $domain = substr($domain, 8);
    if (substr($domain, 0, 7) == 'http://') $domain = substr($domain, 7);
    if (substr($domain, 0, 4) == 'www.') $domain = substr($domain, 4);
    $domain = untrailingslashit($domain);

    return $domain;

  }

  private function replaceTableNames($tables) {

    global $wpdb;

    $this->logger->log(__('Performing table replacement', 'backup-backup'), 'STEP');

    $wpdb->suppress_errors();
    foreach ($tables as $oldTable => $newTable) {

      $sql = "DROP TABLE IF EXISTS `" . $newTable . "`;";
      $wpdb->query($sql);

      $sql = "ALTER TABLE `" . $oldTable . "` RENAME TO `" . $newTable . "`;";
      $wpdb->query($sql);

      $str = __('Table %old% renamed to %new%', 'backup-backup');
      $str = str_replace('%old%', $oldTable, $str);
      $str = str_replace('%new%', $newTable, $str);
      $this->logger->log($str, 'INFO');

    }

    $wpdb->show_errors();
    $this->logger->log(__('All tables replaced', 'backup-backup'), 'SUCCESS');

  }

  private function performReplace() {

    require_once BMI_INCLUDES . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'search-replace.php';

    $backupRootDir = $this->manifest->config->ABSPATH;
    $currentRootDir = ABSPATH;

    $backupDomain = $this->parseDomain($this->manifest->dbdomain);
    $currentDomain = $this->parseDomain(get_option('siteurl'));

    $progress = 0;

    $replaceEngine = new BMISearchReplace(array_keys($this->map['tables']));

    if ($backupRootDir != $currentRootDir || $currentDomain != $backupDomain) {
      $this->logger->log(__('Performing Search & Replace', 'backup-backup'), 'STEP');
    } else {
      $this->logger->log(__('This backup was made on the same site, ommiting search & replace.', 'backup-backup'), 'INFO');
      $progress = 8;
      $this->logger->progress(98);
    }

    if ($backupRootDir != $currentRootDir) {

      $dtables = 0; $drows = 0; $dchange = 0; $dupdates = 0;

      $r = $replaceEngine->perform($backupRootDir, $currentRootDir);
      $dtables += $r['tables']; $drows += $r['rows']; $dchange += $r['change']; $dupdates += $r['updates'];

      $info = __("Searched %tables% tables and %rows% rows for paths, changed %changes%/%updates% rows.", 'backup-backup');
      $info = str_replace('%tables%', $dtables, $info);
      $info = str_replace('%rows%', $drows, $info);
      $info = str_replace('%changes%', $dchange, $info);
      $info = str_replace('%updates%', $dupdates, $info);

      $this->logger->log($info, 'INFO');

    } else {

      $progress++;
      $this->logger->progress(90 + $progress);

    }

    if ($currentDomain != $backupDomain) {
      $ssl = is_ssl() == true ? 'https://' : 'http://';

      $dtables = 0; $drows = 0; $dchange = 0; $dupdates = 0;

      $possibleDomainsBackup = [
        "http://" . $backupDomain,
        "http://www." . $backupDomain,
        "https://" . $backupDomain,
        "https://www." . $backupDomain,
        $backupDomain
      ];

      $possibleDomainsCurrent = [
        $ssl . $currentDomain,
        $ssl . "www." . $currentDomain,
        $ssl . $currentDomain,
        $ssl . "www." . $currentDomain,
        $currentDomain
      ];

      $r = $replaceEngine->perform($possibleDomainsBackup[0], $possibleDomainsCurrent[0]);
      $dtables += $r['tables']; $drows += $r['rows']; $dchange += $r['change']; $dupdates += $r['updates'];
      $progress++; $this->logger->progress(90 + $progress);

      $r = $replaceEngine->perform($possibleDomainsBackup[1], $possibleDomainsCurrent[1]);
      $dchange += $r['change']; $dupdates += $r['updates'];
      $progress++; $this->logger->progress(90 + $progress);

      $r = $replaceEngine->perform($possibleDomainsBackup[2], $possibleDomainsCurrent[2]);
      $dchange += $r['change']; $dupdates += $r['updates'];
      $progress++; $this->logger->progress(90 + $progress);

      $r = $replaceEngine->perform($possibleDomainsBackup[3], $possibleDomainsCurrent[3]);
      $dchange += $r['change']; $dupdates += $r['updates'];
      $progress++; $this->logger->progress(90 + $progress);

      $r = $replaceEngine->perform($possibleDomainsBackup[4], $possibleDomainsCurrent[4]);
      $dchange += $r['change']; $dupdates += $r['updates'];
      $progress++; $this->logger->progress(90 + $progress);

      $info = __("Searched %tables% tables and %rows% rows for domain, changed %changes%/%updates% rows.", 'backup-backup');
      $info = str_replace('%tables%', $dtables, $info);
      $info = str_replace('%rows%', $drows, $info);
      $info = str_replace('%changes%', $dchange, $info);
      $info = str_replace('%updates%', $dupdates, $info);

      $this->logger->log($info, 'INFO');
    }

    if ($backupRootDir != $currentRootDir || $currentDomain != $backupDomain) {
      $this->logger->log(__('Search & Replace finished successfully.', 'backup-backup'), 'SUCCESS');
    }

    $this->replaceTableNames($this->map['tables']);
    $progress += 2; $this->logger->progress(90 + $progress);

    return true;

  }

  private function try_activate_plugins($plugins, $sucstr_source, $failstr_source, $failed_plugins = []) {

    $plugins_copy = array_values($plugins);
    $should_continue = false;
    $activated_plugins = [];
    $failed_plugins = $failed_plugins;
    $disallowed_plugins = [
      'bluehost-wordpress-plugin/bluehost-wordpress-plugin.php'
    ];

    for ($i = 0; $i < sizeof($plugins_copy); ++$i) {

      $plugin_name = $plugins_copy[$i];
      $plugin_display = $plugin_name;

      $shouldActivate = true;

      if (empty($plugin_name)) {
        $shouldActivate = false;
        $plugin_display = '(---)';
      } else if (strpos($plugin_name, '/') === false) {
        $shouldActivate = false;
      }

      $sucstr = str_replace('%plugin_name%', $plugin_display, $sucstr_source);
      $failstr = str_replace('%plugin_name%', $plugin_display, $failstr_source);

      if ($shouldActivate) {
        try {

          if (validate_plugin_requirements($plugin_name) && !in_array($plugin_name, $disallowed_plugins)) {

            $resultWP = activate_plugin($plugin_name, '', true, true);

            $this->logger->log($sucstr, 'INFO');
            $activated_plugins[] = $plugin_name;

            $should_continue = true;
            break;

          } else {

            if (!in_array($plugin_name, $failed_plugins)) {
              $failed_plugins[] = $plugin_name;
            }

          }

        } catch (\Exception $e) {

          if (!in_array($plugin_name, $failed_plugins)) {

            $failed_plugins[] = $plugin_name;
            error_log($e);

          }

        } catch (\Throwable $e) {

          if (!in_array($plugin_name, $failed_plugins)) {

            $msg = $e->getMessage();
            if (strpos($msg, 'add_rule()') != false || strpos($msg, 'rewrite.php:143') != false) {

              $activated_plugins[] = $plugin_name;
              error_log($e);

            } else {

              $failed_plugins[] = $plugin_name;
              error_log($e);

            }

          }

        }

      } else {

        $this->logger->log($failstr, 'WARN');

      }

    }

    return [ 'failed' => $failed_plugins, 'active' => $activated_plugins, 'should_continue' => $should_continue ];

  }

  private function enablePlugins() {

    global $wpdb;

    $this->logger->log(__('Enabling plugins included in the backup', 'backup-backup'), 'STEP');

    if (is_serialized($this->seek['active_plugins'])) {

      $plugins = unserialize($this->seek['active_plugins']);
      usort($plugins, function ($a, $b) { return strlen($a) - strlen($b); });
      $plugins = array_values($plugins);

      $sucstr_source = __('Plugin %plugin_name% enabled successfully.', 'backup-backup');
      $failstr_source = __('Failed to enable plugin %plugin_name%, trying to not end at fatal error...', 'backup-backup');

      $fullyActive = [];
      $failed_plugins = [];

      if (!function_exists('activate_plugin')) {
        require_once(ABSPATH .'/wp-admin/includes/plugin.php');
      }

      $one_more_time = true;
      $try_again = true;
      while ($try_again) {

        $res = $this->try_activate_plugins($plugins, $sucstr_source, $failstr_source, $failed_plugins);

        $fullyActive = array_unique(array_merge($fullyActive, $res['active']));
        $plugins = array_diff($plugins, $res['active']);
        $failed_plugins = array_unique(array_diff(array_merge($failed_plugins, $res['failed']), $fullyActive));

        $try_again = $res['should_continue'];
        if ($try_again == false && $one_more_time == true) {
          $one_more_time = false;
          $try_again = true;
        }

      }

      for ($i = 0; $i < sizeof($failed_plugins); ++$i) {

        $failstr = str_replace('%plugin_name%', $failed_plugins[$i], $failstr_source);
        $this->logger->log($failstr, 'WARN');

      }

      if (!in_array('backup-backup/backup-backup.php', $fullyActive)) {
        $fullyActive[] = 'backup-backup/backup-backup.php';
      }

      $sql = 'UPDATE ' . $options_table . ' SET option_value = %s WHERE option_name = "active_plugins"';
      $wpdb->query($wpdb->prepare($sql, serialize($fullyActive)));

      update_option('active_plugins', $fullyActive);

    }

    $this->logger->progress(100);
    $this->logger->log(__('All plugins enabled, you are ready to go :)', 'backup-backup'), 'SUCCESS');

  }

  public function alter_tables() {

    $this->logger->progress(90);
    $this->prepareFinalDatabase();
    $this->performReplace();
    $this->enablePlugins();

  }

  private function prepareFinalDatabase() {

    global $wpdb;

    $tables = array_keys($this->map['tables']);
    $unique_prefix = explode('_', $tables[0])[0];
    $backupPrefix = $this->manifest->config->table_prefix;

    $options_table = $unique_prefix . '_' . $backupPrefix . 'options';
    if (!in_array($options_table, $tables)) {
      $tablename = false;
      for ($i = 0; $i < sizeof($tables); ++$i) {
        $table = $tables[$i];
        if (substr($table, -7) == 'options') {
          $tablename = $table;
          break;
        }
      }

      $options_table = $tablename;
    }

    if ($options_table != false && in_array($options_table, $tables)) {

      $sql = "DELETE FROM " . $options_table . " WHERE option_name LIKE ('%\_transient\_%')";
      $wpdb->query($sql);

      $active_plugins = $wpdb->get_results('SELECT option_value FROM `' . $options_table . '` WHERE option_name = "active_plugins"');
      $active_plugins = $active_plugins[0]->option_value;

      $this->seek['active_plugins'] = $active_plugins;

      update_option('active_plugins', ['backup-backup/backup-backup.php']);

      $ssl = is_ssl() == true ? 'https://' : 'http://';
      $currentDomain = $ssl . $this->parseDomain(get_option('siteurl'));

      $sql = 'UPDATE ' . $options_table . ' SET option_value = %s WHERE option_name = "siteurl"';
      $wpdb->query($wpdb->prepare($sql, $currentDomain));

      $sql = 'UPDATE ' . $options_table . ' SET option_value = %s WHERE option_name = "home"';
      $wpdb->query($wpdb->prepare($sql, $currentDomain));

    }

  }

  private function getNextFile() {

    if ($this->seek['last_file'] == '...') {

      $nextFile = false;

      $sqlFiles = array_diff(scandir($this->storage), ['..', '.']);
      $sqlFiles = array_values($sqlFiles);

      if (sizeof($sqlFiles) > 0) {
        return $this->storage . DIRECTORY_SEPARATOR . $sqlFiles[0];
      }

      $this->seek['last_file'] = $nextFile;
      return $nextFile;

    } else {

      return $this->seek['last_file'];

    }

  }

  private function initMessage() {

    $this->logger->log(__('Successfully detected backup created with V2 engine, importing...', 'backup-backup'), 'INFO');
    $this->logger->log(__('Restoring database (using V3 engine)...', 'backup-backup'), 'STEP');

    if (file_exists($this->tablemap)) {
      @unlink($this->tablemap);
    }

  }

}
