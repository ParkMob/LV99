<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if (!$lists[$ii]['is_notice']) {
?>
<button class="toggle_btn txt-point">comment <?php echo count($list)?></button>
<?php } ?>
<div style="display:none">

	<ul>
	<!-- 코멘트 리스트 -->
	<?php
    $list= array_reverse($list);
	for ($i=0; $i<count($list); $i++) {
		$comment_id = $list[$i]['wr_id'];
	?>
		<li>
			<div class="qna-comment-content">
				<!-- 코멘트 출력 -->
				<p class="co-info">
				<?php /*if($is_member && ($list[$i][mb_id] != '') && $is_admin) { ?>
					<a href="< ?=G5_BBS_URL?>/memo_form.php?me_recv_mb_id=< ?=$list[$i][mb_id]?>" class="send_memo">
				<?php }*/
				// if($is_member && $list[$i]['ch_id']) {
				// ?>
				 	<!-- <a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$list[$i]['ch_id']?>" target="_blank"> -->
				<?php 
                //}
				echo $list[$i]['name'];
				// if($is_member && $list[$i]['ch_id']) echo "</a>";
				//if($is_member && ($list[$i][mb_id] != '') && $is_admin) echo "</a>";
				// if($is_admin) echo '<span style="font-size:10px;opacity:0.5"> [ '.$list[$i]['wr_ip'].' ]</span>';
				?>
					<em><?php if ($list[$i]['is_edit'])	echo "<a href=\"javascript:comment_tog('edit', '{$comment_id}');\">수정</a>"; ?></em>
					<em><?php if ($list[$i]['is_del'])	echo "<a href=\"javascript:comment_delete('{$list[$i]['del_link']}');\">삭제</a>"; ?></em>
					<span class="date"><?php echo date('m.d H:i', strtotime($list[$i]['datetime'])) ?></span>
				</p>
				<?php
				if (strstr($lists[$ii]['wr_option'], "secret") && !$is_admin && !$is_open && !$is_author) echo "* 작성자만 확인할 수 있습니다.";
				else {
					$str = $list[$i]['content'];
					$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
					$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
					$str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);' border='0'>", $str);
				?>
				<div id="comment<?=$comment_id?>" class="content"><?=$str?></div>
				<?php }
				if ($list[$i]['is_edit']) {
					$str = str_replace('<br/>','',$str); 
				?>
				<div id="edit<?=$comment_id?>" style="display:none;">
					<!-- 코멘트 수정 -->
					<form name="fviewcomment<?=$comment_id?>" method="post" action="./write_comment_update.php" autocomplete="off">
						<input type="hidden" name="w"			value="cu">
						<input type="hidden" name="bo_table"	value="<?=$bo_table?>">
						<input type="hidden" name="wr_id"		value="<?=$comment_id?>">
						<input type="hidden" name="comment_id"	value="<?=$comment_id?>">

						<div class="ui-write-box">
							<textarea id="wr_content" name="wr_content" itemname="내용" style="word-break:break-all;"
							<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?> required><?=$str?></textarea>
						</div>
						<?php if ($comment_min || $comment_max) { ?><script>check_byte('wr_content', 'char_count');</script><?php } ?>

						<div class="txt-right">
							<button type="submit" class="ui-comment-submit ui-btn point" accesskey="s">입력</button>
						</div>
					</form>
				</div>
				<?php } ?>
			</div>
		</li>
	<?php } ?>
	</ul>

    <?php if ($is_comment_write) {
		if (strstr($lists[$ii]['wr_option'], "secret") && !($is_admin) && !($is_open)&&!($is_author)) echo "";
		else 
        
        {
	?>
	<div class="ui-write-area" id="reply<?=$wr_id?>">
		<!-- 코멘트 입력 테이블시작 -->
		<form name="fviewcomment<?=$wr_id?>" id="fviewcomment<?=$wr_id?>" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit('<?=$wr_id?>');" autocomplete="off">
			<input type="hidden" name="w"			value="c">
			<input type="hidden" name="bo_table"	value="<?=$bo_table?>">
			<input type="hidden" name="wr_id"		value="<?=$wr_id?>">
			<input type="hidden" name="comment_id"	value="">
			<input type="hidden" name="token"		value="<?=$comment_token?>">
			<input type="hidden" name="sca"			value="<?=$sca?>" >
			<input type="hidden" name="sfl"			value="<?=$sfl?>" >
			<input type="hidden" name="stx"			value="<?=$stx?>">
			<input type="hidden" name="spt"			value="<?=$spt?>">
			<input type="hidden" name="page"		value="<?=$page?>">
			<input type="hidden" name="cwin"		value="<?=$cwin?>">
			<input type="hidden" name="is_good"		value="">
			<input type="hidden" name="url"			value="./board.php?bo_table=<?=$bo_table?>&page=<?=$page?>">

			<textarea id="wr_content" name="wr_content" rows="4" itemname="내용" style="width:100%; word-break:break-all;" class="tx"
			<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?> required><?=$list[$i]['wr_content']?></textarea>
			<?php if ($comment_min || $comment_max) { ?><script>check_byte('wr_content', 'char_count');</script><?php } ?>




			<div class="txt-right">
            
            <? if(!$is_member){ ?>
		<input type="text" maxlength="20" size="8" name="wr_name" id="wr_name" placeholder="이름" itemname="이름" required value="<?=$name?>" />
		<input type="password" maxlength="20" size="8" id="wr_password" name="wr_password" placeholder="비밀번호" itemname="****" value="<?=$password?>" <?=$password_required?> />
	<? } ?>
				<button type="submit" class="ui-comment-submit ui-btn point" accesskey="s">입력</button>
			</div>
		</form>
	</div>
	<?php }
	}	?>


</div>

<script>
// 글자수 제한
var char_min = parseInt(<?=$comment_min?>); // 최소
var char_max = parseInt(<?=$comment_max?>); // 최대
//function fviewcomment<?=$wr_id?>_submit(f){return true}
</script>
<? 
include_once("$board_skin_path/view_skin_js.php");
?>