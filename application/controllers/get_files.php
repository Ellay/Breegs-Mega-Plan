<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_files extends CI_Controller {

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
		if (!$this->session->userdata("ses_is_loged")){
			redirect("/");
			return TRUE;
		}
		$this->load->helper('common');
		// GENERAL VARIBLES
		$this->data = array(
			'resources_url' => base_url('files/attaches')."/",
			'sys_url' => base_url()."/",
			'ses_user_name'=> $this->session->userdata("ses_user_name"),
			'ses_user_s_name'=> $this->session->userdata("ses_user_s_name"),
			'ses_user_t_name'=> $this->session->userdata("ses_user_t_name"),
			'ses_department'=> $this->session->userdata("ses_department"),
			'ses_position'=> $this->session->userdata("ses_position"),
			'ses_user_id'=> $this->session->userdata("ses_user_id"),
			'ses_user_login'=> $this->session->userdata("ses_user_login"),
		);
		$this->load->model("files_db");
		return TRUE;
	}
	public function attaches($alias){
		$file_info=$this->files_db->get_file_by_alias($alias);
		//var_dump($file_info);
		$file="files/attaches/".$file_info->mail_file_alias;
		//var_dump($file);
		header('Content-Description: File Transfer');
		header('Content-Type: '.$file_info->mail_mime_type);
		header('Content-Disposition: attachment; filename=' . $file_info->mail_file_name);
		//header('Content-Transfer-Encoding: binary');
		//header('Content-Length: ' . filesize($file));
		echo file_get_contents($file);
		return TRUE;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */