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
	// авторизация пользователя, создание ссесии
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
	// Вывод всех пользователей с полной основной информаией
	function get_basic_info_by_all(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$query = $this->db->get();
		return $query->result();
	}
	// Информация об отделе по ID
	function get_department_by_id($id_department){
		$this->db->select('*');
		$this->db->from('departments');
		$this->db->where("Id_department", $id_department);
		$query = $this->db->get();
		return $query->row()->department_title;
	}
	// Информация о позиции по ID
	function get_position_by_id($id_position){
		$this->db->select('*');
		$this->db->from('position');
		$this->db->where("Id_position", $id_position);
		$query = $this->db->get();
		return $query->row()->position_title;
	}
	// Получение основной информации без вызывающего пользователя
	function get_all_without_me(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("Id_user !=", $this->session->userdata("ses_user_id"));
		$query = $this->db->get();
		return $query->result();
	}
	// Полчение списка всех пользователей без участия постновщика дела
	function get_all_without_housmen($todo_id){
		$this->db->select('todo_housmen');
		$this->db->from('todo');
		$this->db->where("Id_todo", $todo_id);
		$query = $this->db->get();
		$user=$query->row();
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where("Id_user !=", $user->todo_housmen);
		$query = $this->db->get();
		return $query->result();
	}
	// Полноая информация о пользователе 2 функции (ID | LOGIN)
	function get_full_info_user_by_id($user_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("Id_user", $user_id);
		$query = $this->db->get();
		return $query->row();
	}
	function get_full_info_user_by_login($user_login){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("user_login", $user_login);
		$query = $this->db->get();
		return $query->row();
	}
	// Поллучение всех пользователей, принадлежащие заданной группе (отделу)
	function get_users_by_dep_id($dep_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('position', 'position.Id_position = users.user_position');
		$this->db->where("user_department", $dep_id);
		$query = $this->db->get();
		return $query->result();
	}
	// Получение списка всех пользователей прринадлежащие к определенной должности
	function get_users_by_possition_id($position_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('departments', 'departments.Id_department = users.user_department');
		$this->db->where("user_position", $position_id);
		$query = $this->db->get();
		return $query->result();
	}
	// Общая функция получения списка пользователей в связкес отделами
	function get_users_by_dep(){
		$this->db->select('Id_department');
		$this->db->from('departments');
		$query = $this->db->get();
		foreach($query->result() as $row){
			$data[$row->Id_department]=$this->get_users_by_dep_id($row->Id_department);
		};
		return $data;
	}
	// Общая функция получения списка пользователей в связкес должностями
	function get_user_by_position(){
		$this->db->select('Id_position');
		$this->db->from('position');
		$query = $this->db->get();
		foreach($query->result() as $row){
			$data[$row->Id_position]=$this->get_users_by_possition_id($row->Id_position);
		};
		return $data;
	}
	function get_user_mail_list($user_id){
		$this->db->select('*');
		$this->db->from('user_mail_list');
		$this->db->where("mail_housman", $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	function get_user_mail_all(){
		$this->db->select('*');
		$this->db->from('user_mail_list');
		$query = $this->db->get();
		return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////// UPDATE/////////////////////////////////////////////////////////////////////
	function upadte_user_mail($post, $user_id){
		
		$this->db->where('mail_housman', $user_id);
		$this->db->delete('user_mail_list');
		$this->db->insert_batch('user_mail_list', $post);
		//var_dump($post);die;
		return TRUE;
	}
	function update_user_profile($post, $user_id){
		$this->db->where('Id_user', $user_id);
		$this->db->update('users', $post);
		return TRUE;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////// INSERT/////////////////////////////////////////////////////////////////////
	// Добавление нового пользователя
	function add_new_staff($post){
		$this->db->insert('users', $post);
		return $this->db->insert_id();
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>