



tippy('.fa-link', { 
content: '로그 주소가 복사되었습니다.',
placement: 'auto', 
offset: [0, 0],
theme:"whippy",
trigger: 'click',
 hideOnClick : true, 
 animation: 'shift-away',
 arrow: true, onShow(instance) {
    setTimeout(function() {instance.hide()},1000);
  } }

); 
$('.trpg-card').hover(function(){
    $(this).find(".trpg-image").css("filter","saturate(100%)")
    $(this).find("img").css("filter","saturate(100%)")


},function(){
    $(this).find("img").css("filter","saturate(60%)")
    $(this).find(".trpg-image").css("filter","saturate(60%)")
});


$(".trpg-card__icon").on("click",function(event){
    event.preventDefault();
});

    function copy_url(url){
        copyToClipboard(url);
   }

    function copyToClipboard(val) {
        var t = document.createElement("textarea");
        document.body.appendChild(t);
        t.value = val;
        t.select();
        document.execCommand('copy');
        document.body.removeChild(t);
      }
      
        
