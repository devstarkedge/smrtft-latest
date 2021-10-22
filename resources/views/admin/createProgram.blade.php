@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Add Program</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       

                             <form method="POST" action="{{route('admin.program.save')}}"   enctype="multipart/form-data">
                                
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
                                         <option value="{{$details->id}}">{{$username}}</option>
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
                                        <input id="programname" type="text" class="form-control{{ $errors->has('programname') ? ' is-invalid' : '' }}" name="programname" value="" required placeholder="Enter  Program Name..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="name">Program Level</label>
                                       <select name="programlevel" class="form-control">
                                       <option value="All Level">All Level</option>
                                       <option value="Beginners">Beginners</option>
                                       <option value="Intermediate">Intermediate</option>
                                       <option value="Expert">Expert</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Description</label>
                                        <input id="programdesc" type="text" class="form-control{{ $errors->has('programdesc') ? ' is-invalid' : '' }}" name="programdesc" value="" required placeholder="Enter  program Description..">
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="amount">Nutrition Plan</label><br>
                                        
                                         @if(count($nutritionList)>0)
                                     @foreach($nutritionList as $details)
                                     <input type="checkbox" value="{{$details->id}}" class="form-control" name="nutrition[]">
                                      <label for="name">{{$details->nutrition_title}}</label><br>
                                     @endforeach
                                     @endif
                                       
                                         
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Number Of  Weeks</label>
                                        <input id="numberofweeks" type="text" class="form-control{{ $errors->has('numberofweeks') ? ' is-invalid' : '' }} numberofweeks" name="numberofweeks" value="" required placeholder="Enter  Number Of weeks.">
                                    </div>
                                    <div class="form-group col-sm-12 weekdescription">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Program Image</label>
                                        <input  type="file" class="form-control" id="programimage"  name="programimage"/>
                                          <div class="dimension-label">
                                            <p>Uploaded Image should have 950 * 553 Dimensions</p>
                                        </div>
                                    </div>
                                  <div class="form-group col-sm-12">
                                        <label for="amount">Program Intro</label>
                                        <input  type="file" class="form-control" id="programintro"  name="programintro"/>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="name">Program Time</label>
                                        <input id="programtime" type="text" class="form-control{{ $errors->has('programtime') ? ' is-invalid' : '' }}" name="programtime" value="" required placeholder="Enter  Program time..">
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