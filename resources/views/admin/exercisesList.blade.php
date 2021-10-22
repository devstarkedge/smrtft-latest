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
                <div class="trainer-title">
                     <h4 class="trainer-name">workout Name <span class="name-style">{{$workoutName}}</span></h4>   
                </div>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Exercise List </h4>
                        <a href="{{route('admin.workout.addexerxcises',$workoutDetails->id)}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Exercise</a>
                         </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th hidden>Trainer Name</th>
                                        <th>Exercise Name</th>
                                        <th>Exercise Description </th>
                                        <th>Exercise Duration</th>
                                        <th>Exercise Url</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th hidden>Trainer Name</th>
                                        <th>Exercise Name</th>
                                        <th>Exercise Description </th>
                                        <th>Exercise Duration</th>
                                        <th>Exercise Url</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($exerciseList))
                                    @foreach ($exerciseList as $details) 
                                    <tr>
                                        <td hidden>{{ $details->first_name }}</td>
                                        <td>{{$details->exercise_name }}</td>
                                        <td>{{$details->exercise_desc }}</td> 
                                        <td>{{$details->exercise_duration}}</td>
                                        <td>{{$details->exercise_video}}</td>
                                         <td><a href="{{route('admin.workout.edit.exercises',$details->id)}}"><i class="fa fa-edit"></i></a></td>                          
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