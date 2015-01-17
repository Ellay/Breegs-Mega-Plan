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
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Редактирование</h2>
		<ol class="breadcrumb">
			<li>
				Планировщик
			</li>
			<li>
				Список дел
			</li>
			<li class="active">
				<strong>Редактирование</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Horizontal form</h5>
		<div class="ibox-tools">
			<a class="collapse-link">
				<i class="fa fa-chevron-up"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
	<div class="row">
			<form method="POST" action="/staff/todo/" id="event_form">
			<div class="form-group col-lg-4">
				<label>Тип события</label>
				<select class="form-control" name="todo_short_cut">
					<?php
					foreach($short_cut_list as $row){
						if ($todo_overview->Id_short_cut==$row->Id_short_cut){
							echo "<option value='$row->Id_short_cut' selected>$row->short_cut_title</option>";
						}else{
							echo "<option value='$row->Id_short_cut'>$row->short_cut_title</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="form-group col-lg-8">
				<label>Заголовок</label>
				<input type="text" placeholder="" class="form-control" name="todo_title" id="todo_title" value="<?php echo $todo_overview->todo_title?>">
			</div>
			<div class="hr-line-dashed"></div>
			<div class="form-group col-lg-4">
				<label>Дата</label>
				<input type="text" placeholder="" class="form-control bt_date" name="todo_date_start" id="todo_date_start" value="<?php echo date("Y-m-d", $todo_overview->todo_time_start)?>">
			</div>
			<div class="form-group col-lg-4">
				<label>Время</label>
				<input type="text" placeholder="" class="form-control bt_time" name="todo_time_start" id="todo_time_start" value="<?php echo date("H:i", $todo_overview->todo_time_start)?>">
			</div>
			<div class="form-group col-lg-2">
				<label>Весь день</label>
				<br><input type="checkbox" class="js-switch"  data-switchery="true" name="todo_if_all_day" <?php if ($todo_overview->todo_if_all_day==1)echo "checked";?>>
			</div>
			<div class="form-group col-lg-2">
				<label>Заморозить</label>
				<br><input type="checkbox" class="js-switch"  data-switchery="true" name="todo_if_static" <?php if ($todo_overview->todo_if_static==1)echo "checked";?>>
			</div>
			<div class="row"></div>
			<div class="form-group col-lg-3">
				<label>Дата окончания</label>
				<input type="text" placeholder="" class="form-control bt_date" name="todo_date_end" id="todo_date_end" value="<?php echo date("Y-m-d", $todo_overview->todo_time_end)?>">
			</div>
			<div class="form-group col-lg-3">
				<label>Время окончания</label>
				<input type="text" placeholder="" class="form-control bt_time" name="todo_time_end" id="todo_time_end" value="<?php echo date("H:i", $todo_overview->todo_time_end)?>">
			</div>
			<div class="form-group col-lg-6">
				<label>Повтор</label>
				<input type="text" placeholder="" class="form-control" name="" id="">
			</div>
			<div class="form-group col-lg-12">
				<textarea name="todo_description" class="form-control" id="todo_description"><?php echo $todo_overview->todo_body?></textarea>
			</div>
			<div class="form-group col-lg-12">
				<div class="input-group">
				<select data-placeholder="Выберите участников" class="chosen-select" multiple style="width:350px;" tabindex="2">
				<?php foreach($staff_list as $row):?>
				<option <?php if (in_array($row->Id_user, $subcon_list)) echo "selected"?> value="<?php echo $row->Id_user; ?>"><?php echo $row->user_s_name." ".$row->user_name; ?></option>
				<?php endforeach?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4 ">
					<a class="btn btn-white" onclick="cancel_event()">Отменить</a>
					<button class="btn btn-primary" type="submit" id="created_event">Сохранить</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	//// SWITTCER
	$(".js-switch").each(function(){
		var switchery = new Switchery(this, { color: '#1AB394' });
	});
	$(document).ready(function(){
		//// SUMMERNOTE
		$('#todo_description').summernote({
			 toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough']],
				['fontsize', ['fontsize']],
				['para', ['ol', 'paragraph']],
				['height', ['height']],
			]
		});
		$('.bt_date').datetimepicker({
			format:"YYYY-MM-DD",
			pickTime: false,
			language: 'ru'
		});
		$('.bt_time').datetimepicker({
			pickDate: false,
			language: 'ru'
		});
	})
</script>