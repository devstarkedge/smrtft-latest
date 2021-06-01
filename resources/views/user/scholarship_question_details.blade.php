@extends('layouts.user')
@section('content')
<style>
    
.questions input[type="radio"] {
    width: auto;
    vertical-align: middle;
    margin-top: 0;
    box-sizing: border-box;
    min-height: 20px;
}
.questions {
    padding: 21px 0 15px;
}

.questions h5 {
    margin-bottom: 15px;
}

</style>
<section class="banner inner-banner recent-scholars-banner">
    <div class="container">
        <div class="content-banner">
            <h1> Scholarship Questionnaire Details</h1>
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

        <h3>Please answer following questions.</h3>

         <form method="POST" action="{{ route('user.apply.scholarship') }}" class="margin-none" id="form-third-step" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="scholarship_id" id="candidate_position" value="{{$scholarshipDetails->id}}">
           
          
                <fieldset class="one-half">
                    <h5>Are You a U.S Citizen or Permanent resident of Unitied States? </h5>
                <select name="citizen_permanent">
                    <option value="1">Citizen</option>
                    <option value="2">Permanent</option>
                </select>
                </fieldset>
               
                <fieldset class="questions one-half">
                    <h5>Have you experienced a cumlative gap of at least five (5) years in your education? </h5>
                <input type="radio" value="1" name="experience_five_year"> <label>Yes</label>
                <input  type="radio" value="0" name="experience_five_year"> <label>no</label>
                </fieldset>
                <fieldset >
                        
                <h5>To be considered,please attach an essay(250-500 words) describing why you resumed your education after having at least 5 year cumulative ago. Explain the impact this will have on your personal and or professional life. </h5>
                <textarea name="professional_life"></textarea>
                                    
                </fieldset>
                <fieldset class="one-half">
                        <input type="file" class="form-control-file" name="file_one" id="file_one_id" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid doc file. Size of image should not be more than 2MB.</small>
                        </fieldset>
                        <fieldset class="one-half"></fieldset>

                 <fieldset class="one-half">
                            <button class="btn-gradient submit-btn">Apply Scholarship</button>
                        </fieldset>

                
        </form>
       
            
            </div>
    </div>
</section>
<section class="slant-last"></section>
    
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('professional_life');
CKEDITOR.config.autoParagraph = false;
CKEDITOR.config.fillEmptyBlocks = false;
    </script>


@endsection

