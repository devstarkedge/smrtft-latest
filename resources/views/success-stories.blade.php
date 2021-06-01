@extends('layouts.app')
@section('content')
<section class="banner inner-banner success-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Success Stories</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box has-space no-flex">
                <div class="main-success">
                    <div class="success-outer">
                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/christie.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Christie D.<br>
                                    Whitmore Lake, MI
                                    University of Michigan</h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>American Legion Auxiliary Michigan Medical Career Scholarship: <span class="price">$500</span> </p>
                                <a href="">Read More</a>
                            </div>
                        </div>

                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/brenne.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Brennan K.<br>
                                    San Diego, CA<br>
                                    San Diego State University</h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>NROTC: $160,000<br>
                                    Elk's Foundation: $3,000
                                </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>


                    <div class="success-outer">
                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/cus.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Cuc N.<br>
                                    Huntsville, AL<br>
                                    University of Louisville</h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>AXA U.S. News and World Report Achievement Scholarship: $10,000 </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>

                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/ellen.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Ellen H.<br>
                                    New Haven, CT<br>
                                    Yale Divinity Schooly</h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>Alpha Kappa Alpha: $1,000<br>
                                    Zeta Phi Beta: $1,000 
                                </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="success-outer">
                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/chrisited.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Christie D.<br>
                                    Whitmore Lake, MI<br>
                                    University of Michigan</h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>American Legion Auxiliary Michigan Medical Career Scholarship: $ 500 </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>

                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/diane.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Diane M.<br>
                                    Miami, FL<br>
                                    Tulane University </h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>Marine Corps Scholarship Foundation: $8,400
                                    George and Diane Yarbrough Collegiate 

                                </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="success-outer">
                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/ivy.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Ivy H.<br>
                                    Fredericksburg, TX<br>
                                    Art Institute of Austin </h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>Passion for Fashion Scholarship: $80,000 </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>

                        <div class="success-single">
                            <div class="sucess-img"><img src="{{asset('images/timothy.jpg')}}"></div>
                            <div class="success-content">
                                <span class="date"><img src="{{asset('images/calendar-icon.png')}}">02 January 2020</span>
                                <h3>Timothy M.<br>
                                    Atlanta, GA<br>
                                    Emory University </h3>
                                <h5>Scholarships Awarded:</h5>
                                <p>2013 Scholarships.com Short & Tweet Scholarship - 1st place winner: $1,000
                                </p>
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div></div>
                <a class="btn-gradient" href="#">Load More</a>
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
@endsection

