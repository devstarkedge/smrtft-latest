@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Add User</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                            <form method="POST" action="{{route('admin.user.save')}}"   enctype="multipart/form-data">
                                
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
                                        <label for="name">User Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="" required placeholder="Enter  Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Email</label>
                                         <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="" required placeholder="Enter Email...">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Phone</label>
                                         <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="mobile_number" value="" required placeholder="Enter Phone Number...">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Profile Image</label>
                                        <input  type="file" class="form-control" id="profileimage"  name="profileimage"/>
                                          <div class="dimension-label">
                                            <p>Uploaded Image should have 950 * 553 Dimensions</p>
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