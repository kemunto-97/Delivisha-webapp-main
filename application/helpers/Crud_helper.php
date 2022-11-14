<?php

/**
 * @param Description - This file contains methods for all create read and update logic
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-10-13
 */

//  This function is for saving email notifications
function save_email_notification($messageId)
{
	// Get the ci instance
	$CI = &get_instance();
	// Get the database
	$CI->load->database();
	// Get the message details
	$CI->db->select('*');
	$CI->db->from('deli_contacts');
	$CI->db->where('id', $messageId);
	$query = $CI->db->get();
	$message = $query->row();
	// Prepare notification data
	$notificationData = array(
		'notification_type' => 'email',
		'notification_title' => 'New message',
		'notification_message' => 'You have a new message from ' . $message->full_name,
		'notification_status' => 'unread',
		'notification_date' => date('Y-m-d H:i:s'),
	);
	// Insert the notification data into the database
	$CI->db->insert('deli_notifications', $notificationData);
	// Return a message
	return true;
}

// Google reCaptcha validation
function validate_recaptcha($recaptchaResponse)
{
	// Get the ci instance
	$CI = &get_instance();
	// Get the database
	$CI->load->database();
	// Get the recaptcha secret key
	$CI->db->select('secret_value');
	$CI->db->from('deli_recaptcha_settings');
	$CI->db->where('secret_name', 'recaptcha_secret_key');
	$query = $CI->db->get();
	$recaptchaSecretKey = $query->row()->secret_value;
	// Prepare the request
	$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
	$remoteIp = $_SERVER['REMOTE_ADDR'];

	// Send the request
	$recaptchaResponse = file_get_contents($recaptchaUrl . '?secret=' . $recaptchaSecretKey . '&response=' . $recaptchaResponse . '&remoteip=' . $remoteIp);
	// Decode the response
	$recaptchaResponse = json_decode($recaptchaResponse);
	// Return the response
	return $recaptchaResponse->success;
}

// This function is for hashing passwords
function hash_password($password)
{
	// Hash the password
	$password = password_hash($password, PASSWORD_DEFAULT);
	// Return the hashed password
	return $password;
}

// This function is for comparing passwords
function compare_password($password, $hashedPassword)
{
	// Compare the passwords
	$compare = password_verify($password, $hashedPassword);
	// Return the comparison
	return $compare;
}

// Generate token function
function generate_secret_token($length = 32)
{
	$secret = "";
	$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
	$codeAlphabet .= "0123456789";
	$max = strlen($codeAlphabet); // edited

	for ($i = 0; $i < $length; $i++) {
		$secret .= $codeAlphabet[random_int(0, $max - 1)];
	}

	return $secret;
}

// This function is for getting customer orders
function get_customer_orders($customer_id, $table)
{
	// initialize ci instance
	$ci = &get_instance();
	$ci->load->database();
	// Get orders
	$ci->db->select('*');
	$ci->db->from($table);
	$ci->db->where('customer_id', $customer_id);
	$ci->db->order_by('waybill_number', 'DESC');
	$query = $ci->db->get();
	$orders = $query->result();
	// Return orders
	return $orders;
}

// This function is for getting customer order count
function get_customer_orders_count($customer_id, $table)
{
	// initialize ci instance
	$ci = &get_instance();
	$ci->load->database();
	// Get orders
	$ci->db->select('*');
	$ci->db->from($table);
	$ci->db->where('customer_id', $customer_id);
	$query = $ci->db->get();
	$orders = $query->num_rows();
	// Return orders
	return $orders;
}

/**
 * @param $type: String ie. "success", "error", "warning"
 * @param $title: String ie. title of the response
 * @param $status: Integer ie. 200, 400, 500
 * @param $data: Array ie. ["name" => "John Doe", "age" => 20]
 * @param $message: String default: "Something went wrong while trying to connect, try again later"
 * @param $code: Intager expects a number 1 or 0
 * @param $url: String expects a url to redirect to
 * @param Description This function takes in 4-6 parameters and returns a JSON response the first 3 parameters are required
 * @return JSON
 * @author: Dennis Otieno - E-mail: otienodennis29@gmail.com
 */
