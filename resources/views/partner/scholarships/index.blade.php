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
                            <h3>Scholarship List</h3> &nbsp;
                            <a href="{{route('scholarships.create')}}">Add New Scholarship</a>
                        </div>
                        <div class="loan-data">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Scholarship Name</th>
                                        <th>Scholarship Amount</th>
                                        <th>Posted By</th>
                                        <th>Last Date</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                    @if(!empty($scholarships))
                                    @foreach($scholarships as $scholarship)
                                    <tr>
                                        <td hidden class="tdScholarshipId">{{$scholarship['id']}}</td>
                                        <td>{{$scholarship['scholarship_name']}}</td>
                                        <td>{{$scholarship['scholarship_amount']}}</td>
                                        <td>{{!empty($scholarship['name'])?$scholarship['name']:""}}</td>
                                        <td>{{date("Y-m-d", strtotime($scholarship['scholarship_expiry_date']))}}</td>
                                        <td>{{($scholarship['is_active'] == 1) ? 'active' : 'in active'}}</td>
                                        <td><a href="{{route('scholarships.edit',$scholarship['id'])}}">Edit</a>&nbsp;<a href="#">Delete</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </table>
                            </div>
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
        <script>
$(document).ready(function () {
});
        </script>
    </body>
</html>