@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Edit Program Details</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       

                             <form method="POST" action="{{route('admin.trainer.updateprogram.details',$id)}}"   enctype="multipart/form-data">
                                
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
                                        <label for="amount">Week</label>
                                         <select name="week" id="trainer" class="form-control">
                                         <option value="">-- select Week --</option>
                                         @if(!empty($programDetails->number_of_weeks))
                                         <?php
                                         	$i=1;
                                         	while($i<=$programDetails->number_of_weeks)	
                                         	{ ?>
                                         		 <option value="{{$i}}" <?php echo ($subProgramDetail->week==$i)?'selected':'' ?>>{{$i}}</option>
                                         	<?php
                                         	$i++;
                                         }
                                         ?>
                                         
                                         @endif
                                         </select>
                                    </div>
                                    
                                    
                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Name</label>
                                        <input type="hidden" name="userId" value="{{$programDetails->user_id}}">
                                         <input type="hidden" name="programId" value="{{$programDetails->id}}">
                                        <input id="programname" type="text" class="form-control{{ $errors->has('programname') ? ' is-invalid' : '' }}" name="programname" value="{{$programDetails->program_name}}" readonly>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Sub Program Tile</label>
                                        <input id="subprogramname" type="text" class="form-control{{ $errors->has('subprogramname') ? ' is-invalid' : '' }}" name="subprogramname" value="{{!empty($subProgramDetail->subprogram_name)?$subProgramDetail->subprogram_name:''}}" required placeholder="Enter   program Title..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Description</label>
                                        <input id="programdesc" type="text" class="form-control{{ $errors->has('programdesc') ? ' is-invalid' : '' }}" name="programdesc" value="{{!empty($subProgramDetail->subprogram_desc)?$subProgramDetail->subprogram_desc:''}}" required placeholder="Enter  program Description..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                     <label for="name">Select WorkOuts</label><br>
                                     @if(count($workoutDetails)>0)
                                     @php
                                            $existwork=explode(',',$subProgramDetail->subprogram_workouts);
                                           // print_r($existwork);
                                     @endphp
                                     @foreach($workoutDetails as $details)

                                     <input type="checkbox" value="{{$details->id}}" class="form-control" name="workouts[]" <?php echo in_array(trim($details->id), $existwork)?'checked':'' ?>>
                                      <label for="name">{{$details->workout_name}}</label><br>
                                     @endforeach

                                     @endif
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Time</label>
                                        <input id="programtime" type="text" class="form-control{{ $errors->has('programtime') ? ' is-invalid' : '' }}" name="programtime" value="{{!empty($subProgramDetail->program_time)?$subProgramDetail->program_time:''}}"  required placeholder="Enter  Program time..">
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