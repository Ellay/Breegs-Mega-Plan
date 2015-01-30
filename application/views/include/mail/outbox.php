<?php
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
?>

<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-4" id="mail_frame_list"></div>
		<div class="col-lg-8 animated fadeInRight" id="mail_body_content" style="position: relative;"></div>
	</div>
</div>
<script type="text/javascript">
var user_id="<?php echo $this->session->userdata("ses_user_id")?>";
	$(document).ready(function(){
		/// LOAD LIST OF MAIL
		$.ajax({
			type: "POST",
			url: "/staff/load_mail_list_outgoing/",
			success: function(req){
				$('#mail_frame_list').html(req);
				return true;
			}
		});
		$("#mail_frame_list").on("click", ".paginator", function(){
			var path=$(this).attr("data-rel");
			$.ajax({
				type: "POST",
				url: "/staff/load_mail_list/"+path,
				success: function(req){
					$('#mail_frame_list').html(req);
					return true;
				}
			});
		})
		$("#mail_frame_list").on("click", ".mail-contact", function(){
			var path=$(this).attr("data-rel");
			var perent=$(this).parent(".mail_line");
			$.ajax({
				type: "POST",
				url: "/staff/view_mail/outbox/"+path,
				success: function(req){
					$('#mail_body_content').html(req);
					perent.removeClass("unread");
					perent.addClass("read");
					return true;
				}
			});
		})
		$("#mail_body_content").on("click", ".replay_b", function(){
			$("#replay").toggle();
			return false;
		})
		$("#mail_body_content").on("click", "#replay_send", function(){
			$("#replay").toggle();
			return false;
		})
		$("#mail_frame_list").on("click", ".mark-read", function(){
			$("input.marking:checked").each(function(){
				var active=$(this);
				var mail_id=active.val();
				var perent=$(this).parents("tr:first");
				console.log(perent);
				$.ajax({
					type: "POST",
					url: "/staff/seen_mail/"+mail_id,
					success: function(req){
						$(active).prop( "checked", false );
						perent.removeClass("unread");
						perent.addClass("read");
					}
				});
			})
			return false;
		})
		$("#mail_frame_list").on("click", ".mark-delet", function(){
			$("input.marking:checked").each(function(){
				var active=$(this);
				var mail_id=active.val();
				var perent=$(this).parents("tr:first");
				//console.log(perent);
				$.ajax({
					type: "POST",
					url: "/staff/delet_mail/"+mail_id,
					success: function(req){
						$(active).prop( "checked", false );
						perent.remove();

					}
				});
			})
			return false;
		})
		$("#mail_frame_list").on("click", ".cron-reload", function(){
			var action=$(this);
			action.addClass("fa-spin");
			$.ajax({
				type: "POST",
				url: "/cron_mail/get_mail_one_user/"+user_id,
				success: function(req){
				if (req){
					if (req=="NO"){
						console.log("HERE NO");
					}else{
						$.ajax({
							type: "POST",
							url: "/staff/load_mail_list/",
							success: function(req){
								$('#mail_frame_list').html(req);
								return true;
							}
						});
					}
					
				}
				action.removeClass("fa-spin");
					
				}
			});
			return true;
		})
	})
</script>