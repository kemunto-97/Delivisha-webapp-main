<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param Description - This file contains methodes for all create read and update logic
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-10-13
 */
class Crud_model extends CI_Model
{
	var $contact_table = 'deli_contacts';
	var $shipping_table = 'deli_shipping_amount';
	var $chatbot_table = 'deli_chatbot';
	var $calculation_table = 'deli_calculations';

	// This function inserts the contact data into the database and returns the id
	function createMessage($data)
	{
		$this->db->insert($this->contact_table, $data);
		return $this->db->insert_id();
	}

	function getTotalShippingPrice()
	{
		// Get data from ajax request
		$pkg_weight = $this->input->post('package_weight');
		$pkg_type = $this->input->post('package_type');
		$pkg_status = $this->input->post('package_status');
		$pkg_quantity = $this->input->post('package_quantity');

		// Calculate shipping fee
		if ($shipping_fee = calculate_shipping($pkg_weight, $pkg_quantity, $pkg_type, $pkg_status)) {
			// Send back the response
			set_response('success', 'Shipping fee calculated successfully!', 200, ['shipping_fee' => $shipping_fee], 'Shipping calculations done successfully', 1, null);
		} else {
			// Send back the response
			set_response('error', 'Shipping fee calculation failed!', 400, null, 'Shipping calculations failed, try again later.', 0, null);
		}
	}

	// This function is for getting the shipping fee for package_types, package_weight, package_weight and package_quantity is the checkbox input is checked
	function getShippingFee()
	{
		// Get the package type
		$package_type = $this->input->post('package_types');
		// Get the package weight
		$package_weight = $this->input->post('package_weight');
		// Get the package quantity
		$package_status = $this->input->post('package_status');
		// Get the package quantity
		$package_qty = $this->input->post('package_quantity');
		// Get the checkbox value
		$checkbox = $this->input->post('ship__bulk');

		// check if the package input is checked
		if (isset($checkbox)) {
			// Validate all inputs
			$this->form_validation->set_rules('package_types', 'Package Type', 'required', ['required' => 'Please select a package type to continue!']);
			$this->form_validation->set_rules('package_weight', 'Package Weight', 'required', ['required' => 'Please select a package weight to continue!']);
			$this->form_validation->set_rules('package_quantity', 'Package Quantity', 'required', ['required' => 'Please select a package quantity to continue!']);
			$this->form_validation->set_rules('package_status', 'Package Status', 'required', ['required' => 'Please select a package status to continue!']);

			// Check if the form validation is false
			if ($this->form_validation->run() == false) {
				// Prepare validation messages
				$validation_errors = [
					'package_types' => form_error('package_types'),
					'package_weight' => form_error('package_weight'),
					'package_quantity' => form_error('package_quantity'),
					'package_status' => form_error('package_status'),
				];
				// Send back the response
				set_response('error', 'Validation errors!', 403, $validation_errors, 'validation errors from the form inputs', 0, null);
			} else {
				// Calculate the shipping
				if ($shippingResult = calculate_shipping($package_weight, $package_qty, $package_type, $package_status)) {
					// Prepare data
					$data = [
						'package_type' => $package_type,
						'package_weight' => $package_weight,
						'package_quantity' => $package_qty,
						'package_status' => $package_status,
						'shipping_fee' => $shippingResult,
						'calculation_date' => date('Y-m-d H:i:s'),
					];
					// Insert the data into the database
					if ($this->db->insert($this->calculation_table, $data)) {
						// Send back the response
						set_response('success', 'Shipping fee calculated successfully!', 200, $data, 'Shipping fee calculated successfully!', 1, null);
					} else {
						// Send back the response
						set_response('error', 'Error calculating shipping fee!', 500, null, 'Error calculating shipping fee!', 0, null);
					}
				} else {
					// Send back the response
					set_response('error', 'Error calculating shipping fee!', 500, null, 'Something went wrong while trying to connect to the server, please try again later.', 0, null);
				}
			}
		} else {
			// Validate only the package type, package status and package weight
			$this->form_validation->set_rules('package_types', 'Package Type', 'required', ['required' => 'Please select a package type to continue!']);
			$this->form_validation->set_rules('package_weight', 'Package Weight', 'required', ['required' => 'Please select a package weight to continue!']);
			$this->form_validation->set_rules('package_status', 'Package Status', 'required', ['required' => 'Please select a package status to continue!']);

			// Check if the form validation is false
			if ($this->form_validation->run() == false) {
				// Prepare validation messages
				$validation_errors = [
					'package_types' => form_error('package_types'),
					'package_weight' => form_error('package_weight'),
					'package_status' => form_error('package_status'),
				];
				// Send back the response
				set_response('error', 'Validation errors!', 403, $validation_errors, 'validation errors from the form inputs', 0, null);
			} else {
				// Calculate the shipping
				if ($shippingResult = calculate_shipping($package_weight, 1, $package_type, $package_status)) {
					// Prepare data
					$data = [
						'package_type' => $package_type,
						'package_weight' => $package_weight,
						'package_status' => $package_status,
						'package_quantity' => 1,
						'shipping_fee' => $shippingResult,
						'calculation_date' => date('Y-m-d H:i:s'),
					];
					// Insert the data into the database
					if ($this->db->insert($this->calculation_table, $data)) {
						// Send back the response
						set_response('success', 'Shipping fee calculated successfully!', 200, $data, 'Shipping fee calculated successfully!', 1, null);
					} else {
						// Send back the response
						set_response('error', 'Error calculating shipping fee!', 500, null, 'Error calculating shipping fee!', 0, null);
					}
				} else {
					// Send back the response
					set_response('error', 'Shipping fee not calculated!', 403, null, 'Something went wrong while trying to connect to the server, please try again later.', 0, null);
				}
			}
		}
	}

