@extends('layouts.user')
@section('content')
<section class="banner inner-banner recent-scholars-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Most Recent Scholarships</h1>
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
                <form class="list-sort-scholars" action="{{route('user.dashboard')}}" method="GET" id="form_order_id">
                    <fieldset >
                        <label >Filter by:</label>
                            <?php $slct_order=!empty($_GET['slct_order'])?$_GET['slct_order']:"" ?>
                        <select name="slct_order" id="slct_order_id">
                            <option value="" >-Please Select-</option>
                           <!--  <option value="scholarship_amount" {{($slct_order=="scholarship_amount")?"selected":""}}>Amount</option> -->
                            <option value="scholarship_expiry_date" {{($slct_order=="scholarship_expiry_date")?"selected":""}}>Deadline</option>
                        </select>
                    
                    </fieldset>
                </form>
                <table>
                    <tr class="hide-on-mobile">
                       <!--  <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Sponsor</th>
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        <th><img src="{{asset('images/action-icon.png')}}"> Action</th>
                        <!-- <th><img src="{{asset('images/deadline-icon.png')}}"> Details</th> -->
                    </tr>
                    @if(isset($scholarships) && count($scholarships)) 
                    @foreach($scholarships as $scholarship)
                    <tr>
                        <!-- <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$scholarship->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Award</h5>
                            <p>{{$scholarship->awards ?? null}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p><a href="{{route('user.scholarship.details',$scholarship->id)}}" class="cta-banner">{{$scholarship->scholarship_name ?? null}}</a></p></td>
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
                                <!-- <button class="cta-banner apply-scholarship" data-id="{{$scholarship->id}}" data-status="{{$scholarship->is_active}}">Apply</button> -->
                               <a href="{{route('user.scholarship.details',$scholarship->id)}}" class="cta-banner">Apply</a>
                                @endif
                            </p>
                        </td>
                        <!-- <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p><a href="{{route('user.scholarship.details',$scholarship->id)}}" class="cta-banner user_more_detail">More Details</a></p>
                        </td> -->
                    </tr>
                    @endforeach
                    @endif
                </table>
               {{ $scholarships->appends(['slct_order'=>$slct_order])->render('pagination')}}
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

        $("#slct_order_id").change(function()
        {
            var order=$("#slct_order_id").val();

            $("#form_order_id").submit();



        }

            )
    });
</script>
@endsection

