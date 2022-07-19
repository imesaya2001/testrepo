<?php
/**
 * tijarah functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tijarah
 */


if ( ! function_exists( 'tijarah_setup' ) ) :

	function tijarah_setup() {

		load_theme_textdomain( 'tijarah', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'tijarah' ),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-background', apply_filters( 'tijarah_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		add_image_size( 'tijarah-1280x720', 1280,720,true );
		add_image_size( 'tijarah-1280x650', 1280,650, array( 'center', 'top' ));
		add_image_size( 'tijarah-500x286', 500,286,true );
		add_image_size( 'tijarah-115x115', 115,115,true );
		add_image_size( 'tijarah-590x300', 590,300,true );		
		add_image_size( 'tijarah-360-260', 360,260,true );
		add_image_size( 'tijarah-350x200', 350,200,true );
		add_image_size( 'tijarah-100x80', 100,80,true );
		add_image_size( 'tijarah-80x80', 80,80,true );
		add_image_size( 'tijarah-32x32', 32,32,true );
		add_image_size( 'tijarah-300x150', 300,150,true );

	}

endif;
add_action( 'after_setup_theme', 'tijarah_setup' );

function tijarah_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tijarah_content_width', 640 );
}
add_action( 'after_setup_theme', 'tijarah_content_width', 0 );

function tijarah_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tijarah' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Store Sidebar', 'tijarah' ),
		'id'            => 'woocommerce_store_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Product Sidebar', 'tijarah' ),
		'id'            => 'woocommerce_product_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="widget-woocommerce %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-woocommerce-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'tijarah' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add footer widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'tijarah' ),
		'id'            => 'footer2',
		'description'   => esc_html__( 'Add footer widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'tijarah' ),
		'id'            => 'footer3',
		'description'   => esc_html__( 'Add footer widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'tijarah' ),
		'id'            => 'footer4',
		'description'   => esc_html__( 'Add footer widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 5', 'tijarah' ),
		'id'            => 'footer5',
		'description'   => esc_html__( 'Add footer widgets here.', 'tijarah' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'tijarah_widgets_init' );


// Register Fonts
function tijarah_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'tijarah' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Rubik:300,400,500,700,900&display=swap' ), "//fonts.googleapis.com/css" );
    }

    return $font_url;
}

