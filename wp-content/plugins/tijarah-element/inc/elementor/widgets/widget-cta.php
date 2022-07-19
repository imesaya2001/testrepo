<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Call_to Action
class tijarah_Widget_CTA extends Widget_Base {
 
   public function get_name() {
      return 'call_to_action';
   }
 
   public function get_title() {
      return esc_html__( 'Call to Action', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-call-to-action';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'call_to_action_section',
         [
            'label' => esc_html__( 'Call to Action', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Join Us Today', 'tijarah' )
         ]
      );

      $this->add_control(
         'description',
         [
            'label' => __( 'Description', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Over 75,000 designers and developers trust the tijarah.', 'tijarah' )
         ]
      );

      $this->add_control(
         'btn_text',
         [
            'label' => __( 'Button', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Join Us Today', 'tijarah' )
         ]
      );

      $this->add_control(
         'btn_url',
         [
            'label' => __( 'Button URL', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );


      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

      <section class="call-to-action">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-md-7 text-left">
              <h2><?php echo esc_html($settings['title']); ?></h2>
              <p class="mb-0"><?php echo esc_html($settings['description']); ?></p>
            </div>
            <div class="col-md-5 my-auto text-right">
              <a class="tijarah-btn" href="<?php echo esc_url($settings['btn_url']); ?>"><?php echo esc_html($settings['btn_text']); ?></a>
            </div>
          </div>
        </div>
        
      </section>


      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_CTA );