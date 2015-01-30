<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stream extends CI_Controller {
	/**
	* Copyright (c) 2014 P. Antoha (p.antoha88@gmail.com || r.linker88@gmail.com)
	* 
	* @license MIT
	* @license GNU GENERAL PUBLIC LICENSE
	* 
	* @author Park Anton Chun Kvanovich
	* 
	* 
	* 
	* If you did not receive a copy of the 
	* PHP license, or have any questions about PHP licensing, 
	* please contact license@php.net.
	* 
	* 
	* 
	* All rights reserved.
	* Все методо выполняються в фоновом режиме асинхронно
	* 
	*/
	
	public function __construct(){
		parent::__construct();
		$this->data = array(
			'resources_url' => base_url('source')."/",
		);
		$this->load->model("alerts_db");
		$this->load->model("calendar_db");
		$this->load->model("department_db");
		$this->load->model("files_db");
		$this->load->model("mail_db");
		$this->load->model("settings_db");
		$this->load->model("user_db");
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */