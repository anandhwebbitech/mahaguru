@extends('layouts.app')
@section('content')

<div class="page-content bg-light">

    <div class="dz-bnr-inr bg-secondary overlay-black-light" style="background-image:url(images/new-images/site-banner.jpg);">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Wishlist</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home</a></li>
                        <li class="breadcrumb-item">Wishlist</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="content-inner-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table check-tbl style-1">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="wishlist-body">
                                <!-- AJAX Loads Here -->
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
@section('scripts')

<script>
function loadWishlistPage() {
    $.ajax({
        url: "{{ route('get.wishlist') }}",
        method: "GET",
        success: function(response) {
            let html = "";

            let items = response.items;

            if (Object.keys(items).length === 0) {
                html = `
                    <tr>
                        <td colspan="6" class="text-center">Your wishlist is empty.</td>
                    </tr>`;
            } else {

                $.each(items, function(id, item) {
                    let imageUrl = "{{ asset('public/uploads/images') }}/" + item.product_img;

                   html += `
                        <tr>
                            <td class="product-item-img">
                                <img src="${imageUrl}" width="80">
                            </td>

                            <td class="product-item-name">${item.product_name}</td>

                            <td class="product-item-price">₹${item.offer_price}</td>

                            <td class="product-item-stock">In Stock</td>

                            <td>
                                <a href="javascript:void(0);" 
                                class="btn btn-secondary btnhover btn-addto-cart"
                                data-id="${item.id}"
                                data-price="${item.offer_price}">
                                Add To Cart
                                </a>
                            </td>

                            <td>
                                <a href="javascript:void(0);" onclick="removeFromWishlistpage(${id})">
                                    <i class="ti-close"></i>
                                </a>
                            </td>
                        </tr>`;
                });
            }

            $("#wishlist-body").html(html);
        }
    });
}

// Call on page load
$(document).ready(function() {
    loadWishlistPage();
});
function removeFromWishlistpage(id) {

    $.ajax({
        url: "{{ route('wishlist.remove', ':id') }}".replace(':id', id),
        method: "GET",
        success: function(res) {
             location.reload(); // ✅ reload table only
        }
    });
}


$(document).on('click', '.btn-addto-cart', function () {

    let product_id = $(this).data('id');
    let price = $(this).data('price');

    $.ajax({
        url: "{{ route('cart.store') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: product_id,
            quantity: 1,
            total: price // ✅ REQUIRED
        },

        beforeSend: function () {
            console.log("Adding...");
        },

        success: function (res) {

            $.ajax({
        url: "{{ route('wishlist.remove', ':id') }}".replace(':id', product_id),
        method: "GET",
        success: function () {

            // ✅ AFTER REMOVE → redirect
            window.location.href = res.redirect_url;

        }
    });

        },

        error: function (xhr) {

            if (xhr.status === 401) {
                alert("Please login first");
                window.location.href = "{{ route('login') }}";
                return;
            }

            console.log(xhr.responseText);
            alert("Error adding to cart");
        }
    });

});
</script>
@endpush

@endsection
