@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div id="main-wrapper">
        <div class="row">  
            @if(session()->has('message.level'))
            <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
            </div>
            @endif
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Plan Management</h4>
                        @if(!empty($is_admin))
                         <a href="{{route('plans.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Plan</a>
                         @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Plans List</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Discount Amount</th>
                                        <th>Time Period</th>
                                         @if(!empty($is_admin))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                         <th>Discount Amount</th>
                                        <th>Time Period</th>
                                        @if(!empty($is_admin))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($plans))
                                    @foreach ($plans as $plan) 
                                    <tr>
                                        <td>{{ $plan->plan_name }}</td>
                                        <td>{{$plan->amount }}</td>
                                         <td>{{$plan->discount_amount}}</td>
                                        <td>{{$plan->plan_period }}</td>
                                         @if(!empty($is_admin))
                                        <td><a href="#" class="btn btn-rounded btn-warning"><i class="fa fa-pencil">&nbsp;Edit</i></a>&nbsp;</td>
                                        @endif
                                    </tr>
                                    @endforeach        
                                    @endif
                                </tbody>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
</div>
@endsection