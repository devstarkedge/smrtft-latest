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
                        <h4 class="panel-title">Frequently Asked Question Management</h4>
                        <a href="{{route('faqs.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add New</a>
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
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($questions))
                                    @foreach ($questions as $key => $question) 
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $question->question }}</td>
                                        <td>{{$question->answer }}</td>
                                        <td><a href="{{route('faqs.edit',$question->id)}}" class="btn btn-rounded btn-warning"><i class="fa fa-pencil">&nbsp;Edit</i></a>&nbsp;<form method="POST" action="{{route('faqs.destroy',$question->id)}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-rounded btn-danger confirmdel"><i class="fa fa-close">&nbsp;Delete</i></button>
                                                </div>
                                            </form>
                                        </td>
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