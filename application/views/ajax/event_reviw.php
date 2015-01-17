<?php
$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
$formatter->setPattern('d MMMM YYYY'." в ".'H:m');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-7">
		<h5><?php echo $event_reviw_data->todo_title ?></h5>
		<ol class="breadcrumb">
			<li class="active">
			<strong><?php echo $formatter->format($event_reviw_data->todo_event_time_start);?> <?php if ($event_reviw_data->todo_if_subhouseman)echo '<i class="fa fa-refresh"></i>'?></strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-5">
		<div class="title-action_addition">
		
			<a href="#" class="btn btn-outline btn-danger close_more_info"><i class="fa fa-times"></i></a>
		</div>
	</div>
</div>
<p><?php echo $event_reviw_data->todo_body?></p>
<?php if($event_reviw_data->todo_if_subhouseman):?>
<h5 class="tag-title">Участники</h5>
<ul class="tag-list">
	<li><a href="">Family</a></li>
	<li><a href="">Work</a></li>
</ul>
<?php endif?>
<a href="/staff/todo_overview/<?php echo $event_reviw_data->Id_todo?>">Подробно</a><br>
<div class="row">
	<div class="col-lg-10">
	<?php if ($event_reviw_data->todo_status==0):?>
			<button type="button" class="btn btn-primary btn-sm btn-block toddo_complate" data-rel="<?php echo $event_reviw_data->Id_todo_event?>"><i class="fa fa-info-circle"></i> Завершить</button>
	<?php endif?>
		
	</div>

	<div class="col-lg-2 text-right">
	<?php
	if ($event_reviw_data->todo_status==0){
		echo "<button type='button' class='btn btn-primary btn-sm btn-block del_event'  data-rel='$event_reviw_data->Id_todo'><i class='fa fa-trash-o'></i></button>";
	}
	?>
	</div>
</div>
