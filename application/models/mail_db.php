<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mail_db extends CI_Model {
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
	// Получаем список доступных cерверов для конекта
	function get_mail_server_list(){
		$this->db->select('*');
		$this->db->from('mail_servers');
		$this->db->where('Id_mail_server !=', 0);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_mail_boxes_for_user_by_id($user_id){
		$this->db->select('*');
		$this->db->from('user_mail_list');
		$this->db->where('mail_housman', $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	function insert_header_mail($mail_dump){
		$this->db->insert('mail_box', $mail_dump);
		return $this->db->insert_id();
	}
	function insert_attach_mail($attach_info){
		$this->db->insert('mail_attach', $attach_info);
		return $this->db->insert_id();
	}
	function insert_bode_mail($mail_dump, $mail_id){
		$this->db->where('Id_mail_box', $mail_id);
		$this->db->update('mail_box', $mail_dump);
		return TRUE;
	}
	function get_mail_list($user_id){
		$this->db->select('*');
		$this->db->from('mail_box');
		$this->db->where('mail_hosman', $user_id);
		$this->db->order_by("Id_mail_box", "DESC");
		$query = $this->db->get();
		return $query->result();
	}
	function get_mail_dump($mail_id){
		$this->db->select('*');
		$this->db->from('mail_box');
		$this->db->where('Id_mail_box', $mail_id);
		$query = $this->db->get();
		$mail_dump["body"]=$query->row();
		if ($mail_dump["body"]->mail_attach){
			$this->db->select('*');
			$this->db->from('mail_attach');
			$this->db->where('mail_id', $mail_dump["body"]->Id_mail_box);
			$query = $this->db->get();
			$mail_dump["attach"]=$query->result();
		};
		return $mail_dump;
	}
	function get_user_mail_from_to($start, $end, $user_id){
		$this->db->select('*');
		$this->db->from('mail_box');
		$this->db->where('mail_hosman', $user_id);
		$this->db->where('mail_status', 0);
		$this->db->where('if_outgoing', 0);
		$this->db->or_where('mail_hosman', $user_id);
		$this->db->where('mail_status', 1);
		$this->db->where('if_outgoing', 0);
		$this->db->order_by("Id_mail_box", "DESC");
		$this->db->limit($end, $start);
		$query = $this->db->get();
		return $query->result();
	}
	function get_user_mail_from_to_outgoing($start, $end, $user_id){
		$this->db->select('*');
		$this->db->from('mail_box');
		$this->db->where('mail_hosman', $user_id);
		$this->db->where('if_outgoing', 1);
		$this->db->or_where('mail_hosman', $user_id);
		$this->db->where('if_outgoing', 1);
		$this->db->order_by("Id_mail_box", "DESC");
		$this->db->limit($end, $start);
		$query = $this->db->get();
		return $query->result();
	}
	function count_all_mail_for_id($id_user, $folder){
		$this->db->select('Id_mail_box');
		$this->db->from('mail_box');
		$this->db->where('mail_hosman', $id_user);
		if ($folder=="inbox"){
			$this->db->where('if_outgoing', 0);
		};
		if ($folder=="outgoing"){
			$this->db->where('if_outgoing', 1);
		};
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	/////////////////////////////////////////
	function get_user_mail(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_mail !=', 'null');
		$this->db->where('user_mail_password !=', 'null');
		$query = $this->db->get();
		return $query->result();
	}
	function mark_mail($id_mail, $mail_dump){
		$this->db->where('Id_mail_box', $id_mail);
		$this->db->update('mail_box', $mail_dump);
		return TRUE;
	}
	

	


}
?>