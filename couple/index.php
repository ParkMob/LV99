<?php
include_once('./_common.php');
$g5['title'] = "커플";
include_once('./_head.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.couple.css">', 0);


$sql_common = " from {$g5['couple_table']} ";
$sql_search = " where co_id = {$config['cf_1']}";
$sql_order = " order by co_order asc ";
$sql_limit = "";


$sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
$result = sql_query($sql);

?>
<hr class="padding">

<div id="couple_page">
	<div id="couple_list">
	
<? for($i=0; $row = sql_fetch_array($result); $i++) { 
			$ch_left = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$row['co_left']}'");
			$ch_right = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$row['co_right']}'");

			$ch_left['ch_name'] = explode(' ', $ch_left['ch_name']);
			$ch_left['ch_name'] = $ch_left['ch_name'][0];

			$ch_right['ch_name'] = explode(' ', $ch_right['ch_name']);
			$ch_right['ch_name'] = $ch_right['ch_name'][0];

			$h=date('H'); //현재시를 구함 
			$m=date('i'); //현재 분을 구함 
			$s=date('s'); //현재 초를 구함 
			$date=date("U",strtotime($row['co_date'])); //생일의 유닉스타임스탬프를 구함 
			$today=time(); //현재의 유닉스타임스탬프를 구함 
			$day=($today-$date)/60/60/24; //몇일이지났는가를 계산
			$day=ceil($day);
		?>
		
				<div class="visual">

				<div class="body_box left">
					<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$row['co_left']?>" class="char_body"  target="_blank">
					<img class="body_img" src="<?=$ch_left['ch_head']?>" />
					</a>
				</div>

				<div class="body_box right">
					<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$row['co_right']?>"   class="char_body" target="_blank">
				<img class="body_img" src="<?=$ch_right['ch_head']?>" />
					
					</a>

					</div>
				</div>

				<p>
					<?=$ch_left['ch_name']?> ♥ <?=$ch_right['ch_name']?> 커플<br />
					<?=$day?>일 째입니다.
				</p>
			
	<? } ?>
		

	</div>
</div>
<hr class="padding">

<?php
include_once('./_tail.php');
?>

