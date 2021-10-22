@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Edit WorkOut</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                             <form method="POST" action="{{route('admin.workout.update',$workoutDetails->id)}}"   enctype="multipart/form-data">
                                
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
                                        <label for="amount">Trainer</label>
                                         <select name="trainer" id="trainer" class="form-control">
                                         <option value="">-- select trainer --</option>
                                         @if(count($trainerList)>0)
                                         @foreach($trainerList as $details)
                                        @php $username=$details->first_name.' '.$details->last_name; @endphp
                                         <option value="{{$details->id}}" @if($details->id==$workoutDetails->user_id)selected @endif>{{$username}}</option>
                                         @endforeach
                                         @endif
                                         </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Category Name</label>
                                        <input id="categoryname" type="text" class="form-control{{ $errors->has('categoryname') ? ' is-invalid' : '' }}" name="categoryname" value="{{$categoryDetails->category_name}}" readonly placeholder="Enter  Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Sub Category</label>
                                         <select name="subcategory" id="subcategory" class="form-control">
                                         <option value="">-- select subcategory --</option>
                                         @if(count($subcategoryDetails)>0)
                                         @foreach($subcategoryDetails as $details)
                                         <option value="{{$details->id}}" @if($details->id==$workoutDetails->subcategory_id)selected @endif>{{$details->subcategory_name}}</option>

                                         @endforeach
                                         @endif
                                         </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Workout Name</label>
                                        <input id="workoutname" type="text" class="form-control{{ $errors->has('workoutname') ? ' is-invalid' : '' }}" name="workoutname" value="{{$workoutDetails->workout_name}}" required placeholder="Enter  Workout Name..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="name">Workout Description</label>
                                        <input id="workoutdesc" type="text" class="form-control{{ $errors->has('workoutdesc') ? ' is-invalid' : '' }}" name="workoutdesc" value="{{$workoutDetails->workout_desc}}" required placeholder="Enter  Workout Description..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Workout Image</label>
                                        <img src="{{ asset('/workoutimage/'.$workoutDetails->workout_image)}}" alt="" title="" width="100px;" height="100px;" />
                                        <input  type="file" class="form-control" id="workoutimage"  name="workoutimage"/>
                                    </div>
                                  <!--   <div class="form-group col-sm-12">
                                        <label for="amount">Workout Video</label>
                                        <input  type="file" class="form-control" id="workoutvideo"  name="workoutvideo"/>
                                    </div> -->
                                     <div class="form-group col-sm-12">
                                        <label for="name">Workout  Link</label>
                                        <input id="videourl" type="text" class="form-control{{ $errors->has('videourl') ? ' is-invalid' : '' }}" name="videourl" value="{{$workoutDetails->video_url}}"required placeholder="Enter  Workout  Link..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Workout Time</label>
                                        <input id="workouttime" type="text" class="form-control{{ $errors->has('workouttime') ? ' is-invalid' : '' }}" name="workouttime" value="{{$workoutDetails->workout_time}}" required placeholder="Enter  Workout time..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="status_tr">
                                        <div class="w-100 mt-3 mb-2">    
                                        <label for="name">Status</label>
                                        </div>
                                        <div class="radio-main">
                                        <div class="radio-outer radio-one">
                                        <input type="radio" class="form-control" value="1" @if($workoutDetails->workout_status==1) checked  @endif name="status">
                                         <label for="name">Active</label>
                                         </div>
                                         <div class="radio-outer radio-two">
                                         <input type="radio" class="form-control" value="0" @if($workoutDetails->workout_status==0) checked  @endif name="status">
                                         <label for="name">Deactive</label>
                                         </div>
                                         </div>
                                         </div>
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