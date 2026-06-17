@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css">
    <style>
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

        .shop-card .dz-media .shop-meta {
            pointer-events: none;
        }

        .shop-card .dz-media .shop-meta .btn,
        .shop-card .dz-media .shop-meta .meta-icon {
            pointer-events: auto;
        }

        #categoryFilter .cat-item, #materialFilter .mat-item {
            cursor: pointer;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        #categoryFilter .cat-item a, #materialFilter .mat-item a {
            color: #333;
            display: block;
            text-decoration: none;
        }

        #categoryFilter .cat-item.active, #materialFilter .mat-item.active {
            background: #000;
        }

        #categoryFilter .cat-item.active a, #materialFilter .mat-item.active a {
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
                        
                        {{-- <div class="widget">
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
                        </div> --}}

                        <div class="widget widget_categories style-1">
                            <h5 class="widget-title">Category</h5>
                            <ul id="categoryFilter">
                                <li class="cat-item active" data-category="">
                                    <a href="javascript:void(0)">All Categories</a>
                                </li>
                                @foreach ($categories as $category)
                                    <li class="cat-item" data-category="{{ $category->id }}">
                                        <a href="javascript:void(0)">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="widget widget_categories style-1 mt-4">
                            <h5 class="widget-title">Material</h5>
                            <ul id="materialFilter">
                                <li class="mat-item active" data-material="">
                                    <a href="javascript:void(0)">All Materials</a>
                                </li>
                                @foreach ($materials as $material)
                                    <li class="mat-item" data-material="{{ $material->id }}">
                                        <a href="javascript:void(0)">{{ ucfirst($material->name) }}</a>
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
        window.selectedMaterial = "";
        let productDetailsRoute = "{{ url('/product') }}";

        $(document).ready(function() {
            fetchProducts();
            initPriceSlider();
        });

        function initPriceSlider() {
            let slider = document.getElementById('slider-tooltips2');
            if (!slider) {
                fetchProducts();
                return;
            }

            // Create noUiSlider instance
            noUiSlider.create(slider, {
                start: [0, 50000],
                connect: true,
                step: 50,
                range: { 'min': 0, 'max': 100000 }
            });

            let minSpan = document.getElementById('slider-margin-value-min2');
            let maxSpan = document.getElementById('slider-margin-value-max2');

            // ஸ்லைடர் நகரும்போது டெக்ஸ்ட் அப்டேட் ஆகும்
            slider.noUiSlider.on('update', function(values) {
                if(minSpan) minSpan.innerHTML = '₹' + Math.round(values[0]);
                if(maxSpan) maxSpan.innerHTML = '₹' + Math.round(values[1]);
            });
            slider.noUiSlider.on('change', function() {
                fetchProducts();
            });
            fetchProducts();
        }

        function fetchProducts() {
            let data = {};
            let slider = document.getElementById('slider-tooltips2');

            // 🔥 PRICE MATRIX - noUiSlider இன்ஸ்டன்ஸில் இருந்தே நேரடியாக வேல்யூஸை எடுக்கிறோம்
            if (slider && slider.noUiSlider) {
                let sliderValues = slider.noUiSlider.get(); // ['min_val', 'max_val'] ஆக வரும்
                data.min_price = Math.round(sliderValues[0]);
                data.max_price = Math.round(sliderValues[1]);
            } else {
                // ஃபால்பேக்: ஒருவேளை ஸ்லைடர் இல்லை என்றால் ஸ்பான் டெக்ஸ்டை செக் செய்யும்
                if ($("#slider-margin-value-min2").length && $("#slider-margin-value-max2").length) {
                    let minPrice = parseInt($("#slider-margin-value-min2").text().replace(/[^\d]/g, ''));
                    let maxPrice = parseInt($("#slider-margin-value-max2").text().replace(/[^\d]/g, ''));

                    if (!isNaN(minPrice) && !isNaN(maxPrice)) {
                        data.min_price = minPrice;
                        data.max_price = maxPrice;
                    }
                }
            }

            data.category = window.selectedCategory ?? "";
            data.material = window.selectedMaterial ?? "";

            if ($("#productSearch").length && $("#productSearch").val().trim() !== "") {
                data.search = $("#productSearch").val().trim();
            }

            $.ajax({
                url: "{{ route('fetchProducts') }}",
                type: "GET",
                data: data,
                success: function(response) {
                    let products = response.products;
                    let wishlistRaw = response.wishlist || [];
                    let wishlistArray = Array.isArray(wishlistRaw) ? wishlistRaw.map(Number) : [];
                    let html = "";
                    let $container = $("#masonry");

                    if (!products || products.length === 0) {
                        $container.html('<div class="col-12 text-center py-5 text-muted">No products found matching these filters.</div>');
                        if ($container.data('masonry')) { $container.masonry('destroy'); }
                        return;
                    }

                    products.forEach(product => {
                        let imageUrl = product.thumbnail ? "{{ asset('public/uploads/products') }}/" + product.thumbnail : "{{ asset('assets/images/no-image.png') }}";
                        let isActive = wishlistArray.includes(Number(product.id)) ? "active" : "";

                        html += `
                        <li class="card-container col-6 col-md-4 col-sm-6">
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
                                    </div>
                                </div>
                                <div class="dz-content text-start mt-2">
                                    <h5 class="title"><a href="${productDetailsRoute}/${product.id}">${product.product_name}</a></h5>
                                    <h5 class="price">
                                        ₹${parseFloat(product.discount_price).toFixed(2)}
                                        ${product.price > product.discount_price ? `<span class="text-muted ms-2" style="text-decoration:line-through; font-size: 12px;">₹${parseFloat(product.price).toFixed(2)}</span>` : ''}
                                    </h5>
                                </div>
                                ${product.discount > 0 ? `
                                    <div class="product-tag">
                                        <span class="badge">Get ${parseInt(product.discount)}% Off</span>
                                    </div>` : ''}
                            </div>
                        </li>`;
                    });

                    $container.html(html);
                    
                    if (typeof $.fn.imagesLoaded === 'function' && typeof $.fn.masonry === 'function') {
                        $container.imagesLoaded(function() {
                            if ($container.data('masonry')) { $container.masonry('destroy'); }
                            $container.masonry({ itemSelector: '.card-container', percentPosition: true });
                        });
                    }
                },
                error: function(xhr) {
                    console.error("Pipeline Sync Error: ", xhr.responseText);
                }
            });
        }

        $(".header-item-search").on("submit", function(e) {
            e.preventDefault();
            fetchProducts();
        });

        let timer;
        $("#productSearch").on("keyup", function() {
            clearTimeout(timer);
            timer = setTimeout(fetchProducts, 400);
        });

        $(document).on("click", "#categoryFilter li", function() {
            $("#categoryFilter li").removeClass("active");
            $(this).addClass("active");
            window.selectedCategory = $(this).data("category");
            fetchProducts();
        });

        $(document).on("click", "#materialFilter li", function() {
            $("#materialFilter li").removeClass("active");
            $(this).addClass("active");
            window.selectedMaterial = $(this).data("material");
            fetchProducts(); 
        });
    </script>
@endpush
@endsection