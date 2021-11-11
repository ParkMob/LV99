<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
/*********** Logo Data ************/
$logo = get_logo('pc');
$m_logo = get_logo('mo');

$logo_data = "";
if($logo)		$logo_data .= "<img src='".$logo."' ";
if($m_logo)		$logo_data .= "class='only-pc' /><img src='".$m_logo."' class='not-pc'";
if($logo_data)	$logo_data.= " />";
/*********************************/

// $join_char_arr = sql_fetch("select cs_value from {$g5['css_table']} where cs_name = 'cate_join'");
// $join_char =  $join_char_arr['cs_value'];

$join_char_arr = get_style('cate_join', 'cs_value');		// 자기 로그 접두문자
$join_char = $join_char_arr['cs_value'];
if($config['cf_side_title']) {
	$ch_si = array();
	$side_result = sql_query("select si_id, si_name from {$g5['side_table']} order by si_id asc");
	for($i=0; $row = sql_fetch_array($side_result); $i++) { 
		$ch_si[$i]['name'] = $row['si_name'];
		$ch_si[$i]['id'] = $row['si_id'];
	}
}

?>
<div id="particles-js" scroll="no" ></div> 
<style>
@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
</style>

<div class="slide-on-background"></div>
  <div class="slide-on-layout"></div> 
  <div class="slide-menu">
      <div class="slide-header">
      <div id = "mobile-login-close">
      <a id="slide-close-button" href="#"> <i class="fas fa-times"></i>
                        </a></div>
 
          <h1 id="logo">
              <a href="<?=G5_URL?>/main.php"><?=$logo_data?></a>
            </h1>
            <hr class="padding">
        </div>
    <div class="slide-menu-category">
        <?
        $bbs_sql=sql_query("select bo_table,bo_subject,bo_order_whippy, bo_use_category, bo_category_list,bo_1,bo_2 from {$g5['board_table']} order by bo_order");
        for ($i=0;$bbs=sql_fetch_array($bbs_sql);$i++){
            if($bbs['bo_order_whippy']){
            ?>
            <?$categories = explode("|", $bbs['bo_category_list']);?>
            <?if($bbs['bo_use_category']) { ?>
                <ul class = "slide-menu-list-category" >
                    <?=$bbs['bo_subject']?>&nbsp;&nbsp;<i class="fas fa-caret-down"></i>
            </ul>
                <div class="sub-category">
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>">ALL</a>
                    </li>
                    <?for ($i=0; $i<count($categories); $i++) {
                         $category = trim($categories[$i]);
                         ?>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>&sca=<?=$categories[$i]?>"><?=$categories[$i]?></a>
                    </li>
                    <?
                    }
                    ?>
                </div>
            <?}
            else if($bbs['bo_1']){
                 if($ch_si){
                     ?>
                      <ul class ="slide-menu-list-category" >
                    <?=$bbs['bo_subject']?>&nbsp;&nbsp;<i class="fas fa-caret-down"></i>
                    </ul>  
                    <div class="sub-category"> 
                    <li>
                        <a href="<?=G5_URL?>/member">ALL</a>
                    </li><?
                     for($i=0; $i < count($ch_si); $i++){?>
                        <li>
                            <a href="<?=G5_URL?>/member/index.php?side=<?=$ch_si[$i]['id']?>"><?=$ch_si[$i]['name']?></a>
                        </li>
                    <?}?>
                    </div><?
                 }
                 else{?>
                 <ul class = "slide-menu-list" >
                <a href="<?=G5_URL?>/member"><?=$bbs['bo_subject']?></a>
                </ul>
                 <?}
            }
            else if($bbs['bo_2']){?>
            <ul class = "slide-menu-list" >
                <a href="<?=G5_BBS_URL?>/content.php?co_id=<?=$bbs['bo_2']?>"><?=$bbs['bo_subject']?></a>
            </ul>
            <?}
            else{?>
            <ul class = "slide-menu-list" >
                <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>"><?=$bbs['bo_subject']?></a>
            </ul>
            <?
        }}?>
        <?}?> 
    </div>

    <div id = "mobile-login">
                <?if ($is_member){?>
                    <?if($is_admin){?>
                        <a href="<?=G5_ADMIN_URL?>" target="_blank">
                            <i class="fas fa-tools"></i>
                        </a>
                    <?}?>
                <!-- <?if($is_member && !$is_admin){?>
                    <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php">
            <i class="fas fa-tools"></i>
            </a>
                    <?}?> -->
                    <a href="<?php echo G5_BBS_URL ?>/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                    </a> 
                <?}else{?>
                        <a href="<?=G5_BBS_URL?>/login.php">
                            <i class="fas fa-unlock-alt"></i>
                        </a>
                    <?}?>
         </div>
         </div>

  </div>

