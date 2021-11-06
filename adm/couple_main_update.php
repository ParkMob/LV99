<?php
$sub_menu = "400500";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();


$sql = " update {$g5['config_table']}
            set cf_1 = '{$_POST['cf_1']}' ";
sql_query($sql);

goto_url('./couple_list.php?'.$qstr);
?>
