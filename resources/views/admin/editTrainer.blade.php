@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
       
        <h3>Edit Trainer</h3>
        
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                            <form method="POST" action="{{route('admin.trainer.update',$trainerDetails->id)}}"   enctype="multipart/form-data">
                                
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
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$trainerDetails->first_name}}" required placeholder="Enter  Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Email</label>
                                         <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$trainerDetails->email}}" required placeholder="Enter Email...">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Profile Image</label>
                                        <img src="{{ asset('/user/'.$trainerDetails->profile_image)}}" alt="" title="" width="100px;" height="100px;" />
                                        <input  type="file" class="form-control" id="profileimage"  name="profileimage"/>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">User Description</label>
                                        <textarea id="description"  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="" required placeholder="Enter  Description.." rows="4" cols="50">{{$trainerDetails->user_desc}}</textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="name">User Address</label>
                                        <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{$trainerDetails->address}}" required placeholder="Enter  Address..">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <div class="status_tr">
                                        <div class="w-100 mt-3 mb-2">    
                                        <label for="name">Status</label>
                                        </div>
                                        <div class="radio-main">
                                        <div class="radio-outer radio-one">
                                        <input type="radio" class="form-control" value="1" @if($trainerDetails->is_active==1) checked  @endif name="status">
                                         <label for="name">Active</label>
                                         </div>
                                         <div class="radio-outer radio-two">
                                         <input type="radio" class="form-control" value="0" @if($trainerDetails->is_active==0) checked  @endif name="status">
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