<!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="/dashboard">
                    <span class="brand-title" style="color: white; font-size: 16px;">
                        <img src="{{ asset('assets/images/favicon.png')}}" height="40px" alt="">
                        Kota Lama Coffee
                    </span>
                </a>
            </div>
        </div>

        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                @if (auth()->user()->foto)
                                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" height="40" width="40" alt="">
                                @else
                                    <div class="default-profile-image" style="width: 40px; height: 40px; background-color: #fff; text-align: center; vertical-align: middle; line-height: 40px; color: #000; border-radius: 50%;">A</div>
                                @endif
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <!-- <li><a href="#"><i class="icon-key"></i> <span>Logout</span></a></li> -->
                                        <li>
                                            <form action="/logout" method="post">
                                                @csrf
                                                <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;"><i class="icon-key"></i> Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->