// 
function tijarah_scripts() {
	// CSS
	wp_enqueue_style( 'tijarah-fonts', tijarah_fonts_url());
	wp_enqueue_style( 'tijarah-plugin',get_template_directory_uri() . '/assets/css/plugin.css');
	wp_enqueue_style( 'tijarah-style', get_stylesheet_uri() );


	// JS
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );	
	wp_enqueue_script( 'nice-select', get_template_directory_uri() . '/assets/js/jquery.nice-select.min.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'plyr', get_template_directory_uri() . '/assets/js/plyr.min.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'tijarah-audio-player', get_template_directory_uri() . '/assets/js/audio-player.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
  	wp_enqueue_script( 'tijarah-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), wp_get_theme()->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'tijarah-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
  
	//'tijarah-style' is main style of the theme
  	wp_add_inline_style( 'tijarah-style', tijarah_inline_style());
}

add_action( 'wp_enqueue_scripts', 'tijarah_scripts' );

// Denqueue elementor animation scripts and styles.
function tijarah_dequeue_script() {
	
	// Dokan Conflict FAQ
	if (class_exists( 'WooCommerce' )) {
	  	if (is_product()) {
	  		wp_dequeue_script( 'dokan-tooltip' );
	  	}
	}
	
    wp_dequeue_style( 'elementor-animations' );
    wp_deregister_style( 'elementor-animations' );
}
add_action( 'wp_enqueue_scripts', 'tijarah_dequeue_script', 20 );

// Includes files
require get_template_directory() . '/inc/inline-script.php';
require get_template_directory() . '/inc/hooks.php';
require get_template_directory() . '/inc/redux-framework.php';
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/breadcrumb.php';
require get_template_directory() . '/inc/customizer.php';
if (empty(get_user_meta( get_current_user_id(), 'licence_activated' , true ))) {
	require get_template_directory() . '/inc/activate-license.php';
}
require get_template_directory() . '/inc/cmb2-conditionals.php';

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// TGM required plugins
function tijarah_register_required_plugins() {

	$plugins = array(

		array(
			'name'        => esc_html__('Redux Framework', 'tijarah'),
			'slug'        => 'redux-framework',
			'required' 	  => true,
		),

		array(
			'name'        =>  esc_html__('Elementor', 'tijarah'),
			'slug'        => 'elementor',
			'
			required'    => true,
		),

		array(
			'name'        => esc_html__('WooCommerce', 'tijarah'),
			'slug'        => 'woocommerce',
			'required' 	  => true,
		),

		array(
			'name'        => esc_html__('Dokan', 'tijarah'),
			'slug'        => 'dokan-lite',
			'required' 	  => true,
		),
		
		array(
			'name'        => esc_html__('Tijarah Element ', 'tijarah').esc_html__('( Licence Key Required )', 'tijarah'),
			'slug'        => 'tijarah-element',
			'source'      => get_template_directory() . '/plugins/tijarah-element.zip',
			'required' 	  => true,
		),

		array(
			'name'        => esc_html__('Contact Form 7', 'tijarah'),
			'slug'        => 'contact-form-7',
			'required' 	  => true,
		),

		array(
			'name'        => esc_html__('CMB2', 'tijarah'),
			'slug'        => 'cmb2',
			'required' 	  => true,
		),

		array(
			'name'        => esc_html__('One Click Demo Import', 'tijarah'),
			'slug'        => 'one-click-demo-import',
			'required' 	  => true,
		)
	);

	$config = array(
		'id'           => 'tijarah',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '', 
		'is_automatic' => false,
		'message'      => '',  
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'tijarah_register_required_plugins' );

// Custom Meta Box
function tijarah_register_download_metafields() {

	if ( class_exists( 'WooCommerce' ) ){
		$currency_symbol = get_woocommerce_currency_symbol();
	} else {
		$currency_symbol = '$';
	}

	$prefix = 'tijarah';

	$product = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Download Options', 'tijarah' ),
		'object_types'  => array( 'product')
	) );

	$product->add_field( array(
		'name'       => esc_html__( 'Product Type', 'tijarah' ),
		'desc'       => esc_html__( 'Select product type', 'tijarah' ),
		'id'         => 'type',
		'type'       => 'select',
		'default'    => 'digital_item',
		'options'    => array(
			'digital_item'    => __( 'Digital Item', 'tijarah' ),
			'video'    => __( 'Video', 'tijarah' ),
			'audio'    => __( 'Audio', 'tijarah' ),
		),
	) );

	$product->add_field( array(
		'name' => esc_html__( 'Video', 'tijarah' ),
		'desc' => esc_html__( 'Upload a video mp4 preview for video product', 'tijarah' ),
		'id'   => 'video',
		'type' => 'file',
		'preview_size' => 'large',
		'attributes' => array(
			'data-conditional-id'     => 'type',
			'data-conditional-value'  => 'video',
		),
	) );

	$product->add_field( array(
		'name' => esc_html__( 'Youtube Video', 'tijarah' ),
		'desc' => esc_html__( 'Set a youtube video url preview', 'tijarah' ),
		'id'   => 'youtube_video',
		'type' => 'file',
		'preview_size' => 'large',
		'attributes' => array(
			'data-conditional-id'     => 'type',
			'data-conditional-value'  => 'video',
		),
	) );

	$product->add_field( array(
		'name' => esc_html__( 'Vimeo Video', 'tijarah' ),
		'desc' => esc_html__( 'Set a vimeo url preview', 'tijarah' ),
		'id'   => 'vimeo_video',
		'type' => 'file',
		'preview_size' => 'large',
		'attributes' => array(
			'data-conditional-id'     => 'type',
			'data-conditional-value'  => 'video',
		),
	) );

	$product->add_field( array(
		'name' => esc_html__( 'Audio', 'tijarah' ),
		'desc' => esc_html__( 'Upload an audio sample mp3 for audio product', 'tijarah' ),
		'id'   => 'audio',
		'type' => 'file',
		'preview_size' => 'large',
		'attributes' => array(
			'required'            => true,
			'data-conditional-id'     => 'type',
			'data-conditional-value'  => 'audio',
		),
	) );

	$product->add_field( array(
		'name'       => __( 'Unique Features', 'tijarah' ),
		'id'         => 'unique_features',
		'type'       => 'text',
		'repeatable' => true,
	) );

	$product->add_field( array(
		'name'       => esc_html__( 'Product Thumbnail', 'tijarah' ),
		'desc'       => esc_html__( 'Product thumbnail to show in different sections ( 80x80 )', 'tijarah' ),
		'id'         => 'product_item_thumbnail',
		'type'       => 'file',
		'preview_size' => array( 80, 80 ),
		'options'    =>array(
	  		'url'     =>false,
	  	)
	) );

	$product->add_field( array(
		'name'       => __( 'Preview Video URL', 'tijarah' ),
		'id'         => 'preview_video_popup',
		'type'       => 'text_url',
	) );

	$product->add_field( array(
		'name'       => esc_html__( 'Preview Url', 'tijarah' ),
		'desc'       => esc_html__( 'Preview Url to show in single download page', 'tijarah' ),
		'id'         => 'preview_url',
		'type'       => 'text'
	) );

	$product->add_field( array(
		'name'       => esc_html__( 'Sub Heading', 'tijarah' ),
		'desc'       => esc_html__( 'Sub Heading for the item', 'tijarah' ),
		'id'         => 'subheading',
		'type'       => 'text',
	) );

	$tijarah_group_feture = $product->add_field( array(
		'id'          => 'faq_group',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'tijarah' ),
		'options'     => array(
			'group_title'       => __( 'FAQ {#}', 'tijarah' ),
			'add_button'        => __( 'Add Another FAQ', 'tijarah' ),
			'remove_button'     => __( 'Remove FAQ', 'tijarah' ),
			'sortable'          => true,
		),
	) );

	$product->add_group_field( $tijarah_group_feture, array(
		'name' => esc_html__( 'Title', 'tijarah' ),
		'id'   => 'faq_title',
		'type' => 'text',
	) );

	$product->add_group_field( $tijarah_group_feture, array(
		'name' => esc_html__( 'Description', 'tijarah' ),
		'id'   => 'faq_description',
		'type' => 'textarea_small',
	) );

	/**
	 * Initiate the metabox
	 */
	$pricing = new_cmb2_box( array(
		'id'            => 'pricing_plan',
		'title'         => __( 'Pricing Plan', 'tijarah' ),
		'object_types'  => array( 'pricing' ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	));

	$pricing->add_field( array(
		'name'    => __( 'FontAwesome Icon', 'tijarah' ),
		'id'      => 'fontawesome_icon',
		'type'    => 'text',
		'default' => 'fab fa-wordpress'
	) );

	$pricing->add_field( array(
		'name'    => 'Gradient color from',
		'id'      => 'gradient_color_from',
		'type'    => 'colorpicker',
		'default' => '#ff416c',
	) );

	$pricing->add_field( array(
		'name'    => 'Gradient color to',
		'id'      => 'gradient_color_to',
		'type'    => 'colorpicker',
		'default' => '#ff4b2b',
	) );

	$pricing->add_field( array(
		'name'    => 'Icon color',
		'id'      => 'icon_color',
		'type'    => 'colorpicker',
		'default' => '#fff',
	) );

	$pricing->add_field( array(
		'name'       => __( 'Feature list', 'tijarah' ),
		'id'         => 'feature_list',
		'type'       => 'text',
		'repeatable' => true,
	));

	$pricing->add_field( array(
		'name'       => __( 'Price', 'tijarah' ),
		'id'         => '_price',
		'type'       => 'text_small',
		'before_field' => $currency_symbol,
		'default' => 70,
	));

	$pricing->add_field( array(
		'name'       => __( 'Button Text', 'tijarah' ),
		'id'         => 'button_text',
		'type'       => 'text',
		'default'	 => __( 'Purchase Now', 'tijarah' )
	));

}

