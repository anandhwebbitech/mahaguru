@extends('layouts.app')

@section('content')
    <style>
        /* FIX IMAGE SIZE & OVERLAY INTERACTIONS FOR POPULAR PRODUCTS */
        .shop-card .dz-media {
            width: 100%;
            height: 320px;
            overflow: hidden;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
        }

        .shop-card .dz-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .shop-card:hover .dz-media img {
            transform: scale(1.05);
        }

        /* Pass events cleanly through overlay boundaries safely */
        .shop-card .dz-media .shop-meta {
            pointer-events: none;
            z-index: 10;
        }

        .shop-card .dz-media .shop-meta .btn,
        .shop-card .dz-media .shop-meta .meta-icon,
        .shop-card .dz-media .quick-view-pill {
            pointer-events: auto;
        }
    </style>

    <div class="page-wraper">
        <div class="page-content bg-light">

            {{-- HERO BANNER CAROUSEL SLIDER --}}
            <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
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
                            <div class="shadow"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- MOST POPULAR PRODUCTS GRID --}}
            <section class="content-inner">
                <div class="container">
                    <div class="row justify-content-md-between align-items-start">
                        <div class="col-lg-6 col-md-12">
                            <div class="section-head style-1 m-b30 wow fadeInUp" data-wow-delay="0.2s">
                                <div class="left-content">
                                    <h2 class="title">Most popular products</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <ul id="masonry" class="row g-xl-4 g-3"></ul>
                    </div>
                </div>
            </section>

            {{-- BLOCKBUSTER DEALS CAROUSEL --}}
            <section class="content-inner-2 overflow-hidden pb-5">
                <div class="container">
                    <div class="style-1 wow fadeInUp d-lg-flex justify-content-between" data-wow-delay="0.2s">
                        <div class="left-content">
                            <h2 class="title">Blockbuster deals</h2>
                        </div>
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
        let swiperInstance = null; // Multi-initialization memory loops தடுக்க

        $(document).ready(function() {
            fetchProducts();
            fetchDiscountProducts();

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

            $(document).on("click", ".widget_categories li", function() {
                window.selectedCategory = $(this).data("category");
                fetchProducts();
            });
        });

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

            return `
                <img src="${finalSrc}" 
                    alt="${product.product_name}" 
                    onerror="this.onerror=null; this.src='{{ asset('assets/images/no-image.png') }}';">
            `;
        }
        

        // 1. Fetch Popular Products Grid Pipeline
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
                        $("#masonry").html('<div class="col-12 text-center py-4 text-muted">No products found matching configuration.</div>');
                        return;
                    }

                    products.forEach(product => {
                        let isActive = wishlist.includes(product.id) ? "active" : "";
                        let mediaContent = generateProductMediaHtml(product);

                        html += `
                        <li class="card-container col-6 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="shop-card">
                                <div class="dz-media" onclick="window.location.href='${productDetailsRoute}/${product.id}'">
                                     ${mediaContent}
                                    <div class="shop-meta">
                                        <a href="${productDetailsRoute}/${product.id}" class="btn btn-secondary btn-md btn-rounded">
                                            <i class="fa-solid fa-eye d-md-none d-block"></i>
                                            <span class="d-md-block d-none">Quick View</span>
                                        </a>
                                        <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}" data-id="${product.id}" id="wishlist-btn-${product.id}">
                                            <i class="icon feather icon-heart dz-heart"></i>
                                            <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                        </div>
                                        <div class="btn btn-primary meta-icon dz-carticon addToCart" onclick="event.stopPropagation(); window.location.href='${productDetailsRoute}/${product.id}'">
                                            <i class="flaticon flaticon-basket"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dz-content mt-2">
                                    <h5 class="title"><a href="${productDetailsRoute}/${product.id}">${product.product_name}</a></h5>
                                    <h5 class="price">
                                        ₹${parseFloat(product.discount_price).toFixed(2)}
                                        ${product.price > product.discount_price ? `<span class="text-muted" style="text-decoration:line-through; font-size: 12px; margin-left:5px;">₹${parseFloat(product.price).toFixed(2)}</span>` : ''}
                                    </h5>
                                </div>
                                ${product.discount > 0 ? `
                                <div class="product-tag">
                                    <span class="badge">Get ${parseInt(product.discount)}% Off</span>
                                </div>` : ''}
                            </div>
                        </li>`;
                    });

                    let $container = $("#masonry");
                    $container.html(html);

                    $container.imagesLoaded(function() {
                        if ($container.data('masonry')) {
                            $container.masonry('destroy');
                        }
                        $container.masonry({
                            itemSelector: '.card-container',
                            percentPosition: true,
                            horizontalOrder: true
                        });
                    });
                }
            });
        }

        // 2. Fetch Blockbuster Deals Carousel Pipeline (FIXED & ALIGNED WITH FETCHPRODUCTS)
        function fetchDiscountProducts() {
            $.ajax({
                url: "{{ route('products.discount') }}",
                method: "GET",
                success: function(response) {
                    let html = '';
                    
                    // Safety Check: Response-ல் இருந்து Products மற்றும் Wishlist அரேக்களை பிரிக்கிறோம்
                    let products = Array.isArray(response) ? response : (response.products || []);
                    let wishlist = response.wishlist || [];

                    if (!products || products.length === 0) {
                        $('#discountProductsWrapper').html('<div class="text-center py-4 text-muted col-12">No blockbuster deals available.</div>');
                        return;
                    }

                    products.forEach((product, index) => {
                        // Wishlist-ல் இந்த தயாரிப்பு இருக்கா என செக் செய்து Class செட் செய்கிறோம்
                        let isActive = wishlist.includes(product.id) ? "active" : "";
                        let mediaContent = generateProductMediaHtml(product);
                        
                        // Price fallbacks
                        let rawPrice = product.price ?? (product.variants && product.variants[0] ? product.variants[0].price : 0);
                        let rawDiscountPrice = product.discount_price ?? (product.variants && product.variants[0] ? product.variants[0].discount_price : rawPrice);
                        let discountPercent = product.discount ?? (product.variants && product.variants[0] ? product.variants[0].discount_percentage : 0);

                        // ✅ Aligned UI HTML Structure with fetchProducts (shop-meta overlay buttons)
                        html += `
                        <div class="swiper-slide">
                            <div class="shop-card style-2 wow fadeInUp" data-wow-delay="${0.1 * index}s">
                                <div class="dz-media" onclick="window.location.href='${productDetailsRoute}/${product.id}'">
                                    ${mediaContent}
                                    <div class="shop-meta">
                                        <a href="${productDetailsRoute}/${product.id}" class="btn btn-secondary btn-md btn-rounded">
                                            <i class="fa-solid fa-eye d-md-none d-block"></i>
                                            <span class="d-md-block d-none">Quick View</span>
                                        </a>
                                        <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}" data-id="${product.id}" id="discount-wishlist-btn-${product.id}">
                                            <i class="icon feather icon-heart dz-heart"></i>
                                            <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                        </div>
                                        <div class="btn btn-primary meta-icon dz-carticon addToCart" onclick="event.stopPropagation(); window.location.href='${productDetailsRoute}/${product.id}'">
                                            <i class="flaticon flaticon-basket"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dz-content mt-2">
                                    <div>
                                        ${parseInt(discountPercent) > 0 ? `<span class="sale-title">up to ${parseInt(discountPercent)}% off</span>` : ''}
                                        <h5 class="title"><a href="${productDetailsRoute}/${product.id}">${product.product_name}</a></h5>
                                    </div>
                                    <h6 class="price">
                                        ₹${parseFloat(rawDiscountPrice).toFixed(2)}
                                        ${parseFloat(rawPrice) > parseFloat(rawDiscountPrice) ? `<del style="margin-left: 5px;">₹${parseFloat(rawPrice).toFixed(2)}</del>` : ''}
                                    </h6>
                                </div>
                            </div>
                        </div>`;
                    });

                    // Swiper நினைவகத்தை பாதுகாப்பாக ரீசெட் செய்கிறோம்
                    if (swiperInstance) {
                        swiperInstance.destroy(true, true);
                        swiperInstance = null;
                    }

                    $('#discountProductsWrapper').html(html);

                    // Swiper Initialization
                    setTimeout(function() {
                        swiperInstance = new Swiper('.swiper-four', {
                            slidesPerView: 1,
                            spaceBetween: 20,
                            loop: products.length > 4,
                            autoplay: { delay: 3500, disableOnInteraction: false },
                            observer: true,       
                            observeParents: true,
                            breakpoints: {
                                576: { slidesPerView: 1 },
                                768: { slidesPerView: 2 },
                                992: { slidesPerView: 3 },
                                1200: { slidesPerView: 4 }
                            }
                        });
                    }, 100);
                },
                error: function(xhr) {
                    console.error("Discount products fetching pipeline failed: ", xhr);
                }
            });
        }
    </script>
@endpush