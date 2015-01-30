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
		$this->load->model("alerts_db");
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
	function clear_todo_sub_list($todo_id){
		//var_dump($todo_id);die;
		$this->db->where('todo_id', $todo_id);
		$this->db->delete('todo_sub');
		$post["todo_if_subhouseman"]=0;
		$this->update_event_head($todo_id, $post);
		return TRUE;
	}
	function add_new_event_rep($post){
		$this->db->insert('todo_event', $post);
		$new_event=$this->db->insert_id();
		return $new_event;
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
		$this->db->where('todo_id', $id_event);
		$query = $this->db->get();
		return $query->result();
	}
	function update_event($event_id, $post){
		$this->db->where('Id_todo_event', $event_id);
		$this->db->update('todo_event', $post);
		return TRUE;
	}
	function update_event_head($event_id, $post){
		$this->db->where('Id_todo', $event_id);
		$this->db->update('todo', $post);
		return TRUE;
	}
	// Обновление событий серии от заданного до конечного
	function update_event_next($event_id, $post){
		$this->db->select('todo_event_time_real, todo_id');
		$this->db->from('todo_event');
		$this->db->where('Id_todo_event', $event_id);
		$query = $this->db->get();
		$existing_time=$query->row()->todo_event_time_real;
		$existing_todo=$query->row()->todo_id;
		$this->db->where('todo_id', $existing_todo);
		$this->db->where('todo_event_time_real >=', $existing_time);
		$this->db->update('todo_event', $post);
		return TRUE;
		
	}
	function get_event_next($event_next_id){
		$this->db->select('todo_event_time_real, todo_id');
		$this->db->from('todo_event');
		$this->db->where('Id_todo_event', $event_next_id);
		$query = $this->db->get();
		$curent_time_real=$query->row()->todo_event_time_real;
		$curent_todo_id=$query->row()->todo_id;
		$this->db->select('*');
		$this->db->from('todo_event');
		$this->db->where('todo_id', $curent_todo_id);
		$this->db->where('todo_event_time_real >=', $curent_time_real);
		$query = $this->db->get();
		return $query->result();
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
		//$this->db->join('todo_planning', 'todo_planning.todo_id = todo.Id_todo');
		$this->db->where('Id_todo_event', $id_event);
		$query = $this->db->get();
		return $query->row();
	}
	function get_fulll_info_event_rep($id_event){
		$this->db->select('*');
		$this->db->from('todo_event');
		$this->db->join('todo', 'todo.Id_todo = todo_event.todo_id');
		$this->db->join('users', 'users.Id_user = todo.todo_housmen');
		$this->db->join('short_cuts_calendar', 'short_cuts_calendar.Id_short_cut = todo.todo_short_cut');
		$this->db->join('todo_planning', 'todo_planning.todo_id = todo.Id_todo');
		$this->db->where('Id_todo_event', $id_event);
		$query = $this->db->get();
		return $query->row();
	}
	function add_todo_comment($post, $id_todo_event){
		$this->db->select('todo_coment');
		$this->db->from('todo_event');
		$this->db->where('Id_todo_event', $id_todo_event);
		$query = $this->db->get();
		$existing_comment=$query->row()->todo_coment;
		$post["todo_coment"]=$existing_comment.$post["todo_coment"];
		$this->db->where('Id_todo_event', $id_todo_event);
		$this->db->update('todo_event', $post);
		return nl2br($post["todo_coment"]);
	}
	function create_planning_task($post){
		$this->db->insert('todo_planning', $post);
		return $this->db->insert_id();
	}
	function get_perent_todo($todo_event_id){
		$this->db->select('todo.Id_todo');
		$this->db->from('todo_event');
		$this->db->join('todo', 'todo.Id_todo = todo_event.todo_id');
		$this->db->where('Id_todo_event', $todo_event_id);
		$query = $this->db->get();
		return $query->row()->Id_todo;
	}
	function get_repeating_day(){
		$this->db->select('todo_id');
		$this->db->from('todo_planning');
		$this->db->where('planning_day', 1);
		$query = $this->db->get();
		return $query->result();
	}
	function get_end_planning_time($id_todo){
		$this->db->select('todo_event_time_real, todo_event_time_start, todo_event_time_end');
		$this->db->from('todo_event');
		$this->db->where('todo_id', $id_todo);
		$this->db->order_by("todo_event_time_real", "DESC");
		$query = $this->db->get();
		return $query->row();
	}

}
?>