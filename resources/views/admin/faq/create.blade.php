@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div class="page-title">
        @if(isset($question))
        <h3>Edit Question</h3>
        @else
        <h3>Add Question</h3>
        @endif
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">
                        @if(isset($question->id))
                        <form method="POST" action="{{route('faqs.update',$question->id)}}">
                            {{method_field('PUT')}}
                            @else
                            <form method="POST" action="{{route('faqs.store')}}">
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
                                        <label for="question">Question</label>

                                        @php

                                        $question1=null;

                                        if(!empty(old('question')))
                                        {
                                            $question1=old('question');
                                        }

                                        if(!empty($question->question))
                                        {
                                            $question1=$question->question;
                                        }


                                        @endphp

                                        <input id="question" type="text" class="form-control{{ $errors->has('question') ? ' is-invalid' : '' }}" name="question" value="{{$question1}}" required placeholder="Enter Question.." required>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="answer">Answer</label>
                                        <textarea name="answer">{{$question->answer ?? null}}</textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        @if (isset($question->id))
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
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('answer');
CKEDITOR.config.autoParagraph = false;
CKEDITOR.config.fillEmptyBlocks = false;
    </script>
    @endsection