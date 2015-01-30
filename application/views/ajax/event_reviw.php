<?php
$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
$formatter->setPattern('d MMMM YYYY'." в ".'H:m');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?php echo $event_reviw_data->todo_title ?></h2>
		<ol class="breadcrumb">
			<li class="active">
			<strong><?php echo $formatter->format($event_reviw_data->todo_event_time_start);?> <?php if ($event_reviw_data->todo_if_subhouseman)echo '<i class="fa fa-refresh"></i>'?></strong>
			</li>
		</ol>
	</div>
</div>
<p><?php echo $event_reviw_data->todo_body?></p>
<br>
	<a href="/staff/todo_overview/<?php echo $event_reviw_data->Id_todo?>">Подробно</a>
<br>
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
