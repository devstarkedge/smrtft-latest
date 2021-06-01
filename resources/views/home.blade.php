@extends('layouts.app')
@section('content')
<!-- <section class="banner" style="background: url({{asset('/images/')}}{{'/'.$settings->banner_image ?? 'banner.jpg'}}) no-repeat center;"> -->    
    <section class="banner" >
    <div class="container">
        <div class="content-banner">
            <!-- <h1><div id="feature">@if(!empty($settings->banner_heading)){{ $settings->banner_heading }} @else Chase. Your.@endif
                    <div id="type-field"><span class="type"></span><span class="line-blink"></span></div>
                </div>
            </h1> -->
            <!-- <p>@if(!empty($settings->banner_description)){{$settings->banner_description}}@else Myscholarship.ng is a premium scholarship platform that uses mobile and web-based technologies to help students find free money for school.@endif</p>
 -->
            <div class="form-search">
                <div class="only-search">
                    <form action="{{route('search.scholarships')}}" method="">
                        <input type="text" placeholder="{{!empty($settings->banner_search_text) ? $settings->banner_search_text : 'Start Searching'}}" name="search_text">
                        <button class="search-btn"><img alt="search" src="images/search-icon.svg"></button>
                    </form>
                </div>

              
         
<!--
                <div class="btn-only">
                
