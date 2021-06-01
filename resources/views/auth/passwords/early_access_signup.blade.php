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
        <title>Early Signup</title>
    </head>
    <body>
        <main class="earlysignup-page">
            <section class="banner-main gr-bg">
                @include('layouts.header')
                <div class="login earl-sign">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="login-inner">
                                    <h2>Almost there!</h2>
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
                                    <form method="POST" action="{{route('password.generate.post',$user->id)}}">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="user_id" value="{{$user->id ?? null }}">
                                        <input type="hidden" name="access_token" value="{{$user->access_token ?? null }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="{{$user->first_name ?? null}}" required="required">
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control"  placeholder="Last Name" id="last_name" name="last_name" value="{{$user->last_name ?? null}}" required="required">
                                        </div>
                                        <div class="input-group">
                                            <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{$user->email ?? null}}" required="required">
                                        </div>
                                        <div class="input-group">
                                            <input type="password" class="form-control"  placeholder="password" id="password" name="password" required="required">
                                        </div>
                                        <p class="pass-instr">Password (min 8 characters with at least one number, upper and lower case letter)</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" onclick="changeType()">
                                            <label class="form-check-label" for="inlineRadio1">Show Password</label>
                                        </div>
                                        <button type="submit" class="btn pri-btn">Join</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script>
                                                $(document).ready(function () {
                                                    $(".nav-btn").click(function () {
                                                        $(".nav-show").slideToggle();
                                                        if ($(".nav-btn").hasClass("change")) {
                                                            $(".nav-btn").removeClass("change");
                                                        } else {
                                                            $(".nav-btn").addClass("change");
                                                        }
                                                    });
                                                });
                                                function changeType() {
                                                    var x = document.getElementById("password");
                                                    if (x.type === "password") {
                                                        x.type = "text";
                                                    } else {
                                                        x.type = "password";
                                                    }
                                                }
        </script>
    </body>
</html>