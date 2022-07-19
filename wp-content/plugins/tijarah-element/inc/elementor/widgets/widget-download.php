<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Download
class tijarah_Widget_download extends Widget_Base {
 
   public function get_name() {
      return 'download';
   }
 
   public function get_title() {
      return esc_html__( 'Download', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-gallery-masonry';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'download_section',
         [
            'label' => esc_html__( 'Download', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
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
         'filter',
         [
            'label' => __( 'Filter', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'tijarah' ),
            'label_off' => __( 'No', 'tijarah' ),
            'return_value' => 'yes',
            'default' => 'yes'
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
               'size' => 9,
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
         <?php if ( 'yes' == $settings['filter'] ) {?>
            <div class="download-filter">
               <ul class="list-inline">
                  <li class="select-cat list-inline-item product-filter" data-product-cat="<?php foreach ( $settings['category'] as $category ) { echo esc_attr( get_term_by('id', $category, 'product_cat')->slug ).','; } ?>"><?php echo esc_html__( 'All Items', 'tijarah' ) ?></li>

                  <?php

                  if ( $settings['category'] ) {

                     foreach ( $settings['category'] as $category ) { ?>

                     <li class="list-inline-item product-filter" data-product-cat="<?php echo esc_attr( get_term_by('id', $category, 'product_cat')->slug ) ?>"><?php echo esc_html( get_term_by('id', $category, 'product_cat')->name ) ?></li>

                     <?php }
                  } ?>
               </ul>
            </div>
            <div class="loader"></div>
         <?php } ?>
         
         <div class="download_items row justify-content-center">
            <div class="loader"></div>
            <?php

            $category = !empty( $settings['category'] ) ? $settings['category'] : 'All';

            $download = new \WP_Query( array( 
               'post_type' => 'product',
               'post_status' => 'publish',
               'posts_per_page' => $settings['ppp']['size'],
               'order' => $settings['order'],
               'tax_query'     => array(
                  array(
                     'taxonomy'  => 'product_cat',
                     'field'     => 'id', 
                     'terms'     => $category
                  ),
                  array(
                     'taxonomy' =>   'product_visibility',
                     'field'    =>   'name',
                     'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                     'operator' =>   'NOT IN'
                  )
               )
            ));
 
            /* Start the Loop */
            while ( $download->have_posts() ) : $download->the_post(); ?>
               <!-- Item -->
               <div class="col-xl-4 col-md-6">
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

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_download );