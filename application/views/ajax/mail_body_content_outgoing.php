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
//var_dump($mail_dump["attach"]);
?>
<div class="mail-box-header">
<div class="ready_todo col-lg-10" id="ready_todo">
	
</div>
	<div class="pull-left tooltip-demo">
		<a class="btn btn-sm btn-white replay_b" href="#"><i class="fa fa-arrow-right"></i> Переслать</a>
		<a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Print email"><i class="fa fa-print"></i> </a>
		<a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>
	</div>
	<h2>
		<br>
	</h2>
	<div class="mail-body" id="replay">
	<form class="form-horizontal" method="POST">
		<div class="form-group"><label class="col-sm-2 control-label">Кому:</label>
			<div class="col-sm-10"><input type="text" class="form-control"  name="forward_resiver" id="forward_resiver"></div>
		</div>
		<div class="form-group"><label class="col-sm-2 control-label">Тема:</label>
			<div class="col-sm-10"><input type="text" class="form-control" value="Fwd: <?php echo $mail_dump["body"]->mail_subject;?>" name="forward_sbj" id="forward_sbj"></div>
		</div>

		<div class="mail-body text-right tooltip-demo">
			<a href="#" onclick="bla()" class="btn btn-sm btn-primary" id="replay_send"><i class="fa fa-reply"></i> Отправить</a>
			<a href="mailbox.html" class="btn btn-white btn-sm replay_b"><i class="fa fa-times"></i> Отменить</a>
		</div>
	</form>
</div>
	<div class="mail-tools tooltip-demo m-t-md">
		<h3>
			<span class="font-noraml">Тема: </span><?php echo $mail_dump["body"]->mail_subject;?>
		</h3>
		<h5>
		<span class="font-noraml">От: </span><?php echo $mail_dump["body"]->mail_from." (".$mail_dump["body"]->mail_from_str.")" ?><br><br>
			<span class="pull-left font-noraml"><?php echo $mail_dump["body"]->mail_date?></span>
			
		</h5>
	</div>
</div>
<div class="mail-box">
<div class="mail-body">
	<?php echo ClearStyle($mail_dump["body"]->mail_body)?>
</div>
<?php if($mail_dump["body"]->mail_attach==1):?>
<div class="mail-attachment">
	<p>
		<span><i class="fa fa-paperclip"></i> <?php echo count($mail_dump["attach"])?> вложение(я) - </span>
	</p>
	<div class="attachment">
	<?php foreach($mail_dump["attach"] as $row):?>
		<div class="file-box">
			<div class="file">
				<a href="/get_files/attaches/<?php echo $row->mail_file_alias?>" target="_blank">
					<span class="corner"></span>
					<div class="icon">
						<i class="fa fa-file"></i>
					</div>
					<div class="file-name">
						<?php echo $row->mail_file_name?>
						<br>
						<small>Раззмер: <?php echo $row->mail_bytes?></small>
					</div>
				</a>
			</div>
		</div>
	<?php endforeach?>
	<div class="clearfix"></div>
	</div>
	</div>
<?php endif?>
	<div class="mail-body text-right tooltip-demo">
			<a class="btn btn-sm btn-white replay_b" href="#replay"><i class="fa fa-arrow-right"></i> Переслать</a>
			<button title="" data-placement="top" data-toggle="tooltip" type="button" data-original-title="Print" class="btn btn-sm btn-white"><i class="fa fa-print"></i> Распечатать</button>
			<button title="" data-placement="top" data-toggle="tooltip" data-original-title="Trash" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Удалить</button>
	</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#replay_send").click(function(){
			console.log("HERE");
			
		})
	})
	function bla(){
		var resiver_str=$("#forward_resiver").val();
		var forward_sbj=$("#forward_sbj").val();
		var mail_id="<?php echo $mail_dump['body']->Id_mail_box?>";
		$.ajax({
			type: "POST",
			url: "/staff/forvard_email/"+mail_id,
			data:"resiver="+resiver_str+"&forward_sbj="+forward_sbj,
			success: function(req){
				$("#forward_resiver").val("");
				$("#replay").hide();
			}
		});
		return false;
	}
</script>