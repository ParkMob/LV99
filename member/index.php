<?php
include_once('./_common.php');
include_once('./_head.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.member.css">', 0);




$category_title = '';
$sql_search = '';
if($side) { 
	$sql_search .= " and ch_side = '{$side}' ";
	$category_title = get_side_name($side);
}
if($class) { 
	$sql_search .= " and ch_class = '{$class}' ";
	$category_title = get_class_name($class);
}
$sql_common = "select *
			from	{$g5['character_table']}
            where	ch_state = '승인'
					{$sql_search}
			order by ch_id asc";

$result = sql_query($sql_common);
?>



<div class = "board_category">
 <?php if ($category_title) { ?>
    <span class="indent">|</span>
     <a href="<?=G5_URL?>/member/index.php?side=<?=$side?>"><?=$category_title?></a>
<?}else{?>
    <span class="indent">|</span>
        <a href="<?=G5_URL?>/member"  class="category_title"> ALL</a>
    <?}?> 
</div>


<div id="member_page">


<ul class="member-list">
	<? for($i=0; $row=sql_fetch_array($result); $i++) { ?>
		<li>
			<div class="item">
				<a href="./viewer.php?ch_id=<?=$row['ch_id']?>">

					<div class="ui-thumb">
						<div class="ui-thumb bg"></div>
						<div class="ui-thumb image" <? if($row['ch_head']) { ?>style="background-image:url(<?=$row['ch_head']?>)" <? } ?>></div>
                        <?if(get_side_name ($row['ch_side']) !="-"){?>
                            <div class="ui-thumb side">
                            <span class="info side" style="background:<?=get_character_info($row['ch_id'], 'color')?> "><?=get_side_name ($row['ch_side'])?></span>
                            </div><?
                        }?>
						<div class="ui-thumb overlay">
                        
                        <div class="char-info">
						<span class="info lang_name"><?=get_character_info($row['ch_id'], 'lang_name')?></span>
							<span class="info name" style="color: <?=get_character_info($row['ch_id'], 'color')?>"><?=$row['ch_name']?></span>
							

                            </div>
						</div>
					</div>
				</a>
			</div>
		</li>
	<?
		}
		if($i == 0) { 
			echo "<li class='no-data'>등록된 캐릭터가 없습니다.</li>";
		}
		unset($row);
	?>
	</ul>
</div>





<script>
$('.send_memo').on('click', function() {
	var target = $(this).attr('href');
	window.open(target, 'memo', "width=500, height=300");
	return false;
});
</script>
<?php
include_once('./_tail.php');
?>
