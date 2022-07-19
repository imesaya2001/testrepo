<?php
// WooCommerce
$product = wc_get_product( get_the_ID() );
$rating_count = $product->get_rating_count();
$average = $product->get_average_rating();

$unique_features = get_post_meta( get_the_ID(), 'unique_features', 1 );
$tijarah_features_group = get_post_meta( get_the_ID(), 'tijarah_features_group', true ); ?>
<div class="widget-woocommerce">
	<div class="widget-product-details">
		<div class="widget-price">
			<?php woocommerce_template_single_price(); ?>
		</div>		
		<?php tijarah_thumbnail_product_item() ?>
		<div class="widget-rating">
			<?php echo wc_get_rating_html( $average, $rating_count ); ?>
		</div>
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

		<ul class="list-inline text-left product-sidebar-stats">
			<li>
				<i class="fa fa-shopping-cart"></i>
				<span><?php echo get_post_meta( get_the_ID(), 'total_sales', true ); ?> <?php echo esc_html__( 'Sales', 'tijarah' ) ?></span>
			</li>
			<li>
				<i class="fa fa-star"></i>
                <span><?php echo esc_html( $rating_count ); ?> <?php echo esc_html__( 'Ratings', 'tijarah' ) ?></span>
			</li>
			<?php if (function_exists('getPostViews')) { ?>
			<li>
				<i class="fa fa-eye"></i>
                <span><?php echo getPostViews(get_the_id()); ?> <?php echo esc_html__( 'Views', 'tijarah' ) ?></span>
			</li>
			<?php } ?>
		</ul>

		<div class="widget-add-to-cart">
			<?php woocommerce_template_single_add_to_cart(); ?>				
		</div>             

	</div>
</div>

<div class="widget-woocommerce">
	<h4 class="widget-woocommerce-title"><?php echo esc_html__( 'Specification', 'tijarah' ) ?></h4>
	<div class="widget-product-details">
		<table>
	        <tbody>
			<tr>
	          <th><?php echo esc_html__( 'Last Update:','tijarah' ); ?></th>
	          <td><span><?php the_modified_date(); ?></span></td>
	        </tr>
			<tr>
	          <th><?php echo esc_html__( 'Relased:','tijarah' ); ?></th>
	          <td><span><?php echo get_the_date(); ?></span></td>
	        </tr>
	
			<?php
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
				if ( $product_tags ){ ?>
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
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>