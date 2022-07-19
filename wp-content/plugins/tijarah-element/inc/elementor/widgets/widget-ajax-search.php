<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// search
class tijarah_Widget_search extends Widget_Base {
 
   public function get_name() {
      return 'search';
   }
 
   public function get_title() {
      return esc_html__( 'Search', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-search-bold';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'search_section',
         [
            'label' => esc_html__( 'Search', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
    // get our input from the widget settings.       
    $settings = $this->get_settings_for_display(); ?>

      <form class="ajax-search-form" method="GET" action="<?php echo esc_url(home_url( '/' )); ?>">
          <input type="text" name="s" id="keyword" onkeyup="fetch()" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'tijarah' ); ?>">
          <button type="submit"><i class="fa fa-search"></i></button>
          <input type="hidden" name="post_type" value="product" />
      </form>
      <div id="datafetch"></div>

      <?php
   }
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_search );