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
                        <h4 class="panel-title"> Trainer Workout List </h4>        
                         <a href="{{route('admin.workout.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add WorkOut</a>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table trainer-work-list list-style" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Trainer Name</th>
                                        <th>Number Of Workouts</th>
                                        
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Trainer Name</th>
                                        <th>Number Of Workout</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($trainerlist))
                                    @foreach ($trainerlist as $details) 
                                    <tr>
                                        <td><a href="{{route('admin.trainer.workout.list',$details->user_id)}}">{{ $details->first_name }}</a></td>
                                        <td>{{$details->count_userid }}</td>                                   
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