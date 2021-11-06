<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$p_url="";
if ($view['wr_protect']!=''){
	if( get_session("ss_secret_{$bo_table}_{$view['wr_num']}") ||  $view['mb_id'] && $view['mb_id']==$member['mb_id'] || $is_admin )
		$is_viewer = true;
	else {
	$is_viewer = false; 
	$p_url="./password.php?w=p&amp;bo_table=".$bo_table."&amp;wr_id=".$view['wr_id'].$qstr;
	}
}else if($view['wr_secret'] == '1') {
	if($board['bo_read_level'] < $member['mb_level'] && $is_member)
		$is_viewer = true; 
	else {
	$is_viewer = false; 
	$p_url="./login.php";
	}
}
if(!$is_viewer && $p_url!=''){
	if($p_url=="./login.php") alert("멤버공개 글입니다. 로그인 후 이용해주세요.",$p_url);
	else goto_url($p_url);
}
?>


<script src="<? echo G5_JS_URL; ?>/viewimageresize.js"></script>
<hr class="padding big">
<?=$table_start?> 
<div class="title">
<div class="category">
<? if ($is_category) { ?><strong><?=$view['ca_name']?></strong><? } ?>
	</div>
    <div class="subject">

		<strong class="txt-point"><?=get_text($view['wr_subject'])?></strong>
	</div>
</div>
<div class="session info">
    <span>	<i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;<? echo $view['wr_2'];?> 
    <?if($view['wr_3']){?> 
     ~ <? echo $view['wr_3'];?>
     <?}?>
        
      </span><span id="playtime"><i class="fas fa-stopwatch"></i>&nbsp;&nbsp;<? echo $view['wr_1']; ?></span>
	</div>
    <div class="player info">

<span><i class="fas fa-chalkboard-teacher"></i>&nbsp;&nbsp;<? echo $view['wr_4'];?> </span>
<span><i class="fas fa-user-friends"></i>&nbsp;&nbsp;<? echo $view['wr_5'];?> </span>
</div>

	<?
	if ($view['file']['count']) {
		$cnt = 0;
		for ($i=0; $i<count($view['file']); $i++) {
			if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
				$cnt++;
		}
	}
	?>

	<hr class="padding small">
	<div class="contents">

		<!-- 본문 내용 시작 { -->
		<div id="bo_v_con"><? echo get_view_thumbnail($view['content']); ?></div>
		<?//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
		<!-- } 본문 내용 끝 -->
	</div>
    <hr class="padding" />
    
	<?
	// 코멘트 입출력
	include_once(G5_BBS_PATH.'/view_comment.php');
	?>


	<!-- 링크 버튼 시작 { -->
	<div id="bo_v_bot">
		<?
		ob_start();
		 ?>
		<? if ($prev_href || $next_href) { ?>
		<div class="bo_v_nb">
			<? if ($prev_href) { ?><a href="<? echo $prev_href ?>" class="ui-btn">이전글</a><? } ?>
			<? if ($next_href) { ?><a href="<? echo $next_href ?>" class="ui-btn">다음글</a><? } ?>
		</div>
		<? } ?>

		<div class="bo_v_com">
			<? if ($update_href) { ?><a href="<? echo $update_href ?>" class="ui-btn">수정</a><? } ?>
			<? if ($delete_href) { ?><a href="<? echo $delete_href ?>" class="ui-btn point" onclick="del(this.href); return false;">삭제</a><? } ?>
			<!-- <? if ($copy_href) { ?><a href="<? echo $copy_href ?>" class="ui-btn admin" onclick="board_move(this.href); return false;">복사</a><? } ?>
			<? if ($move_href) { ?><a href="<? echo $move_href ?>" class="ui-btn admin" onclick="board_move(this.href); return false;">이동</a><? } ?>
			<? if ($search_href) { ?><a href="<? echo $search_href ?>" class="ui-btn">검색</a><? } ?> -->
			<a href="<? echo $list_href ?>" class="ui-btn">목록</a>
			<? if ($reply_href) { ?><a href="<? echo $reply_href ?>" class="ui-btn">답변</a><? } ?>
			<!-- <? if ($write_href) { ?><a href="<? echo $write_href ?>" class="ui-btn point">글쓰기</a><? } ?> -->
		</div>
		<?
		$link_buttons = ob_get_contents();
		ob_end_flush();
		 ?>
	</div>
	<!-- } 링크 버튼 끝 -->
<?=$table_end?>


<script>

$(document).ready(function(){
    var list = document.getElementsByClassName("sheet-template_value");
    for(var i=0; i<list.length; i++){
        if(list[i].innerText=="대성공"){
            list[i].style.backgroundColor = "lime";
        }
        else if(list[i].innerText=="대실패"){
            list[i].style.backgroundColor = "red";
        }
        else if(list[i].innerText=="보통 성공"){
            list[i].style.backgroundColor = "#288d28";
        }
        else if(list[i].innerText=="어려운 성공"){
            list[i].style.backgroundColor = "#61c861";
        }
        else if(list[i].innerText=="극단적 성공"){
            list[i].style.backgroundColor = "#86e586";
        }
        else if(list[i].innerText=="실패"){
            list[i].style.backgroundColor = "#ee4242";
        }
    }
});
</script>
<script>

$('.send_memo').on('click', function() {
	var target = $(this).attr('href');
	window.open(target, 'memo', "width=500, height=300");
	return false;
});


<? if ($board['bo_download_point'] < 0) { ?>
$(function() {
	$("a.view_file_download").click(function() {
		if(!g5_is_member) {
			alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
			return false;
		}

		var msg = "파일을 다운로드 하시면 포인트가 차감(<? echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

		if(confirm(msg)) {
			var href = $(this).attr("href")+"&js=on";
			$(this).attr("href", href);

			return true;
		} else {
			return false;
		}
	});
});
<? } ?>

function board_move(href)
{
	window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});

	// 추천, 비추천
	$("#good_button, #nogood_button").click(function() {
		var $tx;
		if(this.id == "good_button")
			$tx = $("#bo_v_act_good");
		else
			$tx = $("#bo_v_act_nogood");

		excute_good(this.href, $(this), $tx);
		return false;
	});

	// 이미지 리사이즈
	$("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
	$.post(
		href,
		{ js: "on" },
		function(data) {
			if(data.error) {
				alert(data.error);
				return false;
			}

			if(data.count) {
				$el.find("strong").text(number_format(String(data.count)));
				if($tx.attr("id").search("nogood") > -1) {
					$tx.text("이 글을 비추천하셨습니다.");
					$tx.fadeIn(200).delay(2500).fadeOut(200);
				} else {
					$tx.text("이 글을 추천하셨습니다.");
					$tx.fadeIn(200).delay(2500).fadeOut(200);
				}
			}
		}, "json"
	);
}
</script>
<!-- } 게시글 읽기 끝 -->