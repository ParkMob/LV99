<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.profile.css">', 0);

/** 스탯 이용 시 스탯 설정값 가져오기 **/
if($article['ad_use_status']) { 
	$status = array();
	$st_result = sql_query("select * from {$g5['status_config_table']} order by st_order asc");
	for($i = 0; $row = sql_fetch_array($st_result); $i++) {
		$status[$i] = $row;
	}
}
/** 추가 항목 설정값 가져오기 **/
$ch_ar = array();
$str_secret = ' where (1) ';

if($member['mb_id'] == $mb['mb_id']) {
	$str_secret .= " and ar_secret != 'H' ";
} else {
	$str_secret .= " and ar_secret = '' ";
}

$ar_result = sql_query("select * from {$g5['article_table']} {$str_secret} order by ar_order asc");
for($i = 0; $row = sql_fetch_array($ar_result); $i++) {
	$ch_ar[$i] = $row;
}


/* --------------------------------------------------------------
	프로필 양식에서 추가한 캐릭터의 데이터를 임의로 뿌리고 싶을 때
	$ch['고유코드'] 로 해당 데이터를 가져올 수 있습니다.

	--
	
	스탯 설정에서 추가한 캐릭터의 데이터를 임의로 뿌리고 싶을 때
	$변수 = get_status_by_name($ch['ch_id'], 스탯명);
	* $변수['has']	: 현재 캐릭터가 가지고 있는 전체값 (ex. 캐릭터의 최대 HP 값)
	* $변수['drop']	: 현재 캐릭터의 스탯 차감 수치 (ex. 캐릭터의 부상 수치, HP 감소)
	* $변수['now']	: 현재 캐릭터에게 적용되어 있는 값 (ex. 캐릭터의 현재 HP 값 (캐릭터의 원래 HP값 - 부상))
	* $변수['max']	: 입력할 수 있는 최대값
	* $변수['min']	: 필수 최소값
	--
	
	자동으로 출력 되는게 아닌 임의로 레이아웃을 수정하고 싶을 땐
	위쪽의 설정값 가져 오는 부분을 지우셔도 무방합니다.
	
	--
------------------------------------------------------------------ */

// --- 캐릭터 별 추가 항목 값 가져오기
$av_result = sql_query("select * from {$g5['value_table']} where ch_id = '{$ch['ch_id']}'");
for($i = 0; $row = sql_fetch_array($av_result); $i++) {
	$ch[$row['ar_code']] = $row['av_value'];
}

// ------- 캐릭터 의상 정보 가져오기
$temp_cl = sql_fetch("select * from {$g5['closthes_table']} where ch_id = '{$ch_id}' and cl_use = '1'");
if($temp_cl['cl_path']) { 
	$ch['ch_body'] = $temp_cl['cl_path'];
}
?>

<style>



::selection			{<?if ($ch['color']){?>
  background: <?=$ch['color']?>;<?}?>
  }
  ::-moz-selection	{<?if ($ch['color']){?>
  background: <?=$ch['color']?>;<?}?>
  }
  ::-webkit-selection	{ <?if ($ch['color']){?>
  background: <?=$ch['color']?>;<?}?>
  }


  *::-webkit-scrollbar-thumb {

  <?if ($ch['color']){?>
  background: <?=$ch['color']?>;<?}?>
  }
  .fas.fa-tools{
  	<?if ($ch['color']){?>
  color: <?=$ch['color']?>;<?}?>
  }

  .fas.fa-tools{
  	<?if ($ch['color']){?>
  color: <?=$ch['color']?>;<?}?>
  }

  .fas.fa-sign-out-alt{
  	<?if ($ch['color']){?>
  color: <?=$ch['color']?>;<?}?>
  }

    .highlight{

  <?if ($ch['color']){?>
  background: <?=$ch['color']?>;<?}?>
  }

  <!---
    .char_name.engname{
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
    }
  --->
  .char_name.belong{
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
    }
    .profile-title{
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
    }

    color{
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
    }

    .char_title{
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
    }
    color{
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
    }



  .menu--viola .menu__link:hover,
  .menu--viola .menu__link:focus {
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
  }

  .menu--viola .menu__item--current .menu__link {
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
  }

  .menu--viola .menu__item::before,
  .menu--viola .menu__item::after,
  .menu--viola .menu__link::before,
  .menu--viola .menu__link::after {
  	<?if ($ch['color']){?>
  	background: <?=$ch['color']?>;<?}?>
  }

  .character_cmt.quoto {
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
  }


  .menu--iris .menu__link:hover,
  .menu--iris .menu__link:focus {
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
  }

  .menu--iris .menu__item--current .menu__link {
  	<?if ($ch['color']){?>
  	color: <?=$ch['color']?>;<?}?>
  }

  .menu--iris .menu__link::before,
  .menu--iris .menu__link::after {
  	<?if ($ch['color']){?>
  	border-color: <?=$ch['color']?>;
  	<?}?>
  }
