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
    </style>
    <!-- Main Header -->
    <div class="header-info-bar">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="head-top-content">
                            <!--<div class="me-3">-->
                            <!--    <i class="fa-solid fa-chart-area"></i>-->
                            <!--    <a href="track-order.php">Track Order</a>-->
                            <!--</div>-->
                            <!--<div class="me-3">-->
                            <!--    <i class="fa-solid fa-bag-shopping"></i>-->
                            <!--    <a href="javascript:void(0)">Our Stores</a>-->
                            <!--</div>-->
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
                <a href="{{ route('index') }}"><img src="{{ asset('assets/images/new-images/logo.png') }}"
                        alt="logo"></a>
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
                                                <a class="nav-link" href="{{ route('login') }}">
                                                    Login / Register
                                                </a>
                                            </li>
                                        @endguest
                                        <!-- <li class="nav-item search-link">
                                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                                                <i class="iconly-Light-Search"></i>
                                            </a>
                                        </li> -->
                                        <li class="nav-item wishlist-link">
                                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                <i class="iconly-Light-Heart2"></i>
                                                <span class="badge badge-circle">
                                                    @if (session('wishlist'))
                                                        @php $wishlist = count(session('wishlist')); @endphp
                                                        {{ $wishlist }}
                                                    @else
                                                        {{ '0' }}
                                                    @endif
                                                </span>
                                            </a>

                                        </li>
                                        <li class="nav-item cart-link">
                                            <a href="javascript:void(0);" class="nav-link cart-btn"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                                aria-controls="offcanvasRight">
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
                        <input type="text" id="productSearch" class="form-control"
                            aria-label="Text input with dropdown button" placeholder="Search for products">
                        <button class="btn" type="button">
                            <i class="iconly-Light-Search text-secondary"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main Header End -->

    <!-- Main Header -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix">
            <div class="container clearfix d-lg-flex d-block">
                <!-- Website Logo -->
                <div class="logo-header logo-dark">
                    <a href="{{ route('index') }}"><img src="{{ asset('assets/images/new-images/logo.png') }}"
                            alt="logo"></a>
                </div>

                <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Main Nav -->
                <div class="header-nav w3menu navbar-collapse collapse " id="navbarNavDropdown">
                    <div class="logo-header">
                        <a href="{{ route('index') }}"><img src="{{ asset('assets/images/new-images/logo.png') }}"
                                alt=""></a>
                    </div>
                    <ul class="nav navbar-nav ">

                        <li class="nav-item">
                            <a href="{{ route('index') }}" class="nav-link">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('allProducts') }}" class="nav-link">
                                All Collections
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('newarive') }}" class="nav-link">
                                New Arrivals
                            </a>
                        </li>

                        @php
                            $categories = \App\Models\Category::all();
                        @endphp

                        @foreach ($categories->take(5) as $category)
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)"
                                    onclick="applyCategoryFilter({{ $category->id }}, '{{ $category->name }}')">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach

                        @if ($categories->count() > 5)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    More
                                </a>

                                <ul class="dropdown-menu">
                                    @foreach ($categories->skip(5) as $category)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="applyCategoryFilter({{ $category->id }}, '{{ $category->name }}')">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif



                        {{-- ================= RIGHT SIDE (ADMIN + USER) ================= --}}
                        @auth
                            <li class="nav-item ms-auto">
                                <a href="{{ auth()->check() ? route('myorderuser') : route('login') }}" class="nav-link">
                                    My Order
                                </a>
                            </li>
                        @endauth

                    </ul>
                    <div class="dz-social-icon">
                        <ul>
                            <li>
                                <a class="fab fa-youtube" target="_blank"
                                    href="https://youtube.com/@mahaaguruboutique?si=xx6PGztkZ-MW9kcH"></a>
                            </li>

                            <li>
                                <a class="fab fa-facebook-f" target="_blank"
                                    href="https://www.facebook.com/share/179dEVSp57/"></a>
                            </li>

                            <li>
                                <a class="fab fa-instagram" target="_blank"
                                    href="https://www.instagram.com/mahaaguruboutique?igsh=bmY2YXp1ZDQwaDYz"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->

    <!-- SearchBar -->
    <div class="dz-search-area dz-offcanvas offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            &times;
        </button>
        <div class="container">
            <form class="header-item-search">
                <div class="input-group search-input">
                    <select class="default-select">
                        <option>All Categories</option>
                        <option>Kanchi Cotton</option>
                        <option>Chettinad Cotton</option>
                        <option>Kerala Cotton</option>
                        <option>Narayanpet Cotton</option>
                        <option>Mangalagiri Cotton</option>
                        <option>Gadwal Cotton</option>
                        <option>Kalamkari Cotton</option>
                        <option>Venkatagiri Cotton</option>
                        <option>Pochampally Ikat Cotton</option>
                    </select>
                    <input type="search" class="form-control" placeholder="Search Product">
                    <button class="btn" type="button">
                        <i class="iconly-Light-Search"></i>
                    </button>
                </div>
                <ul class="recent-tag">
                    <li class="pe-0"><span>Quick Search :</span></li>
                    <li><a href="javascript:void(0)">Kanchi Cotton</a></li>
                    <li><a href="javascript:void(0)">Chettinad Cotton</a></li>
                    <li><a href="javascript:void(0)">Kerala Cotton</a></li>
                    <li><a href="javascript:void(0)">Kalamkari Cotton</a></li>
                </ul>
            </form>
            <div class="row search-popup">
                <div class="col-xl-12">
                    <h5 class="mb-3">You May Also Like</h5>
                    <div class="swiper category-swiper2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="shop-card">
                                    <div class="dz-media ">
                                        <img src="{{ asset('assets/images/new-images/product/gown.png') }}"
                                            alt="image">
                                    </div>
                                    <div class="dz-content">
                                        <h6 class="title"><a href="javascript:void(0)">SilkBliss Dress</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card">
                                    <div class="dz-media ">
                                        <img src="{{ asset('assets/images/new-images/product/ball-gown.jpg') }}"
                                            alt="image">
                                    </div>
                                    <div class="dz-content">
                                        <h6 class="title"><a href="javascript:void(0)">GlamPants</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card">
                                    <div class="dz-media ">
                                        <img src="{{ asset('assets/images/new-images/product/cotton-saree.jpg') }}"
                                            alt="image">
                                    </div>
                                    <div class="dz-content">
                                        <h6 class="title"><a href="javascript:void(0)">ComfyLeggings</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card">
                                    <div class="dz-media ">
                                        <img src="{{ asset('assets/images/new-images/product/designer-saree.jpg') }}"
                                            alt="image">
                                    </div>
                                    <div class="dz-content">
                                        <h6 class="title"><a href="javascript:void(0)">ClassicCapri</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card">
                                    <div class="dz-media ">
                                        <img src="{{ asset('assets/images/new-images/product/half-saree.jpg') }}"
                                            alt="image">
                                    </div>
                                    <div class="dz-content">
                                        <h6 class="title"><a href="javascript:void(0)">DapperCoat</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="shop-card">
                                    <div class="dz-media ">
                                        <img src="{{ asset('assets/images/new-images/product/kurti.jpg') }}"
                                            alt="image">
                                    </div>
                                    <div class="dz-content">
                                        <h6 class="title"><a href="javascript:void(0)">SilkBliss Dress</a></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SearchBar -->

    <!-- Sidebar cart -->
    <div class="offcanvas dz-offcanvas offcanvas offcanvas-end " tabindex="-1" id="offcanvasRight">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            &times;
        </button>
        <div class="offcanvas-body">
            <div class="product-description">
                <div class="dz-tabs">

                    <ul class="nav nav-tabs center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="shopping-cart" data-bs-toggle="tab"
                                data-bs-target="#shopping-cart-pane" type="button" role="tab"
                                aria-controls="shopping-cart-pane" aria-selected="true">Shopping Cart
                                <span class="badge badge-light cart-count">0</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="wishlist" data-bs-toggle="tab"
                                data-bs-target="#wishlist-pane" type="button" role="tab"
                                aria-controls="wishlist-pane" aria-selected="false">Wishlist
                                <span class="badge badge-light wish-count">0</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-4" id="dz-shopcart-sidebar">
                        <div class="tab-pane fade show active" id="shopping-cart-pane" role="tabpanel"
                            aria-labelledby="shopping-cart" tabindex="0">
                            <div class="shop-sidebar-cart">
                                <ul class="sidebar-cart-list">
                                    <!--  -->
                                </ul>
                                <div class="cart-total">
                                    <h5 class="mb-0">Subtotal:</h5>
                                    <h5 class="mb-0">00.00 ₹</h5>
                                </div>
                                <div class="mt-auto checkout-section">
                                    <div class="shipping-time">
                                        <div class="dz-icon">
                                            <i class="flaticon flaticon-ship"></i>
                                        </div>
                                        <div class="shipping-content">
                                            <h6 class="title pe-4">Congratulations , you've got free shipping!</h6>
                                            <div class="progress">
                                                <div class="progress-bar progress-animated border-0"
                                                    style="width: 75%;" role="progressbar">
                                                    <span class="sr-only">75% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-outline-secondary btn-block m-b20">Checkout</a>
                                    <a href="{{ route('cart') }}" class="btn btn-secondary btn-block">View Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="wishlist-pane" role="tabpanel" aria-labelledby="wishlist"
                            tabindex="0">
                            <div class="shop-sidebar-cart">
                                <ul class="sidebar-wish-list">

                                </ul>
                                <div class="mt-auto">
                                    <a href="{{ route('wishlistpage') }}" class="btn btn-secondary btn-block">Check
                                        Your Favourite</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar cart -->

    <!-- Sidebar finter -->
    <div class="offcanvas dz-offcanvas offcanvas offcanvas-end " tabindex="-1" id="offcanvasLeft">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            &times;
        </button>
        <div class="offcanvas-body">
            <div class="product-description">
                <div class="widget widget_search">
                    <div class="form-group">
                        <div class="input-group">
                            <input name="dzSearch" required="required" type="search" class="form-control"
                                placeholder="Search Product">
                            <div class="input-group-addon">
                                <button name="submit" value="Submit" type="submit" class="btn">
                                    <i class="icon feather icon-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h6 class="widget-title">Price</h6>
                    <div class="price-slide range-slider">
                        <div class="price">
                            <div class="range-slider style-1">
                                <div id="slider-tooltips" class="mb-3"></div>
                                <span class="example-val" id="slider-margin-value-min"></span>
                                <span class="example-val" id="slider-margin-value-max"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h6 class="widget-title">Color</h6>
                    <div class="d-flex align-items-center flex-wrap color-filter ps-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel1"
                                value="#000000" aria-label="..." checked>
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel2"
                                value="#9BD1FF" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel3"
                                value="#21B290" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel4"
                                value="#FEC4C4" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel5"
                                value="#FF7354" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel6"
                                value="#51EDC8" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel7"
                                value="#B77CF3" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel8"
                                value="#FF4A76" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel9"
                                value="#3E68FF" aria-label="...">
                            <span></span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabe20"
                                value="#7BEF68" aria-label="...">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h6 class="widget-title">Size</h6>
                    <div class="btn-group product-size">
                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio11" checked="">
                        <label class="btn" for="btnradio11">4</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio21">
                        <label class="btn" for="btnradio21">6</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio31">
                        <label class="btn" for="btnradio31">8</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio41">
                        <label class="btn" for="btnradio41">10</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio51">
                        <label class="btn" for="btnradio51">12</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio61">
                        <label class="btn" for="btnradio61">14</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio71">
                        <label class="btn" for="btnradio71">16</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio81">
                        <label class="btn" for="btnradio81">18</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="btnradio91">
                        <label class="btn" for="btnradio91">20</label>
                    </div>
                </div>
                <div class="widget widget_categories">
                    <h6 class="widget-title">Category</h6>
                    <ul>
                        <li class="cat-item cat-item-26"><a href="blog-category.html">Dresses</a> (10)</li>
                        <li class="cat-item cat-item-36"><a href="blog-category.html">Top &amp; Blouses</a> (5)</li>
                        <li class="cat-item cat-item-43"><a href="blog-category.html">Boots</a> (17)</li>
                        <li class="cat-item cat-item-27"><a href="blog-category.html">Jewelry</a> (13)</li>
                        <li class="cat-item cat-item-40"><a href="blog-category.html">Makeup</a> (06)</li>
                        <li class="cat-item cat-item-40"><a href="blog-category.html">Fragrances</a> (17)</li>
                        <li class="cat-item cat-item-40"><a href="blog-category.html">Shaving &amp; Grooming</a> (13)
                        </li>
                        <li class="cat-item cat-item-43"><a href="blog-category.html">Jacket</a> (06)</li>
                        <li class="cat-item cat-item-36"><a href="blog-category.html">Coat</a> (22)</li>
                    </ul>
                </div>
                <div class="widget widget_tag_cloud">
                    <h6 class="widget-title">Tags</h6>
                    <div class="tagcloud">
                        <a href="blog-tag.html">Vintage </a>
                        <a href="blog-tag.html">Wedding</a>
                        <a href="blog-tag.html">Cotton</a>
                        <a href="blog-tag.html">Linen</a>
                        <a href="blog-tag.html">Navy</a>
                        <a href="blog-tag.html">Urban</a>
                        <a href="blog-tag.html">Business Meeting</a>
                        <a href="blog-tag.html">Formal</a>
                    </div>
                </div>
                <a href="javascript:void(0);" class="btn btn-sm font-14 btn-secondary btn-sharp">RESET</a>
            </div>
        </div>
    </div>
    <!-- filter sidebar -->
