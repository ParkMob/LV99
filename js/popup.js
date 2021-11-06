

function wrapWindowByMask(img){
    
    $("#raw-image").css("transition","unset");
    $("#raw-image").css("-webkit-transition","unset");
    $("#raw-image").css("-ms-transition","unset");



    $("#raw-image").attr("src", img).load(function(){
        $( '.popup' ).scrollTop( 0 );
        $('#popup-background').fadeIn(300); 
        $('.popup').fadeIn(300);
         $('html').css("overflow","hidden"); 

        if($(window).height()<$(this).height()){ 
            $("#raw-image").css("top","0%");
            $("#raw-image").css("transform","translate(-50%,0%)");
        }
        $( '.popuo' ).scrollTop( 0 );
     
    });
}

// $(".log_img").on('click',function(e){
//     e.preventDefault();
//     wrapWindowByMask(this.src);
// })
$("img").on('click',function(e){
    if(this.className=="log_img"||this.id=="" &&this.className!="only-pc"&&this.className!="not-pc"&&this.className!="guest_list"){
        wrapWindowByMask(this.src);
    }
    if(this.className==""&&this.id!="raw-image"){
        wrapWindowByMask(this.src);
    }
})

$('.popup').click(function () {  
    MaskDown();
}); 


function MaskDown(){
    $('#popup-background').fadeOut(300);
    $('.popup').fadeOut(300); 
    $('html').css("overflow","auto"); 
    
    setTimeout(() => { $("#raw-image").css("top","50%");
    $("#raw-image").css("transform","translate(-50%,-50%)");
    }, 350);
}

$(document).keydown(function(event) {
    if (event.keyCode == '27') {
        MaskDown();
    }
  });