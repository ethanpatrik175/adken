<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="{{ route('user.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('general.profile') }}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxl-product-hunt"></i>
                        <span key="t-tasks">Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.products.index')}}" key="t-task-list">All Products</a></li>
                        <li><a href="{{route('admin.products.create')}}" key="t-kanban-board">Add New</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Orders</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
