<?php

/**
 * Initializaing the front-end struncture of the aplication
 */

//  The header section
$this->load->view('template/publicTemplates/header');

// The body section
$this->load->view($main);

// The footer section
$this->load->view('template/publicTemplates/footer');