add_action( 'cmb2_admin_init', 'tijarah_register_download_metafields' );


// One click demo import
function tijarah_import_files() {
	return array(
		array(
			'import_file_name'             => __( 'Default Marketplace', 'tijarah' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/default/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/default/widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo/default/customizer.dat',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/redux.json',
					'option_name' => 'tijarah_opt',
				),
			),
			'import_preview_image_url'     => get_template_directory_uri(). '/inc/demo/default/demo.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'tijarah' ),
			'preview_url'                  => 'https://themebing.com/wp/tijarah/',
		),
		array(
			'import_file_name'             => __( 'Stock photography', 'tijarah' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/photography/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/photography/widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo/photography/customizer.dat',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/redux.json',
					'option_name' => 'tijarah_opt',
				),
			),
			'import_preview_image_url'     => get_template_directory_uri(). '/inc/demo/photography/demo.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'tijarah' ),
			'preview_url'                  => 'https://themebing.com/wp/tijarah-images/',
		),
		array(
			'import_file_name'             => __( 'Stock video', 'tijarah' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/video/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/video/widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo/video/customizer.dat',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/redux.json',
					'option_name' => 'tijarah_opt',
				),
			),
			'import_preview_image_url'     => get_template_directory_uri(). '/inc/demo/video/demo.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'tijarah' ),
			'preview_url'                  => 'https://themebing.com/wp/tijarah-videos/',
		),
		array(
			'import_file_name'             => __( 'Stock audio', 'tijarah' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/audio/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/audio/widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo/audio/customizer.dat',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demo/redux.json',
					'option_name' => 'tijarah_opt',
				),
			),
			'import_preview_image_url'     => get_template_directory_uri(). '/inc/demo/audio/demo.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'tijarah' ),
			'preview_url'                  => 'https://themebing.com/wp/tijarah-audio/',
		)
	);
}
//if (!empty(get_user_meta( get_current_user_id(), 'licence_activated' , true ))) {
	add_filter( 'pt-ocdi/import_files', 'tijarah_import_files' );
//}

// Default Home and Blog Setup
function tijarah_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'tijarah_after_import_setup' );

