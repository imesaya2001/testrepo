<?php 

// Register Custom Post Type
function tijarah_pricing_post_type() {

	register_post_type( 'pricing', array(
		'label'                 => __( 'Pricing', 'tijarah' ),
		'description'           => __( 'Pricing Items', 'tijarah' ),
		'labels'                => array(
			'name'                  => _x( 'Pricing Items', 'Post Type General Name', 'tijarah' ),
			'singular_name'         => _x( 'Pricing Item', 'Post Type Singular Name', 'tijarah' ),
			'menu_name'             => __( 'Pricing', 'tijarah' ),
			'name_admin_bar'        => __( 'Pricing Item', 'tijarah' ),
			'add_new'               => __( 'Add New', 'tijarah' ),
    		'add_new_item'          => __( 'Add New Pricing', 'tijarah' ),
		),
		'supports'              => array( 'title' , 'thumbnail' ),
		'taxonomies'            => array( 'digital_categories', 'digital_tags' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-editor-paste-word',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => array(
			'slug'                  => 'pricing',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		),
		'capability_type'       => 'page'
	));

}

add_action( 'init', 'tijarah_pricing_post_type' );