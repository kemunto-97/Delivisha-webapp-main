<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @param - This file contains methodes for all order logic
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-09-29
 */
class Order_model extends CI_Model
{
	var $couties_table = 'deli_counties';
	var $regions_table = 'deli_regions';
	var $streets_table = 'deli_streets';
	var $orders_table = 'deli_orders';
	var $customers_table = 'deli_customers';
	var $admins_table = 'deli_admins';

	// This methode is for placing a delivery order
	function place_delivery_order()
	{
		// Verify Google reCAPTCHA
		$response = $this->input->post('g-recaptcha-response');
		$captcha_success = validate_recaptcha($response);

		if ($captcha_success) {
			// Generate a waybill number
			$waybill = $this->generate_waybill();
			// Get the form data
			$sender_id = html_escape(trim($this->input->post('sender_id')));
			$sender_county = html_escape(trim($this->input->post('sender_county')));
			$sender_region = html_escape(trim($this->input->post('sender_region')));
			$sender_street = html_escape(trim($this->input->post('sender_street')));
			$receiver_name = html_escape(trim($this->input->post('receiver_name')));
			$receiver_phone = html_escape(trim($this->input->post('receiver_phone')));
			// $receiver_address = html_escape(trim($this->input->post('receiver_address')));
			$package_type = html_escape($this->input->post('package_types'));
			$package_weight = html_escape(trim($this->input->post('package_weight')));
			// $package_value = html_escape(trim($this->input->post('package_value')));
			$package_description = html_escape(trim($this->input->post('package_description')));
			$package_quantity = html_escape(trim($this->input->post('package_quantity')));
			$package_status = html_escape(trim($this->input->post('package_status')));
			$package_pickup_time = html_escape($this->input->post('package_pickup_time'));
			$delivery_rates = html_escape(trim($this->input->post('total_delivery_rates')));

			// Upload the package image
			$upload = $this->upload_order_image();
			// Check if the image was uploaded
			if ($upload['status'] == 'success') {
				// Get the image name
				$package_image = $upload['image_name'];
			} else {
				// Send back response
				set_response('error', 'Image upload error!', 400, '', $upload['error'], 0, null);
			}

			// prepare data to be sent to the database
			$data = array(
				'waybill_number' => $waybill,
				'customer_id' => $sender_id,
				'county_id' => $sender_county,
				'region_id' => $sender_region,
				'street_id' => $sender_street != '' ? $sender_street : 0,
				'receiver_name' => $receiver_name,
				'receiver_phone' => $receiver_phone,
				// 'receiver_address' => $receiver_address != '' ? $receiver_address : 'N/A',
				'package_type' => $package_type,
				'package_weight' => $package_weight,
				// 'package_value' => $package_value,
				'package_description' => $package_description,
				'package_qty' => $package_quantity,
				'package_status' => $package_status,
				'package_image' => $package_image,
				'package_time' => $package_pickup_time != '' ? $package_pickup_time : '',
				'delivery_cost' => $delivery_rates,
			);

			// Insert the data into the database
			$this->db->insert($this->orders_table, $data);
			// Send sms to customer and admins
			$this->send_sms_to_customer_and_admins($sender_id, $waybill); // Errors not handled
			// Check if the data was inserted
			if ($this->db->affected_rows() > 0) {
				// Get customer name 
				$customer_name = $this->get_customer_name($sender_id);
				// Create a Notification
				$notification_message = 'You have a new order from ' . $customer_name . '. Waybill number: ' . $waybill;
				$notification_title = 'New order!';
				$notification_type = 'orders';

				// Send notification to the admin
				if (createNotification($notification_type, $notification_title, $notification_message)) {
					// Push notification to the admin
					push_notification($notification_message);
					// Send back response
					set_response('success', 'Successfully! order message', 200, '', 'Your order has been placed successfully, you will be notified once it is accepted.', 0, null);
				} else {
					// Send back response
					set_response('error', 'Order placed successfully!', 200, '', 'Something went wrong while trying to place your order, try again later.', 0, null);
				}
			} else {
				// Send back response
				set_response('error', 'Error! order message', 400, '', 'An error occured while placing your order, please try again.', 0, null);
			}
		} else {
			// Send back response
			set_response('error', 'Google reCAPTCHA Error!', 400, '', 'Please verify that you are not a robot by selecting the checkbox below.', 0, null);
		}
	}

