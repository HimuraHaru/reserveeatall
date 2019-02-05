 <!--== 4. Navigation ==-->
    <nav id="template-navbar" class="navbar navbar-default custom-navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#Food-fair-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://reserve-eatall.com/">
                    <img id="logo" src="../assets/images/Logo_main.png" class="logo img-responsive">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="Food-fair-toggle">
                <ul class="nav navbar-nav navbar-right">

                

                    <li><a href="{{route('restaurant')}}">restaurants</a></li>
                    @if(Auth::check() == false)
                        <li><a href="{{route('login')}}">login</a></li>
                    @else

                        <li>
                            <a href="{{route('dashboard')}}">
                                @if(Auth::user()->role == "USER")
                                    profile
                                @else
                                    dashboard
                                @endif
                            </a>
                        </li>
                        <li><a href="http://127.0.0.1:8000/#about">About</a></li>
                        <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endif
                    {{--<li><a href="#about">about</a></li>--}}
                    {{--<li><a href="#pricing">menu</a></li>--}}
                    {{--<li><a href="#great-place-to-enjoy">beer</a></li>--}}
                    {{--<li><a href="#breakfast">bread</a></li>--}}
                    {{--<li><a href="#featured-dish">featured</a></li>--}}
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.row -->
    </nav>

   