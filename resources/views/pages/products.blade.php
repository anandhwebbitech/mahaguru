@extends('layouts.app')
@section('content')

    <!-- Products Section Start -->
    <section class="content-inner">
        <div class="container">
            <div class=" row justify-content-md-center align-items-center">
                <div class="col-md-12">
                    <div class="section-head style-1 m-b30  wow fadeInUp" data-wow-delay="0.2s">
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

    <!-- Products Section Start -->
<script>
       document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');

    if (category) {
        // Auto set title on page load
        let formattedTitle = category
            .replace(/-/g, " ")
            .replace(/\b\w/g, (c) => c.toUpperCase());

        // $("#pageTitle").text(formattedTitle);

        loadFilteredProducts(category);
    }
});

// Update title when clicking a category tab
$(document).on("click", "a.category-tab", function () {
    let titleText = $(this).find("span").text().trim();
    // $("#pageTitle").text(titleText);
});
    function loadFilteredProducts(category) {
        const imageBase = "{{ asset('public/uploads/images') }}/";

        $.ajax({
            url: "{{ route('filter.products') }}",
            type: "GET",
            data: { category: category },

            success: function(response) {
                let products = response.products;
                let wishlist = response.wishlist || [];
                let html = "";

                products.forEach(product => {

                    let imageUrl = product.images
                        ? imageBase + product.images.split(",")[0]
                        : "{{ asset('assets/images/no-image.png') }}";

                    let isActive = wishlist.includes(product.id) ? "active" : "";

                    html += `
                    <li class="card-container col-6 col-xl-3 col-lg-3 col-md-4 col-sm-6 Tops wow fadeInUp" data-wow-delay="0.6s">
                        <div class="shop-card">
                            <div class="dz-media">
                                <img src="${imageUrl}" alt="${product.product_name}">
                                <div class="shop-meta">

                                    <a href="{{ url('product') }}/${product.id}" class="btn btn-secondary btn-md btn-rounded">
                                        <i class="fa-solid fa-eye d-md-none d-block"></i>
                                        <span class="d-md-block d-none">Quick View</span>
                                    </a>

                                    <div class="btn btn-primary meta-icon dz-wishicon addToWishlist ${isActive}"
                                        data-id="${product.id}">
                                        <i class="icon feather icon-heart dz-heart"></i>
                                        <i class="icon feather icon-heart-on dz-heart-fill"></i>
                                    </div>

                                    <div class="btn btn-primary meta-icon dz-carticon addToCart"
                                        onclick="window.location.href='/product/${product.id}'">
                                        <i class="flaticon flaticon-basket"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="dz-content">
                                <h5 class="title"><a href="/product/${product.id}">${product.product_name}</a></h5>

                                <h5 class="price">
                                    ₹${product.discount_price ?? product.price}
                                    <span class="text-muted" style="text-decoration:line-through; font-size:12px;">
                                        ₹${product.price}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </li>`;
                });

                $("#masonry").html(html);

                // reload masonry
                $('#masonry').imagesLoaded(function () {
                    $('#masonry').masonry({
                        itemSelector: '.card-container',
                        percentPosition: true,
                        horizontalOrder: true
                    });
                });
            }
        });
}

</script>
@endpush

@endsection