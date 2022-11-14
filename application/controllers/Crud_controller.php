<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param Description - This file contains methodes for loading all the front pages
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-10-16
 */
class Crud_controller extends CI_Controller
{
	// Constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('Crud_model');
	}

	// Get all the shipping records from the database
	function getShippingRecords()
	{
		// Check is the request is an ajax request
		if ($this->input->is_ajax_request()) {
			// Get the shipping records from the database
			$this->Crud_model->getShippingFee();
		} else {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request!']));
			return;
		}
	}

	function get_total_shipping_price()
	{
		// Check is the request is an ajax request
		if ($this->input->is_ajax_request()) {
			// Get the shipping records from the database
			$this->Crud_model->getTotalShippingPrice();
		} else {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request!']));
			return;
		}
	}
}
