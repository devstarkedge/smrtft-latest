
<div class="overlay"></div>


<main class="page-content content-wrap">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="logo-box">
                <a href="#" class="logo-text"><span><img src="{{ asset('/images/logo.png') }}" style="width: 100%;"></span></a>
            </div><!-- Logo Box -->
            <div class="search-button">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
            </div>
            <div class="topmenu-outer">
                <div class="top-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>		
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </li>
                        <li>		
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                         
                        <li class="dropdown">
                            <a href="{{route('admin.profile.show')}}" class="btn btn-success m-l-sm m-r-sm">View Profile</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic">
                                <span class="user-name"><b>{{ Auth::user()->first_name }}</b></span>
                                <img class="img-circle avatar" src="{{ asset('assets/images/avatar1.png') }}" width="40" height="40" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="{{  route('user.logout') }}" class="log-out waves-effect waves-button waves-classic">
                                <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                            </a>
                        </li>

                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div><!-- Navbar -->
    <div class="page-sidebar sidebar">
        <div class="page-sidebar-inner slimscroll">      
            <ul class="menu accordion-menu">
                <li class="{{ request()->is('/admin/dashboard') ? 'active' : '' }}"><a href="{{route('admin.dashboard')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span>
                        <p>Home</p>
                    </a></li>
                <li class="{{ request()->is('/admin/subcategorylist') ? 'active' : '' }}"><a href="{{route('admin.subcategory.list')}}" class="waves-effect waves-button"><span class="menu-icon fa fa-picture-o"></span>
                        <p>Sub Category List</p>
                    </a></li>
                <li class="{{ request()->is('/admin/faqs') ? 'active' : '' }}"><a href="{{route('faqs.index')}}" class="waves-effect waves-button"><span class="menu-icon fa fa-question-circle"></span>
                        <p>WorkOut Type</p>
                    </a></li>
               

            </ul>
        </div>
        <!-- Page Sidebar Inner --> 
    </div>