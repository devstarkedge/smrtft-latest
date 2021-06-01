@extends('layouts.user')
@section('content')
<section class="banner inner-banner recent-scholars-banner">
    <div class="container">
        <div class="content-banner">
            <h1> Scholarship Details</h1>
        </div></div>
</section>

<section class="recent-scholars list-recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner award-details-apply">
                 @if(session()->has('message.level'))
                    <div class="alert alert-{{ session('message.level') }}"> 
                        {!! session('message.content') !!}
                    </div>
                    @endif
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif 
                 
                        <fieldset class="one-third">
                            <h4 class="user-profile">Award</h4>
                             <p class="user-profile">{{$scholarshipDetails->awards}}</p>
                           
                        </fieldset>
                         <fieldset class="one-third">
                             <h4 class="user-profile">Name</h4>
                             <p class="user-profile">{{$scholarshipDetails->scholarship_name}}</p>
                           
                        </fieldset>
                       
                        <!-- <fieldset class="one-half">
                             <h4 class="user-profile">Scholarship Amount</h4>
                            <p class="user-profile">{{$scholarshipDetails->scholarship_amount}}</p>
                        </fieldset> -->

                         <fieldset class="one-third">
                             <h4 class="user-profile">Deadline</h4>
                            <p class="user-profile">{{date('dS F,Y', strtotime($scholarshipDetails->scholarship_expiry_date))}}</p>
                        </fieldset>
                      
                        <fieldset >
                           <h4 class="user-profile">Application Instruction</h4>
                        @if(!empty($scholarshipDetails->instruction))                     
                             <p class="faq-content" >{!! strip_tags($scholarshipDetails->instruction) !!}</p>
                        @else
                        <p class="faq-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,

                        </p> 
                        @endif 
                         </fieldset> 
                      <!--    @if(!empty($scholarshipDetails->scholarship_doc_one))
                         <fieldset class="one-half">
                           
                           <a href="{{url('myscholarship_docs/'.$scholarshipDetails->scholarship_doc_one)}}" target="_blank">Downloaf File</a>
                        </fieldset>
                        @endif
                         @if(!empty($scholarshipDetails->scholarship_doc_two))
                         <fieldset class="one-half">
                           
                           <a href="{{url('myscholarship_docs/'.$scholarshipDetails->scholarship_doc_two)}}" target="_blank">Downloaf File</a>
                        </fieldset>
                        @endif
                         @if(!empty($scholarshipDetails->scholarship_doc_three))
                         <fieldset class="one-half">
                           
                           <a href="{{url('myscholarship_docs/'.$scholarshipDetails->scholarship_doc_three)}}" target="_blank">Downloaf File</a>
                        </fieldset>
                        @endif -->

                      <!--   <fieldset>
                            
                            @if($isExpired && Auth::user()->is('User'))
                                <a href="{{route('membership.plans')}}" class="cta-banner apply-membership">Buy Membership.</a>
                                @else
                                 <a href="{{route('user.scholarship.question.details',$scholarshipDetails->id)}}" class="cta-banner">Start Application</a>
                                @endif
                                 <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="cta-banner">Cancel</a> 
                        </fieldset> -->

                         <form method="POST" action="{{ route('user.apply.scholarship') }}" class="margin-none" id="form-third-step" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="scholarship_id" id="candidate_position" value="{{$scholarshipDetails->id}}">
           
          
               
                <fieldset >
                        
                <h5>Enter your essay response(s) in the box below. . </h5>
                <textarea name="professional_life" style="min-height: 190px;"></textarea>
                                    
                </fieldset>
                <div class="new-appened-area">
                <fieldset class="one-half">
                   <h5> If required, attach all supporting documents below. </h5>
                       <label class="file-upload-btn">
                        <input type="file" class="form-control-file" name="user_upload_doc[]"  aria-describedby="fileHelp" multiple>  Choose Files </label>
                        <p class="file-name">No files Selected</p>
                  
                        </fieldset>
<!--
                         <fieldset class="one-half">
                   <h5> If required, attach all supporting documents below. </h5>
                       <label class="file-upload-btn">
                        <input type="file" class="form-control-file" name="user_upload_doc[]"  aria-describedby="fileHelp" multiple> Choose Files</label>
                        <p class="file-name">No files Selected</p>
                    
                        </fieldset></div>
-->
                        <div class="append-area"></div>
                        
                        <div class="add-more-files"><span class="add-selector">Click here to add more files</span></div>
                        
                        <fieldset class="one-half"><small id="fileHelp" class="form-text text-muted">Please upload a valid doc., pdf, png, jpg, or jpeg file. The size should not exceed 2MB.</small></fieldset>
                        
							

                 <fieldset>
                            <button class="btn-gradient submit-btn">Submit Application</button>
                             <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="cta-banner">Cancel</a>
                        </fieldset>

                
        </form>

            </div>
        </div>
            
    </div>
</section>
<style>
	.add-more-files span.add-selector {
    font-size: 14px;
    color: #3b379f;
    cursor: pointer;
    text-decoration: underline;
    margin-bottom: 20px;
    display: inline-block;
		transition: all .3s ease-in-out;
}
	.add-more-files span.add-selector:hover {
		color:#b98ff6;
	}
	
	</style>

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

		$(document).on("change", "label.file-upload-btn input[type='file']" , function(){
			var fileName = $(this).val().replace(/C:\\fakepath\\/i, '');
			$(this).parent().next(".file-name").text(fileName);
			
		});
		
			$(document).on("click", ".add-selector" , function(){
				
			$(".append-area").append('<div class="row-append"><span class="delete-row"><i class="fas fa-times"></i></span><fieldset class="one-half"><label class="file-upload-btn"><input type="file" class="form-control-file" name="user_upload_doc[]"  aria-describedby="fileHelp" multiple>  Choose Files </label><p class="file-name">No files Selected</p></fieldset></div>');
				 
		});
		$(document).on("click", ".delete-row" , function(){
			$(this).parent().remove();
		});
        
    });
</script>
@endsection

