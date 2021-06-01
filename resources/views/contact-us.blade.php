@extends('layouts.app')
@section('content')
<section class="banner inner-banner contact-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Contact Us</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box has-space no-flex contact-main">
                <div class="contact-form">
                    <h3>Send us a message</h3>
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <form id="contact_us_form" method="POST" action="{{route('home.contact_us.submit')}}">
                        @csrf
                        <fieldset class="one-half">
                            <input type="text" placeholder="First Name*" name="first_name" required="required">
                        </fieldset>

                        <fieldset class="one-half">
                            <input type="text" placeholder="Last Name*" name="last_name">
                        </fieldset>

                        <fieldset class="one-half">
                            <input type="email" placeholder="Email*" name="email" required="required">
                        </fieldset>

                        <fieldset class="one-half">
                            <input type="text" placeholder="Phone*" name="phone">
                        </fieldset>

                        <fieldset class="one-half">
                            <input type="text" placeholder="Subject of message*" name="subject" required="required">
                        </fieldset>

                        <fieldset class="one-half">
                            <textarea type="text" placeholder="Write your message*" name="message" required="required"></textarea>
                        </fieldset>
                        <fieldset class="one-half captcha">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </fieldset>
                        <fieldset class="one-half align-right">
                            <button class="btn-gradient submit-btn">Submit</button>
                        </fieldset>
                    </form>
                </div>



            </div>
        </div>
    </div>
</section>
<section class="slant-last for-links"></section>

<section class="links-contact">
    <div class="container">
        <h2>Questions?</h2>
        <h5>Guaranteed Reply within 24-48 hours!</h5>
        <ul class="support-links">
            <li>
                <span><img src="images/help-icon.png"></span>
                <p><a href="mailto:hello@myscholarships.ng">hello@myscholarships.ng</a></p>
            </li>
            <li class="social-icons">
                <span><img src="images/help-icon.png"></span>
                <p>

                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </p>
            </li>
        </ul>
    </div>
</section>
<section class="slant-white for-last"></section>
@endsection

