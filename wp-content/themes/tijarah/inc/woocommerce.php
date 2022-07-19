<?php


/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package tijarah
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function tijarah_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'tijarah_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function tijarah_woocommerce_scripts() {
	wp_enqueue_style( 'tijarah-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css' );
	
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'tijarah-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'tijarah_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function tijarah_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'tijarah_woocommerce_active_body_class' );

// Products per page.
function tijarah_woocommerce_products_per_page() {
	global $tijarah_opt; 
	$products_per_page = !empty( $tijarah_opt['products_per_page'] ) ? $tijarah_opt['products_per_page'] : '';
	return $products_per_page;
}
add_filter( 'loop_shop_per_page', 'tijarah_woocommerce_products_per_page' );

// Product gallery thumnbail columns.
function tijarah_woocommerce_thumbnail_columns() {
	global $tijarah_opt; 
	$products_per_page = !empty( $tijarah_opt['products_per_page'] ) ? $tijarah_opt['products_per_page'] : '';
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'tijarah_woocommerce_thumbnail_columns' );


// Default loop columns on product archives.
function tijarah_woocommerce_loop_columns() {
	global $tijarah_opt; 
	$shop_columns = !empty( $tijarah_opt['shop_columns'] ) ? $tijarah_opt['shop_columns'] : '4';
	return $shop_columns;
}
add_filter( 'loop_shop_columns', 'tijarah_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function tijarah_woocommerce_related_products_args( $args ) {
	global $tijarah_opt; 
	$related_products_per_page = !empty( $tijarah_opt['related_products_per_page'] ) ? $tijarah_opt['related_products_per_page'] : '3';
	$related_products_columns = !empty( $tijarah_opt['related_products_columns'] ) ? $tijarah_opt['related_products_columns'] : '4';
	$defaults = array(
		'posts_per_page' => $related_products_per_page,
		'columns'        => $related_products_columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'tijarah_woocommerce_related_products_args' );


/**
 * Removes coupon form, order notes, and several billing fields if the checkout doesn't require payment.
 *
 * REQUIRES PHP 5.3+
 *
 * Tutorial: http://skyver.ge/c
 */
function tijarah_free_checkout_fields() {
	// first, bail if WC isn't active since we're hooked into a general WP hook
	if ( ! function_exists( 'WC' ) ) {
		return;	
	}
	// bail if the cart needs payment, we don't want to do anything
	if ( WC()->cart && WC()->cart->needs_payment() ) {
		return;
	}
	// now continue only if we're at checkout
	// is_checkout() was broken as of WC 3.2 in ajax context, double-check for is_ajax
	// I would check WOOCOMMERCE_CHECKOUT but testing shows it's not set reliably
	if ( function_exists( 'is_checkout' ) && ( is_checkout() || is_ajax() ) ) {
		// remove coupon forms since why would you want a coupon for a free cart??
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		// Remove the "Additional Info" order notes
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
		// Unset the fields we don't want in a free checkout
		add_filter( 'woocommerce_checkout_fields', function( $fields ) {
			// add or remove billing fields you do not want
			// fields: http://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/#section-2
			$billing_keys = array(
				'billing_company',
				'billing_phone',
				'billing_address_1',
				'billing_address_2',
				'billing_city',
				'billing_postcode',
				'billing_country',
				'billing_state',
			);
			// unset each of those unwanted fields
			foreach( $billing_keys as $key ) {
				unset( $fields['billing'][ $key ] );
			}
			return $fields;
		} );
	}
}
add_action( 'wp', 'tijarah_free_checkout_fields' );

/**
* @snippet       Display &quot;FREE&quot; if WooCommerce Product Price is Zero or Empty - WooCommerce
* @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
* @sourcecode    https://businessbloomer.com/?p=73147
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.5.3
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/
 
  
function tijarah_price_free_zero_empty( $price, $product ){
 
if ( '' === $product->get_price() || 0 == $product->get_price() ) {
    $price = '<span class="woocommerce-Price-amount amount">'.esc_html__( 'Free', 'tijarah' ).'</span>';
}
	return $price;
}
add_filter( 'woocommerce_get_price_html', 'tijarah_price_free_zero_empty', 100, 2 );


/**
 * Remove "Description" Title @ WooCommerce Single Product Tabs
 */
 
add_filter( 'woocommerce_product_description_heading', '__return_null' );
add_filter( 'woocommerce_product_reviews_heading', '__return_null' );


/**
 * Add a faq product tab
 */
function add_faq_product_tab( $tabs ) {
	
  // Adds the new tab
  if (get_post_meta( get_the_ID(), 'faq_group', true )) {
	  $tabs['faq_tab'] = array(
	    'title'   => esc_html__( 'FAQ', 'tijarah' ),
	    'priority'  => 50,
	    'callback'  => 'add_faq_product_tab_content'
	  );
  }

  return $tabs;

}

add_filter( 'woocommerce_product_tabs', 'add_faq_product_tab' );


// FAQ callback function
function add_faq_product_tab_content() { ?>

	<div class="faq-wrapper s-faq-wrapper">

		<?php 
		$randID = wp_rand(); ?>
		<div id="accordion<?php echo esc_attr( $randID ) ?>" class="tijarah-accordion">
		<?php

		$entries = get_post_meta( get_the_ID(), 'faq_group', true );

		if ( $entries ) {
		  foreach (  $entries as $key => $entry ) { ?>
		  <div class="tijarah-accordion-item">
		    <h5 data-toggle="collapse" data-target="#collapse-<?php echo esc_attr( $key.$randID ) ?>" aria-expanded="false" aria-controls="collapse-<?php echo esc_attr( $key.$randID ) ?>">
		        <?php echo esc_html( $entry['faq_title'] ); ?>
		        <span class="fa fa-plus"></span>
		        <span class="fa fa-minus"></span>
		    </h5>

		    <div id="collapse-<?php echo esc_attr( $key.$randID ) ?>" class="collapse" data-parent="#accordion<?php echo esc_attr( $randID ) ?>">
		      <?php echo wp_kses( $entry['faq_description'] , tijarah_allowed_html() ); ?>
		    </div>
		  </div>
		  <?php } 
		} ?>
		</div>

	</div>

  <?php
}



// Product Item
function tijarah_product_item() { 

global $tijarah_opt;
$tijarah_product_hover_button = !empty($tijarah_opt['tijarah_product_hover_button']) ? $tijarah_opt['tijarah_product_hover_button'] : '';
?>
  <div class="download-item">
    <div class="download-item-image">
      <a href="<?php the_permalink(); ?>">
        <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail'); ?>
      </a>
      <?php woocommerce_show_product_loop_sale_flash() ?>
    </div>
    <div class="download-item-content">
      <a href="<?php the_permalink(); ?>">
         <?php the_title( '<h5>', '</h5>' ) ?>
      </a>
      <p><?php echo get_post_meta( get_the_ID(), 'subheading', true ) ?></p>

      <ul class="list-inline mb-0">
         <li class="list-inline-item">
            <?php woocommerce_template_single_price(); ?>
         </li>
         <li class="list-inline-item float-right"><?php woocommerce_template_loop_rating(); ?></li>
      </ul>
    </div>
    <?php if ( true == $tijarah_product_hover_button ): ?>
      <div class="download-item-overlay">
        <ul class="text-center mb-0 pl-0">
           <?php if (get_post_meta( get_the_ID(), 'preview_url', true )): ?>
           <li>
              <a class="active" target="_blank" href="<?php echo get_post_meta( get_the_ID(), 'preview_url', true ); ?>"><i class="fa fa-eye"></i><?php echo esc_html__( 'Preview' , 'tijarah' ) ?></a>
           </li>
           <?php endif ?>
           <li>
              <a href="<?php the_permalink(); ?>"><i class="fa fa-info-circle"></i><?php echo esc_html__( 'Details' , 'tijarah' ) ?></a>
           </li>                       
           <li>
              <?php woocommerce_template_loop_add_to_cart() ?>
           </li>
        </ul>
      </div>
    <?php endif ?>
  </div>
<?php }

add_action( 'get_tijarah_product_item', 'tijarah_product_item' );

// Thumbnail Product Item
function tijarah_thumbnail_product_item() { 

	global $product;

  	$product_terms = get_the_terms( get_the_ID() , 'product_cat' );
  	$subheading = get_post_meta( get_the_ID(), 'subheading', true );
  	$thumbnail = get_post_meta( get_the_ID(), 'product_item_thumbnail', 1 );

  	if ($product->is_on_sale()) {
  		if( is_rtl() ){
			$price = get_post_meta( get_the_ID(), '_sale_price', true ).get_woocommerce_currency_symbol();
		} else {
			$price = get_woocommerce_currency_symbol().get_post_meta( get_the_ID(), '_sale_price', true );
		}
  	} else {
  		if( is_rtl() ){
  			$price = get_post_meta( get_the_ID(), '_regular_price', true ).get_woocommerce_currency_symbol();
		} else {
			$price = get_woocommerce_currency_symbol().get_post_meta( get_the_ID(), '_regular_price', true );
		}
  	}
  	
  	?>
	
	<a class="site-preview" href="<?php the_permalink(); ?>">
		<img src="<?php if ( $thumbnail ) { echo esc_url( $thumbnail ); } else { the_post_thumbnail_url( 'tijarah-80x80' ); } ?>" alt="<?php the_title() ?><?php if( $subheading ) echo ' - '. esc_attr( $subheading ); ?>" data-preview-url="<?php echo esc_url( the_post_thumbnail_url( 'tijarah-590x300' ) ) ?>" data-item-name="<?php the_title() ?>" data-item-cost="<?php if ( '' === $product->get_price() || 0 == $product->get_price() ){ echo esc_attr__( 'Free', 'tijarah' ); } else { if( !$product->is_type( 'variable' )){ echo esc_attr( $price ); } } ?>" data-item-category="<?php foreach ($product_terms as $portfolio_term) { echo esc_attr( $portfolio_term->name ); } ?>" data-item-author="<?php echo get_the_author() ?>" data-title="<?php the_title() ?>">
	</a>

<?php }

// Add AJAX Shortcode when cart contents update
function tijarah_cart_button_count( $fragments ) {
 
    ob_start();
    
    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();

    ?>
    <a class="cart-contents menu-item" href="<?php echo esc_url( $cart_url ); ?>" title="<?php echo esc_attr__( 'View your shopping cart','tijarah' ); ?>">
        <span class="cart-contents-count"><i class="fa fa-shopping-cart"></i> 
        	<?php echo sprintf(
			/* translators: number of items in the mini cart. */
			_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'tijarah' ), $cart_count ); ?>
		</span>
	</a>
    <?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'tijarah_cart_button_count' );

 // Add Extra Menu Item to Primary Menu
