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
                <div class="trainer-title">
                     <h4 class="trainer-name">Trainer Name <span class="name-style">{{$trainerName}}</span></h4>   
                </div>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Program List </h4>
                         </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th hidden>Trainer Name</th>
                                        <th>Category</th>
                                        <th>Program Name</th>
                                        <th>Number Of Weeks</th>
                                        <th>Program Description </th>
                                        <th>Program Image </th>
                                        <th>Time</th>
                                         <th>Program Status </th>
                                        <th>Action</th>
                                        <th>Video Info</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th hidden>Trainer Name</th>
                                        <th>Category</th>
                                        <th>Program Name</th>
                                        <th>Number Of Weeks</th>
                                        <th>Program Description </th>
                                        <th>Program Image </th>
                                        <th>Time</th>
                                         <th>Program Status </th>
                                        <th>Action</th>
                                        <th> Video Info</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($programList))
                                    @foreach ($programList as $details) 
                                    <tr>
                                        <td hidden>{{ $details->first_name }}</td>
                                        <td>{{$details->category_name }}</td>
                                        <td>{{$details->program_name }}</td>
                                        <td>{{$details->number_of_weeks }}</td>
                                        <td>{{$details->program_desc }}</td>
                                        <td><img src="{{ asset('/programimage/'.$details->program_image)}}" alt="" title="" width="100px;" height="100px;" /></td>
                                        
                                        <td>{{$details->program_time }}</td>
                                        <td>{{!empty($details->program_status)
                                        ?"Active":"Deactive" }}</td>
                                         <td><a href="{{route('admin.program.edit',$details->id)}}"><i class="fa fa-edit"></i></a><!-- <a href="#"><i class="fa fa-trash"></i></a> --></td>
                                         <td><a href="{{route('admin.trainer.program.details',$details->id)}}"> Details</a</td>
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