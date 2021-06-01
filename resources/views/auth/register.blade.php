@extends('layouts.app')
@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Register</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box">
                <div class="form-img">
                    <img src="images/img-sign-in-form.jpg">
                </div>
                <div class="sign-in-form">
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <form method="POST" action="{{route('register.store')}}">
                        <h3>Register</h3>
                        {{ csrf_field() }}
                        <fieldset> <input type="text" placeholder="First Name" name="first_name" required="required" value="{{ old('first_name') }}"></fieldset>
                        <fieldset><input type="text" placeholder="Last Name" name="last_name" required="required" value="{{ old('last_name') }}"></fieldset>
                        <fieldset><input type="email"  placeholder="Email" name="email" required="required" value="{{ old('email') }}"></fieldset>
                        <fieldset> <select name="user_type" required="required"><option value="">--- Select Account Type ---</option><option value="user" <?php echo (old('user_type')=='user')?'selected':'' ?>>User Account</option><option value="partner" <?php echo (old('user_type')=='partner')?'selected':'' ?>>Sponsor Account</option></select></fieldset>
                        <fieldset class="has-info"><input type="password" placeholder="Password" name="password" required="required" value=""><span class="show-info"><i class="fas fa-info-circle"></i></span>
<p class="info-details">
The password must be at least 8 characters.
Password must contain atleast one upercase,one lowercase and one special character.
The password confirmation must be at least 8 characters like Qwytr@123</p>
                        </fieldset>
                        <!-- <p class="loginError">please enter your email address or password.</p> -->
                        <fieldset><input type="password"  placeholder="Password Confirmation" name="password_confirmation" required="required" value=""></fieldset>
                        <fieldset><input type="tel" placeholder="Mobile Number" name="mobile_number" required="required" value="{{ old('mobile_number') }}"></fieldset>
                        <input type="checkbox" name="terms" id="terms" required=""><p>I agree to the  <a href="{{route('home.terms.conditions')}}" target="_blank">Terms </a> and <a href="{{route('home.privacy.policy')}}" target="_blank">Privacy Policy </a> Agreement.</p>
                        <button>Register</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
@endsection