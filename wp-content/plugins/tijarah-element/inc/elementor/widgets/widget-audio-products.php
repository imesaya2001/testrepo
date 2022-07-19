<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Download
class tijarah_Widget_Audio_Product extends Widget_Base {
 
   public function get_name() {
      return 'audio_product';
   }
 
   public function get_title() {
      return esc_html__( 'Audio Product', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-gallery-masonry';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'audio_product_section',
         [
            'label' => esc_html__( 'Audio Product', 'tijarah' ),
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
         
         <div class="download_items row justify-content-center">
            
            <?php
            $category = !empty( $settings['category'] ) ? $settings['category'] : 'All';

            $download = new \WP_Query( array( 
               'post_type' => 'product',
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
            while ( $download->have_posts() ) : $download->the_post(); ?>
               <!-- Item -->
               <div class="col-xl-4 col-md-6">
                  <?php get_template_part( 'template-parts/product-type/audio', 'item' ); ?>
               </div>

            <?php 
            endwhile; 
         wp_reset_postdata();
         ?>
         </div>
   <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Audio_Product );