function tijarah_add_extra_button_to_menu ( $items, $args ) {

	if ( class_exists( 'WooCommerce' ) & function_exists('tijarah_cart_button_shortcode') ) {
       $items .=  do_shortcode( '[mini_cart_button]');
   	}    

    return $items;
}
add_filter( 'wp_nav_menu_primary_items', 'tijarah_add_extra_button_to_menu', 10, 2 );


// Pricing to woocommerce product
if (class_exists( 'WooCommerce' )) {
	
	class Tijarah_Pricing_Product_Data_Store_CPT extends WC_Product_Data_Store_CPT {

	    /**
	     * Method to read a product from the database.
	     * @param WC_Product
	     */

	    public function read( &$product ) {

	        $product->set_defaults();

	        if ( ! $product->get_id() || ! ( $post_object = get_post( $product->get_id() ) ) || ! in_array( $post_object->post_type, array( 'pricing', 'product' ) ) ) { // change with your post type
	            throw new Exception( __( 'Invalid product.', 'tijarah' ) );
	        }

	        $id = $product->get_id();

	        $product->set_props( array(
	            'name'              => $post_object->post_title,
	            'slug'              => $post_object->post_name,
	            'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
	            'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
	            'status'            => $post_object->post_status,
	            'description'       => $post_object->post_content,
	            'short_description' => $post_object->post_excerpt,
	            'parent_id'         => $post_object->post_parent,
	            'menu_order'        => $post_object->menu_order,
	            'reviews_allowed'   => 'open' === $post_object->comment_status,
	        ) );

	        $this->read_attributes( $product );
	        $this->read_downloads( $product );
	        $this->read_visibility( $product );
	        $this->read_product_data( $product );
	        $this->read_extra_data( $product );
	        $product->set_object_read( true );
	    }

	    /**
	     * Get the product type based on product ID.
	     *
	     * @since 3.0.0
	     * @param int $product_id
	     * @return bool|string
	     */
	    public function get_product_type( $product_id ) {
	        $post_type = get_post_type( $product_id );
	        if ( 'product_variation' === $post_type ) {
	            return 'variation';
	        } elseif ( in_array( $post_type, array( 'pricing', 'product' ) ) ) { // change with your post type
	            $terms = get_the_terms( $product_id, 'product_type' );
	            return ! empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
	        } else {
	            return false;
	        }
	    }
	}

	add_filter( 'woocommerce_data_stores', 'tijarah_woocommerce_data_stores' );

	function tijarah_woocommerce_data_stores ( $stores ) {      
	    $stores['product'] = 'Tijarah_Pricing_Product_Data_Store_CPT';
	    return $stores;
	}
}

