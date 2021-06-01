@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
        @if(isset($plan))
        <h3>Edit Plan</h3>
        @else
        <h3>Add New Plan</h3>
        @endif
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                        @if(isset($plan->id))
                        <form method="POST" action="{{route('plans.update',$plan->id)}}">
                            {{method_field('PUT')}}
                            @else
                            <form method="POST" action="{{route('plans.store')}}">
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
                                        <label for="name">Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="plan_name" value="{{$plan->plan_name ?? null}}" required placeholder="Enter Name..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="amount">Amount</label>
                                         <input id="plan_period" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ $plan->amount ?? null }}" required placeholder="Enter amount...">
                                    </div>
                                     <div class="form-group col-sm-12">
                                        <label for="amount">Discount Amount</label>
                                         <input id="plan_period" type="text" class="form-control{{ $errors->has('discount_amount') ? ' is-invalid' : '' }}" name="discount_amount" value="{{ $plan->discount_amount ?? null }}" required placeholder="Enter discount amount...">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="plan_period">Plan Period</label>
                                         <select class="form-control" name="plan_period" required="required">
                                             <option value="">--- Select Type ---</option>
                                             <option value="annually">Annually</option>
                                             <option value="monthly">Monthly</option>
                                         </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        @if (isset($plan->id))
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