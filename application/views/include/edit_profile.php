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
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Редактирование профиля</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Обзор</a>
			</li>
			<li>
				<a href="index.html">Профиль</a>
			</li>
			<li class="active">
				<strong>Редактирование профиля</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">
	</div>
</div>
<div class="wrapper wrapper-content">
	<div class="row animated fadeInRight">
		<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Поля отмеченные зведочкой являються обязательными</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							<form method="POST" class="form-horizontal" action="/staff/edit_profile/<?php echo $user_info->Id_user?>">
								<div class="form-group"><label class="col-sm-2 control-label">Фамилия *</label>
									<div class="col-sm-10"><input type="text" class="form-control" name="user_s_name" required="" value="<?php echo $user_info->user_s_name?>"></div>
								</div>
								<div class="form-group"><label class="col-sm-2 control-label">Имя *</label>
									<div class="col-sm-10"><input type="text" class="form-control" name="user_name" required="" value="<?php echo $user_info->user_name?>"></div>
								</div>
								<div class="form-group"><label class="col-sm-2 control-label">Отчество</label>
									<div class="col-sm-10"><input type="text" class="form-control" name="user_t_name" value="<?php echo $user_info->user_t_name?>"></div>
								</div>
								<div class="form-group"><label class="col-sm-2 control-label">Дата родения</label>
									<div class="col-sm-10"><input type="text" class="form-control" name="user_date_ob" value="<?php echo $user_info->user_date_ob?>"></div>
								</div>
								<div class="hr-line-dashed"></div>
								
								<div class="form-group"><label class="col-sm-2 control-label">Имя пользователя (логин) *</label>
									<div class="col-sm-10"><input type="text" class="form-control" name="user_login" value="<?php echo $user_info->user_login?>"></div>
								</div>
								<div class="form-group"><label class="col-sm-2 control-label">Пароль *</label>
									<div class="col-sm-10"><input type="password" class="form-control" name="user_password"></div>
								</div>
								<div class="form-group"><label class="col-sm-2 control-label">Повтор пароля *</label>
									<div class="col-sm-10"><input type="password" class="form-control" name="user_password_rep"></div>
								</div>
								<div class="hr-line-dashed"></div>
								<?php if(!$user_mail_list):?>
								<div id="mail_frame">
									<div class="form-group">
										<label class="col-sm-2 control-label"><i class="fa fa-plus-circle fa-2x pointer a_mail"></i> Почта</label>
										<div class="col-sm-4">
											<select class="form-control m-b" name="mail_server[]">
												<option value="1">Yandex</option>
												<option value="2">Google</option>
											</select>
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="mail_login[]" placeholder="Почтовый адрес">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="mail_password[]" placeholder="Пароль от почты">
										</div>
									</div>
								</div>
								<div id="if_add_mail"></div>
								<?php endif?>
								<?php foreach ($user_mail_list as $key=>$row_mail):?>
								<?php if ($key==0):?>
									<div id="mail_frame">
								<?php endif?>
								<?php if ($key==0):?>
									<div id="if_add_mail">
								<?php endif?>
									<div class="form-group">
										<label class="col-sm-2 control-label"><i class="fa fa-plus-circle fa-2x pointer a_mail"></i> Почта</label>
										<div class="col-sm-4">
											<select class="form-control m-b" name="mail_server[]">
												<option value="1" <?php if ($row_mail->mail_server==1)echo "selected"?>>Yandex</option>
												<option value="2" <?php if ($row_mail->mail_server==2)echo "selected"?>>Google</option>
											</select>
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="mail_login[]" placeholder="Почтовый адрес" value="<?php echo $row_mail->mail_login?>">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="mail_password[]" placeholder="Пароль от почты" value="<?php echo $row_mail->mail_password?>">
										</div>
									</div>
								</div>
								<?php endforeach?>
								<div class="form-group">
									<div class="col-sm-4 col-sm-offset-2">
										<button class="btn btn-white" type="submit">Cancel</button>
										<button class="btn btn-primary" type="submit">Save changes</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".a_mail").click(function(){
			var frame=$("#if_add_mail").html();
			var existing=$("#mail_frame").html()
			$("#if_add_mail").append(existing);
			return false;
		})
	})
</script>

