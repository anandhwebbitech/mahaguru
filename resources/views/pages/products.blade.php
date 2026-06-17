@extends('layouts.app')
@section('content')

    <style>
        /* HTML Alignment uniformity preservation properties */
        .shop-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }
        .shop-card:hover {
            transform: translateY(-5px);
        }
        .dz-media {
            position: relative;
            width: 100%;
            padding-top: 115%; /* Exact consistent container aspect-ratio mapping */
            overflow: hidden;
            background: #f9f9f9;
        }
        .dz-media img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Prevents uneven skewing or layout padding drops */
        }
        .dz-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .dz-content .title {
            font-size: 15px;
            line-height: 1.4;
            margin-bottom: 8px;
            height: 42px; /* Standardizes text block wrapping space globally to 2 lines max */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .dz-content .price {
            margin-top: auto; /* Aligns price blocks to the baseline level evenly */
            font-weight: 600;
        }
    </style>

    <section class="content-inner">
        <div class="container">
            <div class="row justify-content-md-center align-items-center">
                <div class="col-md-12">
                    <div class="section-head style-1 m-b30 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="left-content text-center">
                            <h2 class="title" id="pageTitle">Products</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-xl-4 g-3" id="product-grid">
                </div>
        </div>
    </section>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');

    if (category) {
        let formattedTitle = category
            .replace(/-/g, " ")
            .replace(/\b\w/g, (c) => c.toUpperCase());

        // $("#pageTitle").text(formattedTitle);
        loadFilteredProducts(category);
    }
});

$(document).on("click", "a.category-tab", function (e) {
    e.preventDefault();
    let titleText = $(this).find("span").text().trim();
    let categorySlug = $(this).data('slug') || $(this).attr('href').split('category=')[1];
    
    // $("#pageTitle").text(titleText);
    if(categorySlug) {
        loadFilteredProducts(categorySlug);
    }
});

function loadFilteredProducts(category) {
    // Syncing directory base matching controller setup
    const imageBase = "{{ asset('public/uploads/products') }}/"; 
    const fallbackImage = "{{ asset('assets/images/no-image.png') }}";

    $.ajax({
        url: "{{ route('filter.products') }}",
        type: "GET",
        data: { category: category },
        beforeSend: function() {
            $("#product-grid").html('<div class="text-center w-100 p-5"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
        },
        success: function(response) {
            if(!response.success) {
                $("#product-grid").html('<div class="text-center w-100 p-5"><p class="text-danger">Failed to process product dataset request.</p></div>');
                return;
            }

            let products = response.products || [];
            let wishlist = response.wishlist || [];
            let html = "";

            if(products.length === 0) {
                $("#product-grid").html('<div class="text-center w-100 p-5"><h5>No products found in this category.</h5></div>');
                return;
            }

            products.forEach(product => {
                let imageUrl = fallbackImage;
                
                // Matches exact parsed dynamic key mapped in filterProducts() controller method
                if (product.thumbnail && product.thumbnail.trim() !== '') {
                    imageUrl = imageBase + product.thumbnail;
                }

                let isActive = wishlist.includes(parseInt(product.id)) ? "active" : "";
                
                let displayPrice = "₹" + parseFloat(product.discount_price || 0).toFixed(2);
                let strikePriceHtml = "";

                if (product.discount_price && product.price && (parseFloat(product.discount_price) < parseFloat(product.price))) {
                    strikePriceHtml = `<span class="text-muted ms-2" style="text-decoration:line-through; font-size:12px;">₹${parseFloat(product.price).toFixed(2)}</span>`;
                }

                html += `
                <div class="col-6 col-xl-3 col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch wow fadeInUp" data-wow-delay="0.2s">
                    <div class="shop-card w-100">
                        <div class="dz-media">
                            <img src="${imageUrl}" alt="${product.product_name}" loading="lazy">
                            <div class="shop-meta">
                                <a href="{{ url('product') }}/${product.id}" class="btn btn-secondary btn-md btn-rounded">
                                    <i class="fa-solid fa-eye d-md-none d-block"></i>
                                    <span class="d-md-block d-none">Quick View</span>
                                </a>
                                <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}" data-id="${product.id}">
                                    <i class="icon feather icon-heart dz-heart"></i>
                                    <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                </div>
                                <div class="btn btn-primary meta-icon dz-carticon addToCart" onclick="window.location.href='{{ url('product') }}/${product.id}'">
                                    <i class="flaticon flaticon-basket"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dz-content">
                            <h5 class="title">
                                <a href="{{ url('product') }}/${product.id}">${product.product_name}</a>
                            </h5>
                            <h5 class="price">
                                ${displayPrice}
                                ${strikePriceHtml}
                            </h5>
                        </div>
                    </div>
                </div>`;
            });

            $("#product-grid").html(html);
        },
        error: function() {
            $("#product-grid").html('<div class="text-center w-100 p-5"><p class="text-danger">Something went wrong. Please try again.</p></div>');
        }
    });
}
</script>
@endpush
@endsection