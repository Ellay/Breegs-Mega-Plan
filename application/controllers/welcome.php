<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
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
	*/
	
	public function __construct(){
		parent::__construct();
		$this->data = array(
			'resources_url' => base_url('source')."/",
		);
	}
	public function index(){
		$this->load->view("welcome", $this->data);
	}
	public function auth(){
		$this->load->model("user_db");
		if ($this->user_db->login_validator($_POST)){
			redirect("staff");
			return TRUE;
		}
		redirect("/");
		return TRUE;
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */