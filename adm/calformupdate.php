<?php
$sub_menu = '300600';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

$sql_common = "cal_name     = '$cal_name',
                cal_add             = '$cal_add',
                cal_color   = '$cal_color'
                ";

if ($w == "")
{
    //if(eregi("[^a-z0-9_]", $co_id)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");
    if(preg_match("/[^a-z0-9_]/i", $co_id)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select co_id from {$g5['cal_table']} where cal_id = '$cal_id' ";
    $row = sql_fetch($sql);
    if ($row['cal_id'])
        alert("이미 같은 ID로 등록된 내용이 있습니다.");

    $sql = " insert {$g5['cal_table']}
                set cal_id = '$cal_id',
                    $sql_common ";
    sql_query($sql);
}
else if ($w == "u")
{
    $sql = " update {$g5['cal_table']}
                set $sql_common
              where cal_id = '$cal_id' ";
    sql_query($sql);
}
else if ($w == "d")
{

    $sql = " delete from {$g5['cal_table']} where cal_id = '$cal_id' ";
    sql_query($sql);
}

if ($w == "" || $w == "u")
{

    if( $error_msg ){
        alert($error_msg, "./calform.php?w=u&amp;cal_id=$cal_id");
    } else {
        goto_url("./calform.php?w=u&amp;cal_id=$cal_id");
    }
}
else
{
    goto_url("./callist.php");
}
?>
