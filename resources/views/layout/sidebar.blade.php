        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    
                    <li class="nav-label"><b>Dashboard</b></li>
                    <li>
                        <a href="/dashboard" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    
                    @includeWhen(Auth::user()->isAdmin(), 'layout.partials.admin-nav')
                    @includeWhen(Auth::user()->isOwner(), 'layout.partials.owner-nav')
                    @includeWhen(Auth::user()->isPekerja() && Auth::user()->isCheckedInToday(), 'layout.partials.pekerja-nav')
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->