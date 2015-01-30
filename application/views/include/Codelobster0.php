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
<div class="mail-box-header">
		<form method="get" action="index.html" class="">
			<div class="input-group">
				<input type="text" class="form-control input-sm" name="search" placeholder="Search email">
				<div class="input-group-btn">
					<button type="submit" class="btn btn-sm btn-primary">
						Search
					</button>
				</div>
			</div>
		</form>
		<h2>

		</h2>
		<div class="mail-tools tooltip-demo m-t-md">
			<div class="btn-group pull-right">
				<button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
				<button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

			</div>
			<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> </button>
			<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
			<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
			<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>

		</div>
	</div>
		<div class="mail-box" id="mail">
			<table class="table table-hover table-mail">
				<tbody>
				<?php
				foreach($mail_list as $key => $value){
					//var_dump($value);
					if ($value->mail_status==0){
						$unread="unread";
					}else{
						$unread="read";
					}
					if ($value->mail_attach){
						$attach="<i class='fa fa-paperclip'></i>";
					}else{
						$attach="";
					}
					echo "<tr class='$unread mail_line' data-rel='$value->Id_mail_box'>";
						echo "<td class='check-mail'>";
							echo "<label><input type='checkbox' class='i-checks'></label>";
						echo "</td>";
						echo "<td class='mail-contact'><span style='font-weight: bolder; font-size: 12px;'>$value->mail_from_str</span><br>$value->mail_subject</td>";
						//echo "<td class='mail-subject'><a href='".$sys_url."/view_mail/".."'>".."</a></td>";
						echo "<td class=''>".$attach."</td>";
						echo "<td class='text-right mail-date'>19:51</td>";
					echo "</tr>";
				}
				
				?>
				</tbody>
			</table>
		</div>