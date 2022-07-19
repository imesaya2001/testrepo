<?php 

function tijarah_social_share() { ?>

	<div class="social-share list-inline">
        <ul class="list-inline-item">
	        <li class="list-inline-item"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>"><i class="fab fa-facebook-f"></i></a></li>
	        <li class="list-inline-item"><a href="http://www.twitter.com/share?url=<?php the_permalink() ?>"><i class="fab fa-twitter"></i></a></li>
	        <li class="list-inline-item"><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php echo wp_get_attachment_url( get_post_thumbnail_id() ) ?>&description=<?php echo get_the_excerpt(); ?>"><i class="fab fa-pinterest"> </i></a></li>
	        <li class="list-inline-item"><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>"><i class="fab fa-linkedin-in"></i></a></li>
	    </ul>
	</div>
    
	<?php
}

function tijarah_product_social_share() { ?>

	<div class="product-social-share">
	        <div class="float">
				<i class="fa fa-share-alt my-float"></i>
			</div>
			<div class="social">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" class="facebook"><i class="fab fa-facebook-f"></i></a>
				<a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php echo wp_get_attachment_url( get_post_thumbnail_id() ) ?>&description=<?php echo get_the_excerpt(); ?>" class="pinterest"><i class="fab fa-pinterest"></i></a>
				<a href="http://www.twitter.com/share?url=<?php the_permalink() ?>" class="twitter"><i class="fab fa-twitter"></i></a>
				<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
	        </div>
        </div><!-- product-social-share -->
        
	<?php
}