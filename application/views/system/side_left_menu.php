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
				<a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Главная панель</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li class=""><a href="dashboard_2.html">Обзор</a></li>
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
					<li><a href="/staff/tasks">Мои задачи</a></li>
					<li><a href="/staff/todo">Мои дела</a></li>
				</ul>
			</li>
			<li>
				<a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right">16/24</span></a>
				<ul class="nav nav-second-level">
					<li><a href="mailbox.html">Inbox</a></li>
					<li><a href="mail_detail.html">Email view</a></li>
					<li><a href="mail_compose.html">Compose email</a></li>
				</ul>
			</li>
			<li>
				<a href="widgets.html"><i class="fa fa-flask"></i> <span class="nav-label">Widgets</span> <span class="label label-info pull-right">NEW</span></a>
			</li>
			<li>
				<a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Forms</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="form_basic.html">Basic form</a></li>
					<li><a href="form_advanced.html">Advanced Plugins</a></li>
					<li><a href="form_wizard.html">Wizard</a></li>
					<li><a href="form_file_upload.html">File Upload</a></li>
					<li><a href="form_editors.html">Text Editor</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">App Views</span>  <span class="pull-right label label-primary">SPECIAL</span></a>
				<ul class="nav nav-second-level">
					<li><a href="contacts.html">Contacts</a></li>
					<li><a href="profile.html">Profile</a></li>
					<li><a href="file_manager.html">File manager</a></li>
					<li><a href="calendar.html">Calendar</a></li>
					<li><a href="timeline.html">Timeline</a></li>
					<li><a href="pin_board.html">Pin board</a></li>
					<li><a href="invoice.html">Invoice</a></li>
					<li><a href="login.html">Login</a></li>
					<li><a href="register.html">Register</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="search_results.html">Search results</a></li>
					<li><a href="lockscreen.html">Lockscreen</a></li>
					<li><a href="404.html">404 Page</a></li>
					<li><a href="500.html">500 Page</a></li>
					<li><a href="empty_page.html">Empty page</a></li>
				</ul>
			</li>
			<li >
				<a href="#"><i class="fa fa-flask"></i> <span class="nav-label">UI Elements</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="typography.html">Typography</a></li>
					<li><a href="icons.html">Icons</a></li>
					<li><a href="draggable_panels.html">Draggable Panels</a></li>
					<li><a href="buttons.html">Buttons</a></li>
					<li><a href="tabs_panels.html">Tabs & Panels</a></li>
					<li><a href="notifications.html">Notifications & Tooltips</a></li>
					<li><a href="badges_labels.html">Badges, Labels, Progress</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">Layout</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="grid_options.html">Grid options</a></li>
					<li><a href="boxed_layout.html">Boxed layout</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tables</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="table_basic.html">Static Tables</a></li>
					<li><a href="table_data_tables.html">Data Tables</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">Настройка системы</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/staff/settings_short_cut_calendar">Ярлыки для календаря</a></li>
					<li><a href="carousel.html">Bootstrap Carusela</a></li>
				</ul>
			</li>
			<li>
				<a href="css_animation.html"><i class="fa fa-magic"></i> <span class="nav-label">CSS Animations </span><span class="label label-info pull-right">62</span></a>
			</li>
		</ul>

	</div>
</nav>