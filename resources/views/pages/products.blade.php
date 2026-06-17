@extends('layouts.app')
@section('content')

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
            <div class="clearfix">
                <ul id="masonry" class="row g-xl-4 g-3">
                    </ul>
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

        $("#pageTitle").text(formattedTitle);
        loadFilteredProducts(category);
    }
});

$(document).on("click", "a.category-tab", function (e) {
    e.preventDefault();
    let titleText = $(this).find("span").text().trim();
    let categorySlug = $(this).data('slug') || $(this).attr('href').split('category=')[1];
    
    $("#pageTitle").text(titleText);
    if(categorySlug) {
        loadFilteredProducts(categorySlug);
    }
});

function loadFilteredProducts(category) {
    const imageBase = "{{ asset('public/uploads/images') }}/";
    const fallbackImage = "{{ asset('assets/images/no-image.png') }}";

    $.ajax({
        url: "{{ route('filter.products') }}",
        type: "GET",
        data: { category: category },
        beforeSend: function() {
            $("#masonry").html('<div class="text-center w-100 p-5"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
        },
        success: function(response) {
            let products = response.products;
            let wishlist = response.wishlist || [];
            let html = "";

            if(products.length === 0) {
                $("#masonry").html('<div class="text-center w-100 p-5"><h5>No products found in this category.</h5></div>');
                return;
            }

            products.forEach(product => {
                // Perfected Safe Image Extraction Line
                let imageUrl = fallbackImage;
                if (product.images && product.images.trim() !== '') {
                    // Split by comma and clean blank spaces/empty strings
                    let imgArray = product.images.split(',').map(item => item.trim()).filter(Boolean);
                    if (imgArray.length > 0) {
                        imageUrl = imageBase + imgArray[0];
                    }
                }

                let isActive = wishlist.includes(product.id) ? "active" : "";
                
                let originalPrice = product.price ? `₹${product.price}` : '';
                let displayPrice = product.discount_price ? `₹${product.discount_price}` : originalPrice;
                let strikePriceHtml = product.discount_price && product.price && (product.discount_price < product.price) 
                    ? `<span class="text-muted" style="text-decoration:line-through; font-size:12px; margin-left:8px;">₹${product.price}</span>` 
                    : '';

                html += `
                <li class="card-container col-6 col-xl-3 col-lg-3 col-md-4 col-sm-6 Tops wow fadeInUp" data-wow-delay="0.2s">
                    <div class="shop-card">
                        <div class="dz-media">
                            <img src="${imageUrl}" alt="${product.product_name}">
                            <div class="shop-meta">
                                <a href="{{ url('product') }}/${product.id}" class="btn btn-secondary btn-md btn-rounded">
                                    <i class="fa-solid fa-eye d-md-none d-block"></i>
                                    <span class="d-md-block d-none">Quick View</span>
                                </a>
                                <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}" data-id="${product.id}">
                                    <i class="icon feather icon-heart dz-heart"></i>
                                    <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                </div>
                                <div class="btn btn-primary meta-icon dz-carticon addToCart" onclick="window.location.href='/product/${product.id}'">
                                    <i class="flaticon flaticon-basket"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dz-content">
                            <h5 class="title"><a href="/product/${product.id}">${product.product_name}</a></h5>
                            <h5 class="price">
                                ${displayPrice}
                                ${strikePriceHtml}
                            </h5>
                        </div>
                    </div>
                </li>`;
            });

            if ($('#masonry').data('masonry')) {
                $('#masonry').masonry('destroy'); 
            }

            $("#masonry").html(html);

            $('#masonry').imagesLoaded(function () {
                $('#masonry').masonry({
                    itemSelector: '.card-container',
                    percentPosition: true,
                    horizontalOrder: true
                });
            });
        },
        error: function() {
            $("#masonry").html('<div class="text-center w-100 p-5"><p class="text-danger">Something went wrong. Please try again.</p></div>');
        }
    });
}
</script>
@endpush
@endsection