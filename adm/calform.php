<?php
$sub_menu = '300600';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

// 상단, 하단 파일경로 필드 추가
if(!sql_query(" select co_include_head from {$g5['content_table']} limit 1 ", false)) {
	$sql = " ALTER TABLE `{$g5['content_table']}`  ADD `co_include_head` VARCHAR( 255 ) NOT NULL ,
													ADD `co_include_tail` VARCHAR( 255 ) NOT NULL ";
	sql_query($sql, false);
}

// html purifier 사용여부 필드
if(!sql_query(" select co_tag_filter_use from {$g5['content_table']} limit 1 ", false)) {
	sql_query(" ALTER TABLE `{$g5['content_table']}`
					ADD `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `co_content` ", true);
	sql_query(" update {$g5['content_table']} set co_tag_filter_use = '1' ");
}

// 모바일 내용 추가
if(!sql_query(" select co_mobile_content from {$g5['content_table']} limit 1", false)) {
	sql_query(" ALTER TABLE `{$g5['content_table']}`
					ADD `co_mobile_content` longtext NOT NULL AFTER `co_content` ", true);
}

// 스킨 설정 추가
if(!sql_query(" select co_skin from {$g5['content_table']} limit 1 ", false)) {
	sql_query(" ALTER TABLE `{$g5['content_table']}`
					ADD `co_skin` varchar(255) NOT NULL DEFAULT '' AFTER `co_mobile_content`,
					ADD `co_mobile_skin` varchar(255) NOT NULL DEFAULT '' AFTER `co_skin` ", true);
	sql_query(" update {$g5['content_table']} set co_skin = 'basic', co_mobile_skin = 'basic' ");
}

$html_title = "캘린더";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
	$html_title .= " 수정";
	$readonly = " readonly";

	$sql = " select * from {$g5['cal_table']} where cal_id = '$cal_id' ";
	$cal = sql_fetch($sql);
	if (!$cal['cal_id'])
		alert('등록된 자료가 없습니다.');
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmcalform" action="./calformupdate.php" onsubmit="return frmcontentform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="co_html" value="1">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col class="grid_4">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="cal_id">ID</label></th>
		<td>
			<?php echo help('20자 이내의 영문자, 숫자, _ 만 가능합니다.'); ?>
			<input type="text" value="<?php echo $cal['cal_id']; ?>" name="cal_id" id ="cal_id" required <?php echo $readonly; ?> class="required <?php echo $readonly; ?> frm_input" size="20" maxlength="20">
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="cal_name">제목</label></th>
		<td><input type="text" name="cal_name" value="<?php echo htmlspecialchars2($cal['cal_name']); ?>" id="cal_name" required class="frm_input required" size="50"></td>
	</tr>
    <tr>
		<th scope="row"><label for="cal_add">캘린더 ID</label></th>
		<td>
            <a target="_blank" href="https://docs.google.com/document/d/1k3QH2EuPq2A6h_mrP3b_8C5p2YNUirOm1B0grewpkeg/edit?usp=sharing"><?php echo help('캘린더 ID 확인 방법 안내'); ?></a>
            <input type="text" name="cal_add" value="<?php echo htmlspecialchars2($cal['cal_add']); ?>" id="cal_add" required class="frm_input required" size="80">
        </td>
	</tr>

    </tr>
    <tr>
		<th scope="row"><label for="cal_color">캘린더 색깔</label></th>
		<td>
   
            <input type="text" name="cal_color" value="<?php echo htmlspecialchars2($cal['cal_color']); ?>" id="cal_color" required class="frm_input required" size="30">
            &nbsp;&nbsp;<i class="color-preview" style="background: <?=$cal['cal_color']?>;"></i>
        </td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./callist.php">목록</a>
</div>

</form>

<script>
function frmcontentform_check(f)
{
	errmsg = "";
	errfld = "";

	<?php echo get_editor_js('co_content'); ?>
	<?php echo chk_editor_js('co_content'); ?>
	<?php echo get_editor_js('co_mobile_content'); ?>

	check_field(f.cal_id, "ID를 입력하세요.");
	check_field(f.cal_name, "제목을 입력하세요.");
	check_field(f.cal_add, "내용을 입력하세요.");
	check_field(f.cal_color, "색을 입력하세요.");


	if (errmsg != "") {
		alert(errmsg);
		errfld.focus();
		return false;
	}
	return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
