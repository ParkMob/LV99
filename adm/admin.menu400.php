<?php
$menu['menu400'] = array (
	array('400000', '캐릭터관리', ''.G5_ADMIN_URL.'/character_list.php', ''),
	array('400100', '프로필 양식 관리', ''.G5_ADMIN_URL.'/character_article_list.php', ''),
	array('400200', '캐릭터 관리', ''.G5_ADMIN_URL.'/character_list.php', ''),
	array('400500', '커플 관리', ''.G5_ADMIN_URL.'/couple_list.php', '')
);
if($config['cf_side_title']) {
	$menu['menu400'][] = array('400600', $config['cf_side_title'].' 관리', G5_ADMIN_URL.'/side_list.php', '');
}
?>