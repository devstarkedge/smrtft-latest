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
           
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">User List </h4>        
                         <a href="{{route('admin.user.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add User</a>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table user-list" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Profile Image</th>
                                        <th>Email </th> 
                                        <th>status</th>  
                                        <th>Action</th>
                                    </tr>                                    
                                       
                                </thead>
                                <tfoot>
                                    <tr>
                                   		<th>Name</th>
                                        <th>Profile Image</th>
                                        <th>Email </th> 
                                        <th>status</th>                                  
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($userList))
                                    @foreach ($userList as $details) 
                                    @php  $profileImage=!empty($details->profile_image)?$details->profile_image:"default.jpg"   @endphp
                                    <tr>
                                        <td>{{ $details->first_name }}</td>
                                        <td><img src="{{ asset('/user/'.$profileImage)}}" alt="" title="" width="100px;" height="100px;" /></td>
                                        <td>{{$details->email }}</td>
                                        <td>{{!empty($details->is_active)?"Active":"Deactive" }}</td>
                                         <td><a href="{{route('admin.user.edit',$details->id)}}"><i class="fa fa-edit"></i></a><!-- <a href="#"><i class="fa fa-trash"></i></a> --></td>
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
@endsection