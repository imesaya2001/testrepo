<?php

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    $opt_name = "tijarah_opt";
    $theme = wp_get_theme();

    $args = array(
        'opt_name'             => $opt_name,
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_type'            => 'menu',
        'allow_sub_menu'       => true,
        'menu_title'           => esc_html__( 'Tijarah', 'tijarah' ),
        'page_title'           => esc_html__( 'Tijarah', 'tijarah' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => false,
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-portfolio',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => true,
        'customizer'           => true,
        'page_priority'        => null,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => '',
        'last_tab'             => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => '_options',
        'save_defaults'        => true,
        'default_show'         => false,
        'default_mark'         => '',
        'show_import_export'   => true,
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => true,
        'database'             => '',
        'use_cdn'              => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    Redux::setArgs( $opt_name, $args );


    // General
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'General', 'tijarah' ),
        'id'     => 'general',
        'desc'   => esc_html__( 'General theme options.', 'tijarah' ),
        'icon'   => 'el el-home',
        'fields' => array(
            array(
                'id'       => 'site_preloader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Preloader', 'tijarah' ),
                'default'  => true,
            )
        )
    ));

    // Style
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Style', 'tijarah' ),
        'id'     => 'style',
        'desc'   => esc_html__( 'Header menu options.', 'tijarah' ),
        'icon'   => 'el el-edit',
        'fields' => array(
            array(
                'id'       => 'primary_color',
                'type'     => 'color_gradient',
                'title'    => esc_html__('Primary Color', 'tijarah'), 
                'subtitle' => esc_html__('Pick a color for the theme (default: #ff416c and #ff4b2b).', 'tijarah'),
                'validate' => 'color',
                'default'  => array(
                    'from' => '#ff416c',
                    'to'   => '#ff4b2b',
                ),

            ),  
        )
    ));

    // Typography
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Typography', 'tijarah' ),
        'id'               => 'page_title_typography',  
        'icon'   => 'el el-pencil',
        'fields'           => array(
            array(
                'id'          => 'tijarah_heading_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Heading Typography', 'tijarah' ),
                'subtitle'    => __('H1, H2, H3,H4, H5, H6  Tags', 'tijarah'),
                'google'      => true, 
                'font-backup' => true,
                'output'      => array('h1,h2,h3,h4,h5,h6'),
                'units'       =>'px',
                'default'     => array(
                    'color'       => '#333', 
                    'font-weight'  => '700', 
                    'font-family' => 'Rubik', 
                    'google'      => true,
                ),
            ),
            array(
                'id'          => 'tijarah_typography',
                'type'        => 'typography',
                'title'       => esc_html__( 'Typography', 'tijarah' ),
                'subtitle'    => esc_html__('body, p Tags', 'tijarah'),
                'google'      => true, 
                'font-backup' => true,
                'output'      => array('body,p'),
                'units'       =>'px',
                'default'     => array(
                    'color'       => '#808080', 
                    'font-weight'  => 'normal', 
                    'line-height' => '26px',
                    'font-family' => 'Rubik', 
                    'google'      => true,
                    'font-size'   => '16px',
                ),
            )
        )
    ) );

    // Header
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Header', 'tijarah' ),
        'id'     => 'header',
        'desc'   => esc_html__( 'Header menu options.', 'tijarah' ),
        'icon'   => 'el el-heart-empty',
        'fields' => array(
            array(
                'id'       => 'tijarah_header_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width Header', 'tijarah' ),
                'subtitle' => esc_html__( 'Controls the width of the header area. ', 'tijarah' ),
                'default'  => false,
            ),
            array(
                'id'       => 'navbar',
                'type'     => 'background',
                'output'   => '.site-header',
                'title'    => __('Navbar Background Color', 'tijarah'), 
                'subtitle' => __('Pick a color for background.', 'tijarah'),
                'background-repeat' => false,
                'background-attachment' => false,
                'background-size' => false,
                'background-position' => false,
                'background-image' => false,
                'default'  => array(
                    'background-color' => '#fff',
                )
            ),
            array(
                'id'       => 'navbar_link',
                'type'     => 'color',
                'output'   => '.primary-menu ul.menu>li>a,.primary-menu ul li.menu-item-has-children:after',
                'title'    => __('Navbar Link', 'tijarah'), 
                'subtitle' => __('Pick a color for navbar links.', 'tijarah'),
                'default'  => '#808080',
                'validate' => 'color',
            ),
            array(
                'id'       => 'navbar_active_link',
                'type'     => 'color',
                'output'   => '.primary-menu ul li.current-menu-item>a',
                'title'    => __('Navbar Active Link', 'tijarah'), 
                'subtitle' => __('Pick a color for navbar active link.', 'tijarah'),
                'default'  => '#ff416c',
                'validate' => 'color',
            ),
            array(
                'id'       => 'tijarah_header_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Header', 'tijarah' ),
                'subtitle' => esc_html__( 'Turn on to activate the sticky header.', 'tijarah' ),
                'default'  => false,
            ),
            array(
                'id'       => 'navbar_button',
                'type'     => 'switch',
                'title'    => esc_html__( 'Navbar button', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'       => 'blog_breadcrumb_image',
                'type'     => 'background',
                'output'   => array('.breadcrumb-banner'),
                'title'    => __('Breadcrumb Banner Image', 'tijarah'),
                'desc'     => __('Uploaad an image for breadcrumb banner.', 'tijarah'),
            ),

            array(
                'id'       => 'blog_breadcrumb_title_color',
                'type'     => 'color',
                'output'   => array('.breadcrumb-banner h1','.breadcrumbs ul li'),
                'title'    => esc_html__('Breadcrumb Title Color', 'tijarah'), 
                'subtitle' => esc_html__('Pick a color for breadcrumb title (default: #333).', 'tijarah'),
                'default'  => '#fff',
                'validate' => 'color',
            )
        )
    ) );

    // Blog Page
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Blog', 'tijarah' ),
        'id'    => 'blog',
        'icon'  => 'el el-wordpress',
        'fields'     => array(            
            array(
                'id'       => 'blog_breadcrumb_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Breadcrumb Title', 'tijarah' ),
                'default'  => esc_html__( 'Latest news', 'tijarah' ),
            ),
            
            array(
                'id'               => 'tijarah_excerpt_length',
                'type'             => 'slider',
                'title'            => esc_html__('Excerpt Length', 'tijarah'),
                'subtitle'         => esc_html__('Controls the excerpt length on blog page','tijarah'),
                "default"          => 55,
                "min"              => 10,
                "step"             => 2,
                "max"              => 130,
                'display_value'    => 'text'
            )
            
        )
    ) );

    // Blog Detail
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Blog Detail', 'tijarah' ),
        'id'    => 'blog_detail',
        'icon'  => 'el el-wordpress',
        'subsection' => true,
        'fields'     => array(              
            array(
                'id'       => 'social_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Social Share', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'       => 'tijarah_blog_details_post_navigation',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Navigation (Next/Previous)', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'       => 'related_posts',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Related Post', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'       => 'related_post_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Related Post Title', 'tijarah' ),
                'required' => array( 'related_posts','equals', true ),
                'default'  => esc_html__( 'Related Post', 'tijarah' ),
            ),
            array(
                'id' => 'posts_per_page',
                'type' => 'slider',
                'title' => esc_html__( 'Related Posts', 'tijarah' ),
                'subtitle' => esc_html__( 'Related posts per page', 'tijarah' ),
                'desc' => esc_html__('Number of related posts to display. Min: 1, max: Unlimited, step: 1, default value: 4', 'tijarah'),
                "default" => 3,
                "min" => 1,
                "step" => 1,
                "max" => 10000,
                'required' => array( 'related_posts','equals', true ),
                'display_value' => 'text'
            ),
            array(
                'id'       => 'related_posts_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Posts Column', 'tijarah' ), 
                'subtitle' => esc_html__( 'Number of column', 'tijarah' ),
                'desc'     => esc_html__( 'Specify the number of related posts column.', 'tijarah' ),
                'required' => array( 'related_posts','equals', true ),
                'options'  => array(
                    '12' => esc_html__( 'One Column','tijarah' ), 
                     '6' => esc_html__( 'Two Columns','tijarah' ), 
                     '4' => esc_html__( 'Three Columns','tijarah' ), 
                     '3' => esc_html__( 'Four Columns','tijarah' ), 
                     '2' => esc_html__( 'Six Columns','tijarah' ),
                ),
                'default'  => '4',
            )
        )
    ) );


    // WooCommerce
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'WooCommerce', 'tijarah' ),
        'id'    => 'woocommerce',
        'icon'  => 'el el-shopping-cart',
        'fields'     => array(
            array(
                'id' => 'products_per_page',
                'type' => 'slider',
                'title' => esc_html__( 'Products Per Page', 'tijarah' ),
                'subtitle' => esc_html__( 'Product per page', 'tijarah' ),
                'desc' => esc_html__('Number of products to display. Min: 1, max: Unlimited, step: 1, default value: 4', 'tijarah'),
                "default" => 9,
                "min" => 1,
                "step" => 1,
                "max" => 10000,
                'display_value' => 'text'
            ),
            array(
                'id'       => 'shop_layout',
                'type'     => 'select',
                'title'    => esc_html__( 'Store layout', 'tijarah' ),
                'desc'     => esc_html__( 'Specify the number of related products column.', 'tijarah' ),
                'options'  => array(
                    'full_width' => esc_html__( 'Full width','tijarah' ), 
                    'left_sidebar' => esc_html__( 'Left sidebar','tijarah' ), 
                    'right_sidebar' => esc_html__( 'Right sidebar','tijarah' )
                ),
                'default'  => 'full_width',
            ),
            array(
                'id'       => 'shop_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Products Column', 'tijarah' ), 
                'subtitle' => esc_html__( 'Number of column', 'tijarah' ),
                'desc'     => esc_html__( 'Specify the number of related products column.', 'tijarah' ),
                'required' => array( 'shop_layout','equals', 'full_width' ),
                'options'  => array(
                    '12' => esc_html__( 'One Column','tijarah' ), 
                     '6' => esc_html__( 'Two Columns','tijarah' ), 
                     '4' => esc_html__( 'Three Columns','tijarah' ), 
                     '3' => esc_html__( 'Four Columns','tijarah' ), 
                     '2' => esc_html__( 'Six Columns','tijarah' ),
                ),
                'default'  => '4',
            ),
            array(
                'id'       => 'tijarah_product_hover_button',
                'type'     => 'switch', 
                'title'    => __('Product Hover Button Switch On', 'tijarah'),
                'subtitle' => __('Look, it\'s on!', 'tijarah'),
                'default'  => true,
            ),
        )
    ) );

    // WooCommerce Product
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'WooCommerce Product', 'tijarah' ),
        'id'    => 'woocommerce_product',
        'icon'  => 'el el-shopping-cart',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'          => 'supported_currency',
                'type'        => 'slides',
                'title'       => __('Supported currency', 'tijarah'),
                'subtitle'    => __('Unlimited currency with drag and drop sortings.', 'tijarah')
            ),
            array(
                'id'       => 'woocommerce_social_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Social Share', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'       => 'related_products',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Related Products', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'       => 'related_products_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Related Product Title', 'tijarah' ),
                'required' => array( 'related_products','equals', true ),
                'default'  => esc_html__( 'Related products', 'tijarah' ),
            ),
            array(
                'id' => 'related_products_per_page',
                'type' => 'slider',
                'title' => esc_html__( 'Related Products', 'tijarah' ),
                'subtitle' => esc_html__( 'Related product per page', 'tijarah' ),
                'desc' => esc_html__('Number of related products to display. Min: 1, max: Unlimited, step: 1, default value: 4', 'tijarah'),
                "default" => 3,
                "min" => 1,
                "step" => 1,
                "max" => 100,
                'required' => array( 'related_products','equals', true ),
                'display_value' => 'text'
            ),
            array(
                'id'       => 'related_products_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Products Column', 'tijarah' ), 
                'subtitle' => esc_html__( 'Number of column', 'tijarah' ),
                'desc'     => esc_html__( 'Specify the number of related products column.', 'tijarah' ),
                'required' => array( 'related_products','equals', true ),
                'options'  => array(
                    '12' => esc_html__( 'One Column','tijarah' ), 
                     '6' => esc_html__( 'Two Columns','tijarah' ), 
                     '4' => esc_html__( 'Three Columns','tijarah' ), 
                     '3' => esc_html__( 'Four Columns','tijarah' ), 
                     '2' => esc_html__( 'Six Columns','tijarah' ),
                ),
                'default'  => '4',
            )
        )
    ) );

    // Footer
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Footer', 'tijarah' ),
        'id'     => 'footer',
        'icon'   => 'el el-arrow-down',
        'fields' => array(
            array(
                'id'          => 'footer_widget_display',
                'type'        => 'switch',
                'title'       => esc_html__( 'Footer widget display', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'          => 'backtotop',
                'type'        => 'switch',
                'title'       => esc_html__( 'Back to top', 'tijarah' ),
                'default'  => true,
            ),
            array(
                'id'              => 'tijarah_copyright_info',
                'type'            => 'editor',
                'title'           => esc_html__( 'Copyright text', 'tijarah' ),
                'subtitle'        => esc_html__( 'Enter your company information here. HTML tags allowed: a, br, em, strong', 'tijarah' ),
                'default'         => esc_html__( 'Copyright © 2020 tijarah All Rights Reserved.', 'tijarah' ),
                'args'            => array(
                'wpautop'         => false,
                'teeny'           => true,
                'textarea_rows'   => 5
                )
            )
        )
    ) );

    // 404 
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( '404 Error', 'tijarah' ),
        'id'     => 'error-page',
        'icon'   => 'el el-error-alt',
        'fields' => array(
            array(
                'id'          => 'tijarah_error_title',
                'type'        => 'text',
                'title'       => esc_html__( 'Error title', 'tijarah' ),
                'default'     => esc_html__( 'Oops! That page can’t be found.', 'tijarah' ),
                ),
            array(
                'id'          => 'tijarah_error_text',
                'type'        => 'textarea',
                'title'       => esc_html__('Error message', 'tijarah'),
                'subtitle'    => esc_html__('Enter "not found" error message.', 'tijarah'),
                'default'     => esc_html__('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tijarah'),
                )
            ),
    ) );