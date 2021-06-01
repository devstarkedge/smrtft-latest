@extends('errors::error-main')


@section('content')

<section class="page-403">

<div class="inner-error-page">
	<h1>403</h1>
	<p>This is a forbidden area.</p>
	<img src="{{ asset('images/img-error-403.png')}}">
	
	
	<a class="btn-white" href="/dashboard">Back to dashboard</a>
</div>
	
</section>

@endsection