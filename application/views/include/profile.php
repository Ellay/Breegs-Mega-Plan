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
		<h2>Профиль</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Обзор</a>
			</li>
			<li class="active">
				<strong>Профиль</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">
	</div>
</div>
<div class="wrapper wrapper-content">
	<div class="row animated fadeInRight">
		<div class="col-md-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Информация о профиле</h5>
				</div>
				<div>
					<div class="ibox-content no-padding border-left-right">
						<img alt="image" class="img-responsive" src="/images/profile/profile_big.jpg">
					</div>
					<div class="ibox-content profile-content">
						<h4><strong><?php echo $user_info->user_s_name." ".$user_info->user_name?></strong></h4>
						<p><i class="fa fa-university"></i> <?php echo $user_info->department_title ?></p>
						<p><i class="fa fa-male"></i> <?php echo $user_info->position_title ?></p>
						<?php foreach($user_mail_list as $row):?>
						<p><i class="fa fa-envelope-o"></i> <?php echo $row->mail_login ?></p>
						<?php endforeach?>
						<h5>О себе</h5>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat.
						</p>
						<div class="user-button">
							<div class="row">
								<div class="col-md-6">
									<a class="btn btn-primary btn-sm btn-block" href="/staff/edit_profile/<?php echo $user_info->Id_user?>"><i class="fa fa-pencil-square-o"></i> Редактироват</a>
								</div>
								<div class="col-md-6">
									<a class="btn btn-default btn-sm btn-block"><i class="fa fa-coffee"></i> Buy a coffee</a>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
			</div>
		<div class="col-md-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Activites</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>

					</div>
				</div>
				<div class="ibox-content">

					ХЗ

				</div>
			</div>

		</div>
	</div>
</div>
</div>