</style>

<link rel="stylesheet" type="text/css" href="./component.css" />

<div class="cmt_list">
  <div class="character_cmt quoto">“</div>

  <div class="character_cmt"><?=$ch['cmt']?></div>
  <div class="character_cmt quoto">”</div>
</div>

<div class="popup">
  <img id="raw-image" />
</div>

<!-- 캐릭터 비쥬얼 (이미지) 출력 영역 -->

<? if($article['ad_use_body'] && $ch['ch_thumb']) { ?>

<div class="visual-area">
  <div id="characer_head">
    <div id="character_body">
      <div class="body_img">
        <img
          src="<?=$ch['ch_thumb']?>"
          id="body_img_raw"
          alt="캐릭터 전신"
          onclick="wrapWindowByMask(this.src)"
        />
      </div>
      <div class="head_img_ontop"></div>
      <!-- 브금란-->
      <div class="char_profile">
        <div class="char-BG">
          
<!-- 원래 옷장 기능 아이콘
<div id="popup-background"></div>
<? if($article['ad_use_closet'] && $article['ad_use_body']) { ?>
<div class="closet_profile"></div>
<? } ?>
-->
          <!-- 테마곡 -->
          <div class="char_title">
            THEME :
            <?=$ch['title']?>
          </div>

          <? if($ch['ch_music']) { ?>
          <div class="closet_profile">
            <audio
              src=" <?=$ch['ch_music']?>"
              controls
              loop
              id="theme-music"
              style="display:none"
            >
              <?php echo $view['wr_subject'] ?>
            </audio>
            <a href="#" id="btnPlay"><i class="fas fa-play"></i></a>
            <a href="#" id="btnPause"><i class="fas fa-stop"></i></a>

<!--                 
	<a href="#">
	<i class="fas fa-pause" id="btnPause"></i></a> 
-->
            
          </div>
          <? } ?>
        </div>
        <!-- 캐락터 데이터-->
        <div class="char_info_list">
          <div class="char_info_detail">
            <div class="char_info cate highlight">성별</div>
            <div class="char_info gender"><?=$ch['gender']?></div>
          </div>
          <div class="char_info_detail">
            <div class="char_info cate highlight">나이나아아아아아</div>
            <div class="char_info age"><?=$ch['age']?></div>
          </div>
          <div class="char_info_detail">
            <div class="char_info cate highlight">신장/체중</div>
            <div class="char_info height"><?=$ch['height']?>/</div>
            <div class="char_info weight"><?=$ch['weight']?></div>
          </div>
        </div>

        <div class="char_info_list">
          
          <!--- 
          <a href="<?=G5_URL?>/member/index.php?side=<?=$ch['ch_side']?>">
            <div class="char_name side highlight"><?=get_side_name($ch['ch_side'])?>
            </div>
          </a>
          ---->
          
          <div class="char_name belong"><?=$ch['belong']?></div>
          <div class="char_name engname"><?=$ch['engname']?></div>
          
          <!---
          <div class="char_name name"><?=$ch['ch_name']?></div>
          --->
          
        </div>
      </div>
    </div>
  </div>
  <? } ?>
  <hr class="padding" />
  <hr class="padding" />
  <?if($article['ad_use_body'] && $ch['ch_body']) {?>
  <div class="body_img" style="margin:auto;">
    <img
      src="<?=$ch['ch_body']?>"
      id="body_img_raw"
      alt="캐릭터 전신"
      onclick="wrapWindowByMask(this.src)"
    />
  </div>
  <?}?>
  <!-- //캐릭터 비쥬얼 (이미지) 출력 영역 -->
  <hr class="padding" />
  <hr class="padding" />
  <hr class="padding" />

  <section class="section section--menu" style="display:flex;">
    <nav class="menu menu--viola">
      <ul class="menu__list">
        <li class="menu__item menu__item--current">
          <a href="#" class="menu__link" id="appr">외관</a>
        </li>
        <li class="menu__item" id="per">
          <a href="#" class="menu__link">성격</a>
        </li>
        <li class="menu__item" id="etc">
          <a href="#" class="menu__link">기타</a>
        </li>
        <li class="menu__item" id="rec">
          <a href="#" class="menu__link">세션</a>
        </li>
      </ul>
    </nav>
  </section>

  <div class="profile-box appr default">
    <div class="profile-title">외관</div>
    <div class="theme-box profile">
      <?=nl2br($ch['appr'])?>
    </div>
  </div>

  <div class="profile-box per">
    <div class="profile-title">성격</div>
    <div class="theme-box profile">
      <?=nl2br($ch['per'])?>
    </div>
  </div>

  <div class="profile-box etc">
    <div class="profile-title">기타</div>
    <div class="theme-box profile">
      <?=nl2br($ch['etc'])?>
    </div>
  </div>

  <div class="profile-box rec">
    <div class="profile-title">세션</div>
    <div class="theme-box profile">
      <?=nl2br($ch['rec'])?>
    </div>
  </div>

