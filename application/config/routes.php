<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// Front-end Routes
$route['default_controller'] = 'welcome';
$route['order_tracking'] = 'Welcome/tracking';
$route['contact'] = 'welcome/contact';
$route['send_email'] = 'Welcome/send_message';
$route['order'] = 'Welcome/orders';
$route['customer_registration'] = 'authentication/customer_registration';
$route['validate_phone_number'] = 'authentication/validatePhoneNumber';
$route['submit_otp'] = 'authentication/submit_otp';
$route['logout'] = 'authentication/logout';
$route['login_customer'] = 'authentication/validateCustomerPhoneNumber';
$route['verify_cuatomer_otp'] = 'authentication/verify_ustomer_otp';
$route['new_customer_registration'] = 'authentication/new_customer_registration';
$route['customer_account'] = 'Customer_account';
$route['shop'] = 'Welcome/shops';
$route['products'] = 'Welcome/products';

// API Routes
$route['api/v1/register'] = 'api/Auth_Controller/register';

// Backend Routes
$route['admin'] = 'backend/dashboard';
$route['reset-password'] = 'backend/Authentication/get_reset_password/';

// Auth Routes
$route['login'] = 'authentication';
$route['auth-registration'] = 'authentication/registration';

$route['404_override'] = '';
$route['translate_uri_dashes'] = false;
