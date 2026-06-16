@extends('layouts.app')

<style>
    /* Professional Hover and Custom UI Tweaks */
    .table {
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        background: #ffbb38;
        color: #fff;
        border: none;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background: #fff9ec;
    }

    .btn-warning {
        color: #fff;
    }

    .table thead th {
        background: #ffbb38;
        color: #fff;
        border: none;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background: #fff9ec;
    }

    .btn-warning {
        background: #ffbb38;
        border-color: #ffbb38;
        color: #fff;
    }

    .btn-warning:hover {
        background: #f5a800;
        border-color: #f5a800;
        color: #fff;
    }

    .account-card {
        border: 1px solid #eee !important;
    }

    .table {
        margin-bottom: 0;
    }

    .account-sidebar-modern {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, .08);
    }

    .profile-section {
        background: linear-gradient(135deg, #1e293b, #334155);
        padding: 35px 20px;
        color: #fff;
    }

    .profile-image {
        width: 110px;
        height: 110px;
        margin: auto;
        margin-bottom: 15px;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
    }

    .profile-section h5 {
        margin-bottom: 5px;
        font-weight: 700;
        color: #fff;
    }

    .profile-section p {
        margin: 0;
        font-size: 13px;
        color: rgba(255, 255, 255, .75);
    }

    .sidebar-menu {
        padding: 20px;
    }

    .menu-title {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 12px;
        letter-spacing: 1px;
    }

    .sidebar-menu .tab-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        border-radius: 12px;
        text-decoration: none;
        color: #334155;
        font-weight: 600;
        transition: .3s;
    }

    .sidebar-menu .tab-btn i {
        width: 18px;
        color: #f59e0b;
    }

    .sidebar-menu .tab-btn:hover {
        background: #fff7e8;
        color: #f59e0b;
    }

    .sidebar-menu .tab-btn.active {
        background: #f59e0b;
        color: #fff;
    }

    .sidebar-menu .tab-btn.active i {
        color: #fff;
    }

    .custom-radio-default:checked {
        border-color: #FFBB38 !important;
        background-color: #fff !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3ccircle cx='10' cy='10' r='5' fill='%23FFBB38'/%3e%3c/svg%3e") !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-size: 100% 100% !important;
    }
    .custom-default-select:focus {
        border-color: #FFBB38 !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 187, 56, 0.25) !important;
    }
</style>

