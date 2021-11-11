<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$editor_js = '';
$editor_js .= get_editor_js('wr_content', $is_dhtml_editor);
 
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>


<hr class="padding">
<section id="bo_w">
	<!-- 게시물 작성/수정 시작 { -->
        <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<?php
	$option = '';
	$option_hidden = '';
	if ($is_notice || $is_html || $is_secret || $is_mail) {
		$option = '';
		if ($is_notice) {
			$option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
		}

		if ($is_html) {
			if ($is_dhtml_editor) {
				$option_hidden .= '<input type="hidden" value="html1" name="html">';
			} else {
				$option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
			}
		}

		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
                if($secret_checked)$sec_select="selected";
				$sec .='<option value="secret" '.$sec_select.'>비밀글</option>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}

		if ($is_mail) {
			$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
		}

        
	}

	echo $option_hidden;
    $password="";
    if($write['wr_secret']=='1') $mem_select="selected";
    if($write['wr_protect']!=''){
        $pro_select="selected";
        $password =  $write['wr_protect'];
    }
    if($is_member) {$sec .='<option value="protect" '.$pro_select.'>보호글</option>';
        $sec .='<option value="member" '.$mem_select.'>멤버공개</option>';}
	?>

	<div class="board-write theme-box">
		<nav class="write_category">
		<?php if ($is_category) { ?>
			<select name="ca_name" id="ca_name" required class="required" >
				<option value="">선택하세요</option>
				<?php echo $category_option ?>
			</select>
			&nbsp;&nbsp;
		<?php } ?>
			<?php echo $option ?>
		</nav>

		<nav class="write_category" >
        <?if($is_secret!=2||$is_admin){?>
		<select name="set_secret" id="set_secret">
			<option value="">전체공개</option>
			<?=$sec?>
		</select>
		<?}?>

        <div class="wr_password" style="display:inline-block;">
        <input type="text" name="wr_protect" value= "<?php echo $password ?>" id="wr_protect" class="frm_input" size="20" placeholder="비밀번호" style="display:none;">
		</div> 


		</nav>

        <div class="wr_subject" style="margin-top: 10px;">
			<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255"  placeholder="제목">
		</div>




		<? if($board['bo_1']) { ?>
		<div class="write-notice">
			<?=$board['bo_1']?>
		</div>
		<? } ?>

		<br />

		<div class="wr_content">
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
			<?php } ?>
			<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<div id="char_count_wrap"><span id="char_count"></span>글자</div>
			<?php } ?>
		</div>
        
        <nav class="write_category">
        <select name="wr_type" onchange="fn_log_type(this.value);">
        <option value="URL" <?=$write['wr_type'] == "URL" ? "selected" : ""?>>URL</option>
						<option value="UPLOAD" <?=$write['wr_type'] == "UPLOAD" ? "selected" : ""?>>UPLOAD</option>
					
                        <option value="IMGUR" <?=$write['wr_type'] == "IMGUR" ? "selected" : ""?>>IMGUR</option>
					</select>
                    </nav>
        <nav class="write_category">

		<input type="text" name="wr_10" id="wr_delete" value="<?=$write['wr_10']?>" style="display:none">
					<div id="add_UPLOAD" <?=($write['wr_type'] == "UPLOAD") ?"":"style='display: none;'"?>>
						<input type="file" id="wr_file" name="bf_file[]" class="frm_file frm_input view_image_area" />
					</div>
					<div id="add_URL" <?=($write['wr_type'] == "URL" || $write['wr_type'] == "") ? "": "style='display: none;'"; ?>>
						<input type="text" name="wr_url" value="<?=$write['wr_url']?>" id="wr_url" class="frm_input view_image_area" size="50"  placeholder="이미지 링크 입력"/>
					</div>
                    <div id="add_IMGUR" <?=($write['wr_type'] == "IMGUR") ? "":"style='display: none;'"?>>
                        <input type="file" id="wr_imgur_raw" class="frm_file frm_input view_image_area"/>
                        <button type="button" class="ui-btn point" id="imgur-upload">이미지 등록</button>
					</div>
                    </nav>


	</div>

	<hr class="padding" />
	<div class="btn_confirm txt-center">
		<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit ui-btn point">
		<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel ui-btn">취소</a>
	</div>
	</form>

	<script>
	<?php if($write_min || $write_max) { ?>
	// 글자수 제한
	var char_min = parseInt(<?php echo $write_min; ?>); // 최소
	var char_max = parseInt(<?php echo $write_max; ?>); // 최대
	check_byte("wr_content", "char_count");

	$(function() {
		$("#wr_content").on("keyup", function() {
			check_byte("wr_content", "char_count");
		});
	});

	<?php } ?>
	function html_auto_br(obj)
	{
		if (obj.checked) {
			result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
			if (result)
				obj.value = "html2";
			else
				obj.value = "html1";
		}
		else
			obj.value = "";
	}

	function fwrite_submit(f)
	{
		<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": f.wr_subject.value,
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		if (subject) {
			alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
			f.wr_subject.focus();
			return false;
		}

		if (content) {
			alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
			if (typeof(ed_wr_content) != "undefined")
				ed_wr_content.returnFalse();
			else
				f.wr_content.focus();
			return false;
		}

		if (document.getElementById("char_count")) {
			if (char_min > 0 || char_max > 0) {
				var cnt = parseInt(check_byte("wr_content", "char_count"));
				if (char_min > 0 && char_min > cnt) {
					alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
					return false;
				}
				else if (char_max > 0 && char_max < cnt) {
					alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
					return false;
				}
			}
		}
 

		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	}	
	$('#set_secret').on('change', function() {
		var selection = $(this).val();
		if(selection=='protect') $('#set_protect').css('display','block');
		else {$('#set_protect').css('display','none'); $('#wr_protect').val('');}
	});  
	</script>

    

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

 
<script>
    tippy('#imgur-upload', { 
content: '이미지 업로드 완료!',
placement: 'top', 
theme:'whippy',
offset: [0, 0],
trigger: 'manual',
 animation: 'shift-away',
 arrow: true, onShow(instance) {
    setTimeout(function() {instance.hide()},3000);
  } });

	function fn_log_type(type) { 
		$('#add_'+type).siblings().hide();
		$('#add_'+type).show();
		$('#wr_url').val('');
		$('#wr_file').val('');
		$('#wr_video').val('');
		$('#wr_text').val('');


}

$( document ).ready(function() {

$("#imgur-upload").click(function() {
var file = document.getElementById('wr_imgur_raw')
var data = document.getElementById('wr_url')
var delete_token = document.getElementById('wr_delete');
var form = new FormData();
form.append("image", file.files[0]);

var settings = {
  "url": "https://api.imgur.com/3/image",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Authorization": "Client-ID 7e6b35cd0901e85"
  },
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};
    $.ajax(settings).done(function (response) {
        var result = JSON.parse(response);
        file.value = null 
        data.value = result.data.link;
        delete_token.value = result.data.deletehash;

     document.getElementById('imgur-upload')._tippy.show();


    });
});

	});
</script>
</section>
<!-- } 게시물 작성/수정 끝 -->