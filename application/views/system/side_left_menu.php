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
<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element"> <span>
					<img alt="image" class="img-circle" src="img/profile_small.jpg" />
					 </span>
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $ses_user_s_name." ".$ses_user_name?></strong>
					 </span> <span class="text-muted text-xs block"><?php echo $ses_position?> <b class="caret"></b></span> </span> </a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a href="/staff/profile">Профиль</a></li>
						<li><a href="/staff/contacts">Контакты</a></li>
						<li><a href="/staf/mailbox">Почта</a></li>
						<li class="divider"></li>
						<li><a href="login.html">Выход</a></li>
					</ul>
				</div>
				<div class="logo-element">
					IN+
				</div>
			</li>
			<li class="">
				<a href="/staff"><i class="fa fa-th-large"></i> <span class="nav-label">Главная панель</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li class=""><a href="/staff">Обзор</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Сотрудники</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/staff/staff_list">Список сотрудников</a></li>
					<li><a href="/staff/add_staff">Добавить сотрудника</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Отделы и должности</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/staff/departments_list">Список отделов</a></li>
					<li><a href="/staff/position_list">Спосок должностей</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Планировщик</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/staff/todo">Мои дела</a></li>
				</ul>
			</li>
			<li>
				<a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right count_unread_email">16/24</span></a>
				<ul class="nav nav-second-level">
					<li><a href="/staff/inbox">Входящие</a></li>
					<li><a href="/staff/outbox">Исходящие</a></li>
					<li><a href="/staff/compse">Написать</a></li>
					<li><a href="/staff/compose">Корзина</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">Настройка системы</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/staff/settings_short_cut_calendar">Ярлыки для календаря</a></li>
					<li><a href="/staff/settings_notify">Настройка оповещения</a></li>
				</ul>
			</li>
		</ul>

	</div>
</nav>