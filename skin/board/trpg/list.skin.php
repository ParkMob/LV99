<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$colspan = 5;
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$category_option = get_category_option($bo_table, $sca);
?>
<div <?if($board['bo_table_width']>0){?>style="max-width:<?=$board['bo_table_width']?><?=$board['bo_table_width']>100 ? "px":"%"?>;margin:0 auto;"<?}?>>


<? if($board['bo_content_head']) { ?>
	<div class="board-notice">
		<?=stripslashes($board['bo_content_head']);?>
	</div>
<? } ?>





<div class = "board_category">
 <?php if ($is_category) { 
     if($sca){?>
     <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sca=<?=$sca?>"><?=$sca?></a>
	<?php } 
    else{?>
        <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>">ALL</a>
    <?}

}?> 
</div>

<div class="board-skin-basic">

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">
	<?//@201023 게시판 글 다중체크용 폼 필드 추가?>
	<div id="trpg-card-list">
		<?
		for ($i=0; $i<count($list); $i++) {
            $img_src = '';
            $img_popup=false;
            $file = get_file($bo_table, $list[$i]['wr_id']);
            if($file[0]) {
                $img_popup=true;
                 $img_src=$file[0]['path']."/".$file[0]['file'];
            
            }
            else if($list[$i]['wr_url']){
            $img_src = $list[$i]['wr_url'];
            $img_popup=true;
            }
            else $img_src=G5_IMG_URL."/trpg_card.png";
		?>
           
        
        <div class="trpg-card">
            <div class="trpg-image" style="background-image: url(<?= $img_src?>);"></div>
            <a href="<? echo $list[$i]['href'] ?>">
            <div class="trpg-mobile"><img src=<?= $img_src?>></div>
            </a>
            <a href="<? echo $list[$i]['href'] ?>">
            <div class="trpg-overlay">
                <div class="trpg-card__share">
                    <?php if( $img_popup){?>
                    <div class="trpg-card__icon" onclick="wrapWindowByMask('<?= $img_src?>')"><i class="fas fa-camera"></i>
                    </div> 
                    <?}?>
                    <div class="trpg-card__icon"  onclick="copy_url('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sca=&sop=and&sfl=wr_id&stx=<?=$list[$i]['wr_id']?>')"><i class="fas fa-link"></i>
                    </div>
				</div>
             
                <div class="trpg-content">
						<div class="trpg-card__category highlight"><? echo $list[$i]['ca_name'] ?></div>
                        <?if(strstr($list[$i]['wr_option'], 'secret')){?>
                        <span>&nbsp;&nbsp;<i class="fas fa-lock"></i></span><?}
                        else if($list[$i]['wr_secret']){?><span >&nbsp;&nbsp;<i class="fas fa-user-tag"></i></span><?}else if($list[$i]['wr_protect']!=''){?><span>&nbsp;&nbsp;<i class="fas fa-key"></i></span><?}
                        if($is_admin){?><span>&nbsp;<?echo $list[$i]['wr_protect'];?></sapn><?}?>
                        <h1 class="trpg-card__title "><? echo $list[$i]['subject'] ?></h1>
						<div class="trpg-card__list">
                            <p class="trpg-card__info">
								<i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_2'] ?>
								<?if($list[$i]['wr_3']){
									?>&nbsp;~&nbsp;<? echo $list[$i]['wr_3'] ?><?
								}?>
							</p>
							<p class="trpg-card__info">
							<i class="fas fa-stopwatch"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_1'] ?>
							</p>
						</div>
						<div class="trpg-card__list">
								<p class="trpg-card__info">
								<i class="fas fa-chalkboard-teacher"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_4'] ?>
								</p>
								<p class="trpg-card__info">
								<i class="fas fa-user-friends"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_5'] ?>
								</p>
						</div>
				</div>
                <!-- <a href="<? echo $list[$i]['href'] ?>">
                <div class="trpg-button"><i class="fas fa-file-alt"></i>&nbsp;로그 확인</div>
                </a> -->
             </div>
                <div class="trpg-content-mobile">
                    <div class="trpg-card__category highlight"><? echo $list[$i]['ca_name'] ?>
                    </div>       
                        <?if(strstr($list[$i]['wr_option'], 'secret')){?>
                        <span >&nbsp;&nbsp;<i class="fas fa-lock"></i></span><?}
                          else if($list[$i]['wr_secret']){?><span >&nbsp;&nbsp;<i class="fas fa-user-tag"></i></span><?}else if($list[$i]['wr_protect']!=''){?><span>&nbsp;&nbsp;<i class="fas fa-key"></i></span><?}     if($is_admin){?><span>&nbsp;<?echo $list[$i]['wr_protect'];?></sapn><?}?>
					<h1 class="trpg-card__title "><? echo $list[$i]['subject'] ?></h1>
					<div class="trpg-card__list">
						<p class="trpg-card__info">
							<i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_2'] ?>
								<?if($list[$i]['wr_3']){
									?>&nbsp;~&nbsp;<? echo $list[$i]['wr_3'] ?><?
								}?>
						</p>
						<p class="trpg-card__info">
							<i class="fas fa-stopwatch"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_1'] ?>
						</p>
					</div>
					<div class="trpg-card__list">
						<p class="trpg-card__info">
						<i class="fas fa-chalkboard-teacher"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_4'] ?>
						</p>
						<p class="trpg-card__info">
						<i class="fas fa-user-friends"></i>&nbsp;&nbsp;<? echo $list[$i]['wr_5'] ?>
						</p>
					</div> 
                    
				</div>
                <!--모바일-->
              
            </a>
        </div>
        
		<? } ?>

		<? if (count($list) == 0) { echo '<li class="no-data ">게시물이 없습니다.</li>'; } ?>
    </div>


	<? if ($list_href || $is_checkbox || $write_href) { ?>
	<div class="bo_fx txt-right">
		<? if ($list_href || $write_href) { ?>
		
		<!-- <?php if ($is_checkbox) { ?> 
            <p class="chk_all">
                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </p> 
		<button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="ui-btn admin">선택삭제</button>
		<button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="ui-btn admin">선택복사</button>
		<button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="ui-btn admin">선택이동</button>
		<?php } ?> -->
		<? if ($list_href) { ?><a href="<? echo $list_href ?>" class="ui-btn">목록</a><? } ?>
		<? if ($write_href) { ?><a href="<? echo $write_href ?>" class="ui-btn point">글쓰기</a><? } ?>
		<? } ?>
		<!-- <? if($admin_href){?><a href="<?=$admin_href?>" class="ui-btn admin" target="_blank">관리자</a><?}?> -->
	</div>
	<? } ?>

    </form> <?//@201023?>
	<!-- 페이지 -->
	<? echo $write_pages;  ?>

	<!-- 게시판 검색 시작 { -->
	<fieldset id="bo_sch" class="txt-center">
		<legend>게시물 검색</legend>

		<form name="fsearch" method="get">
		<input type="hidden" name="bo_table" value="<? echo $bo_table ?>">
		<input type="hidden" name="sca" value="<? echo $sca ?>">
		<input type="hidden" name="sop" value="and">
		<select name="sfl" id="sfl">
			<option value="wr_subject"<? echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
			<option value="wr_content"<? echo get_selected($sfl, 'wr_content'); ?>>내용</option>
            <option value="wr_4"<? echo get_selected($sfl, 'wr_4'); ?>>GM</option>
            <option value="wr_5"<? echo get_selected($sfl, 'wr_5'); ?>>PL(PC)</option>

			<!-- <option value="wr_subject||wr_content"<? echo get_selected($sfl, 'wr_subject||wr_content||wr_4||wr_5'); ?>>제목+내용</option>
			<option value="mb_id,1"<? echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
			<option value="mb_id,0"<? echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
			<option value="wr_name,1"<? echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
			<option value="wr_name,0"<? echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option> -->
		</select>
		<input type="text" name="stx" value="<? echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="20">
		<button type="submit" class="ui-btn point ico search default">검색</button>
		</form>
	</fieldset>
	<!-- } 게시판 검색 끝 -->












</div>


</div>




<div class="popup">
    <img id="raw-image">
	</div> 
<div id="popup-background"></div>

<? if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
	var f = document.fboardlist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}

function fboardlist_submit(f) {
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택복사") {
		select_copy("copy");
		return;
	}

	if(document.pressed == "선택이동") {
		select_copy("move");
		return;
	}

	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
			return false;

		f.removeAttribute("target");
		f.action = "./board_list_update.php";
	}

	return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
	f.action = "./move.php";
	f.submit();
}
</script>



<? } ?>
<!-- } 게시판 목록 끝 -->


<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script src="<?=$board_skin_url?>/trpg.js"></script>
<script src="<?php echo G5_JS_URL ?>/popup.js"></script>

