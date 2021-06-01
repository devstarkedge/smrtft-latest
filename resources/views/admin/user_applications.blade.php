@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div id="main-wrapper">
        <div class="row">  
            @if(session()->has('message.level'))
            <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
            </div>
            @endif
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">User Applications List</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">User Application</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Scholarship Name</th>
                                        <th>Scholarship Award</th>
                                        <th>Scholarship Expiry Date</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Scholarship Name</th>
                                        <th>Scholarship Award</th>
                                        <th>Scholarship Expiry Date</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($userApplication))
                                    @foreach ($userApplication as $application) 
                                    <tr>
                                        <td>{{$application->scholarship->scholarship_name }}</td>
                                        <td>{{$application->scholarship->awards }}</td>
                                        <td>{{date("dS F,Y", strtotime($application->scholarship->scholarship_expiry_date))}}</td>
                                        <td>{{$application->user->first_name }}</td>
                                        <td>{{$application->user->email }}</td>
                                        <td>{{$application->user->mobile_number }}</td>
                                        <td>@if($application->is_status ==0)<a href="#" data-user-id="{{$application->user_id}}" data-status="1" data-scholarship-id="{{$application->scholarship_id}}" class="btn btn-rounded btn-warning approve_scholarship"><i class="fa fa-pencil">&nbsp;Approve</i></a>&nbsp;<a href="#"  data-user-id="{{$application->user_id}}" data-status="2" data-scholarship-id="{{$application->scholarship_id}}" class="btn btn-rounded btn-warning approve_scholarship"><i class="fa fa-pencil">&nbsp;Decline</i></a> @elseif($application->is_status==1) Approved @else Declined @endif</td>
                                    </tr>
                                    @endforeach        
                                    @endif
                                </tbody>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function () {


    $(document).on("click", ".approve_scholarship", function(){

        var userselection = confirm("Are you sure you want to Approve/Decline?");
        if (userselection == true) {
            var user_id = $(this).attr('data-user-id');
            var scholarship_id = $(this).attr('data-scholarship-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "{{route('partner.scholarship.approve')}}",
                type: "POST",
                data: {"user_id":+user_id,"scholarship_id": +scholarship_id,"status": +status,"_token": "{{ csrf_token() }}"},
                success: function (result) {
                    
                    window.location.href = "{{ route('admin.user_applications')}}";
                }
            });
        } else {

        }
    });
});
</script>
@endsection