</header>
<!-- Header End -->
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            loadCart();
            loadWishlist();

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
        });
        var baseUrl = "{{ asset('') }}";

        // function loadCart() {
        //     $.ajax({
        //         url: "{{ route('cart.items') }}",
        //         method: "GET",
        //         dataType: "json",
        //         success: function(response) {
        //             let items = Array.isArray(response.cartItems) ? response.cartItems : [];
        //             if (items.length === 0) {
        //                 $('.sidebar-cart-list').html('<li>Your cart is empty</li>');
        //                 $('.cart-total h5.mb-0:nth-child(2)').text('0 ₹');
        //                 return;
        //             }
        //             if (response.status === 'success') {
        //                 let cartHtml = '';
        //                 let subtotal = 0;

        //                 response.cartItems.forEach(function(item) {
        //                     subtotal += parseFloat(item.total_amount);
        //                     let imageUrl = item.product.images ?
        //                         "{{ asset('public/uploads/images') }}/" + item.product.images.split(",")[0] :
        //                         "{{ asset('assets/images/no-image.png') }}";


        //                     cartHtml += `
    //             <li>
    //                 <div class="cart-widget">
    //                     <div class="dz-media me-3">
    //                         <img src="${imageUrl}" alt="${item.product.product_name}">
    //                     </div>
    //                     <div class="cart-content">
    //                         <h6 class="title"><a href="javascript:void(0)">${item.product.product_name}</a></h6>
    //                         <div class="d-flex align-items-center">
    //                             <div class="btn-quantity light quantity-sm me-3">
    //                             <div class="qty-wrapper">
    //                                 <button class="qty-btn minus" >−</button>
    //                                 <input type="text" value="${item.quantity}" data-id="${item.id}" class="cart-quantity">
    //                                 <button class="qty-btn plus" >+</button>
    //                             </div>
    //                             </div>
    //                             <h6 class="dz-price mb-0">₹${parseFloat(item.total_amount).toFixed(2)}</h6>
    //                         </div>
    //                     </div>
    //                     <a href="javascript:void(0);" class="dz-close" data-id="${item.id}">
    //                         <i class="ti-close"></i>
    //                     </a>
    //                 </div>
    //             </li>
    //             `;
        //                 });

        //                 // Render cart items
        //                 $('.sidebar-cart-list').html(cartHtml);

        //                 // Update subtotal
        //                 $('.cart-total h5.mb-0:nth-child(2)').text(subtotal.toFixed(2) + ' ₹');
        //                 $('.cart-count').text(response.cartItems.length);
        //                 $('.cart-badge-count').text(response.cartItems.length);
        //             }
        //         },
        //         error: function() {
        //             $('.sidebar-cart-list').html('<li>Your cart is empty</li>');
        //             $('.cart-total h5.mb-0:nth-child(2)').text('0 ₹');
        //         }
        //     });
        // }
        var cartItemCount = 0;


        function togglePlaceOrderButton() {
            if (cartItemCount > 0) {
                // enable update button
                $("#updateCartBtn").prop("disabled", false);

                // enable place order (remove disabled CSS)
                $(".place_order").removeClass("disabled-link");

            } else {

                $("#updateCartBtn").prop("disabled", true);

                // disable place order <a> using CSS
                $(".place_order").addClass("disabled-link");
            }
        }


        function updateQuantity(id, qty) {

            let cartData = [{
                id: id,
                quantity: qty
            }];

            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart: cartData
                },
                success: function(response) {
                    if (response.status === "success") {
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
                    if (response.status === "success") {
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
        // wishlist

        // Function to remove item from wishlist
        function removeFromWishlist(id) {
            let productId = id;

            // Correct: use url() + JS dynamic ID
            let toggleUrl = "{{ url('toggle-wishlist') }}/" + encodeURIComponent(productId);

            $.ajax({
                type: "GET",
                url: toggleUrl,
                success: function(response) {
                    // Optional: update wishlist count
                    $(".wishlist-link .badge").text(response.count);
                    $(".wish-count").text(response.count);
                    // Optional toast message
                    loadWishlist(); // ✅ reload AFTER success
                },
                error: function(err) {
                    console.error("Wishlist Error:", err);
                }
            });
        }
        $(document).on("click", ".addToWishlist", function() {
            let productId = $(this).data("id");
            let btn = $(this);

            // Correct: use url() + JS dynamic ID
            let toggleUrl = "{{ url('toggle-wishlist') }}/" + encodeURIComponent(productId);

            $.ajax({
                type: "GET",
                url: toggleUrl,
                success: function(response) {
                    if (response.added) {
                        btn.addClass("active"); // heart filled
                    } else {
                        btn.removeClass("active"); // heart empty
                    }

                    // Optional: update wishlist count
                    $(".wishlist-link .badge").text(response.count);
                    loadWishlist(); // ✅ reload AFTER success
                },
                error: function(err) {
                    console.error("Wishlist Error:", err);
                }
            });
        });

        function applyCategoryFilter(category) {
            window.location.href = "{{ route('productsfilter') }}" + "?category=" + category;
        }


        $(document).ready(function() {

            // Wishlist Button Click
            $('.wishlist-link a').on('click', function() {
                $('#wishlist').tab('show');
            });

            // Cart Button Click
            $('.cart-link a').on('click', function() {
                $('#shopping-cart').tab('show');
            });

        });
    </script>
@endpush
