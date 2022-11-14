<?php

/**
 * @param Description - This file contains methodes for all create read and update logic
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @param Date - 2020-09-29
 */

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param - This file contains all the functions that run the dashboard page
 */
class Authentication extends CI_Controller
{
	// Magic function
	function __construct()
	{
		parent::__construct();
		// Load the user model
		$this->load->model('authentication_model');
	}

	// This function is for logging in users to the system
	function login_users()
	{
		// Check if the incoming request is ajax
		if (!$this->input->is_ajax_request()) {
			// Respond with bad request
			$this->output->set_status_header(400);
			// Return the error message
			echo json_encode(array('status' => 400, 'status' => 'error', 'message' => 'This request is not allowed'));
		}

		// Check if the user is already logged in
		if ($this->session->userdata('logged_in')) {
			// Redirect the user to the dashboard
			redirect('backend/dashboard');
		}
		// Check is the user exists
		$this->authentication_model->check_user_exists();
	}

	function send_otp()
	{
		// Check if the incoming request is ajax
		if (!$this->input->is_ajax_request()) {
			// Respond with bad request
			$this->output->set_status_header(400);
			// Return the error message
			echo json_encode(array('status' => 400, 'status' => 'error', 'message' => 'This request is not allowed'));
		}
		// Check is the user exists
		$this->authentication_model->send_otp_to_user();
	}

	function verify_otp()
	{
		// Check if the incoming request is ajax
		if (!$this->input->is_ajax_request()) {
			// Respond with bad request
			$this->output->set_status_header(400);
			// Return the error message
			echo json_encode(array('status' => 400, 'status' => 'error', 'message' => 'This request is not allowed'));
		}
		// Check is the otp entered is correct
		$this->authentication_model->verify_otp_entered();
	}

	function get_reset_password()
	{
		// Get data from the url
		$user_id = $this->input->get('token');
		$token = $this->input->get('secret');

		// Check if the passed user id is a number
		if (!is_numeric($user_id)) {
			// Send back response
			set_response('error', 'Error', 400, [], 'Invalid user id');
		}
		// Check if the user exists
		$user_data = user_exists($user_id);
		$pageTitle = 'Reset Password Page';
		$pageData = array(
			'title' => $pageTitle,
			'page' => 'reset_password',
			'user_data' => $user_data,
			'user_id' => $user_id,
			'token_validity' => $this->check_token_validity($token, $user_id) ? 1 : 0
		);
		$this->template->load('public', 'default', 'auth/reset_password', $pageData);
	}

	// Function for checking if the token is valid
	function check_token_validity($token, $user_id)
	{
		// Check if the token is valid
		$this->db->select('*');
		$this->db->from('deli_authentication');
		$this->db->where('user_id', $user_id);
		$this->db->where('secret_token', $token);
		$this->db->where('status', 1);
		$query = $this->db->get();
		// Check if the query returned any results
		if ($query->num_rows() > 0) {
			// current date and time
			$current_date = date('Y-m-d H:i:s');
			$saved_date = $query->row()->updated_date;
			// Get the difference between the current time and the updated time
			$diff = strtotime($current_date) - strtotime($saved_date);
			// round it to the nearest minute
			$minutes = round($diff / 60);

			// Check if the difference is greater than 15 minutes
			if ($minutes > 15) { // 15 minutes
				return false;
			} else { // The token is valid
				return true;
			}
			// Return the result
			return true;
		} else {
			// Return false
			return false;
		}
	}

	// Function for resetting the password
	function change_password()
	{
		// Check if the incoming request is ajax
		if (!$this->input->is_ajax_request()) {
			// Respond with bad request
			$this->output->set_status_header(400);
			// Return the error message
			echo json_encode(array('status' => 400, 'status' => 'error', 'message' => 'This request is not allowed'));
		}
		// Check is the user exists
		$this->authentication_model->change_user_password();
	}
}
