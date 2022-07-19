<?php
/**
 * The Template for displaying Terms and Conditions.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$vendor       = dokan()->vendor->get( get_query_var( 'author' ) );
$vendor_info  = $vendor->get_shop_info();
$map_location = $vendor->get_location();

get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 order-2 order-lg-0">
            <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
            </div>
            <div class="col-lg-8">
                <div id="primary" class="dokan-single-store">
                    <div id="dokan-content" class="site-content store-review-wrap woocommerce" role="main">

                        <?php dokan_get_template_part( 'store-header' ); ?>

                        <div id="store-toc-wrapper">
                            <div id="store-toc">
                                <?php
                                if( ! empty( $vendor->get_store_tnc() ) ):
                                ?>
                                    <h2 class="headline"><?php esc_html_e( 'Terms And Conditions', 'tijarah' ); ?></h2>
                                    <div>
                                        <?php
                                            echo wp_kses_post( nl2br( $vendor->get_store_tnc() ) );
                                        ?>
                                    </div>
                                <?php
                                endif;
                                ?>
                            </div><!-- #store-toc -->
                        </div><!-- #store-toc-wrap -->

                    </div><!-- #content .site-content -->
                </div><!-- #primary .content-area -->
                <div class="dokan-clearfix"></div>
        </div>
    </section>

<?php get_footer(); ?>
