<!-- Header -->
<header class="site-header mo-left header style-2">
    <style>
        .qty-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: black;
            color: white;
            font-size: 20px;
            line-height: 40px;
            text-align: center;
            cursor: pointer;
        }

        .qty-btn.plus,
        .qty-btn.minus {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-number {
            width: 40px;
            height: 40px;
            border: 2px solid black;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .header-nav .navbar-nav {
            width: 100%;
            display: flex;
            align-items: center;
        }

        .header-nav .navbar-nav .ms-auto {
            margin-left: auto !important;
        }
        .header-nav .navbar-nav .nav-item{
            margin: 0 8px;
        }

        .header-nav .navbar-nav .nav-link{
            padding: 10px 15px !important;
        }
        .wishlist-item-card {
            background: #ffffff;
            border: 1px solid #f1f2f6;
            border-radius: 12px;
            padding: 10px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }
        .wishlist-item-card:hover {
            border-color: #e4e7eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
        }
        .wishlist-thumb-wrapper {
            width: 70px;
            height: 70px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            background: #f7f8fa;
            border: 1px solid #f1f2f6;
            flex-shrink: 0;
        }
        .wishlist-thumb-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .wishlist-item-card:hover .wishlist-thumb-wrapper img {
            transform: scale(1.06);
        }
        .wish-prod-title {
            font-size: 13.5px;
            font-weight: 500;
            color: #1e293b;
            line-height: 1.4;
            margin-bottom: 4px;
            height: 38px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            transition: color 0.2s ease;
        }
        .wish-prod-title a {
            color: #1e293b !important;
        }
        .wish-prod-title a:hover {
            color: #ff5e14 !important; /* Unga brand color theme ku mathikonga */
        }
        .wish-category-badge {
            font-size: 10.5px;
            font-weight: 500;
            color: #64748b !important;
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            letter-spacing: 0.3px;
        }
        .wish-delete-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fff0f0;
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            flex-shrink: 0;
        }
        .wish-delete-btn:hover {
            background: #ef4444;
            color: #ffffff;
            transform: rotate(90deg);
        }
    </style>

    <!-- Main Header -->
    <div class="header-info-bar">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="head-top-content">
                            <!-- Left content if any -->
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="text-end">
                            <div class="header-top-right">
                                <a href="{{ route('about') }}">About <i class="fa-solid fa-minus"></i></a>
                                <a href="{{ route('faq') }}">FAQ <i class="fa-solid fa-minus"></i></a>
                                @guest
                                    <a href="{{ route('login') }}">Login <i class="fa-solid fa-minus"></i></a>
                                    <a href="{{ route('userregister') }}">Sign Up <i class="fa-solid fa-minus"></i> </a>
                                @endguest
                                @auth
                                    <a href="{{ route('logout') }}">LogOut</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container clearfix">
            <div class="logo-header logo-dark">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('assets/images/new-images/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="extra-nav d-md-flex d-none m-l15">
                <div class="extra-cell">
                    <ul class="navbar-nav header-right m-0">
                        <li>
                            <div class="extra-nav">
                                <div class="extra-cell">
                                    <ul class="header-right">
                                        @guest
                                            <li class="nav-item login-link">
                                                <a class="nav-link" href="{{ route('login') }}">Login / Register</a>
                                            </li>
                                        @endguest
                                        <li class="nav-item wishlist-link">
                                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                <i class="iconly-Light-Heart2"></i>
                                                <span class="badge badge-circle">
                                                    {{ session('wishlist') ? count(session('wishlist')) : 0 }}
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item cart-link">
                                            <a href="javascript:void(0);" class="nav-link cart-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                <i class="iconly-Broken-Buy"></i>
                                                <span class="badge badge-circle cart-badge-count"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item cart-link user-profile">
                                            <a href="{{ route('userdashboard') }}" class="nav-link cart-btn">
                                                <i class="fa-solid fa-user"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- header search nav -->
            <div class="header-search-nav">
                <form class="header-item-search">
                    <div class="input-group search-input">
                        <input type="text" id="productSearch" class="form-control" placeholder="Search for products">
                        <button class="btn" type="button">
                            <i class="iconly-Light-Search text-secondary"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main Header End -->

    <!-- Main Header Sticky -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix">
            <div class="container clearfix d-lg-flex d-block">
                <!-- Website Logo -->
                <div class="logo-header logo-dark">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('assets/images/new-images/logo.png') }}" alt="logo">
                    </a>
                </div>

                <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Main Nav -->
                <div class="header-nav w3menu navbar-collapse collapse" id="navbarNavDropdown">
                    <div class="logo-header">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('assets/images/new-images/logo.png') }}" alt="">
                        </a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('index') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('allProducts') }}" class="nav-link">All Collections</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('newarive') }}" class="nav-link">New Arrivals</a>
                        </li>

                        @php
                            $categories = \App\Models\Category::all();
                        @endphp

                        @foreach ($categories->take(5) as $category)
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="applyCategoryFilter({{ $category->id }})">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach

                        @if ($categories->count() > 5)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">More</a>
                                <ul class="dropdown-menu">
                                    @foreach ($categories->skip(5) as $category)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="applyCategoryFilter({{ $category->id }})">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        @auth
                            <li class="nav-item ms-auto">
                                <a href="{{ route('myorderuser') }}" class="nav-link">My Order</a>
                            </li>
                        @endauth
                    </ul>
                    <div class="dz-social-icon">
                        <ul>
                            <li><a class="fab fa-youtube" target="_blank" href="https://youtube.com/@mahaaguruboutique?si=xx6PGztkZ-MW9kcH"></a></li>
                            <li><a class="fab fa-facebook-f" target="_blank" href="https://www.facebook.com/share/179dEVSp57/"></a></li>
                            <li><a class="fab fa-instagram" target="_blank" href="https://www.instagram.com/mahaaguruboutique?igsh=bmY2YXp1ZDQwaDYz"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->

    <!-- Sidebar cart & Wishlist -->
    <div class="offcanvas dz-offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">&times;</button>
        <div class="offcanvas-body">
            <div class="product-description">
                <div class="dz-tabs">
                    <ul class="nav nav-tabs center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="shopping-cart" data-bs-toggle="tab" data-bs-target="#shopping-cart-pane" type="button" role="tab" aria-controls="shopping-cart-pane" aria-selected="true">
                                Shopping Cart <span class="badge badge-light cart-count">0</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="wishlist" data-bs-toggle="tab" data-bs-target="#wishlist-pane" type="button" role="tab" aria-controls="wishlist-pane" aria-selected="false">
                                Wishlist <span class="badge badge-light wish-count">0</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-4" id="dz-shopcart-sidebar">
                        <!-- Cart Pane -->
                        <div class="tab-pane fade show active" id="shopping-cart-pane" role="tabpanel" aria-labelledby="shopping-cart" tabindex="0">
                            <div class="shop-sidebar-cart">
                                <ul class="sidebar-cart-list"></ul>
                                <div class="cart-total">
                                    <h5 class="mb-0">Subtotal:</h5>
                                    <h5 class="mb-0" id="sidebar_subtotal">00.00 ₹</h5>
                                </div>
                                <div class="mt-auto checkout-section">
                                    {{-- <div class="shipping-time">
                                        <div class="dz-icon"><i class="flaticon flaticon-ship"></i></div>
                                        <div class="shipping-content">
                                            <h6 class="title pe-4">Congratulations, you've got free shipping!</h6>
                                            <div class="progress">
                                                <div class="progress-bar progress-animated border-0" style="width: 75%;" role="progressbar">
                                                    <span class="sr-only">75% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <a href="{{ route('checkout') }}" class="btn btn-outline-secondary btn-block m-b20">Checkout</a>
                                    <a href="{{ route('cart') }}" class="btn btn-secondary btn-block">View Cart</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Wishlist Pane -->
                        <div class="tab-pane fade" id="wishlist-pane" role="tabpanel" aria-labelledby="wishlist" tabindex="0">
                            <div class="shop-sidebar-cart">
                                <ul class="sidebar-wish-list"></ul>
                                <div class="mt-auto">
                                    <a href="{{ route('wishlistpage') }}" class="btn btn-secondary btn-block">Check Your Favourite</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var baseUrl = "{{ asset('') }}";
        var cartItemCount = 0;

        $(document).ready(function() {
            // Load initial functions
            if (typeof loadCart === "button" || typeof loadCart === "function") loadtoggleCart();
            if (typeof loadWishlist === "button" || typeof loadWishlist === "function") loadWishlist();

            // Handle + button click
            $(document).on("click", ".qty-btn.plus", function() {
                let input = $(this).siblings("input.cart-quantity");
                let id = input.data("id");
                let qty = parseInt(input.val()) + 1;
                updateQuantity(id, qty);
            });

            // Handle - button click
            $(document).on("click", ".qty-btn.minus", function() {
                let input = $(this).siblings("input.cart-quantity");
                let id = input.data("id");
                let qty = parseInt(input.val()) - 1;
                if (qty >= 1) updateQuantity(id, qty);
            });

            // Delete item
            $(document).on("click", ".dz-close", function() {
                let id = $(this).data("id");
                deleteCartItem(id);
            });

            // Wishlist Tab Trigger Link Click
            $('.wishlist-link a').on('click', function() {
                $('#wishlist').tab('show');
            });

            // Cart Tab Trigger Link Click
            $('.cart-link a').on('click', function() {
                $('#shopping-cart').tab('show');
            });
        });

        function togglePlaceOrderButton() {
            if (cartItemCount > 0) {
                $("#updateCartBtn").prop("disabled", false);
                $(".place_order").removeClass("disabled-link");
            } else {
                $("#updateCartBtn").prop("disabled", true);
                $(".place_order").addClass("disabled-link");
            }
        }

        function updateQuantity(id, qty) {
            let cartData = [{ id: id, quantity: qty }];

            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart: cartData
                },
                success: function(response) {
                    if (response.status === "success" && typeof loadCart === "function") {
                        loadCart();
                    }
                }
            });
        }

        function deleteCartItem(id) {
            $.ajax({
                url: "{{ url('/cart/remove') }}/" + id,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE",
                },
                success: function(response) {
                    if (response.status === "success" && typeof loadCart === "function") {
                        loadCart();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.log("ERROR:", xhr.responseText);
                    alert("Something went wrong. Check console.");
                }
            });
        }

        function removeFromWishlist(id) {
            let toggleUrl = "{{ url('toggle-wishlist') }}/" + encodeURIComponent(id);

            $.ajax({
                type: "GET",
                url: toggleUrl,
                success: function(response) {
                    $(".wishlist-link .badge").text(response.count);
                    $(".wish-count").text(response.count);
                    if (typeof loadWishlist === "function") loadWishlist();
                },
                error: function(err) {
                    console.error("Wishlist Error:", err);
                }
            });
        }

        $(document).on("click", ".addToWishlist", function() {
            
            let productId = $(this).data("id");
            let btn = $(this);
            let toggleUrl = "{{ url('toggle-wishlist') }}/" + encodeURIComponent(productId);

            $.ajax({
                type: "GET",
                url: toggleUrl,
                success: function(response) {
                    if (response.added) {
                        btn.addClass("active");
                    } else {
                        btn.removeClass("active");
                    }
                    $(".wishlist-link .badge").text(response.count);
                    if (typeof loadWishlist === "function") loadWishlist();
                },
                error: function(err) {
                    console.error("Wishlist Error:", err);
                }
            });
        });

        function applyCategoryFilter(category) {
            window.location.href = "{{ route('productsfilter') }}" + "?category=" + category;
        }
    </script>
@endpush