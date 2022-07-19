<?php

class ChargePayment extends PayHereToken
{

    public function __construct($app_id, $app_secret, $is_sandbox)
    {
        parent::__construct($app_id, $app_secret, $is_sandbox);
    }


    private function submitCharge($token, $customer_token, $order_id, $amount)
    {

        $url = $this->get_payhere_chargin_api_url();

        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        );
        $fields = array(
            'order_id' => 'WC_' . $order_id,
            'items' => 'Woocommerce  Order :' . $order_id,
            'currency' => get_woocommerce_currency(),
            'amount' => $amount,
            'customer_token' => $customer_token,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, (json_encode($fields)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        curl_close($ch);

        if (!$head) {
            return FALSE;
        } else {
            return $head;
        }
        return FALSE;
    }


    public function charge_payment(WC_Order $order, $token)
    {

        $json = [];

        $_auth_token_data = $this->getAuthorizationToken();
        $auth_token_data = json_decode($_auth_token_data);
        $this->gateway_util->_log('authorization_token', $_auth_token_data);
        $this->gateway_util->_log('INFO', $token);


        if (isset($auth_token_data->access_token) && !empty($auth_token_data->access_token)) {
            $this->gateway_util->_log('ORDER', $order);
            $_charge_response = $this->submitCharge($auth_token_data->access_token, $token, $order->get_id(), $order->get_total());


            $this->gateway_util->_log('charge_response', $_charge_response);
            $charge_response = json_decode($_charge_response);
            if ($charge_response->status == '1') {

                if ($charge_response->data->status_code == '2') {
                    $order->payment_complete();
                    $order->add_order_note($charge_response->msg);
                    $order->add_order_note('PayHere payment successful.<br/>PayHere Payment ID: ' . $charge_response->data->payment_id);

                    $json['type'] = 'OK';
                    $json['message'] = 'Payment Charged Successfully.';
                } else {
                    $json['type'] = 'ERR';
                    $json['message'] = 'Payment Un-Successful. Code : ' . $charge_response->data->status_code;
                }
            } else {
                $json['type'] = 'ERR';
                $json['message'] = 'Can\'t make the payment. Payment Charge Request Failed.<br/>' . $charge_response->msg;
            }
        } else {
            $json['type'] = 'ERR';
            $json['message'] = 'Can\'t make the payment. Can\'t Generate the Authorization Tokens.';
        }

        return $json;
    }

}