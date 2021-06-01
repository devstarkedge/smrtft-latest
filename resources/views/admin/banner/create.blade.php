@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
        @if(isset($setting))
        <h3>Edit Setting</h3>
        @else
        <h3>Add Setting</h3>
        @endif
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                        @if(isset($setting->id))
                        <form method="POST" action="{{route('admin.settings.update',$setting->id)}}" enctype="multipart/form-data">
                            {{method_field('PUT')}}
                            @else
                            <form method="POST" action="{{route('admin.settings.store')}}" enctype="multipart/form-data">
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
                                        <label for="banner_heading">Banner Heading</label>
                                        <input id="banner_heading" type="text" class="form-control{{ $errors->has('banner_heading') ? ' is-invalid' : '' }}" name="banner_heading" value="{{$setting->banner_heading ?? null}}" required placeholder="Enter Banner Heading..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="banner_description">Banner Description</label>
                                        <input id="banner_description" type="text" class="form-control{{ $errors->has('banner_description') ? ' is-invalid' : '' }}" name="banner_description" value="{{$setting->banner_description ?? null}}" required placeholder="Enter Banner Description..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="banner_heading_items">Banner Heading Items</label>
                                        <input id="banner_heading_items" type="text" class="form-control{{ $errors->has('banner_heading_items') ? ' is-invalid' : '' }}" name="banner_heading_items" value="{{$setting->banner_heading_items ?? null}}" required placeholder="Enter Banner Heading Items..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="banner_image">Banner Image</label>
                                        <input id="banner_image" type="file" class="form-control{{ $errors->has('banner_image') ? ' is-invalid' : '' }}" name="banner_image" placeholder="Enter Banner Image.." @if (isset($setting->banner_image)) {{ $setting->banner_image != null ? "" : 'required' }} @endif>
                                               @if (isset($setting->banner_image)) 
                                               <img src="{{asset('images').'/'.$setting->banner_image}}" style="height: 50px;">
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="banner_search_text">Banner Search Text</label>
                                        <input id="banner_search_text" type="text" class="form-control{{ $errors->has('banner_search_text') ? ' is-invalid' : '' }}" name="banner_search_text" value="{{$setting->banner_search_text ?? null}}" required placeholder="Enter Banner Search Text..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="banner_video_text">Banner video Text</label>
                                        <input id="banner_video_text" type="text" class="form-control{{ $errors->has('banner_video_text') ? ' is-invalid' : '' }}" name="banner_video_text" value="{{$setting->banner_video_text ?? null}}" required placeholder="Enter Banner Video Text..">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        @if (isset($setting->id))
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