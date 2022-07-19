<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tijarah
 */

global $tijarah_opt;

$footer_widget_display = !empty( $tijarah_opt['footer_widget_display'] ) ? $tijarah_opt['footer_widget_display'] : true;
$tijarah_copyright_info = isset( $tijarah_opt['tijarah_copyright_info'] ) ? $tijarah_opt['tijarah_copyright_info'] : '';
$backtotop = isset( $tijarah_opt['backtotop'] ) ? $tijarah_opt['backtotop'] : true;
?>


	<footer id="colophon" class="site-footer">
		<?php if ( $footer_widget_display == true & is_active_sidebar('footer') || $footer_widget_display == true & is_active_sidebar('footer2')  || $footer_widget_display == true & is_active_sidebar('footer3')  || $footer_widget_display == true & is_active_sidebar('footer4')  || $footer_widget_display == true & is_active_sidebar('footer5' )  ): ?>
		<div class="footer-widgets">
			<div class="container">
				<div class="row justify-content-xl-between">
					<div class="col-lg-4">
						<?php
						if (is_active_sidebar('footer')) {
							dynamic_sidebar('footer');
						} ?>
					</div>
					<div class="col-xl-2 col-lg-4 col-md-3 col-sm-6">
						<?php
						if (is_active_sidebar('footer2')) {
							dynamic_sidebar('footer2');
						} ?>
					</div>
					<div class="col-xl-2 col-lg-4 col-md-3 col-sm-6">
						<?php
						if (is_active_sidebar('footer3')) {
							dynamic_sidebar('footer3');
						} ?>
					</div>
					<div class="col-xl-2 col-lg-4 col-md-3 col-sm-6">
						<?php
						if (is_active_sidebar('footer4')) {
							dynamic_sidebar('footer4');
						} ?>
					</div>
					<div class="col-xl-2 col-lg-4 col-md-3 col-sm-6">
						<?php
						if (is_active_sidebar('footer5')) {
							dynamic_sidebar('footer5');
						} ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif ?>


		<div class="copyright-bar">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-7 text-center">
						<p>
						<?php
			    		if( $tijarah_copyright_info ) {
							echo wp_kses( $tijarah_copyright_info , tijarah_allowed_html() );
						} else {
							echo esc_html__('Copyright', 'tijarah'); ?> &copy; <?php echo esc_html( date("Y") ).' '.esc_html( get_bloginfo('name') ).' '.esc_html__(' All Rights Reserved.', 'tijarah' );
						}
						?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>

<?php if ($backtotop == true) {?>
	<!--======= Back to Top =======-->
	<div id="backtotop"><i class="fa fa-lg fa-arrow-up"></i></div>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
