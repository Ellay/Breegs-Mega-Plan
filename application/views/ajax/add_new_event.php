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
//var_dump($staff_list);
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
		<h3>Создание нового события</h3>
	</div>
	<div class="col-lg-6">
		<a class="pull-right" onclick="cancel_event()" style="margin-right: -15px; color: rgb(28, 132, 198);">
			<i class="fa fa-times fa-2x" onclick="cancel_event()"></i>
		</a>
	</div>
	<div class="ibox-content" style="padding: 0;">
		<div class="row" style="margin-top: 10px;">
			<form method="POST" action="/staff/add_new_event/" id="event_form">
			<div class="form-group col-lg-4">
				<label>Тип события</label>
				<select class="form-control" name="todo_short_cut">
					<?php
					foreach($short_cut_list as $row){
						echo "<option value='$row->Id_short_cut'>$row->short_cut_title</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group col-lg-8">
				<label>Заголовок</label>
				<input type="text" placeholder="" class="form-control" name="todo_title" id="todo_title" value="">
			</div>

			<div class="form-group col-lg-4">
				<label>Дата начала</label><br>
				<input type="text" placeholder="" class="form-control bt_date" name="todo_date_start" id="todo_date_start" value="<?php echo $date_start?>" style="width: 60%; float: left;"><input type="text" placeholder="" class="form-control bt_time" name="todo_time_start" id="todo_time_start" value="<?php echo $time_start?>" style="width: 40%">
			</div>
			<div class="form-group col-lg-4">
				<label>Дата окончания</label>
				<input type="text" placeholder="" class="form-control bt_date" name="todo_date_end" id="todo_date_end" value="<?php echo $date_end?>" style="width: 60%; float: left;"><input type="text" placeholder="" class="form-control bt_time" name="todo_time_end" id="todo_time_end" value="<?php echo $time_end?>" style="width: 40%">
			</div>
			<div class="form-group col-lg-2">
				<label>Весь день</label>
				<br>
				<input type="checkbox" class="i-checks" name="todo_if_all_day">
			</div>
			<div class="form-group col-lg-2">
				<label>Заморозить</label>
				<br>
				<input type="checkbox" class="i-checks" name="todo_if_static">
			</div>
			<div class="row"></div>
			<div class="form-group col-lg-6" style="margin-bottom: 5px">
				<label>Повтор</label>
				<select class="form-control" name="todo_repeating">
					<option value="none">Не повторять</option>
					<option value="day">Каждый день</option>
					<option value="week">Каждую неделю</option>
					<option value="month">Каждый месяц (Не готово)</option>
					<option value="year">Каждый год (Не готово)</option>
				</select>
			</div>
			<div class="form-group col-lg-12" style="margin-top: 5px;">
				<textarea name="todo_description" class="form-control" id="todo_description"></textarea>
			</div>
			<div class="form-group col-lg-12" style="margin-bottom: 0; margin-top: 8px">
			<label>Участники события</label>
				<div class="input-group">
				<select data-placeholder="Выберите участников" class="chosen-select form-control col-lg-12" multiple style="" tabindex="2" name="todo_subcon[]">
				<?php foreach($staff_list as $row):?>
				<option  value="<?php echo $row->Id_user; ?>"><?php echo $row->user_s_name." ".$row->user_name; ?></option>
				<?php endforeach?>
				</select>
				</div>
			</div>
			<br>
			<div class="form-group col-lg-12" style="margin-top: 15px;">
				<button id="save_ch" class="btn btn-success "  type="submit" id="created_event" style="margin-left: 5px;"><i class="fa fa-floppy-o"></i> Создать событие</button>
			</div>
			</form>
					
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#event_form").submit(function(){
			var date_new=$("#todo_date_start").val().split('-');
			var time_new=$("#todo_time_start").val().split(':');
			var date_new_end=$("#todo_date_end").val().split('-');
			var time_new_end=$("#todo_time_end").val().split(':');
			var start=new Date(date_new[0], Number(date_new[1])-1, date_new[2], time_new[0], time_new[1]);
			var end=new Date(date_new_end[0], Number(date_new_end[1])-1, date_new_end[2], time_new_end[0], time_new_end[1]);
			//var event['title']=$("#todo_title").val();
			//var event['start']=start;
			//var event['end']=end;
			var data=Array();
			/// SUMMERNOTE
			var content = $('textarea[name="todo_description"]').html($('#todo_description').code());
			var data=$("#event_form").serialize();
			//$('#calendar').fullCalendar('renderEvent', event,true;
			$("#modal-form-r").modal("hide");
			$.ajax({
				type: "POST",
				url: "/staff/add_new_event/",
				data: data,
				success: function(req){
					$('#calendar').fullCalendar('refetchEvents');
				}
			});
			return false;
		})

		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		$('#todo_description').summernote({
			 toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough']],
				['fontsize', ['fontsize']],
				['para', ['ol', 'paragraph']],
				['height', ['height']],
			],
			height:95,
			onChange: function(contents, $editable) {
				$("#save_ch").show();
			}
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
		var config = {
			'.chosen-select'		   : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'	 : {width:"95%"}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
	})
</script>
































