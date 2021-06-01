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
        <title>Security</title>
    </head>
    <body>
        <main class="security-page">
            @include('user.layouts.navbar')
            <div class="purpose-steps account bankdet-in security-in">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="left-box account-det">
                                <h3>Change your Password</h3>
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
                                <form method="POST" action="{{ route('change.password') }}">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" placeholder="Old Password"  name="current_password"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>New password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" placeholder="New Password"  name="password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button class="btn pri-btn" type="submit">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="left-box account-det verf-email">
                                <h3>Verify your email</h3>
                                <p>{{Auth::user()->email}} is verified <i class="fas fa-check"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('layouts.script')
    </body>
</html>