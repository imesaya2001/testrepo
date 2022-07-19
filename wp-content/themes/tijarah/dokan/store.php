<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();

get_header( 'shop' );

if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
?>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 order-2 order-lg-0">
            <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
            </div>
            <div class="col-lg-8">
                <div id="dokan-primary" class="dokan-single-store">
                    <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

                        <?php dokan_get_template_part( 'store-header' ); ?>

                        <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

                        <?php if ( have_posts() ) { ?>

                            <div class="seller-items">

                                <?php woocommerce_product_loop_start(); ?>

                                    <?php while ( have_posts() ) : the_post(); ?>
                                        <div class="col-lg-6">
                                            <?php wc_get_template_part( 'content', 'product' ); ?>
                                        </div>
                                    <?php endwhile; // end of the loop. ?>
                                
                                <?php woocommerce_product_loop_end(); ?>

                            </div>

                            <?php 
                            the_posts_pagination( array(
                                'mid_size'  => 2,
                                'prev_text' => esc_html__( '&#10094; Prev', 'tijarah' ),
                                'next_text' => esc_html__( 'Next &#10095;', 'tijarah' ),
                            ) ); ?>

                        <?php } else { ?>

                            <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'tijarah' ); ?></p>

                        <?php } ?>
                    </div>

                </div><!-- .dokan-single-store -->
            </div>
        </div>
        <div class="dokan-clearfix"></div>

    </div>
</section>
<?php get_footer( 'shop' ); ?>
