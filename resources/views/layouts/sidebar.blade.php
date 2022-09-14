<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('assets/img/custom/radix-logo.png') }}" height="40" />

            <span class="app-brand-text menu-text fw-bolder ms-2">Admin</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ str_contains(url()->current(), 'home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        @if (isset(Auth::user()->name))
            <li class="menu-item {{ Request::segment(1) == 'company' ? 'active' : '' }}">
                <a href="{{ route('company.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div data-i18n="Company">Company</div>
                </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'emp' ? 'active' : '' }}">
                <a href="{{ route('emp.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div>Employee</div>
                </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'facades' ? 'active' : '' }}">
                <a href="{{ route('facades') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div>Create Slug</div>
                </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'qr-code-generator' ? 'active' : '' }}">
                <a href="{{ url('qr-code-generator') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div>QR Code</div>
                </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'notification' ? 'active' : '' }}">
                <a href="{{ url('notification') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div>Firebase Notification</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
