<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>INSPINIA | Dashboard v.2</title>
	<link href="<?php echo $resources_url?>css/bootstrap.min.css" rel="stylesheet">
	
	<link href="<?php echo $resources_url?>font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/animate.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/summernote/summernote.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/datapicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/steps/jquery.steps.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/switchery/switchery.css" rel="stylesheet">
	<link href="<?php echo $resources_url?>css/plugins/chosen/chosen.css" rel="stylesheet">

	<link href="<?php echo $resources_url?>css/style.css" rel="stylesheet">
	
	<!-- Mainly scripts -->
	
	<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
	<!--<script src="<?php echo $resources_url?>js/bootstrap.min.js"></script>-->
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	<script src="http://mistic100.github.io/Bootstrap-Confirmation/dist/bootstrap-confirmation2/bootstrap-confirmation.min.js"></script>
	<script src="http://mistic100.github.io/Bootstrap-Confirmation/assets/js/docs.min.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/peity/jquery.peity.min.js"></script>
	<script src="<?php echo $resources_url?>js/demo/peity-demo.js"></script>
	<script src="<?php echo $resources_url?>js/inspinia.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/pace/pace.min.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/easypiechart/jquery.easypiechart.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="<?php echo $resources_url?>js/demo/sparkline-demo.js"></script>
	
	<script src="<?php echo $resources_url?>js/plugins/iCheck/icheck.min.js"></script>
	<script src='<?php echo $resources_url?>js/plugins/fullcalendar/moment.min.js'></script>
	<script src="<?php echo $resources_url?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src='<?php echo $resources_url?>js/plugins/fullcalendar/ru.js'></script>
	<script src="<?php echo $resources_url?>js/plugins/summernote/summernote.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/staps/jquery.steps.min.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/datapicker/bootstrap-datetimepicker.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/switchery/switchery.js"></script>
	<script src="<?php echo $resources_url?>js/plugins/chosen/chosen.jquery.js"></script>

	<script src="http://46.249.16.151:3003/socket.io/socket.io.js"></script>
	<script type="text/javascript">
	var SYS = {
		USER :{
			id : <?PHP echo $ses_user_id; ?>
		}
	}
	</script>
	<script src="/source/js/client.js"></script>

	<script type="text/javascript">
	var socket = new WebSocket("ws://46.249.16.151:3002/<?php echo $ses_user_id?>");
	
	
	
	
	
	
	
	/*
	var socket = new WebSocket("ws://46.249.16.151:3002/<?php echo $ses_user_id?>");
	function Send_pocket(event){
		var method="calendar";
		cansole.log(this);
		this.push({
			'method': method,
			'event': event
		});
		//console.log(this);
		return this;
	}
	//var o = {};
	//this.prototype.sss = Send_pocket;
	//socket.send(str);



socket.onmessage = function(event) {
	console.log(event);
  var incomingMessage = event.data;
  showMessage(incomingMessage); 
};

// показать сообщение в div#subscribe
function showMessage(message) {
  var messageElem = document.createElement('div');
  messageElem.appendChild(document.createTextNode(message.event));
  document.getElementById('subscribe').appendChild(messageElem);
}
*/

</script>
</head>
<body>
	<div id="wrapper">
		<?php $this->load->view("system/side_left_menu")?>
		<div id="page-wrapper" class="gray-bg">
			<?php $this->load->view("system/side_top_menu")?>
			<div class="wrapper wrapper-content">
				<?php $this->load->view($content)?>
			</div>
		</div>
	</div>
	<script type="text/javascript">

$(document).ready(function(){
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


	var url=document.location.href;
	$.each($("#side-menu a"),function(){
		if(this.href==url){
			$(this).parents("li").addClass('active');
			$(this).parents("ul").addClass('in');
			
		};
	});
});

</script>
</body>
</html>