// Related Posts
function tijarah_related_posts(){

    global $tijarah_opt;

    if (!empty($tijarah_opt['related_posts']) && $tijarah_opt['related_posts']!='') {
         $posts_per_page = !empty( $tijarah_opt['posts_per_page'] ) ? $tijarah_opt['posts_per_page'] : '';
         $related_posts_columns = !empty( $tijarah_opt['related_posts_columns'] ) ? $tijarah_opt['related_posts_columns'] : '';
         $related_post_title = !empty( $tijarah_opt['related_post_title'] ) ? $tijarah_opt['related_post_title'] : '';
        
        global $post;

        $related = get_posts( array( 
            'post_type' => 'post', 
    		'post_status' => 'publish',
            'category__in' => wp_get_post_categories($post->ID),
            'posts_per_page' => $posts_per_page,
            'post__not_in' => array($post->ID) 
        ) ); ?>

      <?php if ($related): ?>
        <div class="related-posts">
          <h4><?php echo esc_html( $related_post_title ) ?></h4>
          <div class="row">
              <?php
                  if( $related ) foreach( $related as $post ) { 
                  setup_postdata($post); ?>
                  <div class="col-md-12 col-xl-<?php echo esc_attr( $related_posts_columns ) ?>">
                      <div class="single-related-post">
                      <?php if ( has_post_thumbnail() ) : ?>
                          <a href="<?php the_permalink(); ?>"> 
                              <?php the_post_thumbnail('tijarah-590x300');  ?> 
                          </a>
                      <?php endif; ?>

                          <div class="related-post-title">
                              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                              <span><?php the_time('F j, Y') ?></span>
                          </div>

                      </div>
                  </div>
              <?php } wp_reset_postdata(); ?> 
          </div>
      </div><!-- .related-posts --> 

      <?php endif ?>
    <?php } 
}

// Display Blog breadcrumb
function tijarah_breadcrumb_display(){
	global $tijarah_opt; ?>
	<!-- START BREADCRUMB AREA -->
	<section class="breadcrumb-banner">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="breadcrumb-title">
						<h1>
						<?php
						if(is_home() && is_front_page()){
							$title = !empty($tijarah_opt['blog_breadcrumb_title']) ? $tijarah_opt['blog_breadcrumb_title'] : esc_html__( 'Blog Posts', 'tijarah' );
						}else if(is_home()){
							$title = !empty($tijarah_opt['blog_breadcrumb_title']) ? $tijarah_opt['blog_breadcrumb_title'] : wp_title('', false);
						}else{
							$title = wp_title('', false);
						}
							echo esc_html($title);
						?>
						</h1>
						<div class="breadcrumbs">
							<?php tijarah_breadcrumb(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--END BREADCRUMB AREA-->
<?php }


// Comment List
function tijarah_comment_list($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'article' == $args['style'] ) {
		$tag = 'article';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'comment';
	}
?>

<<?php echo esc_html( $tag ) ?> <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemscope itemtype="http://schema.org/Comment">
	<div class="row">
		<?php
		$avatar = get_avatar( $comment, 90, '', 'Author\'s gravatar' );
		if ($avatar): ?>
			<div class="col-md-2 col-xs-3">
		        <?php echo get_avatar( $comment, 90, '', 'Author\'s gravatar' ); ?>
		    </div>
		<?php endif ?>	    
	    <div class="<?php if( $avatar =='' ){ echo 'col-md-12'; } else { echo'col-md-10 col-xs-9'; } ?>">
	        <div class="commenter">
	            <?php echo get_comment_author_link(); ?>
	            <span><?php comment_date('jS F Y , ').comment_time() ?></span>
	        </div>
	        <?php comment_text() ?>
	        <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>	        
	        <?php if ($comment->comment_approved == '0') : ?>
			<p class="comment-meta-item"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'tijarah' ) ?></p>
			<?php endif; ?>
			<?php edit_comment_link('<p class="comment-meta-item">Edit this comment</p>','',''); ?>
	    </div>
	</div>
<?php }


//Comment Field to Bottom
function tijarah_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'tijarah_comment_field_to_bottom' );

// Archive count on rightside
function tijarah_archive_count_on_rightside($links) {
    $links = str_replace('</a>&nbsp;(', '</a> <span class="float-right">(', $links);
    $links = str_replace(')', ')</span>', $links);
    return $links;
}

add_filter( 'get_archives_link', 'tijarah_archive_count_on_rightside' );

// Category count on rightside
function tijarah_category_count_on_rightside($links) {
  $links = str_replace('</a> (', '</a> <span class="float-right">(', $links);
  $links = str_replace(')', ')</span>', $links);
  return $links;
}
add_filter('wp_list_categories', 'tijarah_category_count_on_rightside');

// Allowed html
function tijarah_allowed_html() {

	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
	);
	
	return $allowed_tags;
}
