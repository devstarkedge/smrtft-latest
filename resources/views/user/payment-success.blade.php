@extends('layouts.user')
@section('content')
<section class="banner inner-banner success-payment-banner">
    <div class="container">
        <div class="content-banner">
        <h1>Payment Success</h1>
    </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
        <div class="recent-inner sign-in-box has-space no-flex">
            <div class="payment-status success">
                <img src="{{asset('images/thankyou.png')}}">
                <h3>Payment Succesful</h3>
                <p>Thank you for your payment. An automated payment receipt will be sent to your registered email.</p>
                <a href="{{route('user.dashboard')}}">Back to Home</a>
            </div>

          
        </div>
    </div>
    </div>
</section>
<section class="slant-white for-last"></section>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
@endsection

