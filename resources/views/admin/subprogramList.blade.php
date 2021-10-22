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
                        <h4 class="panel-title">Program Details </h4>        
                         <a href="{{route('admin.trainer.addprogram.details',$id)}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Program Details</a>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        
                                        <th>Week</th>          
                                        <th>Program Description </th>
                                        <th>Workout Name </th>  
                                        <th>Number of Workouts</th>      
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                  
                                   <th>Week</th>
                                        <th>Program Title</th>           
                                        <th>Program Description </th>
                                        <th>Workout Name </th>
                                        <th>Number of Workouts</th>           
                                        <th>Time</th>
                                      <th>Action</th> 
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($subProgramDetail))
                                    @foreach ($subProgramDetail as $details) 
                                    <tr>
                                       
                                        <td>{{ $details->week }}</td>
                                        <td>{{$details->subprogram_desc }}</td>
                                       
                                        <td>{{$details->workoutlist}}</td>
                                         <td>{{ $details->count }}</td>
                                        <td>{{$details->program_time }}</td>
                                      
                                         <td><a href="{{route('admin.trainer.edit.details',$details->id)}}"><i class="fa fa-edit"></i></a><!-- <a href="#"><i class="fa fa-trash"></i></a> --></td>
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