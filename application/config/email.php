<?php

/**
 * @author - Dennis Otieno
 * @param Date - 24-20-2020
 * @param Description - This file configures the email setings for sysstem sending emails.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

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