@section('content')
    {{-- <div class="dz-bnr-inr bg-secondary overlay-black-light text-white"
        style="background-image:url({{ asset('images/new-images/site-banner.jpg') }}); background-size: cover; background-position: center;">
        <div class="container">
            <div class="dz-bnr-inr-entry py-2">
                <h1 class="text-white fw-bold mb-2">My Account</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-warning text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item text-white-50" aria-current="page">Dashboard</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div> --}}

    <div class="content-inner-1 py-5 bg-light">
        <div class="container">
            <div class="row g-4">

                <aside class="col-xl-3 col-lg-4">
                    <div class="sticky-top" style="top:30px; z-index:10;">

                        <div class="account-sidebar-modern">

                            <!-- Profile -->
                            <div class="profile-section text-center">

                                <div class="profile-image">
                                    <img src="{{ Auth::user()->profile_pic ? asset('public/uploads/profile/' . Auth::user()->profile_pic) : asset('public/assets/images/new-images/profile.jpg') }}"
                                        alt="{{ Auth::user()->name }}">
                                </div>

                                <h5>{{ Auth::user()->name }}</h5>
                                <p>{{ Auth::user()->email }}</p>

                            </div>

                            <!-- Menu -->
                            <div class="sidebar-menu">

                                <span class="menu-title">MAIN MENU</span>

                                <a href="#" class="tab-btn active" data-tab="dashboard">
                                    <i class="fa-solid fa-gauge"></i>
                                    Dashboard
                                </a>

                                <span class="menu-title mt-4">ACCOUNT SETTINGS</span>

                                <a href="#" class="tab-btn" data-tab="profile">
                                    <i class="fa-solid fa-user"></i>
                                    Profile
                                </a>

                                <a href="#" class="tab-btn" data-tab="account_address">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Address
                                </a>

                            </div>

                        </div>

                    </div>
                </aside>
                <section class="col-xl-9 col-lg-8 account-wrapper">

                    <div id="dashboard" class="tab-content">
                        <div class="account-card bg-white p-4 p-md-5 rounded-3 shadow-sm border">
                            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <p class="mb-0 text-secondary">Hello <strong
                                        class="text-dark">{{ Auth::user()->name }}</strong> (not you?
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="text-warning fw-semibold text-decoration-none border-bottom border-warning">Log
                                        out</a>)
                                </p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="stat-card d-flex align-items-center p-4 border rounded-3 bg-white h-100">
                                        <div class="p-3 rounded-3 me-3 bg-light-warning"
                                            style="background-color: rgba(255, 187, 56, 0.15);">
                                            <svg width="28" height="28" viewBox="0 0 36 37" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M32.4473 8.03086C32.482 8.37876 32.5 8.73144 32.5 9.08829C32.5 14.919 27.7564 19.6625 21.9258 19.6625C16.0951 19.6625 11.3516 14.919 11.3516 9.08829C11.3516 8.73144 11.3695 8.37876 11.4042 8.03086H8.98055L8.05537 0.628906H0.777344V2.74375H6.18839L8.56759 21.7774H34.1868L35.8039 8.03086H32.4473Z"
                                                    fill="#FFBB38"></path>
                                                <path
                                                    d="M9.09669 26.0074H6.06485C4.31566 26.0074 2.89258 27.4305 2.89258 29.1797C2.89258 30.9289 4.31566 32.352 6.06485 32.352H9.09669C10.8459 32.352 12.269 30.9289 12.269 29.1797C12.269 27.4305 10.8459 26.0074 9.09669 26.0074Z"
                                                    fill="#FFBB38"></path>
                                                <path
                                                    d="M24.8315 26.0074H21.7997C20.0508 26.0074 18.6277 27.4305 18.6277 29.1797C18.6277 30.9289 20.0508 32.352 21.7997 32.352H24.8315C26.5807 32.352 28.0038 30.9289 28.0038 29.1797C28.0038 27.4305 26.5807 26.0074 24.8315 26.0074Z"
                                                    fill="#FFBB38"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-muted small d-block mb-1 fw-semibold">Total Orders</span>
                                            <h3 class="fw-bold mb-0 text-dark">{{ $orders ? $orders->count() : 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card d-flex align-items-center p-4 border rounded-3 bg-white h-100">
                                        <div class="p-3 rounded-3 me-3" style="background-color: rgba(255, 187, 56, 0.15);">
                                            <svg width="28" height="28" viewBox="0 0 33 27" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M30.2253 12.8816H29.4827L28.6701 9.36514C28.376 8.10431 27.2552 7.22168 25.9662 7.22168H21.8474V3.84528C21.8474 2.03804 20.3764 0.581055 18.5831 0.581055H3.17237C1.46313 0.581055 0.0761719 1.96801 0.0761719 3.67717V20.0967C0.0761719 21.8058 1.46313 23.1928 3.17237 23.1928H4.29313C4.89555 25.1962 6.74485 26.6533 8.93037 26.6533C11.1159 26.6533 12.9792 25.1962 13.5816 23.1928C13.8455 23.1928 20.3459 23.1928 20.1942 23.1928C20.7966 25.1962 22.6459 26.6533 24.8315 26.6533C27.031 26.6533 28.8803 25.1962 29.4827 23.1928H30.2253C31.7663 23.1928 32.9992 21.9599 32.9992 20.4189V15.6555C32.9992 14.1145 31.7663 12.8816 30.2253 12.8816ZM8.93037 23.8513C7.78968 23.8513 6.88491 22.8969 6.88491 21.7918C6.88491 20.657 7.79558 19.7324 8.93037 19.7324C10.0652 19.7324 10.9898 20.657 10.9898 21.7918C10.9898 22.9151 10.0692 23.8513 8.93037 23.8513ZM13.9739 8.06224L9.79897 11.3125C9.20227 11.7767 8.30347 11.6903 7.82363 11.0604L6.21247 8.94486C5.7361 8.32843 5.86222 7.4458 6.47866 6.98346C7.08107 6.50717 7.96369 6.63321 8.44006 7.24965L9.19656 8.23035L12.2507 5.84867C12.8531 5.3864 13.7357 5.48448 14.2121 6.10092C14.6884 6.71727 14.5763 7.58595 13.9739 8.06224ZM24.8315 23.8513C23.6906 23.8513 22.7861 22.8969 22.7861 21.7918C22.7861 20.657 23.7107 19.7324 24.8315 19.7324C25.9662 19.7324 26.8909 20.657 26.8909 21.7918C26.8909 22.9166 25.9683 23.8513 24.8315 23.8513ZM22.618 10.0236H25.2798C25.6021 10.0236 25.8962 10.2337 26.0083 10.542L26.8629 13.0497C27.031 13.5541 26.6667 14.0724 26.1344 14.0724H22.618C22.1976 14.0724 21.8474 13.7222 21.8474 13.3019V10.7942C21.8474 10.3739 22.1976 10.0236 22.618 10.0236Z"
                                                    fill="#FFBB38"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-muted small d-block mb-1 fw-semibold">Pending Orders</span>
                                            <h3 class="fw-bold mb-0 text-dark">{{ $pendingordersCount }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card d-flex align-items-center p-4 border rounded-3 bg-white h-100">
                                        <div class="p-3 rounded-3 me-3" style="background-color: rgba(255, 187, 56, 0.15);">
                                            <svg width="24" height="28" viewBox="0 0 27 31" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.79749 18.4331C6.71621 20.0289 5.95627 20.8019 4.64859 23.6816C3.76653 22.8387 2.90107 22.0123 2.00953 21.1599C2.5288 20.3146 3.03267 19.4942 3.53535 18.6726C3.88035 18.1071 3.46066 17.0579 2.82282 16.899C1.88623 16.6666 0.94845 16.4426 0 16.2114C0 14.4034 0 12.6274 0 10.7827C0.921182 10.561 1.85422 10.3405 2.78489 10.1117C3.46777 9.94331 3.8922 8.90476 3.52705 8.30605C3.03385 7.49868 2.5371 6.6925 2.06051 5.91596C3.35514 4.62014 4.62251 3.35396 5.92426 2.05339C6.70673 2.53355 7.52832 3.03978 8.35347 3.54246C8.88698 3.8673 9.94331 3.44524 10.0927 2.84416C10.3262 1.90638 10.5491 0.965048 10.7839 0C12.5883 0 14.3785 0 16.2197 0C16.4366 0.906955 16.6548 1.8234 16.8777 2.73865C17.0555 3.46777 18.0763 3.89694 18.7082 3.50926C19.5144 3.01489 20.3182 2.52051 21.0829 2.05102C22.3763 3.34447 23.6318 4.59998 24.943 5.9124C24.4783 6.67235 23.9756 7.49038 23.4753 8.31079C23.1114 8.90713 23.5405 9.93976 24.2258 10.1081C25.1434 10.3334 26.0646 10.5503 27 10.7756C27 12.5954 27 14.3892 27 16.2197C26.1298 16.426 25.2667 16.6287 24.4048 16.8338C23.4658 17.0579 23.0651 18.0122 23.5654 18.8267C24.029 19.5819 24.4914 20.3383 24.9727 21.122C24.1487 22.004 23.3473 22.8612 22.4901 23.7776C21.5393 21.1741 19.8297 19.4243 17.3163 18.4592C20.5565 15.5332 19.8558 11.4668 17.659 9.41099C15.2973 7.19992 11.5995 7.26157 9.31378 9.56393C7.15368 11.7406 6.71858 15.6885 9.79749 18.4331Z"
                                                    fill="#FFBB38"></path>
                                                <path
                                                    d="M21.0695 30.3147C16.0415 30.3147 11.0847 30.3147 6.03891 30.3147C6.03891 29.9768 6.03416 29.6496 6.04009 29.3224C6.06262 28.0396 5.97963 26.7426 6.13612 25.4752C6.53566 22.2576 9.12611 19.9244 12.3722 19.8213C13.5886 19.7821 14.8417 19.7762 16.0249 20.0169C18.8643 20.5954 20.8916 23.0258 21.0552 25.9364C21.1359 27.3709 21.0695 28.8138 21.0695 30.3147Z"
                                                    fill="#FFBB38"></path>
                                                <path
                                                    d="M13.5375 17.9235C11.2244 17.9093 9.35005 16.0112 9.38325 13.7195C9.41763 11.4124 11.3169 9.55701 13.6157 9.58428C15.8849 9.61036 17.7486 11.5013 17.7403 13.7693C17.7332 16.0752 15.8481 17.9378 13.5375 17.9235Z"
                                                    fill="#FFBB38"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-muted small d-block mb-1 fw-semibold">Total Wishlist</span>
                                            <h3 class="fw-bold mb-0 text-dark">
                                                {{ session('wishlist') ? count(session('wishlist')) : 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-xl-12">
                                    <div class="sales-chart-wraper border p-4 rounded-3 bg-white shadow-sm">
                                        <div id="handleSalesChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="account_address" class="tab-content" style="display:none;">
                        <div class="account-card bg-white p-4 p-md-5 rounded-3 shadow-sm border">

                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold text-dark mb-0">
                                    My Saved Addresses
                                </h4>

                                <button class="btn btn-warning px-4 py-2 rounded-pill fw-semibold shadow-sm"
                                    id="addAdd_btn">
                                    <i class="fa-solid fa-plus me-2"></i>
                                    Add Address
                                </button>
                            </div>

                            <!-- Address Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th class="text-center" width="120">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addressContainer">
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div id="addressFormWrapper" class="tab-content p-4 p-md-5 border rounded-3 shadow-sm bg-white"
                        style="display:none;">
                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                            <h4 id="addressFormTitle" class="fw-bold text-dark mb-0">Add / Edit Address</h4>
                        </div>
                        <form id="addressForm" class="row g-3">
                            @csrf
                            <input type="hidden" id="selected_address_id" name="selected_address_id">

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">First Name *</label>
                                <input type="text" name="first_name" class="form-control py-2" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Last Name</label>
                                <input type="text" name="last_name" class="form-control py-2">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-secondary">Company name (optional)</label>
                                <input type="text" name="company_name" class="form-control py-2">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Country / Region *</label>
                                <select class="form-select py-2" name="country" id="country-dropdown" required>
                                    <option value="">Select Country</option>
                                    <option value="India" selected>India</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="United Arab Emirates">United Arab Emirates (UAE)</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="United Kingdom">United Kingdom (UK)</option>
                                    <option value="United States">United States (USA)</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Australia">Australia</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">State *</label>
                                <select class="form-select py-2" name="state" id="state-dropdown" required disabled>
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-secondary">Street address *</label>
                                <input type="text" name="address_line1" class="form-control py-2" required
                                    placeholder="House number and street name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Town / City *</label>
                                <input type="text" name="city" class="form-control py-2" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">ZIP Code *</label>
                                <input type="text" name="zip_code" class="form-control py-2" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Phone *</label>
                                <input type="text" name="phone" class="form-control py-2" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Email address *</label>
                                <input type="email" name="email" class="form-control py-2" required>
                            </div>
                            <div class="col-12 mt-3 mb-2">
                               <div class="col-md-6 mt-2">
                                    <label class="form-label small fw-semibold text-secondary">Set as Default Address? *</label>
                                    <select class="form-select py-2 shadow-none custom-default-select" name="is_default" id="isDefaultAddress" required style="border: 1px solid #ced4da; cursor: pointer;">
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes (Set as Default)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-4 pt-2 border-top">
                                <button type="button" id="saveAddressBtn"
                                    class="btn btn-warning px-4 text-white fw-semibold">Save Address</button>
                                <button type="button" id="cancelAddressBtn"
                                    class="btn btn-light border px-4 ms-2">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <div id="profile" class="tab-content" style="display:none;">
                        <div class="account-card bg-white p-4 p-md-5 rounded-3 shadow-sm border">
                            <div class="profile-edit text-center mb-5 border-bottom pb-4">
                                <div class="avatar-preview mb-3 d-flex justify-content-center">
                                    <div id="imagePreview"
                                        style="background-image: url({{ Auth::user()->profile_pic ? asset('public/uploads/profile/' . Auth::user()->profile_pic) : asset('public/assets/images/new-images/profile.jpg') }}); width:130px; height:130px; border-radius:50%; background-size:cover; background-position:center; cursor:pointer; position:relative; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"
                                        title="Click to change profile picture">
                                        <span
                                            style="position:absolute; bottom:5px; right:5px; background:#FFBB38; color:#fff; border-radius:50%; width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:3px solid #fff;">
                                            <i class="fa-solid fa-camera" style="font-size:12px;"></i>
                                        </span>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark mb-1" id="display_user_name">{{ Auth::user()->name }}</h3>
                                <p class="text-muted small mb-0" id="display_user_email">{{ Auth::user()->email }}</p>
                            </div>

                            <form id="profileForm" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="profile_pic" id="profile_pic_input" class="d-none"
                                    accept="image/*">

                                <div class="col-lg-6">
                                    <label class="form-label small fw-semibold text-secondary">Full Name</label>
                                    <input type="text" name="first_name" class="form-control py-2"
                                        value="{{ Auth::user()->name }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label small fw-semibold text-secondary">Email Address</label>
                                    <input type="email" name="email" class="form-control py-2"
                                        value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label small fw-semibold text-secondary">Phone</label>
                                    <input type="text" name="phone" class="form-control py-2"
                                        value="{{ Auth::user()->phone }}">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label small fw-semibold text-secondary">New Password</label>
                                    <input type="password" name="new_password" class="form-control py-2"
                                        placeholder="Leave blank to keep unchanged">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label small fw-semibold text-secondary">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control py-2">
                                </div>

                                <div
                                    class="col-12 mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="newsletter"
                                            name="newsletter">
                                        <label class="form-check-label small text-muted" for="newsletter">Subscribe to
                                            monthly store newsletter</label>
                                    </div>
                                    <button type="button" id="updateProfile"
                                        class="btn btn-warning text-white px-4 fw-semibold">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function loadAddresses() {
                $.ajax({
                    url: "{{ route('get.addresses') }}",
                    method: "GET",
                    success: function(response) {

                        let html = '';

                        if (response.status === "success") {

                            if (response.addresses.length === 0) {

                                html = `
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No saved addresses found
                                        </td>
                                    </tr>
                                `;

                            } else {

                                response.addresses.forEach(function(addr, index) {

                                    html += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>
                                            <strong>${addr.first_name} ${addr.last_name ?? ''}</strong>
                                        </td>
                                        <td>
                                            ${addr.street ?? ''}<br>
                                            ${addr.city ?? ''},
                                            ${addr.state ?? ''}<br>
                                            ${addr.country ?? ''}
                                            - ${addr.zip_code ?? ''}
                                        </td>
                                        <td>${addr.phone ?? ''}</td>
                                        <td>${addr.email ?? ''}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning edit-address-btn mb-1"
                                                data-id="${addr.id}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger remove-address-btn"
                                                data-id="${addr.id}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    `;
                                });
                            }

                            $("#addressContainer").html(html);
                        }
                    }
                });
            }
            loadAddresses();

            $(document).on('click', '.tab-btn', function(e) {
                e.preventDefault();
                let targetTab = $(this).data('tab');

                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                $('.tab-content').hide();
                $('#' + targetTab).show();
            });

            $(document).on('click', '#imagePreview', function() {
                $('#profile_pic_input').click();
            });

            $(document).on('change', '#profile_pic_input', function() {
                let file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $(document).on('click', '#updateProfile', function() {
                // Essential: Convert plain form to standard multi-part FormData object
                let formElement = $('#profileForm')[0];
                let formData = new FormData(formElement);

                $.ajax({
                    url: "{{ url('/update-user') }}",
                    type: "POST",
                    data: formData,
                    contentType: false, // Critical for multi-part file payloads
                    processData: false, // Critical to stop jQuery encoding structures
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Update UI titles dynamically if you drop page reload
                            $('#display_user_name').text($('[name="first_name"]').val());
                            $('#display_user_email').text($('[name="email"]').val());

                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: value[0],
                                    });
                                });
                            } else if (xhr.responseJSON.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: xhr.responseJSON.message,
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong!',
                            });
                        }
                    }
                });
            });
            $(document).on('click', '#addAdd_btn', function() {
                $('.tab-content').hide();
                $("#addressForm")[0].reset();
                $("#selected_address_id").val("");
                $('.error-text').text('');
                $('#addressForm input, #addressForm select').removeClass('is-invalid').prop("disabled",
                    false);

                $("#saveAddressBtn").text("Save Address").removeClass("update-mode").show();
                $("#addressFormTitle").text("Add New Address");
                $("#addressFormWrapper").slideDown();

                $('#country-dropdown').val('India'); // Default India
                loadApiStates('India');
            });

            $(document).on('click', '#cancelAddressBtn', function() {
                $("#addressFormWrapper").slideUp(function() {
                    $('#account_address').show();
                    $('.tab-btn[data-tab="account_address"]').addClass('active');
                });
            });

            $(document).on("click", "#enableEditBtn", function() {
                $("#addressForm input, #addressForm select").prop("disabled", false);
                $("#saveAddressBtn").show();
            });

            // Save or Update Address
            $(document).on('click', '#saveAddressBtn', function() {
                let formData = $("#addressForm").serialize();
                let id = $("#selected_address_id").val();
                let isUpdate = $(this).hasClass("update-mode");

                let url = isUpdate ?
                    "{{ url('/update-address') }}/" + id :
                    "{{ route('saveAddress') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            Swal.fire({
                                icon: 'error',
                                title: value[0],
                            });
                        });
                    }
                });
            });

            function loadApiStates(countryName, selectedState = '', callback = null) {
                let stateDropdown = $('#state-dropdown');

                if (!countryName) {
                    stateDropdown.html('<option value="">Select State</option>').prop('disabled', true);
                    if (callback) callback();
                    return;
                }
                stateDropdown.html('<option value="">Loading States...</option>').prop('disabled', true);

                // CountriesNow API Request
                $.ajax({
                    url: 'https://countriesnow.space/api/v0.1/countries/states',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        country: countryName
                    }),
                    success: function(resData) {
                        stateDropdown.html('<option value="">Select State</option>');

                        if (resData.data && resData.data.states && resData.data.states.length > 0) {
                            let htmlOptions = '';

                            resData.data.states.forEach(function(stateObject) {
                                let isSelected = (stateObject.name === selectedState) ?
                                    'selected' : '';
                                htmlOptions +=
                                    `<option value="${stateObject.name}" ${isSelected}>${stateObject.name}</option>`;
                            });

                            let otherSelected = (selectedState === 'Other States') ? 'selected' : '';
                            htmlOptions +=
                                `<option value="Other States" ${otherSelected}>Other States (Default)</option>`;

                            stateDropdown.append(htmlOptions).prop('disabled', false);
                        } else {
                            stateDropdown.html(
                                '<option value="Other States" selected>Other States (Default)</option>'
                                ).prop('disabled', false);
                        }

                        if (callback) callback();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching states from API:', error);
                        stateDropdown.html(
                            '<option value="Other States" selected>Error Loading! Select Other States</option>'
                            ).prop('disabled', false);

                        if (callback) callback();
                    }
                });
            }
            $(document).on('change', '#country-dropdown', function() {
                let country = $(this).val();
                loadApiStates(country);
            });
            if ($('#country-dropdown').val() === 'India') {
                loadApiStates('India');
            }
            $(document).on('click', '.edit-address-btn', function() {
                $("#addressForm")[0].reset();
                $('.error-text').text('');
                $('#addressForm input, #addressForm select').removeClass('is-invalid');

                $("#addressFormTitle").text("Edit Address");
                $("#addressFormWrapper").slideDown();

                let id = $(this).data("id");
                $("#selected_address_id").val(id);

                $.ajax({
                    url: "{{ url('/address') }}/" + id,
                    method: "GET",
                    success: function(res) {
                        if (!res.address) {
                            Swal.fire('Error', 'Address not found', 'error');
                            return;
                        }

                        let a = res.address;
                        $('[name="first_name"]').val(a.first_name || '');
                        $('[name="last_name"]').val(a.last_name || '');
                        $('[name="company_name"]').val(a.company_name || '');
                        // $('[name="country"]').val(a.country_region || a.country || '');
                        let country = a.country_region || a.country || 'India';

                        $('#country-dropdown').val(country);

                        loadApiStates(country, a.state || '', function() {
                            $('#state-dropdown').val(a.state || '');
                        });
                        $('[name="address_line1"]').val(a.street || '');
                        $('[name="address_line2"]').val(a.address_line2 || '');
                        $('[name="city"]').val(a.city || '');
                        $('[name="state"]').val(a.state || '');
                        $('[name="zip_code"]').val(a.zip_code || '');
                        $('[name="phone"]').val(a.phone || '');
                        $('[name="email"]').val(a.email || '');
                        $('[name="is_default"]').val(a.is_default ?? 0);
                        $("#addressForm input, #addressForm select").prop("disabled", false);
                        $("#saveAddressBtn").addClass("update-mode").text("Update Address")
                            .show();
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to load address', 'error');
                    }
                });
            });

            // Delete Address
            $(document).on('click', '.remove-address-btn', function() {
                let id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/delete-address') }}/" + id,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                Swal.fire('Deleted!', 'Your address has been removed.',
                                    'success');
                                loadAddresses();
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to delete address.',
                                    'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
