<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<li>

	<div id="comment-<?php comment_ID(); ?>" class="item-single-comment">
		<div class="item-comment-avatar">
            <?php echo get_avatar( $comment, 90, '', 'Author’s gravatar' ); ?>
        </div>
        <div class="item-comment-content">
            <h5><?php comment_author(); ?></h5>
            <div class="review-content-star">
            	<?php do_action( 'woocommerce_review_before_comment_meta', $comment ); ?>
            </div>
            <small><?php echo esc_html( human_time_diff( strtotime( $comment->comment_date ), current_time( 'timestamp', 1 ) )) . esc_html__( ' ago', 'tijarah' ); ?></small>
            <?php do_action( 'woocommerce_review_comment_text', $comment ); ?>
        </div>
    </div>