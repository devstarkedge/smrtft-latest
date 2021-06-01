<nav class="dash-nav">
    <div class="container">
        <div class="nav-in">
            <div class="nav-header">
                <div class="nav-title">
                    <a href="#"><img src="{{ asset('/images/banner.png') }}"></a>
                </div>
            </div>
            <div class="nav-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-show" >
                <div class="nav-links right-links">
                    <ul>
                        @if( Auth::user()->is('Partner'))
                        <li><a href="{{route('scholarships.index')}}" class="btn pri-btn">Scholarships</a></li>
                        @else
                        <li style="padding: 20px;"><a href="{{route('user.dashboard')}}" class="btn pri-btn">Home</a></li>
                        <li style="padding: 20px;"><a href="{{route('membership.plans')}}" class="btn pri-btn">Membership</a></li>
                        <li style="padding: 20px;"><a href="{{route('user.applications')}}" class="btn pri-btn">My Applications</a></li>
                        @endif
                        <li><button class="btn pri-btn tri-btn" type="submit"><i class="fas fa-user"></i>user</button>
                            <ul class="drop-hover">
                                <li><a href="{{route('user.profile')}}"><p>My Account</p> <i class="fas fa-user"></i></a></li>
                                <li><a href="{{route('change.password.show')}}"><p>Change Password</p> <i class="fas fa-user"></i></a></li>
                                <li><a href="{{route('user.logout')}}"><p>Logout</p> <i class="fas fa-sign-out-alt"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>