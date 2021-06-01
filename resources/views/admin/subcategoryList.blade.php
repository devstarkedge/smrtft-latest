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
                        <h4 class="panel-title">SubCategory List </h4>        
                         <a href="{{route('admin.subcategory.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add SubCategory</a>
                        
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
                                    @if(isset($subcategoryDetails))
                                    @foreach ($subcategoryDetails as $details) 
                                    <tr>
                                        <td>{{ $details->subcategory_name }}</td>
                                        <td><img src="{{ asset('/subcategory/'.$details->subcategory_image)}}" alt="" title="" width="100px;" height="100px;" /></td>
                                        <td>{{$details->subcategory_desc }}</td>
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