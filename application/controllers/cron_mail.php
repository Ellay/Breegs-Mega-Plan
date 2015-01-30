<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron_mail extends CI_Controller {
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
		$this->load->model("mail_db");
		$this->load->model("alerts_db");
	}
	private function get_body_message($body_msg, $encode_no, $encode_type=FALSE){
		switch($encode_no){
			case 0:
				$body=mb_convert_encoding( $body_msg, $encode_type, "UTF7-IMAP"); # for encoding
				break;
			case 1:
				$body=imap_utf8($body_msg);
				break;
			case 3:
				$body=base64_decode($body_msg);
				break;
			case 4:
				$body=quoted_printable_decode($body_msg);
				break;
			default:
				break;
		}
		if ($encode_type and $encode_type!=="utf-8"){
			$body = mb_convert_encoding($body, 'UTF-8', $encode_type);
		}
		return $body;
	}
	private function mixed_to_utf8($str, $mixed){
		return mb_convert_encoding($str, 'UTF-8', $mixed);
	}
	private function encoder($encode_str){
		$encode_arr = imap_mime_header_decode($encode_str);
		if (count($encode_arr)==0){
			return TRUE;
		}
		$str="";
		for ($i=0; $i<count($encode_arr); $i++) {
			if ($encode_arr[$i]->charset=="default"){
				$str.=$encode_arr[$i]->text;
				continue;
			};
			$str.=$this->mixed_to_utf8($encode_arr[$i]->text, $encode_arr[$i]->charset);
		};
		return $str;
	}
	private function get_Message_groupe_ALTERNATIVE($structure, &$parts){
		foreach($structure->parts as $key => $structure){
			if ($key==0){
				continue;
			};
			$temp["part_no"]=$key+1;
			$temp['type']=$structure->type;
			$temp['encoding']=$structure->encoding;
			$temp['subtype']=$structure->subtype;
			$temp["parameters"]=0;
			if ($structure->ifparameters){
					$temp["parameters"]=$structure->parameters;
			}
			$temp["dparameters"]=0;
			if ($structure->ifdparameters){
				$temp["dparameters"]=$structure->dparameters;
			}
			$temp["disposition"]=0;
			if ($structure->ifdisposition){
				$temp["disposition"]="ATTACHMENT";
			}
		}
		return $parts[] = $temp;
	}
	private function get_Message_groupe($structure, $groupe=FALSE, &$parts){
		if ($structure->type==1){
			if ($structure->subtype=="MIXED"){
				if (!$groupe)$groupe=0;
				foreach ($structure->parts as $part_tm){
						$groupe++;
						$this->get_Message_groupe($part_tm, $groupe, $parts);
				}
			}
			if ($structure->subtype=="RELATED"){
				$groupe=0;
				foreach ($structure->parts as $part_tm){
						$groupe++;
						$this->get_Message_groupe($part_tm, $groupe, $parts);
				}
			}
			if ($structure->subtype=="ALTERNATIVE"){
				if (!$groupe)$groupe=1;
				$sub_groupe=0;
				foreach ($structure->parts as $part_tm){
					$sub_groupe++;
					$part_no=$groupe.".".$sub_groupe;
					if ($part_tm->subtype=="PLAIN"){
						continue;
					}
					$this->get_Message_groupe($part_tm, $part_no, $parts);
				}
			}
		}else{
			$temp["part_no"]=$groupe;
			$temp['type']=$structure->type;
			$temp['encoding']=$structure->encoding;
			$temp['subtype']=$structure->subtype;
			$temp['bytes']=$structure->bytes;
			$temp["parameters"]=0;
			if ($structure->ifparameters){
					$temp["parameters"]=$structure->parameters;
			}
			$temp["dparameters"]=0;
			if ($structure->ifdparameters){
				$temp["dparameters"]=$structure->dparameters;
			}
			$temp["disposition"]=0;
			if ($structure->ifdisposition){
				$temp["disposition"]="ATTACHMENT";
			}
			return $parts[] = $temp;
		}
	}
	private function encode_attach($resurce, $key){
		$resurce_out=array();
		$type = $resurce["type"];
		if ($type == 0){
			$type = "text/";
		}elseif ($type == 1){
			$type = "multipart/";
		}elseif ($type == 2){
			$type = "message/";
		}elseif ($type == 3){
			$type = "application/";
		}elseif ($type == 4){
			$type = "audio/";
		}elseif ($type == 5){
			$type = "image/";
		}elseif ($type == 6){
			$type = "video";
		}elseif($type == 7){
			$type = "other/";
		}
		$resurce_out["mail_file_alias"]=md5($resurce["bytes"].$key.time());
		$resurce_out["mail_mime_type"]=$type .= $resurce["subtype"];
		$resurce_out["mail_file_name"]=$this->encoder($resurce["parameters"][0]->value);
		if (isset($resurce["bytes"])){
			$resurce_out["mail_bytes"]=$resurce["bytes"];
		}else{
			$resurce_out["mail_bytes"]=0;
		}
		return $resurce_out;
	}
	private function get_mail($mail_login, $mail_password, $mail_housmen, $mail_server){
		set_time_limit(0);
		$num_of_mail=0;
		$mail_login=trim($mail_login);
		$mail_password=trim($mail_password);
		if ($mail_server==1){
			$connect = imap_open('{imap.yandex.ru:993/imap/ssl}INBOX', $mail_login, $mail_password);
		}
		if ($mail_server==2){
			$connect = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', $user, $pass);
		}
		/*
		ONLY FOR SRVICE
		if ($connect){
			echo 'Connect successful<br>';
		}else{
			echo 'Connect FALED<br>';
			return FALSE;
		}
		*/
		$mails = imap_search($connect, 'UNSEEN');
		if (!$mails){
			return FALSE;
		}
		foreach ($mails as $mail){
			$num_of_mail++;
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////////// MAIL INIT
			$parts=array(); /// DEFAULT PARTS OF ONE MESSAGE
			$mail_dump=array(); /// MAIN DUMP OF MESSAGE
			$attach_path="files/attaches/";
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////HEADER PART
			$header = imap_header($connect, $mail);
			//var_dump($header);
			if (isset($header->subject)){
				$mail_dump["mail_subject"]=$this->encoder($header->subject);
			}else{
				$mail_dump["mail_subject"]="";
			}
			$mail_dump["mail_toaddress_str"]=$this->encoder($header->toaddress);
			$mail_dump["mail_toaddress"]=$mail_login;
			$mail_dump["mail_from"]=$header->from[0]->mailbox."@".$header->from[0]->host;
			if (isset($header->from[0]->personal)){
				$mail_dump["mail_from_str"]=$this->encoder($header->from[0]->personal);
			}else{
				$mail_dump["mail_from_str"]="";
			}
			$mail_dump["mail_reply_to"]=$header->reply_to[0]->mailbox."@".$header->reply_to[0]->host;
			if (isset($header->reply_to[0]->personal)){
				$mail_dump["mail_reply_to_str"]=$this->encoder($header->reply_to[0]->personal);
			}else{
				$mail_dump["mail_reply_to_str"]="";
			}
			$mail_dump["mail_date"]=$header->date;
			$mail_dump["mail_hosman"]=$mail_housmen;
			$mail_sys_info["mail_id"]=$this->mail_db->insert_header_mail($mail_dump);
			
			//// MAIL ALERTS
			$alerts["relay_id"]=$mail_sys_info["mail_id"];
			$alerts["user_target"]=$mail_housmen;
			$alerts["user_requester"]=0;
			$this->alerts_db->add_new_mail_alerts($alerts);
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////// STRUCTURE PART
			$structure=imap_fetchstructure($connect, $mail);
			if ($structure->type==0){ 
				$body_text = imap_body($connect, $mail);
				$body_text=$this->get_body_message($body_text, $structure->encoding, $structure->parameters[0]->value);
				$mail_dump["mail_body"]=$body_text;
				$this->mail_db->insert_bode_mail($mail_dump, $mail_sys_info["mail_id"]);
				continue;
			}
			if ($structure->subtype=="ALTERNATIVE"){
				// FOR SIMPLE STRUCTURE WITH ALTERNATIVE
				$this->get_Message_groupe_ALTERNATIVE($structure, $parts);
			}else{
				$this->get_Message_groupe($structure, FALSE, $parts);
			}
			foreach($parts as $key => $value){
				$body_text=imap_fetchbody($connect, $mail, $value["part_no"]);
				if ($value["disposition"]){
					/// PART WITH ATTACHEMET
					$body_text=$this->get_body_message($body_text, $value["encoding"]);
					$file_info=$this->encode_attach($value, $key);
					file_put_contents($attach_path.$file_info["mail_file_alias"], $body_text);
					$file_info["mail_id"]=$mail_sys_info["mail_id"];
					$this->mail_db->insert_attach_mail($file_info);
					$mail_dump["mail_attach"]=1;
					//echo "Attach downloaded: ".$this->encoder($file_info["mail_file_name"])."<br>";
				}else{
					/// PART WITH MESSAGE
					$body_text=$this->get_body_message($body_text, $value["encoding"], $value["parameters"][0]->value);
					if ($value["subtype"]=="PLAIN"){
						$mail_dump["mail_body"]=nl2br($body_text);
					}else{
						$mail_dump["mail_body"]=$body_text;
					}
				}
			}
			$this->mail_db->insert_bode_mail($mail_dump, $mail_sys_info["mail_id"]);
			/* SERVICE ONLY
			echo "Mail save completed<br>";
			echo "############################################################################<br>";
			*/
		}
		return $num_of_mail;
	}
	
	// Главная входня функция крона
	public function get_mail_user(){
		set_time_limit(0);
		$this->load->model("user_db");
		$mail_users_info=$this->user_db->get_user_mail_all();
		foreach($mail_users_info as $key => $value){
			echo $key." ".$value->mail_login."<br>";
			$this->get_mail($value->mail_login, $value->mail_password, $value->mail_housman, $value->mail_server);
		}
		return TRUE;
	}
	public function get_mail_one_user($user_id){
		set_time_limit(0);
		$start=0;
		$this->load->model("mail_db");
		$user_info=$this->mail_db->get_mail_boxes_for_user_by_id($user_id);
		foreach($user_info as $key => $value){
			$start=$this->get_mail($value->mail_login, $value->mail_password, $value->mail_housman, $value->mail_server);
		};
		if($start>0){
			echo $start;
		}else{
			echo "NO";
		}
		return TRUE;
	}

}

