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
                        <h4 class="panel-title">Nutrition List </h4>        
                         <a href="{{route('admin.nutrition.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Nutrition</a>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Nutrition Name</th>
                                        
                                        <th>Nutrition Description </th>
                                        <th>Nutrition Image </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </thead>
                                <tfoot>
                                   <tr>
                                        <th>Nutrition Name</th>
                                        
                                        <th>Nutrition Description </th>
                                        <th>Nutrition Image </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($nutritionList))
                                    @foreach ($nutritionList as $details) 
                                    <tr>
                                        <td>{{ $details->nutrition_title }}</td>
                                        <td>{{ strip_tags($details->nutrition_desc) }}</td>
                                        <td><img src="{{ asset('/nutrition/'.$details->nutrition_image)}}" alt="" title="" width="100px;" height="100px;" /></td>
                                         <td>{{ !empty($details->nutrition_status)?"Active":"Deactive" }}</td>
                                       
                                         <td><a  href="{{route('admin.nutrition.edit',$details->id)}}"><i class="fa fa-edit"></i></a><!-- <a href="#"><i class="fa fa-trash"></i></a> --></td>
                                         
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