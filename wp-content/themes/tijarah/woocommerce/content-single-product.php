<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

defined( 'ABSPATH' ) || exit;

global $product;
global $tijarah_opt;

$preview_url = get_post_meta( get_the_ID(), 'preview_url', 1 );
$preview_video_popup = get_post_meta( get_the_ID(), 'preview_video_popup', 1 );
$attachment_ids = $product->get_gallery_image_ids();
$type = get_post_meta( get_the_ID(), 'type', true );
$video = get_post_meta( get_the_ID(), 'video', true );
$youtube_video = get_post_meta( get_the_ID(), 'youtube_video', true );
$vimeo_video = get_post_meta( get_the_ID(), 'vimeo_video', true );
$audio = get_post_meta( get_the_ID(), 'audio', true );
$woocommerce_social_share = !empty( $tijarah_opt['woocommerce_social_share'] ) ? $tijarah_opt['woocommerce_social_share'] : '';

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="woocommerce-product-gallery">
		<?php if ( $type == 'video' ){ 

			if ( $youtube_video ){ ?>

				<div class="plyr__video-embed" id="tijarah-player-product-single">
				    <iframe
				        src="<?php echo esc_url( $youtube_video ) ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
				        allowfullscreen
				        allowtransparency
				        allow="autoplay" width="100%" height="100%"
				    ></iframe>
				</div>

				<a class="tijarah-btn download" href="<?php echo esc_url( $youtube_video ); ?>" download ><?php echo esc_html__( 'Download', 'tijarah' ); ?><i class="fas fa-download mr-0 ml-3"></i></a>

				<?php 
	        	if ( function_exists('tijarah_product_social_share') & true == $woocommerce_social_share ) {
	        		tijarah_product_social_share();
				} ?>


			<?php } elseif ( $vimeo_video ){ ?>

				<div class="plyr__video-embed" id="tijarah-player-product-single">
				    <iframe
				        src="<?php echo esc_url( $vimeo_video ) ?>?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
				        allowfullscreen
				        allowtransparency
				        allow="autoplay"
				    ></iframe>
				</div>

				<a class="tijarah-btn download" href="<?php echo esc_url( $vimeo_video ); ?>" download ><?php echo esc_html__( 'Download', 'tijarah' ); ?><i class="fas fa-download mr-0 ml-3"></i></a>

				<?php 
	        	if ( function_exists('tijarah_product_social_share') & true == $woocommerce_social_share  ) {
	        		tijarah_product_social_share();
				} ?>


			<?php } else { ?>

				<video poster="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'woocommerce_single' )[0]; ?>" id="tijarah-player-product-single" controls>
					<source src="<?php echo esc_url( $video ) ?>" type="video/mp4" />
					<source src="<?php echo esc_url( $video ) ?>" type="video/webm" />
				</video>
				<a class="tijarah-btn download" href="<?php echo esc_url( $video ); ?>" download ><?php echo esc_html__( 'Download', 'tijarah' ); ?><i class="fas fa-download mr-0 ml-3"></i></a>

				<?php 
	        	if ( function_exists('tijarah_product_social_share') & true == $woocommerce_social_share  ) {
	        		tijarah_product_social_share();
				} ?>

			<?php } ?>

        <?php } elseif( $type == 'audio' ) {

        	get_template_part( 'template-parts/product-type/audio', 'item' );

    	} else {

        	echo woocommerce_get_product_thumbnail('woocommerce_single');

        	if ( function_exists('tijarah_product_social_share') & true == $woocommerce_social_share ) {
        		tijarah_product_social_share();
			}
			
        } ?>
	
	</div>
	
	<?php if ( $preview_url == true || $attachment_ids == true || $preview_video_popup == true ){ ?>
		<ul class="list-inline preview-btn text-center">
			<?php if ( $preview_url ): ?>
				<li class="list-inline-item"><a href="<?php echo esc_url( $preview_url ) ?>" target="_blank"><i class="fas fa-desktop"></i><?php echo esc_html__( 'Live Preview', 'tijarah' ) ?></a></li>
			<?php endif ?>
	        <?php if ( $attachment_ids ): ?>
	            <li class="list-inline-item"><a href="#preview-gallery-images" class="preview-image-popup"><i class="far fa-images"></i><?php echo esc_html__( 'Screenshots', 'tijarah' ); ?></a></li>
	        <?php endif ?> 
	        <?php if ( $preview_video_popup ): ?>
	            <li class="list-inline-item"><a class="preview-video-popup" href="<?php echo esc_url( $preview_video_popup ); ?>"><i class="fas fa-video"></i><?php echo esc_html__( 'Video', 'tijarah' ); ?></a></li>
	        <?php endif ?> 
	    </ul>
	<?php } ?>

    <div id="preview-gallery-images" class="d-none">
    <?php
        foreach( $attachment_ids as $attachment_id ) { ?>
            <a href="<?php echo wp_get_attachment_url( $attachment_id ); ?>">a</a>
        <?php }
    ?>
    </div>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>
	
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