<style>
/* fancyBox v2.0.3 fancyapps.com | fancyapps.com/fancybox/#license */.wistia-fancybox .fancybox-tmp iframe,.wistia-fancybox .fancybox-tmp object{vertical-align:top;padding:0;margin:0}.wistia-fancybox .fancybox-wrap{position:absolute;top:0;left:0;z-index:1002}.wistia-fancybox .fancybox-outer{padding:0;margin:0;background:#f1efeb;color:#444;text-shadow:none}.wistia-fancybox .fancybox-opened{z-index:1003}.wistia-fancybox .fancybox-opened .fancybox-outer{-webkit-box-shadow:0 10px 25px rgba(0,0,0,0.5);-moz-box-shadow:0 10px 25px rgba(0,0,0,0.5);box-shadow:0 10px 25px rgba(0,0,0,0.5)}.wistia-fancybox .fancybox-inner{width:100%;height:100%;padding:0;margin:0;position:relative;outline:none;overflow:hidden}.wistia-fancybox .fancybox-error{color:#444;font:14px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;margin:0;padding:10px}.wistia-fancybox .fancybox-image,.wistia-fancybox .fancybox-iframe{display:block;width:100%;height:100%;border:0;padding:0;margin:0;vertical-align:top}.wistia-fancybox .fancybox-image{max-width:100%;max-height:100%}.wistia-fancybox #fancybox-loading{position:fixed;top:50%;left:50%;margin-top:-21px;margin-left:-21px;width:42px;height:42px;background:url("/assets/images/fancybox/fancybox_loading.gif");opacity:0.8;cursor:pointer;z-index:1010}.wistia-fancybox .fancybox-close,.wistia-fancybox .fancybox-prev span,.wistia-fancybox .fancybox-next span{background-image:url("/assets/images/fancybox/fancybox_sprite.png")}.wistia-fancybox .fancybox-close{position:absolute;top:-18px;right:-18px;width:36px;height:36px;cursor:pointer;z-index:1004}.wistia-fancybox .fancybox-close{background-color:rgba(99,97,85,0.9);*background-color:#636155;border-radius:50%;height:31px;right:-15px;top:-15px;width:31px;box-shadow:0 3px 3px rgba(0,0,0,0.4)}.wistia-fancybox .fancybox-prev,.wistia-fancybox .fancybox-next{position:absolute;top:0;width:40%;height:100%;cursor:pointer;background:transparent url("/assets/images/blank.gif");z-index:1003}.wistia-fancybox .fancybox-prev{left:0}.wistia-fancybox .fancybox-next{right:0}.wistia-fancybox .fancybox-prev span,.wistia-fancybox .fancybox-next span{position:absolute;top:50%;left:-9999px;width:36px;height:36px;margin-top:-18px;cursor:pointer;z-index:1003}.wistia-fancybox .fancybox-prev span{background-position:0 -36px}.wistia-fancybox .fancybox-next span{background-position:0 -72px}.wistia-fancybox .fancybox-prev:hover,.wistia-fancybox .fancybox-next:hover{visibility:visible}.wistia-fancybox .fancybox-prev:hover span{left:20px}.wistia-fancybox .fancybox-next:hover span{left:auto;right:20px}.wistia-fancybox .fancybox-tmp{position:absolute;top:-9999px;left:-9999px;padding:0;overflow:visible;visibility:hidden}.wistia-fancybox #fancybox-overlay{position:absolute;top:0;left:0;overflow:hidden;display:none;z-index:1001;background:#000}.wistia-fancybox .fancybox-title{visibility:hidden;font:normal 13px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;position:relative;text-shadow:none;z-index:1005}.wistia-fancybox .fancybox-opened .fancybox-title{visibility:visible}.wistia-fancybox .fancybox-title-float-wrap{position:absolute;bottom:0;right:50%;margin-bottom:-35px;z-index:1003;text-align:center}.wistia-fancybox .fancybox-title-float-wrap .child{display:inline-block;margin-right:-100%;padding:2px 20px;background:transparent;background:rgba(0,0,0,0.7);-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;text-shadow:0 1px 2px #222;color:#FFF;font-weight:bold;line-height:24px;white-space:nowrap}.wistia-fancybox .fancybox-title-outside-wrap{position:relative;margin-top:10px;color:#fff}.wistia-fancybox .fancybox-title-inside-wrap{margin-top:10px}.wistia-fancybox .fancybox-title-over-wrap{position:absolute;bottom:0;left:0;color:#fff;padding:10px;background:#000;background:rgba(0,0,0,0.8)}.wistia-playlist .fancybox-outer,.fancybox-opened.wistia-playlist .fancybox-outer{background:transparent;-webkit-box-shadow:0 0;-moz-box-shadow:0 0;box-shadow:0 0}.wistia-playlist-bare .fancybox-outer{background:#f1efeb;-webkit-box-shadow:0 10px 25px rgba(0,0,0,0.5);-moz-box-shadow:0 10px 25px rgba(0,0,0,0.5);box-shadow:0 10px 25px rgba(0,0,0,0.5)}.wistia-fancybox .wistia-playlist-slide-ears .fancybox-close{right:25px}.wistia-fancybox .wistia-playlist-slide-socialbar .fancybox-close{top:10px}.wistia-fancybox .fancybox-close, .wistia-fancybox .fancybox-prev span, .wistia-fancybox .fancybox-next span {background-image: url("http://fast.wistia.net/assets/images/fancybox/fancybox_sprite.png");}
.video-caption{background-image:url(https://www.dropoff.com/hubfs/Dropoff%202017%2060%20Thumbnail.png);}.wistia-fancybox .fancybox-close:before, .wistia-fancybox .fancybox-close:after {content: '';position: absolute;width: 60%;height: 2px;background: #fff;bottom: 0;top: 0;left: 0;right: 0;margin: auto;transform: rotate(45deg);}.wistia-fancybox .fancybox-close:after {transform: rotate(-45deg);}.fancybox-item.fancybox-close {background-color: #3f339f !important;}
</style>
<script type="text/javascript">
  $(document).ready(function() {
    if (window.location.href.indexOf("search_text") > -1) {
        var $container = $("html,body");
	var $scrollTo = $('.recent-scholars');
	
	$container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(), scrollLeft: 0},300);
    }
  });
</script>
<a href="https://www.youtube.com/embed/dfWlaa9mAOQ?popover=true" class="watch wistia-popover[height=478,playerColor=7b796a,width=800]">
@if(!empty($settings->banner_video_text)){{$settings->banner_video_text}} @else Learn How it Works .@endif<img src="images/paly-icon.png"></a>
<script src="https://fast.wistia.com/assets/external/popover-v1.js" type="text/javascript" charset="ISO-8859-1"></script>
                </div>
-->
            </div>
              <div class="tags">
                    <a href="#">all scholarships</a>
                    <a href="#">marketplace</a>
                    <a href="#">internships</a>
                    <a href="#">daily deals</a>
                </div>
        </div></div>
</section>

<!-- <section class="recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner">
                <h2>Recent Scholarships</h2>
                <table>
                    <tr class="hide-on-mobile">
                        <th><img src="images/amount-icon.png"> Amount</th>
                        <th><img src="images/name-icon.png"> Name</th>
                        <th><img src="images/sponsor-icon.png"> Sponsor</th>
                        <th><img src="images/deadline-icon.png"> Deadline</th>
                        <th><img src="images/available.png"> Available</th>

                    </tr>
                    @if(isset($scholarships) && count($scholarships))
                    @foreach($scholarships as $scholarship)
                    <tr>
                        <td> <h5 class="hide-on-desktop head-table"><img src="images/amount-icon.png"> Amount</h5><p class="amount">{{$scholarship->scholarship_amount}} NGN </p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/name-icon.png"> Name</h5> 
                            <p>{{$scholarship->scholarship_name}}</td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/sponsor-icon.png"> Sponsor</h5>
                            <p>{{!empty($scholarship->user->first_name)?$scholarship->user->first_name:""}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="images/deadline-icon.png"> Deadline</h5>
                            <p>{{date("dS F, Y", strtotime($scholarship->scholarship_expiry_date))}}</p>
                        </td>
<!--                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/available.png"> Available</h5>
                            <p>5</p>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="4" style="text-align: center;"> No Record Found</td></tr>
                    @endif
                </table>
                 <a class="btn-gradient" href="{{route('home.all_scholarships')}}">See All Scholarships</a>
               < @if(empty($_GET['search_text']) || (!empty($_GET['search_text']) && count($scholarships)!=0))
                <a class="btn-gradient" href="{{route('home.all_scholarships')}}">See All Scholarships</a>
                @endif 
            </div>
        </div>
    </div>
</section> -->
<!-- <section class="our-story">
    <div class="container">
        <h2>Watch Our Success Stories</h2>

        <div class="videos">
            <div class="owl-carousel">
                <div class="video-single"> 
                    <div class="video-thumb">
                        <img src="images/video-img.jpg">
                        <span class="play-btn"><img src="images/play-icon-big.png"></span>
                    </div><div class="pattern"><img src="images/patter-video.png"></div></div>

                <div class="video-single"> 
                    <div class="video-thumb">
                        <img src="images/video-img.jpg">
                        <span class="play-btn"><img src="images/play-icon-big.png"></span>
                    </div><div class="pattern"><img src="images/patter-video.png"></div></div>

                <div class="video-single"> 
                    <div class="video-thumb">
                        <img src="images/video-img.jpg">
                        <span class="play-btn"><img src="images/play-icon-big.png"></span>
                    </div>
                    <div class="pattern"><img src="images/patter-video.png"></div></div>



            </div>
        </div>
    </div>
</section> -->
<!-- <section class="faqs">
    <div class="container">
        <h2>Frequently Asked Questions</h2>
        <ul class="faq-inner">
            @if(isset($faqs) && count($faqs))
            @foreach($faqs as $key =>$question)
            <li class="{{$key == 0 ? 'open' : ''}}">
                <h4 class="faq-head">{{$question->question}}<span class="toggle-faq {{$key == 0 ? 'rotated' : ''}}"><img src="images/arrow-down.png"></span></h4>
                 <div class="faq-content" style="{{$key != 0 ? 'display: none;' : ''}}">{!!$question->answer!!}</div>
            </li>
            @endforeach
            <p class="faq-content" style="{{$key != 0 ? 'display: none;' : ''}}">{{strip_tags($question->answer)}}</p> 
            @else
            <li>
                <h4 class="faq-head">What is myscholarship.ng?    <span class="toggle-faq rotated"><img src="images/arrow-down.png"></span></h4>
                <p class="faq-content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
            </li>
            <li>
                <h4 class="faq-head"> Is it free?    <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
            </li>
            <li>
                <h4 class="faq-head">How do i upgrade my account after my trial period?    <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
            </li>
            <li>
                <h4 class="faq-head"> How do i win scholarship?   <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
            </li>
            <li>
                <h4 class="faq-head"> I have a question about a scholarship - can you help?     <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
            </li>
            @endif
        </ul>
        <a class="btn-gradient" href="{{route('home.faqs.index')}}">See All FAQs</a>
    </div>
</section> -->
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
<script>
var header_items = "<?php if (isset($settings->banner_heading_items)) echo $settings->banner_heading_items; ?>";
var items = ['Dreams.  ', 'Ambitions.  ', 'Goals.  ']; // keep a space after array items
// if (header_items != '') {
//     items = header_items.split(',');
// }
let index = 0; // index of array
let charIndex = 0; // index of character in string

function typing() {
    if (index === items.length) {
        index = 0;
        setTimeout(typing, 1000);
    } else if (charIndex >= items[index].length) {
        setTimeout(deleteTxt, 1000);
    } else if (charIndex < items[index].length) {
        const addChar = items[index].substr(-items[index].length, charIndex);
        document.querySelector('.type').innerHTML = addChar;
        charIndex += 1;
        setTimeout(typing, 100); // typing speed
    }
}
;

function deleteTxt() {
    if (charIndex >= 0) {
        const delChar = items[index].substr(-items[index].length, charIndex);
        document.querySelector('.type').innerHTML = delChar;
        charIndex -= 1;
        setTimeout(deleteTxt, 50); // delete speed
    } else if (index <= items.length - 1) {
        index += 1;
        typing();
    } else {
        typing();
    }
}
;

document.addEventListener("DOMContentLoaded", typing());
</script>
@endsection


