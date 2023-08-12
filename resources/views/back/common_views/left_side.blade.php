<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ admin_url() . '' }}" class="brand-link">
        <img src="{!! getImage('admin_logo_favicon', config('admin_logo_favicon.admin_header_logo'), 'main') !!}" alt="{{ FindInsettingArr('business_name') }}"
            class="brand-image elevation-3 main_sidebar_opacity">
        {{-- <span class="brand-text font-weight-heavy">{{ FindInsettingArr('business_name') }}</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ admin_url() . '' }}" class="d-block">{{ __('Welcome') }}
                    {{ __('Admin') }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @php
                    $currentURL = url()->current();
                    $currentURL = str_replace(admin_url(), '', $currentURL);
                    $arrLinks = [];
                    $beforeLinks = \App\Helpers\DashboardLinks::$beforeLeftModuleLinks;
                    $arrLinksModule = \App\Helpers\DashboardLinks::get_cms_modules('left');
                    $afterLinks = \App\Helpers\DashboardLinks::$afterLeftModuleLinks;
                    $arrLinks = array_merge($beforeLinks, $arrLinksModule, $afterLinks);
                @endphp
                <li class="nav-item">
                    <a class="nav-link  {{ $currentURL == rtrim(admin_url(), '/') ? 'active' : 'inactive' }}"
                        href="{{ admin_url() }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @foreach ($arrLinks as $key => $val)
                    @php
                        $keys = array_keys($val);
                    @endphp
                    @if (is_array($val[$keys[0]]))
                        @if (isset($val['permission']) && isAllowed($val['permission']))
                            <li class="nav-item">
                                <a class="nav-link inactive" href="#">
                                    <i class="nav-icon {{ $val['icon'][0] }}"></i>
                                    <p>{{ $key }}<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach ($val as $key1 => $val1)
                                        @if (isset($val1['permission']) && isAllowed($val1['permission']))
                                            @if ($key1 != 'icon')
                                                <li class="nav-item">
                                                    <a target="{{ $val1[3] == 'newtab' ? '_blank' : '' }}"
                                                        class="nav-link  {{ $currentURL == $val1[2] ? 'active' : '' }}"
                                                        href="{{ admin_url() . $val1[2] }}">
                                                        <i class="nav-icon {{ $val1[1] }}"></i>
                                                        <p>{{ $val1[0] }}</p>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>

                            </li>
                        @endif
                    @else
                        @if (isset($val['permission']) && isAllowed($val['permission']))
                            <li class="nav-item">
                                <a class="nav-link {{ $currentURL == $val[2] ? 'active' : 'inactive' }}"
                                    target="{{ $val[3] == 'newtab' ? '_blank' : '' }}"
                                    href="{{ admin_url() . $val[2] }}">
                                    <i class="nav-icon {{ $val[1] }}"></i>
                                    <p>{{ $val[0] }}</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
                @if (isAllowed('View Roles') || isAllowed('View Permissions') || isAllowed('View Permission Groups'))
                    <li class="nav-item">
                        <a class="nav-link inactive" href="#">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Roles &amp; Permissions<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (isAllowed('View Roles'))
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link {{ $currentURL == route('roles.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            @endif
                            @if (isAllowed('View Permissions'))
                                <li class="nav-item">
                                    <a href="{{ route('permissions.index') }}"
                                        class="nav-link {{ $currentURL == route('permissions.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-door-open"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                            @endif
                            @if (isAllowed('View Permission Groups'))
                                <li class="nav-item">
                                    <a href="{{ route('permissionGroup.index') }}"
                                        class="nav-link {{ $currentURL == route('permissionGroup.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-list"></i>
                                        <p>Permission Groups</p>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route('permissionGroup.index') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Permission Groups</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
            <button class="btn btn-danger mt-1 w-100" onclick="$('#logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i> Log Out
            </button>
            <br />
            <br />
            <br />
            <br />
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
