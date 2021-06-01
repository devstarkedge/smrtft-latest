@extends('layouts.user')
@section('content')
<section class="banner inner-banner contact-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Personal Details.</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">

        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box has-space no-flex contact-main">
                <div class="contact-form">
                     @if(session()->has('message.level'))
                    <div class="alert alert-{{ session('message.level') }}"> 
                        {!! session('message.content') !!}
                    </div>
                    @endif
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <h3>Personal Details.</h3>
                    <form id="contact_us_form" method="POST" action="{{route('user.profile.update')}}">
                        @csrf
                        <fieldset class="one-half">
                            <label class="user-profile">First Name</label>
                            <input type="text" placeholder="First Name*" name="first_name" value="{{$user->first_name}}">
                        </fieldset>

                        <fieldset class="one-half">
                            <label class="user-profile">Last Name</label>
                            <input type="text" placeholder="Last Name*" id="last_name" name="last_name" value="{{$user->last_name}}" >
                        </fieldset>

                        <fieldset class="one-half">
                            <label class="user-profile">Email</label>
                            <input type="email" placeholder="Email*" name="email"  value="{{$user->email}}" required="required" disabled>
                        </fieldset>

                        <fieldset class="one-half">
                            <label class="user-profile">Mobile Number</label>
                            <input type="tel" placeholder="Mobile Number*" value="{{$user->mobile_number}}" name="mobile_number" required="required">
                        </fieldset>
                        <fieldset class="one-half">
                            <label class="user-profile">School</label>
                            <input type="text" placeholder="School Name" name="school" value="{{$user->school}}">
                        </fieldset>
                        <fieldset class="one-half">
                            <label class="user-profile">City</label>
                            <input type="text" placeholder="City" name="city" value="{{$user->city}}">
                        </fieldset>
                        <fieldset class="one-half">
                            <label class="user-profile">State</label>
                            <input type="text" placeholder="State" name="state" value="{{$user->state}}">
                        </fieldset>
                        <fieldset class="one-half">
                            <label class="user-profile">Plan Expired Date</label>
                            <input type="text" placeholder="State" name="state" value="{{date("dS F,Y", strtotime($user->expiry_date))}}" readonly>

                        </fieldset>
                        <fieldset class="one-half">
                            <label class="user-profile">Select Areas of Interests:</label>
                            <ul>
                                <?php
                                $intersts = [];
                                if (!empty($user->interests)) {
                                    $intersts = unserialize($user->interests);
                                }
                                ?>
                                <li style="display:inline-block;"> <input type="checkbox" class="interst-checkbox" name="intersts[]" value="science" {{in_array("science",$intersts) ? "checked":""}}>Science   </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="technology" {{in_array("technology",$intersts) ? "checked":""}}>Technology</li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="engineering" {{in_array("engineering",$intersts) ? "checked":""}}>Engineering</li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="math" {{in_array("math",$intersts) ? "checked":""}}>Math </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="medicine" {{in_array("medicine",$intersts) ? "checked":""}}>Medicine </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="social_science" {{in_array("social_science",$intersts) ? "checked":""}}>Social Science </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="education" {{in_array("education",$intersts) ? "checked":""}}>Education </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="sports" {{in_array("sports",$intersts) ? "checked":""}}>Sports </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="finance" {{in_array("finance",$intersts) ? "checked":""}}>Finance </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="manufacturing" {{in_array("manufacturing",$intersts) ? "checked":""}}>Manufacturing </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="recreation" {{in_array("recreation",$intersts) ? "checked":""}}>Recreation </li>
                                <li style="display:inline-block;"><input type="checkbox" class="interst-checkbox" name="intersts[]" value="entrepreneurship" {{in_array("entrepreneurship",$intersts) ? "checked":""}}>Entrepreneurship </li>
                            </ul>
                        </fieldset>

                        <fieldset class="one-half align-right">
                            <button class="btn-gradient submit-btn">Submit</button>
                        </fieldset>
                    </form>
                </div>



            </div>
        </div>
    </div>
</section>
<section class="slant-white for-last"></section>
@endsection

