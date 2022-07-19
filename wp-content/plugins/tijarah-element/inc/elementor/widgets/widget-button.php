<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Button
class tijarah_Widget_Button extends Widget_Base {
 
   public function get_name() {
      return 'button';
   }
 
   public function get_title() {
      return esc_html__( 'Button', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-button';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'button_section',
         [
            'label' => esc_html__( 'Button', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'button_text', [
            'label' => __( 'Button Text', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Raed More', 'tijarah' )
         ]
      );

      $this->add_control(
         'button_icon',
         [
            'label' => __( 'Icon', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'tijarah' ),
            'label_off' => __( 'No', 'tijarah' ),
            'return_value' => 'yes',
            'default' => 'no'
         ]
      );

      $this->add_control(
         'icon',
         [
            'label' => __( 'Choose Icon', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::ICON,
            'default' => 'fa fa-play',
            'condition' => ['button_icon' => 'yes']
         ]
      );

      $this->add_control(
         'button_url', [
            'label' => __( 'Button URL', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#',
         ]
      );      

      $this->add_control(
         'popup',
         [
            'label' => __( 'Popup Video', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'tijarah' ),
            'label_off' => __( 'No', 'tijarah' ),
            'return_value' => 'yes',
            'default' => 'no'
         ]
      );

      $this->add_control(
         'align',
         [
            'label' => __( 'Alignment', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
               'left' => [
                  'title' => __( 'Left', 'tijarah' ),
                  'icon' => 'fa fa-align-left',
               ],
               'center' => [
                  'title' => __( 'Center', 'tijarah' ),
                  'icon' => 'fa fa-align-center',
               ],
               'right' => [
                  'title' => __( 'Right', 'tijarah' ),
                  'icon' => 'fa fa-align-right',
               ],
            ],
            'default' => 'left',
            'toggle' => true
         ]
      );

       $this->add_control(
         'drop_shadow',
         [
            'label' => __( 'Drop Shadow', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'tijarah' ),
            'label_off' => __( 'Hide', 'tijarah' ),
            'return_value' => 'yes',
            'default' => 'yes'
         ]
      );

      $this->add_control(
         'bordered',
         [
            'label' => __( 'Bordered', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'tijarah' ),
            'label_off' => __( 'No', 'tijarah' ),
            'return_value' => 'yes',
            'default' => 'no'
         ]
      );

      $this->add_control(
         'button_radius',
         [
            'label' => __( 'Button Radius', 'tijarah' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range' => [
               'px' => [
                  'min' => 0,
                  'max' => 50,
                  'step' => 1,
               ]
            ],
            'default' => [
               'unit' => 'px',
               'size' => 0,
            ]
         ]
      );

      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display();

      //Inline Editing
      $this->add_inline_editing_attributes( 'button_text', 'basic' );
      ?>

      <div class="text-<?php echo esc_attr($settings['align']) ?>">
         <a class="tijarah-btn <?php if( 'yes' == $settings['bordered'] ){ echo'bordered'; } ?> elementor-inline-editing <?php if('yes' == $settings['drop_shadow']){ echo'shadow'; } ?> <?php if( 'yes' == $settings['popup'] ){ echo'tijarah-popup-url'; } ?>" style="border-radius: <?php echo esc_attr($settings['button_radius']['size']) ?>px;" <?php echo $this->get_render_attribute_string( 'button_text' ); ?> href="<?php echo esc_url( $settings['button_url'] ); ?>"><?php if ( 'yes' == $settings['button_icon'] ) { echo '<i class="'.$settings['icon'].'"></i>'; } ?><?php echo esc_html( $settings['button_text'] ); ?></a>
      </div>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Button );