<aside class="left-side sidebar-offcanvas {{ session('leftSideBar') == 1 ? 'collapse-left' : '' }}" id="left-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            @php
                $currentURL = url()->current();
                $currentURL = str_replace(admin_url(), '', $currentURL);
                $arrLinks = [];
                $beforeLinks = \App\Helpers\DashboardLinks::$beforeLeftModuleLinks;
                $arrLinksModule = \App\Helpers\DashboardLinks::get_cms_modules();
                $afterLinks = \App\Helpers\DashboardLinks::$afterLeftModuleLinks;
                $arrLinks = array_merge($beforeLinks, $arrLinksModule, $afterLinks);
            @endphp
            <li class="{{ $currentURL == admin_url() ? 'active' : '' }}">
                <a href="{{ admin_url() }}"> <i class="fa-solid fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            @foreach ($arrLinks as $key => $val)
                @php
                    $keys = array_keys($val);
                @endphp
                @if (is_array($val[$keys[0]]))
                    @if (isset($val['user_type']) && in_array(auth()->user()->type, $val['user_type']))
                        <li>
                            <a class="nav-link navclp collapsed" href="#id-{{ $keys[1] }}" data-bs-toggle="collapse">
                                <i class="awesome_style fa-solid {{ $val['icon'][0] }}"></i>
                                <span>{{ $key }}</span>
                            </a>
                            <div class="collapse" id="id-{{ $keys[1] }}">
                                <ul class="nav flex-column sub-menu">
                                    @foreach ($val as $key1 => $val1)
                                        @if (isset($val1['user_type']) && in_array(auth()->user()->type, $val1['user_type']))
                                            @if ($key1 != 'icon')
                                                <li class="nav-item">
                                                    <a target="{{ $val1[3] == 'newtab' ? '_blank' : '' }}"
                                                        class="nav-link" href="{{ admin_url() . $val1[2] }}">
                                                        <i class="fa-solid awesome_style {{ $val1[1] }}"></i>
                                                        {{ $val1[0] }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                @else
                    @if (isset($val['user_type']) && in_array(auth()->user()->type, $val['user_type']))
                        <li class="{{ $currentURL == $val[2] ? 'active' : '' }}">
                            <a target="{{ $val[3] == 'newtab' ? '_blank' : '' }}" href="{{ admin_url() . $val[2] }}">
                                <i class="fa-solid awesome_style {{ $val[1] }}"></i>
                                <span>{{ $val[0] }}</span>
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    </section>
</aside>
