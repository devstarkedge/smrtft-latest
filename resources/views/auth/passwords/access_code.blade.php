<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
        <title>Login</title>
    </head>
    <body>
        <main class="earlyaccess-page">
            <section class="banner-main gr-bg">
                @include('layouts.header')
                <div class="login earlyacc">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                <div class="login-inner">
                                    <h2>MyScholarship Early Access</h2>
                                    <p>Please enter the access code provided in your early access invite email.</p>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    <form method="GET" action="{{route('password.generate.get')}}">
                                        {{ csrf_field() }}
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="access_code" name="access_code" value="{{$token ?? null}}" required="required">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><button class="pri-btn">Enter</button></div>
                                            </div>
                                        </div>
                                        <div class="dont">
                                            <b>Don't have a code? <a href="#">Request Access</a></b>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @include('layouts.script')
    </body>
</html>