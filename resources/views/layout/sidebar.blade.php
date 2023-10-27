        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">

                    @includeWhen(Auth::user()->isAdmin(), 'layout.partials.admin-nav')
                    @includeWhen(Auth::user()->isOwner(), 'layout.partials.owner-nav')
                    @includeWhen(Auth::user()->isPekerja(), 'layout.partials.pekerja-nav')
                    
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->