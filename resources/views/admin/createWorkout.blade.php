@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Add WorkOut</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                             <form method="POST" action="{{route('admin.workout.save')}}"   enctype="multipart/form-data">
                                
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
                                        <input id="categoryname" type="text" class="form-control{{ $errors->has('categoryname') ? ' is-invalid' : '' }}" name="categoryname" value="{{$categoryDetails->category_name}}" readonly placeholder="Enter  Name..">
                                    </div>
                                    <!-- <div class="form-group col-sm-12">
                                        <label for="amount">Sub Category</label>
                                         <select name="subcategory[]" id="subcategory" class="form-control" multiple>
                                         
                                         @if(count($subcategoryDetails)>0)
                                         @foreach($subcategoryDetails as $details)
                                         <option value="{{$details->id}}">{{$details->subcategory_name}}</option>

                                         @endforeach
                                         @else
                                         <option value="">-- select subcategory --</option>
                                         @endif
                                         </select>
                                    </div> -->

                                     <div class="form-group col-sm-12">
                                        <label for="amount">Sub Category</label>
                                         <div class="multiselect">
										    <div class="selectBox" onclick="showCheckboxes()">
										      <select>
										        <option>Select subcategory</option>
										      </select>
										      <div class="overSelect"></div>
										    </div>
										    <div id="checkboxes">
										    	 @php $i=1; @endphp
                                         @if(count($subcategoryDetails)>0)
                                         @foreach($subcategoryDetails as $details)
                                           <label for="lbl{{$i}}">
                                            <input type="checkbox" id="lbl{{$i}}" value="{{$details->id}}"  name="subcategory[]" /><span class="clscheck">{{$details->subcategory_name}}</span></label> 
                                            @php $i++; @endphp                                        
                                         @endforeach         
                                         @endif					     
										    </div>
                                            <div class="hidecheckbox"></div>
										  </div>                           
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="name">Workout Name</label>
                                        <input id="workoutname" type="text" class="form-control{{ $errors->has('workoutname') ? ' is-invalid' : '' }}" name="workoutname" value="" required placeholder="Enter  Workout Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Workout Description</label>
                                        <input id="workoutdesc" type="text" class="form-control{{ $errors->has('workoutdesc') ? ' is-invalid' : '' }}" name="workoutdesc" value="" required placeholder="Enter  Workout Description..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Workout Image</label>
                                        <input  type="file" class="form-control" id="workoutimage"  name="workoutimage"/>
                                        <div class="dimension-label">
                                            <p>Uploaded Image should have 950 * 553 Dimensions</p>
                                        </div>
                                    </div>
                                  <!--   <div class="form-group col-sm-12">
                                        <label for="amount">Workout Video</label>
                                        <input  type="file" class="form-control" id="workoutvideo"  name="workoutvideo"/>
                                    </div> -->
                                    <div class="form-group col-sm-12">
                                        <label for="name">Workout  Link</label>
                                        <input id="videourl" type="text" class="form-control{{ $errors->has('videourl') ? ' is-invalid' : '' }}" name="videourl" value="" required placeholder="Enter  Workout  Link..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">Workout Time</label>
                                        <input id="workouttime" type="text" class="form-control{{ $errors->has('workouttime') ? ' is-invalid' : '' }}" name="workouttime" value="" required placeholder="Enter  Workout time..">
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
<!--<script type="text/javascript">
	var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}



</script> -->
    @endsection