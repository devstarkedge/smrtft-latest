@extends('errors::error-main')

@section('content')
<section class="error-page page-401">

<div class="inner-error-page">

<div class="round-shape"></div>

	<h3>Hold Up!</h3>
	<p>Error 401: Unauthorized.</p>
	<div class="images-error">
	<img class="desktop-only" src="{{ asset('images/image-401-error.png') }}">
	<img class="mobile-only" src="{{ asset('images/mobile-401-page.png') }}">
	</div>
	<a class="btn-white" href="/dashboard">Back to dashboard</a>
</div>
	
</section>

@endsection
