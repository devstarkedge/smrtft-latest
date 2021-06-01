@extends('layouts.app')
@section('content')
<section class="banner inner-banner student-banner scholar-banner-small">
<!--
    <div class="container">
        <div class="content-banner">
        <h1>HELP AFRICAN STUDENTS SUCCEED </h1>
        <h5>We makes it easy for anyone anywhere to create and manage a scholarship online. anyday, anytime.</h5>
<a class="btn-plan" href="{{route('user.dashboard')}}">Post a Scholarship</a>
<a class="btn-plan"  href="#">Our Success Story</a>
    </div></div>
-->
</section>

<section class="about-us student-scholar">
    <div class="container">
        <h2>How It Works</h2>

<div class="steps-infographic">
<img src="images/infograph-how-it-works.svg" alt="How it works">
</div>
    </div>
</section>
<section class="lates-scholarship search-with-us">
    <div class="container">

        
        <div class="join-scholar">
          <h3>Join hundreds of individuals and organizations helping students succeed across Africa</h3>
            <a class="btn-plan" href="{{route('user.dashboard')}}">Post a Scholarship</a>
<a class="btn-plan"  href="https://paystack.com/pay/scholarshipfund">Donate</a>
<a class="btn-plan" href="#">See Our Success Story</a>
<a class="btn-plan"  href="#">Contact Our Team</a>
          
        </div>

    </div>
</section>



@endsection