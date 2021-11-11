<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if($is_admin) set_session("ss_delete_token", $token = uniqid(time()));
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
if($is_member) {
	$comment_token = uniqid(time());
	set_session('ss_comment_token', $comment_token);
}
?>
<div id="page_board_content">

<!-- 상단 공지 부분 -->
<?php if($board['bo_content_head']) { ?>
	<div class="board-notice">
		<?=stripslashes($board['bo_content_head']);?>
	</div>
	<hr class="padding" />
<?php } ?>

<!-- 게시판 카테고리 시작 { -->
    <div class = "board_category">
 <?php if ($is_category) { 
     if($sca){?>
    <?=$sca?>
	<?php } 
    else{
        echo "전체";
    }

}?> 
</div>

	<!-- 버튼 링크 -->
	<!-- <div class="search-box">
		<form name="fsearch" method="get" style="margin:0px;">
			<input type="hidden" name="bo_table" value="<?=$bo_table?>">
			<input type="hidden" name="sca"      value="<?=$sca?>">
			<input type="hidden" name="sfl" value="wr_subject||wr_content">
			<input type="hidden" name="sop" value="and">
			
			<input type="text" name="stx" itemname="검색어" value="<?=$stx?>" >
			<button type="submit" class="ui-btn">SEARCH</button>
		</form>
	</div> -->

	<?php if ($write_href) { ?>
	<div class="ui-write-area">
		<?php include ($board_skin_path."/write.php"); ?>
	</div>
	<?php } ?>

	<div class="ui-qna-list">
	<ajaxcomment>
		<ul>
	<?php
		$lists = array();
		for ($i=0; $i<count($list); $i++) { $lists[$i] = $list[$i]; } 
		
		for ($ii=0; $ii < count($lists); $ii++) {
			$profile = get_member($lists[$ii]['mb_id']);
			include "$board_skin_path/inc.list_main.php";

			$is_open = false;
			$is_author = false;
			if(get_cookie('read_'.$lists[$ii]['wr_id']) == $lists[$ii]['wr_password'] || $is_admin) $is_open = true;
			if($member['mb_id'] && ($member['mb_id'] == $lists[$ii]['mb_id'])) $is_author = true;
			$lists[$ii]['content'] = conv_content($lists[$ii]['wr_content'], 0, 'wr_content');
			$lists[$ii]['content'] = search_font($stx, $lists[$ii]['content']);
	?>
			<li class="theme-box">
				<div>
					<p>
					<? if($lists[$ii]['is_notice']) { ?>
						<i class="notice_ico">NOTICE</i>
					<? } else { ?>
						<i>No.<?=$lists[$ii]['num'];?></i>
					<? } ?>
						<em>
						<? //if($is_member && ($lists[$ii]['mb_id'] != '') && $is_admin) { ?>
							<!--<a href="< ?=G5_BBS_URL?>/memo_form.php?me_recv_mb_id=< ?=$lists[$ii]['mb_id']?>" class="send_memo">-->
						<? //} ?>
						<? if($is_member && $lists[$ii]['ch_id']) { ?>
							<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$lists[$ii]['ch_id']?>" target="_blank">
						<? } ?>
							<?=$lists[$ii]['name']?>
						<? if($is_member && $lists[$ii]['ch_id']) echo "</a>"; ?>
						<? //if($is_member && ($lists[$ii]['mb_id'] != '') && $is_admin) echo "</a>"; ?>
						<!-- <? if($is_admin) { ?> <span style="font-size:10px;opacity:0.5">[ <?=$lists[$ii]['wr_ip']?> ]</span><? } ?> -->
						</em>
						<strong>
						<? if($is_author || $is_admin) { ?>
							<a href="javascript:comment_tog('edit', '<?=$lists[$ii]['wr_id']?>');">수정</a>
							<a href="<?=$delete_href?>">삭제</a>
						<? } else if (!$lists[$ii]['mb_id']) { ?>
							<a href="<?=$delete_href?>">삭제</a>
						<? } ?>
						</strong>
						<span class="date">
							<? echo date('y.m.d H:i', strtotime($lists[$ii]['wr_datetime'])) ?>
						</span>
					</p>
					<div class="qna-content">
					<? if(strstr($lists[$ii]['wr_option'], 'secret') && !$is_open && !$is_author ) { ?>
						<form name="fboardlist" method="post" action="<?=$board_skin_url?>/password.php" style="margin:0">
							<input type="hidden" name="bo_table" value="<?=$bo_table?>">
							<input type="hidden" name="sfl"      value="<?=$sfl?>">
							<input type="hidden" name="stx"      value="<?=$stx?>">
							<input type="hidden" name="spt"      value="<?=$spt?>">
							<input type="hidden" name="page"     value="<?=$page?>">
							<input type="hidden" name="wr_idx"     value="<?=$lists[$ii]['wr_id']?>">
							<input type="hidden" name="sw"       value="">
							<fieldset class="ui-qna-list-password">
								<input type="password" name="wr_password" id="wr_password_<?=$ii?>" value="" placeholder="PASSWORD"/>
								<button type="submit" class="ui-comment-submit ui-btn point">입력</button>
							</fieldset>
						</form>
				<? } else {
					$str = $lists[$ii]['content'];
					$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
					$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
					$str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);' border='0'>", $str);
				?>
						<div id="comment<?=$lists[$ii]['wr_id']?>" class="content">
						<? if(strstr($lists[$ii]['wr_option'], 'secret')) { ?>
							<span style="color: #efb04e;">[SECRET]</span>
						<? } ?> <?=$str?></div>
					<? }
					if($is_author || $is_admin) {
						$str = str_replace('<br/>','',$str); 
					?>
						<div id="edit<?=$lists[$ii]['wr_id']?>" style="display:none;">
							<!-- 코멘트 수정 -->
							<form name="fviewcomment<?=$lists[$ii]['wr_id']?>" method="post" action="./write_comment_update.php" autocomplete="off">
								<input type="hidden" name="w"			value="cu">
								<input type="hidden" name="bo_table"	value="<?=$bo_table?>">
								<input type="hidden" name="wr_id"		value="<?=$lists[$ii]['wr_id']?>">
								<input type="hidden" name="comment_id"	value="<?=$lists[$ii]['wr_id']?>">

								<div class="ui-write-box autosize">
									<textarea id="wr_content" name="wr_content" itemname="내용" required
									<? if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?> style="word-break:break-all;"><?=$str?></textarea>
								</div>
								<? if ($comment_min || $comment_max) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>

								<div class="txt-right">
								<? if ($is_secret) {
									if ($is_admin || $is_secret==1) {
								?>
									<input type="checkbox" id="re_secret<?=$lists[$ii]['wr_id']?>" name="wr_secret" value="secret" <? if(strstr($lists[$ii]['wr_option'], 'secret')) echo "checked";?>> <label for="re_secret<?=$lists[$ii]['wr_id']?>">비밀글</label>&nbsp;&nbsp;
								<?
									} else echo "<input type='hidden' name='wr_secret' value='secret'>";
								} ?>
									<button type="submit" id="btn_submit" class="ui-comment-submit ui-btn point" accesskey="s">입력</button>
								</div>
							</form>
						</div>
					<? } ?>
					</div>
				</div>
				<div id="cmt_<?=$lists[$ii]['wr_id']?>">
				<?php
				$wr_id = $lists[$ii]['wr_id'];
					include ("$board_skin_path/view_comment.php");
				?>
				</div>
			</li>
	<?	}
		// 필터
		if (!$member['mb_id']) // 비회원일 경우에만
			echo "<script language='javascript' src='$g5[path]/js/md5.js'></script>\n";
	?>
	<? if (count($lists) == 0) { echo "<li class='no-data'>등록된 글이 없습니다.</li>"; } ?>
		</ul>

		<!-- 페이지 -->

		<div class="ui-page">
			<? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색'></a>"; } ?>
			<?
			// 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
			//echo $write_pages;
			$write_pages = str_replace("처음", "<<", $write_pages);
			$write_pages = str_replace("이전", "Prev", $write_pages);
			$write_pages = str_replace("다음", "Next", $write_pages);
			$write_pages = str_replace("맨끝", ">>", $write_pages);
			$write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $write_pages);
			$write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font class=\"color_gold2\">$1</font></b>", $write_pages);
			?>
			<?=$write_pages?>
			<? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
		</div>		
	</ajaxcomment>
	</div>
