<?php

// This is an api for sending SMS
function sendMessage(string $message, string $receipient)
{
	# code...
	$url = 'https://vas.teleskytech.com/api/sendsms';
	$post = [
		"username" => "totalk9",
		"api" => "a0239aaa3353",
		"phone" => $receipient,
		"from" => 'TOTALK9SOLN', //replace with sender ID (Telesky)
		"message" => $message
	];
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode($post),

		CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response;
}

// This function sends sms to customer and system administrators
// function send_sms($phone, $message)
// {
// 	// Get the ci instance
// 	$CI = &get_instance();
// 	// Get the database
// 	$CI->load->database();
// 	// Get the sms settings
// 	$CI->db->select('*');
// 	$CI->db->from('deli_sms_settings');
// 	$query = $CI->db->get();
// 	$sms_settings = $query->row();
// 	// Check if the sms settings are set
// 	if ($sms_settings->sms_status == 'enabled') {
// 		// Check if the sms gateway is set to africastalking
// 		if ($sms_settings->sms_gateway == 'africastalking') {
// 			// Get the sms settings
// 			$username = $sms_settings->sms_username;
// 			$apikey = $sms_settings->sms_api_key;
// 			// Initialize the africastalking gateway
// 			$AT = new AfricasTalkingGateway($username, $apikey);
// 			// Send the sms
// 			try {
// 				$results = $AT->sendMessage($phone, $message);
// 				// Return the response
// 				return true;
// 			} catch (AfricasTalkingGatewayException $e) {
// 				// Return the response
// 				return false;
// 			}
// 		} else if ($sms_settings->sms_gateway == 'twilio') {
// 			// Get the sms settings
// 			$account_sid = $sms_settings->sms_username;
// 			$auth_token = $sms_settings->sms_api_key;
// 			// Initialize the twilio gateway
// 			$twilio = new Client($account_sid, $auth_token);
// 			// Send the sms
// 			try {
// 				$message = $twilio->messages
// 					->create($phone, // to
// 						[
// 							"body" => $message,
// 							"from" => $sms_settings->sms_sender_id
// 						]
// 					);
// 				// Return the response
// 				return true;
// 			} catch (Exception $e) {
// 				// Return the response
// 				return false;
// 			}
// 		}
// 	} else {
// 		// Return the response
// 		return false;
// 	}
// }
