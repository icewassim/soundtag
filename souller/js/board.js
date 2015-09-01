  var mouse = {x: 0, y: 0};
  document.addEventListener('mousemove', function(e){ 
      mouse.x = e.clientX || e.pageX; 
      mouse.y = e.clientY || e.pageY 
  }, false);


function changeFontAngular(fontName)
{
  $("#comment-area").css("font-family",fontName);
}

$("#main-container").css("height",window.innerHeight);   


$("#comment-button").click(function() {
    $("#comment-container").css("top","25%");
    $("#comment-container").css("left","35%");
    $("#comment-container textarea").val("");
    $("#comment-container textarea").css("color","white");
    $("#submit-comment").removeAttr("disabled");
    $(".modal-footer").css("cursor","move");
    $("#comment-container").fadeIn();
    $("#comment-form").css("-webkit-animation"," scale 0.5s");
  }
 );

$("#scribble-icon").click(function() {
    $("#comment-container").css("top","25%");
    $("#comment-container").css("left","35%");
    $("#comment-container textarea").val("");
    $("#comment-container textarea").css("color","black");
    $("#submit-comment").removeAttr("disabled");
    $(".modal-footer").css("cursor","move");
    $("#comment-container").fadeIn();
    $(this).css("opacity",1);
  }
);

/*
$(function() {
    var aFontsSizeArray = new Array('35', '40','45','50','55','60');
    $('#slider').slider({
        value: 1,
        min: 1,
        max: 5,
        step: 1,
        slide: function(event, ui) {
            var sFontSizeArray = aFontsSizeArray[ui.value];
            // $('#font_size').val(sFontSizeArray + ' px');
            $('#comment-area').css('font-size', sFontSizeArray + 'px' );
        }
    });
   // $('#font_size').val((aFontsSizeArray[$('#size-selector').slider('value')]) + ' px');
});
*/
 $("#font-selector").change(function() {
  var font=$(this).val();
  document.getElementById('comment-area').style.fontFamily=font;//css("font",font);
 }
);

$("#color-selector").change(function() {
    alert("lol")
    var color=$(this).val();
    document.getElementById('comment-area').style.color=color;  
 }
);


(function($) {
    var oldHide = $.fn.popover.Constructor.prototype.hide;

    $.fn.popover.Constructor.prototype.hide = function() {
        if (this.tip().is(":hover")) {
            var that = this;
            // try again after what would have been the delay
            setTimeout(function() {
                return that.hide.call(that, arguments);
            }, that.options.delay.hide);
            return;
        }
        oldHide.call(this, arguments);
    };
})(jQuery);


$('.lightbox').mouseenter(function(){
  $(this).parent().find('span').fadeIn();
  var pos=$(this).parent().css("top").replace("px","");
  if(pos<5)
    $(this).parent().find('span').animate({top: "250px"}, 200);
  else  
    $(this).parent().find('span').animate({top: "-20px"}, 200);
});

function resetPrevious(){
  $("#slider-container").fadeOut();
  $("#"+oldId).css("-webkit-transform",oldposition);
}

function submitRotation(){
  $("#slider-container").fadeOut();
}

function playsong(){
  $("#lifetrack").fadeIn();
  $("#playbutton").css("display","none");
  $(".jp-play").trigger("click");
}

$("#main-menu-dropdown").click(function(){
  hideMainMenue();
})

$(".submenu-item").mouseenter(function(){
  var subclass=$(this).find("span").attr("class");
  subclass=subclass.replace("submenu-icons-black","submenu-icons-white");
  $(this).find("span").first().attr("class",subclass);
});


$(".submenu-item").mouseleave(function(){
  var subclass=$(this).find("span").attr("class");
  subclass=subclass.replace("submenu-icons-white","submenu-icons-black");
  $(this).find("span").first().attr("class",subclass);
});


$("#main-container").click(function(){
  document.addEventListener( 'keyup', onDocumentKeyUp, false );
  if(!$("#comments").is(":hover") && !$("#album-container").is(":hover") && !$("#subboards-container").is(":hover")) {
    $("#commenModal").fadeIn();
    $("#commenModal").css("top",mouse.y-98)
    $("#commenModal").css("left",mouse.x-20); 
    $("#comment-container").css("top",mouse.y-98); 
    $("#comment-container").css("left",mouse.x-20); 
    $("#comment-container").fadeIn(); 
    $("#comment-area").focus();
    $("#comment-area").val("");
    $("#comment-form").css("-webkit-animation"," scale 0.5s");
  }
})

$("#comment-button").click(function(){
  document.addEventListener( 'keyup', onDocumentKeyUp, false );
  if(!$("#comments").is(":hover") && !$("#album-container").is(":hover")) {
    $("#comment-container").css("top",mouse.y-98); 
    $("#comment-container").css("left",mouse.x-20); 
    $("#comment-container").fadeIn(); 
    $("#comment-area").focus();
    $("#comment-area").val("");
    $("#comment-form").css("-webkit-animation"," scale 0.5s");
  }
  
})

  // Deactivate on ESC
  function onDocumentKeyUp( event ) {
    if( event.keyCode === 27 ) {
      commentContainerFadeOut();
      $("#boardPhoto"+editId).parent().parent().fadeOut();
      editId=0;
      commentEditId=0;
    }
  }


function commentContainerFadeOut(){
      $("#commentModal").fadeOut();
      $("#popoverFreshComment").fadeOut();
      $(".popover .fade .top .in").fadeOut;
      $("#comment-container").fadeOut();
      document.removeEventListener( 'keyup', onDocumentKeyUp, false );
}

$("#new-item").tooltip({title:"Create Board",placement:"right"});
$("#my-boards-item").tooltip({title:"About",placement:"right"});
$("#upload-photo-item").tooltip({title:"Upload pictures",placement:"right"});
$("#soundtrack-item").tooltip({title:"#Sound_Tags",placement:"right"});
$("#like-icon").tooltip({title:"Like",placement:"right"});