<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package tijarah
 */
global $tijarah_opt;

$tijarah_error_title = !empty( $tijarah_opt['tijarah_error_title'] ) ? $tijarah_opt['tijarah_error_title'] : __( 'Oops! That page can&rsquo;t be found.', 'tijarah' );
$tijarah_error_text = !empty( $tijarah_opt['tijarah_error_text'] ) ? $tijarah_opt['tijarah_error_text'] : __( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tijarah' );

get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="error-404">
				<h1 class="page-title"><?php echo esc_html( $tijarah_error_title ); ?></h1>
				<p><?php echo esc_html( $tijarah_error_text ); ?></p>
				<a href="<?php echo esc_url( get_home_url() ); ?>" class="btn"><?php echo esc_html__( 'Go to Home', 'tijarah' ); ?></a>
			</div>
		</div>
	</div>
</div>

<?php get_footer();