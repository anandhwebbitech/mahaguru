<div class="sidebar">
    <style>
        .sidebar a {
            display: block;
            padding: 8px 20px;
            margin: 6px 16px;
            color: #444;
            font-size: 15px;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #f1f5f9;
            color: #2b6cb0;
        }

        .sidebar a.active {
            background: #eef6ff;
            color: #2b6cb0;
            font-weight: 500;
        }

        .sidebar h4 {
            background: #fff;
        }

        .sidebar .btn {
            background: red;
            border: 1px solid #ddd;
            color: #fff;
            border-radius: 8px;
        }

        .sidebar .btn:hover {
            background: #2b6cb0;
        }
    </style>

    {{-- Logo --}}
    <h4 class="text-center p-2 mt-1 border-bottom">
        <img src="{{ asset('assets/images/new-images/logo.png') }}" class="img-fluid" style="max-height:60px;">
    </h4>

    {{-- ================= ADMIN MENU ================= --}}
    @auth
        @if (auth()->user()->role == 1)

           <a href="{{ route('admin.dashboard') }}"
   class="{{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
    <i class="fa fa-home me-2"></i> Dashboard
</a>
<a href="{{ route('admin.banner.index') }}"
   class="{{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
    <i class="fa fa-list me-2"></i> Banner
</a>
<a href="{{ route('admin.category.index') }}"
   class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
    <i class="fa fa-list me-2"></i> Category List
</a>
<a href="{{ route('admin.subcategory.index') }}"
   class="{{ request()->routeIs('admin.subcategory.*') ? 'active' : '' }}">
    <i class="fa fa-list me-2"></i> Sub Category List
</a>

<a href="{{ route('admin.material.index') }}"
   class="{{ request()->routeIs('admin.material.*') ? 'active' : '' }}">
    <i class="fa fa-cubes me-2"></i> Material List
</a>
<a href="{{ route('admin.colors.index') }}"
   class="{{ request()->routeIs('admin.colors.*') ? 'active' : '' }}">
    <i class="fa fa-cubes me-2"></i> Colors 
</a>
<a href="{{ route('admin.sizes.index') }}"
   class="{{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}">
    <i class="fa fa-cubes me-2"></i> Size 
</a>
<a href="{{ route('admin.shipping.index') }}"
   class="{{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}">
    <i class="fa fa-cubes me-2"></i> Shipping 
</a>
<a href="{{ route('admin.addProductspage') }}"
   class="{{ request()->routeIs('admin.addProductspage') || request()->routeIs('admin.products.*') ? 'active' : '' }}">
    <i class="fa fa-plus me-2"></i> Add Products
</a>

<a href="{{ route('admin.userlist') }}"
   class="{{ request()->routeIs('admin.userlist*') ? 'active' : '' }}">
    <i class="fa fa-users me-2"></i> User List
</a>

<a href="{{ route('admin.coupon.index') }}"
   class="{{ request()->routeIs('admin.coupon.*') ? 'active' : '' }}">
    <i class="fa fa-ticket-alt me-2"></i> Coupon List
</a>

<a href="{{ route('admin.orders') }}"
   class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
    <i class="fa fa-shopping-cart me-2"></i> Order List
</a>

<a href="{{ route('admin.productreviews') }}"
   class="{{ request()->routeIs('admin.productreviews*') ? 'active' : '' }}">
    <i class="fa fa-star me-2"></i> Reviews List
</a>

<a href="{{ route('admin.enquiry') }}"
   class="{{ request()->routeIs('admin.enquiry*') ? 'active' : '' }}">
    <i class="fa fa-envelope me-2"></i> Enquiry List
</a>

        @endif
    @endauth

    {{-- Logout --}}
    <div class="mt-auto p-3">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn w-100">
                <i class="fa fa-sign-out-alt me-1"></i> Logout
            </button>
        </form>
    </div>
</div>