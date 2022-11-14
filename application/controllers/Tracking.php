<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param - This file contains methodes for all orders scripts
 * @author - Dennis Otieno
 */
class Tracking extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// Load the model
		$this->load->model('Order_model');
	}

	// This methode is for tracking a delivery order
	function track_delivery_order()
	{
		// check if the request is ajax
		if (!$this->input->is_ajax_request()) {
			// Send order to the order model
			set_response('error', 'Invalid request!', 400, '', 'Invalid request!', 0, null);
		}
		// Place the customers order
		$this->Order_model->track_delivery_order();
	}
}
