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
           
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title"> Trainer Program List </h4>        
                          <a href="{{route('admin.program.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Program</a>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table trainer-program-list list-style" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Trainer Name</th>
                                        <th>Number Of programs</th>
                                        
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Trainer Name</th>
                                        <th>Number Of Program</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($trainerlist))
                                    @foreach ($trainerlist as $details) 
                                    <tr>
                                        <td><a href="{{route('admin.trainer.program.list',$details->user_id)}}">{{ $details->first_name }}</a></td>
                                        <td>{{$details->count_userid }}</td>                                   
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
@endsection