jQuery(document).ready(function($) {
    $('.thumb-product-filter').click( function(event) {
 
        // Prevent default action - opening tag page
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }
 
        // Get tag slug from title attirbute
        var selecetd_taxonomy = $(this).attr('data-thumb-product-cat');

        // console.log(selecetd_taxonomy);
 
        // After user click on tag, fade out list of posts
        $('.newest_items').fadeOut();
        $('.loader').show();
 
        data = {
            action: 'filter_thumb_products', // function to execute
            tijarah_thumb_product_ajax_nonce: tijarah_ajax_thumb_products_obj.tijarah_thumb_product_ajax_nonce, // wp_nonce
            taxonomy: selecetd_taxonomy, // selected tag
        };
 
        $.post( tijarah_ajax_thumb_products_obj.tijarah_thumb_product_ajax_url, data, function(response) {
           
            if( response ) {
                // Display posts on page
                $('.newest_items').html( response );

                // Restore div visibility
                $('.newest_items').fadeIn();

                $('.loader').hide();

                // Products Tooltip
                $(".sit-preview").smartImageTooltip({previewTemplate: "envato", imageWidth: "500px"});
            };
        });
    });
});