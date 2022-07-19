<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Products
class tijarah_Widget_products extends Widget_Base {
 
   public function get_name() {
      return 'Products';
   }
 
   public function get_title() {
      return esc_html__( 'Products', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-form-vertical';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'products_section',
         [
            'label' => esc_html__( 'Products', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'columns',
         [
            'label' => __( 'Columns', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'col-md-4',
            'options' => [
               'col-md-12'  => __( 'Column 1', 'tijarah' ),
               'col-md-6' => __( 'Column 2', 'tijarah' ),
               'col-md-4' => __( 'Column 3', 'tijarah' ),
               'col-md-3' => __( 'Column 4', 'tijarah' ),
               'col-md-2' => __( 'Column 6', 'tijarah' ),
               'col-md-1' => __( 'Column 12', 'tijarah' ),
            ],
         ]
      );

      $this->add_control(
         'category',
         [
            'label' => esc_html__( 'Category', 'tijarah' ),
            'type' => Controls_Manager::SELECT2, 
            'title' => esc_html__( 'Select a category', 'tijarah' ),
            'multiple' => true,
            'options' => tijarah_get_terms_dropdown_array([
               'taxonomy' => 'product_cat',
               'hide_empty' => false,
            ]),
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

      <div class="row justify-content-center">
         <?php

         $category = !empty( $settings['category'] ) ? $settings['category'] : 'All';

         $products = new \WP_Query( array( 
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $settings['ppp']['size'],
            'order' => $settings['order'],
            'tax_query'     => array(
                 array(
                     'taxonomy'  => 'product_cat',
                     'field'     => 'id', 
                     'terms'     => $category
                 )
             )

         ));

         /* Start the Loop */
         while ( $products->have_posts() ) : $products->the_post(); ?>
            <!-- Item -->
            <div class="<?php echo esc_attr($settings['columns']) ?>">
             <?php do_action( 'get_tijarah_product_item' ) ?>
            </div>

         <?php 
         endwhile; 
      wp_reset_postdata();
      ?>
      </div>
   <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_products );