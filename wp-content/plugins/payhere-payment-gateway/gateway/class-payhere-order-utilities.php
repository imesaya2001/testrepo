<?php


class PayHereOrderUtilities
{

    private $order;
    private $is_subscription;
    private $gateUtils;

    public function __construct(WC_Order $order, $is_subscription)
    {
        $this->order = $order;
        $this->is_subscription = $is_subscription;
        $this->gateUtils = new GatewayUtilities();
    }


    public function update_user_token($post)
    {
        update_user_meta($this->order->get_customer_id(), 'payhere_customer_token', $post['customer_token']);

        $card_data = array(
            'card_holder_name' => $post['card_holder_name'],
            'card_no' => $post['card_no'],
            'card_expiry' => $post['card_expiry'],
            'saved_date' => time(),
            'method' => $post['method']
        );
        update_user_meta($this->order->get_customer_id(), 'payhere_customer_data', json_encode($card_data));
        $this->gateUtils->_log('TOKEN', $this->order->get_customer_id() . ' : ' . $post['customer_token']);
    }

    public function authorize_order($post){
        if ($this->order->get_status() == 'pending') {
            $this->order->add_order_note('Order amount : ' .$post['payhere_currency'] .' '.$post['payhere_amount'].'  Authorized By PayHere');
            $this->order->add_order_note($post['status_message']);

            $this->order->add_meta_data('payhere_auth_token',$post['authorization_token']);
            $this->order->add_meta_data('payhere_auth_amount',$post['payhere_amount']);
            $this->order->update_status('phauthorized');
            $this->order->save();
        }
    }


    public function update_order($post)
    {
        global $woocommerce;
        if ($this->order->get_status() == 'processing') {
            $this->order->add_order_note('PayHere Payment ID: ' . $post['payment_id']);
        } else {
            $this->order->payment_complete();
            $this->order->add_order_note('PayHere payment successful.<br/>PayHere Payment ID: ' . $post['payment_id']);

            if ($this->is_subscription) {
                $this->order->add_order_note('PayHere Subscription ID: ' . $post['subscription_id']);
                $this->order->update_meta_data('_payhere_subscription_id', $post['subscription_id']);
                $this->order->save();
            }
            $woocommerce->cart->empty_cart();
        }

        if ($this->is_subscription) {
            WC_Subscriptions_Manager::process_subscription_payments_on_order($this->order);
        }
    }

    public function redirect_user($page)
    {
        if ($this->redirect_page == '' || $this->redirect_page == 0) {
            $redirect_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $redirect_url = get_permalink($this->redirect_page);
        }
        wp_redirect($redirect_url);
    }
}