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
                        <h4 class="panel-title">Banner Management</h4>
                        <a href="{{route('admin.settings.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add New</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Questions List</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Banner Heading</th>
                                        <th>Banner Description</th>
                                        <th>Banner Heading Items</th>
                                        <th>Banner Image</th>
                                        <th>Banner Search Text</th>
                                        <th>Banner Video Text</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                         <th>Sr No.</th>
                                        <th>Banner Heading</th>
                                        <th>Banner Description</th>
                                        <th>Banner Heading Items</th>
                                        <th>Banner Image</th>
                                        <th>Banner Search Text</th>
                                        <th>Banner Video Text</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($settings))
                                    @foreach ($settings as $key => $setting) 
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $setting->banner_heading }}</td>
                                        <td>{{$setting->banner_description }}</td>
                                        <td>{{$setting->banner_heading_items }}</td>
                                        <td><img src="{{asset('images').'/'.$setting->banner_image}}" style="height: 50px;"></td>
                                        <td>{{$setting->banner_search_text }}</td>
                                        <td>{{$setting->banner_video_text }}</td>
                                        <td><a href="{{route('admin.settings.edit',$setting->id)}}" class="btn btn-rounded btn-warning"><i class="fa fa-pencil">&nbsp;Edit</i></a>&nbsp;</td>
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