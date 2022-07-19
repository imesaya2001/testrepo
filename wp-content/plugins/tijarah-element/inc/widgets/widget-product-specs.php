<?php
/**
 * Adds Product Details Widget.
 * @package tijarah
 */
if( !class_exists('tijarah_Product_Specs') ){
	class tijarah_Product_Specs extends WP_Widget{

		function __construct() {

			$widget_options = array(
				'description' 					=> esc_html__( 'Tijarah Product Specification Here', 'tijarah' ), 
				'customize_selective_refresh' 	=> true,
			);

			parent:: __construct('tijarah_Product_Specs', esc_html__( 'Tijarah : Product Specification', 'tijarah' ), $widget_options );
		}

		public function widget($args, $instance){

			if ( ! isset( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->id;

		}
		
		$tijarah_features_group = get_post_meta( get_the_ID(), 'tijarah_features_group', true );

		$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : 'Specification';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$update_checkbox = $instance[ 'update_checkbox' ] ? 'true' : 'false';
		$relased_checkbox = $instance[ 'relased_checkbox' ] ? 'true' : 'false';

			echo $args['before_widget']; 
			if ( $title ): 
		    echo $args['before_title'];  
			echo esc_attr( $title );  
		 	echo $args['after_title']; 
			endif; ?>
			<div class="widget-product-details">
				<table>
                    <tbody>
					<?php if ( 'true' == $update_checkbox ): ?>
						<tr>
	                      <th><?php echo esc_html__( 'Last Update:','tijarah' ); ?></th>
	                      <td><span><?php the_modified_date(); ?></span></td>
	                    </tr>
					<?php endif ?>
					<?php if ( 'true' == $relased_checkbox ): ?>
						<tr>
	                      <th><?php echo esc_html__( 'Relased:','tijarah' ); ?></th>
	                      <td><span><?php echo get_the_date(); ?></span></td>
	                    </tr>
					<?php endif ?>

					<?php
						$product = wc_get_product( get_the_ID() );
						$attributes = $product->get_attributes();

						foreach ( $attributes as $attribute ) {

						$taxonomy_terms = get_the_terms( get_the_ID(), $attribute['name']); ?>

						<tr>
							<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
							<td>
								<span>
									<?php 
									foreach ($taxonomy_terms as $attribute_values){ ?>
										<a href="<?php echo esc_url( get_term_link( $attribute_values->term_id ) ) ?>"><?php echo esc_html( $attribute_values->name ); ?></a>
									<?php 
									} ?>
								</span>
							</td>
						</tr>

						<?php }

						$product_tags = get_the_terms( get_the_ID(), 'product_tag' );
						
						if ( $product_tags ): ?>
						<tr>
							<th><?php echo esc_html__( 'Tags:','tijarah' ); ?></th>
							<td>
								<span>
								<?php 
								if ( $product_tags ) {
									foreach ( $product_tags as $key => $product_tag ) { ?>
										<a href="<?php echo esc_url( get_tag_link( $product_tag->term_id ) ) ?>"><?php echo esc_html( $product_tag->name ) ?></a> ,
									<?php }
								} else {
									echo esc_html__( 'No Tags Found!', 'tijarah' );
								} ?>
								</span>
							</td>
	                    </tr>
						<?php endif ?>

					</tbody>
				</table>
			</div>

			<?php
			echo $args['after_widget']; 

			
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance[ 'update_checkbox' ] = $new_instance[ 'update_checkbox' ];
			$instance[ 'relased_checkbox' ] = $new_instance[ 'relased_checkbox' ];
			return $instance;
		}

		public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : ''; ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:','tijarah' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'update_checkbox' ); ?>"><?php echo esc_html__( 'Update Date:','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'update_checkbox' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'update_checkbox' ); ?>" name="<?php echo $this->get_field_name( 'update_checkbox' ); ?>" />		    
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'relased_checkbox' ); ?>"><?php echo esc_html__( 'Relased Date:','tijarah' ); ?></label>
		    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'relased_checkbox' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'relased_checkbox' ); ?>" name="<?php echo $this->get_field_name( 'relased_checkbox' ); ?>" />		    
		</p>
		<hr>
		<p><?php echo esc_html__( 'All other specification will come from feature fields of the product single page', 'tijarah' ) ?></p>

	<?php
		}
	}
}

// register Contact  Widget widget
function tijarah_Product_Specs(){
	register_widget('tijarah_Product_Specs');
}
add_action('widgets_init','tijarah_Product_Specs');
