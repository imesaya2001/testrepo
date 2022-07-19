<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tijarah
 */


global $tijarah_opt; 

$site_preloader = !empty( $tijarah_opt['site_preloader'] ) ? $tijarah_opt['site_preloader'] : '';
$tijarah_header_sticky = !empty( $tijarah_opt['tijarah_header_sticky'] ) ? $tijarah_opt['tijarah_header_sticky'] : '';
$tijarah_header_full_width = !empty( $tijarah_opt['tijarah_header_full_width'] ) ? $tijarah_opt['tijarah_header_full_width'] : '';
$navbar_button = !empty( $tijarah_opt['navbar_button'] ) ? $tijarah_opt['navbar_button'] : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:image" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ) ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
     <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1311965788570608"
     crossorigin="anonymous"></script>
</head>

<body <?php body_class(); ?>>
	 <?php wp_body_open(); ?>
	
	<?php if ($site_preloader): ?>
		<!-- Preloading -->
		<div id="preloader">
		    <div class="spinner">
		        <div class="uil-ripple-css" style="transform:scale(0.29);">
		            <div></div>
		            <div></div>
		        </div>
		    </div>
		</div>
	<?php endif ?>
	
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'tijarah' ); ?></a>
	<header class="site-header <?php if( true == $tijarah_header_sticky ){ echo'sticky-header'; } ?>">
		<div class="container<?php if( true == $tijarah_header_full_width ){ echo'-fluid'; } ?>">
	        <div class="row align-items-center">
	            <div class="col-xl-2 col-md-3">
	                <div class="logo">
	                    <?php if (has_custom_logo()) {
	                        the_custom_logo();
	                    } else { ?>
	                        <a class="navbar-logo-text" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
	                    <?php } ?>
	                </div>
	            </div>
	            <div class="col-xl-<?php if ( class_exists( 'WooCommerce' ) & true == $navbar_button ) { echo'8'; }else{ echo'10'; }?> col-md-9">
	                <div class="primary-menu d-none d-lg-inline-block float-right">
	                    <nav class="desktop-menu">
	                        <?php
	                            wp_nav_menu( array(
	                            'theme_location'    => 'primary',
	                            'depth'             => 2,
	                            'container'         => 'ul',
	                        ) ); ?>
	                    </nav>	                    
	                </div>
	            </div>
	            <?php 
                if ( class_exists( 'WooCommerce' ) & true == $navbar_button ) { ?>
            	<div class="col-xl-2 p-0 text-right">
					<div class="header-btn d-none d-xl-block">
						<a class="my-account-btn" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
							<?php 
							if ( is_user_logged_in() ) { 
								$current_user = wp_get_current_user();
							    if ( ($current_user instanceof WP_User) ) { 
							    	echo get_avatar( $current_user->ID, 32 ); 
							    }
							} else {?>
								<img src="<?php echo get_template_directory_uri() ?>/assets/images/user.png" alt="<?php the_title_attribute() ?>">
							<?php } ?>
							<?php echo esc_html__( 'My Account', 'tijarah' ) ?>
						</a>
						<?php
						if ( is_user_logged_in() ) { ?>
							<ul class="sub-menu list-unstyled">
								<?php 
								foreach ( wc_get_account_menu_items() as $endpoint => $label ) { ?>
									<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
										<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
            	</div>
	            <?php } ?>
	        </div>
	    </div>
	</header><!-- #masthead -->
	<!--Mobile Navigation Toggler-->
	<div class="off-canvas-menu-bar">
		<div class="container">
			<div class="row">
				<div class="col-8 my-auto">
				<?php if (has_custom_logo()) {
	                the_custom_logo();
	            } else { ?>
	                <a class="navbar-logo-text" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
	            <?php } ?>
				</div>
				<div class="col-2 my-auto">
				<?php 
                if ( class_exists( 'WooCommerce' ) & true == $navbar_button ) { ?>
                	<div class="header-btn float-right">
						<a class="my-account-btn" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
							<?php 
							if ( is_user_logged_in() ) { 
								$current_user = wp_get_current_user();
							    if ( ($current_user instanceof WP_User) ) { 
							    	echo get_avatar( $current_user->ID, 32 ); 
							    }
							} else {?>
								<img src="<?php echo get_template_directory_uri() ?>/assets/images/user.png" alt="<?php the_title_attribute() ?>">
							<?php } ?>
						</a>
						<?php
						if ( is_user_logged_in() ) { ?>
							<ul class="sub-menu list-unstyled">
								<?php 
								foreach ( wc_get_account_menu_items() as $endpoint => $label ) { ?>
									<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
										<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
	            <?php } ?>
				</div>
				<div class="col-2 my-auto">
					<div class="mobile-nav-toggler"><span class="fas fa-bars"></span></div>
				</div>
			</div>
		</div>
	</div>
    <!-- Mobile Menu  -->
    <div class="off-canvas-menu">
        <div class="menu-backdrop"></div>
        <i class="close-btn fa fa-close"></i>
        <nav class="mobile-nav">
        	<div class="text-center pt-3 pb-3">
            <?php if (has_custom_logo()) {
                the_custom_logo();
            } else { ?>
                <a class="navbar-logo-text" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
            <?php } ?>
            </div>

            <ul class="navigation"><!--Keep This Empty / Menu will come through Javascript--></ul>
        </nav>
    </div>

	<?php if ( !is_page_template( 'custom-homepage.php' ) ) {
		tijarah_breadcrumb_display();
	}  ?>