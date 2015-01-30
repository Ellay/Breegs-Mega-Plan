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
	<div class="col-lg-4">
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
	<div class="col-lg-8">
		<div class="title-action">
			<div class="input-group-btn" style="display: inline-block;width: auto;">
				<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">Удалить <span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="/staff/del_even/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_one">Удалить это событие</a></li>
					<li><a href="/staff/del_even_next/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_next" data-rel="<?php echo $todo_overview->Id_todo_event?>">Удалить все следующие</a></li>
					<li class="divider"></li>
					<li><a href="/staff/del_even/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_all" data-rel="<?php echo $todo_overview->Id_todo_event?>">Удалить все события серии</a></li>
				</ul>
			</div>
			<a href="/staff/todo_edit/<?php echo $todo_overview->Id_todo_event?>" class="btn btn-white"><i class="fa fa-pencil"></i> Редактировать</a>
			<?php if($todo_overview->todo_status==0):?>
				<a href="/staff/completed_event/<?php echo $todo_overview->Id_todo_event?>" class="btn btn-white"><i class="fa fa-check "></i> Завершить</a>
			<?php endif?>
			<?php if($todo_overview->todo_status==3):?>
				<a href="/staff/restart_event/<?php echo $todo_overview->Id_todo_event?>" class="btn btn-white"><i class="fa fa-check "></i> Возобновить</a>
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
						<h4 class="text-navy">Дело #. TD-<?php echo $todo_overview->Id_todo_event?></h4>
						<p>
						<span><strong>Дата начала:</strong> <?php echo $formatter->format($todo_overview->todo_event_time_start);?></span><br/>
						<span><strong>Дата завершения:</strong> <?php echo $formatter->format($todo_overview->todo_event_time_end);?></span><br/>
						| 
						<?php
						foreach($staff_list as $row){
							if (in_array($row->Id_user, $subcon_list)){
								echo $row->user_s_name." ".$row->user_name." |";
							};
						};
						?>
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
	<div class="col-lg-12">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="ibox-content p-xl">
			<h2>Заметки / Коментарии</h2>
			<?php echo $todo_overview->todo_coment?>
		</div>
	</div>
	</div>
</div>