 @extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Edit Exercise</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                             <form method="POST" action="{{route('admin.workout.updateexercises',$exerciseDetails->id)}}"   enctype="multipart/form-data">
                                
                                @if(session()->has('message.level'))
                                <div class="alert alert-{{ session('message.level') }}"> 
                                    {!! session('message.content') !!}
                                </div>
                                @endif
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @csrf
                                 
                                <div class="row">
                                
                                   <div class="form-group col-sm-12">
                                        <label for="name">Workout Name</label>
                                        <input id="workoutname" type="text" class="form-control{{ $errors->has('programname') ? ' is-invalid' : '' }}" name="workoutname" value="{{$workoutDetails->workout_name}}" readnly >
                                        <input type="hidden" name="workoutid" value="{{$workoutDetails->id}}">

                                    </div>
                                    
                                    <div class="form-group col-sm-12">
                                        <label for="name">Exercise Name</label>
                                        <input id="exercisename" type="text" class="form-control{{ $errors->has('programname') ? ' is-invalid' : '' }}" name="exercisename" value="{{$exerciseDetails->exercise_name}}" required placeholder="Enter  Exercise Name..">
                                    </div>
                                 
                                    <div class="form-group col-sm-12">
                                        <label for="name">Exercise Description</label>
                                        <input id="exercisedesc" type="text" class="form-control{{ $errors->has('exercisedesc') ? ' is-invalid' : '' }}" name="exercisedesc" value="{{$exerciseDetails->exercise_desc}}" required placeholder="Enter  Exercise Description..">
                                    </div>

                                  
                                  
                                  <div class="form-group col-sm-12">
                                        <label for="amount">Exercise Video</label>
                                        <input id="exercisevideo" type="text" class="form-control{{ $errors->has('exercisevideo') ? ' is-invalid' : '' }}" name="exercisevideo" value="{{$exerciseDetails->exercise_video}}" required placeholder="Enter  Exercise Video URL..">
                                        <!-- <input  type="file" class="form-control" id="exercisevideo"  name="exercisevideo"/> -->
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="name">Exercise Duration</label>
                                        <input id="exerciseduration" type="text" class="form-control{{ $errors->has('exerciseduration') ? ' is-invalid' : '' }}" name="exerciseduration" value="{{$exerciseDetails->exercise_duration}}" required placeholder="Enter  Exercise Duration..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                       
                                        <button type="submit" class="btn btn-primary">Save</button>
                                       
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection