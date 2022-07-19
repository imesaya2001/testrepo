<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Title
class tijarah_Widget_Partner extends Widget_Base {
 
   public function get_name() {
      return 'partner';
   }
 
   public function get_title() {
      return esc_html__( 'Partner', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-site-logo';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'partner_section',
         [
            'label' => esc_html__( 'Partner', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $repeater = new \Elementor\Repeater();

      $repeater->add_control(
         'image',
         [
            'label' => __( 'Choose Photo', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
               'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
         ]
      );

      $this->add_control(
         'partner_list',
         [
            'label' => __( 'Partner List', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls()

         ]
      );
      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.       
      $settings = $this->get_settings_for_display(); ?>
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <?php foreach (  $settings['partner_list'] as $partner_single ){ ?>
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="partner">
                <img class="img-fluid" src="<?php echo esc_url( $partner_single['image']['url'] ); ?>" alt="Logo">
            </div>
          </div>
          <?php } ?>
        </div>
      </div>

   <?php } 
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Partner );