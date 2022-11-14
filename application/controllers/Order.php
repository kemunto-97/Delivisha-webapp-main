<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param - This file contains methodes for all orders scripts
 * @author - Dennis Otieno
 */
class Order extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Load the model
		$this->load->model('Order_model');
	}

	// This methode is for placing a delivery order
	public function place_delivery_order()
	{
		// check if the request is ajax
		if (!$this->input->is_ajax_request()) {
			// Send order to the order model
			set_response('error', 'Invalid request!', 400, '', 'Invalid request!', 0, null);
		}
		// Place the customers order
		$this->Order_model->place_delivery_order();
	}

	// Get counties from the database
	public function get_counties()
	{
		// check if the request is ajax
		if ($this->input->is_ajax_request()) {
			// Get the counties
			$counties = $this->Order_model->getCounties();

			// Return the counties
			echo json_encode($counties);
		} else {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
	}

	// Get regions from the database
	public function get_regions($county_id)
	{
		// check if the request is ajax
		if ($this->input->is_ajax_request()) {
			// Get the regions
			$regions = $this->Order_model->getRegions($county_id);

			// Return the regions
			echo json_encode($regions);
		} else {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
	}

	// Get the streets data
	public function get_streets($region_id)
	{
		// check if the request is ajax
		if ($this->input->is_ajax_request()) {
			// Get the streets
			$streets = $this->Order_model->getStreets($region_id);

			// Return the streets
			echo json_encode($streets);
		} else {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
	}

	// Get the houses data
	public function get_houses($street_id)
	{
		// check if the request is ajax
		if ($this->input->is_ajax_request()) {
			// Get the houses
			$houses = $this->Order_model->getHouses($street_id);

			// Return the houses
			echo json_encode($houses);
		} else {
			// Set the response and exit
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Bad request']));
			return;
		}
	}
}
