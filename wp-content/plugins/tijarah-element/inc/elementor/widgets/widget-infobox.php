<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// InfoBox item
class tijarah_Widget_InfoBox extends Widget_Base {
 
   public function get_name() {
      return 'InfoBox_item';
   }
 
   public function get_title() {
      return esc_html__( 'Info Box', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-facebook-comments';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }
   protected function _register_controls() {
      $this->start_controls_section(
         'InfoBox_section',
         [
            'label' => esc_html__( 'Info Box', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'align',
         [
            'label' => __( 'Alignment', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
               'left' => [
                  'title' => __( 'Left', 'plugin-domain' ),
                  'icon' => 'fa fa-align-left',
               ],
               'center' => [
                  'title' => __( 'Center', 'plugin-domain' ),
                  'icon' => 'fa fa-align-center',
               ],
               'right' => [
                  'title' => __( 'Right', 'plugin-domain' ),
                  'icon' => 'fa fa-align-right',
               ],
            ],
            'default' => 'left',
            'toggle' => true,
         ]
      );
      
      $this->add_control(
         'bg_color',
         [
            'label' => __( 'Background Color', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ece6f9',
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
            'selector' => '{{WRAPPER}} .infobox-item i',
         ]
      );

      $this->add_group_control(
         Group_Control_Box_Shadow::get_type(),
         [
            'name' => 'box_shadow',
            'label' => __( 'Box Shadow', 'tijarah' ),
            'selector' => '{{WRAPPER}} .infobox-item i',
         ]
      );


      $this->add_control(
         'color',
         [
            'label' => __( 'Icon Color', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#fff',
         ]     
      );


      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Design','tijarah'),
         ]
      );
      $this->add_control(
         'text',
         [
            'label' => __( 'Text', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Lorem ipsum dummy text in print and website industry are usually use in these section','tijarah'),
         ]
      );

      $this->add_control(
         'text_color',
         [
            'label' => __( 'Text Color', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#7d6e9b'
         ]     
      );
      
      $this->end_controls_section();
   }
   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

         <div class="infobox-item style-2 text-<?php echo esc_attr( $settings['align'] ) ?>" style="background: <?php echo esc_attr( $settings['bg_color'] ) ?>">
            <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ,'style' => 'color:'.$settings['color'].''] ); ?>
            <h5 style="color:<?php echo esc_attr( $settings['text_color'] ) ?>"><?php echo esc_html($settings['title']); ?></h5>
            <p style="color:<?php echo esc_attr( $settings['text_color'] ) ?>"><?php echo wp_kses( $settings['text'] , array( 'br' =>  array() )); ?></p>
         </div>

      <?php
   }
 
}
Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_InfoBox );