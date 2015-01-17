<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_db extends CI_Model {
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
	
	
	///////////////////////////////////////////////////////
	/////////// AUTH PART
	function login_validator($post){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_login', $post["user_login"]);
		$this->db->where('user_password', md5($post["user_password"]));
		$query = $this->db->get();
		$user_info=$query->row();
		if ($user_info){
			$newdata = array(
				'ses_user_name'=> $user_info->user_name,
				'ses_user_s_name'=> $user_info->user_s_name,
				'ses_user_t_name'=> $user_info->user_t_name,
				'ses_department'=> $this->get_department_by_id($user_info->Id_user),
				'ses_position'=> $this->get_position_by_id($user_info->Id_user),
				'ses_user_id'=> $user_info->Id_user,
				'ses_user_login'=> $user_info->user_login,
				'ses_is_loged'=> TRUE,
			);
			$this->session->set_userdata($newdata);
			return TRUE;
		}
		return FALSE;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////// GET////////////////////////////////////////////////////////////////////////
	function get_basic_info_by_all(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$query = $this->db->get();
		return $query->result();
	}
	function get_department_by_id($id_department){
		$this->db->select('*');
		$this->db->from('departments');
		$this->db->where("Id_department", $id_department);
		$query = $this->db->get();
		return $query->row()->department_title;
	}
	function get_position_by_id($id_position){
		$this->db->select('*');
		$this->db->from('position');
		$this->db->where("Id_position", $id_position);
		$query = $this->db->get();
		return $query->row()->position_title;
	}
	function get_all_without_me(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("Id_position !=", $this->session->userdata("ses_user_id"));
		$query = $this->db->get();
		return $query->result();
	}
	function get_full_info_user_by_id($user_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("Id_user", $user_id);
		$query = $this->db->get();
		return $query->row();
	}
	function get_users_by_dep_id($dep_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("user_department", $dep_id);
		$query = $this->db->get();
		return $query->result();
	}
	function get_users_by_possition_id($position_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->where("user_position", $position_id);
		$query = $this->db->get();
		return $query->result();
	}
	function get_users_by_dep(){
		$this->db->select('Id_department');
		$this->db->from('departments');
		$query = $this->db->get();
		foreach($query->result() as $row){
			$data[$row->Id_department]=$this->get_users_by_dep_id($row->Id_department);
		};
		return $data;
	}
	function get_user_by_position(){
		$this->db->select('Id_position');
		$this->db->from('position');
		$query = $this->db->get();
		foreach($query->result() as $row){
			$data[$row->Id_position]=$this->get_users_by_possition_id($row->Id_position);
		};
		return $data;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////// UPDATE/////////////////////////////////////////////////////////////////////
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////// INSERT/////////////////////////////////////////////////////////////////////

	function add_new_staff($post){
		$this->db->insert('users', $post);
		return $this->db->insert_id();
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>