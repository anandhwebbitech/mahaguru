@extends('layouts.app')

@section('content')
    <style>
        /* MODERN LUXURY BOUTIQUE CSS VARIABLES */
        :root {
            --brand-color: #a81c51;      /* ரிச் மெரூன் / சில்க் பிங்க் */
            --brand-gold: #b38728;       /* பிரீமியம் சில்க் ஜரிகை தங்கம் */
            --light-gold: #fcf8f0;       /* சாஃப்ட் பேக்கிரவுண்ட் தங்கம் */
            --premium-shadow: 0 15px 35px rgba(168, 28, 81, 0.05);
            --smooth-transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* HERO BANNER GRADIENT REFINEMENT */
        .carousel-item {
            position: relative;
        }
        .carousel-item .shadow-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35%;
            background: linear-gradient(to top, rgba(0,0,0,0.35), transparent);
            z-index: 1;
        }

        /* 👑 LUXURY CATEGORIES EXCLUSIVE DESIGN */
        .category-luxury-section {
            padding: 45px 0 25px 0;
            background: #ffffff;
            margin-bottom: 25px;
            position: relative;
        }
        
        /* மைக்ரோ நேவிகேஷன் டேப்கள் (Top 5 Quick Links) */
        .luxury-nav-tabs {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }
        .luxury-nav-tabs .nav-item {
            list-style: none;
        }
        .luxury-nav-tabs .nav-link {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            padding: 8px 18px;
            border-radius: 30px;
            border: 1px solid #eee;
            background: #fff;
            transition: var(--smooth-transition);
            text-decoration: none;
        }
        .luxury-nav-tabs .nav-link:hover,
        .luxury-nav-tabs .nav-item.active .nav-link {
            color: #fff;
            background: var(--brand-color);
            border-color: var(--brand-color);
            box-shadow: 0 8px 16px rgba(168, 28, 81, 0.2);
        }

        /* வட்ட வடிவ ஸ்லைடர் கார்டுகள் */
        .luxury-cat-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            cursor: pointer;
            position: relative;
            transition: var(--smooth-transition);
            text-decoration: none !important;
        }
        
        .luxury-cat-circle {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-gold);
            border: 1px solid rgba(168, 28, 81, 0.06);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
            transition: var(--smooth-transition);
            margin-bottom: 16px;
            overflow: hidden;
        }

        /* சுழலும் ஜரிகை மேஜிக் பார்டர் (Hover-ன் போது மட்டும் தெரியும்) */
        .luxury-cat-circle::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 50%;
            border: 2px dashed var(--brand-gold);
            opacity: 0;
            transform: scale(0.9) rotate(0deg);
            transition: var(--smooth-transition);
            z-index: 1;
        }

        .luxury-cat-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            z-index: 2;
            transition: var(--smooth-transition);
        }

        /* படம் லோட் ஆகாத போது எழுத்துக்கள் சிதறுவதைத் தடுக்கும் FIX */
        .luxury-cat-circle img[alt] {
            text-indent: -10000px;
            background: var(--light-gold);
        }

        .luxury-cat-fallback-icon {
            position: absolute;
            font-size: 28px;
            color: var(--brand-color);
            opacity: 0.4;
            z-index: 1;
        }

        .luxury-cat-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin: 0;
            max-width: 110px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.3s ease;
        }

        /* HOVER & ACTIVE ANIMATION EFFECTS */
        .luxury-cat-card:hover .luxury-cat-circle,
        .luxury-cat-card.active .luxury-cat-circle {
            transform: translateY(-8px);
            background: #ffffff;
            box-shadow: 0 15px 30px rgba(168, 28, 81, 0.12);
        }

        .luxury-cat-card:hover .luxury-cat-circle::after,
        .luxury-cat-card.active .luxury-cat-circle::after {
            opacity: 1;
            transform: scale(1);
            animation: luxuryOrbit 15s linear infinite;
        }

        .luxury-cat-card:hover .luxury-cat-circle img,
        .luxury-cat-card.active .luxury-cat-circle img {
            transform: scale(1.08);
        }

        .luxury-cat-card:hover .luxury-cat-title,
        .luxury-cat-card.active .luxury-cat-title {
            color: var(--brand-color);
            font-weight: 700;
        }

        @keyframes luxuryOrbit {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* PREMIUM SHOP CARDS RE-BUILT */
        .shop-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--premium-shadow);
            transition: var(--smooth-transition);
            border: 1px solid rgba(0, 0, 0, 0.04);
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .shop-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(168, 28, 81, 0.1);
        }
        .shop-card .dz-media {
            width: 100%;
            height: 350px;
            overflow: hidden;
            position: relative;
            background: #f7f7f7;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .shop-card .dz-media { height: 250px; }
        }
        .shop-card .dz-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .shop-card:hover .dz-media img {
            transform: scale(1.05);
        }

        /* METADATA OVERLAYS & QUICK VIEW */
        .shop-card .dz-media .shop-meta {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
            opacity: 0;
            transition: var(--smooth-transition);
            z-index: 5;
        }
        .shop-card:hover .dz-media .shop-meta {
            opacity: 1;
        }
        .shop-card .dz-media .shop-meta .btn {
            pointer-events: auto;
            border-radius: 30px;
        }

        /* CARD BADGES POSITION FIX */
        .product-badge-container {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 4;
        }
        .product-badge-container .badge {
            background: var(--brand-color);
            color: #fff;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 4px;
            box-shadow: 0 4px 10px rgba(168, 28, 81, 0.3);
        }

        /* PRICE & TITLE DETAILS STYLING */
        .shop-card .dz-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #fff;
        }
        .shop-card .dz-content .title {
            font-size: 15px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 8px;
        }
        .shop-card .dz-content .title a {
            color: #222;
            text-decoration: none;
            transition: color 0.2s;
        }
        .shop-card .dz-content .title a:hover {
            color: var(--brand-color);
        }
        .shop-card .dz-content .price {
            font-size: 16px;
            font-weight: 700;
            color: var(--brand-color);
            margin: 0;
        }
        .shop-card .dz-content .price del {
            font-size: 13px;
            color: #999;
            font-weight: 400;
            margin-left: 6px;
        }

        /* SECTION HEADINGS */
        .section-heading-box {
            margin-bottom: 30px;
            border-left: 4px solid var(--brand-color);
            padding-left: 15px;
        }
        .section-heading-box .title {
            font-size: 26px;
            font-weight: 700;
            color: #111;
            margin: 0;
        }
        @media (max-width: 768px) {
            .section-heading-box .title { font-size: 20px; }
        }
    </style>

    <div class="page-wraper">
        <div class="page-content bg-light">

            {{-- HERO BANNER CAROUSEL SLIDER --}}
            <div id="heroSlider" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="social-icons">
                    <a href="https://youtube.com/@mahaaguruboutique?si=xx6PGztkZ-MW9kcH" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.facebook.com/share/179dEVSp57/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/mahaaguruboutique?igsh=bmY2YXp1ZDQwaDYz" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>

                <div class="carousel-indicators vertical-indicators">
                    @foreach ($banner as $key => $item)
                        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach ($banner as $key => $item)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="slide-bg" style="background-image:url('{{ asset('public/uploads/banner/' . $item->banner) }}');"></div>
                            <div class="shadow-overlay"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 👑 LUXURY CATEGORIES QUICK NAV & SWIPER INTEGRATION --}}
            @if(isset($categories) && $categories->count() > 0)
            <section class="category-luxury-section">
                <div class="container">
                    
                    {{-- Top 5 Quick Navigation Links --}}
                    <ul class="luxury-nav-tabs">
                        <li class="nav-item tab-link-item active" data-id="">
                            <a class="nav-link" href="{{ route('allProducts') }}">All Categories</a>
                        </li>
                        @foreach ($categories->take(5) as $category)
                            <li class="nav-item tab-link-item" data-id="{{ $category->id }}">
                                <a class="nav-link" href="javascript:void(0)" onclick="applyCategoryTabFilter({{ $category->id }}, this)">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Main Categories Round Slider --}}
                    <div class="swiper swiper-categories">
                        <div class="swiper-wrapper">
                            <!-- All Products Frame -->
                            <div class="swiper-slide">
                                <div class="luxury-cat-card active" id="cat-card-all" data-category="">
                                    <div class="luxury-cat-circle">
                                        <i class="fa-solid fa-border-all luxury-cat-fallback-icon" style="opacity: 1;"></i>
                                    </div>
                                    <p class="luxury-cat-title">All Products</p>
                                </div>
                            </div>
                            
                            @foreach($categories as $cat)
                                <div class="swiper-slide">
                                    <div class="luxury-cat-card" id="cat-card-{{ $cat->id }}" data-category="{{ $cat->id }}">
                                        <div class="luxury-cat-circle">
                                            <i class="fa-solid fa-bag-shopping luxury-cat-fallback-icon"></i>
                                            @if($cat->image)
                                                <img src="{{ asset('public/uploads/categories/' . $cat->image) }}" 
                                                     alt="{{ $cat->name }}"
                                                     onerror="this.style.display='none';">
                                            @endif
                                        </div>
                                        <p class="luxury-cat-title" title="{{ $cat->name }}">{{ $cat->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </section>
            @endif

            {{-- MOST POPULAR PRODUCTS GRID --}}
            <section class="content-inner pt-2">
                <div class="container">
                    <div class="section-heading-box wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="title">Most Popular Products</h2>
                    </div>
                    <div class="clearfix">
                        <ul id="masonry" class="row g-xl-4 g-3 list-unstyled"></ul>
                    </div>
                </div>
            </section>

            {{-- BLOCKBUSTER DEALS CAROUSEL --}}
            <section class="content-inner-2 overflow-hidden pb-5">
                <div class="container">
                    <div class="section-heading-box wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="title">Blockbuster Deals</h2>
                    </div>
                    <div class="swiper swiper-four swiper-visible">
                        <div class="swiper-wrapper" id="discountProductsWrapper"></div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

    <script>
        let productDetailsRoute = "{{ url('/product') }}";
        window.selectedCategory = "";
        let swiperInstance = null;
        let categorySwiper = null;

        $(document).ready(function() {
            fetchProducts();
            fetchDiscountProducts();
            initCategorySlider();

            $(".header-item-search").on("submit", function(e) {
                e.preventDefault();
                fetchProducts();
            });

            let timer;
            $("#productSearch").on("keyup", function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fetchProducts();
                }, 400);
            });

            // Handle Round Circle Click
            $(document).on("click", ".luxury-cat-card", function() {
                let catId = $(this).data("category");
                syncCategorySelection(catId);
            });
        });

        // Tab and Circle Sync Core Mechanism
        function applyCategoryTabFilter(catId, element) {
            syncCategorySelection(catId);
        }

        function syncCategorySelection(catId) {
            // 1. Sync Top Nav Link Tabs
            $(".luxury-nav-tabs .nav-item").removeClass("active");
            if(catId === "" || catId === undefined) {
                $(".luxury-nav-tabs .nav-item[data-id='']").addClass("active");
            } else {
                $(".luxury-nav-tabs .nav-item[data-id='" + catId + "']").addClass("active");
            }

            // 2. Sync Round Slider Cards
            $(".luxury-cat-card").removeClass("active");
            if(catId === "" || catId === undefined) {
                $("#cat-card-all").addClass("active");
            } else {
                $("#cat-card-" + catId).addClass("active");
                // Auto-slide to selected circle element
                if (categorySwiper) {
                    let slideIndex = $("#cat-card-" + catId).closest('.swiper-slide').index();
                    categorySwiper.slideTo(slideIndex, 500);
                }
            }

            window.selectedCategory = catId;
            fetchProducts();
        }

        // SWIPER INITIALIZATION FOR CATEGORIES
        function initCategorySlider() {
            if($('.swiper-categories').length > 0) {
                categorySwiper = new Swiper('.swiper-categories', {
                    slidesPerView: 3,
                    spaceBetween: 12,
                    freeMode: true,
                    observer: true,
                    observeParents: true,
                    breakpoints: {
                        480: { slidesPerView: 4, spaceBetween: 15 },
                        768: { slidesPerView: 5, spaceBetween: 20 },
                        1200: { slidesPerView: 7, spaceBetween: 25 }
                    }
                });
            }
        }

        function generateProductMediaHtml(product) {
            let rawImages = product.images || '';
            let imgKey = '';

            if (rawImages && rawImages !== 'NULL' && rawImages.trim() !== '') {
                imgKey = rawImages.split(',')[0].trim();
            }
            
            if (!imgKey) {
                return `<img src="{{ asset('assets/images/no-image.png') }}" alt="${product.product_name}">`;
            }

            let finalSrc = "{{ asset('public/uploads/products') }}/" + imgKey;
            return `<img src="${finalSrc}" alt="${product.product_name}" onerror="this.onerror=null; this.src='{{ asset('assets/images/no-image.png') }}';">`;
        }

        // Fetch Popular Products Grid
        function fetchProducts() {
            let data = {};
            if ($("#slider-margin-value-min2").length && $("#slider-margin-value-max2").length) {
                let minPrice = parseInt($("#slider-margin-value-min2").text().replace(/[^\d]/g, ''));
                let maxPrice = parseInt($("#slider-margin-value-max2").text().replace(/[^\d]/g, ''));
                if (!isNaN(minPrice) && !isNaN(maxPrice)) {
                    data.min_price = minPrice;
                    data.max_price = maxPrice;
                }
            }

            data.category = window.selectedCategory ?? "";

            if ($("#productSearch").length && $("#productSearch").val().trim() !== "") {
                data.search = $("#productSearch").val().trim();
            }

            $.ajax({
                url: "{{ route('mostfetchProducts') }}",
                type: "GET",
                data: data,
                success: function(response) {
                    let products = response.products;
                    let wishlist = response.wishlist || [];
                    let html = "";

                    if(products.length === 0) {
                        $("#masonry").html('<div class="col-12 text-center py-5 text-muted">No products found in this boutique section.</div>');
                        if ($("#masonry").data('masonry')) { $("#masonry").masonry('destroy'); }
                        return;
                    }

                    products.forEach(product => {
                        let isActive = wishlist.includes(product.id) ? "active" : "";
                        let mediaContent = generateProductMediaHtml(product);

                        html += `
                        <li class="card-container col-6 col-md-4 col-lg-3">
                            <div class="shop-card">
                                ${product.discount > 0 ? `
                                <div class="product-badge-container">
                                    <span class="badge">-${parseInt(product.discount)}%</span>
                                </div>` : ''}
                                <div class="dz-media" onclick="window.location.href='${productDetailsRoute}/${product.id}'">
                                     ${mediaContent}
                                    <div class="shop-meta">
                                        <a href="${productDetailsRoute}/${product.id}" class="btn btn-secondary btn-sm">
                                            <i class="fa-solid fa-eye"></i> Quick View
                                        </a>
                                        <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}" data-id="${product.id}" id="wishlist-btn-${product.id}">
                                            <i class="icon feather icon-heart dz-heart"></i>
                                            <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dz-content">
                                    <h5 class="title"><a href="${productDetailsRoute}/${product.id}">${product.product_name}</a></h5>
                                    <h6 class="price">
                                        ₹${parseFloat(product.discount_price).toFixed(2)}
                                        ${product.price > product.discount_price ? `<del>₹${parseFloat(product.price).toFixed(2)}</del>` : ''}
                                    </h6>
                                </div>
                            </div>
                        </li>`;
                    });

                    let $container = $("#masonry");
                    $container.html(html);
                    $container.imagesLoaded(function() {
                        if ($container.data('masonry')) { $container.masonry('destroy'); }
                        $container.masonry({ itemSelector: '.card-container', percentPosition: true, horizontalOrder: true });
                    });
                }
            });
        }

        // Fetch Blockbuster Deals Carousel Pipeline
        function fetchDiscountProducts() {
            $.ajax({
                url: "{{ route('products.discount') }}",
                method: "GET",
                success: function(response) {
                    let html = '';
                    let products = Array.isArray(response) ? response : (response.products || []);
                    let wishlist = response.wishlist || [];

                    if (!products || products.length === 0) {
                        $('#discountProductsWrapper').html('<div class="text-center py-5 text-muted col-12">No blockbuster deals available.</div>');
                        return;
                    }

                    products.forEach((product, index) => {
                        let isActive = wishlist.includes(product.id) ? "active" : "";
                        let mediaContent = generateProductMediaHtml(product);
                        
                        let rawPrice = product.price ?? (product.variants && product.variants[0] ? product.variants[0].price : 0);
                        let rawDiscountPrice = product.discount_price ?? (product.variants && product.variants[0] ? product.variants[0].discount_price : rawPrice);
                        let discountPercent = product.discount ?? (product.variants && product.variants[0] ? product.variants[0].discount_percentage : 0);

                        html += `
                        <div class="swiper-slide">
                            <div class="shop-card">
                                ${parseInt(discountPercent) > 0 ? `
                                <div class="product-badge-container">
                                    <span class="badge">Save ${parseInt(discountPercent)}%</span>
                                </div>` : ''}
                                <div class="dz-media" onclick="window.location.href='${productDetailsRoute}/${product.id}'">
                                    ${mediaContent}
                                    <div class="shop-meta">
                                        <a href="${productDetailsRoute}/${product.id}" class="btn btn-secondary btn-sm">
                                            <i class="fa-solid fa-eye"></i> Quick View
                                        </a>
                                        <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}" data-id="${product.id}" id="discount-wishlist-btn-${product.id}">
                                            <i class="icon feather icon-heart dz-heart"></i>
                                            <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dz-content">
                                    <h5 class="title"><a href="${productDetailsRoute}/${product.id}">${product.product_name}</a></h5>
                                    <h6 class="price">
                                        ₹${parseFloat(rawDiscountPrice).toFixed(2)}
                                        ${parseFloat(rawPrice) > parseFloat(rawDiscountPrice) ? `<del>₹${parseFloat(rawPrice).toFixed(2)}</del>` : ''}
                                    </h6>
                                </div>
                            </div>
                        </div>`;
                    });

                    if (swiperInstance) { swiperInstance.destroy(true, true); swiperInstance = null; }
                    $('#discountProductsWrapper').html(html);

                    setTimeout(function() {
                        swiperInstance = new Swiper('.swiper-four', {
                            slidesPerView: 2,
                            spaceBetween: 15,
                            loop: products.length > 4,
                            autoplay: { delay: 3500, disableOnInteraction: false },
                            observer: true,       
                            observeParents: true,
                            breakpoints: {
                                768: { slidesPerView: 3, spaceBetween: 20 },
                                1200: { slidesPerView: 4, spaceBetween: 24 }
                            }
                        });
                    }, 100);
                }
            });
        }
    </script>
@endpush