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
                        <h4 class="panel-title">Category List </h4>        
                         <!-- <a href="{{route('admin.category.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add Category</a> -->
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Descriptioh </th>
                                        
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Name</th>
                                        <th>Image</th>
                                        <th>Descriptioh </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($categoryDetails))
                                    @foreach ($categoryDetails as $details) 
                                    <tr>
                                        <td>{{ $details->category_name }}</td>
                                        <td><img src="{{ asset('/category/'.$details->category_image)}}" alt="" title="" width="350px;" height="100px;" /></td>
                                        <td>{{$details->category_desc }}</td>
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