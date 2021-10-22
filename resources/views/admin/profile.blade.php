@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
        <h3>Personal Details</h3>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <form method="POST" action="{{route('admin.profile.update')}}">
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
                                    <label for="first_name">First Name</label>
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{$user->first_name}}" required placeholder="Enter First Name..">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="last_name">Last Name</label>
                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required placeholder="Enter Last Name..">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{$user->email ?? null}}" required placeholder="Enter Email.." @if(isset($user->id))disabled @endif>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input id="mobile_number" type="text" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" name="mobile_number" value="{{$user->mobile_number ?? null}}" required placeholder="Enter Mobile Number..">
                                </div>
                              
                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection