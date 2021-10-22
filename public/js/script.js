
$(document).ready(function(){
    $(".toggle-faq").click(function(){
        $(this).toggleClass("rotated");
        $(this).parent().parent().toggleClass("open");
      $(this).parent().next(".faq-content").slideToggle();
    });
$(".numberofweeks").blur(function(){

  var numberofweeks=$(".numberofweeks").val().trim();

  if(numberofweeks!="")
  {
    var data='';
    var total_weeks=parseInt(numberofweeks);
    for(var i=1;i<=total_weeks;i++)
    {

      data=data+'<input id="weekdesc'+i+'" type="text" class="form-control{{ $errors->has("weekdesc") ? " is-invalid" : "" }}" name="weekdesc[]" value="" required placeholder="Enter  week Description..">'
    }
   
    $(".weekdescription").html(data);
  }

});
   

    $('#mobile-toggle').click(function(){
      $(this).toggleClass('open');
      $(".mobile-menu").toggleClass("slide-in");
    });
    $(".taber-nav").click(function(){
      if($(this).hasClass("active")){

      }
      else{
        $(".taber-nav").removeClass("active");
        $(this).addClass("active");
      }
      var data = $(this).attr("data");
      $(".common").attr("style", "display:none");
      $("." + data).attr("style", "display:table");
      

    });
  $("span.toggle-row-data").click(function(){
    
    
var getParent = $(this).parent().parent().attr("class");
var newVar = getParent = getParent.replace('parent', 'child', 'parent-row', 'child-row');
newVar = newVar.replace(' parent-row', '');
  $("." + newVar).slideToggle();
  
  if($(this).hasClass("roated")){
  }
  else{
    $(this).addClass("roated");
    $("span.toggle-row-data").removeClass("roated");
  }
});


 //Slider
      
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        items:1,
        dots:false,
        nav:true,
        navText: ["<img src='images/nav-prev.png'>","<img src='images/nav-next.png'>"]
    
    });


  });
  $(window).load(function () {
           
$(".checker").click(function() {
if ($(this).children().children("input[type=checkbox]").is(
                      ":checked")) {
$(this).addClass('highlight-checked')
                    } else {
                        $(this).removeClass('highlight-checked')
                    }
                });
        
        });

// Prevent events from getting pass .popup
$(".selectBox").click(function(){
$("#checkboxes").toggle();
$('.hidecheckbox').toggleClass('active');
});
$(".hidecheckbox").click(function(){
$("#checkboxes").hide();
$('.hidecheckbox').removeClass('active');
});

