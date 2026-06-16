@extends('layouts.app')
@section('content')
    <style>
        /* Modernized Quantity UI Controls */
        .qty-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 30px;
            width: fit-content;
            border: 1px solid #e9ecef;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: #ffffff;
            color: #212529;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            background: #000000;
            color: #ffffff;
        }

        .qty-number {
            min-width: 30px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: #212529;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
            filter: grayscale(1);
        }

        .product-item-img img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>

    <section class="content-inner shop-account">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table check-tbl vertical-align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cartTableBody">
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                <h4 class="title mb15">Cart Total</h4>
                <div class="cart-detail">
                    {{-- <div class="icon-bx-wraper style-4 m-b15">
                        <div class="icon-bx">
                            <i class="flaticon flaticon-ship"></i>
                        </div>
                        <div class="icon-content">
                            <span class="font-14">FREE SHIPPING</span>
                            <h6 class="dz-title">Enjoy Your Product</h6>
                        </div>
                    </div> --}}

                    <table class="table style-1 check-tbl mb-4">
                        <tbody>
                            {{-- <tr>
                                <td><span class="text-muted">Subtotal</span></td>
                                <td class="text-end"><h6 class="mb-0" id="cart_subtotal">₹0.00</h6></td>
                            </tr>
                            <tr>
                                <td><span class="text-muted">Shipping</span></td>
                                <td class="text-end"><h6 class="mb-0 text-success" id="cart_shipping">Free</h6></td>
                            </tr> --}}
                            <tr class="d-none">
                                <td><span class="text-muted">Tax / GST</span></td>
                                <td class="text-end"><h6 class="mb-0" id="cart_tax">₹0.00</h6></td>
                            </tr>
                            <tr class="total" style="border-top: 2px solid #eee; padding-top: 10px;">
                                <td>
                                    <h5 class="mb-0 font-weight-bold">Total</h5>
                                </td>
                                <td class="price text-end">
                                    <h4 class="mb-0 font-weight-bold text-primary" id="overall_total">₹0.00</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <a href="{{ route('checkout') }}" class="btn btn-secondary w-100 place_order">PLACE ORDER</a>
                </div>
            </div>
            </div>
        </div>
    </section>

