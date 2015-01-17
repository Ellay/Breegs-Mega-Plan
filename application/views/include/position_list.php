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
		<h2>Список должностей</h2>
		<ol class="breadcrumb">
			<li>
				Отделы и должности
			</li>
			<li class="active">
				<strong>Список должностей</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
	<?php
	foreach($position_list as $row):
	?>
		<div class="col-lg-6">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5><?php echo $row->position_title?></h5>
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
				<table class="table">
					<thead>
					<tr>
						<th>Фамилия Имя</th>
						<th>Логин</th>
						<th>E-Mail</th>
						<th>Номер телефона</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($user_list_by_position[$row->Id_position] as $sub_row):?>
					<tr>
						<td><?php echo $sub_row->user_s_name." ".$sub_row->user_name?></td>
						<td><?php echo $sub_row->user_login?></td>
						<td><?php echo $sub_row->user_mail?></td>
						<td><?php echo $sub_row->user_phone?></td>
					</tr>
					<?php endforeach?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	<?php endforeach ?>
	</div>
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Форма добавления новой должности <small>Поля помеченные звездочкой обязательны</small></h5>
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
				<form method="POST" class="form-horizontal" action="/staff/position_list/add_new">
					<div class="form-group">
						<label class="col-sm-2 control-label">Название должности *</label>
						<div class="col-sm-10"><input type="text" class="form-control" name="position_title"></div>
					</div>
					<div class="hr-line-dashed"></div>
					
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<button class="btn btn-primary" type="submit">Создать</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

