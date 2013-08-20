<?php

/**
 * Provides acccess to Payment-related Xfers API.
 *
 * API Documentation:
 * https://docs.google.com/a/paywhere.com/document/d/1lfw4xBsNEugPx-rAoNFFSQYvk-X69v-hZwJit52R7vU/
 */
class PaymentService extends HTTPService {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * After receiving a payment notification from Xfers, you need to do 
	 * verification with Xfers to confirm that that it did indeed originate 
	 * from Xfers.
	 *
	 * @param mixed $config
	 * @param mixed $fields
	 * @return mixed
	 * @throws Exception
	 */
	public static function validatePayment($config, $fields) {

		// API Configurations
		if (!isset($config['API_KEY'])) {
			throw new Exception('Invalid API Key.');
		}
		if (!isset($config['API_SECRET'])) {
			throw new Exception('Invalid API Secret.');
		}
		// Required Fields
		if (!isset($fields['orderId'])) {
			throw new Exception('Invalid Order ID.');
		}
		if (!isset($fields['totalAmount'])) {
			throw new Exception('Invalid Total Amount.');
		}
		if (!isset($fields['currency'])) {
			throw new Exception('Invalid Currency.');
		}
		if (!isset($fields['status'])) {
			throw new Exception('Invalid Status.');
		}
		if (!isset($fields['transId'])) {
			throw new Exception('Invalid Transaction ID.');
		}

		$data = array(
			'API_KEY' => $config['API_KEY'],
			'signature' => self::_generateSignature($config, $fields)
		);
		$data = array_merge($data, $fields);
		
		// do the actual post to Xfers servers
		$result = self::doXfersPost(self::_getAPIURL($config, 'payments_validate'), $data);

		return $result;
	}

	private static function _generateSignature($config, $fields) {

		if (!isset($config['API_KEY'])) {
			throw new Exception('Invalid Merchant API KEY.');
		}
		if (!isset($config['API_SECRET'])) {
			throw new Exception('Invalid Merchant API SECRET.');
		}
		// Required Fields
		if (!isset($fields['orderId'])) {
			throw new Exception('Invalid Order ID.');
		}
		if (!isset($fields['totalAmount'])) {
			throw new Exception('Invalid Total Amount.');
		}
		if (!isset($fields['currency'])) {
			throw new Exception('Invalid Currency.');
		}

		$fields['totalAmount'] = str_replace(',', '', $fields['totalAmount']);
		$fields['totalAmount'] = str_replace('.', '', $fields['totalAmount']);

		$signature_string = $config['API_KEY'] . $config['API_SECRET'] . $fields['orderId'] . $fields['totalAmount'] . $fields['currency'];
		$signature = sha1($signature_string);

		return $signature;
	}

}