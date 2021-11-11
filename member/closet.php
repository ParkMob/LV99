<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

$cl_count = sql_fetch("select count(*) as cnt from {$g5['closthes_table']} where ch_id = '{$ch_id}'");
$cl_count = $cl_count['cnt'];
$cl_result = sql_query("select * from {$g5['closthes_table']} where ch_id = '{$ch_id}' order by cl_id asc");
?>
<div class="closet-list">

<? if($is_admin){?>
	<a href="#" class="menu__item tshirt" onclick="javascript:window.open('<?=G5_URL?>/mypage/character/closet.inc.php?ch_id=<?=$ch_id?>','new','left=50, top=50, width=800, height=600')"><i class="fas fa-tshirt" style="font-size: 20pt";></i></a>
		<? }?>
<? if($cl_count > 1) { ?>
	<nav class="menu menu--iris">
					<ul class="menu__list">
<? for($i=0; $row=sql_fetch_array($cl_result); $i++) { 
	$class = "";

	if($row['cl_use'] == '1') { 
		$class .='--current';
	}
?>
<li class="menu__item menu__item<?=$class?>"><a href="#" class="menu__link"  onclick="change_closet('<?=$row['cl_path']?>')">
 
 <? if($row['cl_type'] =='default'){ ?>
	DEFAULT
	<? }else{?>
		 <?=$row['cl_subject']?>
		</a>
		 <? } ?>
		 </a></li>
<? } ?>


	
</ul>
</nav>

<? } ?>
 </div>


<script>


function change_closet(url) {
	setTimeout(function(){
		$("#body_img_raw").css('opacity','0')
		$('.char_profile').css('opacity','0')
		setTimeout(function(){
			$("#body_img_raw").attr("src", url).load(function(){
				$("#body_img_raw").css('opacity','1')
				$('.char_profile').css('opacity','1')
			});
		},300);
	},300);
}

</script>

