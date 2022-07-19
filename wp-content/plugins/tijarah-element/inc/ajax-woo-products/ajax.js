jQuery(document).ready(function($) {
    $('.product-filter').click( function(event) {
 
        // Prevent default action - opening tag page
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }
 
        // Get tag slug from title attirbute
        var selecetd_taxonomy = $(this).attr('data-product-cat');

        // console.log(selecetd_taxonomy);
 
        // After user click on tag, fade out list of posts
        $('.download_items').fadeOut();
        $('.loader').show();
 
        data = {
            action: 'filter_products', // function to execute
            tijarah_product_ajax_nonce: tijarah_ajax_products_obj.tijarah_product_ajax_nonce, // wp_nonce
            taxonomy: selecetd_taxonomy, // selected tag
        };
 
        $.post( tijarah_ajax_products_obj.tijarah_product_ajax_url, data, function(response) {
 
            if( response ) {
                // Display posts on page
                $('.download_items').html( response );
                // Restore div visibility
                $('.download_items').fadeIn();

                $('.loader').hide();
            };
        });
    });
});