<?php

/**
 * @package Codeigniter Rest API Modal Class
 * @param Author: Dennis Otieno
 * @param Email: otienodennis29@gmail.com
 * @param date 2022-09-18
 * @param Description: This is a modal class has all the methodes to interact with the database for the api section.
 * @version 1.0
 */

class Api_model extends CI_Model
{
	// Database table name
	private $userTable = 'deli_api_users';
	private $userTokenTable = 'deli_auth_tokens';

	function registerApiUser()
	{
		// Get csrf token
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		// Generate random user id
		$userId = uniqid();
		// Get the post data
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$companyName = $this->input->post('company_name');

		// Run validation on the post data
		$this->form_validation->set_rules('username', 'Name', 'required', array('required' => 'Please enter your username or company name'));
		$this->form_validation->set_rules('email', 'Email', 'required', array('required' => 'Please enter your email address or company email address'));
		$this->form_validation->set_rules('password', 'Pasword', 'required', array('required' => 'Please enter your password or company password'));
		$this->form_validation->set_rules('company_name', 'Company Name', 'required, min_length[3]', array('required' => 'Please provide your company name', 'min_length' => 'Company name must be at least 3 characters long'));

		// Check if the validation is successful
		if ($this->form_validation->run()) {
			// Check if the user already exists
			$checkUser = $this->db->get_where($this->userTable, array('email' => $email));
			if ($checkUser->num_rows() > 0) {
				$response = array(
					'status' => false,
					'message' => 'User already exists',
					'data' => []
				);
				return $response;
			} else {
				// Hash the password
				$password = hash_password($password);

				// Insert user data in the database
				$data = array(
					'user_id' => $userId,
					'username' => $username,
					'email' => $email,
					'secret_key' => generate_secret_token(),
					'password' => sha1($password),
					'company_name' => $companyName,
				);
				// insert the user data into the database and Check if the user was inserted
				if ($insert = $this->db->insert($this->userTable, $data)) {
					// Get the user data
					$user = $this->db->get_where($this->userTable, array('user_id' => $userId))->row();
					$data = array();
					$data['user_id'] = $user->user_id;
					$data['username'] = $user->username;
					$data['email'] = $user->email;
					$data['secret_key'] = $user->secret_key;
					$data['company_name'] = $user->company_name;
					$data['created_at'] = $user->created_at;
					$data['ci_token_hash'] = $csrf['hash'];

					// Prepare the response
					$response = array(
						'status' => true,
						'message' => 'User registered successfully',
						'data' => $data
					);
					return $response;
				} else {
					$data = array();
					$data['ci_token_hash'] = $csrf['hash'];
					// Prepare the response
					$response = array(
						'status' => 'error',
						'message' => 'Failed to register user please try again',
						'data' => []
					);
					return $response;
				}
			}
		} else {
			// Return the response
			$responseData = array(
				'status' => false,
				'message' => 'fill all the required fields',
				'data' => []
			);
			return $responseData;
		}
	}

	function checkLogin($data)
	{
		$this->db->where($data);
		$query = $this->db->get('users');
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getProfile($userId)
	{
		$this->db->select('name,email');
		$this->db->where(['id' => $userId]);
		$query = $this->db->get('users');
		return $query->row();
	}
}
