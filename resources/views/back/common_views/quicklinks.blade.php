<ul class="stats">
    <li class="refres">
        <a href="#" data-bs-toggle="tooltip" title="Create/Update Sitemap" id="sitemap">
            <i class="fa-solid fa-sitemap" aria-hidden="true"></i>
        </a>
    </li>
    <li class="refres">
        <a href="{{ admin_url() . 'clear-cache' }}" data-bs-toggle="tooltip" title="Clear Cache">
            <i class="fa-solid fa-refresh" aria-hidden="true"></i>
        </a>
    </li>
    <li class="setting">
        <a href="{{ admin_url() . 'settings' }}" data-bs-toggle="tooltip" title="Site Setting">
            <i class="fa-solid fa-cog fa-spin" aria-hidden="true"></i>
        </a>
    </li>
    <li class="link">
        <a href="{{ base_url() }}" target="_blank" data-bs-toggle="tooltip" title="Visit Website">
            <i class="fa-solid fa-globe" aria-hidden="true"></i>
        </a>
    </li>
    <li class="logout">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
            data-bs-toggle="tooltip" title="Logout">
            <i class="fa-solid fa-sign-out" aria-hidden="true"></i>
        </a>        
    </li>
</ul>
