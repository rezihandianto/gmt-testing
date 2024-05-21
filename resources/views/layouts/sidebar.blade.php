<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
        <!-- Logo -->
        <a class="fw-semibold text-dual" href="/">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider">GMT <span class="fw-normal"> Company</span></span>
        </a>
        <!-- END Logo -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                {{-- <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('/') || request()->is('dashboard/*') ? 'active' : '' }}"
                        href="/">
                        <i class="nav-main-link-icon si si-home"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li> --}}
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('/') || request()->is('employee/*') ? 'active' : '' }}"
                        href="/">
                        <i class="nav-main-link-icon si si-users"></i>
                        <span class="nav-main-link-name">Karyawan</span>
                    </a>
                </li>
                {{-- <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('archive') || request()->is('archive/*') ? 'active' : '' }}"
                        href="/archive">
                        <i class="nav-main-link-icon si si-drawer"></i>
                        <span class="nav-main-link-name">Archive</span>
                    </a>
                </li> --}}
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