function set_response($type, $title, $status_code, $data = [], $message = "", $code = null, $url = null)
{
	// Get the ci instance
	$CI = &get_instance();
	// Generate a csrf token if not provided
	$csrf = [
		'name' => $CI->security->get_csrf_token_name(),
		'hash' => $CI->security->get_csrf_hash()
	];

	// Set the response body
	$message = [
		'status' => $type,
		'title' => $title,
		'message' => $message !== "" ? $message : "Something went wrong while trying to connect, try again later",
		'status_code' => $status_code,
		'url' => $url !== null ? $url : null,
		'code' => $code !== null ? $code : 0,
		'token' => $csrf['hash'],
		'data' => $data
	];
	echo json_encode($message);
	exit;
}

// This function checks if the user exists
function user_exists($user_id)
{
	// Get the ci instance
	$CI = &get_instance();
	// Get the database
	$CI->load->database();
	// Check if the user exists
	$CI->db->select('*');
	$CI->db->from('deli_authentication');
	$CI->db->where('user_id', $user_id);
	$query = $CI->db->get();
	// User data
	if ($user = $query->row()) {
		// Get user from respective table depending on the user type
		if ($user->user_type == 'admin') {
			$CI->db->select('*');
			$CI->db->from('deli_admins');
			$CI->db->where('admin_id', $user_id);
			$query = $CI->db->get();
			$user_data = $query->row();
		} else if ($user->user_type == 'driver') {
			$CI->db->select('*');
			$CI->db->from('deli_drivers');
			$CI->db->where('driver_id', $user_id);
			$query = $CI->db->get();
			$user_data = $query->row();
		} else if ($user->user_type == 'vendor') {
			$CI->db->select('*');
			$CI->db->from('deli_vendors');
			$CI->db->where('vendor_id', $user_id);
			$query = $CI->db->get();
			$user_data = $query->row();
		}
		// Return the user
		return $user_data;
	} else {
		return false;
	}
}

// This function is for creating new notification
function createNotification($type, $title, $message)
{
	// Get the ci instance
	$CI = &get_instance();
	// Get the database
	$CI->load->database();
	// Create the notification
	$notification = [
		'notification_type' => $type,
		'notification_title' => $title,
		'notification_message' => $message,
		'notification_status' => 'unread',
		'notification_date' => date('Y-m-d H:i:s')
	];
	// Insert the notification
	$CI->db->insert('deli_notifications', $notification);
	// Return the notification
	return true;
}

/** 
 * @param $datetime: String expects a date timestamp
 * @param $full: Boolean expects a boolean value true or false
 * @param Description This function takes in a date timestamp and returns a human readable time. if boolean is set to true it returns a full date and time else it returns a short date and time
 * @author: Dennis Otieno - E-mail: otienodennis29@gmail.com
 */
