@extends('layouts.app')
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
                
                 <form class="list-sort-scholars" action="{{route('home.all_scholarships')}}" method="GET" id="form_order_id">
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
                        <!-- <th><img src="images/amount-icon.png"> Amount</th> -->
                        <th><img src="images/sponsor-icon.png"> Award</th>
                        <th><img src="images/name-icon.png"> Name</th>
                        <th><img src="images/sponsor-icon.png"> Sponsor</th>
                        <th><img src="images/deadline-icon.png"> Deadline</th>
                        <!--<th><img src="images/available.png"> Available</th>-->

                    </tr>
                    @if(isset($scholarships) && count($scholarships))
                    @foreach($scholarships as $scholarship)
                    <tr>
                       <!--  <td> <h5 class="hide-on-desktop head-table"><img src="images/amount-icon.png"> Amount</h5><p class="amount">{{$scholarship->scholarship_amount}} NGN </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/sponsor-icon.png"> Award</h5>
                            <p>{{!empty($scholarship->awards)?$scholarship->awards:""}}</p>
                        </td>
                       
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p><a href="{{route('user.scholarship.details',$scholarship->id)}}" class="cta-banner">{{$scholarship->scholarship_name ?? null}}</a></p></td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/sponsor-icon.png"> Sponsor</h5>
                            <p>{{!empty($scholarship->user->first_name)?$scholarship->user->first_name:""}}</p>
                        </td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="images/deadline-icon.png"> Deadline</h5>
                            <p>{{date("dS F, Y", strtotime($scholarship->scholarship_expiry_date))}}</p>
                        </td>
<!--                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="images/available.png"> Available</h5>
                            <p>5</p>
                        </td>-->
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
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function () {
 $("#slct_order_id").change(function()
        {
            var order=$("#slct_order_id").val();

            $("#form_order_id").submit();



        }

            )
    });
</script>
@endsection

