        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('dashboard') }}" class="app-brand-link m-auto">
                    <span class="app-brand-logo demo">
                        <div class="d-flex flex-column align-items-center">
                            <img src="https://www.medify.id/assets-2021/image/logo-text.png" alt="Donor Darah Logo" style="height: 40px; width: auto;">
                        </div>
                    </span>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1 mt-3 border-top">
                <!-- Dashboard -->
                <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-home"></i>
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>
                <!-- Users -->
                <li class="menu-item {{ Route::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-user"></i>
                        <div data-i18n="Users">Pengguna</div>
                    </a>
                </li>
                <!-- Master Item -->
                <li class="menu-item {{ Route::is('master*') ? 'active' : '' }}">
                    <a href="{{ route('master-items.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-package"></i>
                        <div data-i18n="Users">Master Item</div>
                    </a>
                </li>

                <!-- Category -->
                <li class="menu-item {{ Route::is('categories*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-category-alt"></i>
                        <div data-i18n="Users">Categories</div>
                    </a>
                </li>

                <!-- Supplier -->
                <li class="menu-item {{ Route::is('suppliers*') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-user-rectangle"></i>
                        <div data-i18n="Users">Suppliers</div>
                    </a>
                </li>

            </ul>
        </aside>
        <!-- / Menu -->
