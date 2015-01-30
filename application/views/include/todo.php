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
	<div class="row animated fadeInDown">
	<div class="row">
	<div class="col-lg-9">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Календарь моих дел</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Добавить дело</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">

			</div>
		</div>
	</div>
	</div>
	</div>
</div>
<div id="modal-form-r" class="modal fade" aria-hidden="true" style="display: none;" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="padding: 10px 30px 0px 30px;">
				<div class="row event-r">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-4" id="more_info">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
		<div class="file-manager" id="event_content">
		
		</div>
		</div>
	</div>
</div>
<div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
				<h2>Создание нового события</h2>
						<form method="POST" action="/staff/todo/" id="event_form">
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
								<input type="text" placeholder="" class="form-control" name="todo_title" id="todo_title" >
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group col-lg-3">
								<label>Дата</label>
								<input type="text" placeholder="" class="form-control bt_date" name="todo_date_start" id="todo_date_start">
							</div>
							<div class="form-group col-lg-3">
								<label>Время</label>
								<input type="text" placeholder="" class="form-control bt_time" name="todo_time_start" id="todo_time_start">
							</div>
							<div class="form-group col-lg-3">
								<label>Весь день</label>
								<br><input type="checkbox" class="js-switch"  data-switchery="true" name="todo_if_all_day">
							</div>
							<div class="form-group col-lg-3">
								<label>Заморозить</label>
								<br><input type="checkbox" class="js-switch"  data-switchery="true" name="todo_if_static">
							</div>
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Уточнить дату и время</h5>
									<div class="ibox-tools">
										<a class="collapse-link sub-hide">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">
									<div class="form-group col-lg-3">
										<label>Дата окончания</label>
										<input type="text" placeholder="" class="form-control bt_date" name="todo_date_end" id="todo_date_end">
									</div>
									<div class="form-group col-lg-3">
										<label>Время окончания</label>
										<input type="text" placeholder="" class="form-control bt_time" name="todo_time_end" id="todo_time_end">
									</div>
									<div class="form-group col-lg-6">
										<label>Повтор</label>
										<select class="form-control" name="todo_repeating">
											<option value="none">Не повторять</option>
											<option value="day">Каждый день</option>
											<option value="week">Каждую неделю</option>
											<option value="month">Каждый месяц</option>
											<option value="year">Каждый год</option>
										</select>
									</div>
								</div>
							</div>
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Добавить описание</h5>
									<div class="ibox-tools">
										<a class="collapse-link sub-hide">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">
									<textarea name="todo_description" class="form-control" id="todo_description"></textarea>
								</div>
							</div>
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Добавить участников</h5>
									<div class="ibox-tools">
										<a class="collapse-link  sub-hide">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">
									<div class="form-group">
										<div class="input-group">
										<select data-placeholder="Выберите участников" class="chosen-select" multiple style="width:350px;" tabindex="2" name="todo_subcon[]">
										<?php foreach($staff_list as $row):?>
										<option value="<?php echo $row->Id_user; ?>"><?php echo $row->user_s_name." ".$row->user_name; ?></option>
										<?php endforeach?>
										</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-4 col-sm-offset-2">
									<a class="btn btn-white" onclick="cancel_event()">Отменить</a>
									<button class="btn btn-primary" type="submit" id="created_event">Создать</button>
								</div>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modal-form_add_new_event" class="modal fade" aria-hidden="true" style="display: none;" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-body">