	// This function is for sending the email to the admin
	function sendEmail()
	{
		// Verify Google reCAPTCHA
		$response = $this->input->post('g-recaptcha-response');
		$captcha_success = validate_recaptcha($response);

		if ($captcha_success) {
			// Get data from the form inputs and sanitize
			$data = array(
				'full_name' => html_escape(trim($this->input->post('customer_name'))),
				'email_address' => html_escape(trim($this->input->post('email'))),
				'phone_number' => html_escape(trim($this->input->post('phone'))),
				'subject' => html_escape(trim($this->input->post('subject'))),
				'message' => html_escape(trim($this->input->post('message')))
			);
			// Call the model and pass data to it
			$response = $this->Crud_model->createMessage($data);
			// Save notification
			save_email_notification($response);
			// Send back the response
			set_response('success', 'Message sent!', 200, '', 'Message sent successfully', 1, null);
		} else {
			// Send back the response
			set_response('error', 'Message not sent!', 400, '', 'Message not sent, please try again', 0, null);
		}
	}

	// Function for submiting chatbot data
	function submitChatbotConversation()
	{
		// Get data from the form inputs and sanitize
		$data = array(
			'name' => html_escape($this->input->post('name')),
			'email' => html_escape($this->input->post('email')),
			'phone' => html_escape($this->input->post('phone')) != NULL ? html_escape($this->input->post('phone')) : html_escape($this->input->post('phone2')),
			'bussiness' => html_escape($this->input->post('bussiness')) != NULL ? html_escape($this->input->post('bussiness')) : '',
			'partner' => html_escape($this->input->post('partner')) != NULL ? html_escape($this->input->post('partner')) : '',
			'vendor_thought' => html_escape($this->input->post('vendor_thought')) != NULL ? html_escape($this->input->post('vendor_thought')) : '',
			'rider_thought' => html_escape($this->input->post('rider_thought')) != NULL ? html_escape($this->input->post('rider_thought')) : '',
			'reaction' => html_escape($this->input->post('reaction')) != NULL ? html_escape($this->input->post('reaction')) : '',
			'reaction2' => html_escape($this->input->post('reaction2')) != NULL ? html_escape($this->input->post('reaction2')) : '',
		);
		// Call the model and pass data to it
		if ($chat_id = $this->createBotMessage($data)) {
			// Save notification
			$notification_message = 'Chatbot conversation from ' . $data['name'] . ' with email ' . $data['email'] . ' and phone number ' . $data['phone'];
			$notification_type = 'chatbot';
			$notification_title = 'Chatbot conversation';
			// Create a notification
			if (createNotification($notification_type, $notification_title, $notification_message)) {
				// Send back the response
				set_response('success', 'Message sent!', 200, '', 'Thank you for taking your time to chat with me, this was fun hope we do this again some time.', 1, null);
			}
		} else {
			// Send back the response
			set_response('error', 'Message not sent!', 400, '', 'I am unable to reach one of delivisha service providers, we can try this some time later thank you.', 0, null);
		}
	}

	// Function for submiting chatbot data
	function createBotMessage($data)
	{
		$this->db->insert($this->chatbot_table, $data);
		return $this->db->insert_id();
	}
}
