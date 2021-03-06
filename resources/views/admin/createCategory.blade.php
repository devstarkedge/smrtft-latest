@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Add Category</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                            <form method="POST" action="{{route('admin.category.save')}}"   enctype="multipart/form-data">
                                
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
                                        <label for="name">Category Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('categoryname') ? ' is-invalid' : '' }}" name="categoryname" value="" required placeholder="Enter Category Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Category Description</label>
                                         <input id="plan_period" type="text" class="form-control{{ $errors->has('categorydesc') ? ' is-invalid' : '' }}" name="categorydesc" value="" required placeholder="Enter Category Description...">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Category Image</label>
                                        <input  type="file" class="form-control" id="categoryimage"  name="categoryimage"/>
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