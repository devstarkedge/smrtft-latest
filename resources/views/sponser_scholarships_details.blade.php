@extends('layouts.app')
@section('content')
<section class="banner inner-banner recent-scholars-banner">
    <div class="container">
        <div class="content-banner">
            <h1>{{$username}} Scholarships Details</h1>
        </div></div>
</section>

<section class="recent-scholars list-recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner">
                 @if(session()->has('message.level'))
                    <div class="alert alert-{{ session('message.level') }}"> 
                        {!! session('message.content') !!}
                    </div>
                    @endif
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif 
               
                <table>
                    <tr class="hide-on-mobile">
                        <!-- <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Sponsor</th>
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        <th><img src="{{asset('images/action-icon.png')}}"> Action</th>

                    </tr>
                    @if(isset($scholarships) && count($scholarships))
                    @foreach($scholarships as $scholarship)
                    <tr>
                        <!-- <td> <h5 class="hide-on-desktop head-table"><img src="images/amount-icon.png"> Amount</h5><p class="amount">{{$scholarship->scholarship_amount}} NGN </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/sponsor-icon.png"> Award</h5>
                            <p>{{!empty($scholarship->awards)?$scholarship->awards:""}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/name-icon.png"> Name</h5> 
                            <p><a href="{{route('user.scholarship.details',$scholarship->id)}}" class="cta-banner ">{{$scholarship->scholarship_name}} </a></p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/sponsor-icon.png"> Sponsor</h5>
                            <p>{{!empty($scholarship->user->first_name)?$scholarship->user->first_name:""}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="images/deadline-icon.png"> Deadline</h5>
                            <p>{{date("dS F, Y", strtotime($scholarship->scholarship_expiry_date))}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/action-icon.png')}}"> Action</h5>
                            <p><a href="{{route('user.scholarship.details',$scholarship->id)}}" class="cta-banner user_more_detail">Apply </a></p>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="5" style="text-align: center;">No Record Found</td></tr>

                    @endif
                </table>
                
            </div>

        </div>
    </div>

</section>
<section class="slant-last"></section>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>

@endsection