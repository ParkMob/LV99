<?php
include_once('./_common.php');
define('_MAIN_', true);
include_once(G5_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/main.css">', 0);
include_once(G5_PATH."/intro.php");
?>

<div id="main_body">

<?
$main_content = get_site_content('site_main');
if($main_content) { ?>


    <?
	echo $main_content;
    ?>


</div>

    <hr class="padding">

    <?
} else { 
?>
	<div id="no_design_main">
	</div>
<?php } ?>


<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>

function copyToClipboard(val) {
  var t = document.createElement("textarea");
  document.body.appendChild(t);
  t.value = val;
  t.select();
  document.execCommand('copy');
  document.body.removeChild(t);
}


$(document).on("click", "#whippy_banner", function(e) {
    copyToClipboard('<a href="http://whippy.dothome.co.kr/cream" target= "_blank"><img src="http://whippy.dothome.co.kr/banner.png"></a>');
});


$(".whippy_banner_img").mouseover(function() {
     $(this).attr("src", $(this).attr("src").replace("http://whippy.dothome.co.kr/banner.png","http://whippy.dothome.co.kr/banner_hover.png"));
});
$(".whippy_banner_img").mouseout(function() {
     $(this).attr("src", $(this).attr("src").replace("http://whippy.dothome.co.kr/banner_hover.png", "http://whippy.dothome.co.kr/banner.png"));
});


</script>


<script> 
tippy('.whippy_banner_img', { 
content: '복사 완료!',
theme:'whippy',
placement: 'auto', 
offset: [0, 0],
trigger: 'click',
 hideOnClick : true, 
 animation: 'shift-away',
 arrow: true, onShow(instance) {
    setTimeout(function() {instance.hide()},1000);
  } }

); 

</script>
<script>
$(function() { 
	window.onload = function() {
		$('#body').css('opacity', 1);
	};
});


</script>

<?
include_once(G5_PATH.'/tail.php');
?>

