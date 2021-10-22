@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Add Nutrition Details</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       

                             <form method="POST" action="{{route('admin.nutrition.update',$nutritionDetails->id)}}" "   enctype="multipart/form-data">
                                
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
                                        <label for="name">Nutrition Name</label>
                                        
                                        <input id="nutritionname" type="text" class="form-control{{ $errors->has('nutritionname') ? ' is-invalid' : '' }}" name="nutritionname" value="{{$nutritionDetails->nutrition_title}}">
                                    </div>
                                    
                                   
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Nutrition Image</label>
                                         <img src="{{ asset('/nutrition/'.$nutritionDetails->nutrition_image)}}" alt="" title="" width="100px;" height="100px;" />
                                        <input  type="file" class="form-control" id="nutritionimage"  name="nutritionimage"  />
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name"> NutritionDescription</label>
                                        <textarea id="nutritiondesc"  class="form-control ckeditor {{ $errors->has('nutritiondesc') ? ' is-invalid' : '' }}" name="nutritiondesc" value="" required placeholder="Enter Nutrition  Description.." rows="4" cols="50">{{$nutritionDetails->nutrition_desc}}</textarea>
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Nutrition Video</label>
                                        <input  type="file" class="form-control" id="nutritionvideo"  name="nutritionvideo"/>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="status_tr">
                                        <div class="w-100 mt-3 mb-2">    
                                        <label for="name">Status</label>
                                        </div>
                                        <div class="radio-main">
                                        <div class="radio-outer radio-one">
                                        <input type="radio" class="form-control" value="1" @if($nutritionDetails->nutrition_status==1) checked  @endif name="status">
                                         <label for="name">Active</label>
                                         </div>
                                         <div class="radio-outer radio-two">
                                         <input type="radio" class="form-control" value="0" @if($nutritionDetails->nutrition_status==0) checked  @endif name="status">
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });
</script>
    @endsection