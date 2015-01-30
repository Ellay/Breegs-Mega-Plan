<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Alerts_db extends CI_Model {
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
	function __construct(){
		parent::__construct();
	}
	function add_new_mail_alerts($post){
		$post["relay"]="mail_boxs";
		$this->db->insert('alerts', $post);
		return $this->db->insert_id();
	}
	function add_new_todo_alerts($post){
		$post["relay"]="todo";
		$this->db->insert('alerts', $post);
		return $this->db->insert_id();
	}
	
	

}
?>