</div>
</div>
</div>
</div>
<script type="text/javascript">
	var calEvent_teleport;
	$(document).ready(function() {

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
		//// SWITTCER
		$(".js-switch").each(function(){
			var switchery = new Switchery(this, { color: '#1AB394' });
		});
		
		/// MORE INFO 
		$("#event_content").on("click", ".close_more_info", function(){
			cancel_event();
			return false;
		})
		
		$("#event_content").on("click", ".del_event", function(){
			var event_id=$(this).attr("data-rel");
			$.ajax({
				type: "POST",
				url: "/ajax/del_even/"+event_id,
				success: function(req){
					cancel_event();
					$('#calendar').fullCalendar( 'removeEvents', event_id )
				}
			});
		})
		
		//// DATAPICKER
		$('.bt_date').datetimepicker({
			format:"YYYY-MM-DD",
			pickTime: false,
			language: 'ru'
		});
		$('.bt_time').datetimepicker({
			pickDate: false,
			language: 'ru'
		});
		/// I-CHECK
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		
		
		/* initialize the calendar
		 -----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next, today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			timezone: 'local',
			defaultView:'agendaWeek',
			defaultTimedEventDuration: '00:30:00',
			titleFormat: 'MMMM DD YYYY',
			eventFormat:'hh:mm',
			selectable: true,
			selectHelper: true,
			droppable: true,
			drop: function(date, allDay) {
				var originalEventObject = $(this).data('eventObject');
				var copiedEventObject = $.extend({}, originalEventObject);
				copiedEventObject.start = date;
				//copiedEventObject.end   = (date.getTime() + 1800000)/1000;
				copiedEventObject.allDay = allDay;
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				if ($('#drop-remove').is(':checked')) {
					$(this).remove();
				}
			},
			eventSources: [
				{
					url: '/staff/event_feed/my',
					type: 'POST',
					data: {
						custom_param1: 'something',
						custom_param2: 'somethingelse'
					},
					error: function(){
						alert('there was an error while fetching events!');
					},
				},
				{
					url: '/staff/event_feed/share',
					type: 'POST',
					data: {
						custom_param1: 'something',
						custom_param2: 'somethingelse'
					},
					error: function(){
						alert('there was an error while fetching events!');
					},
				}
			],
			timeFormat: 'H(:mm)',
			eventDrop: function(event, delta, revertFunc) {
				var str="";
				var upd_time_start=event.start.format();
				
				str=str+"upd_time_start="+upd_time_start;
				if (event.end){
					var upd_time_end=event.end.format();
					str=str+"&upd_time_end="+upd_time_end
				}
				str=str+"&upd_event_id="+event.id;
				console.log(str);
				//console.log(upd_time_end);
				$.ajax({
					type: "POST",
					url: "/staff/update_event_drop/",
					data: str,
					success: function(req){
						//$('#calendar').fullCalendar('refetchEvents');
					}
				});
			},
			eventResize: function(event, delta, revertFunc) {
				var str="";
				str=str+"upd_event_id="+event.id;
				var upd_time_end=event.end.format();
				str=str+"&upd_time_end="+upd_time_end
				$.ajax({
					type: "POST",
					url: "/staff/update_event_drop/",
					data: str,
					success: function(req){
						//$('#calendar').fullCalendar('refetchEvents');
					}
				});
			},
			select: function(start, end){
				var new_start_date=start.format();
				var new_end_date=end.format();
				var str="";
				str+="new_event_start="+new_start_date;
				str+="&new_event_end="+new_end_date;
				$.ajax({
					type: "POST",
					url: "/staff/add_new_event_form/",
					data: str,
					success: function(req){
						$('.event-r').html(req);
						$("#modal-form-r").modal("show");
						//$('#calendar').fullCalendar('refetchEvents');
					}
				});
				//add_new_event(new_start_date, new_end_date);
			},
			eventClick: function(calEvent, jsEvent, view) {
				var event_id=calEvent.id;
				calEvent_teleport=calEvent;
				$('#modal-form-r').modal("show");
				$.ajax({
					type: "POST",
					url: "/staff/todo_more_info/"+event_id+"/show",
					//url: "/staff/todo_more_info/"+event_id,
					success: function(req){
						$('.event-r').html(req);
					}
				});
				$(this).css('border-color', 'red');
			},
			eventRender:function(event, element){
				//console.log(element);
				//element.find('.fc-title').append("1111");
			}
		});

		//////////////////////////////////
		//////// SEND EVENT TO WS
		$("#event_form").submit(function(){
			var data=Array();
			/// SUMMERNOTE
			var content = $('textarea[name="todo_description"]').html($('#todo_description').code());
			var data=$("#event_form").serialize();
			$("#todo_date_start").val("");
			$("#todo_time_start").val("");
			$("#todo_title").val("");
			$("#todo_date_end").val("");
			$("#todo_time_end").val("");
			$("#modal-form").modal('hide');
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
	});
	function cancel_event(){
		$("#modal-form").modal('hide');
		$(".modal").modal('hide');
		$("#modal-form-r").modal('hide');
		//$("#more_info").hide();
		$("#todo_date_start").val();
		$("#todo_time_start").val();
		return false;
	}

</script>
