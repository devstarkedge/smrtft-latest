@extends('layouts.user')
@section('content')
<section class="banner inner-banner failed-payment-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Payment Failure</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box has-space no-flex">
                <div class="payment-status failed">
                    <img src="images/payment-failure.png">
                    <h3>Payment Failed</h3>
                    <p>Please check your internet connection or payment method and try again.</p>
                    <a href="#">Take me back to the payment page.</a> | <a href="{{route('user.dashboard')}}"> Take me back to the homepage.</a>
                </div>
            </div>
        </div>
    </div>
</section>
<s            ection class="s        lant-last"></secti    on>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
@endsection