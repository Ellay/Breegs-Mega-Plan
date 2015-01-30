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
$left_start=$start-$count_page;
$left_end=$end-$count_page;

$right_start=$start+$count_page;
$right_end=$end+$count_page;
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
	<h2></h2>
	<div class="mail-tools tooltip-demo m-t-md">
		<div class="btn-group pull-right">
			<button class="btn btn-white btn-sm <?php echo $class_left?>" data-rel="<?php echo $left_start."/".$left_end?>"><i class="fa fa-arrow-left"></i></button>
			<button class="btn btn-white btn-sm <?php echo $class_right?>" data-rel="<?php echo $right_start."/".$right_end?>"><i class="fa fa-arrow-right"></i></button>
		</div>
		<button class="btn btn-white btn-sm cron-reload"><i class="fa fa-refresh"></i> </button>
		<button class="btn btn-white btn-sm mark-read"><i class="fa fa-eye"></i> </button>
		<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
		<button class="btn btn-white btn-sm mark-delet"><i class="fa fa-trash-o"></i> </button>
	</div>
</div>
<div class="mail-box" id="mail">
	<table class="table table-hover table-mail">
		<tbody>
		<?php
		foreach($mail_list as $key => $value){
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
			echo "<tr class='$unread mail_line'>";
				echo "<td class='check-mail'>";
					echo "<label><input type='checkbox' class='i-checks marking' value='$value->Id_mail_box'></label>";
				echo "</td>";
				echo "<td class='mail-contact' data-rel='$value->Id_mail_box'><span style='font-weight: bolder; font-size: 12px;'>$value->mail_from_str</span><br>$value->mail_subject</td>";
				//echo "<td class='mail-subject'><a href='".$sys_url."/view_mail/".."'>".."</a></td>";
				echo "<td class=''>".$attach."</td>";
				echo "<td class='text-right mail-date'>19:51</td>";
			echo "</tr>";
		}
		
		?>
		</tbody>
	</table>
</div>