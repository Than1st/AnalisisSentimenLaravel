<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <!-- <img src="{{ asset('image/excel.png') }}" width="50px"> -->
        <div class="sidebar-brand-icon">
            <i class="fas fa-search"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Analisis Sentimen</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->

    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Beranda -->
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span></a>
    </li>
    <li class="nav-item {{ request()->is('import') ? 'active' : '' }}">
        <a class="nav-link" href="/import">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Import Data Excel</span></a>
    </li>
    <li class="nav-item {{ request()->is('preprocessing') ? 'active' : '' }}">
        <a class="nav-link" href="/preprocessing">
            <i class="fas fa-fw fa-cog"></i>
            <span>Preprocessing</span></a>
    </li>
    <li class="nav-item {{ request()->is('labelling') ? 'active' : '' }}">
        <a class="nav-link" href="/labelling">
            <i class="fas fa-fw fa-tag"></i>
            <span>Labelling</span></a>
    </li>
    <li class="nav-item {{ request()->is('split') ? 'active' : '' }}">
        <a class="nav-link" href="/split">
            <i class="fas fa-fw fa-cut"></i>
            <span>Split Data</span></a>
    </li>
    <li class="nav-item {{ request()->is('modelling') ? 'active' : '' }}">
        <a class="nav-link" href="/modelling">
            <i class="fas fa-fw fa-dumbbell"></i>
            <span>Modelling</span></a>
    </li>
    <li class="nav-item {{ request()->is('pengujian') ? 'active' : '' }}">
        <a class="nav-link" href="/pengujian">
            <i class="fas fa-fw fa-vials"></i>
            <span>Pengujian</span></a>
    </li>

    <li class="nav-item {{ request()->is('positif') | request()->is('negatif') | request()->is('slang') | request()->is('stop') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-th-large"></i>
            <span>Kamus Kata</span>
        </a>
        <div id="collapseTwo" class="collapse {{ request()->is('positif') | request()->is('negatif') | request()->is('slang') | request()->is('stop') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('positif') ? 'active' : '' }}" href="/trainset">Kata Positif</a>
                <a class="collapse-item {{ request()->is('negatif') ? 'active' : '' }}" href="/kereta">Kata Negatif</a>
                <a class="collapse-item {{ request()->is('slang') ? 'active' : '' }}" href="/lokasi">Slang Word</a>
                <a class="collapse-item {{ request()->is('stop') ? 'active' : '' }}" href="/titik">Stop Word</a>
            </div>
        </div>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>