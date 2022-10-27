<header class="header">
    <a href="{{ admin_url() . '' }}" class="logo">
        <img src="{!! getImage('admin_logo_favicon', config('admin_logo_favicon.admin_header_logo'), 'main') !!}" alt="{{ config('Constants.SITE_NAME') }}"/>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="searchwrap">

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Keyword" aria-label="Keyword" aria-describedby="searchKeyword" onkeyup="searchResult()" id="searchText">
                <span class="input-group-text" id="searchKeyword"><i class="fa-solid fa-search"></i></span>
                <div class="sgoptions">
                    <ul id="result">
                        <li></li>
                    </ul>
                </div>
              </div>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>
                            {{ Auth::user()->name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            {{-- <div class="pull-left"> --}}
                            {{-- <a href="#" --}}
                            {{-- class="btn btn-default btn-flat">Edit</a> --}}
                            {{-- </div> --}}
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
