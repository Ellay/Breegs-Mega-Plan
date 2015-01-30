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
		$this->load->helper('common');
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
		if (!$user_login){
			$user_login=$this->session->userdata("ses_user_login");
		};
		$this->load->model("user_db");
		$this->data["user_info"]=$this->user_db->get_full_info_user_by_login($user_login);
		$this->data["user_mail_list"]=$this->user_db->get_user_mail_list($this->data["user_info"]->Id_user);
		$this->data["content"]="include/profile";
		$this->load->view("main", $this->data);
	}
	public function edit_profile($user_id){
		$this->load->model("user_db");
		if($_POST){
			$post_mail=array();
			$j=0;
			for($i = 0; $i < count($_POST["mail_server"]); $i++){
				
				if ($_POST["mail_server"][$i] and $_POST["mail_login"][$i] and $_POST["mail_password"][$i]){
					$post_mail[$j]["mail_server"]=$_POST["mail_server"][$i];
					$post_mail[$j]["mail_login"]=$_POST["mail_login"][$i];
					$post_mail[$j]["mail_password"]=$_POST["mail_password"][$i];
					$post_mail[$j]["mail_housman"]=$user_id;
					$j++;
				}
			}
			//var_dump($post_mail);die;
			$this->user_db->upadte_user_mail($post_mail, $user_id);
			unset($_POST["mail_server"]);
			unset($_POST["mail_login"]);
			unset($_POST["mail_password"]);
			unset($_POST["user_password_rep"]);
			$_POST["user_password"]=md5($_POST["user_password"]);
			$this->user_db->update_user_profile($_POST, $user_id);
			
			redirect("/staff/profile/".$_POST["user_login"]);
			return TRUE;
		}
		if (!$user_id){
			$user_id=$this->session->userdata("ses_user_id");
		}
		
		$this->data["user_info"]=$this->user_db->get_full_info_user_by_id($user_id);
		$this->data["user_mail_list"]=$this->user_db->get_user_mail_list($user_id);
		$this->data["content"]="include/edit_profile";
		$this->load->view("main", $this->data);
		return TRUE;
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
	/// Загрузка формы добавления новго события
	public function add_new_event_form(){
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		$date_start=strtotime(substr($_POST["new_event_start"], 0, -6));
		$date_end=strtotime(substr($_POST["new_event_end"], 0, -6));
		$this->data["date_start"]=date("Y-m-d", $date_start);
		$this->data["time_start"]=date("H:i", $date_start);
		$this->data["date_end"]=date("Y-m-d", $date_end);
		$this->data["time_end"]=date("H:i", $date_end);
		$this->data["short_cut_list"]=$this->calendar_db->get_short_cuts();
		$this->data["staff_list"]=$this->user_db->get_all_without_me();
		//var_dump($this->data["staff_list"]);
		$this->load->view("ajax/add_new_event", $this->data);
	}
	
	
	
	// OVERVIEW TODO EVENT BY ID
	public function todo_overview($todo_id){
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		$sub_con_list=array();
		foreach($this->calendar_db->get_subcon_list($todo_id) as $row){
			$sub_con_list[]=$row->todo_sub_user;
		};
		$this->data["subcon_list"]=$sub_con_list;
		$this->data["staff_list"]=$this->user_db->get_basic_info_by_all();
		$this->data["todo_overview"]=$this->calendar_db->get_fulll_info_event($todo_id);
		$this->data["content"]="include/todo_overview";
		$this->load->view("main", $this->data);
	}
	// Завершение события
	// Вызываеться AJAX
	public function complete_event($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=3; // "3" - Complated
		$this->calendar_db->update_event($id_event, $post);
	}
	// Удаление одного собыия (в архиве)
	public function todo_dell_one($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=1; // "1" - Удаленно
		$this->calendar_db->update_event($id_event, $post);
	}
	public function test_time(){
		for ($i=1; $i<=3000000; $i++){
				echo $i;
		}
	}
	public function run_test(){
		exec_script('http://breegsplan.wl/staff/test_time');
		echo "OK";
	}
	public function replan_time($post){
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		$next_event=$this->calendar_db->get_event_next($post["todo_event_id"]);
		$time_start_str=$post["todo_date_start"]." ".$post["todo_time_start"];
		$time_end_str=$post["todo_date_end"]." ".$post["todo_time_end"];
		$time_start=strtotime($time_start_str);
		$time_end=strtotime($time_end_str);
		if ($time_end<$time_start){
			$time_end=$time_start+30*60;
		}
		//var_dump($post);die;
		switch($post["devider"]){
			case "day":
				$day_key=0;
				foreach($next_event as $row){
					$post_rep["todo_event_time_start"]=$time_start;
					$post_rep["todo_event_time_end"]=$time_end;
					$post_rep["todo_event_time_real"]=$time_start;
					$this->calendar_db->update_event($row->Id_todo_event, $post_rep);
					$time_start+=24*60*60;
					$time_end+=24*60*60;
					$day_key++;
				}

				break;
			case "week":
				foreach($next_event as $row){
					$post_rep["todo_event_time_start"]=$time_start;
					$post_rep["todo_event_time_end"]=$time_end;
					$post_rep["todo_event_time_real"]=$time_start;
					$this->calendar_db->update_event($row->Id_todo_event, $post_rep);
					$time_start+=7*24*60*60;
					$time_end+=7*24*60*60;
				}
				break;
				//// NEED ADDING PLAN FOR ONE MONTH AND YEAR
			case "none":
					$post_rep["todo_event_time_start"]=$time_start;
					$post_rep["todo_event_time_end"]=$time_end;
					$post_rep["todo_event_time_real"]=$time_start;
					$this->calendar_db->update_event($post["todo_event_id"], $post_rep);
				break;
		}
		return TRUE;
	}
	public function todo_edit($todo_id){
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		$perent_id=$this->calendar_db->get_perent_todo($todo_id);
		if ($_POST){
			$post["todo_short_cut"]=$_POST["todo_short_cut"];
			$post["todo_title"]=$_POST["todo_title"];
			if (isset($_POST["todo_if_all_day"])){ // IF TODO EVENT IS ALL DAY
			$post["todo_if_all_day"]=1;
			}else{
				$post["todo_if_all_day"]=0;
			}
			if (isset($_POST["todo_if_static"])){ // IF TODO EVENT PROTECTED FOR MOVING
				$post["todo_if_static"]=1;
			}else{
				$post["todo_if_static"]=0;
			}
			if (isset($_POST["todo_description"])){
				$post["todo_body"]=$_POST["todo_description"];
			};
			if (isset($_POST["todo_subcon"])){
				$post["todo_if_subhouseman"]=1; // IF TODO EVENT SHARIN WITH USERS
			}else{
				$post["todo_if_subhouseman"]=0;
			}
			if (isset($_POST["todo_repeating"])){ // IF TODO EVENT IS REPEATIN
				if ($_POST["todo_repeating"]!="none"){
					$post["todo_if_repeating"]=1;
				}else{
					$post["todo_if_repeating"]=0;
				}
			}else{
				$post["todo_if_repeating"]=0;
			}
			$this->calendar_db->clear_todo_sub_list($perent_id);
			$this->calendar_db->update_event_head($perent_id, $post);
			$sub_pos["perent_id"]=$perent_id;
			$sub_pos["todo_event_id"]=$todo_id;
			$sub_pos["todo_date_start"]=$_POST["todo_date_start"];
			$sub_pos["todo_time_start"]=$_POST["todo_time_start"];
			$sub_pos["todo_date_end"]=$_POST["todo_date_end"];
			$sub_pos["todo_time_end"]=$_POST["todo_time_end"];
			if (isset($_POST["todo_repeating"])){
				$sub_pos["devider"]=$_POST["todo_repeating"];
			}
			//var_dump($sub_pos);
			$this->replan_time($sub_pos);
			if (isset($_POST["todo_subcon"])){
				foreach($_POST["todo_subcon"] as $key => $value){
					$post_sub=array();
					$post_sub["todo_id"]=$perent_id;
					$post_sub["todo_sub_user"]=$value;
					$this->calendar_db->add_new_event_subcon($post_sub);
				}
			}
			return TRUE;
			//redirect("/staff/todo_overview/".$todo_id);
		}

		$sub_con_list=array();
		foreach($this->calendar_db->get_subcon_list($perent_id) as $row){
			$sub_con_list[]=$row->todo_sub_user;
		};
		$this->data["subcon_list"]=$sub_con_list;
		$this->data["short_cut_list"]=$this->calendar_db->get_short_cuts();
		$this->data["staff_list"]=$this->user_db->get_all_without_housmen($perent_id);
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
		$alert["todo_id"]=$new_event_id;
		$alert["users"][][todo_sub_user]=$this->session->userdata("ses_user_id");
		if (isset($_POST["todo_subcon"])){
			foreach($_POST["todo_subcon"] as $key => $value){
				$post_sub=array();
				$post_sub["todo_id"]=$new_event_id;
				$post_sub["todo_sub_user"]=$value;
				$alert["users"][][todo_sub_user]=$value;
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
			// $plan - Планировщие задачи
			$plan=array();
			$plan["todo_id"]=$new_event_id;
			// IF NEED REPETING TODO EVENT
			$start=$post_event["todo_event_time_start"];
			$end=$post_event["todo_event_time_end"];
			switch($_POST["todo_repeating"]){
				case "day":
				$plan["planning_day"]=1;
				// THIS CASE FOR REPEATIN TODOD EVENT FOR EVERY DAY
				// FIRST STEP IN 30 DAYS
					for($i = 0; $i <= 31; $i++){
						$post_rep["todo_event_time_start"]=$start;
						$post_rep["todo_event_time_end"]=$end;
						$post_rep["todo_event_time_real"]=$start;
						$post_rep["todo_id"]=$new_event_id;
						$this->calendar_db->add_new_event_rep($post_rep);
						$start+=24*60*60;
						$end+=24*60*60;
					}
					break;
				case "week":
				$plan["planning_week"]=1;
				// THIS CASE FOR REPEATIN TODOD EVENT FOR EVERY WEEK
				// FIRST STEP IN 8 WEEKS (2 MOTHES)
					for($i = 0; $i <= 31; $i++){
						$post_rep["todo_event_time_start"]=$start;
						$post_rep["todo_event_time_end"]=$end;
						$post_rep["todo_event_time_real"]=$start;
						$post_rep["todo_id"]=$new_event_id;
						$this->calendar_db->add_new_event_rep($post_rep);
						$start+=7*24*60*60;
						$end+=7*24*60*60;
					}
					break;
					//// NEED ADDING PLAN FOR ONE MONTH AND YEAR
				default:
					break;
			}
			$this->calendar_db->create_planning_task($plan);
		}
		return TRUE;
	}
	// THIS FUNCTION CALLED BY AJAX
	// DELETING TODO EVENT
	public function del_even($id_event, $not_ajax=FALSE){
		$this->load->model("calendar_db");
		$post["todo_status"]=1; // "1" - removed
		$this->calendar_db->update_event($id_event, $post);
		if ($not_ajax){
			redirect("staff/todo");
			return TRUE;
		};
		return TRUE;
	}
	public function del_even_next($id_event, $not_ajax=FALSE){
		$this->load->model("calendar_db");
		$post["todo_status"]=1; // "1" - removed
		$this->calendar_db->update_event_next($id_event, $post);
		if ($not_ajax){
			redirect("/staff/todo");
			return TRUE;
		};
		return TRUE;
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
			$eventsArray['end'] = date("Y-m-d H:i:s", $row->todo_event_time_end);
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
			if ($row->todo_if_static){
				$eventsArray['editable'] = FALSE;
			}
			$events[] = $eventsArray;
		}
		echo json_encode($events);
		return TRUE;
	}
	// THIS FUNCTION CALLED BY AJAX
	public function todo_more_info($id_event, $show=FALSE){
		//$this->load->model("calendar_db");
		//$this->data["event_reviw_data"]=$this->calendar_db->get_more_info_event($id_event);
		$this->load->model("calendar_db");
		$this->load->model("user_db");
		$perent_id=$this->calendar_db->get_perent_todo($id_event);
		//echo $perent_id;
		$sub_con_list=array();
		foreach($this->calendar_db->get_subcon_list($perent_id) as $row){
			$sub_con_list[]=$row->todo_sub_user;
		};
		$this->data["short_cut_list"]=$this->calendar_db->get_short_cuts();
		$this->data["staff_list"]=$this->user_db->get_all_without_housmen($perent_id);
		//var_dump($this->data["staff_list"]); die;
		$this->data["short_cut_list"]=$this->calendar_db->get_short_cuts();
		$this->data["subcon_list"]=$sub_con_list;
		$this->data["todo_overview"]=$this->calendar_db->get_fulll_info_event($id_event);
		//var_dump($this->data["todo_overview"]->todo_if_repeating);die;
		if ($this->data["todo_overview"]->todo_if_repeating==1){
			$this->data["todo_overview"]=$this->calendar_db->get_fulll_info_event_rep($id_event);
		}
		//var_dump($this->data["todo_overview"]);die;
		if ($show){
			$this->load->view("ajax/event_preview", $this->data);
		}else{
			$this->load->view("ajax/event_reviw", $this->data);
		}
		
		return TRUE;
	}
	// THIS FUNCTION CALLED BY AJAX
	// UPADE TODO EVENT BY DROP IN CALENDAR
	public function update_event_drop(){
		$this->load->model("calendar_db");
		if (isset($_POST["upd_time_end"])){
			$post["todo_event_time_end"]=strtotime(substr($_POST["upd_time_end"], 0, -6));
		}
		if (isset($_POST["upd_time_start"])){
			$post["todo_event_time_start"]=strtotime(substr($_POST["upd_time_start"], 0, -6));
		}
		$this->calendar_db->update_event($_POST["upd_event_id"], $post);
		return TRUE;
	}
	// Добвление коментария к делу.
	// This function called by AJAX
	public function add_todo_comment($todo_event_id){
		$this->load->model("calendar_db");
		$_POST["todo_coment"]="<h4>".$this->data["ses_user_s_name"]." ".$this->data["ses_user_name"]."</h4>".$_POST["todo_coment"];
		echo $this->calendar_db->add_todo_comment($_POST, $todo_event_id);
		return TRUE;
	}
	public function completed_event($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=3; // "3" - Ready
		$this->calendar_db->update_event($id_event, $post);
		redirect("staff/todo");
	}
	// Возобновление заврщенного дела
	public function restart_event($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=0; // "0" - Normal
		$this->calendar_db->update_event($id_event, $post);
		redirect("staff/todo");
		return TRUE;
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
	public function settings_notify(){
		$this->load->model("settings_db");
		$this->data["notify_list"]=$this->settings_db->get_all_notify();
		$this->data["content"]="settings/notify";
		$this->load->view("main", $this->data);
	}
	/////// MAIL
	public function inbox(){
		$this->load->model("mail_db");
		//$this->data["mail_list"]=$this->mail_db->get_mail_list($this->session->userdata("ses_user_id"));
		$this->data["content"]="include/mail/inbox";
		$this->load->view('main', $this->data);
	}
	public function outbox(){
		$this->load->model("mail_db");
		//$this->data["mail_list"]=$this->mail_db->get_mail_list($this->session->userdata("ses_user_id"));
		$this->data["content"]="include/mail/outbox";
		$this->load->view('main', $this->data);
	}
	public function load_mail_list($start=FALSE, $end=FALSE){
		$count_page=25;
		$this->load->model("mail_db");
		$total_count=$this->mail_db->count_all_mail_for_id($this->session->userdata("ses_user_id"), "inbox");
		if (!$start and !$end){
			$start=0;
			$end=$count_page;
		}
		if ($start<=0){
			$start=0;
			$end=$start+$count_page;
			$this->data["class_left"]="disabled";
		}else{
			$this->data["class_left"]="paginator";
		}
		if ($end>=$total_count){
			$this->data["class_right"]="disabled";
		}else{
			$this->data["class_right"]="paginator";
		};
		$this->data["start"]=$start;
		$this->data["end"]=$end;
		$this->data["count_page"]=$count_page;
		$this->data["mail_list"]=$this->mail_db->get_user_mail_from_to($start, $end, $this->session->userdata("ses_user_id"));
		$this->load->view("include/mail_list", $this->data);
		return TRUE;
	}
	public function load_mail_list_outgoing($start=FALSE, $end=FALSE){
		$count_page=25;
		$this->load->model("mail_db");
		$total_count=$this->mail_db->count_all_mail_for_id($this->session->userdata("ses_user_id"), "outgoing");
		if (!$start and !$end){
			$start=0;
			$end=$count_page;
		}
		if ($start<=0){
			$start=0;
			$end=$start+$count_page;
			$this->data["class_left"]="disabled";
		}else{
			$this->data["class_left"]="paginator";
		}
		if ($end>=$total_count){
			$this->data["class_right"]="disabled";
		}else{
			$this->data["class_right"]="paginator";
		};
		$this->data["start"]=$start;
		$this->data["end"]=$end;
		$this->data["count_page"]=$count_page;
		$this->data["mail_list"]=$this->mail_db->get_user_mail_from_to_outgoing($start, $end, $this->session->userdata("ses_user_id"));
		$this->load->view("include/mail_list", $this->data);
		return TRUE;
	}
	public function view_mail($folder, $mail_id){
		$this->load->model("mail_db");
		$this->data["mail_dump"]=$this->mail_db->get_mail_dump($mail_id);
		$mark["mail_status"]=1;
		$this->mail_db->mark_mail($mail_id, $mark);
		if ($folder=="outbox"){
			$this->load->view('ajax/mail_body_content_outgoing', $this->data);
		}
		if ($folder=="inbox"){
			$this->load->view('ajax/mail_body_content', $this->data);
		}
		return TRUE;
	}
	public function forvard_email($mail_id){
		$this->load->model("mail_db");
		$config = Array(
			'mailtype' => 'html',
			'charset' => 'utf-8',
		);
		$this->load->library('email', $config);
		$mail_dump=$this->mail_db->get_mail_dump($mail_id);
		$resiver=explode(",", $_POST["resiver"]);
		foreach($resiver as $row){
			$row=trim($row);
			if (filter_var($row, FILTER_VALIDATE_EMAIL)){
				$this->email->from($mail_dump["body"]->mail_toaddress);
				$this->email->to($row);
				$this->email->subject($_POST["forward_sbj"]);
				$this->email->message($mail_dump["body"]->mail_body);
				foreach($mail_dump["attach"] as $attach){
					$file="files/attaches/".$attach->mail_file_alias;
					file_put_contents(GetInTranslit("temp/".$attach->mail_file_name), file_get_contents($file));
					$this->email->attach(GetInTranslit("temp/".$attach->mail_file_name));
				}
				$this->email->send();
				////// INSERTING TO DB
				$mail_dump["body"]->mail_subject=$_POST["forward_sbj"];
				$mail_dump["body"]->mail_from=$mail_dump["body"]->mail_toaddress;
				$mail_dump["body"]->mail_from_str=$this->session->userdata("ses_user_s_name")." ".$this->session->userdata("ses_user_name");
				$mail_dump["body"]->mail_toaddress=$row;
				$mail_dump["body"]->mail_toaddress_str=$row;
				$mail_dump["body"]->mail_reply_to=$mail_dump["body"]->mail_toaddress;
				$mail_dump["body"]->mail_reply_to_str=$mail_dump["body"]->mail_toaddress;
				$mail_dump["body"]->if_outgoing=1;
				unset($mail_dump["body"]->Id_mail_box);
				$new_id=$this->mail_db->insert_header_mail($mail_dump["body"]);
				foreach($mail_dump["attach"] as $attach){
					var_dump($attach);
					unset($attach->Id_mail_attach);
					$attach->mail_id=$new_id;
					$this->mail_db->insert_attach_mail($attach);
				}
				
			}
		}
	}
	// Пометить прочтенным
	public function seen_mail($mail_id){
		$this->load->model("mail_db");
		$mark["mail_status"]=1;
		$this->mail_db->mark_mail($mail_id, $mark);
		return TRUE;
	}
	public function delet_mail($mail_id){
		$this->load->model("mail_db");
		$mark["mail_status"]=2;
		$this->mail_db->mark_mail($mail_id, $mark);
		return TRUE;
	}
	public function compse(){
		$this->load->model("mail_db");
		if ($_POST){
			//var_dump($_POST);
			$config = Array(
				'mailtype' => 'html',
				'charset' => 'utf-8',
			);
			$this->load->library('email', $config);
			$this->email->from($_POST["mail_from"], $this->session->userdata("ses_user_s_name")." ".$this->session->userdata("ses_user_name"));
			$this->email->to($_POST["mail_toaddress"]); 
			$this->email->bcc($_POST["to_bcc"]); 
			$this->email->subject($_POST["mail_subject"]);
			$this->email->message($_POST["mail_body"]);
			$this->email->send();
			$mail_dump["mail_hosman"]=$this->session->userdata("ses_user_id");
			$mail_dump["mail_subject"]=$_POST["mail_subject"];
			$mail_dump["mail_body"]=$_POST["mail_body"];
			$mail_dump["mail_from"]=$_POST["mail_from"];
			$mail_dump["mail_from_str"]=$this->session->userdata("ses_user_s_name")." ".$this->session->userdata("ses_user_name");
			$mail_dump["mail_date"]=date(DATE_RFC2822);
			$mail_dump["mail_toaddress_str"]=$_POST["mail_toaddress"];
			$mail_dump["if_outgoing"]=1;
			$this->mail_db->insert_header_mail($mail_dump);
			redirect("/staff/outbox");
			return TRUE;
		}
		$this->data["user_mail"]=$this->mail_db->get_mail_boxes_for_user_by_id($this->session->userdata("ses_user_id"));
		$this->data["content"]="include/mail/mail_compose";
		$this->load->view('main', $this->data);
		return TRUE;
	}
	

	
	///////////////////////////////////////////////////////////////////////////////////
	//////// CRON PART 1 (TODO)
	public function clone_day_event(){
		$this->load->model("calendar_db");
		$curent_day=date("d", time());
		$curent_month=date("m", time());
		$curent_year=date("y", time());
		$future=$curent_year."-".$curent_month."-".$curent_day;
		$future_time=strtotime($future."+1 month");
		$future_month=date("m", $future_time);
		$future_year=date("y", $future_time);
		$num_of_future_day=date("t", $future_time);
		//echo "<br>";
		$future_time_stamp=strtotime($future_year."-".$future_month."-".$num_of_future_day)+24*60*60;
		foreach ($this->calendar_db->get_repeating_day() as $row){
			$end_time=$this->calendar_db->get_end_planning_time($row->todo_id);
			$end_month=date("m", $end_time->todo_event_time_real);
			echo $end_day=date("d", $end_time->todo_event_time_real);
			$duration_todo_event=$end_time->todo_event_time_start-$end_time->todo_event_time_end;
			//echo $duration_todo_event;
			if ($future_month==$end_month){
				echo "OK<br>";
				if ($num_of_future_day>$end_day){
					echo "KO<br>";
					$cron_time=$end_time->todo_event_time_real+24*60*60;
					echo $cron_time."<br>";
					echo $future_time_stamp."<br>";
					while($future_time_stamp>=$cron_time){
						//echo "Here<br>";
						$post_rep["todo_event_time_start"]=$cron_time;
						$post_rep["todo_event_time_end"]=$cron_time+$duration_todo_event;
						$post_rep["todo_event_time_real"]=$cron_time;
						$post_rep["todo_id"]=$row->todo_id;
						$this->calendar_db->add_new_event_rep($post_rep);
						$cron_time+=24*60*60;
					}
					
					
						
				}
			}
			
			//var_dump($end_time);
		}
		echo "Alive";
	}

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */