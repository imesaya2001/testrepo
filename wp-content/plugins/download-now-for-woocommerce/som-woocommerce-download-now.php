<?php

/**
 * Plugin Name: Free Downloads WooCommerce
 * Plugin URI: https://squareonemedia.co.uk
 * Description: Allow users to instantly download your free digital products without going through the checkout.
 * Version: 3.5.1
 * Author: Square One Media
 * Author URI: https://squareonemedia.co.uk
 * Requires at least: 4.4
 * Tested up to: 5.9
 * Requires PHP: 7.4.0
 *
 * Text Domain: download-now-for-woocommerce
 * Domain Path: /i18n/languages
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 6.3
 *
 * Copyright 2021 Square One Media
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace SOM\FreeDownloads;

defined('ABSPATH') || exit;

if (defined('SOMDN_FILE')) {
    if (SOMDN_FILE != __FILE__) {
        require_once 'somdn-uninstall-existing.php';
        // Return after deactivating the existing Free Downloads plugin.
        // Once the page has finished loading the new plugin will be active.
        return;
    }
}

define('SOMDN_FILE', __FILE__);

if (version_compare('7.4.0', PHP_VERSION, '>')) {
    add_action('admin_notices', function() {
        printf(
            '<div class="notice notice-error">' .
            '<p style="font-size: 16px;"><strong>%1s</strong> is currently not running.</p>' .
            '<p style="font-size: 16px;">This plugin requires a minimum PHP version of %2s. '.
            'You are running version %3s.</p>' .
            '</div>',
            'Free Downloads WooCommerce',
            '7.4.0',
            PHP_VERSION
        );
    });
    return;
}

require_once 'bootstrap.php';
