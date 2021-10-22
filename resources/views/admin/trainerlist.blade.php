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
                        <h4 class="panel-title">Trainer List </h4>        
                         <a href="{{route('admin.trainer.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Trainer</a>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Profile Image</th>
                                        <th>Email</th>
                                        <th>Description </th>
                                        <th>Address </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Name</th>
                                        <th>Profile Image</th>
                                        <th>Email</th>
                                        <th>Description </th>
                                        <th>Address </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($trainerList))
                                    @foreach ($trainerList as $details) 
                                    <tr>
                                        <td>{{ $details->first_name }}</td>
                                        <td><img src="{{ asset('/user/'.$details->profile_image)}}" alt="" title="" width="100px;" height="100px;" /></td>
                                        <td>{{ $details->email }}</td>
                                        <td>{{$details->user_desc }}</td>
                                        <td>{{$details->address }}</td>
                                        <td>{{!empty($details->is_active)?"Active":"Deactive" }}</td>
                                         <td><a href="{{route('admin.trainer.edit',$details->id)}}"><i class="fa fa-edit"></i></a><a href="{{route('admin.trainer.delete',$details->id)}}"><i class="fa fa-trash"></i></a></td>
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