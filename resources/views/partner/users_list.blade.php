@extends('layouts.partner')
@section('content')
<section class="banner inner-banner donor-dashboar">
    <div class="container">
        <div class="content-banner">
            <h1>Welcome!</h1>
            <h4>Here are all your available actions.</h4>
        </div></div>
</section>
<section class="recent-scholars list-recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner">
                <ul class="tabber-main">
                    <!-- <li><a data="active-scholar" href="javascript:void(0)" class="taber-nav active">Active Users</a></li> -->
                    <li><a data="scholar-history" href="javascript:void(0)" class="taber-nav active">User Applications</a></li>
                </ul>
                <table class="active-scholar common" style="display:none">
                    <tr class="hide-on-mobile">
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    @if(isset($users) && count($users)) 
                    @foreach($users as $user)
                    <tr>
                        <td> <h5 class="hide-on-desktop head-table">Amount</h5><p class="amount">{{$user->first_name ?? null}} </p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table">Name</h5> 
                            <p>{{$user->last_name ?? null}}</p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table">Sponsor</h5>
                            <p>{{$user->email ?? null}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table">Deadline</h5>
                            <p>{{$user->mobile_number ?? null}}</p>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </table>
                <table class="scholar-history common" style="display:table">
                    <tr class="hide-on-mobile">
                        <th> Name</th>
                        <th>Email</th>
                        <th>School Name</th>
                        <th>Scholarship Name</th>
                        <th>Scholarship Amount </th>
                        <th hidden=""> Status </th>
                        <th >Action</th>
                    </tr>
                    @if(isset($applications) && count($applications)) 
                    @foreach($applications as $detail)
                    <tr>
                        <td> <h5 class="hide-on-desktop head-table"> Name</h5><p><a href="{{route('partner.application.details',$detail->userScholarshipId)}}" class="cta-banner">{{$detail->first_name ?? null}}</a></p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table">Email</h5> 
                            <p>{{$detail->user->email ?? null}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table">School Name</h5> 
                            <p>{{$detail->user->school ?? null}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table">Scholarship Name</h5>
                            <p>{{$detail->scholarship->scholarship_name ?? null}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table">Scholarship Amount </h5>
                            <p>{{$detail->scholarship->scholarship_amount}}</p>
                        </td>
                        <td hidden=""> <h5 class="hide-on-desktop head-table">Status</h5>
                            <p>{{($detail->is_status == 1) ? 'Approved' :(($detail->is_status == 2)?'Declined':'Applied')}}</p>
                        </td>
                        <td >
                            <h5 class="hide-on-desktop head-table">Action</h5>
                            <p>@if($detail->is_status == 0)<a href="#" data-user-id="{{$detail->user_id}}" data-status="1" data-scholarship-id="{{$detail->scholarship_id}}" class="cta-banner approve_scholarship">Approve</a>&nbsp;<a href="#" data-user-id="{{$detail->user_id}}" data-status="2" data-scholarship-id="{{$detail->scholarship_id}}" class="cta-banner approve_scholarship">Decline</a>@endif @if($detail->is_status == 1) Approved @endif  @if($detail->is_status == 2)Declined @endif</p>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function () {
    $('.approve_scholarship').on('click', function () {
        var userselection = confirm("Are you sure you want to Approve/Decline?");
        if (userselection == true) {
            var user_id = $(this).attr('data-user-id');
            var scholarship_id = $(this).attr('data-scholarship-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "{{route('partner.scholarship.approve')}}",
                type: "POST",
                data: {"user_id":+user_id,"scholarship_id": +scholarship_id,"status": +status,"_token": "{{ csrf_token() }}"},
                success: function (result) {
                    window.location.href = "{{ route('partner.users_list')}}";
                }
            });
        } else {

        }
    });
});
</script>
@endsection

