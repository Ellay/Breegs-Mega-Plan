<?php
$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
$formatter->setPattern('d MMMM'." в ".'H:m');
//var_dump($todo_overview);
?>
<style>
.note-editor {
	height: auto !important;
}
.form-control, .default{
	#height: 22px !important;
	#font-size: 12px;
	#padding: 0px 12px;
}
.form-group{
	margin-bottom: 8px !important;
}
.note-editor .note-toolbar{
	padding-bottom: 0 !important;
	padding-top: 0 !important;
	border: 1px solid #ddf !important;
}
.note-editor{

	border: 1px solid #ddf !important;
}
.note-editable {
	padding-bottom: 0 !important;
	padding-top: 0 !important;
}
.note-editor .btn-sm, .note-editor .btn-xs {
padding: 5px 10px;
font-size: 9px;
line-height: 1.5;
border-radius: 3px;
}
</style>
<div class="ibox float-e-margins">
	<div class="col-lg-6" style="padding-left: 0;">
		<h2 style="margin-top: 2px;"><?php echo $todo_overview->todo_title?> <span class="label label-info" style="background-color: <?php echo $todo_overview->short_cut_bgcolor?>; color:<?php echo $todo_overview->short_cut_txcolor?>;"><?php echo $todo_overview->short_cut_title?></span> <?php if ($todo_overview->todo_if_all_day==1)echo '<i class="fa fa-circle-o-notch"></i>';?> <?php if ($todo_overview->todo_if_static==1)echo '<i class="fa fa-lock"></i>';?> <?php if ($todo_overview->todo_if_repeating==1)echo '<i class="fa fa-retweet"></i>';?>  <?php if ($todo_overview->todo_if_subhouseman==1)echo '<i class="fa fa-share-alt"></i>';?></h2>
	</div>
	<div class="col-lg-6">
		<a class="pull-right" onclick="cancel_event()" style="margin-right: -15px; color: rgb(28, 132, 198);">
			<i class="fa fa-times fa-2x"></i>
		</a>
	</div>
	<div class="ibox-content" style="padding: 0;">
		<div class="row" style="margin-bottom: 15px;">
			<div class="col-sm-7">
				<address style="margin-bottom: 0;">
					<strong>Постановщик: </strong><br>
					<?php echo $todo_overview->user_s_name." ".$todo_overview->user_name?>
				</address>
				<address style="margin-bottom: 0;">
					<strong>Участник(и):</strong><br>
					<?php
					$key=0;
					foreach($staff_list as $row){
						if (in_array($row->Id_user, $subcon_list)){
							if ($key>0)echo ", ";
							echo $row->user_s_name." ".$row->user_name;
							$key++;
						};
					};
					?>
				</address>
			</div>
			<div class="col-sm-5 text-right">
				<h4>Событие No.</h4>
				<h4 class="text-navy">TD-<?php echo $todo_overview->Id_todo_event?></h4>
					<span><strong>Начало: </strong> <?php echo $formatter->format($todo_overview->todo_event_time_start);?></span><br>
					<span><strong>Конец:</strong> <?php echo $formatter->format($todo_overview->todo_event_time_end)?></span>
			</div>
		</div>
		<?php if ($todo_overview->todo_body):?>
			<h3>Описание</h3>
			<div class="well m-t" style="margin-top: 5px;">
				<?php echo $todo_overview->todo_body?>
			</div>
		<?php endif?>
			<div class="col-lg-8" style="padding-left: 0;">
				<?php if($todo_overview->todo_status==0):?>
					<button class="btn btn-primary " type="button" id="completed_event" data-rel="<?php echo $todo_overview->Id_todo_event?>"><i class="fa fa-check"></i> Завершить событие</button>
				<?php endif?>
				<?php if($todo_overview->todo_status==3):?>
					<button class="btn btn-primary " type="button" id="restart_event" data-rel="<?php echo $todo_overview->Id_todo_event?>"><i class="fa fa-check"></i> Возобновить событие</button>
				<?php endif?>
				<?php if ($todo_overview->todo_status==0):?>
				<button class="btn btn-primary " type="button" id="red" data-rel="<?php echo $todo_overview->Id_todo_event?>"><i class="fa fa-check" ></i> Редактировать</button>
				<?php endif?>
			</div>
			<?php if ($todo_overview->todo_status==0):?>
			<div class="col-lg-4 text-right" style="padding-right: 0;">
				<div class="input-group-btn" style="display: inline-block;width: auto;">
				<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">Удалить <span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="/staff/del_even/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_one" data-rel="<?php echo $todo_overview->Id_todo_event?>">Удалить это событие</a></li>
					<?php if($todo_overview->todo_if_repeating):?>
					<li><a href="/staff/del_even_next/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_next" data-rel="<?php echo $todo_overview->Id_todo_event?>">Удалить все следующие</a></li>
					<?php endif?>
				</ul>
			</div>
			</div>
			<?php endif?>

			<div class="row col-lg-12">
			<h3>Комментарии:</h3>
				<div id="comment_result">
					<?php echo $todo_overview->todo_coment?>
				</div>
				
			</div>

		<?php if($todo_overview->todo_status==0):?>
			<div class="form-group col-lg-12" style="margin-top: 5px; padding: 0">
				<textarea name="todo_comment" class="form-control" id="todo_comment"></textarea>
				<a href="/staff/add_todo_comment/<?php echo $todo_overview->Id_todo_event?>" class="btn btn-success btn-facebook btn-xs" id="add_comment" style="margin-top: 5px" data-rel="<?php echo $todo_overview->Id_todo_event?>">
					 Коментировать
				</a>
			</div>
		<?php endif?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#red").click(function(){
			var event_id=$(this).attr("data-rel")
			$.ajax({
				type: "POST",
				url: "/staff/todo_more_info/"+event_id,
				//url: "/staff/todo_more_info/"+event_id,
				success: function(req){
					$('.event-r').html(req);
				}
			});
		})
		$("#completed_event").click(function(){
			var event_id=$(this).attr("data-rel");
			console.log(calEvent_teleport);
			$.ajax({
				type: "POST",
				url: "/staff/completed_event/"+event_id,
				success: function(req){
					cancel_event();
					calEvent_teleport.className = "todo_completed";
					$('#calendar').fullCalendar('updateEvent', calEvent_teleport);
					calEvent_teleport=null;
				}
			});
			return false;
		})
		$("#restart_event").click(function(){
			var event_id=$(this).attr("data-rel");
			console.log(calEvent_teleport);
			$.ajax({
				type: "POST",
				url: "/staff/restart_event/"+event_id,
				success: function(req){
					cancel_event();
					calEvent_teleport.className = "";
					$('#calendar').fullCalendar('updateEvent', calEvent_teleport);
					calEvent_teleport=null;
				}
			});
			return false;
		})
		$("#dell_one").click(function(){
			var url=$(this).attr("href");
			var event_id=$(this).attr("data-rel");
			$.ajax({
				type: "POST",
				url: url,
				success: function(req){
					cancel_event();
					$('#calendar').fullCalendar( 'removeEvents', event_id )
				}
			});
			return false;
		})
		$("#add_comment").click(function(){
			var url=$(this).attr("href");
			var data="todo_coment="+$("#todo_comment").val();
			
			$.ajax({
				type: "POST",
				url: url,
				data:data,
				success: function(req){
					//cancel_event();
					$('#comment_result').html(req);
					$("#todo_comment").val("");
				}
			});
			return false;
		})
		
	})
</script>
