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
		<h2>Список сотрудников</h2>
		<ol class="breadcrumb">
			<li>
				Сотрудники
			</li>
			<li class="active">
				<strong>Список сотрудников</strong>
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
				<h5>Список сотрудников</h5>
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
						<th>Отдел</th>
						<th>Должность</th>
						<th>Имя пользователя</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($user_list as $row):?>
					<tr>
						<td><?php echo $row->user_s_name." ".$row->user_name?></td>
						<td><?php echo $row->department_title?></td>
						<td><?php echo $row->position_title?></td>
						<td><?php echo $row->user_login?></td>
					</tr>
					<?php endforeach?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
</div>

