<?php
/**
 * Dokan Store Contact Form widget Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<form id="dokan-form-contact-seller" action="" method="post" class="seller-form clearfix">
    <div class="ajax-response"></div>
    <div class="form-group">
        <input type="text" name="name" value="<?php echo esc_attr( $username ); ?>" placeholder="<?php esc_attr_e( 'Your Name', 'tijarah' ); ?>" class="dokan-form-control" minlength="5" required="required">
    </div>
    <div class="form-group">
        <input type="email" name="email" value="<?php echo esc_attr( $email ); ?>" placeholder="<?php esc_attr_e( 'you@example.com', 'tijarah' ); ?>" class="dokan-form-control" required="required">
    </div>
    <div class="form-group">
        <textarea  name="message" maxlength="1000" cols="25" rows="6" value="" placeholder="<?php esc_attr_e( 'Type your messsage...', 'tijarah' ); ?>" class="dokan-form-control" required="required"></textarea>
    </div>
    <?php do_action( 'dokan_contact_form', $seller_id ) ?>

    <?php wp_nonce_field( 'dokan_contact_seller' ); ?>
    <input type="hidden" name="seller_id" value="<?php echo esc_html( $seller_id ); ?>">
    <input type="hidden" name="action" value="dokan_contact_seller">
    <input type="submit" name="store_message_send" value="<?php esc_attr_e( 'Send Message', 'tijarah' ); ?>" class="">
</form>
