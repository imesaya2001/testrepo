<?php

class GatewayUtilities
{

    public function get_form_fields()
    {
        return array(
            'seperator' => array(
                'title' => __('General Settings', 'payhere'),
                'description' => '',
                'type' => 'title'
            ),
            // Activate the Gateway
            'enabled' => array(
                'title' => __('Enable/Disable', 'payhere'),
                'type' => 'checkbox',
                'label' => __('Enable PayHere', 'payhere'),
                'default' => 'yes',
                'description' => 'Show in the Payment List as a payment option',
                'desc_tip' => true
            ),
            // Title as displayed on Frontend
            'title' => array(
                'title' => __('Title', 'payhere'),
                'type' => 'text',
                'default' => __('PayHere', 'payhere'),
                'description' => __('This controls the title which the user sees during checkout.', 'payhere'),
                'desc_tip' => true
            ),
            // Description as displayed on Frontend
            'description' => array(
                'title' => __('Description:', 'payhere'),
                'type' => 'textarea',
                'default' => __('Pay by Visa, MasterCard, AMEX, eZcash, mCash or Internet Banking via PayHere.', 'payhere'),
                'description' => __('This controls the description which the user sees during checkout.', 'payhere'),
                'desc_tip' => true
            ),
            // LIVE Key-ID
            'merchant_id' => array(
                'title' => __('Merchant ID', 'payhere'),
                'type' => 'text',
                'description' => __('Your PayHere Merchant ID'),
                'desc_tip' => true
            ),
            // LIVE Key-Secret
            'secret' => array(
                'title' => __('Secret Key', 'payhere'),
                'type' => 'text',
                'description' => __('Secret word you set in your PayHere Account'),
                'desc_tip' => true
            ),
            // Mode of Transaction
            'test_mode' => array(
                'title' => __('Sandbox Mode', 'payhere'),
                'type' => 'checkbox',
                'label' => __('Enable Sandbox Mode', 'payhere'),
                'default' => 'yes',
                'description' => __('PayHere sandbox can be used to test payments', 'payhere'),
                'desc_tip' => true
            ),
            // Onsite checkout
            'onsite_checkout' => array(
                'title' => __('Onsite Checkout', 'payhere'),
                'type' => 'checkbox',
                'label' => __('Enable On-site Checkout', 'payhere'),
                'default' => 'no',
                'description' => __('Enable to let customers checkout with PayHere without leaving your site', 'payhere'),
                'desc_tip' => true
            ),
            // Page for Redirecting after Transaction
            'redirect_page' => array(
                'title' => __('Return Page'),
                'type' => 'select',
                'options' => $this->payhere_get_pages('Select Page'),
                'description' => __('Page to redirect the customer after payment', 'payhere'),
                'desc_tip' => true
            ),
            'payment_action' => array(
                'title' => __('Payment Action', 'payhere'),
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'description' => __('Choose whether you wish to capture funds immediately or authorize payment and capture later.<br/><br/>To setup Authorize mode with your PayHere Live Account, contact PayHere Support on <a href="tel:+94115339339">+94 115 339 339</a> on email <a href="mailto:support@payhere.lk">support@payhere.lk</a>. Our team will be of assistance.', 'payhere'),
                'default' => 'sale',
                'desc_tip' => false,
                'options' => array(
                    'sale' => __('Sale', 'payhere'),
                    'authorization' => __('Authorize', 'payhere'),
                ),
            ),
            'seperator_2' => array(
                'title' => __('Recurring Payments', 'payhere'),
                'description' => __('You will only need below credentials if you have subscriptions or Charging API available.', 'payhere'),
                'type' => 'title'
            ),
            // Business App ID
            'enable_tokenizer' => array(
                'title' => __('Enable Tokenizer', 'payhere'),
                'type' => 'checkbox',
                'description' => __('If Enabled, Customers can pay with their saved cards. <a target="_blank" href="https://support.payhere.lk/api-&-mobile-sdk/payhere-charging">More Info</a>'),
                'desc_tip' => false
            ),// Business App ID
            'app_id' => array(
                'title' => __('App ID', 'payhere'),
                'type' => 'text',
                'description' => __('Your PayHere Business App ID <a target="_blank" href="https://support.payhere.lk/api-&-mobile-sdk/payhere-subscription#1-create-a-business-app">More Info</a>'),
                'desc_tip' => false
            ),// Business App Secret
            'app_secret' => array(
                'title' => __('App Secret', 'payhere'),
                'type' => 'text',
                'description' => __('Your PayHere Business App Secret'),
                'desc_tip' => true
            ),
            'subscription_warn' => array(
                'title' => '<span class="dashicons dashicons-warning"></span>Important!!',
                'type' => 'info_box',
                'box_type' => 'info',
                'description' => "<p>PayHere doesn't support Renewals,Switching and Synchronisation for Subscriptions.</p><p>Please do not enable above features in Woocommerce Subscription Plugin settings.</p>",
                'desc_tip' => true
            ),
        );
    }

    /**
     * Get Page list from WordPress
     **/
    public function payhere_get_pages($title = false, $indent = true)
    {
        $wp_pages = get_pages('sort_column=menu_order');
        $page_list = array();
        if ($title) $page_list[] = $title;
        foreach ($wp_pages as $page) {
            $prefix = '';
            // show indented child pages?
            if ($indent) {
                $has_parent = $page->post_parent;
                while ($has_parent) {
                    $prefix .= ' - ';
                    $next_page = get_post($has_parent);
                    $has_parent = $next_page->post_parent;
                }
            }
            // add to page list array array
            $page_list[$page->ID] = $prefix . $page->post_title;
        }
        return $page_list;
    }

