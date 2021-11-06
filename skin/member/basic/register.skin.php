<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


<div id="member_page">

	<h1 class="member-title">
		<strong>가입 약관</strong>
	</h1>


	<!-- 회원가입약관 동의 시작 { -->
	<div class="member-contents agree-pannel">
		<form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

		<section id="fregister_term">
			<div class="theme-box">
				<?=nl2br($config['cf_stipulation'])?>
			</div>
			<fieldset class="check-agree">
				<input type="checkbox" name="agree" value="1" id="agree11">
				<label for="agree11">가입 약관에 동의합니다.</label>
			</fieldset>
		</section>


		<div class="ui-button-box txt-center">
			<button type="submit" class="ui-btn point">계정생성</button>
		</div>

		</form>

	</div>

</div>

<script>
function fregister_submit(f)
{
	if (!f.agree.checked) {
		alert("가입 약관에 동의하셔야 회원가입을 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}

	return true;
}
</script>


