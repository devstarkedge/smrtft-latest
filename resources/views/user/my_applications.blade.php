@extends('layouts.user')
@section('content')
<section class="banner inner-banner recent-scholars-banner">
    <div class="container">
        <div class="content-banner">
            <h1>My Applications</h1>
        </div></div>
</section>

<section class="recent-scholars list-recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner">
                <table>
                    <tr class="hide-on-mobile">
                        <!-- <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Status</th>
                    </tr>
                    @if(isset($userScholarships) && count($userScholarships)) 
                    @foreach($userScholarships as $scholarship)
                    <tr>
                        <!-- <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$scholarship->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                        <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponser-icon.png')}}"> Award</h5> 
                            <p>{{$scholarship->awards ?? null}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p>{{$scholarship->scholarship_name ?? null}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($scholarship->scholarship_expiry_date))}}</p>
                        </td>
                         <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Status</h5>
                            <p>@if($scholarship->is_status == 0) <button class="cta-banner cancel-scholarship" data-id="{{$scholarship->id}}" data-status="{{$scholarship->is_active}}">Cancel</button> @elseif($scholarship->is_status == 1) Approved @else Declined @endif</p>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </table>
                {{ $userScholarships->links('pagination')}}
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script>
$(document).ready(function () {
    $('.apply-scholarship').on('click', function () {
        var userselection = confirm("Are you sure you want to apply for this scholarship?");
        if (userselection == true) {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $.ajax({
                url: "{{route('apply.scholarship')}}",
                type: "POST",
                data: {"scholarship_id": +id, "status": +status, "_token": "{{ csrf_token() }}"},
                success: function (result) {
                    alert('applied');
                    window.location.href = "{{ route('user.dashboard')}}";
                }
            });
        } else {
            alert("Your account is not deleted!");
        }
    });

           $('.cancel-scholarship').on('click', function () {
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure you want to cancel?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "{{route('cancel.scholarship')}}",
                                type: "POST",
                                data: {"user_scholarship_id": +id, "_token": "{{ csrf_token() }}"},
                                success: function (result) {
                                    swal("Applied!", "Your have successfully canceled.", "success");
                                    window.location.href = "{{ route('user.applications')}}";
                                }
                            });
                        } else {
                            swal("Cancelled", "Your have canceled for cancel application.:)", "error");
                        }
                    });

        });
});
</script>
@endsection

