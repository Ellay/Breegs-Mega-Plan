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
		<h2>Добавление нового сотрудника</h2>
		<ol class="breadcrumb">
			<li>
				Сотрудники
			</li>
			<li class="active">
				<strong>Добавление нового сотрудника</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Форма добавления нового сотрудника <small>Поля помеченные звездочкой обязательны</small></h5>
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
				<form method="POST" class="form-horizontal" action="/staff/add_staff/add_new">
					<div class="form-group">
						<label class="col-sm-2 control-label">Фамилия *</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="user_name"></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Имя *</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="user_s_name"></div>
					</div>
					<div class="hr-line-dashed"></div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Отчество</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="user_t_name"></div>
					</div>
					<div class="hr-line-dashed"></div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Имя пользователя *</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="user_login"></div>
					</div>
					<div class="hr-line-dashed"></div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Пароль *</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="user_password"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Повтор пароля *</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="user_password_rep"></div>
					</div>
					<div class="hr-line-dashed"></div>

					<div class="form-group"><label class="col-sm-2 control-label">Отдел *</label>
						<div class="col-sm-10">
						<select class="form-control m-b" name="user_department">
							<option>Веберите отдел</option>
						<?php foreach($department_list as $row):?>
							<option value="<?php echo $row->Id_department?>"><?php echo $row->department_title?></option>
						<?php endforeach?>
						</select>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group"><label class="col-sm-2 control-label">Должность *</label>
						<div class="col-sm-10">
						<select class="form-control m-b" name="user_position">
						<option>Веберите должность</option>
						<?php foreach($position_list as $row):?>
							<option value="<?php echo $row->Id_position?>"><?php echo $row->position_title?></option>
						<?php endforeach?>
						</select>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<button class="btn btn-white" type="submit">Отмена</button>
							<button class="btn btn-primary" type="submit">Создать</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
