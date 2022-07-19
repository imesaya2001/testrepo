<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Title
class tijarah_Widget_Counter extends Widget_Base {
 
   public function get_name() {
      return 'counters';
   }
 
   public function get_title() {
      return esc_html__( 'Counter', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-counter';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'counter_section',
         [
            'label' => esc_html__( 'Counter', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'icon',
         [
            'label' => __( 'Icon', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
               'value' => 'fas fa-star',
               'library' => 'solid',
            ]
         ]     
      );

      $this->add_group_control(
         Group_Control_Background::get_type(),
         [
            'name' => 'background',
            'label' => __( 'Icon Background', 'tijarah' ),
            'types' => [ 'gradient' ],
            'selector' => '{{WRAPPER}} .counter-icon i',
         ]
      );

      $this->add_control(
         'color',
         [
            'label' => __( 'Icon Color', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ccc',
         ]     
      );

      $this->add_control(
         'count',
         [
            'label' => __( 'Count', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 4892,
         ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Total Customers', 'tijarah' ),
         ]
      );

      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
      $settings = $this->get_settings_for_display(); ?>

      <div class="counter-item text-center">
         <div class="counter-icon">
             <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ,'style' => 'color:'.$settings['color'].''] ); ?>
         </div>
         <div class="elementor-counter-number-wrapper">
         <div class="counter-content">
             <h2 class="count elementor-counter-number" data-duration="2000" data-to-value="100" data-from-value="0" data-delimiter=" "><?php echo esc_html( $settings['count'] ); ?></h2>
             <span><?php echo esc_html( $settings['title'] ); ?></span>
         </div>
         </div>
      </div>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Counter );