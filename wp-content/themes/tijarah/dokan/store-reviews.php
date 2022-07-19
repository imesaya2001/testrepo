<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

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
                <div id="dokan-primary" class="dokan-single-store">
                    <div id="dokan-content" class="store-review-wrap woocommerce" role="main">

                        <?php dokan_get_template_part( 'store-header' ); ?>


                        <?php
                        $dokan_template_reviews = dokan_pro()->review;
                        $id                     = $store_user->ID;
                        $post_type              = 'product';
                        $limit                  = 20;
                        $status                 = '1';
                        $comments               = $dokan_template_reviews->comment_query( $id, $post_type, $limit, $status );
                        ?>

                        <div id="reviews">
                            <div id="comments">

                              <?php do_action( 'dokan_review_tab_before_comments' ); ?>

                                <h2 class="headline"><?php _e( 'Vendor Review', 'tijarah' ); ?></h2>

                                <ol class="commentlist">
                                    <?php echo wp_kses( $dokan_template_reviews->render_store_tab_comment_list( $comments , $store_user->ID) , tijarah_allowed_html() ); ?>
                                </ol>

                            </div>
                        </div>

                        <?php echo wp_kses( $dokan_template_reviews->review_pagination( $id, $post_type, $limit, $status ) , tijarah_allowed_html() ); ?>
                        
                    </div><!-- #content .site-content -->
                </div><!-- #primary .content-area -->
            </div>
        </div>
    </div>
</section>


<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
