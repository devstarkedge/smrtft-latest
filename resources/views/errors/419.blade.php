@extends('errors::error-main')


@section('content')

<section class="page-419">

<div class="inner-error-page">
	
	<img src="{{ asset('images/img-error-419.png')}}">
	
	<h2>Page Expired</h2>
	<p>Sorry, your session has expired. Please refresh and try again.</p>
	<a class="btn-white" href="/dashboard">Back to dashboard</a>
</div>
	
</section>
@endsection