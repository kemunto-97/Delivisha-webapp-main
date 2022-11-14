<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @param Description - This file contains methodes for customers logic
 * @date - 2020-10-01
 */
class Authentication_model extends CI_Model
{
	var $customers_table = 'deli_customers';
	var $users_table = 'deli_authentication';
	var $admins_table = 'deli_admins';

	// Function for registering new customers
	public function customer_registration()
	{
		// Get the form data
		$first_name = html_escape($this->input->post('first_name'));
		$last_name = html_escape($this->input->post('last_name'));
		$email = html_escape($this->input->post('emailAddress'));
		$phone = html_escape($this->input->post('phoneNumber'));

		// Check if the email or phone is already registered
		$this->db->select('*');
		$this->db->from($this->customers_table);
		$this->db->where('email', $email);
		$this->db->or_where('phone', $phone);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Return a response
			set_response('error', 'Error', 400, '', 'The email or phone number is already registered', null, null);
		} else {
			// Generate a randon code
			$code = rand(100000, 999999);

			// set data to array
			$data = array(
				'customer_id' => $code,
				'firstname' => $first_name,
				'lastname' => $last_name,
				'email' => $email,
				'phone' => $phone,
				'status' => 1,
			);

			// Insert the data to the database
			if ($this->db->insert_id($this->customers_table, $data)) {
				// Create a notification
				$notification_message = 'New customer ' . $first_name . ' ' . $last_name . ' has been registered with the email ' . $email . ' and phone number ' . $phone;
				$notification_type = 'customer';
				$notification_title = 'New customer';
				// Create a notification
				if (createNotification($notification_type, $notification_title, $notification_message)) {
					// Return a response
					$email_title = 'Delivisha Logistics';
					$subject = 'Delivisha Welcoming Message';
					$email_data = [
						'username' => $first_name . ' ' . $last_name
					];
					$message = $this->load->view('email_templates/delivisha_welcome_email', $email_data, true);
					// Send email
					$result = sendWelcomingEmail($email, $subject, $email_title, $message);
					// Return a response
					set_response($result['status'], $result['title'], 200, '', $result['message'], 1, null);
				} else {
					// Return a response
					set_response('error', 'Error', 400, '', 'Something went wrong while trying to register your details, try again later!', null, null);
				}
			} else {
				// Return a response
				set_response('error', 'Error', 400, '', 'There was an error registering the customer', null, null);
			}
		}
	}

	// Check if the phone number is registered *Pending
	public function validatePhoneNumber()
	{
		// Get the provided phone number
		$phone = html_escape($this->input->post('phoneNumber'));
		$checkBox = html_escape($this->input->post('sendToMe'));
		// Generate a random OTP
		$otp = rand(100000, 999999);

		if (isset($checkBox)) { // Send OTP to the phone number
			// Call the function to send the OTP
			return $this->sendSmsWithOTP($otp, $phone);
		} else {
			// Check if the phone number is registered
			$this->db->select('*');
			$this->db->from($this->customers_table);
			$this->db->where('phone', $phone);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$email = $query->row()->email;
				$name = $query->row()->firstname . ' ' . $query->row()->lastname;
				// Send the email
				$message = $this->sendOtpToCustomerEmail($email, $name, $otp);
				if ($message['status'] == 'success') {
					// set phone number to session
					$this->session->set_userdata('phone', $phone);
					// Send back a response
					set_response('success', 'Success', 200, '', 'OTP sent to your email address ' . $email . ' please check', 1, null);
				} elseif ($message['status'] == 'error') {
					// Send back a response
					set_response('error', 'Error', 400, '', 'Error sending OTP to your email address', null, null);
				}
			} else {
				// Send back a response
				set_response('error', 'Error', 400, '', 'The phone number ' . $phone . ' is not registered', null, null);
			}
		}
	}

	// This function validates the OTP
	public function validate_otp()
	{
		// Get the phone number from session
		$phone = $this->session->userdata('phone');
		// Get the form data
		$code1 = html_escape($this->input->post('code_1'));
		$code2 = html_escape($this->input->post('code_2'));
		$code3 = html_escape($this->input->post('code_3'));
		$code4 = html_escape($this->input->post('code_4'));
		$code5 = html_escape($this->input->post('code_5'));
		$code6 = html_escape($this->input->post('code_6'));

		// Create the OTP
		$otp = $code1 . $code2 . $code3 . $code4 . $code5 . $code6;

		// Compare the otp with the one in the database
		$this->db->select('*');
		$this->db->from($this->customers_table);
		$this->db->where('otp', $otp);
		$query = $this->db->get();

		if ($query->num_rows() > 0) { // The otp is correct
			// Check if the OTP has expired
			$otp_time = $query->row()->updated_date;
			$otp_time = strtotime($otp_time);
			$now = time();
			$diff = $now - $otp_time;
			$minutes = round($diff / 60);

			if ($minutes > 10) { // The OTP has expired
				// Send back a response
				set_response('error', 'Error', 400, '', 'The OTP has expired', null, null);
			} else { // The OTP is valid
				// Set the session
				$customer_id = $query->row()->customer_id;
				if (start_user_session($customer_id, $this->customers_table)) {
					// Reset the login attempts back to 0
					resetLoginAttempts($this->customers_table, $phone);

					// Clear the session
					$this->session->unset_userdata('phone');
					// Send back a response
					set_response('success', 'Success! OTP verified!', 200, '', 'Welcome back ' . $query->row()->firstname . ' ' . $query->row()->lastname, 1, null);
				}
			}
		} else { // The otp is incorrect
			// Return a message
			loginAttempts($this->customers_table, $phone);
		}
	}

	// Function for sending OTP to customer email
	public function sendOtpToCustomerEmail($email, $name, $otp)
	{
		// Load the email library
		$this->load->library('email');
		// email configuration
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'gator2106.hostgator.com',
			'smtp_port' => 587,
			'smtp_user' => 'info@tk9.co.ke',
			'smtp_pass' => 'TotalK9@2022',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE,
			'newline' => "\r\n" //use double quotes,
		);

		// Initialize the email configuration
		$this->email->initialize($config);

		// create time stamp
		$timestamp = date('Y-m-d H:i:s');

		// update the code in the database
		$this->db->set('otp', $otp);
		$this->db->set('updated_date', $timestamp);
		$this->db->where('email', $email);
		$this->db->update($this->customers_table);

		// Set session data
		$session_data = array(
			'otp' => $otp,
			'customer' => $name,
		);

		// Set session
		$this->session->set_userdata($session_data);

		// Message to be sent
		$message = "Hello There, <br><br> Your OTP is: " . $otp . "<br><br> Regards, <br> Delivisha";

		// Send email
		$this->email->from('info@delivisha.com', 'Delivisha Logistics');
		$this->email->to($email);
		$this->email->subject('Delivisha OTP');
		$this->email->message($message);

		// Check if email is sent
		if ($this->email->send()) {
			// Return a message
			$result = array(
				'status' => 'success',
				// 'message' => 'OTP sent to your email address please check',
			);
			return $result;
		} else {
			// Return a message
			$result = array(
				'status' => 'error',
				// 'message' => 'Error sending OTP to your email address',
			);
			return $result;
		}
	}

	/**
	 * =============================================================================================
	 * 							FUNCTIONS FOR CUSTOMER REGISTRATION AND LOGIN
	 * =============================================================================================
	 */

	// Function for validating customer login
	public function validateExistingCustomer()
	{
		// Verify Google reCAPTCHA
		$response = $this->input->post('g-recaptcha-response');
		$captcha_success = validate_recaptcha($response);

		if ($captcha_success) {
			// Get the form data
			$phone = html_escape($this->input->post('phone_number'));
			$checkBox = html_escape($this->input->post('sendToMe2'));
			// Generate OTP
			$otp = rand(100000, 999999);

			if (isset($checkBox)) { // The customer wants to receive the OTP via phone
				// Call the function to send the OTP to the customer
				return $this->sendSmsWithOTP($otp, $phone);
			} else {
				// Check if the phone number is registered
				$this->db->select('*');
				$this->db->from($this->customers_table);
				$this->db->where('phone', $phone);
				$query = $this->db->get();

				if ($query->num_rows() > 0) { // The phone number is registered
					// Send OTP to customer email
					$email = $query->row()->email;
					$name = $query->row()->firstname;
					$message = $this->load->view('email_templates/otp_email', array('otp' => $otp, 'username' => $name), true);
					$titleFrom = 'Delivisha Logistics';
					$subject = 'Delivisha One Time Password';

					// Send OTP to customer email
					$send_otp = sendOtpEmail($email, $subject, $titleFrom, $otp, $message);

					if ($send_otp['status'] == 'success') {
						// Send back a response
						set_response('success', 'Success! OTP sent.', 200, '', $send_otp['message'], 1, null);
					} elseif ($send_otp['status'] == 'error') {
						// Send back a response
						set_response('error', 'Error! OTP not sent.', 400, '', $send_otp['message'], 1, null);
					}
				} else { // The phone number is not registered
					// Send back a response
					set_response('error', 'Error! Phone number not registered.', 400, '', 'The phone number +254' . $phone . ' is not registered.', 1, null);
				}
			}
		} else {
			// Send back a response
			set_response('error', 'Error! Google reCAPTCHA failed.', 403, '', 'Please verify that you are not a robot using the Google reCAPTCHA check box', 1, null);
		}
	}

	// Function for validating customer OTP
	public function validateCustomerOTP()
	{
		// Get the phone number from session
		$phone = $this->session->userdata('phone');
		// Get the form data
		$code1 = html_escape($this->input->post('code1'));
		$code2 = html_escape($this->input->post('code2'));
		$code3 = html_escape($this->input->post('code3'));
		$code4 = html_escape($this->input->post('code4'));
		$code5 = html_escape($this->input->post('code5'));
		$code6 = html_escape($this->input->post('code6'));

		// Create the OTP
		$otp = $code1 . $code2 . $code3 . $code4 . $code5 . $code6; //12121212

		// Check if the OTP is correct
		$this->db->select('*');
		$this->db->from($this->customers_table);
		$this->db->where('otp', $otp);
		$query = $this->db->get();

		if ($query->num_rows() > 0) { // The otp is correct
			// Check if the customer is active
			if ($query->row()->status == 0) { // The customer is not active
				// Send back a response
				set_response('error', 'Error! Account not active.', 403, '', 'Your account is not active. Please contact Delivisha support.', 1, null);
			} else { // The customer is active
				// Get saved updated date
				$updated_date = $query->row()->updated_date;
				// Check if the OTP has expired
				$result = checkExpirationTime($updated_date);
				if ($result['status'] == 'success') :
					$customer_id = $query->row()->customer_id;
					// Reset login attempts to 0
					resetLoginAttempts($this->customers_table, $phone);

					// Clear the phone session
					$this->session->unset_userdata('phone');
					// Set session data
					start_user_session($customer_id, $this->customers_table);
					$message = 'OTP verified successfully welcome back ' . $query->row()->firstname . ' ' . $query->row()->lastname;
					// Send back a response
					set_response('success', 'Success! OTP verified.', 200, '', $message, 1, base_url('customer_account'));
				elseif ($result['status'] == 'error') :
					// Send back a response
					set_response('error', 'Error! OTP expired.', 400, '', $result['message'], 1, null);
				endif;
			}
		} else { // The otp is incorrect
			// Return a message
			loginAttempts($this->customers_table, $phone);
		}
	}

	// Function to send sms with OTP if the customer selects the checkbox
	public function sendSmsWithOTP($otp, $phone)
	{
		// Check if the phone number is registered
		$this->db->select('*');
		$this->db->from($this->customers_table);
		$this->db->where('phone', $phone);
		$query = $this->db->get();

		if ($query->num_rows() > 0) { // The phone number is registered
			$email = $query->row()->email;
			// Prepare phone number and message
			$phone = '254' . substr($phone, 1);
			$message = 'Your OTP is ' . $otp . ' Please enter it to continue with your order.';

			// Send the message
			$successMessage = sendMessage($message, $phone);

			if ($successMessage) {
				// create time stamp
				$timestamp = date('Y-m-d H:i:s');
				// Update the otp in the database
				$this->db->set('otp', $otp);
				$this->db->set('updated_date', $timestamp);
				$this->db->where('email', $email);
				$this->db->update($this->customers_table);

				// Send back a response
				set_response('success', 'Success! OTP sent.', 200, '', 'OTP sent to your phone number +' . $phone . ' successfully', 1, null);
			} else {
				$message = 'OTP not sent to your phone number +' . $phone . ' please try again';
				// Send back a response
				set_response('error', 'Error! OTP not sent.', 400, '', $message, 1, null);
			}
		} else { // The phone number is not registered
			// Send back a response
			set_response('error', 'Error! Phone number not registered.', 400, '', 'The phone number +' . $phone . ' is not registered.', 1, null);
		}
	}

	// This function is for creating new customer
	public function createNewCustomer()
	{
		// Verify Google reCAPTCHA
		$response = $this->input->post('g-recaptcha-response');
		$captcha_success = validate_recaptcha($response);

		if ($captcha_success) {
			// Get the customers details from the inputs
			$first_name = html_escape(trim($this->input->post('first_name1')));
			$last_name = html_escape(trim($this->input->post('last_name1')));
			$email = html_escape(trim($this->input->post('emailAddress1')));
			$phone = html_escape(trim($this->input->post('phoneNumber1')));

			// Check if customer exists in the databse
			$this->db->select('*');
			$this->db->from($this->customers_table);
			$this->db->where('email', $email);
			$this->db->or_where('phone', $phone);
			$query = $this->db->get();
			// Check if query returns something
			if ($query->num_rows() > 0) {
				// Send back a response
				set_response('error', 'Error! Customer already exists.', 403, '', 'The email or phone number is already registered', 1, null);
			} else {
				// Generate a randon code
				$code = rand(100000, 999999);
				// set data to array
				$data = array(
					'customer_id' => $code,
					'firstname' => $first_name,
					'lastname' => $last_name,
					'email' => $email,
					'phone' => $phone,
					'status' => 1,
				);

				// Insert the data to the database
				$this->db->insert($this->customers_table, $data);
				// Create a notification
				$notification_message = 'New customer ' . $first_name . ' ' . $last_name . ' has been registered with the email ' . $email . ' and phone number ' . $phone;
				$notification_type = 'customer';
				$notification_title = 'New customer';
				// Create a notification
				if (createNotification($notification_type, $notification_title, $notification_message)) { // The notification was created
					// Redirect url
					$redirect_url = base_url('customer_account');
					$email_title = 'Delivisha Logistics';
					$subject = 'Delivisha Welcoming Message';
					$email_data = [
						'username' => $first_name . ' ' . $last_name
					];
					$message = $this->load->view('email_templates/delivisha_welcome_email', $email_data, true);
					// Send email to the customer
					$result = sendWelcomingEmail($email, $subject, $email_title, $message);
					// Send back a response
					set_response($result['status'], $result['title'], 200, '', $result['message'], 1, $redirect_url);
				} else {
					// Send back a response
					set_response('error', 'Error! Customer not created.', 400, '', 'Something went wrong while trying to register your details, try again later!', 1, null);
				}
			}
		} else {
			// Send back a response
			set_response('error', 'Error! Google reCAPTCHA failed.', 400, '', 'Please check the reCAPTCHA box to verify that you are not a robot', 1, null);
		}
	}

	/**
	 * =============================================================================================
	 * 							FUNCTION FOR USERS REGISTRATION (BACKEND)
	 * =============================================================================================
	 */
	// This function has the logic of checking wether the user data provided is valid before logging in
	function check_user_exists()
	{
		// Get the form data
		$email_or_phone = html_escape(trim($this->input->post('username')));
		$password = html_escape(trim($this->input->post('password')));

		// Check if the username input is an email or a phone number
		$filter_response = $this->filterPhoneNumberOrEmail($email_or_phone);
		// Check if the filter response is an email
		if ($filter_response['status'] == 'email') { // The input is an email
			// Check if the email exists in the database
			$this->db->select('*');
			$this->db->from($this->users_table);
			$this->db->where('email', $email_or_phone);
			$query = $this->db->get();
			// Check if query returns something
			if ($query->num_rows() > 0) {
				// Check if the email exists in the database
				$this->db->select('*');
				$this->db->from($this->users_table);
				$this->db->where('email', $filter_response['email']);
				$query = $this->db->get();

				// Check if the account is active
				if ($query->row()->status == 1) {
					if ($query->num_rows() > 0) { // The email exists 
						// Get the user details
						$user = $query->row_array();
						// Check if the password is correct
						if (password_verify($password, $user['user_password'])) { // The password is correct
							// Set the session data
							if ($this->createNewUserSession($user['user_id'], $user['user_type'])) {
								// clear login attempts
								resetLoginAttempts($this->users_table, $user['phone']);
								// Send back a response
								set_response('success', 'Success! Login successful.', 200, '', 'Login successful', 1, base_url('admin'));
							} else {
								// Send back a response
								set_response('error', 'Error! Login failed.', 400, '', 'An error occured while creating your session, please try again', 1, null);
							}
						} else { // The password is incorrect
							// Update the login attempts
							loginAttempts($this->users_table, $user['phone']);
						}
					} else { // The email does not exist
						// Send back a response
						set_response('error', 'Error! Login failed.', 400, '', 'The email ' . $filter_response['email'] . ' is not registered', 1, null);
					}
				} else {
					// Send back a response
					set_response('error', 'Error! Locked Account.', 400, '', 'Your account is not active, please contact Delivisha support for unlock. <a href="' . site_url('contact') . '" class="text-info">Support Here</a>', 1, null);
				}
			} else { // The email does not exist
				// Send back a response
				set_response('error', 'Error! Email not registered.', 400, '', 'The email "' . $email_or_phone . '" is not registered in our system.', 1, null);
			}

			// Check if the filter response is a phone
		} elseif ($filter_response['status'] == 'phone') { // The input is a phone number
			// Check if the phone number exists in the database
			$this->db->select('*');
			$this->db->from($this->users_table);
			$this->db->where('phone', $filter_response['phone']);
			$query = $this->db->get();

			if ($query->num_rows() > 0) { // The phone number exists 
				// Check if the account is active
				if ($query->row()->status == 1) {
					// Get the user details
					$user = $query->row_array();
					// Check if the password is correct
					if (password_verify($password, $user['user_password'])) { // The password is correct
						// Set the session
						if ($this->createNewUserSession($user['user_id'], $user['user_type'])) {
							// clear login attempts
							resetLoginAttempts($this->users_table, $user['phone']);
							// Send back a response
							set_response('success', 'Success! Login successful.', 200, '', 'Login successful', 1, base_url('admin'));
						} else {
							// Send back a response
							set_response('error', 'Error! Login failed.', 400, '', 'An error occured while creating your session, please try again', 1, null);
						}
					} else { // The password is incorrect
						// Update the login attempts
						loginAttempts($this->users_table, $user['phone']);
					}
				} else { // The account is not active
					// Send back a response
					set_response('error', 'Error! Locked Account.', 400, '', 'Your account is not active, please contact Delivisha support for unlock. <a href="' . site_url('contact') . '" class="text-info">Support Here</a>', 1, null);
				}
			} else { // The phone number does not exist
				// Send back a response
				set_response('error', 'Error! Login failed.', 400, '', 'The phone number "' . $filter_response['phone'] . '" is not registered in our system', 1, null);
			}
		}
	}

	// This function filters phone number or email
	function filterPhoneNumberOrEmail($email_or_phone)
	{
		// Check if the username input is an email or a phone number
		if (filter_var($email_or_phone, FILTER_VALIDATE_EMAIL)) { // The input is an email
			// Return status is email
			$response = array(
				'status' => 'email',
				'email' => $email_or_phone,
			);
			return $response;
		} else { // The input is a phone number
			// Return status is phone
			$response = array(
				'status' => 'phone',
				'phone' => $email_or_phone,
			);
			return $response;
		}
	}

	// Create new user session function
	function createNewUserSession($userId, $userType)
	{
		// Prepare session data
		$sessionData = array(
			'user_id' => $userId,
			'user_type' => $userType,
			'logged_in' => TRUE,
		);
		// Create new session
		$this->session->set_userdata($sessionData);
		return TRUE;
	}

	// Send otp to user function
	function send_otp_to_user()
	{
		// Get data from the form
		$email = html_escape(trim($this->input->post('email')));
		$checkBox = $this->input->post('send_to_phone');
		// check if user exists
		if ($user = $this->check_login_user_exist($email)) {
			// Generate otp
			$otp = generateOTP();
			// check if the checkbox is checked sms counter is less than 3

			if (isset($checkBox) && $user->sms_counter < 3) { // Send otp to phone
				// Get the user phone number
				$phone = $user->phone;
				$phoneNumber = '+254' . $phone;
				$message = 'Your OTP is ' . $otp . ' for validating your account. This code is valid for 5 minutes. If you did not request this code, please ignore this message.';
				// Send otp to phone
				if (sendMessage($message, $phoneNumber)) {
					// current date and time
					$now = date('Y-m-d H:i:s');
					// Update the otp in the database
					$this->db->where('user_id', $user->user_id);
					$this->db->update($this->users_table, array('otp' => $otp, 'sms_counter' => $user->sms_counter + 1, 'updated_date' => $now));
					// Send back a response
					set_response('success', 'Success! OTP sent to phone.', 200, '', 'OTP has been sent to ' . $phone . ' please check to verify.', 1, null);
				} else {
					// Send back a response
					set_response('error', 'Error! Sending OTP.', 400, '', 'Something went wrong while trying to send SMS. Leave the checkbox empty to send to email.', 1, null);
				}
			} else { // Send otp to email
				// Get the user full name
				$userDetails = $this->getUserTypeDetails($user);
				$firstName = $userDetails->first_name;
				// Get the user email
				$email = $user->email;
				$message = $this->load->view('email_templates/send_user_email', array('otp' => $otp, 'username' => $firstName), TRUE);
				// Send otp to email
				sendOtpToUserEmail($email, 'Your OTP from Delivisha', 'Delivisha Logistics', $otp, $message);
			}
		}
	}

	// Check if the user requesting otp exists
	function check_login_user_exist($email)
	{
		// Check if the email exists in the database
		$this->db->select('*');
		$this->db->from($this->users_table);
		$this->db->where('email', $email);
		$query = $this->db->get();

		if ($query->num_rows() > 0) { // The email exists 
			// Get the user details
			$user = $query->row();
			return $user;
		} else { // The phone number does not exist
			// Send back a response
			set_response('error', 'Error! Wrong Email.', 400, '', 'The email ' . $email . ' is not registered please try again with a registered one.', 1, null);
		}
	}

	// Get user type details function
	function getUserTypeDetails($user)
	{
		// Check user type
		if ($user->user_type == 'admin') { // The user is an admin
			// Get the admin details
			$this->db->select('*');
			$this->db->from($this->admins_table);
			$this->db->where('admin_id', $user->user_id);
			$query = $this->db->get();
			$driver_details = $query->row();
			return $driver_details;
		} else if ($user->user_type == 'driver') {
			// Get the driver details
			$this->db->select('*');
			$this->db->from($this->drivers_table);
			$this->db->where('driver_id', $user->user_id);
			$query = $this->db->get();
			$driver_details = $query->row();
			return $driver_details;
		} else if ($user->user_type == 'vendor') {
			// Get the vendor details
			$this->db->select('*');
			$this->db->from($this->vendor_table);
			$this->db->where('vendor_id', $user->user_id);
			$query = $this->db->get();
			$vendor_details = $query->row();
			return $vendor_details;
		}
	}

	// Function to verify otp entered by the user is correct
	function verify_otp_entered()
	{
		// Get data from the request
		$otp_code_1 = html_escape($this->input->post('code_one'));
		$otp_code_2 = html_escape($this->input->post('code_two'));
		$otp_code_3 = html_escape($this->input->post('code_three'));
		$otp_code_4 = html_escape($this->input->post('code_four'));
		$otp_code_5 = html_escape($this->input->post('code_five'));
		$otp_code_6 = html_escape($this->input->post('code_six'));
		// Check if the otp is correct
		$otp = $otp_code_1 . $otp_code_2 . $otp_code_3 . $otp_code_4 . $otp_code_5 . $otp_code_6;
		// Check if the otp exists in the database
		$this->db->select('*');
		$this->db->from($this->users_table);
		$this->db->where('otp', $otp);
		$query = $this->db->get();

		if ($query->num_rows() > 0) { // The otp exists 
			// cirrent date and time
			$current_date = date('Y-m-d H:i:s');
			// Get the user details
			$user = $query->row();
			// Check if the otp is still valid
			$otp_time = checkExpirationTime($user->updated_date);
			if ($otp_time['status'] == 'error') { // The otp is not valid
				// Send back a response
				set_response($otp_time['status'], $otp_time['title'], 400, '', $otp_time['message'], 1, null);
			} elseif ($otp_time['status'] == 'success') { // The otp is valid
				// secret token
				$secret_token = generate_secret_token(50);
				// Reset password page url
				$reset_password_url = base_url() . 'reset-password/?token=' . $user->user_id . '&secret=' . $secret_token;
				// Update the otp in the database
				$this->db->where('user_id', $user->user_id);
				$this->db->update($this->users_table, array('otp' => '', 'updated_date' => $current_date, 'sms_counter' => 0, 'secret_token' => $secret_token));
				// Send back a response
				set_response('success', 'Success! OTP Verified.', 200, '', 'OTP verified successfully you may proceed to reset password', 1, $reset_password_url);
			}
		} else { // The otp does not exist
			// Send back a response
			set_response('error', 'Error! Wrong OTP.', 400, '', 'The OTP you entered is wrong please try again.', 1, null);
		}
	}

	// This function is for changing the users password
	function change_user_password()
	{
		// Get data from the request
		$user_id = html_escape($this->input->post('user_id'));
		$password = html_escape($this->input->post('password'));
		$confirm_password = html_escape($this->input->post('confirm_password'));
		// Check if the passwords match
		if ($password != $confirm_password) { // The passwords do not match
			// Send back a response
			set_response('error', 'Error! Passwords do not match.', 400, '', 'The passwords you entered do not match please try again.', 1, null);
		} else { // The passwords match
			// Hash the password
			$password = password_hash($password, PASSWORD_DEFAULT);
			// Current date and time
			$current_date = date('Y-m-d H:i:s');
			// Redirect url
			$redirect_url = base_url() . 'login';
			// Update the password in the database
			$this->db->where('user_id', $user_id);
			$this->db->update($this->users_table, array('user_password' => $password, 'secret_token' => '', 'updated_date' => $current_date, 'sms_counter' => 0, 'login_attempts' => 0));
			// Send back a response
			set_response('success', 'Success! Password Changed.', 200, '', 'Password changed successfully you may proceed to login.', 1, $redirect_url);
		}
	}
}
