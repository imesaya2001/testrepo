<?php
function ajax_fetch() { ?>
  <script type="text/javascript">
  function fetch(){
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
        success: function(data) {
          if (jQuery('#keyword').val().length !== 0) {
            jQuery('#datafetch').html( data );
          } else {
            jQuery('#datafetch').html( '' );
          }
            
        }
    });

    jQuery("#datafetch").show();
  }
  </script>
<?php
}
add_action( 'wp_footer','ajax_fetch' );


function data_fetch(){
    $the_query = new WP_Query( array( 
      'post_type' => 'product', 
      'post_status' => 'publish',
      'posts_per_page' => 10 , 
      's' => esc_attr( $_POST['keyword'] )      
    ));

    if( $the_query->have_posts() ) { ?>
      <ul class="ajax-search-results list-unstyled">
        <?php
        while( $the_query->have_posts() ){ $the_query->the_post(); ?>
        <li>
          <a href="<?php echo esc_url( post_permalink() ); ?>">
            <?php if (get_post_meta( get_the_ID(), 'product_item_thumbnail', 1 )){ ?>
              <img src="<?php echo esc_url( get_post_meta( get_the_ID(), 'product_item_thumbnail', 1 ), 'tijarah-32x32' ); ?>" alt="<?php the_title_attribute() ?>">
            <?php } else { ?>
              <?php the_post_thumbnail( 'tijarah-32x32') ?>
            <?php } ?>
            <?php the_title();?>
          </a>
        </li>
        <?php }; ?>
      </ul>
      <?php
      wp_reset_postdata();  
    }
  die();
}

add_action( 'wp_ajax_data_fetch',  'data_fetch' );
add_action( 'wp_ajax_nopriv_data_fetch',  'data_fetch' );











