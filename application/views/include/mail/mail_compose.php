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
<div class="row">
	<div class="col-lg-12 animated fadeInRight">
	<div class="mail-box-header">
		<div class="pull-right tooltip-demo">
			<a href="/staff/inbox" class="btn btn-danger btn-sm" ><i class="fa fa-times"></i> Отменить</a>
		</div>
		<h2>Написать письмо</h2>
	</div>
	<form class="form-horizontal" method="POST" action="/staff/compse">
		<div class="mail-box">
		<div class="mail-body">
				<div class="form-group"><label class="col-sm-2 control-label">От:</label>
					<div class="col-sm-10">
						<select class="form-control" name="mail_from">
							<?php
							foreach($user_mail as $row){
								echo "<option>$row->mail_login</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group"><label class="col-sm-2 control-label">Кому:</label>
					<div class="col-sm-10"><input type="text" class="form-control" value="" name="mail_toaddress"></div>
				</div>
				<div class="form-group"><label class="col-sm-2 control-label">Скрытая:</label>
					<div class="col-sm-10"><input type="text" class="form-control" value="" name="to_bcc"></div>
				</div>
				<div class="form-group"><label class="col-sm-2 control-label">Тема:</label>
					<div class="col-sm-10"><input type="text" class="form-control" value="" id="" name="mail_subject"></div>
				</div>
		</div>
		<div class="mail-text h-200">
			<textarea name="mail_body" class="form-control" id="mail_body"></textarea>
			<div class="clearfix"></div>
		</div>
		<div class="mail-body text-right tooltip-demo">
			<button href="/staff/mail_compose" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-reply"></i> Отправить</button>
			<a href="/staff/inbox" class="btn btn-white btn-sm"><i class="fa fa-times"></i> Отменить</a>
		</div>
		<div class="clearfix"></div>
		</div>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		//var content = $('textarea[name="body"]').html($('#body').code());

		$('#mail_body').summernote();

	});
	
</script>
