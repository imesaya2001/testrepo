<?php

// Enqueue script
function tijarah_plugin_enqueue_script() {

	// CSS
  wp_enqueue_style('tijarah-plugns', plugin_dir_url( __FILE__ ) . '../assets/css/plugins.css');
	wp_enqueue_style('tijarah-plugn', plugin_dir_url( __FILE__ ) . '../assets/css/plugin.css');

	// JS
  wp_enqueue_script( 'tijarah-plugins', plugin_dir_url( __FILE__ ) . '../assets/js/plugins.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'tijarah-plugin', plugin_dir_url( __FILE__ ) . '../assets/js/plugin.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
}
add_action('wp_enqueue_scripts', 'tijarah_plugin_enqueue_script');



// function to display number of posts.
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}
 
// function to count views.
function setPostViews($postID) {
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $key = $user_ip . 'x' . $postID;
    $value = array($user_ip, $postID);
    $visited = get_transient($key);
    if ( false === ( $visited ) ) {
        set_transient( $key, $value, 60*60*12 );
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = esc_html__('Views','tijarah');
    return $defaults;
}

function posts_custom_column_views($column_name, $id){
 if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

// Create Shortcode for WooCommerce Cart Menu Item
function tijarah_cart_button_shortcode() {
  ob_start();
 
  $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
  $cart_url = wc_get_cart_url();  // Set Cart URL

  ?>
  <li class="menu-cart">
    <a class="cart-contents menu-item" href="<?php echo esc_url( $cart_url ); ?>" title="<?php echo esc_attr__( 'View your shopping cart','tijarah' ); ?>">
      <span class="cart-contents-count"><i class="fa fa-shopping-cart"></i> 
        <?php echo sprintf(
        /* translators: number of items in the mini cart. */
        _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'tijarah' ), $cart_count ); ?>
      </span>
    </a>

    <div class="mini-cart">
      <?php

      $instance = array( 'title' => '', );
      the_widget( 'WC_Widget_Cart', $instance ); ?>
    </div>
  </li>
  <?php

  return ob_get_clean();
 
}

add_shortcode ('mini_cart_button', 'tijarah_cart_button_shortcode' );

// Remove the short description field in WooCommerce
function tijarah_remove_short_description() {
 
  remove_meta_box( 'postexcerpt', 'product', 'normal');
 
}
add_action('add_meta_boxes', 'tijarah_remove_short_description', 999);