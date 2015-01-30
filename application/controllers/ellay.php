<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ellay extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->data = array(
			'resources_url' => base_url('source')."/",
			'ses_user_name'=> $this->session->userdata("ses_user_name"),
			'ses_user_s_name'=> $this->session->userdata("ses_user_s_name"),
			'ses_user_t_name'=> $this->session->userdata("ses_user_t_name"),
			'ses_department'=> $this->session->userdata("ses_department"),
			'ses_position'=> $this->session->userdata("ses_position"),
			'ses_user_id'=> $this->session->userdata("ses_user_id"),
			'ses_user_login'=> $this->session->userdata("ses_user_login"),
		);
	}
	
	public function index(){
		$this->data['content'] = 'ellay/node';
		$this->load->view('main',$this->data);
	}







}