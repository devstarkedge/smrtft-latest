
$(document).ready(function(){
    $(".toggle-faq").click(function(){
        $(this).toggleClass("rotated");
        $(this).parent().parent().toggleClass("open");
      $(this).parent().next(".faq-content").slideToggle();
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
  });