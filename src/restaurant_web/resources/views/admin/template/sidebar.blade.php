<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
      <h5 class="light-logo">EatzAI</h5>
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li class="{{ request()->is('admin/dashboard') ? 'active-page' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="active-page">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span> 
        </a>
      </li>

      <li class="sidebar-menu-group-title">Menu Management</li>
      
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="fluent:food-24-regular" class="menu-icon"></iconify-icon>
          <span>Menu Items</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.menu.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Menu Items
            </a>
          </li>
          <li>
            <a href="{{ route('admin.menu.create') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Add New Item
            </a>
          </li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:list-bold" class="menu-icon"></iconify-icon>
          <span>Categories</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.categories.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Categories
            </a>
          </li>
          <li>
            <a href="{{ route('admin.categories.create') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Add Category
            </a>
          </li>
        </ul>
      </li>

      <li class="sidebar-menu-group-title">Orders & Reservations</li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:cart-4-outline" class="menu-icon"></iconify-icon>
          <span>Orders</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.orders.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Orders
            </a>
          </li>
          <li>
            <a href="{{ route('admin.orders.pending') }}">
              <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Pending Orders
            </a>
          </li>
          <li>
            <a href="{{ route('admin.orders.completed') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Completed Orders
            </a>
          </li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:calendar-mark-outline" class="menu-icon"></iconify-icon>
          <span>Reservations</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.reservations.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Reservations
            </a>
          </li>
          <li>
            <a href="{{ route('admin.reservations.pending') }}">
              <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Pending Reservations
            </a>
          </li>
          <li>
            <a href="{{ route('admin.reservations.create') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Add Reservation
            </a>
          </li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
          <span>Tables</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.tables.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Tables
            </a>
          </li>
          <li>
            <a href="{{ route('admin.tables.create') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Add Table
            </a>
          </li>
        </ul>
      </li>

      <li class="sidebar-menu-group-title">User Management</li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:users-group-rounded-outline" class="menu-icon"></iconify-icon>
          <span>Customers</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.customers.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Customers
            </a>
          </li>
          <li>
            <a href="{{ route('admin.customers.create') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Add Customer
            </a>
          </li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:user-id-outline" class="menu-icon"></iconify-icon>
          <span>Staff</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.staff.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Staff
            </a>
          </li>
          <li>
            <a href="{{ route('admin.staff.create') }}">
              <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Add Staff
            </a>
          </li>
        </ul>
      </li>

      <li class="sidebar-menu-group-title">Settings</li>

      <li>
        <a href="{{ route('admin.settings.general') }}">
          <iconify-icon icon="solar:settings-outline" class="menu-icon"></iconify-icon>
          <span>General Settings</span> 
        </a>
      </li>

      <li>
        <a href="{{ route('admin.profile') }}">
          <iconify-icon icon="solar:user-outline" class="menu-icon"></iconify-icon>
          <span>My Profile</span> 
        </a>
      </li>

      <li>
        <a href="{{ route('admin.reports') }}">
          <iconify-icon icon="solar:chart-2-outline" class="menu-icon"></iconify-icon>
          <span>Reports</span> 
        </a>
      </li>
    </ul>
  </div>
</aside>