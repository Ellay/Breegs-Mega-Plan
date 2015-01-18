<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar_db extends CI_Model {
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
	function get_short_cuts(){
		$this->db->select('*');
		$this->db->from('short_cuts_calendar');
		$query = $this->db->get();
		return $query->result();
	}
	function add_new_event($post){
		$this->db->insert('todo', $post);
		return $this->db->insert_id();
	}
	function add_new_event_subcon($post){
		$this->db->insert('todo_sub', $post);
		return $this->db->insert_id();
	}
	function add_new_event_rep($post){
		$this->db->insert('todo_event', $post);
		return $this->db->insert_id();
	}
	function get_feed_my($timestamp_start, $timestamp_end){
		$this->db->select('*');
		$this->db->from('todo');
		$this->db->join('short_cuts_calendar', 'short_cuts_calendar.Id_short_cut = todo.todo_short_cut');
		$this->db->join('todo_event', 'todo_event.todo_id = todo.Id_todo');
		$this->db->where('todo_event.todo_event_time_start >=', $timestamp_start);
		$this->db->where('todo_event.todo_event_time_end <=', $timestamp_end);
		$this->db->where('todo_event.todo_status !=', 1);
		$this->db->where('todo_housmen', $this->session->userdata("ses_user_id"));
		$query = $this->db->get();
		return $query->result();
	}
	function get_feed_share($timestamp_start, $timestamp_end){
		$this->db->select('*');
		$this->db->from('todo');
		$this->db->join('short_cuts_calendar', 'short_cuts_calendar.Id_short_cut = todo.todo_short_cut');
		$this->db->join('todo_event', 'todo_event.todo_id = todo.Id_todo');
		$this->db->join('todo_sub', 'todo_sub.todo_id = todo.Id_todo');
		$this->db->where('todo_event_time_start >=', $timestamp_start);
		$this->db->where('todo_event_time_end <=', $timestamp_end);
		$this->db->where('todo_status !=', 1);
		$this->db->where('todo_sub_user', $this->session->userdata("ses_user_id"));
		$query = $this->db->get();
		return $query->result();
	}
	function get_subcon_list($id_event){
		$this->db->select('*');
		$this->db->from('todo_sub');
		$this->db->join('users', 'users.Id_user = todo_sub.todo_sub_user');
		$query = $this->db->get();
		return $query->result();
	}
	function update_event($event_id, $post, $target=FALSE){
		$this->db->where('Id_todo', $event_id);
		$this->db->update('todo', $post);
		return TRUE;
	}
	function update_event_event($event_id, $post){
		$this->db->where('Id_todo_event', $event_id);
		$this->db->update('todo_event', $post);
	}
	function get_more_info_event($id_event){
		$this->db->select('*');
		$this->db->from('todo_event');
		$this->db->join('todo', 'todo.Id_todo = todo_event.todo_id');
		$this->db->join('short_cuts_calendar', 'short_cuts_calendar.Id_short_cut = todo.todo_short_cut');
		$this->db->where('Id_todo_event', $id_event);
		
		$query = $this->db->get();
		return $query->row();
	}
	function get_fulll_info_event($id_event){
		$this->db->select('*');
		$this->db->from('todo_event');
		$this->db->join('todo', 'todo.Id_todo = todo_event.todo_id');
		$this->db->join('users', 'users.Id_user = todo.todo_housmen');
		$this->db->join('short_cuts_calendar', 'short_cuts_calendar.Id_short_cut = todo.todo_short_cut');
		$this->db->where('Id_todo_event', $id_event);
		$query = $this->db->get();
		return $query->row();
	}


}
?>