<!-- 헤더 영역 -->
<header id="header">
	<div class="fix-layout">
		<!-- 로고 영역 : PC 로고 / 모바일 로고 동시 출력 - 디자인 사용을 체크하지 않을 시, 제대로 출력되지 않을 수 있습니다. -->
		<!-- 관리자 기능을 사용하지 않고 로고를 넣고 싶을 시, < ? = $ log_data ? > 항목을 제거 하고 <img> 태그를 넣으세요. -->
        <div id="header-bar">
        <div id="bgm-bar">
        <? include(G5_PATH."/templete/txt.bgm.php"); ?>
        </div>
        

         </div>
         
         <a href="#" id="gnb_control_box" title="Menu">
        <i class="fas fa-bars"></i>
		</a>

		<h1 id="logo">
			<a href="<?=G5_URL?>/main.php">
				<?=$logo_data?>
			</a>
		</h1>
		<div id="gnb">
			<?
			$menu_content = get_site_content('site_menu');
			if($menu_content) { 
				echo $menu_content;
			} else { ?>
            
            <ul id="no_design_gnb">
            <?
             $bbs_sql=sql_query("select bo_table,bo_subject,bo_order_whippy, bo_use_category, bo_category_list,bo_1,bo_2 from {$g5['board_table']} order by bo_order");
            for ($i=0;$bbs=sql_fetch_array($bbs_sql);$i++){
                if($bbs['bo_order_whippy']){
                if($i!=0){
                    
            ?>
               <div class="cate_join">
                   <p><?=$join_char?></p>
                </div>
            <?}?>
                <div class="category">
                    <div class = "bbs">
                    <?if($bbs['bo_1']){?>
                        <a class = "subject" href="<?=G5_URL?>/member"><?=$bbs['bo_subject']?></a><?}
                        else if($bbs['bo_2']){ ?>
                        <a class = "subject" href="<?=G5_BBS_URL?>/content.php?co_id=<?=$bbs['bo_2']?>"><?=$bbs['bo_subject']?></a>
                        <?}
                        else{?>
                        <a class = "subject" href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>"><?=$bbs['bo_subject']?></a>
                        <?}?>
                     
                    </div>
                    <?$categories = explode("|", $bbs['bo_category_list']);?>
                            <ul>
                            <?if($bbs['bo_1']){?>
                                    <?
                               
                                    if($ch_si){  ?>                                  <li>
                                        <a href="<?=G5_URL?>/member">ALL</a>
                                    </li><?         
                                    for($i=0; $i < count($ch_si); $i++)
                                   {?>
                                    <li>
                                        <a href="<?=G5_URL?>/member/index.php?side=<?=$ch_si[$i]['id']?>"><?=$ch_si[$i]['name']?></a>
                                    </li>
                                <?}
                                }
                            }else if($bbs['bo_use_category']) { ?>
                                    <li>
                                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>">ALL</a>
                                    </li>
                                    <?for ($i=0; $i<count($categories); $i++) {
                                        $category = trim($categories[$i]);
                                    ?>
                                    <li>
                                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>&sca=<?=$categories[$i]?>"><?=$categories[$i]?></a>
                                    </li>
                                    <?
                                    }
                                 }?>
                            </ul>
                </div>
                <?}
            }unset($bbs)?> 
			</ul>
			<?php } ?>   
		</div>




	</div>
</header>
<!-- // 헤더 영역 -->



<section id="body">
<script> function clickEffect(e){  play(); var d=document.createElement("div");   d.className="clickEffect";   d.style.top=e.clientY+"px";d.style.left=e.clientX+"px";   document.body.appendChild(d);   d.addEventListener('animationend',function(){d.parentElement.removeChild(d);}.bind(this)); } document.addEventListener('click',clickEffect); </script>
	<div class="fix-layout">


    
 <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
 <script>
 	particlesJS("particles-js", {"particles":{"number":{"value":24,"density":{"enable":true,"value_area":1025.940511234049}},"color":{"value":"#d2d2d2"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.4166266064160501,"random":false,"anim":{"enable":false,"speed":0,"opacity_min":0,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":2,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":false,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
 </script>
<audio id='audio_play' src="<?=G5_IMG_URL?>/click.mp3">></audio> 
<script type="text/javascript"> 
function play() { 
    var audio = document.getElementById('audio_play'); 
    if (audio.paused) { 
        audio.play(); 
    }else{ 
        audio.pause(); 
        audio.currentTime = 0 
    } 
} 
</script>

<div class="guest" id="guest">
    <a href="<?=G5_BBS_URL?>/board.php?bo_table=guest">
    <img src="<?=G5_IMG_URL?>/guest.png" class="guest_list">
</a>

    <div class = "login_guset">
                <?if ($is_member){?>
                    <?if($is_admin){?>
                        <a href="<?=G5_ADMIN_URL?>" target="_blank">
                            <i class="fas fa-tools"></i>
                        </a>
                    <?}?>
    
                    <a href="<?php echo G5_BBS_URL ?>/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                    </a> 
                <?}else{?>
                        <a href="<?=G5_BBS_URL?>/login.php">
                            <i class="fas fa-unlock-alt"></i>
                        </a>
                    <?}?>
                </div>


    </div>


    <div class="board-viewer theme-box" id="main-box"style="padding:20px 70px;">



<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

 
<script>

$(window).resize(function() {

    var w=document.documentElement.clientHeight-document.getElementById("header").clientHeight-100;
     $("#main-box").css('height',w+'px')
     
     });


$(document).ready(function(){

    var w=document.documentElement.clientHeight-document.getElementById("header").clientHeight-100;
     $("#main-box").css('height',w+'px')




$("#gnb_control_box").click(function(){
$(".slide-menu").toggleClass("slide-right");
$(".slide-on-background").toggleClass("slide-on");
});
		
$('.slide-on-layout, #slide-close-button').click(function(){
$(".slide-menu").removeClass("slide-right");
$(".slide-on-background").removeClass("slide-on");
});


$(".slide-menu-list-category").click(function(){
    var list = document.getElementsByClassName("slide-menu-list-category");
    for(var i=0; i<list.length; i++){
        if(i!= $(".slide-menu-list-category").index(this)){
            $(".sub-category:eq(" + i + ")").removeClass("on")
        }
        else{
            $(".sub-category:eq(" + i + ")").toggleClass("on")

        }
    }
});
});



var mql = window.matchMedia("screen and (max-width: 800px)");

mql.addListener(function(e) {
    if(!e.matches) {
        $(".slide-menu").removeClass("slide-right");
        $(".slide-on-background").removeClass("slide-on");
    } 
});

</script>

 