<?php 
namespace Elementor;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Newest Item
class tijarah_Widget_Newest extends Widget_Base {
 
   public function get_name() {
      return 'newest';
   }
 
   public function get_title() {
      return esc_html__( 'Newest', 'tijarah' );
   }
 
   public function get_icon() { 
        return 'eicon-apps';
   }
 
   public function get_categories() {
      return [ 'tijarah-elements' ];
   }

   protected function _register_controls() {

      $this->start_controls_section(
         'newest_section',
         [
            'label' => esc_html__( 'Newest', 'tijarah' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'category',
         [
            'label' => esc_html__( 'Category', 'tijarah' ),
            'type' => Controls_Manager::SELECT2, 
            'title' => esc_html__( 'Select a category', 'tijarah' ),
            'multiple' => true,
            'options' => tijarah_get_terms_dropdown_array([
               'taxonomy' => 'product_cat',
               'hide_empty' => false,
            ]),
         ]
      );

      $this->add_control(
         'filter',
         [
            'label' => __( 'Filter', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'tijarah' ),
            'label_off' => __( 'No', 'tijarah' ),
            'return_value' => 'yes',
            'default' => 'yes'
         ]
      );

      $this->add_control(
         'ppp',
         [
            'label' => __( 'Number of Items', 'tijarah' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
               'no' => [
                  'min' => 0,
                  'max' => 100,
                  'step' => 1,
               ],
            ],
            'default' => [
               'size' => 40,
            ]
         ]
      );
      
      $this->add_control(
         'order',
         [
            'label' => __( 'order', 'tijarah' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'DESC',
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
       
      $settings = $this->get_settings_for_display();

      $category = !empty( $settings['category'] ) ? $settings['category'] : 'All';

      $query = new \WP_Query( array(
         'post_type' => 'product',
         'post_status' => 'publish',
         'posts_per_page' => $settings['ppp']['size'],
         'order' => $settings['order'],
         'tax_query' => array(
            array(
                'taxonomy'  => 'product_cat',
                'field'     => 'id', 
                'terms'     => $category
            ),
            array(
                'taxonomy' =>   'product_visibility',
                'field'    =>   'name',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN'
            )
          )
      ));

      if ( 'yes' == $settings['filter'] ) { ?>

        <div class="newest-filter">
            <ul class="list-inline">
              <li class="select-cat list-inline-item thumb-product-filter" data-thumb-product-cat="<?php foreach ( $settings['category'] as $category ) { echo esc_attr( get_term_by('id', $category, 'product_cat')->slug ).','; } ?>"><?php echo esc_html__( 'All Items', 'tijarah' ) ?></li>

              <?php 

              if ( $settings['category'] ) {

                foreach ( $settings['category'] as $category ) { ?>
              
                <li class="list-inline-item thumb-product-filter" data-thumb-product-cat="<?php echo esc_attr( get_term_by('id', $category, 'product_cat')->slug ) ?>"><?php echo esc_html( get_term_by('id', $category, 'product_cat')->name ) ?></li>

                <?php }

              } ?>
              
            </ul>
        </div>

      <?php }
      ?>


      <div class="container loader-rel">
        <div class="loader"></div>
        <div class="newest_items row justify-content-center no-gutters">
         <?php if ( $query->have_posts() ){ ?>

           <?php while ( $query->have_posts() ) { $query->the_post(); ?>
            
            <div class="col-auto">
               <?php tijarah_thumbnail_product_item() ?>
            </div>

           <?php } ?>

        </div>
      </div>

      <?php } else { ?>

         <h2><?php echo esc_html__('No item found','tijarah'); ?></h2>

      <?php }  wp_reset_postdata();
   }
 
}

Plugin::instance()->widgets_manager->register_widget_type( new tijarah_Widget_Newest );