<div class="col-md-3">
    <div class="right-box side-bar">
        <ul>
            <li class="{{ Request::url() == url('/account') ? 'active' : '' }}"><a href="{{route('user.profile')}}">Personal Details</a></li>
          <!--  <li class="{{ Request::url() == url('/account/bank') ? 'active' : '' }}"><a href="{{route('bank_details.index')}}">Update Bank Details</a></li> -->
            <li class="{{ Request::url() == url('/account/security') ? 'active' : '' }}"><a href="{{route('change.password.show')}}">Security</a></li>
        </ul>
    </div>
</div>