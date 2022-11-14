<?php

/**
 * @param Description - This file contains methods for all create read and update logic for the api
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @param Date - 2020-10-18
 */

class Auth_Controller extends RestApi_Controller
{
	function __construct()
	{
		parent::__construct();
		// Load the api_auth library
		$this->load->library('api_auth');
		// Load the user model
		$this->load->model('api_model');
	}

	function register()
	{
		// Send data to the model and get the response
		$response = $this->api_model->registerApiUser();
		// Check the response status
		if ($response['status'] == true) {
			// Set the response and exit
			$this->response($response, 200);
			return;
		} elseif ($response['status'] == 'error') {
			// Set the response and exit
			$this->response($response, 403);
			return;
		} else {
			// Set the response and exit
			$this->response($response);
			return;
		}
	}

	function login()
	{

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Pasword', 'required');
		if ($this->form_validation->run()) {
			$data = array('email' => $email, 'password' => sha1($password));
			$loginStatus = $this->api_model->checkLogin($data);
			if ($loginStatus != false) {
				$userId = $loginStatus->id;
				$bearerToken = $this->api_auth->generateToken($userId);
				$responseData = array(
					'status' => true,
					'message' => 'Successfully Logged In',
					'token' => $bearerToken,
				);
				return $this->response($responseData, 200);
			} else {
				$responseData = array(
					'status' => false,
					'message' => 'Invalid Crendentials',
					'data' => []
				);
				return $this->response($responseData);
			}
		} else {
			$responseData = array(
				'status' => false,
				'message' => 'Email Id and password is required',
				'data' => []
			);
			return $this->response($responseData);
		}
	}
}
