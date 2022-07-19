<?php 
function tijarah_ajax_filter_products_scripts() {
  // Enqueue script
  wp_register_script('tijarah_product_ajax_script', plugin_dir_url( __FILE__ ) . 'ajax.js', false, null, false);
  wp_enqueue_script('tijarah_product_ajax_script');

  wp_localize_script( 'tijarah_product_ajax_script', 'tijarah_ajax_products_obj', array(
        'tijarah_product_ajax_nonce' => wp_create_nonce( 'tijarah_product_ajax_nonce' ),
        'tijarah_product_ajax_url' => admin_url( 'admin-ajax.php' ),
      )
  );
}
add_action('wp_enqueue_scripts', 'tijarah_ajax_filter_products_scripts');


// Script for getting posts
function tijarah_ajax_filter_get_products( $taxonomy ) {
 
  // Verify nonce
  if( !isset( $_POST['tijarah_product_ajax_nonce'] ) || !wp_verify_nonce( $_POST['tijarah_product_ajax_nonce'], 'tijarah_product_ajax_nonce' ) )
    die('Permission denied');
 
  $taxonomy = $_POST['taxonomy'];
 
  // WP Query
  $args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'product_cat' => $taxonomy,
    'posts_per_page' => 9,
    'tax_query'     => array(
      array(
         'taxonomy' =>   'product_visibility',
         'field'    =>   'name',
         'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
         'operator' =>   'NOT IN'
      )
    )
  );
 
  // If taxonomy is not set, remove key from array and get all posts
  if( !$taxonomy ) {
    unset( $args['tag'] );
  }
 
  $query = new WP_Query( $args );
 
  
	if ( $query->have_posts() ): ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <div class="col-lg-4 col-md-6">
        <?php do_action( 'get_tijarah_product_item' ) ?>
      </div>
			<?php endwhile; ?>
  <?php else: ?>
    <h2><?php echo esc_html__('No item found','tijarah'); ?></h2>
  <?php endif;
 
  die();
}
 
add_action('wp_ajax_filter_products', 'tijarah_ajax_filter_get_products');
add_action('wp_ajax_nopriv_filter_products', 'tijarah_ajax_filter_get_products');