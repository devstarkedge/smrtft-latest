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
                    <li><a data="new-scholar" href="javascript:void(0)" class="taber-nav active">Edit/Review Scholarship</a></li>
                </ul>
                <div class="new-scholar common" style="display:table;">
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <form id="edit_scholarship_form" method="POST" action="{{route('scholarships.update',$scholarship->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <fieldset class="one-half">
                            <input type="text" placeholder="Scholarship Name*" name="scholarship_name" required="required" value="{{$scholarship->scholarship_name ?? null}}">
                        </fieldset>

                       <!--  <fieldset class="one-half">
                            <input type="number"  placeholder="Scholarship Amount*" name="scholarship_amount" required="required" value="{{$scholarship->scholarship_amount ?? null}}">
                            </fieldset> -->
                        <fieldset class="one-half">
                            <input type="text"  placeholder=" Award*" name="awards" required="required" value="{{$scholarship->awards ?? null}}">
                        </fieldset>

                        <fieldset class="one-half">
                            <input type ="text" id = "datepicker-13" name="scholarship_expiry_date" placeholder="Scholarship Deadline*" required="required" value="{{date("m/d/Y", strtotime($scholarship->scholarship_expiry_date))}}">
                        </fieldset>
                       <!--  <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_one" id="file_one_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                    @if(!empty($scholarship->scholarship_doc_one))
                       <a href="{{url('myscholarship_docs/'.$scholarship->scholarship_doc_one)}}" target="_blank">Downloaf File</a>  
                    @endif
                    
                        </fieldset>
                        <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_two" id="file_two_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                     @if(!empty($scholarship->scholarship_doc_two))
                       <a href="{{url('myscholarship_docs/'.$scholarship->scholarship_doc_two)}}" target="_blank">Downloaf File</a>  
                    @endif
                        </fieldset>
                        <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_three" id="file_three_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                     @if(!empty(trim($scholarship->scholarship_doc_three)))
                    
                       <a href="{{url('myscholarship_docs/'.$scholarship->scholarship_doc_three)}}" target="_blank">Downloaf File</a>  
                    @endif
                        </fieldset> -->
                         <fieldset class="one-half">
                           
                        </fieldset> 
                        <fieldset>
                        
                                        <label for="answer">Application Instructions</label>
                                        <textarea name="instruction">{{$scholarship->instruction ?? null}}</textarea>
                                    
                        </fieldset>
                        <fieldset class="one-half edit_scholarship_submissions">
                            <button class="btn-gradient submit-btn">Update</button> <a class="btn-gradient submit-btn" href="{{ redirect()->getUrlGenerator()->previous() }}">Cancel</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function () {
    $("#datepicker-13").datepicker();
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

