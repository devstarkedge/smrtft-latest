@extends('layouts.app')
@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Reset Your Password</h1>
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
                    <form method="POST" action="{{route('password.store')}}">
                        <h3>Reset Your Password</h3>
                        {{ csrf_field() }}
                        <input type="hidden" id="email" name="email" value="{{$email ?? null }}" required="required">
			<input type="hidden" id="token" name="token" value="{{$token ?? null}}" required="required">
                        <fieldset><input type="password" placeholder="Password" name="password" required="required"></fieldset>
                        <fieldset> <input type="password" placeholder="Confirm Password" name="password_confirmation" required="required"></fieldset>
                        <button>Reset Password</button>
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