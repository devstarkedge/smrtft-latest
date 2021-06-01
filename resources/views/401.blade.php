@extends('layouts.app')
@section('content')
<section class="banner inner-banner privacy-banner">
    <div class="container">
        <div class="content-banner">
            <h1>401 Unauthorized</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box has-space no-flex">
                <div class="policy-terms">
                    <p>You are not authorized to access this route.</p>
                    <a style="text-decoration:none" href="{{route('home')}}"class="cta-banner">Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
@endsection