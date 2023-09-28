<ul class="dashNav">
    <li>
        <div class="title">Quick Link</div>
    </li>
    <li><a href="{{ base_url() . 'member/dashboard' }}"><i class="fa fa-user"></i> My profile</a></li>
    <li><a href="{{ route('dashboard.edit', Auth::user()->id) }}" class="edit" title="Edit Profile"><i
                class="fa fa-edit"></i>Update</a></li>
    <!--<li><a href="{{ base_url() . 'member/manage_loads' }}" class="edit" title="Manage data"><i class="fa fa-tasks"></i>Manage data</a></li>-->
    <li>
        <form method="post" action="{{ route('logout') }}" id="lgForm" style="display: inline;">
            @csrf
            <a href="#" name="submit" onclick="document.getElementById('lgForm').submit();">
                <i class="fa fa-power-off"></i>Logout
            </a>
        </form>
        {{-- <a href="{{ base_url() .'member/logout'}}" class="edit" title="Logout"> --}}
        {{-- <i class="fa fa-power-off"></i>Logout --}}
        {{-- </a> --}}
    </li>
</ul>
