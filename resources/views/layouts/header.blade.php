<nav>
    <div class="container">
        <div class="nav-in">
            <div class="nav-header">
                <div class="nav-title">
                    <a href={{route('home')}}><img src="{{ asset('/images/logo.png') }}"></a>
                </div>
            </div>
            <div class="nav-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-show">
                <div class="nav-links left-links">
                    <ul>
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">WHAT WE DO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">INSIGHT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>	
                </div>
                <div class="nav-links right-links">
                    <ul>
                        <li><a href="{{route('login')}}" class="btn pri-btn">Login</a></li>
                        <li><a href="{{route('register.index')}}" class="btn pri-btn sec-btn">Register </a></li>
                       
                    </ul>	
                </div>
            </div>
        </div>
    </div>
</nav>
<div id="content">
    @yield('content')
</div>