	// Send sms to customer and all admins
	function send_sms_to_customer_and_admins($customer_id, $waybill)
	{
		// Get the customer details
		$customer = $this->db->get_where($this->customers_table, array('customer_id' => $customer_id, 'status' => 1))->row();
		// Get the admins
		$admins = $this->db->get_where($this->admins_table, array('status' => 1, 'soft_delete' => 0))->result();
		// Get admin phone numbers array
		$admin_phone_numbers = array();
		foreach ($admins as $admin) {
			$admin_phone_numbers[] = '+254' . $admin->phone;
		}
		// Get the customer phone number
		$customer_phone_number = '+254' . $customer->phone;
		// Get the customer name
		$customer_name = $customer->firstname . ' ' . $customer->lastname;
		// Set the customer message
		$message = get_salute() . ' ' . $customer->firstname . ', your order with waybill number ' . $waybill . ' has been placed successfully. You will be notified once it is accepted. Thank you for choosing Delivisha Express.';
		// set the admin message
		$admin_message = get_salute() . ' Admin, you have a new order with waybill number ' . $waybill . ' from ' . $customer_name . '. Please login to your dashboard to action on the order. Thank you.';
		// Send the message to the customer
		sendMessage($message, $customer_phone_number);
		// loop through the admin phone numbers and send the message to each one
		foreach ($admin_phone_numbers as $admin_phone_number) {
			sendMessage($admin_message, $admin_phone_number);
		}
		return true;
	}

	// Get counties from the database
	function getCounties()
	{
		// Get the counties Nairobi, Kiambu, Machakos
		$this->db->select('*');
		$this->db->from($this->couties_table);
		$this->db->where('in_county', 1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Return the counties
			return $query->result();
		} else {
			// Return false
			return false;
		}
	}

	// Get regions from the database
	function getRegions($county_id)
	{
		// Get the regions
		$this->db->select('*');
		$this->db->from($this->regions_table);
		$this->db->where('county_code', $county_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Return the regions
			return $query->result();
		} else {
			// Return false
			return false;
		}
	}

	// Get the streets data
	function getStreets($region_id)
	{
		// Get the streets
		$this->db->select('*');
		$this->db->from($this->streets_table);
		$this->db->where('region_id', $region_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Return the streets
			return $query->result();
		} else {
			// Return false
			return false;
		}
	}

	// get the house data
	function getHouses($street_id)
	{
		// Get the houses
		$this->db->select('*');
		$this->db->from($this->streets_table);
		$this->db->where('street_id', $street_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Return the houses
			return $query->row()->id;
		} else {
			// Return false
			return false;
		}
	}

	// Generate a waybill number
	function generate_waybill()
	{
		// Get the last waybill number
		$this->db->select('waybill_number');
		$this->db->from($this->orders_table);
		$this->db->order_by('waybill_number', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Get the last waybill number
			$last_waybill = $query->row()->waybill_number;
			// Get the last 4 digits
			$last_four_digits = substr($last_waybill, -4);
			// Convert the last 4 digits to an integer
			$last_four_digits = (int) $last_four_digits;
			// Add 1 to the last 4 digits
			$last_four_digits = $last_four_digits + 1;
			// Convert the last 4 digits to a string
			$last_four_digits = (string) $last_four_digits;
			// Get the length of the last 4 digits
			$last_four_digits_length = strlen($last_four_digits);
			// Check if the length of the last 4 digits is less than 4
			if ($last_four_digits_length < 4) {
				// Get the difference between 4 and the length of the last 4 digits
				$diff = 4 - $last_four_digits_length;
				// Add the difference to the last 4 digits
				for ($i = 0; $i < $diff; $i++) {
					$last_four_digits = '0' . $last_four_digits;
				}
			}
			// Get the first 4 digits
			$first_four_digits = substr($last_waybill, 0, 4);
			// Concatenate the first 4 digits and the last 4 digits
			$waybill = $first_four_digits . $last_four_digits;
			// Return the waybill number
			return $waybill;
		} else {
			// Return the first waybill number
			return '10000001';
		}
	}

