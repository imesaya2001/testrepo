<?php
/**
* Plugin Name: Tijarah Element
* Plugin URI: https://github.com/ThemeBing/tijarah-element
* Description: After install the tijarah WordPress Theme, you must need to install this "tijarah Element" first to get all functions of tijarah WP Theme.
* Version: 1.1.0
* Author: ThemeBing
* Author URI: http://themeforest.net/user/ThemeBing
* Text Domain: tijarah
* License: GPL/GNU.
* Domain Path: /languages
*/

/**----------------------------------------------------------------*/
/* Include all file
/*-----------------------------------------------------------------*/  

include_once(dirname( __FILE__ ). '/inc/functions.php');
include_once(dirname( __FILE__ ). '/inc/update-checker.php');
include_once(dirname( __FILE__ ). '/inc/custom-post-type.php');
include_once(dirname( __FILE__ ). '/inc/elementor/elementor.php');
include_once(dirname( __FILE__ ). '/inc/social-share.php');
include_once(dirname( __FILE__ ). '/inc/widgets/widget-product-specs.php');
include_once(dirname( __FILE__ ). '/inc/widgets/widget-product-details.php');
include_once(dirname( __FILE__ ). '/inc/widgets/widget-recent-posts.php');
include_once(dirname( __FILE__ ). '/inc/ajax-woo-thumb-products/ajax.php');
include_once(dirname( __FILE__ ). '/inc/ajax-woo-products/ajax.php');
include_once(dirname( __FILE__ ). '/inc/ajax-search/ajax.php');