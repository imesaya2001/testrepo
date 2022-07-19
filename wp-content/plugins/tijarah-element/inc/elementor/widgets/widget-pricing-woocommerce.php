<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Pricing
class Tijarah_Widget_Pricing_WooCommerce extends Widget_Base {
 
   public function get_name() {
      return 'pricing_woocommerce';
   }
 
   public function get_title() {
      return esc_html__( 'Pricing WooCommerce', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-price-table';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'pricing_section',
         [
            'label' => esc_html__( 'Pricing', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'order',
         [
            'label' => __( 'Order', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'ASC',
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
         $blog = new \WP_Query( array( 
            'post_type' => 'pricing',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => true,
            'order' => $settings['order'],
         ));
         /* Start the Loop */
         while ( $blog->have_posts() ) : $blog->the_post();
         ?>
         <div class="col-lg-4 col-md-6">
            <div class="tijarah-pricing-table">
               <i aria-hidden="true" style="color:<?php echo esc_attr( get_post_meta( get_the_ID(), 'icon_color', 1 ) ) ?>; background-image: linear-gradient(180deg, <?php echo esc_attr( get_post_meta( get_the_ID(), 'gradient_color_from', 1 ) ) ?> 0%, <?php echo esc_attr( get_post_meta( get_the_ID(), 'gradient_color_to', 1 ) ) ?> 180%);" class="<?php echo esc_html( get_post_meta( get_the_ID(), 'fontawesome_icon', 1 ) ) ?>"></i>
               <h1 class="tijarah-price elementor-inline-editing">
                  <span><?php echo get_woocommerce_currency_symbol(); ?></span>
                  <?php echo get_post_meta( get_the_ID(), '_price', true ); ?>
               </h1>
               <h6><?php the_title(); ?></h6>
               <?php
               $feature_list = get_post_meta( get_the_ID(), 'feature_list', 1 );
               if ($feature_list): ?>
                  <ul>
                     <?php foreach ($feature_list as $key => $feature): ?>
                        <li><?php echo esc_html( $feature ) ?></li>
                     <?php endforeach ?>            
                  </ul>
               <?php endif ?>

               <a class="tijarah-buy-button" href="<?php echo wc_get_cart_url().esc_url( '?add-to-cart=' ).get_the_ID(); ?>"><?php echo esc_html( get_post_meta( get_the_ID(), 'button_text', 1 ) ) ?></a>
            </div>
         </div>
         <?php 
         endwhile; 
         wp_reset_postdata();
         ?>
      </div>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new Tijarah_Widget_Pricing_WooCommerce );