<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<section class="section-padding">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-xl-8 col-md-7">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php 
					
					if (function_exists('setPostViews')) {
	                    setPostViews(get_the_id());
	                }

					wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>
			<div class="col-xl-4 col-md-5">

				<?php
				if (is_woocommerce() & is_active_sidebar( 'woocommerce_product_sidebar' ) ) {
					dynamic_sidebar( 'woocommerce_product_sidebar' );
				} else {
					get_template_part( 'inc/product','sidebar' );
				} ?>
			</div>		
		</div>

		<?php woocommerce_output_related_products() ?>
		
	</div>
</section>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
