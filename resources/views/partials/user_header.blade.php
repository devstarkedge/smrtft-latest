<header>
    <div class="container">
        <div class="row">
            <div class="logo"> @if(Auth::check())

                    @if(Auth::user()->roles()->first()->name == 'User')
                        <a href="{{route('user.dashboard')}}">
                    @endif
                    @if(Auth::user()->roles()->first()->name == 'Partner')
                        <a href="{{route('partner.dashboard')}}">
                    @endif
                    @if(Auth::user()->roles()->first()->name == 'Administrator')
                        <a href="{{route('admin.dashboard')}}">
                    @endif

                @else
                <a href="https://brainupca.com/myscholarship/public/">
                @endif<img alt="Logo" src="{{asset('images/logo.png')}}"></a></div>
            <nav class="mobile-menu">
                @if (Auth::check())
                <ul>
                    <li><a href="{{route('user.dashboard')}}">Home</a></li>
                    @if(Auth::user()->is('User'))
                    <li><a href="{{route('membership.plans')}}">Membership</a></li>
                    @endif
                    <li><a href="{{route('user.applications')}}">My Applications</a></li>
                    <li><a href="{{route('user.profile')}}">Profile</a></li>
                    @if (Auth::user()->is('Administrator'))
                    <li><a href="{{route('admin.dashboard')}}" class="cta-banner">Admin Panel</a></li>
                    @endif
                    @if (Auth::user()->is('SubAdmin'))
                    <li><a href="{{route('admin.dashboard')}}" class="cta-banner">Sub Admin Panel</a></li>
                    @endif
                    <li><a href="{{route('user.logout')}}" class="cta-banner">Logout</a></li>
                </ul>
                @else
                <ul>
                    <li><a href="{{route('login')}}">Login</a></li>
                    <li><a href="{{route('register.index')}}">Register</a></li>
                    <li><a href="{{route('user.dashboard')}}" class="cta-banner">Submit a scholarship</a></li>
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