</div>

<script>

//if ("<?=$sca?>") document.fcategory.sca.value = "<?=$sca?>";
if ("<?=$stx?>") {
	document.fsearch.sfl.value = "<?=$sfl?>";
	document.fsearch.sop.value = "<?=$sop?>";
}
// HTML 로 넘어온 <img ... > 태그의 폭이 테이블폭보다 크다면 테이블폭을 적용한다.

<? if ($is_checkbox) { ?>
function all_checked(sw)
{
	var f = document.fboardlist;
	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}
function check_confirm(str)
{
	var f = document.fboardlist;
	var chk_count = 0;
	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}
	if (!chk_count) {
		alert(str + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}
	return true;
}
// 선택한 게시물 삭제
function select_delete()
{
	var f = document.fboardlist;
	str = "삭제";
	if (!check_confirm(str))
		return;
	if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
		return;
	f.action = "./delete_all.php";
	f.submit();
}
// 선택한 게시물 복사 및 이동
function select_copy(sw)
{
	var f = document.fboardlist;
	if (sw == "copy")
		str = "복사";
	else
		str = "이동";
	if (!check_confirm(str))
		return;
	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");
	f.sw.value = sw;
	f.target = "move";
	f.action = "./move.php";
	f.submit();
}
<?php } ?>
function commentReload(cmt_id) {
	jQuery.ajax ({
		url: window.location.href,
		dataType:'html',
		success: function(html) {
			var tempDom2 = $('<output>').append($.parseHTML(html));
			$('ajaxcomment').replaceWith($('ajaxcomment', tempDom2));
			$('#cmt_'+cmt_id+' .toggle_btn').next("div").show();
		}
	});
}
function fviewcomment_submit(cmt_id) {
	f = document.getElementById("fviewcomment" + cmt_id);
	
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    f.wr_content.value = f.wr_content.value.replace(pattern, "");
	
	if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!f.wr_content.value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

	<?php //if($is_guest) echo chk_captcha_js(); ?>

	set_comment_token(f);
	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>

<script>
$(document).on('click', '.toggle_btn', function(){
	var slide = $(this).next("div");
	if(slide.is(":visible")) {
		$(this).removeClass('open');
		slide.slideUp();
	} else {
		$(this).addClass('open');
		slide.slideDown();
	}
});


  $(window).load(function(){$('.hidden').removeClass('hidden'); });
</script>