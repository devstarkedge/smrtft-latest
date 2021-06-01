@extends('layouts.user')
@section('content')
<section class="banner inner-banner recent-scholars-banner">
    <div class="container">
        <div class="content-banner">
            <h1>All Scholarships</h1>
        </div></div>
</section>

<section class="recent-scholars list-recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner">
                <form class="list-sort-scholars">
                    <fieldset >
                        <label >Filter by:</label>
                        <select name="" id="">
                            <option value="">-Please Select-</option>
                            <option value="">Option one</option>
                            <option value="">Option two</option>
                        </select>
                    </fieldset>
                </form>
                <table>
                    <tr class="hide-on-mobile">
                        <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th>
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Sponsor</th>
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        <th><img src="{{asset('images/action-icon.png')}}"> Action</th>
                    </tr>
                    @if(isset($scholarships) && count($scholarships)) 
                    @foreach($scholarships as $scholarship)
                    <tr>
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$scholarship->scholarship_amount ?? null}} NGN </p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p>{{$scholarship->scholarship_name ?? null}}</p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Sponsor</h5>
                            <p>{{$scholarship->user->first_name ?? null}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($scholarship->scholarship_expiry_date))}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/action-icon.png')}}"> Action</h5>
                            <p>@if($isExpired && Auth::user()->is('User'))
                                <a href="{{route('membership.plans')}}" class="cta-banner apply-membership">Buy Membership.</a>
                                @else
                                <button class="cta-banner apply-scholarship" data-id="{{$scholarship->id}}" data-status="{{$scholarship->is_active}}">Apply</button>
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </table>
                {{ $scholarships->links('pagination')}}
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script>
    $(document).ready(function () {
        $('.apply-scholarship').on('click', function () {
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure you want to apply?",
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
                                url: "{{route('apply.scholarship')}}",
                                type: "POST",
                                data: {"scholarship_id": +id, "_token": "{{ csrf_token() }}"},
                                success: function (result) {
                                    swal("Applied!", "Your have successfully applied.", "success");
                                    window.location.href = "{{ route('user.dashboard')}}";
                                }
                            });
                        } else {
                            swal("Cancelled", "Your have canceled application.:)", "error");
                        }
                    });

//            var userselection = confirm("Are you sure you want to apply for this scholarship?");
//            if (userselection == true) {
//                var id = $(this).attr('data-id');
//                $.ajax({
//                    url: "{{route('apply.scholarship')}}",
//                    type: "POST",
//                    data: {"scholarship_id": +id, "_token": "{{ csrf_token() }}"},
//                    success: function (result) {
//                        alert('applied');
//                        window.location.href = "{{ route('user.dashboard')}}";
//                    }
//                });
//            } else {
//
//            }
        });
    });
</script>
@endsection

