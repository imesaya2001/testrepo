<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Banner
class tijarah_Widget_Banner extends Widget_Base {
 
   public function get_name() {
      return 'banner';
   }
 
   public function get_title() {
      return esc_html__( 'Banner', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-slider-video';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'banner_section',
         [
            'label' => esc_html__( 'Banner', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Best Themes and Pluginse Marketplace','tijarah' )
         ]
      );

      $this->add_control(
         'description',
         [
            'label' => __( 'Description', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('tijarah is the most powerful, & customizable theme for eCommerce Products','tijarah' )
         ]
      );

      $this->add_control(
        'banner_image',
        [
          'label' => __( 'Banner image', 'tijarah' ),
          'type' => \Elementor\Controls_Manager::MEDIA,
          'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
          ],
        ]
      );


      $this->add_control(
         'search_display',
         [
            'label' => __( 'Search', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'tijarah' ),
            'label_off' => __( 'Off', 'tijarah' ),
            'return_value' => 'on',
            'default' => 'off',
         ]
      );

      $this->add_control(
         'button_display',
         [
            'label' => __( 'Button', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'On', 'tijarah' ),
            'label_off' => __( 'Off', 'tijarah' ),
            'return_value' => 'on',
            'default' => 'off',
         ]
      );

      $button = new \Elementor\Repeater();

      $button->add_control(
         'button',
         [
            'label' => __( 'Button Text', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Learn More', 'tijarah' )
         ]
      );

      $button->add_control(
         'button_url',
         [
            'label' => __( 'Button URL', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#'
         ]
      );

      $this->add_control(
         'button_list',
         [
            'label' => __( 'Button List', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $button->get_controls(),
            'default' => [
               [
                  'button' => __( 'Shop Now', 'tijarah' ),
                  'button_url' => '#',
               ],
               [
                  'button' => __( 'Learn More', 'tijarah' ),
                  'button_url' => '#',
               ],
            ],
            'title_field' => '{{{ button }}}',
            'condition' => [
               'button_display' => 'on'
            ]
         ]
      );
      
      $this->add_control(
         'textcolor',
         [
            'label' => __( 'Text Color', 'appku' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
               'default' => __( 'Default', 'appku' ),
               'white' => __( 'White', 'appku' )
            ],
         ]
      );
      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display(); ?>

      <section class="banner <?php if ( $settings['textcolor'] == 'white' ){ echo'white-text-color'; } ?>">
        <div class="container">
            <div class="row">
              <div class="col-lg-7">
                <div class="banner-content">
                  <h1><?php echo esc_html($settings['title']); ?></h1>
                  <p><?php echo esc_html($settings['description']); ?></p>

                  <?php if ( 'on' == $settings['search_display'] ): ?>                    
                  <div class="tijarah-product-search-form">
                    <form method="GET" action="<?php echo esc_url(home_url( '/' )); ?>">
                      <div class="tijarah-download-cat-filter">
                        <?php wp_dropdown_categories( array(
                          'show_option_all' => esc_html__('All Categories','tijarah'),
                          'taxonomy' => 'product_cat',
                          'name' => 'product_cat',
                          'hide_empty' => 1,
                          'show_count' => 1,
                          'value_field' => 'slug'
                        ) ); ?>
                      </div>
                      <div class="tijarah-search-fields">
                        <input name="s" value="<?php echo (isset($_GET['s']))?$_GET['s']: null; ?>" type="text">
                        <input type="hidden" name="post_type" value="product">
                        <span class="tijarah-search-btn"><input type="submit" value="<?php echo esc_attr__('All Search','tijarah') ?>"></span>
                      </div>
                    </form>
                  </div>
                  <?php endif ?>
                </div>
            
                <?php if ( 'on' == $settings['button_display'] ): ?>
                  <div class="clearfix"></div>
                  <ul class="list-inline banner-button">
                    <?php 
                       foreach (  $settings['button_list'] as $index => $button ) { 
                       $button_inline = $this->get_repeater_setting_key( 'button','button_list',$index);
                       $this->add_inline_editing_attributes( $button_inline, 'basic' );
                    ?>
                    <li  class="list-inline-item" <?php echo esc_attr( $this->get_render_attribute_string( $button_inline ) ); ?>>
                      <a href="<?php echo esc_url( $button['button_url'] ) ?>"><?php echo esc_html( $button['button'] ) ?></a>           
                    </li>
                    <?php 
                    } ?>
                </ul>
                <?php endif ?>
              </div>
              <?php if ($settings['banner_image']['url']): ?>
                <div class="col-lg-6 my-auto">
                  <img src="<?php echo esc_url($settings['banner_image']['url']) ?>" alt="<?php echo esc_attr($settings['title']); ?>">
                </div>
              <?php endif ?>
              
            </div>

        </div>
      </section>

      <?php
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Banner );