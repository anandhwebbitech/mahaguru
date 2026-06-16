@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css">
    <style>
        /* FIX IMAGE SIZE & OVERLAY INTERACTIONS */
        .shop-card .dz-media {
            width: 100%;
            height: 320px;
            overflow: hidden;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            /* Makes the entire image area look clickable */
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

        /* 🔥 THE SECRET SAUCE:
               We make the overlay container pass click events through to the parent/image,
               but turn pointer-events back ON for the inner buttons so they stay clickable!
            */
        .shop-card .dz-media .shop-meta {
            pointer-events: none;
        }

        .shop-card .dz-media .shop-meta .btn,
        .shop-card .dz-media .shop-meta .meta-icon {
            pointer-events: auto;
        }

        #categoryFilter .cat-item {
            cursor: pointer;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        #categoryFilter .cat-item a {
            color: #333;
            display: block;
            text-decoration: none;
        }

        #categoryFilter .cat-item.active {
            background: #000;
        }

        #categoryFilter .cat-item.active a {
            color: #fff !important;
            font-weight: 600;
        }
    </style>

    <section class="content-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12">
                    <aside class="side-bar left sticky-top m-b30">
                        <h5 class="widget-title">Sort by</h5>
                        <div class="widget">
                            <h6 class="widget-title">Price</h6>
                            <div class="price-slide range-slider">
                                <div class="price">
                                    <div class="range-slider style-1">
                                        <div id="slider-tooltips2" class="mb-3"></div>
                                        <span class="example-val" id="slider-margin-value-min2"></span>
                                        <span class="example-val" id="slider-margin-value-max2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget widget_categories style-1">
                            <h5 class="widget-title">Category</h5>
                            <ul id="categoryFilter">
                                <li class="cat-item active" data-category="">
                                    <a href="javascript:void(0)">All</a>
                                </li>
                                @foreach ($categories as $category)
                                    <li class="cat-item" data-category="{{ $category->id }}">
                                        <a href="javascript:void(0)">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-md-8 col-12">
                    <div class="clearfix">
                        <ul id="masonry" class="row g-3">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>

        <script>
            window.selectedCategory = "";
            let productDetailsRoute = "{{ url('/product') }}";

            $(document).ready(function() {
                fetchProducts();
            });

            function fetchProducts() {
                let data = {};

                // PRICE FILTER
                if ($("#slider-margin-value-min2").length && $("#slider-margin-value-max2").length) {
                    let minText = $("#slider-margin-value-min2").text().trim();
                    let maxText = $("#slider-margin-value-max2").text().trim();

                    let minPrice = parseInt(minText.replace(/[^\d]/g, ''));
                    let maxPrice = parseInt(maxText.replace(/[^\d]/g, ''));

                    if (!isNaN(minPrice) && !isNaN(maxPrice)) {
                        data.min_price = minPrice;
                        data.max_price = maxPrice;
                    }
                }

                // CATEGORY
                data.category = window.selectedCategory ?? "";

                // SEARCH
                if ($("#productSearch").length) {
                    let search = $("#productSearch").val();
                    if (search && search.trim() !== "") {
                        data.search = search.trim();
                    }
                }

                $.ajax({
                    url: "{{ route('fetchProducts') }}",
                    type: "GET",
                    data: data,
                    success: function(response) {
                        let products = response.products;
                        let wishlist = response.wishlist || [];
                        let html = "";

                        products.forEach(product => {
                            let imageUrl = product.thumbnail ?
                                "{{ asset('public/uploads/products') }}/" + product.thumbnail.split(",")[0] :
                                "{{ asset('assets/images/no-image.png') }}";

                            let isActive = wishlist.includes(product.id) ? "active" : "";

                            // Safely extract price ranges from active relational variants matrix
                            let displayPrice = 0;
                            let strikePrice = 0;

                            if (product.variants && product.variants.length > 0) {
                                let firstVariant = product.variants[0];
                                displayPrice = firstVariant.discount_price > 0 ? firstVariant
                                    .discount_price : firstVariant.price;
                                strikePrice = firstVariant.discount_price > 0 ? firstVariant.price : 0;
                            } else {
                                displayPrice = product.price || 0;
                            }

                            html += `
    <li class="card-container col-6 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.6s">
        <div class="shop-card">
            <div class="dz-media" onclick="window.location.href='${productDetailsRoute}/${product.id}'">
                <img src="${imageUrl}" alt="${product.product_name}">
                <div class="shop-meta">
                    <a href="${productDetailsRoute}/${product.id}" class="btn btn-secondary btn-md btn-rounded">
                        <i class="fa-solid fa-eye d-md-none d-block"></i>
                        <span class="d-md-block d-none">Quick View</span>
                    </a>
                    <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}"
                        data-id="${product.id}" id="wishlist-btn-${product.id}">
                        <i class="icon feather icon-heart dz-heart"></i>
                        <i class="icon feather icon-heart-on dz-heart-fill"></i>
                    </div>
                    <div class="btn btn-primary meta-icon dz-carticon addToCart"
                         onclick="window.location.href='${productDetailsRoute}/${product.id}'">
                        <i class="flaticon flaticon-basket"></i>
                    </div>
                </div>
            </div>
            <div class="dz-content">
                <h5 class="title"><a href="${productDetailsRoute}/${product.id}">${product.product_name}</a></h5>
                <h5 class="price">
                    ₹${parseFloat(displayPrice).toFixed(2)}
                    ${strikePrice > 0 ? `<span class="text-muted" style="text-decoration:line-through; font-size: 12px;">₹${parseFloat(strikePrice).toFixed(2)}</span>` : ''}
                </h5>
            </div>
            ${product.discount > 0 ? `
                    <div class="product-tag">
                        <span class="badge">Get ${parseInt(product.discount)}% Off</span>
                    </div>` : ''}
        </div>
    </li>`;
                        });

                        $("#masonry").html(html);
                    }
                });
            }

            // Prevent form submit reload on enter key
            $(".header-item-search").on("submit", function(e) {
                e.preventDefault();
                fetchProducts();
            });

            // Debounced Search Keyup Event
            let timer;
            $("#productSearch").on("keyup", function(e) {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fetchProducts();
                }, 400);
            });

            // noUiSlider Initialization
            document.addEventListener('DOMContentLoaded', function() {
                let slider = document.getElementById('slider-tooltips2');
                if (!slider) return;

                noUiSlider.create(slider, {
                    start: [500, 50000],
                    connect: true,
                    step: 100,
                    range: {
                        'min': 0,
                        'max': 100000
                    }
                });

                let minSpan = document.getElementById('slider-margin-value-min2');
                let maxSpan = document.getElementById('slider-margin-value-max2');

                slider.noUiSlider.on('update', function(values) {
                    minSpan.innerHTML = '₹' + Math.round(values[0]);
                    maxSpan.innerHTML = '₹' + Math.round(values[1]);
                });

                slider.noUiSlider.on('change', function() {
                    fetchProducts();
                });
            });

            // Category Selection Logic
            $(document).on("click", "#categoryFilter li", function() {
                $("#categoryFilter li").removeClass("active");
                $(this).addClass("active");
                window.selectedCategory = $(this).data("category");
                fetchProducts();
            });
        </script>
    @endpush
@endsection
