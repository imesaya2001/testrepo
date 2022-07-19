<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Title
class tijarah_Widget_Testimonials extends Widget_Base {
 
   public function get_name() {
      return 'testimonials';
   }
 
   public function get_title() {
      return esc_html__( 'Testimonials', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-testimonial';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'testimonials_section',
         [
            'label' => esc_html__( 'Testimonials', 'tijarah' ),
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
      
      $repeater->add_control(
         'name',
         [
            'label' => __( 'Name', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            
         ]
      );

      $repeater->add_control(
         'designation',
         [
            'label' => __( 'Designation', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT
         ]
      );

      $repeater->add_control(
         'testimonial',
         [
            'label' => __( 'Testimonial', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA
         ]
      );

      
      $repeater->add_control(
         'rating',
         [
            'label' => __( 'Rating', 'appnova' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
              'range' => [
                '%' => [
                  'min' => 1,
                  'max' => 5,
                  'step' => 1,
                ]
              ],
              'default' => [
                'unit' => '%',
                'size' => 5,
              ],
         ]
      );

      $this->add_control(
         'testimonial_list',
         [
            'label' => __( 'Testimonial List', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{name}}}',

         ]
      );
      
      $this->end_controls_section();

   }

   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.       
      $settings = $this->get_settings_for_display(); ?>

      <div class="row align-items-center">
        <div class="col-lg-4 col-md-4">
            <div class="testimonials">
              <?php foreach (  $settings['testimonial_list'] as $testimonial_single ): ?>
                <div class="testimonial-img">
                    <img src="<?php echo esc_url( $testimonial_single['image']['url'] ); ?>" alt="<?php echo esc_html($testimonial_single['name']); ?>">
                </div>
              <?php endforeach; ?>
            </div>
        </div>
        <div class="col-lg-7 col-md-8">
            <div class="testimonials-nav">
              <?php foreach (  $settings['testimonial_list'] as $testimonial_single ): ?>
                <div class="testimonial-content">
                    <i class="fas fa-quote-left"></i>
                    <p><?php echo esc_html($testimonial_single['testimonial']); ?></p>
                    <div class="testi-bottom">
                    <div class="client-info">
                        <h4><?php echo esc_html($testimonial_single['name']); ?></h4>
                        <span><?php echo esc_html($testimonial_single['designation']); ?></span>
                    </div>
                  
                    <ul class="list-inline">
                     <?php for ($i=0; $i < $testimonial_single['rating']['size']; $i++) { ?>
                       <li class="list-inline-item"><i class="fa fa-star"></i></li>
                     <?php } ?>
                    </ul>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
        </div>
      </div>

   <?php } 
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Testimonials );