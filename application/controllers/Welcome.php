<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param Description - This file contains methodes for loading and passing data to pages and views
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-09-29
 */
class Welcome extends CI_Controller
{
	// Private variables
	private $googleRecaptchaConfig;

	// Constructor
	function __construct()
	{
		parent::__construct();
		// Load models
		$this->load->model(array('Order_model', 'Crud_model'));
		// Load the captcha config
		$this->googleRecaptchaConfig = $this->config->item('google_recaptcha_secret_key');
	}

	// Function for loading the landing page
	function index()
	{
		// Send the data to the view
		$data = array(
			'title' => 'Welcome to Delivisha logistics',
			'page' => 'home',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		// Load the view
		$this->template->load('public', 'default', 'index', $data);
	}

	// This function id for loading shops page
	function shops()
	{
		// Send the data to the view
		$data = array(
			'title' => 'Delivisha Shops for quick accessiblity of your products',
			'page' => 'shops',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		// Load the view
		$this->template->load('public', 'default', 'shops/index', $data);
	}

	// Function for loading tracking page
	function tracking()
	{
		// Get data from the request
		$trackingNumber = $this->input->get('waybill_number');
		$customerId = $this->input->get('customer');
		// Check if the tracking number and customer id are set
		if (isset($trackingNumber) && isset($customerId)) {
			// Get the order details
			$orderDetails = $this->Order_model->get_order_details($trackingNumber, $customerId);
			// Check if the order exists
			if ($orderDetails) {
				// Send the data to the view
				$data = array(
					'title' => 'Track your order',
					'page' => 'tracking',
					'orderDetails' => $orderDetails,
					'captcha_key' => $this->googleRecaptchaConfig
				);
				// Load the view
				$this->template->load('public', 'default', 'tracking/index', $data);
			}
		} else {
			// Send back the response
			set_response('error', 'Invalid request!', 400, '', 'Invalid request!', 0, null);
		}
	}

	// Function for loading products page
	function products()
	{
		// Send the data to the view
		$data = array(
			'title' => 'Delivisha Products',
			'page' => 'products',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		// Load the view
		$this->template->load('public', 'default', 'shops/products/index', $data);
	}

	// Function for loading contact page
	function contact()
	{
		// Send data to the view
		$data = array(
			'title' => 'Talk to us, let us know how we can help.',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		// Load the view
		$this->template->load('public', 'default', 'contact/index', $data);
	}

	// This function is for sending message to the backend
	function send_message()
	{
		// Check if request is AJAX
		if (!$this->input->is_ajax_request()) {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
		// Get csrf token
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash(),
		);
		// Call the Crud_model and pass data to it
		$response = $this->Crud_model->sendEmail();
		// Check if response is true
		if ($response['status'] == 'success') {
			// Return response
			$message = array(
				'status' => 'success',
				'title' => $response['title'],
				'message' => $response['message'],
				'csrf' => $csrf
			);
			// Set the response and exit
			echo json_encode($message);
		} else {
			// Return response
			$message = array(
				'status' => 'error',
				'title' => $response['title'],
				'message' => $response['message'],
				'csrf' => $csrf
			);
			// Set the response and exit
			echo json_encode($message);
		}
	}

	// Function for loading orders page
	function orders()
	{
		// Check if the user is logged in
		if (!$this->session->userdata('logged_in')) {
			// Redirect to the login page
			redirect(base_url());
		}
		// Send data to the view
		$data = array(
			'title' => 'Place your order and get it delivered',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		// Load the view
		$this->template->load('public', 'default', 'orders/index', $data);
	}

	// Function for submiting chatbot data
	function submit_chatbot_conversation()
	{
		// Check if request is AJAX
		if (!$this->input->is_ajax_request()) {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
		// Call the Crud_model and pass data to it
		$response = $this->Crud_model->submitChatbotConversation();
	}
}
