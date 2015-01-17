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
var_dump($_POST);
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-8">
		<h2>Настройка системы</h2>
		<ol class="breadcrumb">
			<li>
				Настройка календаря
			</li>
			<li class="active">
				<strong>Создание ярлыков</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Список ярлыков</h5>
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
						<th>Название ярлыка</th>
						<th>Цвет ярлыка</th>
						<th>Цвет такста</th>
						<th>Образец</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($short_cut_list as $row):?>
					<tr>
						<td><?php echo $row->short_cut_title?></td>
						<td><?php echo $row->short_cut_bgcolor?></td>
						<td><?php echo $row->short_cut_txcolor?></td>
						<td><span class="label" style="background-color: <?php echo $row->short_cut_bgcolor?>; color: <?php echo $row->short_cut_txcolor?>">Documents</span></td>
					</tr>
					<?php endforeach?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Добавить ярлык</h5>
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
				<form role="form" class="form-inline" method="POST" action="/staff/settings_short_cut_calendar/add_short">
					<div class="form-group"><label for="short_cut_title" class="help-block m-b-none">Название ялыка</label>
						<input type="text" placeholder="Название ярлыка" id="short_cut_title" class="form-control" name="short_cut_title"></div>
					<div class="form-group"><label for="short_cut_bgcolor" class="help-block m-b-none" >Цвет фона</label>
						<input type="color" placeholder="Цвет фона" id="short_cut_bgcolor" class="form-control" name="short_cut_bgcolor" style="width: 150px;"></div>
					<div class="form-group"><label for="short_cut_txcolor" class="help-block m-b-none" >Цвет текста</label>
						<input type="color" placeholder="Цвет фона" id="short_cut_txcolor" class="form-control" name="short_cut_txcolor" style="width: 150px;"></div>
					
					<button class="btn btn-white" type="submit">Добавить</button></form>
			</div>
		</div>
	</div>
</div>