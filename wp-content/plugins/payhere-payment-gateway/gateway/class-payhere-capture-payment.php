<?php

class PayHereCapturePayment extends PayHereToken
{

    public function __construct($app_id, $app_secret, $is_sandbox)
    {
        parent::__construct($app_id, $app_secret, $is_sandbox);
    }

    /**
     * Caputure payment for Authorized Payments
     * @param $token payhere auth token
     * @param $authorize_token  payment authorize token
     * @param $order_id woocommerce order id
     * @param $amount amount to capture
     */
    private function submit_capture_payment($token, $authorize_token, $order_id, $amount)
    {
        $this->gateway_util->_log('CAPTURE', array($token, $authorize_token, $order_id, $amount));
        $url = $this->get_payhere_capture_api_url();

        $this->gateway_util->_log('CAPTURE', $url);
        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        );
        $fields = array(
            'deduction_details' => 'Capture Payment for Order : #' . $order_id,
            'amount' => $amount,
            'authorization_token' => $authorize_token,
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


    /**
     * @param WC_Order $order Order for capture payment
     * @param $token PayHere payment authorize token
     * @param $amount Amount to  capture
     * @return array Status array message with type and message
     */
    public function capture_payment_payhere(WC_Order $order, $token, $amount)
    {
        $json = [];

        $_auth_token_data = $this->getAuthorizationToken();
        $this->gateway_util->_log('authorization_token', $_auth_token_data);
        $auth_token_data = json_decode($_auth_token_data);

        if (isset($auth_token_data->access_token) && !empty($auth_token_data->access_token)) {

            $this->gateway_util->_log('INFO', "Trying to capture");
            $_capture_response = $this->submit_capture_payment($auth_token_data->access_token, $token, $order->get_id(), $amount);
            $this->gateway_util->_log('capture_response', $_capture_response);

            $capture_response = json_decode($_capture_response);

            if ($capture_response->status == '1') {

                if ($capture_response->data->status_code == '2') {
                    $order->set_status('processing');
                    $order->payment_complete($capture_response->data->payment_id);
                    $order->add_meta_data('payhere_acpture_date',date("g:ia \o\n l jS F Y"));
                    $order->add_meta_data('payhere_acpture_amount',$capture_response->data->captured_amount);
                    $order->add_order_note($capture_response->msg);
                    $order->add_order_note($capture_response->data->status_message);
                    $order->save();

                    $json['type'] = 'OK';
                    $json['message'] = 'Payment Captured Successfully.';
                } else {
                    $json['type'] = 'ERR';
                    $json['message'] = 'Payment Un-Successful. Code : ' . $capture_response->data->status_code;
                }
            } else {
                $json['type'] = 'ERR';
                $_msg = isset($capture_response->msg) ? $capture_response->msg : $capture_response->error_description;
                $json['message'] = 'Can\'t make the payment. Payment Capture Request Failed.<br/>' . $_msg;
            }


        } else {
            $json['type'] = 'ERR';
            $json['message'] = 'Can\'t make the payment. Can\'t Generate the Authorization Tokens.';
        }

        return $json;
    }

}