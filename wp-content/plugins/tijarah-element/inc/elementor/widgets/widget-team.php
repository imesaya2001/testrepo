<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// team
class tijarah_Widget_Team extends Widget_Base {
 
   public function get_name() {
      return 'team';
   }
 
   public function get_title() {
      return esc_html__( 'Team', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-person';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }
   protected function _register_controls() {
      $this->start_controls_section(
         'team_section',
         [
            'label' => esc_html__( 'team', 'tijarah' ),
            'type' => Controls_Manager::SECTION
         ]
      );
      
      $this->add_control(
         'image',
         [
            'label' => __( 'Choose photo', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
               'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
         ]
      );
      
      $this->add_control(
         'name',
         [
            'label' => __( 'Name', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'John Doe', 'tijarah' ),
         ]
      );
      $this->add_control(
         'designation',
         [
            'label' => __( 'Designation', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'App Developer', 'tijarah' ),
         ]
      );
      
      $social = new \Elementor\Repeater();

      $social->add_control(
         'social_icon', [
            'label' => __( 'Social Icon', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::ICON,
            'default' => 'fa fa-facebook',
         ]
      );

      $social->add_control(
         'social_url', [
            'label' => __( 'Socia URL', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '#',
         ]
      );

      $this->add_control(
         'social_media',
         [
            'label' => __( 'social profile', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $social->get_controls(),
            'title_field' => 'Social Item',
            'default' => [
               [
                  'social_icon' => 'fa fa-facebook',
                  'social_url' => '#'
               ],
               [
                  'social_icon' => 'fa fa-twitter',
                  'social_url' => '#'
               ],
               [
                  'social_icon' => 'fa fa-linkedin',
                  'social_url' => '#'
               ]
            ],
            'title_field' => '{{{ social_icon }}}',
         ]
      );
      
      $this->end_controls_section();
   }
   protected function render( $instance = [] ) {
 
      // get our input from the widget settings.
       
      $settings = $this->get_settings_for_display();
      
      //Inline Editing
      $this->add_inline_editing_attributes( 'name', 'basic' );
      $this->add_inline_editing_attributes( 'designation', 'basic' );
      ?>

      <div class="tijarah-team">
         <?php echo wp_get_attachment_image( $settings['image']['id'], 'tijarah-400x400' ); ?>
         <div class="position-relative">
            <div class="tijarah-team-content">
               <h4 <?php echo $this->get_render_attribute_string( 'name' ); ?>><?php echo esc_html($settings['name']); ?></h4>
               <span <?php echo $this->get_render_attribute_string( 'designation' ); ?>><?php echo esc_html($settings['designation']); ?></span>
            </div>
         </div>
         <ul class="tijarah-team-social">
            <?php 
            foreach (  $settings['social_media'] as $single_social ) { ?>
               <li class="list-inline-item"><a href="<?php echo esc_attr( $single_social['social_url'] ) ?>"><i class="fas fa-fw <?php echo esc_attr( $single_social['social_icon']) ?>"></i></a></li>
            <?php 
            } ?>
         </ul>
      </div>
      <?php
   }
 
}
Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Team );