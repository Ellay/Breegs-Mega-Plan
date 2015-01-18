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
//var_dump($todo_overview);

$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
$formatter->setPattern('d MMMM YYYY'." в ".'H:m');
switch($todo_overview->todo_status){
	case 0:
			$todo_status="Открыто";
		break;
	case 1:
			$todo_status="Удален";
		break;
	case 3:
			$todo_status="Завершено";
		break;
	default:
		break;
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-6">
		<h2>Подробности</h2>
		<ol class="breadcrumb">
			<li>
				<a href="/staff/todo">Планировщик</a>
			</li>
			<li>
				<a href=".staff/todo_list">Список дел</a>
			</li>
			<li class="active">
				<strong>Подробности</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-6">
		<div class="title-action">
			<a href="#" class="btn "><i class="fa fa-pencil"></i> Удалить</a>
			<a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Редактировать</a>
			<?php if($todo_overview->todo_status==0):?>
				<a href="#" class="btn btn-white toddo_complate" data-rel="<?php echo $todo_overview->Id_todo?>"><i class="fa fa-check "></i> Завершить</a>
			<?php endif?>
			<?php if($todo_overview->todo_status==3):?>
				<a href="#" class="btn btn-white toddo_restart" data-rel="<?php echo $todo_overview->Id_todo?>"><i class="fa fa-check "></i> Возобновить</a>
			<?php endif?>
			<?php if($todo_overview->todo_status==2):?>
				<a href="#" class="btn btn-white"><i class="fa fa-check "></i> Востоновить</a>
			<?php endif?>
			<a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Распечатать</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="ibox-content p-xl">
					<div class="row">
						<div class="col-sm-6">
							<h5>Информация:</h5>
							<address>
								<strong><?php echo "Постановщик: ".$todo_overview->user_s_name." ".$todo_overview->user_name?></strong><br>
								<abbr title="Phone number">Моб:</abbr> <?php echo $todo_overview->user_phone?><br>
								<abbr title="E-Mail">E-Mail:</abbr> <?php echo $todo_overview->user_mail?><br>
								<?php echo $todo_overview->todo_time_created?>
							</address>
						</div>
						<div class="col-sm-6 text-right">
							<h4>Статус: <?php echo $todo_status?></h4>
							<h4 class="text-navy">Дело #. TD-<?php echo $todo_overview->Id_todo?></h4>
							<p>
								<span><strong>Дата начала:</strong> <?php echo $formatter->format($todo_overview->todo_event_time_start);?></span><br/>
								<span><strong>Дата завершения:</strong> <?php echo $formatter->format($todo_overview->todo_event_time_end);?></span><br/>
							</p>
						</div>
					</div>
					<h2><?php echo $todo_overview->todo_title?> <?php if ($todo_overview->todo_if_repeating)echo '<i class="fa fa-refresh"></i>';?> <?php if ($todo_overview->todo_if_subhouseman)echo '<i class="fa fa-share-alt"></i>';?></h2>
					<div class="well m-t">
						<?php echo $todo_overview->todo_body?>
					</div>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".title-action").on("click", ".toddo_complate", function(){
		var event_id=$(this).attr("data-rel");
		$.ajax({
			type: "POST",
			url: "/ajax/complate_event/"+event_id,
			success: function(req){
				
			}
		});
		return false;
	})
	$(".title-action").on("click", ".toddo_restart", function(){
		var event_id=$(this).attr("data-rel");
		$.ajax({
			type: "POST",
			url: "/ajax/restart_event/"+event_id,
			success: function(req){
				
			}
		});
		return false;
	})
</script>
