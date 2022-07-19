<?php

if ( ! defined( 'ABSPATH' ) ) exit;


// get posts dropdown
function tijarah_get_posts_dropdown_array($args = [], $key = 'ID', $value = 'post_title') {
  $options = [];
  $posts = get_posts($args);
  foreach ((array) $posts as $term) {
    $options[$term->{$key}] = $term->{$value};
  }
  return $options;
}

// get terms dropdown
function tijarah_get_terms_dropdown_array($args = [], $key = 'term_id', $value = 'name') {
  $options = [];
  $terms = get_terms($args);

  if (is_wp_error($terms)) {
    return [];
  }

  foreach ((array) $terms as $term) {
    $options[$term->{$key}] = $term->{$value};
  }

  return $options;
}


function tijarah_add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'tijarah-elements',
		[
			'title' => esc_html__( 'tijarah Elements', 'tijarah' ),
			'icon' => 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'tijarah_add_elementor_widget_categories' );

//Elementor init

class tijarah_ElementorCustomElement {
 
   private static $instance = null;
 
   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }
 
   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
   }


   public function widgets_registered() {
 
    // We check if the Elementor plugin has been installed / activated.
    if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){      
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-accordion.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-ajax-search.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-audio-products.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-banner.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-banner2.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-blog.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-button.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-counter.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-download.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-featured.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-newest.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-cta.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-partner.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-photo-products.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-pricing-woocommerce.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-pricing.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-products.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-infobox.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-team.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-testimonials.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-title.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-video-products.php');
         include_once(plugin_dir_path( __FILE__ ).'/widgets/widget-video.php');
      }
	}

}
 
tijarah_ElementorCustomElement::get_instance()->init();