@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Add SubCategory</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                            <form method="POST" action="{{route('admin.subcategory.save')}}"   enctype="multipart/form-data">
                                
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
                                        <label for="name">Category </label>
                                        <select class="form-control" name="category">
                                        <option value="">--- select category ---</option>
                                        @if(count($categoryDetails)>0)
                                        @foreach($categoryDetails as $details)
                                        <option value="{{$details->id}}">{{$details->category_name}}</option>

                                        @endforeach

                                        @endif
                                        </select>       
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">SubCategory Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('subcategoryname') ? ' is-invalid' : '' }}" name="subcategoryname" value="" required placeholder="Enter Category Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">SubCategory Description</label>
                                         <input id="plan_period" type="text" class="form-control{{ $errors->has('subcategorydesc') ? ' is-invalid' : '' }}" name="subcategorydesc" value="" required placeholder="Enter Category Description...">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">SubCategory Image</label>
                                        <input  type="file" class="form-control" id="subcategoryimage"  name="subcategoryimage"/>
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