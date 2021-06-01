@extends('layouts.app')
@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Sign In</h1>
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
                    <form method="POST" action="{{route('login.post')}}">
                        <h3>Log in</h3>
                        {{ csrf_field() }}
                        <fieldset> <input type="email" placeholder="Email*" name="email"></fieldset>
                        <fieldset> <input type="password" placeholder="Password*" name="password"></fieldset>
                        <button>Sign In</button>
                    </form>
                    <ul class="extra-links">
                        <li><a href="{{route('password.email')}}">Forget Password?</a></li>
                        <li><a href="{{route('register.index')}}">Register now</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
@endsection

