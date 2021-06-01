@extends('errors::error-main')


@section('content')
<section class="page-404">

<div class="inner-error-page">
	
	<img src="{{ asset('images/404-img.png')}}">
	
	<h1>ERROR</h1>
	<p>Page not found</p>
	<a class="btn-white" href="/dashboard">Back to dashboard</a>
</div>
	
</section>

@endsection