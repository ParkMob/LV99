<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>

<?
include_once("_common.php"); //이걸 페이지 최상단에 호출합니다
?>

<?
    if(!$member[mb_id]){
    alert("회원만 이용가능하십니다.");
  }
?>


 <div class="board-viewr theme-box" style="padding:20px;">
<?php echo $str; ?>
    </div>
    <hr class="padding">