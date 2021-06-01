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
                        <h4 class="panel-title">Scholarship List</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Active Scholarships </h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Award</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Award</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($scholarships))
                                    @foreach ($scholarships as $scholarship) 
                                    <tr>
                                        <td>{{ $scholarship->scholarship_name }}</td>
                                        <td>{{$scholarship->awards }}</td>
                                        <td>{{date("dS F,Y", strtotime($scholarship->scholarship_expiry_date))}}</td>
                                        <td>{{ ($scholarship->is_active ==1) ? 'active' : 'in active'}}</td>
                                        <td><a href="{{route('admin.scholarship.decline',$scholarship->id)}}" class="btn btn-rounded btn-warning"><i class="fa fa-pencil">&nbsp;Deactivate</i></a></td>
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
@endsection