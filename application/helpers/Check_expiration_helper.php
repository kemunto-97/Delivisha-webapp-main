<?php

/**
 * @param - This file contains methode for checking if verification code has expired
 * @author - Dennis Otieno
 */
function checkExpirationTime($updatedTime)
{
	// Get the current time
	$timestamp = date('Y-m-d H:i:s');
	// Get the saved time in the database
	$updated_date = $updatedTime;
	// Get the difference between the current time and the updated time
	$diff = strtotime($timestamp) - strtotime($updated_date);
	// round it to the nearest minute
	$minutes = round($diff / 60);

	// Check if the difference is greater than 15 minutes
	if ($minutes > 15) { // The OTP is expired
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Error! OTP Expired.',
			'message' => 'The OTP you entered has expired please request for a new one.',
		);
		return $result;
	} else { // The OTP is not expired
		// Return a message
		$result = array(
			'status' => 'success',
		);
		return $result;
	}
}

// This function is for checking login attempts
function loginAttempts($database, $phone)
{
	// Get the ci instance
	$ci = &get_instance();
	// Load the database
	$ci->load->database();
	// Get the csrf token
	$csrf = array(
		'name' => $ci->security->get_csrf_token_name(),
		'hash' => $ci->security->get_csrf_hash(),
	);
	// Get the login attempts from the database
	$ci->db->select('login_attempts');
	$ci->db->from($database);
	$ci->db->where('phone', $phone);
	$query = $ci->db->get();
	$login_attempts = $query->row();
	// Check if the login attempts are greater than 3	
	if ($login_attempts->login_attempts == 0) {
		// add 1 to the login attempts
		$login_attempts = $login_attempts->login_attempts + 1;
		// update the login attempts
		$ci->db->set('login_attempts', $login_attempts);
		$ci->db->where('phone', $phone);
		$ci->db->update($database);
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Login attempts 1',
			'attempts' => $login_attempts,
			'message' => 'Wrong email or password, you have 2 more attempts before your account is locked',
			'token' => $csrf['hash'],
		);
		echo json_encode($result);
	} elseif ($login_attempts->login_attempts == 1) {
		// add 1 to the login attempts
		$login_attempts = $login_attempts->login_attempts + 1;
		// update the login attempts
		$ci->db->set('login_attempts', $login_attempts);
		$ci->db->where('phone', $phone);
		$ci->db->update($database);
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Login attempts 2',
			'attempts' => $login_attempts,
			'message' => 'Wrong email or password, you have 1 login attempts left before your account is locked',
			'token' => $csrf['hash'],
		);
		echo json_encode($result);
	} elseif ($login_attempts->login_attempts == 2) {
		// add 1 to the login attempts
		$login_attempts = $login_attempts->login_attempts + 1;
		// update the login attempts
		$ci->db->set('login_attempts', $login_attempts);
		$ci->db->where('phone', $phone);
		$ci->db->update($database);
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Login attempts 3',
			'attempts' => $login_attempts,
			'message' => 'This is your last chance, your account will be locked after this',
			'token' => $csrf['hash'],
		);
		echo json_encode($result);
	} elseif ($login_attempts->login_attempts >= 3) {
		// Update the status to locked
		$ci->db->set('status', 0);
		$ci->db->where('phone', $phone);
		$ci->db->update($database);
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Login attempts exceeded',
			'message' => 'You have exceeded the maximum number of login attempts please contact Delivisha for assistance. Your account has been locked for security reasons <i class="fa fa-lock"></i>',
			'token' => $csrf['hash'],
		);
		echo json_encode($result);
	} else {
		// Return a message
		return false;
	}
}

// This function clears the login attempts
function resetLoginAttempts($database, $phone)
{
	// Get the ci instance
	$ci = &get_instance();
	// Load the database
	$ci->load->database();
	// Clear the login attempts
	$ci->db->set('login_attempts', 0);
	$ci->db->where('phone', $phone);
	$ci->db->update($database);
	// return
	return true;
}

// This function is for generating OTP
function generateOTP()
{
	// Get the ci instance
	$ci = &get_instance();
	// Load the database
	$ci->load->database();
	// Generate a random number
	$otp = rand(100000, 999999);
	return $otp;
}