<!-- 
<? if($article['ad_use_closet'] && $article['ad_use_body'] && $mb['mb_id'] == $member['mb_id']) { 
  // 옷장 설정
  // 옷장 사용 및 캐릭터 소유주일시에 출력
  // -- 옷장 출력형태 변경을 원할 시, mypage/character/closet.inc.php 파일을 수정해 주시길 바랍니다.
?>
  <hr class="padding" />
  <h3>CLOSET</h3>
  <div class="theme-box">
	  <? include_once(G5_PATH."/mypage/character/closet.inc.php"); ?>
  </div>
<? } ?> 
-->
  
  <hr class="padding" />
  <hr class="padding" />
  <div style="text-align:center;">
    <? if($is_admin){?>
    <a href='<?=G5_URL?>/mypage/character/character_form.php?w=u&ch_id=<?=$ch['ch_id']?>' class="ui-btn point">수정
    </a>
      <? }?>
    <a href='<?=G5_URL?>/member' class="ui-btn">목록
    </a>
  </div>
  <hr class="padding" />
  <hr class="padding" />
</div>
<script>
  const myAudio = document.getElementById("theme-music");
  const btnPlay = document.getElementById("btnPlay");
  const btnPause = document.getElementById("btnPause");
  const btnStop = document.getElementById("btnStop");
  btnPlay.onclick = function() {
    myAudio.play();
    console.log("play");
  };
  btnPause.onclick = function() {
    myAudio.pause();
    myAudio.currentTime = 0;
  };
  btnStop.onclick = function() {
    console.log("stop");
    myAudio.pause();
    console.log("stop");
  };
  //btnStop.onclick = function () { myAudio.pause(); myAudio.currentTime = 0; }
</script>

<script>
  $("#per").click(function() {
    setTimeout(function() {
      $(".profile-box.per").addClass("default");
      $(".profile-box.appr").removeClass("default");
      $(".profile-box.etc").removeClass("default");
      $(".profile-box.rec").removeClass("default");
    }, 300);
  });

  $("#appr").click(function() {
    setTimeout(function() {
      $(".profile-box.appr").addClass("default");
      $(".profile-box.per").removeClass("default");
      $(".profile-box.etc").removeClass("default");
      $(".profile-box.rec").removeClass("default");
    }, 300);
  });

  $("#etc").click(function() {
    setTimeout(function() {
      $(".profile-box.etc").addClass("default");
      $(".profile-box.appr").removeClass("default");
      $(".profile-box.per").removeClass("default");
      $(".profile-box.rec").removeClass("default");
    }, 300);
  });

  $("#rec").click(function() {
    setTimeout(function() {
      $(".profile-box.rec").addClass("default");
      $(".profile-box.appr").removeClass("default");
      $(".profile-box.per").removeClass("default");
      $(".profile-box.etc").removeClass("default");
    }, 300);
  });
</script>
<script src="./classie.js"></script>
<script src="<?php echo G5_JS_URL ?>/popup.js"></script>

<script>
  (function() {
    [].slice.call(document.querySelectorAll(".menu")).forEach(function(menu) {
      var menuItems = menu.querySelectorAll(".menu__link"),
        setCurrent = function(ev) {
          ev.preventDefault();

          var item = ev.target.parentNode; // li

          // return if already current
          if (classie.has(item, "menu__item--current")) {
            return false;
          }
          // remove current
          classie.remove(
            menu.querySelector(".menu__item--current"),
            "menu__item--current"
          );
          // set current
          classie.add(item, "menu__item--current");
        };

      [].slice.call(menuItems).forEach(function(el) {
        el.addEventListener("click", setCurrent);
      });
    });
  })(window);
</script>
