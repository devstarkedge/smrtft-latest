@extends('layouts.app')
@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Forgot Password</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box">
                <div class="form-img">
                    <img src="{{asset('images/img-sign-in-form.jpg')}}">
                </div>
                <div class="sign-in-form">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <p> Enter your registered email and a password reset link will be sent to you.</p>
                    <form method="POST" action="{{route('password.send')}}">
                        <h3>Forgot Password</h3>
                        {{ csrf_field() }}
                        <fieldset> <input type="email" placeholder="Email" id="email" name="email" required="required"></fieldset>
                        <button>Submit</button>
                    </form>
                    <ul class="extra-links">
                        <li><a href="{{route('login')}}">Log In</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
@endsection