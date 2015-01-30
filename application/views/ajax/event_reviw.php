<?php
$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
$formatter->setPattern('d MMMM YYYY'." в ".'H:m');
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
		<h3>Редактирование</h3>
	</div>
	<div class="col-lg-6">
		<a class="pull-right" onclick="cancel_event()" style="margin-right: -15px; color: rgb(28, 132, 198);">
			<i class="fa fa-times fa-2x"></i>
		</a>
	</div>
	<div class="ibox-content" style="padding: 0;">
		<div class="row" style="margin-top: 10px;">
			<form method="POST" action="/staff/todo_edit/<?php echo $todo_overview->Id_todo_event ?>" id="event_form">
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

			<div class="form-group col-lg-4">
				<label>Дата начала</label><br>
				<input type="text" placeholder="" class="form-control bt_date" name="todo_date_start" id="todo_date_start" value="<?php echo date("Y-m-d", $todo_overview->todo_event_time_start)?>" style="width: 60%; float: left;"><input type="text" placeholder="" class="form-control bt_time" name="todo_time_start" id="todo_time_start" value="<?php echo date("H:i", $todo_overview->todo_event_time_start)?>" style="width: 40%">
			</div>
			<div class="form-group col-lg-4">
				<label>Дата окончания</label>
				<input type="text" placeholder="" class="form-control bt_date" name="todo_date_end" id="todo_date_end" value="<?php echo date("Y-m-d", $todo_overview->todo_event_time_end)?>" style="width: 60%; float: left;"><input type="text" placeholder="" class="form-control bt_time" name="todo_time_end" id="todo_time_end" value="<?php echo date("H:i", $todo_overview->todo_event_time_end)?>" style="width: 40%">
			</div>
			<div class="form-group col-lg-2">
				<label>Весь день</label>
				<br>
				<input type="checkbox" class="i-checks" name="todo_if_all_day" <?php if ($todo_overview->todo_if_all_day==1)echo "checked";?>>
			</div>
			<div class="form-group col-lg-2">
				<label>Заморозить</label>
				<br>
				<input type="checkbox" class="i-checks" name="todo_if_static" <?php if ($todo_overview->todo_if_static==1)echo "checked";?>>
			</div>
			<div class="row"></div>
			<?php if ($todo_overview->todo_if_repeating):?>
			<div class="form-group col-lg-6" style="margin-bottom: 5px">
				<label>Повтор</label>
				<select class="form-control" name="todo_repeating">
					<option value="none">Не повторять</option>
					<option value="day" <?php if (isset($todo_overview->planning_day))echo "selected"?>>Каждый день</option>
					<option value="week" <?php if (isset($todo_overview->planning_week))echo "selected"?>>Каждую неделю</option>
				</select>
			</div>
			<?php endif?>
			<div class="form-group col-lg-12" style="margin-top: 5px;">
				<textarea name="todo_description" class="form-control" id="todo_description"><?php echo $todo_overview->todo_body?></textarea>
			</div>
			<div class="form-group col-lg-12" style="margin-bottom: 0; margin-top: 8px">
			<label>Участники события</label>
				<div class="input-group">
				<select data-placeholder="Выберите участников" class="chosen-select form-control col-lg-12" multiple style="" tabindex="2" name="todo_subcon[]">
				<?php foreach($staff_list as $row):?>
				<option <?php if (in_array($row->Id_user, $subcon_list)) echo "selected"?> value="<?php echo $row->Id_user; ?>"><?php echo $row->user_s_name." ".$row->user_name; ?></option>
				<?php endforeach?>
				</select>
				</div>
			</div>
			<div class="form-group col-lg-12" style="margin-top: 15px;">
				 <button id="save_ch" class="btn btn-success "  type="submit" style="margin-left: 5px;" data-rel="<?php echo $todo_overview->Id_todo_event?>"><i class="fa fa-floppy-o"></i> Сохранить изменения</button>
				<div class="input-group-btn pull-right" style="display: inline-block;width: auto;">
					<button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-outline" type="button">Удалить <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="/staff/del_even/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_one">Удалить это событие</a></li>
						<li><a href="/staff/del_even_next/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_next" data-rel="<?php echo $todo_overview->Id_todo_event?>">Удалить все следующие</a></li>
						<li class="divider"></li>
						<li><a href="/staff/del_even/<?php echo $todo_overview->Id_todo_event?>/not_ajax" id="dell_all" data-rel="<?php echo $todo_overview->Id_todo_event?>">Удалить все события серии</a></li>
					</ul>
				</div>
			</div>
			</form>
					
		</div>
	</div>
</div>


<script type="text/javascript">
	//// SWITTCER
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});


	$(document).ready(function(){
		
		$("#save_ch").click(function(){
			/// SUMMERNOTE
			var content = $('textarea[name="todo_description"]').html($('#todo_description').code());
			var data=$("#event_form").serialize();
			var event_id=$(this).attr("data-rel");
			
			//$('#calendar').fullCalendar('renderEvent', event,true;
			$("#modal-form-r").modal("hide");
			$.ajax({
				type: "POST",
				url: "/staff/todo_edit/"+event_id,
				data: data,
				success: function(req){
					$('#calendar').fullCalendar('refetchEvents');
				}
			});
			return false;
		})
		
		
		//// SUMMERNOTE
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