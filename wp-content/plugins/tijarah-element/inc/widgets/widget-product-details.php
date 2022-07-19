<?php
/**
 * Adds Product Details Widget.
 * @package tijarah
 */



if( !class_exists('tijarah_Product_Details') ){
	class tijarah_Product_Details extends WP_Widget{

		function __construct() {

			$widget_options = array(
				'description' 					=> esc_html__( 'Tijarah Product Details Here', 'tijarah' ), 
				'customize_selective_refresh' 	=> true,
			);

			parent:: __construct('tijarah_Product_Details', esc_html__( 'Tijarah : Product Details', 'tijarah' ), $widget_options );
		}

		public function widget($args, $instance){

			if ( ! isset( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->id;

		}
		
		$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$price_checkbox = $instance[ 'price_checkbox' ] ? 'true' : 'false';
		$product_thumbnail_checkbox = $instance[ 'product_thumbnail_checkbox' ] ? 'true' : 'false';
		$rating_checkbox = $instance[ 'rating_checkbox' ] ? 'true' : 'false';		
		$total_sales = $instance[ 'total_sales' ] ? 'true' : 'false';
		$total_views = $instance[ 'total_views' ] ? 'true' : 'false';
		$unique_features = get_post_meta( get_the_ID(), 'unique_features', 1 );

		// WooCommerce
		$product = wc_get_product( get_the_ID() );
		$rating_count = $product->get_rating_count();
		$average = $product->get_average_rating();


			echo $args['before_widget']; 
			if ( $title ): 
		    echo $args['before_title'];  
			echo esc_attr( $title );  
		 	echo $args['after_title']; 
			endif; ?>
			<div class="widget-product-details">
				<?php if ( 'true' == $price_checkbox ): ?>
					<div class="widget-price">
					<?php woocommerce_template_single_price(); ?>
				</div>
				<?php endif ?>				
				<?php if ( 'true' == $product_thumbnail_checkbox ): ?>
					<?php tijarah_thumbnail_product_item() ?>
				<?php endif ?>
				<?php if ( 'true' == $rating_checkbox ): ?>
				<div class="widget-rating">
					<?php echo wc_get_rating_html( $average, $rating_count ); ?>
				</div>
				<?php endif ?>
				<?php if ($unique_features): ?>
		            <ul class="text-left list-unstyled mb-4">
		                <?php foreach ($unique_features as $key => $unique_feature): ?>
		                    <li><i class="fa fa-check-circle text-success fa-fw"></i> <?php echo esc_html( $unique_feature ) ?></li>
		                <?php endforeach ?>            
		            </ul>
		        <?php endif ?>

				<?php

				global $tijarah_opt;

				$supported_currency = !empty( $tijarah_opt['supported_currency'] ) ? $tijarah_opt['supported_currency'] : '';

				if ( $supported_currency[0] == !'' ) { ?>
				
				<ul class="list-inline text-center mt-3">
					<?php foreach ($supported_currency as $key => $currency) {?>
	                <li class="list-inline-item">
	                	<a href="<?php echo esc_url( $currency['url'] ) ?>">
	            			<img src="<?php echo esc_url( $currency['image'] ) ?>" alt="<?php echo esc_attr( $currency['title'] ) ?>">
	            		</a>
	            	</li>
	                <?php } ?>
	            </ul>

				<?php } ?>


		        <?php if ( 'true' == $total_sales || 'true' == $rating_checkbox || 'true' == $total_views ){ ?>
					<ul class="list-inline text-left product-sidebar-stats">
						<?php if ( 'true' == $total_sales ){ ?>
							<li>
								<i class="fa fa-shopping-cart"></i>
								<span><?php echo get_post_meta( get_the_ID(), 'total_sales', true ); ?> <?php echo esc_html__( 'Sales', 'tijarah' ) ?></span>
							</li>						
						<?php } ?>
						<?php if ( 'true' == $rating_checkbox ){ ?>
							<li>
								<i class="fa fa-star"></i>
		                        <span><?php echo esc_html( $rating_count ); ?> <?php echo esc_html__( 'Ratings', 'tijarah' ) ?></span>
							</li>
						<?php } ?>
						<?php if ( 'true' == $total_views ){ ?>
							<li>
								<i class="fa fa-eye"></i>
		                        <span><?php echo getPostViews(get_the_id()); ?> <?php echo esc_html__( 'Views', 'tijarah' ) ?></span>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>

				<div class="widget-add-to-cart">
					<?php woocommerce_template_single_add_to_cart(); ?>				
				</div>             

			</div>

			<?php
			echo $args['after_widget']; 

			
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance[ 'price_checkbox' ] = $new_instance[ 'price_checkbox' ];			
			$instance[ 'product_thumbnail_checkbox' ] = $new_instance[ 'product_thumbnail_checkbox' ];
			$instance[ 'rating_checkbox' ] = $new_instance[ 'rating_checkbox' ];
			$instance[ 'total_sales' ] = $new_instance[ 'total_sales' ];
			$instance[ 'total_views' ] = $new_instance[ 'total_views' ];
			return $instance;
		}

		public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : ''; ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:','tijarah' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'price_checkbox' ); ?>"><?php echo esc_html__( 'Price:','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'price_checkbox' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'price_checkbox' ); ?>" name="<?php echo $this->get_field_name( 'price_checkbox' ); ?>" />		    
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'product_thumbnail_checkbox' ); ?>"><?php echo esc_html__( 'Product Thumbnail :','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'product_thumbnail_checkbox' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'product_thumbnail_checkbox' ); ?>" name="<?php echo $this->get_field_name( 'product_thumbnail_checkbox' ); ?>" />		    
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'rating_checkbox' ); ?>"><?php echo esc_html__( 'Rating Stars:','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'rating_checkbox' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'rating_checkbox' ); ?>" name="<?php echo $this->get_field_name( 'rating_checkbox' ); ?>" />		    
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'total_sales' ); ?>"><?php echo esc_html__( 'Total Sales','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'total_sales' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'total_sales' ); ?>" name="<?php echo $this->get_field_name( 'total_sales' ); ?>" />		    
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'total_views' ); ?>"><?php echo esc_html__( 'Total Views:','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'total_views' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'total_views' ); ?>" name="<?php echo $this->get_field_name( 'total_views' ); ?>" />		    
		</p>

	<?php
		}
	}
}

// register Contact  Widget widget
function tijarah_Product_Details(){
	register_widget('tijarah_Product_Details');
}
add_action('widgets_init','tijarah_Product_Details');
