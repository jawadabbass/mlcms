<ul class="stats">
    <li class="refres">
        <button class="btn btn-success">
            <i class="fas fa-user" aria-hidden="true"></i>&nbsp;Welcome {{ auth()->check() ? auth()->user()->name : '' }}
        </button>
    </li>
    <li class="refres">
        <button class="btn btn-danger">
            <i class="fa-solid fa-calendar-days"></i>&nbsp;{{ date('M, d Y') }}
        </button>
    </li>
    <li class="refres">
        <a href="#" data-bs-toggle="tooltip" title="Create/Update Sitemap" id="sitemap">
            <i class="fas fa-sitemap" aria-hidden="true"></i>
        </a>
    </li>
    <li class="refres">
        <a href="{{ admin_url() . 'clear-cache' }}" data-bs-toggle="tooltip" title="Clear Cache">
            <i class="fas fa-sync" aria-hidden="true"></i>
        </a>
    </li>
    <li class="setting">
        <a href="{{ admin_url() . 'settings' }}" data-bs-toggle="tooltip" title="Site Setting">
            <i class="fas fa-cog fa-spin" aria-hidden="true"></i>
        </a>
    </li>
    <li class="link">
        <a href="{{ base_url() }}" target="_blank" data-bs-toggle="tooltip" title="Visit Website">
            <i class="fas fa-globe" aria-hidden="true"></i>
        </a>
    </li>
    <li class="logout">
        <a href="{{ route('admin.logout') }}"
            onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
            data-bs-toggle="tooltip" title="Logout">
            <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
        </a>
    </li>
</ul>
