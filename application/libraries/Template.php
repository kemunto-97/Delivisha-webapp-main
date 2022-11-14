<?php

/**
 * @param Description - This file is responsible for switching between the different sectioons of the website ie admin, public, and api
 * @author - Dennis Otieno
 * @version - 1.0.0
 * @date - 2020-09-29
 */

class Template
{
	public $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
	}

	/*
    *   @name:              load
    *   @desc:              Loads template and view specified
    *   @param:loc:         Location (Admin or Public)
    *   @param:tpl_name:    Name of the Template
    *   @param:view:        Name of the view to load
    *   @param:data:        Optional data array
     */

	public function load($loc, $tpl_name, $view, $data = null)
	{
		if ($loc == 'admin' && $tpl_name == 'default') {
			$tpl_name = 'admin';
		}

		if ($loc == 'public' && $tpl_name == 'default') {
			$tpl_name = 'public';
		}

		$data['main'] = $loc . '/' . $view;
		$this->ci->load->view('/template/' . $tpl_name, $data);
	}
}
