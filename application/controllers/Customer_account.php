<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param Description - This file contains methodes for loading and passing data to pages and views
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @param Date - 2020-10-21
 */
class Customer_account extends CI_Controller
{
	// Private variables
	private $googleRecaptchaConfig;

	// Constructor
	public function __construct()
	{
		parent::__construct();
		// Load models
		$this->load->model(array('Order_model', 'Crud_model'));
		// Load the captcha config
		$this->googleRecaptchaConfig = $this->config->item('google_recaptcha_secret_key');
		// Check if the user is logged in
		if (!$this->session->userdata('logged_in')) {
			// Redirect to the login page
			redirect('/');
		}
	}

	// Function for loading the customer accounts page
	public function index()
	{
		// Send the data to the view
		$data = array(
			'title' => 'Customer accounts',
			'page' => 'account',
			'captcha_key' => $this->googleRecaptchaConfig
		);
		// Load the view
		$this->template->load('public', 'default', 'account/index', $data);
	}
}
