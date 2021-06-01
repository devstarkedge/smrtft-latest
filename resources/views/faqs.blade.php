@extends('layouts.app')
@section('content')
<section class="banner inner-banner faq-banner">
    <div class="container">

        <h1>Frequently Asked Questions</h1>
    </div>
</section>
<section class="faqs-section">
    <div class="container">
        <div class="faq-main-outer">
            <ul class="faq-inner">
                @if(isset($faqs) && count($faqs))
                @foreach($faqs as $key =>$question)
                <li class="{{$key == 0 ? 'open' : ''}}">
                    <h4 class="faq-head">{{$question->question}}<span class="toggle-faq {{$key == 0 ? 'rotated' : ''}}"><img src="images/arrow-down.png"></span></h4>
                   
                   <div class="faq-content" style="{{$key != 0 ? 'display: none;' : ''}}">{!!$question->answer!!}</div>
                  
                </li>
                @endforeach
                <!--  <p class="faq-content" style="{{$key != 0 ? 'display: none;' : ''}}">{!!strip_tags(str_replace(['&lt','&gt'],['<','>'],$question->answer))!!}</p> -->
                @else
                <li class="open">
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
                <li>
                    <h4 class="faq-head"> HOW CAN I ADD MY SCHOLARSHIPS TO MYSCHOLARSHIP.NG?     <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                    <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
                </li>
                <li>
                    <h4 class="faq-head">ARE THE SCHOLARSHIPS LEGIT?  <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                    <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
                </li>
                <li>
                    <h4 class="faq-head">HOW DO I APPLY FOR SCHOLARSHIPS?  <span class="toggle-faq"><img src="images/arrow-down.png"></span></h4>
                    <p class="faq-content" style="display: none;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
                </li>
                @endif
                
            </ul>
        </div>
    </div>
</section>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
@endsection

