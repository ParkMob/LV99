<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
if($board['bo_type']=='board')$category_option = get_category_option($bo_table, $sca);
if ($board['bo_gallery_cols']==0) $bo_gallery_cols=4;
if($board['bo_table_width']==0) $width="100%";
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0); 
?>
<style>
* {
    transition: unset;
    -webkit-transition: unset;
    -ms-transition: unset;
}
</style>

<?php if($board['bo_content_head']) { ?>
	<div class="board-notice">
		<?=stripslashes($board['bo_content_head']);?>
	</div>
	<hr class="padding" />
<?php } ?>


<!-- 게시판 카테고리 시작 { -->

    <div class = "board_category">
<?php if ($is_category) {
    
    ?>
<section class="section section--menu" style="display:flex;">
    <nav class="menu menu--viola">
        <ul class="menu__list">
            <? if(!$sca){?>
                <li class="menu__item menu__item--current"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>" class="menu__link"  >전체</a></li>
            <? }else{?>
            <li class="menu__item"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>" class="menu__link" >전체</a></li>
            <?}
            
            for ($i=0; $i<count($categories); $i++) {
                $category = trim($categories[$i]);
                if($sca==$category){?>
                <li class="menu__item menu__item--current"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sca=<?=$category?>" class="menu__link"  ><?=$category?></a></li>
                
            <?}else{?>
                <li class="menu__item"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sca=<?=$category?>" class="menu__link" ><?=$category?></a></li>

            <?}
        }?>
        </ul>
    </nav>
</section>

<?}?> 

</div>
<!-- 게시판 목록 시작 { -->
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx"  style="width:<?=$board['bo_image_width']?>px; margin:auto;">
        <?php if ($write_href) { ?>
        
        <ul class="btn_bo_user">

            <?php if ($write_href) { ?>
            <li><a href="#" class="edit-item" onclick="pin()"><i class="fas fa-thumbtack"></i></a></li>
            <li><a href="#" class="edit-item pen" onclick="zup()"><i class="fas fa-angle-up"></i></a></li>
            <li><a href="#" class="edit-item"onclick="zdown()"><i class="fas fa-angle-down"></i></a></li>
            <li><a href="#" class="edit-item pen" onclick="rotdown()"><i class="fas fa-undo"></i></a></li>
            <li><a href="#" class="edit-item" onclick="rotup()"><i class="fas fa-redo"></i></a></li>
            <li><a  href="#" onclick="javascript:window.open('<?php echo $write_href ?>','new','left=50, top=50, width=800, height=600')" class="edit-item pen"><i class="fas fa-pen"></i></a></li>
            
            <?php } ?>
        </ul>
        <ul class="btn_bo_user left">

<li><a href="#" class="edit-item " onclick="delete_item()"><i class="fas fa-trash-alt"></i></a></li>
</ul>
        <?php } ?>
    </div>
    <?php } ?>

<div id="fix-layout-out" style="width:<?=$board['bo_image_width']?>px; margin:auto; position: relative; height: <?=$board['bo_gallery_height']?>px">


    <!-- 게시판 페이지 정보 및 버튼 시작 { 
    <div id="bo_btn_top"> 
        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user"> 
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" target="_black" class="admin ui-btn">게시판관리</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="ui-btn point">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    } 게시판 페이지 정보 및 버튼 끝 -->



        <?php for ($i=0; $i<count($list); $i++) {
            
            $is_viewer = true;

			if (!$list[$i]['is_notice']) {  
				$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'],$gal_width,$board['bo_gallery_height'],false,true);
                 if($is_viewer){
                if($thumb['src']) 
                $img_content =  $thumb['ori'];
            else if($list[$i]['wr_url'])
                $img_content =  $list[$i]['wr_url'];
            else $img_content="none";
                }
      
			} 

         
         ?>
         
         <img src=<?=$img_content?> id="item_<?=$list[$i]['wr_id']?>" class="item" style="position:absolute; left:<?=$list[$i]['wr_1']?>; top: <?=$list[$i]['wr_2']?>; z-index: <?=$list[$i]['wr_3']?>; transform:rotate(<?=$list[$i]['wr_4']?>deg) "   
         
          <?php if ($write_href) {
             
              ?>onmousedown="startDrag(event, this,'<?=$list[$i]['wr_type']?>','<?=$list[$i]['wr_url']?>','<?=$list[$i]['wr_5']?>')" onmouseup="mouseUp(<?=$list[$i]['wr_id']?>,this)" <?php
              
              
              }?>> 

        <?php } ?>
        <?php if (count($list) == 0) { echo "<li class=\"empty_list\"></li>"; } ?>

  

</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>



<!-- 페이지 -->
<?php echo $write_pages;  ?>
<script> 


<?php if ($is_checkbox) { ?>
$("#checkall").click(function(){
	$(this).toggleClass("on");
});
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
<?php } ?>

var img_L = 0;
var img_T = 0;
var targetObj;
var img_type= "";
var img_url = "";
var img_bg = "";

function getLeft(o){
     return parseInt(o.style.left.replace('px', ''));
}
function getTop(o){
     return parseInt(o.style.top.replace('px', ''));
}

function pin(){
    var pin_boolean="pic"
    var pin_keyword= "설정"
if(img_bg=="bg"){
    
    pin_boolean = "pic"
     pin_keyword= "해제"
}
else{
    pin_boolean="bg"
     pin_keyword = "설정"

}

    if (!confirm("선택한 이미지를 고정 "+pin_keyword+" 하시겠습니까?"))
    			return false;
    $.ajax({
			url: g5_bbs_url+"/write_update.php",
			type: "POST",
			data: {
                "ajax_write": 'y',
				"uid": "<?php echo get_uniqid(); ?>",
				"w": "u",
				"bo_table": "<?echo $board['bo_table']?>",
				"wr_id": targetObj.id.replace("item_",""),
				"wr_subject": "MINI",
                "wr_type":img_type,
                "wr_url":img_url,
                "wr_1": targetObj.style.left,
				"wr_2": targetObj.style.top,
                "wr_3":0,
                "wr_4":targetObj.style.transform.match(/[-]?[0-9]+/gi)[0],
                "wr_5":pin_boolean
			},
			dataType: "text",
			error: function(xhr, status, error){
				alert(error);
			},
			async: false,
			cache: false,
			success : function(data){
                location.reload();


			}

		});

}
function zup(){

    if(img_bg=="pic"){
    targetObj.style.zIndex =  parseInt(targetObj.style.zIndex) +1;
    mouseUp(targetObj.id.replace("item_",""), targetObj);
}
}
function zdown(){
    if(img_bg=="pic"){
    if( targetObj.style.zIndex >1){
        targetObj.style.zIndex =  targetObj.style.zIndex -1;
    }
    else{
        targetObj.style.zIndex = 1;
    }
    mouseUp(targetObj.id.replace("item_",""), targetObj);
    }
}


function rotup(){

    if(img_bg=="pic"){
    var rot = targetObj.style.transform.match(/[-]?[0-9]+/gi)[0];
    targetObj.style.transform =  "rotate("+String(parseInt(rot)+10)+"deg)"
    mouseUp(targetObj.id.replace("item_",""), targetObj);
    }
}
function rotdown(){

    if(img_bg=="pic"){
    var rot = targetObj.style.transform.match(/[-]?[0-9]+/gi)[0];
    targetObj.style.transform =  "rotate("+String(parseInt(rot)-10)+"deg)"
    
    mouseUp(targetObj.id.replace("item_",""), targetObj);
    }
}



// 이미지 움직이기
function moveDrag(e){
     var e_obj = e;
     var dmvx = parseInt(e_obj.clientX + img_L);
     var dmvy = parseInt(e_obj.clientY + img_T);
      if(dmvx> <? echo $board['bo_image_width']?>-targetObj.width)
      dmvx = <? echo $board['bo_image_width']?>-targetObj.width+"px";
     else if(dmvx<0)
     dmvx = "0px"

     if(dmvy> <? echo $board['bo_gallery_height']?>-targetObj.height)
      dmvy =<? echo $board['bo_gallery_height']?>-targetObj.height+"px";
     else if(dmvy<0)
     dmvy = "0px"

     targetObj.style.left =dmvx+"px";
     targetObj.style.top = dmvy +"px";
     return false;
}

// 드래그 시작
function startDrag(e, obj,type,url,bg){
    img_type=type;
    img_url = url;
    img_bg = bg;
    targetObj = obj;
     var e_obj = e;
     img_L = getLeft(obj) - e_obj.clientX;
     img_T = getTop(obj) - e_obj.clientY;

    if(img_bg=="pic"){

     document.onmousemove = moveDrag;
     document.onmouseup = stopDrag;
     if(e_obj.preventDefault)e_obj.preventDefault();
    }

}

// 드래그 멈추기
function stopDrag(){
     document.onmousemove = null;
     document.onmouseup = null;
}



function delete_item(){
    if (!confirm("선택한 이미지를 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다."))
    			return false;
    $.ajax({
			url: g5_bbs_url+"/delete.php",
			type: "POST",
			data: {
                "ajax_write": 'y',
				"bo_table": "<?echo $board['bo_table']?>",
				"wr_id": targetObj.id.replace("item_","")
            },
			dataType: "text",
			error: function(xhr, status, error){
				alert(error);
			},
			async: false,
			cache: false,
			success : function(data){
                location.reload();

			}

		});

    
}

function mouseUp(id, obj){
    $.ajax({
			url: g5_bbs_url+"/write_update.php",
			type: "POST",
			data: {
                "ajax_write": 'y',
				"uid": "<?php echo get_uniqid(); ?>",
				"w": "u",
				"bo_table": "<?echo $board['bo_table']?>",
				"wr_id": id,
				"wr_subject": "MINI",
                "wr_type":img_type,
                "wr_url":img_url,
                "wr_1": obj.style.left,
				"wr_2": obj.style.top,
                "wr_3":obj.style.zIndex,
                "wr_4":obj.style.transform.match(/[-]?[0-9]+/gi)[0],
                "wr_5":img_bg
			},
			dataType: "text",
			error: function(xhr, status, error){
				alert(error);
			},
			async: false,
			cache: false,
			success : function(data){

			}

		});

    
}
</script>



</script>


<script src="<?php echo G5_JS_URL ?>/classie.js"></script>
<!-- } 게시판 목록 끝 -->
