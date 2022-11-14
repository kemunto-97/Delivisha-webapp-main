<?php

/**
 * @param - This file contains methodes for customers logic
 * @author - Dennis Otieno
 */

// Function for starting user session
function start_user_session($customer_id, $table)
{
	// initialize ci instance
	$ci = &get_instance();
	$ci->load->database();
	// Get user data
	$ci->db->select('*');
	$ci->db->from($table);
	$ci->db->where('customer_id', $customer_id);
	$query = $ci->db->get();
	$user = $query->row();
	// Set session data
	$session_data = array(
		'logged_in' => true,
		'user_id' => $user->customer_id,
		'firstname' => $user->firstname,
		'lastname' => $user->lastname,
		'email' => $user->email,
		'phone' => $user->phone,
	);
	// Set session
	$ci->session->set_userdata($session_data);
	return true;
}