function time_elapsed_string($datetime, $full = false)
{
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// Function for creating salute depending on the time of the day
function get_salute()
{
	$time = date("H");
	if ($time < "12") {
		return "Good Morning";
	} elseif ($time >= "12" && $time < "17") {
		return "Good Afternoon";
	} elseif ($time >= "17" && $time < "19") {
		return "Good Evening";
	} else {
		return "Hello There";
	}
}

// Function for culculating shipping cost using weight and quantity
function calculate_shipping($weight, $quantity, $packageType, $status)
{
	// Get the Calculation costs
	$shipping_costs = get_shipping_cost();
	// Initialize the total price
	$totalPrice = 0;
	// Calculate shipping depending on the package type
	if ($packageType == 'Document') {
		if ($status == 2) :
			$totalPrice = ($shipping_costs->std_doc_price + $shipping_costs->doc_urg_price) * $quantity;
		else :
			$totalPrice =  $shipping_costs->std_doc_price * $quantity;
		endif;
	} elseif ($packageType == 'Parcel') { // Parcel calculations
		// check if the weight is less than 5kg or is empty
		if ($weight <= 5 || $weight == "") {
			// Check if the status is urgent
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_parcel_price + $shipping_costs->parcel_urg_price) * $quantity;
			else :
				$totalPrice =  $shipping_costs->std_parcel_price * $quantity;
			endif;
		} else { // If the weight is greater than 5kg
			// Calculate the extra weight
			$extra_weight = $weight - 5;
			// Calculate the extra weight price
			$extra_weight_price = $extra_weight * $shipping_costs->extra_weight_price;
			// Calculate the total price
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_parcel_price + $shipping_costs->parcel_urg_price + $extra_weight_price) * $quantity;
			else :
				$totalPrice =  ($shipping_costs->std_parcel_price + $extra_weight_price) * $quantity;
			endif;
		}
	} elseif ($packageType == 'Box') {
		// check if the weight is less than 10kg or is empty
		if ($weight <= 10 || $weight == "") {
			// Check if the status is urgent
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_box_price + $shipping_costs->box_urg_price) * $quantity;
			else :
				$totalPrice =  $shipping_costs->std_box_price * $quantity;
			endif;
		} else { // If the weight is greater than 10kg
			// Calculate the extra weight
			$extra_weight = $weight - 10;
			// Calculate the extra weight price
			$extra_weight_price = $extra_weight * $shipping_costs->extra_weight_price;
			// Calculate the total price
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_box_price + $shipping_costs->box_urg_price + $extra_weight_price) * $quantity;
			else :
				$totalPrice =  ($shipping_costs->std_box_price + $extra_weight_price) * $quantity;
			endif;
		}
	} elseif ($packageType == 'Crate') {
		// check if the weight is less than 20kg or is empty
		if ($weight <= 20 || $weight == "") {
			// Check if the status is urgent
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_crate_price + $shipping_costs->crate_urg_price) * $quantity;
			else :
				$totalPrice =  $shipping_costs->std_crate_price * $quantity;
			endif;
		} else { // If the weight is greater than 20kg
			// Calculate the extra weight
			$extra_weight = $weight - 20;
			// Calculate the extra weight price
			$extra_weight_price = $extra_weight * $shipping_costs->extra_weight_price;
			// Calculate the total price
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_crate_price + $shipping_costs->crate_urg_price + $extra_weight_price) * $quantity;
			else :
				$totalPrice =  ($shipping_costs->std_crate_price + $extra_weight_price) * $quantity;
			endif;
		}
	} elseif ($packageType == 'Pallet') {
		// check if the weight is less than 100kg or is empty
		if ($weight <= 100 || $weight == "") {
			// Check if the status is urgent
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_pallet_price + $shipping_costs->pallet_urg_price) * $quantity;
			else :
				$totalPrice =  $shipping_costs->std_pallet_price * $quantity;
			endif;
		} else { // If the weight is greater than 100kg
			// Calculate the extra weight
			$extra_weight = $weight - 100;
			// Calculate the extra weight price
			$extra_weight_price = $extra_weight * $shipping_costs->extra_weight_price;
			// Calculate the total price
			if ($status == 2) :
				$totalPrice = ($shipping_costs->std_pallet_price + $shipping_costs->pallet_urg_price + $extra_weight_price) * $quantity;
			else :
				$totalPrice =  ($shipping_costs->std_pallet_price + $extra_weight_price) * $quantity;
			endif;
		}
	}
	// Return the total price
	return $totalPrice;
}

function get_shipping_cost()
{
	// Get the ci instance
	$CI = &get_instance();
	// Get the database
	$CI->load->database();
	// Get the items from the databse
	$CI->db->select('*');
	$CI->db->from('deli_shipping_amount');
	$CI->db->where('id', 1);
	$query = $CI->db->get();
	return $query->row();
}

// This function is for pushing notifications to the admin
function push_notification($message)
{
	// Get the ci instance
	$CI = &get_instance();
	// Get the database
	$CI->load->database();
	// Get the items from the databse
	$CI->db->select('*');
	$CI->db->from('deli_notifications');
	$CI->db->where('notification_status', 'unread');
	// Get the number of unread notifications
	$unread_notifications = $CI->db->count_all_results();

	// Get the notification settings
	$CI->load->view('vendor/autoload.php');

	$options = array(
		'cluster' => 'mt1',
		'useTLS' => true
	);
	$pusher = new Pusher\Pusher(
		'2d87a011e38a284e30a6',
		'8e8e08ede74e7701a604',
		'1500428',
		$options
	);

	$data['message'] = $message;
	$data['notifications_count'] = $unread_notifications;
	$pusher->trigger('delivisha-noti', 'my-event', $data);
}
