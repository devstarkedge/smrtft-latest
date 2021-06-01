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
                @if(session()->has('message.level'))
            <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
            </div>
            @endif
                <ul class="tabber-main">
                    <li><a data="new-scholar" href="javascript:void(0)" class="taber-nav {{$active['new_scholar']=='active' ? 'active' :''}}">Post New Scholarship</a></li>
                    <li><a data="active-scholar" href="javascript:void(0)" class="taber-nav {{$active['active_scholar']=='active' ? 'active' :''}}">Active </a></li>
                    <li><a data="scholar-history" href="javascript:void(0)" class="taber-nav {{$active['scholar_history']=='active' ? 'active' :''}}">History</a></li>
                     <li><a data="pending-scholar" href="javascript:void(0)" class="taber-nav {{$active['pending_scholar']=='active' ? 'active' :''}}"> Pending Approval</a></li>
                     <li><a data="decline-scholar" href="javascript:void(0)" class="taber-nav {{$active['decline_scholar']=='active' ? 'active' :''}}">Not Approved</a></li>
                </ul>

                <div class="new-scholar common" style="{{$active['new_scholar']=='active' ? 'display:table' :'display: none;'}}">
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <form id="post_scholarship_form" method="POST" action="{{route('scholarships.store')}}" enctype="multipart/form-data">
                        @csrf
                        <fieldset class="one-half">
                            <input type="text" placeholder="Scholarship Name*" name="scholarship_name" required="required">
                        </fieldset>

                        <!-- <fieldset class="one-half">
                            <input type="number"  placeholder="Scholarship Amount*" name="scholarship_amount" required="required">
                        </fieldset> -->
                        <fieldset class="one-half">
                            <input type="text" placeholder="Award*" name="awards" required="required">
                        </fieldset>

                        <fieldset class="one-half">
                            <input type ="text" id = "datepicker-13" name="scholarship_expiry_date" placeholder="Scholarship Deadline*" required="required">
                        </fieldset>
                       <!--  <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_one" id="file_one_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                        </fieldset>
                        <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_two" id="file_two_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                        </fieldset>
                        <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_three" id="file_three_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                        </fieldset> -->
                        <fieldset class="one-half">
                           
                        </fieldset> 
                        <fieldset>
                        
                                        <label for="answer">Application Instructions</label>
                                        <textarea name="instruction"></textarea>
                                    
                        </fieldset>
                        <fieldset class="one-half">
                            <button class="btn-gradient submit-btn">Submit for admin review</button>
                        </fieldset>
                    </form>
                </div>
                <table class="active-scholar common dynamic-data" style="{{$active['active_scholar']=='active' ? 'display:table' :'display: none;'}}">
                    <tr class="hide-on-mobile">
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                        <!-- <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>             
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        

                    </tr>
                    @if(isset($activeScholarships) && count($activeScholarships)) 
                    @php $i=1; @endphp
                    @foreach($activeScholarships as $activeData)
                    <tr class="parent-group-{{$i}} parent-row">
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Award</h5>
                            <p>{{$activeData->awards ?? null}}</p>
                        </td>
                       <!--  <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$activeData->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                                <p>{{$activeData->scholarship_name ?? null}}</p></td>
                        
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($activeData->scholarship_expiry_date))}}</p>
                            
                            @if(count($activeData->user_list)) <span class="toggle-row-data"><i class="fas fa-angle-down"></i></span> @endif
                        </td>
                       
                    </tr>
                    @if(count($activeData->user_list))
                    @foreach($activeData->user_list as $userDetails)
                        <tr class="child-group-{{$i}} child-row" style="display: none;">
                         <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Award</h5>
                            <p>{{$activeData->awards ?? null}}</p>
                        </td>   
                        <!-- <td > <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount1">{{$activeData->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                                <p><a href="{{route('partner.application.details',$userDetails->userScholarshipId)}}" class="cta-banner">{{$userDetails->first_name ?? null}}</a></p></td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($activeData->scholarship_expiry_date))}}</p>
                        </td>
                        
                    </tr>
                    
                    @endforeach
                    @endif
                    @php $i++; @endphp
                    @endforeach
                    @else
                    <tr><td colspan="4" style="text-align: center;"> No Record Found</td></tr>
                    @endif
                </table>
                <table class="scholar-history common" style="{{$active['scholar_history']=='active' ? 'display:table' :'display: none;'}}">
                     <tr class="hide-on-mobile">
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                        <!-- <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>              
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        <th hidden><img src="{{asset('images/action-icon.png')}}"> Action</th>

                    </tr>
                    @if(isset($scholarshipHistory) && count($scholarshipHistory)) 
                    @foreach($scholarshipHistory as $historyData)
                    <tr>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Award</h5>
                            <p>{{$historyData->awards ?? null}}</p>
                        </td>
                        <!-- <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$historyData->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p>{{$historyData->scholarship_name ?? null}}</p></td>
                       <!--  <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Sponsor</h5>
                            <p>{{$historyData->user->first_name ?? null}}</p>
                        </td> -->
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($historyData->scholarship_expiry_date))}}</p>
                        </td>
                        <td hidden>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/action-icon.png')}}"> Action</h5>
                            <p><a href="{{route('scholarships.edit',$historyData->id)}}" class="cta-banner cancel-scholarship">Edit/Review</a></p>
                        </td>
                    </tr>
                    @endforeach
                     @else
                    <tr><td colspan="5" style="text-align: center;"> No Record Found</td></tr>
                    @endif
                </table>
                 <table class="pending-scholar common" style="{{$active['pending_scholar']=='active' ? 'display:table' :'display: none;'}}">
                    <tr class="hide-on-mobile">
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                       <!--  <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        <th><img src="{{asset('images/action-icon.png')}}"> Action</th>

                    </tr>
                    @if(isset($pendingScholarships) && count($pendingScholarships)) 
                    @foreach($pendingScholarships as $historyData)
                    <tr>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Award</h5>
                            <p>{{$historyData->awards ?? null}}</p>
                        </td>
                       <!--  <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$historyData->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p>{{$historyData->scholarship_name ?? null}}</p></td>
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($historyData->scholarship_expiry_date))}}</p>
                        </td>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/action-icon.png')}}"> Action</h5>
                            <p><a href="{{route('scholarships.edit',$historyData->id)}}" class="cta-banner cancel-scholarship">Edit/Review</a></p>
                        </td>
                    </tr>
                    @endforeach
                     @else
                    <tr><td colspan="5" style="text-align: center;"> No Record Found</td></tr>
                    @endif
                </table>
                    <table class="decline-scholar common" style="{{$active['decline_scholar']=='active' ? 'display:table' :'display: none;'}}">
                    <tr class="hide-on-mobile">
                        <th><img src="{{asset('images/sponsor-icon.png')}}"> Award</th>
                        <!-- <th><img src="{{asset('images/amount-icon.png')}}"> Amount</th> -->
                        <th><img src="{{asset('images/name-icon.png')}}"> Name</th>                   
                        <th><img src="{{asset('images/deadline-icon.png')}}"> Deadline</th>
                        

                    </tr>
                    @if(isset($declineScholarships) && count($declineScholarships)) 
                    @foreach($declineScholarships as $declineData)
                    <tr>
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/sponsor-icon.png')}}"> Award</h5>
                            <p>{{$declineData->awards ?? null}}</p>
                        </td>
                       <!--  <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/amount-icon.png')}}"> Amount</h5><p class="amount">{{$declineData->scholarship_amount ?? null}} USD </p></td> -->
                        <td>
                            <h5 class="hide-on-desktop head-table"><img src="{{asset('images/name-icon.png')}}"> Name</h5> 
                            <p>{{$declineData->scholarship_name ?? null}}</p></td>
                        
                        <td> <h5 class="hide-on-desktop head-table"><img src="{{asset('images/deadline-icon.png')}}"> Deadline</h5>
                            <p>{{date("dS F,Y", strtotime($declineData->scholarship_expiry_date))}}</p>
                        </td>
                        
                    </tr>
                    @endforeach
                     @else
                    <tr><td colspan="4" style="text-align: center;"> No Record Found</td></tr>
                    @endif
                </table>
                <!--<a class="btn-gradient" href="#">See More</a>-->
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function () {
    $("#datepicker-13").datepicker({
         minDate: 0,
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha256-pTxD+DSzIwmwhOqTFN+DB+nHjO4iAsbgfyFq5K5bcE0=" crossorigin="anonymous"></script>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
 <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('instruction');
CKEDITOR.config.autoParagraph = false;
CKEDITOR.config.fillEmptyBlocks = false;
    </script>
@endsection

