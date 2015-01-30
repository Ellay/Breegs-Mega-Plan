<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("ses_is_loged")){
			redirect("/");
			return TRUE;
		}
		return TRUE;
	}
	
	/*dtrhdbghdrt*/
/**
	public function update_event(){
		$this->load->model("calendar_db");
		if (isset($_POST["upd_time_end"])){
			$post["todo_time_end"]=strtotime($_POST["upd_time_end"]);
		}
		if (isset($_POST["upd_time_start"])){
			$post["todo_time_start"]=strtotime($_POST["upd_time_start"]);
		}
		$this->calendar_db->update_event($_POST["upd_event_id"], $post);
	}
	public function get_event($id_event){
		$this->load->model("calendar_db");
		$this->data["event_reviw_data"]=$this->calendar_db->get_more_info_event($id_event);
		$this->load->view("ajax/event_reviw", $this->data);
	}
	
	public function complate_event($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=3; // "3" - Complated
		$this->calendar_db->update_event($id_event, $post);
	}
	public function restart_event($id_event){
		$this->load->model("calendar_db");
		$post["todo_status"]=0; // "0" - Normal
		$this->calendar_db->update_event($id_event, $post);
	}
*/

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */