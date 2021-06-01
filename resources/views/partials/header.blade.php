<header>
    <div class="container">
        <div class="row">
            <div class="logo"><a href="https://brainupca.com/myscholarship/public/"><img alt="Logo" src="{{asset('images/logo.png')}}"></a></div>
            <nav class="mobile-menu">
                @if (Auth::check())
                @if( Auth::user()->is('Partner'))
                <ul>
                    <li><a href="{{route('partner.dashboard')}}">Home</a></li>
                    <li><a href="{{route('user.logout')}}" class="cta-banner">Logout</a></li>
                </ul>
                @elseif(Auth::user()->is('User') || Auth::user()->is('Administrator'))
                 <ul>
                    <li><a href="{{route('user.dashboard')}}">Home</a></li>
                    <li><a href="{{route('membership.plans')}}">Membership</a></li>
                    <li><a href="{{route('user.applications')}}">My Applications</a></li>
                    <li><a href="{{route('user.logout')}}" class="cta-banner">Logout</a></li>
                </ul>
                @else
                @endif
                @else
                <ul>
                    <li><a href="{{route('login')}}">Login</a></li>
                    <li><a href="{{route('register.index')}}">Register</a></li>
                </ul>
                @endif

            </nav>
            <div id="mobile-toggle">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
    </div>
</header>