	// Upload the package image with codeigniter upload library
	function upload_order_image()
	{
		// Get the image name
		$image_name = $_FILES['package_image']['name'];
		// Get the image size
		$image_size = $_FILES['package_image']['size'];

		// Check if the image name is not empty
		if ($image_name != '') {
			// Get the image extension
			$image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
			// Check if the image extension is jpg, jpeg, png or gif
			if ($image_extension == 'jpg' || $image_extension == 'jpeg' || $image_extension == 'png' || $image_extension == 'gif') {
				// Check if the image size is less than 2MB
				if ($image_size < 2097152) {
					// Set the image path
					$image_path = './uploads/order_imgs/';
					// Set the image config
					$image_config['upload_path'] = $image_path;
					$image_config['allowed_types'] = 'jpg|jpeg|png|gif';
					$image_config['max_size'] = 2097152;
					$image_config['file_name'] = 'Delivisha_pkg_' . time();

					$this->load->library('upload', $image_config);
					$this->upload->initialize($image_config);
					// Upload the image
					if ($this->upload->do_upload('package_image')) {
						// Send back the response
						// set_response('success', 'Success! image upload', 200, ['image_name' => $image_name], 'The image has been uploaded successfully', 1, null);
						$result = array(
							'status' => 'success',
							'image_name' => site_url() . 'uploads/order_imgs/' . $image_name,
						);
						return $result;
					} else {
						// Return a message
						$result = array(
							'status' => 'error',
							'message' => $this->upload->display_errors(),
						);
						return $result;
					}
				} else {
					// Return a message
					$result = array(
						'status' => 'error',
						'message' => 'The image size is too large',
					);
					return $result;
				}
			} else {
				// Return a message
				$result = array(
					'status' => 'error',
					'message' => 'The image extension is not allowed',
				);
				return $result;
			}
		} else {
			// Return a message
			$result = array(
				'status' => 'error',
				'message' => 'Please select an image',
			);
			return $result;
		}
	}

	// This function is for tracking the order
	function track_delivery_order()
	{
		// Get data from the form
		$waybill_number = html_escape($this->input->post('waybill_number'));
		// Check if the waybill number is correct
		$this->db->where('waybill_number', $waybill_number);
		$query = $this->db->get($this->orders_table)->num_rows();
		// Check if the waybill number is correct
		if ($query > 0) {
			// Get the order details
			$this->db->where('waybill_number', $waybill_number);
			$query = $this->db->get($this->orders_table);
			$order_details = $query->row();
			// Get the customer details
			$customer_details = $this->get_customer_details($order_details->customer_id);
			// Redirect url
			$redirect_url = site_url() . 'order_tracking?waybill_number=' . $waybill_number . '&customer=' . $order_details->customer_id;
			// Send back the response
			set_response('success', 'Success! order details', 200, [], 'Hello ' . $customer_details->firstname . ' ' . $customer_details->lastname . ', your order details has been fetched successfully 😉', 1, $redirect_url);
		} else {
			// Send back the response
			set_response('error', 'Error! waybill number', 400, null, 'The waybill number provided "' . $waybill_number . '" is incorrect. Check the SMS we sent you after you placed your order for your correct waybill number.', 0, null);
		}
	}

	// This function is for getting customer details
	function get_customer_details($customer_id)
	{
		// Get the customer details
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get($this->customers_table);
		$customer_details = $query->row();
		// Return the customer details
		return $customer_details;
	}

	// This function is for getting the order details
	function get_order_details($trackingNumber, $customerId)
	{
		// Get the order details
		$this->db->where('waybill_number', $trackingNumber);
		$this->db->where('customer_id', $customerId);
		$query = $this->db->get($this->orders_table);
		$order_details = $query->row();
		// Return the order details
		return $order_details;
	}

	function get_customer_name($customer_id)
	{
		// Get the customer details
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get($this->customers_table);
		$customer_details = $query->row();
		// Return the customer name
		return $customer_details->firstname . ' ' . $customer_details->lastname;
	}
}
