<?php

/**
 * Initializing the backend structure of the application
 */

//  Top header files of the application
$this->load->view('template/adminTemplates/header');

// The body section of the application
$this->load->view($main);

// The footer section of the backend
$this->load->view('template/adminTemplates/footer');
