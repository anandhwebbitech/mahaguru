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
        .product-size-wrapper input[type="radio"]:checked + .size-label {
            background: #000;
            color: #fff;
            border-color: #000;
            transform: scale(1.05);
        }
        .product-size-wrapper input[type="radio"]:disabled + .size-label {
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
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid #ccc;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }
        .color-option input:checked + .color-circle {
            border: 3px solid #000;
            transform: scale(1.1);
        }
    </style>

    <div id="productDetailContainer" data-variants="{{ json_encode($product->variants) }}">
        <section class="content-inner py-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="dz-product-detail sticky-top">
                            <div class="swiper-btn-center-lr">
                                {{-- MAIN BIG IMAGE SLIDER --}}
                                <div class="swiper product-gallery-swiper2 rounded mb-2">
                                    <div class="swiper-wrapper" id="lightgallery2">
                                        @foreach ($images as $img)
                                            <div class="swiper-slide">
                                                <div class="dz-media DZoomImage">
                                                    <a class="mfp-link lg-item"
                                                       href="{{ asset('public/uploads/products/' . $img) }}"
                                                       data-src="{{ asset('public/uploads/products/' . $img) }}">
                                                        <i class="feather icon-maximize dz-maximize top-left"></i>
                                                    </a>
                                                    <img src="{{ asset('public/uploads/products/' . $img) }}" alt="Product Image" class="img-fluid">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- THUMBNAILS --}}
                                <div class="swiper product-gallery-swiper thumb-swiper-lg">
                                    <div class="swiper-wrapper">
                                        @foreach ($images as $img)
                                            <div class="swiper-slide" style="width: 80px; cursor: pointer;">
                                                <img src="{{ asset('public/uploads/products/' . $img) }}" alt="Thumbnail" class="img-fluid rounded border">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-md-8">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="dz-product-detail style-2 p-t20 ps-0">
                                    <div class="dz-content">
                                        <div class="dz-content-footer">
                                            <div class="dz-content-start">
                                                @if ($product->discount > 0)
                                                    <span class="badge bg-secondary mb-2">
                                                        SALE {{ rtrim(rtrim($product->discount, '0'), '.') }}% Off
                                                    </span>
                                                @endif
                                                <h4 class="title mb-1"> {{ $product->product_name }} | 
                                                    {{ $product->category->name ?? '-' }}
                                                </h4>
                                                
                                                {{-- SHORT DESCRIPTION DISPLAY --}}
                                                @if (!empty($product->short_description))
                                                    <div class="product-short-description my-2">
                                                        <p class="text-secondary mb-0" style="font-size: 15px; font-style: italic; border-left: 3px solid #ffc107; padding-left: 10px;">
                                                            {{ $product->short_description }}
                                                        </p>
                                                    </div>
                                                @endif

                                                @php $rating = round($avgRating ?? 0, 1); @endphp
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <div class="text-warning">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            {{ $i <= round($rating) ? '★' : '☆' }}
                                                        @endfor
                                                    </div>
                                                    <span class="text-secondary me-2">{{ $rating }} Rating</span>
                                                    <a href="javascript:void(0);" class="review-link" data-bs-toggle="modal" data-bs-target="#reviewsModal">
                                                        ({{ $reviewCount }} customer reviews)
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- MAIN PRODUCT DESCRIPTION DISPLAY --}}
                                        @if ($product->description)
                                            <div class="main-description-block border-top border-bottom py-3 my-3">
                                                <label class="form-label d-block fw-bold text-dark">Product Description</label>
                                                <p class="para-text text-muted mb-0" style="line-height: 1.6; font-size: 14px;">
                                                    {{ $product->description }}
                                                </p>
                                            </div>
                                        @endif

                                        <div class="product-num mt-4">
                                            <label class="form-label d-block fw-bold">Quantity</label>
                                            <div class="qty-box mb-4">
                                                <button type="button" class="qty-btn" id="qtyMinus">−</button>
                                                <input type="text" value="1" id="qtyInput" class="qty-input" readonly>
                                                <button type="button" class="qty-btn" id="qtyPlus">+</button>
                                            </div>

                                            @if(count($uniqueColors) > 0)
                                                <div class="meta-content mb-4">
                                                    <label class="form-label d-block fw-bold">Color</label>
                                                    <div class="d-flex align-items-center color-filter flex-wrap">
                                                        @foreach ($uniqueColors as $index => $clr)
                                                            <div class="form-check color-option ps-0">
                                                                <input type="radio" class="color-radio-select" name="productColor" id="color{{ $index }}" value="{{ $clr['id'] }}" data-color-name="{{ $clr['name'] }}" {{ $index == 0 ? 'checked' : '' }}>
                                                                <label for="color{{ $index }}">
                                                                    <span class="color-circle" style="background: {{ $clr['code'] }};" title="{{ $clr['name'] }}"></span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="meta-content mb-4" id="sizeSelectionSection">
                                                <label class="form-label d-block fw-bold">Size</label>
                                                <div class="d-flex align-items-center product-size-wrapper flex-wrap gap-2" id="dynamicSizesContainer">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dz-info border-top pt-3 mt-3">
                                            <ul class="list-unstyled">
                                                <li><strong>Category:</strong> {{ $product->category->name ?? '-' }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-5">
                                <div class="cart-detail p-3 bg-light rounded border">
                                    <table class="table table-borderless mb-3">
                                        <tbody>
                                            <tr class="mb-2">
                                                <td><span class="text-secondary">Price Each</span></td>
                                                <td class="text-end fw-semibold text-dark" id="displayUnitPrice">₹0.00</td>
                                            </tr>
                                            <tr class="total border-top pt-2">
                                                <td><h6 class="mb-0 fw-bold">Total</h6></td>
                                                <td class="text-end price fw-bold text-dark fs-5" id="totalAmount">₹0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <input type="hidden" id="selectedVariantId" value="">

                                    @php $isActive = in_array($product->id, $wishlistProductIds) ? 'active' : ''; @endphp
                                    @if (!auth()->check() || auth()->user()->role != 1)
                                        <button type="button" class="btn btn-outline-secondary w-100 mb-2 addToWishlist {{ $isActive }}" data-id="{{ $product->id }}">
                                            Add To Wishlist
                                        </button>
                                        <button type="button" id="addToCartButton" class="btn btn-warning w-100 fw-bold btn-addto-cart">ADD TO CART</button>
                                    @endif
                                </div>
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
                    <h5 class="modal-title">Customer Reviews</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @forelse($reviews as $review)
                        <div class="border-bottom py-3">
                            <strong>{{ $review->user->name ?? 'User' }}</strong>
                            <div class="text-warning mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </div>
                            <p class="mb-0 text-secondary">{{ $review->review }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">No reviews yet for this product.</p>
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
                const variants = JSON.parse($('#productDetailContainer').attr('data-variants') || "[]");
                const qtyInput = $("#qtyInput");
                const displayUnitPrice = $("#displayUnitPrice");
                const totalAmount = $("#totalAmount");
                const dynamicSizesContainer = $("#dynamicSizesContainer");
                const selectedVariantId = $("#selectedVariantId");

                let currentActivePrice = 0;

                function handleColorChangeSelection() {
                    const selectedColorRadio = $('input[name="productColor"]:checked');
                    if (!selectedColorRadio.length) return;

                    const targetColorId = selectedColorRadio.val();
                    
                    // Filter matching variants structural checks
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

                    // Map all variants details loop safely
                    matchingVariants.forEach((variant, index) => {
                        const sizeName = variant.size ? variant.size.name : (variant.size_name || 'Standard');
                        const sizeValueId = variant.size_id ? variant.size_id : sizeName;
                        const isChecked = index === 0 ? 'checked' : '';
                        
                        const sizeHtml = `
                            <div class="size-option">
                                <input type="radio" name="productSize" class="size-radio-select" 
                                    id="sizeAttr${index}" value="${sizeValueId}" data-variant-id="${variant.id}" 
                                    data-price="${variant.price}" data-discount-price="${variant.discount_price || 0}" ${isChecked}>
                                <label class="size-label" for="sizeAttr${index}">${sizeName}</label>
                            </div>
                        `;
                        dynamicSizesContainer.append(sizeHtml);
                    });

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
                }

                function updateTotalCalculation() {
                    let qty = parseInt(qtyInput.val()) || 1;
                    let continuousTotal = qty * currentActivePrice;
                    totalAmount.html("₹" + continuousTotal.toFixed(2));
                }

                // Listeners Layout Bindings
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

                // AJAX Pipeline Submission
                $('.btn-addto-cart').click(function(e) {
                    e.preventDefault();

                    var product_id = "{{ $product->id }}";
                    var variant_id = selectedVariantId.val();
                    var quantity = qtyInput.val();
                    var colorName = $('input[name="productColor"]:checked').attr('data-color-name') || '';
                    var sizeName = $('input[name="productSize"]:checked').parent().find('.size-label').text() || '';
                    var total = totalAmount.text().replace('₹', '').trim();

                    if (!variant_id) {
                        Swal.fire({ icon: 'warning', title: 'Selection Missing', text: 'Please choose a valid configuration.' });
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

                // Init load
                handleColorChangeSelection();
            });
        </script>
    @endpush
@endsection