<div class="sidebar-menu" style="height: 100vh">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        {{-- Dashboard --}}
        
        <li
            class="sidebar-item">
            <a href="{{ route('users.home') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Users</span>
            </a>
        </li>

        <li
            class="sidebar-item">
            <a href="{{ route('roles.home') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Roles</span>
            </a>
        </li>

</div>