    /**
     * Generate Title HTML.
     *
     * @param string $key Field key.
     * @param array $data Field data.
     * @return string
     * @since  1.0.0
     */
    public function generate_info_box_html($key, $data)
    {

        $type = $data['box_type'];
        ob_start();
        $class = '';
        if ($type == 'info') {
            $class = 'alert alert-danger';
        }
        ?>
        <tr valign="top">
            <td colspan="2">
                <div class="<?php echo $class ?>">
                    <h3 class="wc-settings-sub-title "><?php echo $data['title'] ?></h3>
                    <?php echo $data['description'] ?>
                </div>
            </td>
        </tr>
        <?php

        return ob_get_clean();
    }

    /**
     * Generate the HASH value for verify PayHere notify_url call.
     * @param string $merchant_id Merchant ID
     * @param string $secret Merchant Secret
     * @param string $order_id Order ID
     * @param string $amount PayHere amount
     * @param string $currency PayHere Currency
     * @param string $status_code PayHere Status code
     * @return string
     * @since  1.0.0
     */
    public function generate_verify_hash($merchant_id, $secret, $order_id, $amount, $currency, $status_code)
    {
        $hash = $merchant_id;
        $hash .= $order_id;
        $hash .= $amount;
        $hash .= $currency;
        $hash .= $status_code;
        $hash .= strtoupper(md5($secret));
        return strtoupper(md5($hash));
    }

    /**
     * Generate the HASH value for generate form when initiating PayHere Gateway.
     * @param string $merchant_id Merchant ID
     * @param string $secret Merchant Secret
     * @param string $order_id Order ID
     * @param string $amount PayHere amount
     * @param string $currency PayHere Currency
     * @return string
     * @since  1.0.0
     */
    public function generate_frontend_hash($merchant_id, $secret, $order_id, $amount, $currency)
    {
        $hash = $merchant_id;
        $hash .= $order_id;
        $hash .= $amount;
        $hash .= $currency;
        $hash .= strtoupper(md5($secret));
        return strtoupper(md5($hash));
    }


    public function verify_hash($secret){
        $verified = true;
        $verification_required = apply_filters('payhere_filter_verification_required', true, $_REQUEST['order_id'], $_REQUEST['merchant_id']);
        if ($verification_required) {
            $effective_merchant_secret = apply_filters('payhere_filter_merchant_secret', $secret, $_REQUEST['order_id'], $_REQUEST['merchant_id']);
            if ($effective_merchant_secret) {
                $amount = str_replace(',','',$_REQUEST['payhere_amount']);
                $md5hash = $this->generate_verify_hash($_REQUEST['merchant_id'], $effective_merchant_secret, $_REQUEST['order_id'], number_format($amount,2,'.',''), $_REQUEST['payhere_currency'], $_REQUEST['status_code']);
                if (($md5hash != $_REQUEST['md5sig'])) {
                    $verified = false;
                }
            }
        }
        return $verified;
    }

    /**
     * return PayHere checkout URL
     * @param $is_test_mode Is test mode enabled
     * @return string
     */
    public function get_payhere_checkout_url($is_test_mode)
    {
        if ($is_test_mode == 'yes') {
            return 'https://sandbox.payhere.lk/pay/checkout';
        }
        return 'https://www.payhere.lk/pay/checkout';
    }

    /**
     * return PayHere preapprove URL
     * @param $is_test_mode
     * @return string
     */
    public function get_payhere_preapprove_url($is_test_mode)
    {
        if ($is_test_mode == 'yes') {
            return 'https://sandbox.payhere.lk/pay/preapprove';
        }
        return 'https://www.payhere.lk/pay/preapprove';
    }
    /**
     * return PayHere Autgorize URL
     * @param $is_test_mode
     * @return string
     */
    public function get_payhere_authorize_url($is_test_mode)
    {
        if ($is_test_mode == 'yes') {
            return 'https://sandbox.payhere.lk/pay/authorize';
        }
        return 'https://www.payhere.lk/pay/authorize';
    }


    /**
     * return amount in PayHere support format
     * @param $amount
     * @return string
     */
    public function price_format($amount){
        return number_format(str_replace(',', '', $amount), 2,  '.', '');
    }



    public function getRedirectUrl($id, $order)
    {

        $query = [
            'wc-api' => $id,
            'order_key' => $order->get_order_key(),
        ];
        return add_query_arg($query, trailingslashit(get_home_url()));
    }

    public function _log($type, $data)
    {
        $uploads = wp_upload_dir(null, false);
        $logs_dir = $uploads['basedir'] . '/payhere-logs';

        if (!is_dir($logs_dir)) {
            mkdir($logs_dir, 0755, true);
        }

        $__content = $data;
        if (is_array($data) || is_object($data)) {
            $__content = json_encode($data);
        }
        $_content = date('Y-m-d H:i:s') . "| [$type] \t\t| $__content";
        file_put_contents($logs_dir . '/log_' . date("Y-m-d") . '.log', [$_content . '' . PHP_EOL], FILE_APPEND);
    }

}