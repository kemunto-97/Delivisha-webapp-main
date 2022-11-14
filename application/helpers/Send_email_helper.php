<?php

/**
 * @author - Dennis Otieno
 * @param Date - 2022-10-10
 * @param Description - This file contains helper-methode for sending system generated emails
 */
function sendOtpEmail($email, $subject, $title, $otp, $message)
{
	// initioalize ci
	$ci = get_instance();
	// Load email config
	$ci->load->config('email');
	// Load the email library
	$ci->load->library('email');
	// Load the database
	$ci->load->database();
	// Email from 
	$from = $ci->config->item('smtp_user');
	// Sender email address
	$ci->email->from($from, $title);
	// Receiver email address
	$ci->email->to($email);
	// Subject of email
	$ci->email->subject($subject);
	// Message in email
	$ci->email->message($message);

	// Check if email was sent
	if ($ci->email->send()) {
		// Get the current time stamp
		$timestamp = date('Y-m-d H:i:s');
		// Update the database with OTP
		$ci->db->set('otp', $otp);
		$ci->db->set('updated_date', $timestamp);
		$ci->db->where('email', $email);
		$ci->db->update('deli_customers');

		// Return a message
		$result = array(
			'status' => 'success',
			'message' => 'OTP sent to your email address' . $email . ' please check for the six digit code',
		);
		return $result;
	} else {
		// Return a message
		$result = array(
			'status' => 'error',
			'message' => 'Email not sent, something went wrong please try again later',
		);
		return $result;
	}
}

// This function is for sending OTP to the users email address
function sendOtpToUserEmail($email, $subject, $title, $otp, $message)
{
	// initioalize ci
	$ci = get_instance();
	// Load the email config
	$ci->load->config('email');
	// Load the email library
	$ci->load->library('email');
	// Load the database
	$ci->load->database();
	// Get csrf token
	$csrf = array(
		'name' => $ci->security->get_csrf_token_name(),
		'hash' => $ci->security->get_csrf_hash(),
	);
	// Load the email host
	$email_from = $ci->config->item('smtp_user');
	// Sender email address
	$ci->email->from($email_from, $title);
	// Receiver email address
	$ci->email->to($email);
	// Subject of email
	$ci->email->subject($subject);
	// Message in email
	$ci->email->message($message);
	// Check if email was sent
	if ($ci->email->send()) {
		// Get the current time stamp
		$timestamp = date('Y-m-d H:i:s');
		// Update the database with OTP
		$ci->db->set('otp', $otp);
		$ci->db->set('updated_date', $timestamp);
		$ci->db->where('email', $email);
		$ci->db->update('deli_authentication');

		// Return a message
		$result = array(
			'status' => 'success',
			'title' => 'OTP sent to your email address',
			'message' => 'OTP sent to your email address' . $email . ' please check for the six digit code',
			'token' => $csrf['hash'],
		);
		echo json_encode($result);
	} else {
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Email not sent',
			'message' => 'Email not sent, something went wrong please try again later',
			'token' => $csrf['hash'],
		);
		echo json_encode($result);
	}
}

// This function is for sending user welcomeing email after registration of account
function sendWelcomingEmail($email, $subject, $title, $message)
{
	// Get ci instance
	$ci = get_instance();
	// Load the email config
	$ci->load->config('email');
	// Load the email library
	$ci->load->library('email');
	// Load the databse
	$ci->load->database();
	// Load the email host
	$email_from = $ci->config->item('smtp_user');
	// Sender email address
	$ci->email->from($email_from, $title);
	// Receiver email address
	$ci->email->to($email);
	// Subject of email
	$ci->email->subject($subject);
	// Message in email
	$ci->email->message($message);
	// Check if email was sent
	if ($ci->email->send()) {
		// Return a message
		$result = array(
			'status' => 'success',
			'title' => 'Success! Customer created',
			'message' => 'Your account has been created successfully, welcome to Delivisha',
		);
		return $result;
	} else {
		// Return a message
		$result = array(
			'status' => 'error',
			'title' => 'Email not sent',
			'message' => 'Email not sent, something went wrong please try again later',
		);
		return $result;
	}
}
