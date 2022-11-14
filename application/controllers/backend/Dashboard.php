<?php

/**
 * @param Description - This file contains methodes for all create read and update logic
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-09-29
 */

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param - This file contains all the functions that run the dashboard page
 */
class Dashboard extends CI_Controller
{
	// Magic function
	public function __construct()
	{
		parent::__construct();
		// Check if the user is logged in
		if (!$this->session->userdata('logged_in')) {
			// Redirect the user to the login page
			redirect('login');
		}
	}

	// This function loads the dashboard landing page
	public function index()
	{
		$data = array(
			'title' => 'Welcome to Delivisha Backend',
		);

		$this->template->load('admin', 'default', 'index', $data);
	}
}