@push('scripts')
<script>
    // உங்கள் இமேஜ்கள் இருக்கும் சரியான ஃபோல்டர் பாத்
    var storageUrl = "{{ asset('public/uploads/images') }}/";
    var fallbackImg = "{{ asset('public/uploads/images/no-image.png') }}";
    var cartItemCount = 0;

    function loadCartdata() {
        $.ajax({
            url: "{{ route('cart.items') }}",
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    let tbody = '';
                    let grandTotal = 0;   
                    
                    // ⚡ FIX: Array மற்றும் Object இரண்டையும் பாதுகாப்பாக கையாள Object.values() பயன்படுத்துகிறோம்
                    let itemsArray = Object.values(response.cartItems);
                    let itemCount = itemsArray.length;

                    if(itemCount === 0) {
                        cartItemCount = 0;
                        togglePlaceOrderButton();
                        $('#cartTableBody').html('<tr><td colspan="6" class="text-center py-4">Your cart is empty.</td></tr>');
                        return;
                    }

                    itemsArray.forEach(function(item) {
                        // 1. கண்ட்ரோலரில் இருந்து வரும் நேரடி துல்லியமான விலை
                        let price = parseFloat(item.final_price) || 0;
                        
                        // 2. கண்ட்ரோலரில் இருந்து வரும் துல்லியமான இமேஜ் பெயர்
                        let productImage = item.final_image ? item.final_image.trim() : '';
                        let finalImgSrc = (productImage === 'no-image.png' || !productImage) ? fallbackImg : (storageUrl + productImage);

                        // 3. வேரியண்ட் விவரங்கள் (Size, Color)
                        let variantDetails = '';
                        let sizeName = item.size ? `Size: ${item.size}` : '';
                        let colorName = item.color ? `Color: ${item.color}` : '';
                        if (sizeName || colorName) {
                            variantDetails = `(${sizeName}${sizeName && colorName ? ', ' : ''}${colorName})`;
                        }

                        // 4. கணிதக் கணக்கீடுகள்
                        let itemQuantity = parseInt(item.quantity) || 1;
                        let itemTotal = price * itemQuantity;
                        grandTotal += itemTotal;

                        // தயாரிப்பு பெயர் (உங்கள் டேட்டாபேஸ் படி 'product_name')
                        let productName = (item.product && item.product.product_name) ? item.product.product_name : 'Unknown Product';

                        tbody += `
                        <tr data-id="${item.id}" data-price="${price}">
                            <td class="product-item-img">
                                <img src="${finalImgSrc}" onerror="this.src='${fallbackImg}'" alt="${productName}" style="width:80px; height:80px; object-fit:cover;">
                            </td>
                            <td class="product-item-name">
                                ${productName} <br>
                                <small class="text-danger font-weight-bold">${variantDetails}</small>
                            </td>
                            <td class="product-item-price">₹${price.toFixed(2)}</td>
                            <td class="product-item-quantity">
                                <div class="qty-wrapper">
                                    <button class="qty-btn minus" type="button">−</button>
                                    <span class="qty-number">${itemQuantity}</span>
                                    <button class="qty-btn plus" type="button">+</button>
                                </div>
                            </td>
                            <td class="product-item-totle subtotal">₹${itemTotal.toFixed(2)}</td>
                            <td class="product-item-close">
                                <a href="javascript:void(0);" class="text-danger" onclick="removeCartItem(${item.id})">
                                    <i class="ti-close"></i>
                                </a>
                            </td>
                        </tr>
                        `;
                    });
                    
                    $('#cartTableBody').html(tbody);
                    $('#overall_total').text("₹" + grandTotal.toFixed(2));
                    cartItemCount = itemCount;
                    togglePlaceOrderButton();
                }
            },
            error: function() {
                $('#cartTableBody').html('<tr><td colspan="6" class="text-center text-danger py-4">Failed to load cart.</td></tr>');
            }
        });
    }



    function togglePlaceOrderButton() {
        if (cartItemCount > 0) {
            $(".place_order").removeClass("disabled-link");
        } else {
            $(".place_order").addClass("disabled-link");
            $('#cartTableBody').html('<tr><td colspan="6" class="text-center py-5 text-muted">Your cart is empty.</td></tr>');
            $('#overall_total').text("₹0.00");
        }
    }

    function removeCartItem(id) {
        if(!confirm('Are you sure you want to remove this item?')) return;
        
        $.ajax({
            url: "{{ url('/cart/remove') }}/" + id,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
            success: function(response) {
                if (response.status === "success") {
                    loadCartdata();
                } else {
                    alert(response.message || "Something went wrong.");
                }
            }
        });
    }

    $(document).on('click', '.qty-btn.plus', function () {
        let row = $(this).closest('tr');
        let qtySpan = row.find('.qty-number');
        let quantity = parseInt(qtySpan.text()) || 0;
        let price = parseFloat(row.attr('data-price')) || 0; 

        quantity++;
        qtySpan.text(quantity);

        let newSubtotal = price * quantity;
        row.find('.subtotal').text("₹" + newSubtotal.toFixed(2));

        updateGrandTotal();
        autoUpdateCartServer(row.attr("data-id"), quantity);
    });

    $(document).on('click', '.qty-btn.minus', function () {
        let row = $(this).closest('tr');
        let qtySpan = row.find('.qty-number');
        let quantity = parseInt(qtySpan.text()) || 0;
        let price = parseFloat(row.attr('data-price')) || 0;

        if (quantity > 1) {
            quantity--;
            qtySpan.text(quantity);

            let newSubtotal = price * quantity;
            row.find('.subtotal').text("₹" + newSubtotal.toFixed(2));

            updateGrandTotal();
            autoUpdateCartServer(row.attr("data-id"), quantity);
        }
    });

    function updateGrandTotal() {
        let total = 0;
        $(".subtotal").each(function () {
            let val = parseFloat($(this).text().replace("₹", "")) || 0;
            total += val;
        });
        $("#overall_total").text("₹" + total.toFixed(2));
    }

    function autoUpdateCartServer(itemId, qty) {
        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                item_id: itemId,
                quantity: qty
            },
            success: function (response) {
                if (response.status !== "success") {
                    console.error("Sync error.");
                }
            }
        });
    }
</script>
@endpush
@endsection
