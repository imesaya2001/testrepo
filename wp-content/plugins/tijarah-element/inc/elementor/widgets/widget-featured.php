<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Featured
class tijarah_Widget_featured extends Widget_Base {
 
   public function get_name() {
      return 'featured';
   }
 
   public function get_title() {
      return esc_html__( 'Featured', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-favorite';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'featured_section',
         [
            'label' => esc_html__( 'Featured', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'columns',
         [
            'label' => __( 'Columns', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'col-xl-4 col-md-6',
            'options' => [
               'col-xl-12'  => __( 'Column 1', 'tijarah' ),
               'col-xl-6' => __( 'Column 2', 'tijarah' ),
               'col-xl-4 col-md-6' => __( 'Column 3', 'tijarah' ),
               'col-xl-3' => __( 'Column 4', 'tijarah' ),
               'col-xl-2' => __( 'Column 6', 'tijarah' ),
               'col-xl-1' => __( 'Column 12', 'tijarah' ),
            ],
         ]
      );

      $this->add_control(
         'ppp',
         [
            'label' => __( 'Number of Items', 'tijarah' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
               'no' => [
                  'min' => 0,
                  'max' => 100,
                  'step' => 1,
               ],
            ],
            'default' => [
               'size' => 3,
            ]
         ]
      );

      $this->add_control(
         'order',
         [
            'label' => __( 'order', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
               'ASC'  => __( 'Ascending', 'tijarah' ),
               'DESC' => __( 'Descending', 'tijarah' )
            ],
         ]
      );

      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>
      <div class="container">
         <div class="row justify-content-center">
            <?php

            $featured = new \WP_Query( array( 
               'post_type' => 'product',
               'posts_per_page' => $settings['ppp']['size'],
               'order' => $settings['order'],
               'post_status'  => 'publish',
               'tax_query' => array(
                  array(
                     'taxonomy' => 'product_visibility',
                     'field'    => 'name',
                     'terms'    => 'featured',
                  ),
                ),
            ));

            /* Start the Loop */
            while ( $featured->have_posts() ) : $featured->the_post(); ?>
               <!-- Item -->
               <div class="<?php echo esc_attr($settings['columns']) ?>">
                <?php do_action( 'get_tijarah_product_item' ) ?>
               </div>

            <?php 
            endwhile; 
         wp_reset_postdata();
         ?>
         </div>
      </div>
   <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_featured );