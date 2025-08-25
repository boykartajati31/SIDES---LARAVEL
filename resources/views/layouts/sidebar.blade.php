            @php
                $menus = [
                    1 => [
                        (object)[
                            'title' => 'Dashboard',
                            'path' => 'dashboard',
                            'icon' => 'fas fa-fw fa-tachometer-alt',
                        ],
                        (object)[
                            'title' => 'Penduduk',
                            'path' => 'resident',
                            'icon' => 'fas fa-fw fa-user',
                        ],
                        (object)[
                            'title' => 'Daftar Akun',
                            'path' => 'account-list',
                            'icon' => 'fas fa-fw fa-users',
                        ],
                        (object)[
                            'title' => 'Permintaan Akun',
                            'path' => 'account-requests',
                            'icon' => 'fas fa-fw fa-users-cog',
                        ],

                    ],

                    2 => [
                        (object)[
                            'title' => 'dashboard',
                            'path' => 'dashboard',
                            'icon' => 'fas fa-fw fa-tachometer-alt',
                        ],

                        (object)[
                            'title' => 'pengaduan',
                            'path' => 'complaint',
                            'icon' => 'fas fa-fw fa-scroll',
                        ],
                    ],
                ];
            @endphp

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    {{-- <i class="fas fa-laugh-wink"></i> --}}
                </div>
                <div class="sidebar-brand-text mx-3">SIDESA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            {{-- <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li> --}}

            <!-- Nav Item - Pages Collapse Menu -->
            @auth

            @foreach ($menus[auth()->user()->role_id] as $menu)
                <li class="nav-item {{ request()->is($menu->path . '*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url($menu->path) }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span>{{ $menu->title }}</span>
                    </a>
                </li>
            @endforeach

            @endauth

            {{-- <li class="nav-item {{ request()->is('resident*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo ">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <hr class="sidebar-divider my-0">
                        <a class="collapse-item" href="/resident">Data Penduduk</a>
                    </div>
                </div>
            </li> --}}

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
