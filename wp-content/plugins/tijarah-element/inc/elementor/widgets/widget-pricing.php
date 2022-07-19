<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Pricing
class tijarah_Widget_Pricing extends Widget_Base {
 
   public function get_name() {
      return 'pricing';
   }
 
   public function get_title() {
      return esc_html__( 'Pricing', 'tijarah' );
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
            'selector' => '{{WRAPPER}} .tijarah-pricing-table i',
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
         'price',
         [
            'label' => __( 'Price', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '70'
         ]
      );
      

      $this->add_control(
         'currency',
         [
            'label' => __( 'Currency', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( '$', 'tijarah' )
         ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'title', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Basic'
         ]
      );

      $feature = new \Elementor\Repeater();

      $feature->add_control(
         'feature',
         [
            'label' => __( 'Feature', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Demo Content Install', 'tijarah' )
         ]
      );

      $this->add_control(
         'feature_list',
         [
            'label' => __( 'Feature List', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $feature->get_controls(),
            'default' => [
               [
                  'feature' => __( 'Demo Content Install', 'tijarah' )
               ],
               [
                  'feature' => __( 'Premium Support', 'tijarah' )
               ],
               [
                  'feature' => __( 'Theme Updates', 'tijarah' )
               ],
               [
                  'feature' => __( 'Support And Updates', 'tijarah' )
               ],
               [
                  'feature' => __( 'Access All Themes', 'tijarah' )
               ],
               [
                  'feature' => __( 'All Themes For Life', 'tijarah' )
               ]
            ],
            'title_field' => '{{{ feature }}}'
         ]
      );

      $this->add_control(
         'btn_text',
         [
            'label' => __( 'button text', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get Started'
         ]
      );

      $this->add_control(
         'btn_url',
         [
            'label' => __( 'button URL', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );

      $this->add_control(
         'recommended',
         [
            'label' => __( 'Recommended', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'tijarah' ),
            'label_off' => __( 'Off', 'tijarah' ),
            'return_value' => 'on',
            'default' => 'off',
         ]
      );

      $this->end_controls_section();
   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display();
      
      //Inline Editing
      $this->add_inline_editing_attributes( 'title', 'basic' );
      $this->add_inline_editing_attributes( 'price', 'basic' );
      $this->add_inline_editing_attributes( 'btn_text', 'basic' );
      ?>

      <div class="tijarah-pricing-table <?php if ( 'on' == $settings['recommended'] ){ echo"recommended"; }?>">
         <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ,'style' => 'color:'.$settings['color'].''] ); ?>
         <h1 class="tijarah-price elementor-inline-editing" <?php echo esc_attr( $this->get_render_attribute_string( 'price' ) ); ?>>
            <span><?php echo esc_attr( $settings['currency'] ) ?></span>
            <?php echo esc_html( $settings['price'] ); ?>
         </h1>
         <h6 class="type elementor-inline-editing" <?php echo esc_attr( $this->get_render_attribute_string( 'title' ) ); ?>><?php echo esc_html( $settings['title'] ); ?></h6>
         <ul>
            <?php 
               foreach (  $settings['feature_list'] as $index => $feature ) { 
               $feature_inline = $this->get_repeater_setting_key( 'feature','feature_list',$index);
               $this->add_inline_editing_attributes( $feature_inline, 'basic' );
            ?>
               <li <?php echo esc_attr( $this->get_render_attribute_string( $feature_inline ) ); ?>><?php echo esc_html( $feature['feature'] ) ?></li>
            <?php 
            } ?>
         </ul>
         <a class="elementor-inline-editing tijarah-buy-button" href="<?php echo esc_url( $settings['btn_url'] ) ?>" <?php echo esc_attr( $this->get_render_attribute_string( 'btn_text' ) ); ?>><?php echo esc_html( $settings['btn_text'] ) ?></a>
      </div>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Pricing );