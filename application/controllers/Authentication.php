<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param - This file runs all the authentication functions for the login and registration
 * @author - Dennis Otieno
 * @param - 2019-10-10
 * @param Description - This file runs all the authentication functions for the login and registration
 * @method - csrf_token_generator - Generates a csrf token for all the requests sent to the server
 */
class Authentication extends CI_Controller
{
	// Ptivate variables
	private $googleRecaptchaConfig;

	// Constructor
	public function __construct()
	{
		parent::__construct();
		// Load the model
		$this->load->model('Authentication_model');
		// Load the captcha config
		$this->googleRecaptchaConfig = $this->config->item('google_recaptcha_secret_key');
	}

	// This functions loads the login page
	public function index()
	{
		// Check if the user is already logged in
		if ($this->session->userdata('logged_in') == true && $this->session->userdata('user_type') == 'admin') {
			// Redirect the user to the dashboard
			redirect('admin');
		} else if ($this->session->userdata('logged_in') == true && $this->session->userdata('user_type') == 'vendor') {
			// Redirect the user to the dashboard
			redirect('vendor');
		} else if ($this->session->userdata('logged_in') == true && $this->session->userdata('user_type') == 'driver') {
			// Redirect the user to the dashboard
			redirect('driver');
		}

		$data = array(
			'title' => 'Provide your credentials',
			'page' => 'login',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		$this->template->load('public', 'default', 'auth/login', $data);
	}

	// This function loads the registration page
	public function registration()
	{
		$this->template->load('public', 'default', 'auth/signup');
	}

	// This function validates the OTP code from the customer
	public function submit_otp()
	{
		// Compare the code
		$response = $this->Authentication_model->validate_otp();
		// Return the response
		echo json_encode($response);
	}

	// Function signing in users
	public function login()
	{
		// 
	}

	// Function for registering new customers
	public function customer_registration()
	{
		// Check if request is AJAX
		if (!$this->input->is_ajax_request()) {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
		// create a new customer
		$response = $this->Authentication_model->customer_registration();
		// Send back json data
		echo json_encode($response);
	}

	// Another function for registering new customers
	public function new_customer_registration()
	{
		// Check if request is AJAX
		if (!$this->input->is_ajax_request()) {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
		// Create new customer
		$response = $this->Authentication_model->createNewCustomer();
		// Send back json data
		echo json_encode($response);
	}

	// Function for logging out customers
	public function logout()
	{
		// Logout the user
		$this->session->sess_destroy();
		// redirect back
		redirect(base_url());
	}

	// Function for validating customer phone number
	public function validatePhoneNumber()
	{
		// check if the phone number is already registered
		$response = $this->Authentication_model->validatePhoneNumber();
		// Send back json data
		echo json_encode($response);
	}

	/**
	 * ====================================================================================================
	 * 					This section contains all the functions for Customer Login
	 * ====================================================================================================
	 */

	// Function for validating customer phone number
	public function validateCustomerPhoneNumber()
	{
		// check if the request is ajax
		if (!$this->input->is_ajax_request()) {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
		// check if the phone number is already registered
		$response = $this->Authentication_model->validateExistingCustomer();
		// Send back json data
		echo json_encode($response);
	}

	// Function validate customer OTP
	public function verify_ustomer_otp()
	{
		// check if the request is ajax
		if (!$this->input->is_ajax_request()) {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
		// check if the phone number is already registered
		$response = $this->Authentication_model->validateCustomerOTP();
		// Send back json data
		echo json_encode($response);
	}
}