// Disable Seller More Products Tab
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_more_seller_product_tab', 98 );
    function wcs_woo_remove_more_seller_product_tab($tabs) {
    unset($tabs['more_seller_product']);
    return $tabs;
}

// WooCommerce Variations as Radio Buttons
function tijarah_variation_radio_buttons($html, $args) {
  	$args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
	    'options'          => false,
	    'attribute'        => false,
	    'product'          => false,
	    'selected'         => false,
	    'name'             => '',
	    'id'               => '',
	    'class'            => '',
	    'show_option_none' => __('Choose an option', 'tijarah'),
	));

	if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
	$selected_key     = 'attribute_'.sanitize_title($args['attribute']);
	$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
	}

	$options               = $args['options'];
	$product               = $args['product'];
	$attribute             = $args['attribute'];
	$name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
	$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
	$class                 = $args['class'];
	$show_option_none      = (bool)$args['show_option_none'];
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'tijarah');

	if(empty($options) && !empty($product) && !empty($attribute)) {
		$attributes = $product->get_variation_attributes();
		$options    = $attributes[$attribute];
	}

	$radios = '<div class="variation-radios">';

	if(!empty($options)) {
		if($product && taxonomy_exists($attribute)) {
		$terms = wc_get_product_terms($product->get_id(), $attribute, array(
			'fields' => 'all',
		));

		foreach($terms as $term) {
			if(in_array($term->slug, $options, true)) {
			  $radios .= '<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" id="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($term->slug).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
			}
		}
		} else {
		foreach($options as $option) {
			$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
			$radios    .= '
			<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.'>
			<label for="'.sanitize_title($option).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $option)).'</label>';
			}
		}
	}

	$radios .= '</div>';

	return $html.$radios;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'tijarah_variation_radio_buttons', 20, 2);