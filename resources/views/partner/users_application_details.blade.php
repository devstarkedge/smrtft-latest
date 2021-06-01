@extends('layouts.partner')
@section('content')
<section class="banner inner-banner donor-dashboar">
    <div class="container">
        <div class="content-banner">
            <h4>User Application Details.</h4>
        </div></div>
</section>
<section class="recent-scholars list-recent-scholars">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner">
                 
                        <fieldset class="one-third">
                            <label class="user-profile">Award</label>
                             <label class="user-profile">{{$applications->awards}}</label>
                           
                        </fieldset>
                         <fieldset class="one-third">
                            <label class="user-profile">Scholarship Name</label>
                             <label class="user-profile">{{$applications->scholarship_name}}</label>
                           
                        </fieldset>

                         <fieldset class="one-third">
                            <label class="user-profile">User Name</label>
                             <label class="user-profile">{{$applications->first_name}}</label>
                           
                        </fieldset>
                       
                        <fieldset class="one-third">
                            <label class="user-profile">Scholarship Amount</label>
                            <label class="user-profile">{{$applications->scholarship_amount}}</label>
                        </fieldset>

                         <fieldset class="one-third">
                            <label class="user-profile">Deadline</label>
                            <label class="user-profile">{{date('dS F,Y', strtotime($applications->scholarship_expiry_date))}}</label>
                        </fieldset>
                       <!--  <fieldset >
                            <label class="user-profile">Are You a U.S Citizen or Permanent resident of Unitied States</label>
                            <label class="user-profile">{{($applications->citizen_permanent=="1")?"Citizen":"permannet"}}</label>
                        </fieldset>
                        <fieldset >
                            <label class="user-profile">Have you experienced a cumlative gap of at least five (5) years in your education?</label>
                            <label class="user-profile">{{!empty($applications->experience_five_year)?"Yes":"No"}}</label>
                        </fieldset> -->
                        <fieldset >
                            
                            @if($applications->professional_life)   
                            <label class="user-profile">Essay</label>                                         
                             <p class="faq-content" >{!! strip_tags($applications->professional_life) !!}</p>

                             @endif
                         </fieldset> 
                         @if(count($uploadDocumentDetails)>0)
                         @foreach($uploadDocumentDetails as $upload)
                         <fieldset >
                            <label class="user-profile">User Upload Document</label> 
                           @php $url=""; 
                           $text="No Document Attach";
                           if(!empty($upload->upload_doc))
                           {
                           		$url=url('myscholarship_docs/user_submit_doc/'.$upload->upload_doc);
                           		$text="Download File";
                           }

                           @endphp                                          
                            <p><a href="{{$url}}" target="_blank">{{$text}}</a></p> 
                         </fieldset> 
                         @endforeach
                         @endif
                          <fieldset>                  
                                 <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="cta-banner">Back</a> 
                        </fieldset>
                         

            </div>
        </div>
    </div>
</section>

@endsection