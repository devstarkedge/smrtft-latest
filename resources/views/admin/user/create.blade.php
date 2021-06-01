@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
        @if(isset($user))
        <h3>Edit User</h3>
        @else
        <h3>Add User</h3>
        @endif
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                        @if(isset($user->id))
                        <form method="POST" action="{{route('admin.users.update',$user->id)}}">
                            {{method_field('PUT')}}
                            @else
                            <form method="POST" action="{{route('admin.users.store')}}">
                                @endif
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
                                        <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{$user->first_name ?? null}}" required placeholder="Enter First Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="last_name">Last Name</label>
                                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{$user->last_name ?? null}}" required placeholder="Enter Last Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email ?? null}}" required placeholder="Enter Email.." @if(isset($user->id))disabled @endif>
                                    </div>
                                    @if(!isset($user))
                                    <div class="form-group col-sm-12">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{$user->password ?? null}}" required placeholder="Enter Password..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="password_confirmation">Password Confirmation</label>
                                        <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" value="" required placeholder="Enter Password Confirmation..">
                                    </div>
                                    @endif
                                    <div class="form-group col-sm-12">
                                        <label for="mobile_number">Mobile Number</label>
                                        <input id="mobile_number" type="text" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" name="mobile_number" value="{{$user->mobile_number ?? null}}" required placeholder="Enter Mobile Number..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="role">User Role</label>
                                        <select class="form-control" name="role" required="required">
                                            <option value="">--- Select Role ---</option>
                                            @if(isset($roles) && count($roles))
                                            @foreach($roles as $role)
                                            <option value="{{$role->name}}" {{ (isset($user) && $user->roles[0]->name == $role->name) ? 'selected':''}}>{{$role->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="is_active">User Status</label>
                                        <input class="form-control" type="radio" id="active" name="is_active" value="1" required {{ (isset($user) && $user->is_active == 1) ? 'checked':''}}>Active
                                        <input class="form-control" type="radio" id="in_active" name="is_active" value="0" required {{ (isset($user) && $user->is_active == 0) ? 'checked':''}}>Inactive
                                    </div>
                                    <div class="form-group col-sm-12">
                                        @if (isset($user->id))
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        @else
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection