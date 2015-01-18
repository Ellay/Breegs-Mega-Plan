<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {

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
		// GENERAL VARIBLES
		$this->data = array(
			'resources_url' => base_url('source')."/",
			'sys_url' => base_url()."/",
			'ses_user_name'=> $this->session->userdata("ses_user_name"),
			'ses_user_s_name'=> $this->session->userdata("ses_user_s_name"),
			'ses_user_t_name'=> $this->session->userdata("ses_user_t_name"),
			'ses_department'=> $this->session->userdata("ses_department"),
			'ses_position'=> $this->session->userdata("ses_position"),
			'ses_user_id'=> $this->session->userdata("ses_user_id"),
			'ses_user_login'=> $this->session->userdata("ses_user_login"),
		);
		return TRUE;
	}
	public function index(){
		$this->data["content"]="system/default";
		$this->load->view("main", $this->data);
	}
	
	/////////////////////////////////////////////////////////////////////////////////////
	////// COMAPNY TOOLS PART ///////////////////////////////////////////////////////////
	
	// LIST OF DEPARTMENTS
	public function departments_list($add_department=FALSE){
		$this->load->model("department_db");
		$this->load->model("user_db");
		if ($add_department){
			$this->department_db->add_new_department($_POST);
			redirect("staff/departments_list");
			return TRUE;
		}
		$this->data["department_list"]=$this->department_db->get_full_info_by_all();
		$this->data["user_list_by_dep"]=$this->user_db->get_users_by_dep();
		$this->data["content"]="include/department_list";
		$this->load->view("main", $this->data);
		return TRUE;
	}
	// LIST OF POSITION
	public function position_list($add_position=FALSE){
		$this->load->model("department_db");
		$this->load->model("user_db");
		if ($add_position){
			$this->department_db->add_new_position($_POST);
			redirect("staff/position_list");
			return TRUE;
		}
		$this->data["user_list_by_position"]=$this->user_db->get_user_by_position();
		$this->data["position_list"]=$this->department_db->get_position_list();
		$this->data["content"]="include/position_list";
		$this->load->view("main", $this->data);
		return TRUE;
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////
	////// USER TOOLS PART //////////////////////////////////////////////////////////////
	// ADDING NEW SATSS USER
	public function add_staff($add_new=FALSE){
		$this->load->model("department_db");
		if ($add_new){
			$this->load->model("user_db");
			if ($_POST["user_password"]==$_POST["user_password_rep"]){
				unset($_POST["user_password_rep"]);
				$_POST["user_password"]=md5($_POST["user_password"]);
				$this->user_db->add_new_staff($_POST);
				redirect("staff/add_staff");
				return TRUE;
			}
		}
		$this->data["position_list"]=$this->department_db->get_position_list();
		$this->data["department_list"]=$this->department_db->get_full_info_by_all();
		$this->data["content"]="include/add_staff_form";
		$this->load->view("main", $this->data);
	}
	// STAFF LIST 
	public function staff_list(){
		$this->load->model("user_db");
		$this->data["user_list"]=$this->user_db->get_basic_info_by_all();

		$this->data["content"]="include/staff_list";
		$this->load->view("main", $this->data);
	}
	public function profile($user_login=FALSE){
		
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////
	////// SHEDULE PART //////////////////////////////////////////////////////////////
	
	// VIEW CALENDAR AND INCLIDDIN ALL EVENTS
	// EVENTS LOADING BY AJAX (FULL CALENDAR FUNCTIONS)
	public function todo(){
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		$this->data["short_cut_list"]=$this->calendar_db->get_short_cuts();
		$this->data["staff_list"]=$this->user_db->get_all_without_me();
		$this->data["content"]="include/todo";
		$this->load->view("main", $this->data);
	}
	// OVERVIEW TODO EVENT BY ID
	public function todo_overview($todo_id){
		$this->load->model("calendar_db");
		$this->data["todo_overview"]=$this->calendar_db->get_fulll_info_event($todo_id);
		$this->data["content"]="include/todo_overview";
		$this->load->view("main", $this->data);
	}
	
	public function todo_edit($todo_id){
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		foreach($this->calendar_db->get_subcon_list($todo_id) as $row){
			$sub_con_list[]=$row->todo_sub_user;
		};
		$this->data["subcon_list"]=$sub_con_list;
		$this->data["short_cut_list"]=$this->calendar_db->get_short_cuts();
		$this->data["staff_list"]=$this->user_db->get_all_without_me();
		$this->data["todo_overview"]=$this->calendar_db->get_fulll_info_event($todo_id);
		$this->data["content"]="include/todo_edit";
		$this->load->view("main", $this->data);
	}
	// THIS FUNCTION CALLED BY AJAX
	// ADDING NEW TODO EVENT
	public function add_new_event(){
		/// THIS DATA IS REQUARED
		$this->load->model("calendar_db");
		$post["todo_housmen"]=$this->session->userdata("ses_user_id");
		$post["todo_title"]=$_POST["todo_title"];
		$post["todo_short_cut"]=$_POST["todo_short_cut"];
		/// THIS DATA IS OPTIONAL
		if (isset($_POST["todo_if_all_day"])){ // IF TODO EVENT IS ALL DAY
			$post["todo_if_all_day"]=1;
		};
		if (isset($_POST["todo_if_static"])){ // IF TODO EVENT PROTECTED FOR MOVING
			$post["todo_if_static"]=1;
		};
		if (isset($_POST["todo_description"])){
			$post["todo_body"]=$_POST["todo_description"];
		};
		if (isset($_POST["todo_subcon"])){
			$post["todo_if_subhouseman"]=1; // IF TODO EVENT SHARIN WITH USERS
		};
		if ($_POST["todo_repeating"]!="none"){ // IF TODO EVENT IS REPEATIN
			$post["todo_if_repeating"]=1;
		}
		// INSERTING GENERAL DATA TO PERENT TABLE (TODO!)
		$new_event_id=$this->calendar_db->add_new_event($post); // CURRENT ID FOR NEW TODO EVENT

		// FILLING SUBCON USER TABLE
		if (isset($_POST["todo_subcon"])){
			foreach($_POST["todo_subcon"] as $key => $value){
				$post_sub=array();
				$post_sub["todo_id"]=$new_event_id;
				$post_sub["todo_sub_user"]=$value;
				$this->calendar_db->add_new_event_subcon($post_sub);
			}
		}
		// INSERTING DATA TO TODO EVENT TABLE
		$post_event["todo_id"]=$new_event_id;
		$post_event["todo_event_time_start"]=strtotime($_POST["todo_date_start"]." ".$_POST["todo_time_start"]);
		$post_event["todo_event_time_real"]=$post_event["todo_event_time_start"];
		if ($_POST["todo_date_end"] and $_POST["todo_time_end"]){
			$post_event["todo_event_time_end"]=strtotime($_POST["todo_date_end"]." ".$_POST["todo_time_end"]);
			if ($post_event["todo_event_time_start"]>$post_event["todo_event_time_end"]){
				$post_event["todo_event_time_end"]=$post_event["todo_event_time_start"]+20*60;
			}
		}else{
			$post_event["todo_event_time_end"]=$post_event["todo_event_time_start"]+20*60;
		}
		if ($_POST["todo_repeating"]=="none"){
			// IF NO REPEATIN
			$this->calendar_db->add_new_event_rep($post_event);
		}else{
			// IF NEED REPETING TODO EVENT
			$start=$post_event["todo_event_time_start"];
			$end=$post_event["todo_event_time_end"];
			switch($_POST["todo_repeating"]){
				case "day":
				// THIS CASE FOR REPEATIN TODOD EVENT FOR EVERY DAY
				// FIRST STEP IN 30 DAYS
					for($i = 0; $i < 30; $i++){
						$start+=24*60*60;
						$end+=24*60*60;
						$post_rep["todo_event_time_start"]=$start;
						$post_rep["todo_event_time_end"]=$end;
						$post_rep["todo_event_time_real"]=$start;
						$post_rep["todo_id"]=$new_event_id;
						$this->calendar_db->add_new_event_rep($post_rep);
					}
					break;
				case "week":
				// THIS CASE FOR REPEATIN TODOD EVENT FOR EVERY WEEK
				// FIRST STEP IN 8 WEEKS (2 MOTHES)
					for($i = 0; $i < 8; $i++){
						$start+=7*24*60*60;
						$end+=7*24*60*60;
						$post_rep["todo_event_time_start"]=$start;
						$post_rep["todo_event_time_end"]=$end;
						$post_rep["todo_event_time_real"]=$start;
						$post_rep["todo_id"]=$new_event_id;
						$this->calendar_db->add_new_event_rep($post_rep);
					}
					break;
					//// NEED ADDING PLAN FOR ONE MONTH AND YEAR
				default:
					break;
			}
		}
		return TRUE;
	}
	// THIS FUNCTION CALLED BY AJAX
	// DELETING TODO EVENT
	public function del_even($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=1; // "1" - removed
		$this->calendar_db->update_event($id_event, $post);
	}
	// THIS FUNCTION CALLED BY AJAX
	// TODO EVENT FEEDS AS JSON FORMAT
	// MY - SHOW MY FEEDS
	// SHARE - SHOW SHARED FEEDS
	public function event_feed($type=FALSE){
		$this->load->model("calendar_db");
		if ($type=="my"){
			$feed=$this->calendar_db->get_feed_my(strtotime($_POST["start"]), strtotime($_POST["end"]));
		};
		if ($type=="share"){
			$feed=$this->calendar_db->get_feed_share(strtotime($_POST["start"]), strtotime($_POST["end"]));
		}
		$events=array();
		foreach($feed as $row){
			$eventsArray=array();
			$classArr=array();
			$eventsArray['id'] =  $row->Id_todo_event;
			$eventsArray['title'] = $row->todo_title;
			$eventsArray['start'] = date("Y-m-d H:i:s", $row->todo_event_time_start);
			$eventsArray['color'] = $row->short_cut_bgcolor;
			$eventsArray['textColor'] = $row->short_cut_txcolor;
			$classArr[]="todo_more_info";
			// ADDING CLASS FOR COMPLEED TODO EVENT
			if ($row->todo_status==3){
				$classArr[]="todo_completed";
			};
			// ADDING CLASS FOR SHARED TODO EVENT
			if ($row->todo_if_subhouseman){
				$classArr[]="todo_share";
			}
			
			$eventsArray['className'] =$classArr;
			if ($row->todo_if_all_day){
				$eventsArray['allDay'] =TRUE;
			}
			//if ($row->)
			if ($row->todo_event_time_end){
				$eventsArray['end'] = date("Y-m-d H:i:s", $row->todo_event_time_end);
			}
			if ($row->todo_if_static){
				$eventsArray['editable'] = FALSE;
			}
			$events[] = $eventsArray;
		}
		echo json_encode($events);
		return TRUE;
	}
	// THIS FUNCTION CALLED BY AJAX
	public function todo_more_info($id_event){
		$this->load->model("calendar_db");
		$this->data["event_reviw_data"]=$this->calendar_db->get_more_info_event($id_event);
		$this->load->view("ajax/event_reviw", $this->data);
	}
	// THIS FUNCTION CALLED BY AJAX
	// UPADE TODO EVENT BY DROP IN CALENDAR
	public function update_event_drop(){
		$this->load->model("calendar_db");
		if (isset($_POST["upd_time_end"])){
			$post["todo_event_time_end"]=strtotime($_POST["upd_time_end"]);
		}
		if (isset($_POST["upd_time_start"])){
			$post["todo_event_time_start"]=strtotime($_POST["upd_time_start"]);
		}
		$this->calendar_db->update_event_event($_POST["upd_event_id"], $post);
	}
	
	/////////////////////////////////////////////////////////////////////////////////
	///////// SYSTEM SETTINGS
	public function settings_short_cut_calendar($add_short=FALSE){
		$this->load->model("settings_db");
		if ($add_short){
			$this->settings_db->add_new_short_cut($_POST);
			redirect("/staff/settings_short_cut_calendar");
			return TRUE;
		}
		
		$this->data["short_cut_list"]=$this->settings_db->get_all_short_cart();
		$this->data["content"]="settings/short_cut";
		$this->load->view("main", $this->data);
	}

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */