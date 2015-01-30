<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings_db extends CI_Model {
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
	
	//////////////////////////////////////////////////////////////////////////////////////
	//// CALENDAR
	function get_all_short_cart(){
		$this->db->select('*');
		$this->db->from('short_cuts_calendar');
		$query = $this->db->get();
		return $query->result();
	}
	function add_new_short_cut($post){
		$this->db->insert('short_cuts_calendar', $post);
		return $this->db->insert_id();
	}
	
	
}
?>