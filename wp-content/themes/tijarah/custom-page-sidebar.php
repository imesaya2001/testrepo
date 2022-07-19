<?php 
/**
 * Template Name: Custom Page With Sidebar
 */

get_header(); ?>

<section class="section-padding">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-8 col-md-7">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</div>

			<div class="col-xl-4 col-md-5">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer();