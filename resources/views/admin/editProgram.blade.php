@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Edit Program</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       

                             <form method="POST" action="{{route('admin.program.update',$programDetails->id)}}"   enctype="multipart/form-data">
                                
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
                                         <option value="{{$details->id}}" @if($details->id==$programDetails->user_id) selected @endif>{{$username}}</option>
                                         @endforeach
                                         @endif
                                         </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Category Name</label>
                                        <input id="category" type="hidden" value="{{$categoryDetails->id}}" name="category">
                                        <input id="categoryname" type="text" class="form-control{{ $errors->has('categoryname') ? ' is-invalid' : '' }}" name="categoryname" value="{{$categoryDetails->category_name}}" readonly placeholder="Enter  Name..">
                                    </div>
                                    
                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Name</label>
                                        <input id="programname" type="text" class="form-control{{ $errors->has('programname') ? ' is-invalid' : '' }}" name="programname" value="{{$programDetails->program_name}}" required placeholder="Enter  Program Name..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="name">Program Level</label>
                                       <select name="programlevel" class="form-control">
                                       <option value="All Level" @if($programDetails->program_level=="All Level") selected @endif>All Level</option>
                                       <option value="Beginners" @if($programDetails->program_level=="Beginners") selected @endif>Beginners</option>
                                       <option value="Intermediate" @if($programDetails->program_level=="Intermediate") selected @endif>Intermediate</option>
                                       <option value="Expert" @if($programDetails->program_level=="Expert") selected @endif>Expert</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Description</label>
                                        <input id="programdesc" type="text" class="form-control{{ $errors->has('programdesc') ? ' is-invalid' : '' }}" name="programdesc" value="{{$programDetails->program_desc}}" required placeholder="Enter  program Description..">
                                    </div>
                                    @php

                                        $nutritionArray=explode(',',$programDetails->nutrition_id);
                                    @endphp
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Nutrition Plan</label><br>
                                        
                                         @if(count($nutritionList)>0)
                                     @foreach($nutritionList as $details)
                                     <input type="checkbox" value="{{$details->id}}" class="form-control" name="nutrition[]" @if (in_array($details->id, $nutritionArray)) checked @endif>
                                      <label for="name">{{$details->nutrition_title}}</label><br>
                                     @endforeach
                                     @endif
                                       
                                         
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Number Of  Weeks</label>
                                        <input id="numberofweeks" type="text" class="form-control{{ $errors->has('numberofweeks') ? ' is-invalid' : '' }}" name="numberofweeks" value="{{$programDetails->number_of_weeks}}" required placeholder="Enter  Number Of weeks." readonly="">
                                    </div>
                                    <div class="form-group col-sm-12 weekdescription">
                                    @php
                                    $numberOfWeeks=$programDetails->number_of_weeks;
                                    for($i=0;$i<$numberOfWeeks;$i++)
                                    {
                                        $week=$weekDesc[$i]->week;
                                       
                                    @endphp

                                    <input id="weekdesc{{$week}}" type="text" class="form-control{{ $errors->has("weekdesc") ? " is-invalid" : "" }}" name="weekdesc[]" value="{{$weekDesc[$i]->week_description}}" required placeholder="Enter  week Description..">

                                    @php
                                    }
                                    @endphp

                                        
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Program Image</label>
                                        <img src="{{ asset('/programimage/'.$programDetails->program_image)}}" alt="" title="" width="100px;" height="100px;" />
                                        <input  type="file" class="form-control" id="programimage"  name="programimage"/>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Program Intro</label>
                                        <input  type="file" class="form-control" id="programintro"  name="programintro"/>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Time</label>
                                        <input id="programtime" type="text" class="form-control{{ $errors->has('programtime') ? ' is-invalid' : '' }}" name="programtime" value="{{$programDetails->program_time}}" required placeholder="Enter  Program time..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <div class="status_tr">
                                        <div class="w-100 mt-3 mb-2">    
                                        <label for="name">Status</label>
                                        </div>
                                        <div class="radio-main">
                                        <div class="radio-outer radio-one">
                                        <input type="radio" class="form-control" value="1" @if($programDetails->program_status==1) checked  @endif name="status">
                                         <label for="name">Active</label>
                                         </div>
                                         <div class="radio-outer radio-two">
                                         <input type="radio" class="form-control" value="0" @if($programDetails->program_status==0) checked  @endif name="status">
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