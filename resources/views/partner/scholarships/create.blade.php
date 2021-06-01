<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('/css/style.css')}}">
        <title>Dashboard</title>
    </head>
    <body>
        <main class="dashboard-page">
            @include('user.layouts.navbar')
            <div class="loan-appl">
                <div class="container">
                    <div class="loan-in">
                        <div class="top">
                            @if(isset($scholarship))
                            <h3>Edit Scholarship </h3>
                            @else
                            <h3>Add new Scholarship </h3>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            @if($errors->any())
                            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                            @endif
                            @if(isset($scholarship->id))
                            <form id="scholarship_form" method="POST" action="{{route('scholarships.update',$scholarship->id)}}">
                                <input name="_method" type="hidden" value="PUT">
                                @else
                                <form id="scholarship_form" method="POST" action="{{route('scholarships.store')}}">
                                    @endif
                                    @csrf
                                    <label for="name">Scholarship Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  placeholder="Scholarship Name" name="scholarship_name" required="required" value="{{$scholarship->scholarship_name ?? null}}">
                                    </div>
                                    <label for="amount">Scholarship Amount</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Scholarship Amount" name="scholarship_amount" required="required" value="{{$scholarship->scholarship_amount ?? null}}">
                                    </div>
                                    <label for="date">Scholarship Expiry Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" placeholder="scholarship_expiry_date" id="scholarship_expiry_date" name="scholarship_expiry_date" value="{{(isset($scholarship)) ? date("Y-m-d", strtotime($scholarship->scholarship_expiry_date)) : null}}" required="required">
                                    </div>
                                    <div class="input-groupsb">
                                        <button type="submit" class="btn pri-btn">Submit for admin review</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>