@extends('layouts.user')
@section('content')
<section class="banner inner-banner pricing-banner">
    <div class="container">
        <div class="content-banner">
            <h1>Upgrade Membership</h1>
        </div></div>
</section>

<section class="recent-scholars sign-in">
    <div class="container">
        <div class="recent-inner-outer">
            <div class="recent-inner sign-in-box has-space no-flex">
                <ul class="tabber-main pricing-tab">
                    <li><a class="taber-nav active" data="yearly" href="javascript:void(0)">Membership Plan</a></li>
                    <!-- <li><a class="taber-nav" data="monthly" href="javascript:void(0)">Monthly</a></li> -->
                </ul>
                <div class="plans-outer common yearly user_membership_plan">
                      
                         @if(isset($monthlyPlans) && count($monthlyPlans))
                        @foreach($monthlyPlans as $mplans)
                        <div class=" plans"> 
                        <div class="plan-box">
                            <p class="plan-name">{{$mplans->plan_name}}</p>
                            <div class="plan-price">
                                <h4><sup>$</sup> {{$mplans->amount}}<sub>USD<br></sub></h4>
                            </div>
                           
                            @if(!empty($mplans->transaction))
                            @if($mplans->transaction->plan_id==$mplans->id && $mplans->transaction->user_id ==Auth::user()->id) 
                            <p class="btn-plan">Successfully subscribed this plan</p>
                            @else
                            <form> 
                                <button class="btn-plan" type="button" onclick="payWithPaystack('<?php echo $mplans->amount *100 ?>', '<?php echo $mplans->id ?>')"> Subscribe </button>
                            </form>
                            @endif
                            @else
                            <form> 
                                <button class="btn-plan" type="button" onclick="payWithPaystack('<?php echo $mplans->amount *100 ?>', '<?php echo $mplans->id ?>')">Subscribe </button>
                            </form>
                            @endif
                        </div> 
                    </div>
                        @endforeach
                        @endif
                
<!-- 
                <div class="common monthly plans-outer" style="display: none;">  
                    <div class=" plans"> 
                        @if(isset($monthlyPlans) && count($monthlyPlans))
                        @foreach($monthlyPlans as $mplans)
                        <div class="plan-box">
                            <p class="plan-name">{{$mplans->plan_name}}</p>
                            <div class="plan-price">
                                <h4><sup>₦</sup> {{$mplans->amount}}<sub>NGN<br></sub></h4>
                            </div>
                            <p class="billed-annualy">{{$mplans->amount}}per month</p>
                            <ul class="plan-features">
                                <li>Billed Monthly </li>
                                <li>Access <span class="divider"></span></li>
                                <li><b>Unlimited 12 months access to</b></li>
                                <li><b>all local and international scholarships and</b></li>
                                <li><b>funding opportunities</b></li>
                            </ul>
                            @if(!empty($mplans->transaction))
                            @if($mplans->transaction->plan_id==$mplans->id && $mplans->transaction->user_id ==Auth::user()->id) 
                            <p class="btn-plan">Successfully subscribed this plan</p>
                            @else
                            <form> 
                                <button class="btn-plan" type="button" onclick="payWithPaystack('<?php //echo $mplans->amount *100 ?>', '<?php //echo $mplans->id ?>')"> Buy </button>
                            </form>
                            @endif
                            @else
                            <form> 
                                <button class="btn-plan" type="button" onclick="payWithPaystack('<?php //echo $mplans->amount *100 ?>', '<?php //echo $mplans->id ?>')">Buy </button>
                            </form>
                            @endif
                        </div> 
                        @endforeach
                        @endif
                    </div>
                </div> -->
                <div class="promocode" hidden>
                    <form action=""><input type="text" placeholder="Enter Copon Code"><button class="btn-plan">Apply Coupon</button></form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slant-last"></section>
<script src="{{asset('js/script.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
                                    $(document).ready(function () {

                                    });
                                    function payWithPaystack(amount, planid) {
                                        var user_email = "<?php echo Auth::user()->email ?>";
                                        var handler = PaystackPop.setup({
                                            key: 'pk_test_06dc9f12766400fe5c618732e287eb515596b8ab',
                                            email: user_email,
                                            amount: amount,
                                            currency: "USD",
                                            ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                            metadata: {
                                                custom_fields: [
                                                    {
                                                        display_name: "Mobile Number",
                                                        variable_name: "mobile_number",
                                                        value: "+2349098639544"
                                                    }
                                                ]
                                            },
                                            callback: function (response) {
                                                console.log('response--' + JSON.stringify(response));
                                                if (response.status == "success") {
                                                    $.ajax({
                                                        url: "{{route('payment.callback')}}",
                                                        type: "POST",
                                                        data: {"transaction_id": +response.reference, "plan_id": +planid, "_token": "{{ csrf_token() }}"},
                                                        success: function (result) {
                                                            window.location.href = "{{ route('membership.success')}}";
                                                        }
                                                    });
                                                } else {
                                                    window.location.href = "{{ route('membership.failure')}}";
                                                }
                                            },
                                            onClose: function () {
                                            }
                                        });
                                        handler.openIframe();
                                    }
</script>
@endsection

