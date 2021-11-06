<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<link rel="stylesheet" href="<?php echo $visit_skin_url ?>/style.css">

<div class="section_ul">
<!--Today:-->Today <span style="color:#7fbbc6;"><?=number_format($visit[1])?></span>
<!--Yesterday:-->Yesterday <span style="color:#afdde5;"> <?=number_format($visit[2])?></span><br />
<!--Total:-->Total <span style="color:#afdde5;"><?=number_format($visit[4])?></span>
</div>