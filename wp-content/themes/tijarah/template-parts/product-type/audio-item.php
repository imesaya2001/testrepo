<?php 
$audio = get_post_meta( get_the_ID(), 'audio', true );
$thumbnail = get_post_meta( get_the_ID(), 'product_item_thumbnail', 1 )
?>

<div class="audioPlayer">
    <div class="playerContainer">
        <div class="albumArt">
            <a href="<?php the_permalink() ?>">
                <img src="<?php if ( $thumbnail ) { echo esc_url( $thumbnail ); } else { the_post_thumbnail_url( 'tijarah-80x80' ); } ?>" alt="<?php the_title_attribute() ?>">
            </a>
        </div>
        
        <div class="info">
            <div class="audioName" data-duration='5000' data-gap='50' data-duplicated='false'><h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5></div>
            <div class="seekBar">
              <span class="outer">
                  <span class="inner" data-seek=0></span>
              </span>
            </div>
            <div class="timing">
              <span class="start">0:00</span>
              <span class="end">0:00</span>
            </div>
        </div>

        <div class="volumeControl">
            <div class="wrapper">
              <i class="fa fa-volume-up"></i>
              <span class="outer">
                  <span class="inner"></span>
              </span>
            </div>
        </div>
        <button class="btn play">
            <i class="fa fa-play"></i>
            <i class="fa fa-pause"></i>
        </button>
    </div>

    <audio class="audio">
        <source src="<?php echo esc_url( $audio ) ?>">
    </audio>
</div>