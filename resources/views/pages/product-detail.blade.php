@extends('layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Quantity Buttons */
        .qty-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .qty-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #000;
            color: #fff;
            border: none;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .qty-input {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid #000;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        /* Size Design Round Selectors */
        .product-size-wrapper .size-option {
            margin-right: 10px;
        }

        .product-size-wrapper input[type="radio"] {
            display: none;
        }

        .product-size-wrapper .size-label {
            min-width: 44px;
            height: 44px;
            padding: 0 10px;
            border-radius: 22px;
            border: 2px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .product-size-wrapper input[type="radio"]:checked+.size-label {
            background: #000;
            color: #fff;
            border-color: #000;
            transform: scale(1.05);
        }

        .product-size-wrapper input[type="radio"]:disabled+.size-label {
            background: #f5f5f5;
            color: #ccc;
            border-color: #ddd;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* Color Dots */
        .color-filter .form-check {
            margin-right: 12px;
            position: relative;
        }

        .color-filter .form-check-input {
            display: none;
        }

        .color-option {
            margin-right: 10px;
        }

        .color-option input {
            display: none;
        }

        .color-option .color-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid #ccc;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .color-option input:checked+.color-circle {
            border: 3px solid #000;
            transform: scale(1.1);
        }

        /* FIX: Swiper Container Layout Constraints */
        .swiper-container-wrapper {
            width: 100%;
            max-width: 100%;
            overflow: hidden; /* Prevents thumbnails from leaking out horizontally */
        }

        .product-gallery-swiper.thumb-swiper-lg {
            width: 100%;
            margin-top: 12px;
            overflow: hidden;
        }

        .product-gallery-swiper.thumb-swiper-lg .swiper-slide {
            opacity: 0.5;
            transition: opacity 0.2s ease;
        }

        .product-gallery-swiper.thumb-swiper-lg .swiper-slide-thumb-active {
            opacity: 1;
            border: 1px solid #000 !important;
        }
    </style>
    
    <div id="productDetailContainer" data-variants="{{ json_encode($product->variants) }}">
        <section class="content-inner py-5">
            <div class="container">
                {{-- UPPER PRODUCT INFO SECTION --}}
                <div class="row g-4">
                    {{-- LEFT SIDE: IMAGES & THUMBNAILS --}}
                    <div class="col-lg-5 col-md-6">
                        <div class="dz-product-detail sticky-top" style="top: 20px;">
                            <div class="swiper-container-wrapper">
                                {{-- MAIN BIG IMAGE SLIDER --}}
                                <div class="swiper product-gallery-swiper2 rounded mb-3 border">
                                    <div class="swiper-wrapper" id="mainSliderWrapper">
                                        @foreach ($baseImages as $img)
                                            <div class="swiper-slide">
                                                <div class="dz-media DZoomImage text-center p-2">
                                                    <img src="{{ asset('public/uploads/products/' . $img) }}" alt="Product Image" class="img-fluid rounded max-auto" style="max-height: 450px; object-fit: contain;">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- THUMBNAILS --}}
                                <div class="swiper product-gallery-swiper thumb-swiper-lg">
                                    <div class="swiper-wrapper" id="thumbSliderWrapper">
                                        @foreach ($baseImages as $img)
                                            <div class="swiper-slide" style="width: 80px; cursor: pointer;">
                                                <img src="{{ asset('public/uploads/products/' . $img) }}" alt="Thumbnail" class="img-fluid rounded border p-1 bg-white">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- RIGHT SIDE: PURCHASE CONFIGURATIONS --}}
                    <div class="col-lg-7 col-md-6">
                        <div class="dz-product-detail style-2 ps-lg-4">
                            <div class="dz-content">
                                {{-- CATEGORY BREADCRUMB --}}
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-2 text-uppercase fs-7 fw-semibold tracking-wide text-secondary">
                                        <li class="breadcrumb-item"><span class="text-dark">{{ $product->category->name ?? 'General' }}</span></li>
                                        @if(!empty($product->subCategory))
                                            <li class="breadcrumb-item active text-warning" aria-current="page">{{ $product->subCategory->name }}</li>
                                        @endif
                                    </ol>
                                </nav>
                                @if ($product->discount > 0)
                                    <span class="badge bg-danger mb-2">
                                        SALE {{ rtrim(rtrim($product->discount, '0'), '.') }}% Off
                                    </span>
                                @endif
                                <h2 class="title mb-2 fw-bold text-dark">{{ $product->product_name }}</h2>
                                
                                {{-- RATINGS & REVIEWS --}}
                                @php $rating = round($avgRating ?? 0, 1); @endphp
                                <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
                                    <div class="text-warning fs-5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= round($rating) ? '★' : '☆' }}
                                        @endfor
                                    </div>
                                    <span class="text-dark fw-semibold ms-1">{{ $rating }}</span>
                                    <span class="text-muted">|</span>
                                    <a href="javascript:void(0);" class="review-link text-decoration-none text-secondary" data-bs-toggle="modal" data-bs-target="#reviewsModal">
                                        ({{ $reviewCount }} Customer Reviews)
                                    </a>
                                </div>

                                {{-- OPTIONS FOR COLOR AND SIZE --}}
                                <div class="options-selection-block">
                                    {{-- COLOR SELECTION --}}
                                    @if (count($uniqueColors) > 0)
                                        <div class="meta-content mb-4">
                                            <label class="form-label d-block fw-bold text-dark uppercase mb-2">Color</label>
                                            <div class="d-flex align-items-center color-filter flex-wrap">
                                                @foreach ($uniqueColors as $index => $clr)
                                                    <div class="form-check color-option ps-0">
                                                        <input type="radio" class="color-radio-select" name="productColor" id="color{{ $index }}" value="{{ $clr['id'] }}" data-color-name="{{ $clr['name'] }}" {{ $index == 0 ? 'checked' : '' }}>
                                                        <label for="color{{ $index }}">
                                                            <span class="color-circle shadow-sm" style="background: {{ $clr['code'] }};" title="{{ $clr['name'] }}"></span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- SIZE SELECTION --}}
                                    <div class="meta-content mb-4" id="sizeSelectionSection">
                                        <label class="form-label d-block fw-bold text-dark mb-2">Size / Packaging</label>
                                        <div class="d-flex align-items-center product-size-wrapper flex-wrap gap-2" id="dynamicSizesContainer">
                                            {{-- Will be loaded dynamically --}}
                                        </div>
                                    </div>

                                    {{-- QUANTITY SELECTOR --}}
                                    <div class="product-num mb-4">
                                        <label class="form-label d-block fw-bold text-dark mb-2">Quantity</label>
                                        <div class="qty-box">
                                            <button type="button" class="qty-btn shadow-sm" id="qtyMinus">−</button>
                                            <input type="text" value="1" id="qtyInput" class="qty-input bg-white" readonly>
                                            <button type="button" class="qty-btn shadow-sm" id="qtyPlus">+</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- PRICING & CALL TO ACTIONS --}}
                                <div class="cart-detail p-4 bg-light rounded border mt-4 shadow-sm">
                                    <table class="table table-borderless mb-3">
                                        <tbody>
                                            <tr>
                                                <td><span class="text-secondary fs-6"> Price</span></td>
                                                <td class="text-end fw-semibold text-dark fs-6" id="displayUnitPrice">₹0.00</td>
                                            </tr>
                                            <tr class="total border-top">
                                                <td class="pt-2">
                                                    <h5 class="mb-0 fw-bold text-dark">Subtotal</h5>
                                                </td>
                                                <td class="text-end pt-2 fw-bold text-dark fs-4" id="totalAmount">₹0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <input type="hidden" id="selectedVariantId" value="">

                                    <div class="row g-2">
                                        @php $isActive = in_array($product->id, $wishlistProductIds) ? 'active' : ''; @endphp
                                        @if (!auth()->check() || auth()->user()->role != 1)
                                            <div class="col-sm-4">
                                                <button type="button" class="btn btn-outline-dark w-100 py-2.5 addToWishlist {{ $isActive }}" data-id="{{ $product->id }}">
                                                    ♥ Wishlist
                                                </button>
                                            </div>
                                            <div class="col-sm-8">
                                                <button type="button" id="addToCartButton" class="btn btn-warning w-100 py-2.5 fw-bold btn-addto-cart text-uppercase">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">
                <div class="row">
                    <div class="col-12">
                        <div class="product-description-tabs bg-white p-4 rounded border shadow-sm">
                            <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">Product Specifications & Description</h4>
                            
                            {{-- SHORT DESCRIPTION DISPLAY --}}
                            @if (!empty($product->short_description))
                                <div class="product-short-description mb-4">
                                    <p class="text-secondary mb-0 border-start border-warning border-3 ps-3 italic" style="font-size: 16px;">
                                        {{ $product->short_description }}
                                    </p>
                                </div>
                            @endif

                            {{-- MAIN PRODUCT DESCRIPTION --}}
                            @if ($product->description)
                                <div class="main-description-block mb-4">
                                    <p class="para-text text-muted" style="line-height: 1.8; font-size: 15px; text-align: justify;">
                                        {!! nl2br(e($product->description)) !!}
                                    </p>
                                </div>
                            @endif

                            {{-- METADATA INFO TABLE --}}
                            <div class="table-responsive mt-3" style="max-width: 500px;">
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light px-3 py-2 text-secondary" style="width: 40%;">Category</th>
                                            <td class="px-3 py-2 fw-semibold">{{ $product->category->name ?? '-' }}</td>
                                        </tr>
                                        @if(!empty($product->subCategory))
                                        <tr>
                                            <th class="bg-light px-3 py-2 text-secondary">Sub Category</th>
                                            <td class="px-3 py-2 fw-semibold">{{ $product->subCategory->name }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- REVIEWS MODAL --}}
    <div class="modal fade" id="reviewsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Customer Reviews</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @forelse($reviews as $review)
                        <div class="border-bottom py-3">
                            <strong>{{ $review->user->name ?? 'Verified Buyer' }}</strong>
                            <div class="text-warning mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </div>
                            <p class="mb-0 text-secondary">{{ $review->review }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No reviews yet for this product.</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            const assetBaseUrl = "{{ asset('public/uploads/products/') }}/";
            const baseImages = @json($baseImages);
            const variants = JSON.parse($('#productDetailContainer').attr('data-variants') || "[]");
            
            const qtyInput = $("#qtyInput");
            const displayUnitPrice = $("#displayUnitPrice");
            const totalAmount = $("#totalAmount");
            const dynamicSizesContainer = $("#dynamicSizesContainer");
            const selectedVariantId = $("#selectedVariantId");

            let currentActivePrice = 0;
            let mainSwiper = null;
            let thumbSwiper = null;

            // Initialize Swiper instances safely
            function initSwiperSliders() {
                // Destroy old instances before rebuilding structural layouts
                if (mainSwiper) mainSwiper.destroy(true, true);
                if (thumbSwiper) thumbSwiper.destroy(true, true);

                thumbSwiper = new Swiper('.thumb-swiper-lg', {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                });

                mainSwiper = new Swiper('.product-gallery-swiper2', {
                    spaceBetween: 10,
                    thumbs: {
                        swiper: thumbSwiper,
                    },
                });
            }

            function updateSliderImages(imageArray) {
                const mainWrapper = $("#mainSliderWrapper");
                const thumbWrapper = $("#thumbSliderWrapper");
                mainWrapper.empty();
                thumbWrapper.empty();

                imageArray.forEach(img => {
                    if (!img) return;
                    const fullImgUrl = assetBaseUrl + img.trim();
                    mainWrapper.append(`
                        <div class="swiper-slide">
                            <div class="dz-media DZoomImage text-center p-2">
                                <img src="${fullImgUrl}" alt="Product Image" class="img-fluid rounded" style="max-height: 450px; object-fit: contain;">
                            </div>
                        </div>
                    `);

                    thumbWrapper.append(`
                        <div class="swiper-slide" style="width: 80px; cursor: pointer;">
                            <img src="${fullImgUrl}" alt="Thumbnail" class="img-fluid rounded border p-1 bg-white">
                        </div>
                    `);
                });

                // Re-initialize Swiper configurations matching updated contents
                if (typeof Swiper !== 'undefined') {
                    setTimeout(() => {
                        initSwiperSliders();
                    }, 50);
                }
            }

            function handleColorChangeSelection() {
                const selectedColorRadio = $('input[name="productColor"]:checked');
                if (!selectedColorRadio.length) return;
                const targetColorId = selectedColorRadio.val();
                
                const matchingVariants = variants.filter(v =>
                    String(v.color_id) === String(targetColorId) ||
                    String(v.color_name) === String(targetColorId) ||
                    (v.color && String(v.color.id) === String(targetColorId))
                );

                dynamicSizesContainer.empty();

                if (matchingVariants.length === 0) {
                    $('#sizeSelectionSection').hide();
                    return;
                }
                $('#sizeSelectionSection').show();

                let variantImages = [];

                matchingVariants.forEach((variant, index) => {
                    const sizeName = variant.size ? variant.size.name : (variant.size_name || 'Standard');
                    const sizeValueId = variant.size_id ? variant.size_id : sizeName;
                    const isChecked = index === 0 ? 'checked' : '';

                    if (variant.thumbnail) {
                        if (typeof variant.thumbnail === 'string') {
                            if (variant.thumbnail.startsWith('[')) {
                                try {
                                    const parsedImages = JSON.parse(variant.thumbnail);
                                    if (Array.isArray(parsedImages)) {
                                        variantImages = variantImages.concat(parsedImages);
                                    }
                                } catch (e) {
                                    variantImages.push(variant.thumbnail);
                                }
                            } else if (variant.thumbnail.includes(',')) {
                                const splitStrings = variant.thumbnail.split(',');
                                variantImages = variantImages.concat(splitStrings);
                            } else {
                                variantImages.push(variant.thumbnail);
                            }
                        } else if (Array.isArray(variant.thumbnail)) {
                            variantImages = variantImages.concat(variant.thumbnail);
                        }
                    }

                    dynamicSizesContainer.append(`
                        <div class="size-option">
                            <input type="radio" name="productSize" class="size-radio-select" 
                                id="sizeAttr${index}" value="${sizeValueId}" data-variant-id="${variant.id}" 
                                data-price="${variant.price}" data-discount-price="${variant.discount_price || 0}" ${isChecked}>
                            <label class="size-label" for="sizeAttr${index}">${sizeName}</label>
                        </div>
                    `);
                });

                variantImages = variantImages.map(img => typeof img === 'string' ? img.trim() : img).filter(Boolean);

                if (variantImages.length > 0) {
                    variantImages = [...new Set(variantImages)];
                    updateSliderImages(variantImages);
                } else {
                    updateSliderImages(baseImages);
                }

                handleSizeChangeSelection();
            }

            function handleSizeChangeSelection() {
                const activeSizeRadio = $('input[name="productSize"]:checked');
                if (!activeSizeRadio.length) return;

                const varId = activeSizeRadio.attr('data-variant-id');
                const basePrice = parseFloat(activeSizeRadio.attr('data-price')) || 0;
                const discountPrice = parseFloat(activeSizeRadio.attr('data-discount-price')) || 0;

                currentActivePrice = discountPrice > 0 ? discountPrice : basePrice;

                selectedVariantId.val(varId);
                displayUnitPrice.text("₹" + currentActivePrice.toFixed(2));

                updateTotalCalculation();

                const currentVariant = variants.find(v => String(v.id) === String(varId));
                if (currentVariant && currentVariant.thumbnail) {
                    let extractedThumbs = [];
                    
                    if (typeof currentVariant.thumbnail === 'string') {
                        if (currentVariant.thumbnail.startsWith('[')) {
                            try { extractedThumbs = JSON.parse(currentVariant.thumbnail); } catch(e) {}
                        } else if (currentVariant.thumbnail.includes(',')) {
                            extractedThumbs = currentVariant.thumbnail.split(',');
                        } else {
                            extractedThumbs.push(currentVariant.thumbnail);
                        }
                    } else if (Array.isArray(currentVariant.thumbnail)) {
                        extractedThumbs = currentVariant.thumbnail;
                    }

                    extractedThumbs = extractedThumbs.map(img => typeof img === 'string' ? img.trim() : img).filter(Boolean);

                    if (extractedThumbs.length > 0) {
                        const uniqueUpdatedGallery = [...new Set([...extractedThumbs, ...baseImages])];
                        updateSliderImages(uniqueUpdatedGallery);
                    }
                }
            }

            function updateTotalCalculation() {
                let qty = parseInt(qtyInput.val()) || 1;
                let continuousTotal = qty * currentActivePrice;
                totalAmount.html("₹" + continuousTotal.toFixed(2));
            }

            // UI Elements Event Bindings
            $(document).on('change', '.color-radio-select', function() {
                handleColorChangeSelection();
            });

            $(document).on('change', '.size-radio-select', function() {
                handleSizeChangeSelection();
            });

            $("#qtyPlus").on("click", function() {
                qtyInput.val(parseInt(qtyInput.val()) + 1);
                updateTotalCalculation();
            });

            $("#qtyMinus").on("click", function() {
                let qty = parseInt(qtyInput.val());
                if (qty > 1) {
                    qtyInput.val(qty - 1);
                    updateTotalCalculation();
                }
            });

            // Cart Pipeline AJAX
            $('.btn-addto-cart').click(function(e) {
                e.preventDefault();

                var product_id = "{{ $product->id }}";
                var variant_id = selectedVariantId.val();
                var quantity = qtyInput.val();
                var colorName = $('input[name="productColor"]:checked').attr('data-color-name') || '';
                var sizeName = $('input[name="productSize"]:checked').parent().find('.size-label').text() || '';
                var total = totalAmount.text().replace('₹', '').trim();

                if (!variant_id) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Selection Missing',
                        text: 'Please choose a valid configuration.'
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('cart.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: product_id,
                        variant_id: variant_id,
                        quantity: quantity,
                        size: sizeName,
                        color: colorName,
                        total: total
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Adding to Cart...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Login Required',
                                text: 'Please login to continue processing',
                                confirmButtonText: 'Login'
                            }).then(() => {
                                window.location.href = "{{ route('login') }}";
                            });
                            return;
                        }
                        let message = 'Something went wrong processing your request.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({ icon: 'error', title: 'Error', text: message });
                    }
                });
            });

            // Initial Layout Trigger
            handleColorChangeSelection();
        });
    </script>
@endpush
@endsection