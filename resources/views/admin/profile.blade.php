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
                        <form method="POST" action="{{route('user.profile.update')}}">
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
                                    <label for="city">City</label>
                                    <input id="city" type="text" class="form-control" name="city" value="{{$user->city}}" placeholder="Enter City..">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="state">State</label>
                                    <input id="state" type="text" class="form-control" name="state" value="{{$user->state}}" placeholder="Enter State..">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="city">Select Areas of Interests:</label>
                                    <ul>
                                        <?php
                                        $intersts = [];
                                        if (!empty($user->interests)) {
                                            $intersts = unserialize($user->interests);
                                        }
                                        ?>
                                        <li style="display:inline-block;"> <input type="checkbox" class="interst-checkbox" name="intersts[]" value="science" {{in_array("science",$intersts) ? "checked":""}}>Science   </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="technology" {{in_array("technology",$intersts) ? "checked":""}}>Technology</li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="engineering" {{in_array("engineering",$intersts) ? "checked":""}}>Engineering</li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="math" {{in_array("math",$intersts) ? "checked":""}}>Math </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="medicine" {{in_array("medicine",$intersts) ? "checked":""}}>Medicine </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="social_science" {{in_array("social_science",$intersts) ? "checked":""}}>Social Science </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="education" {{in_array("education",$intersts) ? "checked":""}}>Education </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="sports" {{in_array("sports",$intersts) ? "checked":""}}>Sports </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="finance" {{in_array("finance",$intersts) ? "checked":""}}>Finance </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="manufacturing" {{in_array("manufacturing",$intersts) ? "checked":""}}>Manufacturing </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="recreation" {{in_array("recreation",$intersts) ? "checked":""}}>Recreation </li>
                                        <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="entrepreneurship" {{in_array("entrepreneurship",$intersts) ? "checked":""}}>Entrepreneurship </li>
                                    </ul>
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