<?php

/**
 * HTTPService class to help in HTTP-related tasks.
 *
 */
class HTTPService {

	// Xfers URLs
	const XFER_URL_BASE = 'https://www.xfers.io/';
	const XFER_URL_BASE_SANDBOX = 'https://sandbox.xfers.io/';
	// Xfers API URLs
	const XFER_API_URL_BASE = 'https://www.xfers.io/api/v2/';
	const XFER_API_URL_BASE_SANDBOX = 'https://sandbox.xfers.io/api/v2/';
	// Xfer API latest version
	const XFER_API_VERSION = 'v2/';

	public function __construct($config) {
		
	}

	/**
	 * Send the actual HTTP POST to Xfers servers.
	 *
	 * @return mixed            Returns the result from json_decode of Xfers's response
	 * @throws XfersException   Error sending HTTP POST
	 */
	protected static function doXfersGet($url, $fields) {

		// initialize cURL
		$ch = curl_init();

		$fields_string = http_build_query($fields);

		// set options for cURL
		curl_setopt($ch, CURLOPT_URL, $url . '?' . $fields_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// execute HTTP POST request
		$response = curl_exec($ch);
		$ch_error = curl_error($ch);
		if ($ch_error) {
			echo $ch_error;
			die();
		}

		// close connection
		curl_close($ch);

		return self::parseResult($response);
	}

	/**
	 * Send the actual HTTP POST to Xfers servers.
	 *
	 * @return mixed            Returns the result from json_decode of Xfers's response
	 * @throws XfersException   Error sending HTTP POST
	 */
	protected static function doXfersPost($url, $fields) {

		// initialize cURL
		$ch = curl_init();

		$fields_string = http_build_query($fields);

		// set options for cURL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		// execute HTTP POST request
		$response = curl_exec($ch);
		$ch_error = curl_error($ch);
		if ($ch_error) {
			echo $ch_error;
			die();
		}

		// close connection
		curl_close($ch);

		return self::parseResult($response);
	}

	/**
	 * Send the actual HTTP PUT to Xfers servers.
	 *
	 * @return mixed            Returns the result from json_decode of Xfers's response
	 * @throws XfersException   Error sending HTTP POST
	 */
	protected static function doXfersPut($url, $fields) {

		// initialize cURL
		$ch = curl_init();

		$fields_string = http_build_query($fields);

		// set options for cURL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		// execute HTTP POST request
		$response = curl_exec($ch);
		$ch_error = curl_error($ch);
		if ($ch_error) {
			echo $ch_error;
			die();
		}

		// close connection
		curl_close($ch);

		return self::parseResult($response);
	}

	/**
	 * Get API URL based on config.
	 * @return string URL for Xfers service
	 */
	protected static function _getURL($config, $service) {
		if (isset($config['SANDBOX']) && $config['SANDBOX']) {
			$_BASE_URL = self::XFER_URL_BASE_SANDBOX;
		} else {
			$_BASE_URL = self::XFER_URL_BASE;
		}

		switch ($service) {
			case 'account_registration':
				return $_BASE_URL . 'account_registration';
			default:
				break;
		}
	}

	/**
	 * Get API URL based on config.
	 * @return string URL for Xfers service
	 */
	protected static function _getAPIURL($config, $service) {
		if (isset($config['SANDBOX']) && $config['SANDBOX']) {
			$_BASE_URL = self::XFER_API_URL_BASE_SANDBOX;
		} else {
			$_BASE_URL = self::XFER_API_URL_BASE;
		}

		switch ($service) {
			case 'accounts':
				return $_BASE_URL . 'accounts/';
			case 'accounts_status':
				return $_BASE_URL . 'accounts/status/';
			case 'transaction':
				return $_BASE_URL . 'transactions/';
			case 'transactions':
				return $_BASE_URL . 'users/';
			case 'payments_validate':
				return $_BASE_URL . 'payments/validate/';
			default:
				break;
		}
	}

	/**
	 * Throw XfersException if there are errors.
	 *
	 * @return mixed            Returns the result from json_decode of Xfers's response
	 * @throws XfersException   Error sending HTTP POST
	 */
	private static function parseResult($response) {
		$result = json_decode($response);

		if (is_null($result)) {
			return $response;
		}

		return $result;
	}

}