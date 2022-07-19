<?php 

$video = get_post_meta( get_the_ID(), 'video', true );
$youtube_video = get_post_meta( get_the_ID(), 'youtube_video', true );
$vimeo_video = get_post_meta( get_the_ID(), 'vimeo_video', true );


if ( $youtube_video ){ ?>
	
	<div class="plyr__video-embed" id="tijarah-player">
	    <iframe
	        src="<?php echo esc_url( $youtube_video ) ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
	        allowfullscreen
	        allowtransparency
	        allow="autoplay" width="100%" height="100%"
	    ></iframe>
	</div>

<?php } elseif ( $vimeo_video ){ ?>

	<div class="plyr__video-embed" id="tijarah-player">
	    <iframe
	        src="<?php echo esc_url( $vimeo_video ) ?>?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
	        allowfullscreen
	        allowtransparency
	        allow="autoplay"
	    ></iframe>
	</div>

<?php } else { ?>

<div class="video-item">
	<video poster="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'tijarah-1280x720' )[0]; ?>" id="tijarah-player" controls>
		<source src="<?php echo esc_url( $video ) ?>" type="video/mp4" />
		<source src="<?php echo esc_url( $video ) ?>" type="video/webm" />
	</video>
	<a class="view-detail" href="<?php the_permalink() ?>"><?php echo esc_html__( 'View detail', 'tijarah' ) ?></a>
</div>

<?php } ?>