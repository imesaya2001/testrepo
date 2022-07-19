<div class="photo-product-item">
	<?php woocommerce_template_loop_add_to_cart() ?>
	<a href="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )[0]; ?>" class="photo-product-item-click" title="<?php the_title() ?>" data-source="<?php the_permalink() ?>">
	  <?php the_post_thumbnail() ?>
	  <ul class="list-inlin">
	    <li class="list-inline-item"><?php echo get_avatar( get_the_author_meta( 'ID' ), '30').get_the_author() ?></li>
	    <li class="list-inline-item float-right"><i class="fa fa-eye"></i><?php echo getPostViews(get_the_id()); ?> <?php echo esc_html__( 'Views', 'tijarah' ) ?></li>
	  </ul>
	</a>
</div>