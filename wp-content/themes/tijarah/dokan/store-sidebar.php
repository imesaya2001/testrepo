<?php if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_appearance', 'off' ) === 'off' ): ?>
    <div id="dokan-secondary" class="dokan-clearfix dokan-store-sidebar" role="complementary" style="margin-right:3%;">
        <div class="dokan-widget-area widget-collapse">
            <?php do_action( 'dokan_sidebar_store_before', $store_user->data, $store_info ); ?>
            <?php
            if ( ! dynamic_sidebar( 'sidebar-store' ) ) {
                $args = array(
                    'before_widget' => '<div class="widget %s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h4 class="widget-title">',
                    'after_title'   => '</h4>',
                );

                if ( dokan()->widgets->is_exists( 'store_category_menu' ) ) {
                    the_widget( dokan()->widgets->store_category_menu, array( 'title' => __( 'Store Product Category', 'tijarah' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && ! empty( $map_location ) ) {
                    the_widget( dokan()->widgets->store_location, array( 'title' => __( 'Store Location', 'tijarah' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_open_close' ) && dokan_get_option( 'store_open_close', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_open_close, array( 'title' => __( 'Store Time', 'tijarah' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_contact_form' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_contact_form, array( 'title' => __( 'Contact Vendor', 'tijarah' ) ), $args );
                }
            }
            ?>

            <?php do_action( 'dokan_sidebar_store_after', $store_user->data, $store_info ); ?>
        </div>
    </div><!-- #secondary .widget-area -->
<?php else: ?>
    <?php get_sidebar( 'store' ); ?>
<?php endif; ?>
