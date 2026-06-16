@extends('layouts.app')
@section('content')
    <style>
        .address-box {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            min-height: 180px;
            transition: .2s;
        }

        .address-box:hover {
            border-color: #d9bfa5;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .address-card {
            margin-bottom: 20px;
        }

        .select-address {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #ff6a3d;
            /* Stylish orange-red radio button */
        }

        .btn-sm {
            padding: 6px 16px;
            font-size: 14px;
            border-radius: 6px;
        }

        .selectable {
            cursor: pointer;
            border: 2px solid #dee2e6;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .selectable:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .selectable.active {
            border-color: #0d6efd;
            background-color: #e7f1ff;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        }

        .selectable.active p {
            color: #0d6efd;
            font-weight: 600;
        }
        #accordionFaq .accordion-item{
            border-radius:12px;
            overflow:hidden;
            border:1px solid #e5e7eb;
        }

        #accordionFaq .accordion-button{
            font-size:16px;
            font-weight:600;
        }

        #accordionFaq .accordion-button:not(.collapsed){
            color:#111827;
            background:#fff;
        }

        #accordionFaq .accordion-button:focus{
            box-shadow:none;
        }

        #addAdd_btn{
            white-space:nowrap;
        }
    </style>
    <div class="page-content bg-light">
        <!--Banner Start-->
        <div class="dz-bnr-inr bg-secondary overlay-black-light"
            style="background-image:url(images/new-images/site-banner.jpg);">
            <div class="container">
                <div class="dz-bnr-inr-entry">
                    <h1>Shop Checkout</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-row">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home</a></li>
                            <li class="breadcrumb-item">Shop Checkout</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!--Banner End-->

        <!-- inner page banner End-->
        <div class="content-inner-1">
            <div class="container">
                <div class="row shop-checkout">
                    <div class="col-xl-8">
                        <h4 class="title m-b15">Billing details</h4>
                        <div class="accordion dz-accordion accordion-sm" id="accordionFaq">
                            <!-- 3 -->
                            <div class="accordion-item">

                                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">

                                    <h2 class="accordion-header flex-grow-1 mb-0" id="headingThree">
                                        <button class="accordion-button p-0 shadow-none bg-transparent" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true"
                                            aria-controls="collapseThree">

                                            <span class="fw-semibold">
                                                Select Delivery Address
                                            </span>

                                        </button>
                                    </h2>
                                    <a href="{{ route('userdashboard') }}">
                                    <button class="btn btn-warning btn-sm rounded-pill px-3 ms-3" id="addAdd_btn">
                                        <i class="fa-solid fa-plus me-1"></i>
                                        Add Address
                                    </button></a>

                                </div>

                                <div id="collapseThree" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionFaq">

                                    <div class="accordion-body">
                                        <div id="deliveryAddressContainer" class="row">
                                            <p class="m-0">Loading addresses...</p>
                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="col-xl-4 side-bar">
                        <h4 class="title m-b15">Your Order</h4>
                        <div class="order-detail sticky-top">
                            <div id="sidebarCartList">

                            </div>
                            <div class="coupon-box mb-3">
                                <div class="input-group">
                                    <input type="text" id="coupon_code" class="form-control"
                                        placeholder="Enter coupon code">
                                    <button class="btn btn-secondary" id="applyCouponBtn">
                                        Apply
                                    </button>
                                </div>
                            </div>
                            <table>
                                <tbody>
                                    <tr class="subtotal">
                                        <td>Subtotal</td>
                                        <td class="price" id="overall_total">₹0</td>
                                    </tr>

                                    <tr class="coupon">
                                        <td>Coupon Discount</td>
                                        <td class="price text-success" id="coupon_amount">₹0.00</td>
                                    </tr>
                                    <tr class="shipping">
                                        <td>Shipping Charge</td>
                                        <td class="price" id="shipping_amount">₹0.00</td>
                                    </tr>
                                <tbody id="gst_section"></tbody>
                                <tr class="total">
                                    <td>Total</td>
                                    <td class="price" id="overallTotal">₹00.00</td>

                                </tr>
                                </tbody>
                            </table>
                            <p class="text">Your personal data will be used to process your order, support your
                                experience throughout this website, and for other purposes described in our <a
                                    href="{{ route('privacy') }}">privacy policy.</a></p>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox d-flex m-b15">
                                    <input type="checkbox" name="terms_conditions" class="form-check-input"
                                        id="basic_checkbox_3" required>
                                    <label class="form-check-label" for="basic_checkbox_3">I have read and agree to the
                                        website terms and conditions </label>
                                </div>
                            </div>
                            {{-- <div class="payment-method mt-3 mb-3">
                                <h6>Select Payment Method</h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card p-2 text-center selectable " data-method="online">
                                            <img src="{{ asset('public/assets/images/razorpay.png') }}" style="height:80px">
                                            <p class="mb-0">Online Payment</p>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <input type="hidden" id="selected_address_id" name="selected_address_id">
                            <button type="submit" id="place_order_btn" class="btn btn-secondary w-100">CONTINUE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var baseUrl = "{{ asset('') }}";
            let cartProductIds = [];
            let cartItemCount = 0;
            let paymentMethod = null;

            $(document).ready(function() {
                loadSidebarCart();
                loadAddresses();
            });

            function loadSidebarCart() {
                $.ajax({
                    url: "{{ route('cart.items') }}",
                    method: "GET",
                    success: function(response) {
                        if (response.status === "success" && response.cartItems) {
                            let html = "";
                            let grandTotal = 0;
                            let itemCount = 0;
                            cartProductIds = [];

                            let itemsArray = Object.values(response.cartItems);

                            itemsArray.forEach(function(item) {
                                itemCount++;
                                let price = parseFloat(item.total_amount) || 0;
                                grandTotal += price;

                                if (item.product) {
                                    cartProductIds.push({
                                        product_id: item.product.id,
                                        quantity: item.quantity,
                                        price: price
                                    });

                                    let productImage = 'no-image.png';
                                    if (item.product.images) {
                                        productImage = item.product.images.split(',')[0].trim();
                                    }

                                    let imageUrl = item.product.images ?
                                        `${baseUrl}uploads/images/${productImage}` :
                                        `${baseUrl}uploads/images/no-image.png`;

                                    let productUrl = "{{ url('/product') }}";
                                    let gstRate = parseFloat(item.product.tax || 0);
                                    let gstAmount = (price * gstRate) / 100;

                                    html += `
                            <div class="cart-item style-1 mb-2">
                                <div class="dz-media" style="width:60px; height:60px; object-fit:cover;">
                                    <img src="${imageUrl}" alt="product">
                                </div>
                                <div class="dz-content">
                                    <h6 class="title mb-1">
                                        <a href="${productUrl}/${item.product.id}">${item.product.product_name}</a>
                                    </h6>
                                    <div class="d-flex flex-column align-items-start small">
                                        <span class="price mb-1">Price: ₹${price.toFixed(2)}</span>
                                        ${gstAmount > 0 ? `<span class="text-muted mb-1">Tax (${gstRate}%): ₹${gstAmount.toFixed(2)}</span>` : ''}
                                    </div>
                                </div>
                            </div>`;
                                }
                            });

                            $("#sidebarCartList").html(html);
                            $('#overall_total').text("₹" + grandTotal.toFixed(2));
                            $('#overallTotal').text("₹" + grandTotal.toFixed(2));
                            cartItemCount = itemCount;
                            togglePlaceOrderButton();
                        } else {
                            cartItemCount = 0;
                            togglePlaceOrderButton();
                        }
                    },
                    error: function(err) {
                        console.error('AJAX error:', err);
                    }
                });
            }

            function loadAddresses() {
                $.ajax({
                    url: "{{ route('get.addresses') }}",
                    method: "GET",
                    success: function(response) {

                        if (response.status !== "success") return;

                        let html = "";

                        if (!response.addresses || response.addresses.length === 0) {

                            html = `
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No saved addresses found.
                        </div>
                    </div>
                `;

                            $("#deliveryAddressContainer").html(html);
                            togglePlaceOrderButton();
                            return;
                        }

                        response.addresses.forEach(function(addr) {

                            html += `
                <div class="col-md-6 mb-3">
                    <div class="address-box p-3 rounded shadow-sm border" data-id="${addr.id}">
                        
                        <div class="d-flex justify-content-between">
                            <strong>
                                ${addr.first_name || ''} ${addr.last_name || ''}
                                ${addr.is_default == 1 
                                    ? '<span class="badge bg-success ms-2">Default</span>'
                                    : ''}
                            </strong>

                            <input type="radio"
                                name="selected_address"
                                value="${addr.id}"
                                data-country="${addr.country_region || ''}"
                                data-state="${addr.state || ''}"
                                class="select-address"
                                ${addr.is_default == 1 ? 'checked' : ''}>
                        </div>

                        <div class="mt-2 small">
                            ${addr.street || ''}<br>
                            ${addr.city || ''}, ${addr.state || ''} - ${addr.zip_code || ''}<br>
                            ${addr.country_region || ''}<br>
                            Phone: ${addr.phone || ''}<br>
                            Email: ${addr.email || ''}
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-2">
                            <button
                                class="btn btn-sm text-danger remove-address-btn"
                                data-id="${addr.id}"
                                title="Delete Address">
                                🗑️
                            </button>
                        </div>

                    </div>
                </div>`;
                        });

                        $("#deliveryAddressContainer").html(html);

                        // Default address auto load
                        let selected = $("input[name='selected_address']:checked");

                        if (selected.length) {

                            loadAddressDetails(
                                selected.val(),
                                selected.data("country"),
                                selected.data("state")
                            );

                            togglePlaceOrderButton();
                        }
                    }
                });
            }

            function loadAddressDetails(addressId, country, state) {

                if (!addressId) return;
                console.log("Address Loaded:", addressId);
                $("#selected_address_id").val(addressId);

                $.ajax({
                    url: "{{ url('/address') }}/" + addressId,
                    method: "GET",

                    success: function(res) {

                        if (!res.address) return;

                        let a = res.address;

                        $('[name="first_name"]').val(a.first_name || '');
                        $('[name="last_name"]').val(a.last_name || '');
                        $('[name="country"]').val(a.country_region || '');
                        $('[name="state"]').val(a.state || '');

                        // Check your field name
                        $('[name="address_line1"]').val(a.street || '');

                        $('[name="city"]').val(a.city || '');
                        $('[name="zip_code"]').val(a.zip_code || '');
                        $('[name="phone"]').val(a.phone || '');
                        $('[name="email"]').val(a.email || '');

                        addressGst(addressId, country, state);

                        $('#addressForm input, #addressForm select, #addressForm textarea')
                            .prop("disabled", true);

                        $("#saveAddressBtn").hide();
                    }
                });
            }



            function togglePlaceOrderButton() {

                let addressSelected =
                    $("input[name='selected_address']:checked").length > 0;

                let cartOk = cartItemCount > 0;

                $("#place_order_btn").prop(
                    "disabled",
                    !(addressSelected && cartOk)
                );
            }

            $(document).on("change", ".select-address", function() {

                togglePlaceOrderButton();

                loadAddressDetails(
                    $(this).val(),
                    $(this).data("country"),
                    $(this).data("state")
                );
            });

            function addressGst(addressId, country = '', state = '') {
                if (!addressId) return;

                let subtotal = parseFloat($("#overall_total").text().replace("₹", "")) || 0;
                let couponCode = $("#coupon_code").val().trim();

                $.ajax({
                    url: "{{ url('/calculate-gst') }}",
                    method: "POST",
                    data: {
                        address_id: addressId,
                        country: country, // எ.கா: India
                        state: state, // எ.கா: Tamil Nadu
                        subtotal: subtotal,
                        coupon_code: couponCode,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $("#shipping_amount").text("Calculating...");
                    },
                    success: function(res) {
                        if (res.status === "success") {
                            $("#coupon_amount").text("₹" + (res.discount || 0).toFixed(2));

                            // 💰 டேட்டாபேஸில் மேட்ச் ஆன ஷிப்பிங் சார்ஜ் இங்கு அப்டேட் ஆகும்
                            let shippingCharge = parseFloat(res.shipping_charge) || 0;
                            $("#shipping_amount").text("₹" + shippingCharge.toFixed(2));

                            let gstHtml = "";
                            if (res.cgst > 0) {
                                gstHtml += `<tr><td>CGST</td><td class="price">₹${res.cgst.toFixed(2)}</td></tr>`;
                                gstHtml += `<tr><td>SGST</td><td class="price">₹${res.sgst.toFixed(2)}</td></tr>`;
                            }
                            if (res.igst > 0) {
                                gstHtml += `<tr><td>IGST</td><td class="price">₹${res.igst.toFixed(2)}</td></tr>`;
                            }
                            $("#gst_section").html(gstHtml);

                            $("#overallTotal").text("₹" + res.final_total.toFixed(2));
                        }
                    },
                    error: function() {
                        $("#shipping_amount").text("₹0.00");
                    }
                });
            }

            // கூப்பன் அப்ளை செய்யும் லாஜிக்
            $("#applyCouponBtn").click(function(e) {
                e.preventDefault();
                let couponCode = $("#coupon_code").val().trim();

                if (!couponCode) {
                    Swal.fire('Error', 'Please enter coupon code', 'warning');
                    return;
                }

                let subtotal = parseFloat($("#overall_total").text().replace("₹", "")) || 0;

                $.ajax({
                    url: "{{ route('coupon.apply') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon_code: couponCode,
                        subtotal: subtotal
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Applying coupon...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function(res) {
                        Swal.close();
                        if (res.status === "success") {
                            $("#coupon_amount").text("₹" + res.discount);
                            Swal.fire({
                                icon: 'success',
                                title: 'Coupon Applied',
                                text: `You saved ₹${res.discount}`
                            });

                            // கூப்பனுக்குப் பிறகு மீண்டும் ஷிப்பிங் மற்றும் ஜிஎஸ்டி கணக்கிடப்படுகிறது
                            let $selectedRadio = $("input[name='selected_address']:checked");
                            if ($selectedRadio.length > 0) {
                                addressGst($selectedRadio.val(), $selectedRadio.data("country"),
                                    $selectedRadio.data("state"));
                            } else {
                                let final = subtotal - res.discount;
                                $("#overallTotal").text("₹" + final.toFixed(2));
                            }
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        let msg = 'Invalid coupon';
                        if (xhr.responseJSON?.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

            // பேமெண்ட் மெத்தட் செலக்ட் செய்தல்
            $(document).on("click", ".selectable", function() {
                $(".selectable").removeClass("border border-primary active");
                $(this).addClass("border border-primary active");
                paymentMethod = $(this).data("method");
            });

            $(document).on("click", "#place_order_btn", function (e) {
                e.preventDefault();

                let $btn = $(this);

                let address_id = $("#selected_address_id").val();
                let termsAccepted = $("#basic_checkbox_3").is(":checked");

                if (!address_id) {
                    Swal.fire('Warning', 'Please select a delivery address.', 'warning');
                    return;
                }

                if (!cartProductIds || cartProductIds.length === 0) {
                    Swal.fire('Warning', 'Your cart is empty.', 'warning');
                    return;
                }

                if (!termsAccepted) {
                    Swal.fire('Warning', 'Please accept the Terms & Conditions.', 'warning');
                    return;
                }

                // if (!paymentMethod) {
                //     Swal.fire('Warning', 'Please select a payment method.', 'warning');
                //     return;
                // }

                $btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: "{{ route('order.create.initial') }}",
                    type: "POST",
                    data: {
                        address_id: address_id,
                        payment_method: paymentMethod,
                        _token: "{{ csrf_token() }}"
                    },

                    success: function (res) {

                        if (res.status === "success" &&
                            Array.isArray(res.order_ids) &&
                            res.order_ids.length > 0) {

                            if (paymentMethod === "cod") {

                                Swal.fire({
                                    icon: "success",
                                    title: "Order Placed",
                                    text: "Your order has been placed successfully."
                                }).then(() => {
                                    window.location.href = "{{ url('/') }}";
                                });

                            } else {

                                let firstOrderId = res.order_ids[0];
                                let amount = parseFloat(res.total_amount || 0);

                                window.location.href =
                                    "{{ url('payment/razorpay') }}/" +
                                    firstOrderId +
                                    "?amount=" +
                                    amount;
                            }

                        } else {

                            Swal.fire(
                                "Error",
                                res.message || "Order creation failed.",
                                "error"
                            );

                            $btn.prop('disabled', false).text('Place Order');
                        }
                    },

                    error: function (xhr) {

                        let message = "Something went wrong. Please try again.";

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire("Error", message, "error");

                        $btn.prop('disabled', false).text('Place Order');
                    }
                });
            });

            $(document).on('click', '#saveAddressBtn', function(e) {
                e.preventDefault();
                let isValid = true;
                let $form = $('#addressForm');

                $form.find('.error-message').remove();
                $form.find('.form-control, .form-select').removeClass('is-invalid');

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const phoneRegex = /^[6-9]\d{9}$/;
                const zipRegex = /^\d{6}$/;

                function showError($element, message) {
                    $element.addClass('is-invalid');
                    if (!$element.next('.error-message').length) {
                        $element.after(`<div class="error-message text-danger mt-1">${message}</div>`);
                    }
                    isValid = false;
                }

                $form.find('input:not([type="hidden"]), select').each(function() {
                    if ($.trim($(this).val()) === '') {
                        showError($(this), 'This field is required.');
                    }
                });

                let $email = $form.find('[name="email"]');
                if ($.trim($email.val()) !== '' && !emailRegex.test($email.val())) {
                    showError($email, 'Please enter a valid email address.');
                }

                let $phone = $form.find('[name="phone"]');
                if ($.trim($phone.val()) !== '' && !phoneRegex.test($phone.val())) {
                    showError($phone, 'Please enter a valid 10-digit mobile number.');
                }

                let $zip = $form.find('[name="zip_code"]');
                if ($.trim($zip.val()) !== '' && !zipRegex.test($zip.val())) {
                    showError($zip, 'Please enter a valid 6-digit PIN code.');
                }

                if (!isValid) return false;

                let formData = $form.serialize();
                let addressId = $('#selected_address_id').val();
                let isUpdate = $(this).hasClass('update-mode');
                let url = isUpdate ? "{{ url('/update-address') }}/" + addressId : "{{ route('saveAddress') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#saveAddressBtn').prop('disabled', true).text(isUpdate ? 'Updating...' :
                            'Saving...');
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: isUpdate ? 'Address updated!' : 'Address saved!'
                            });
                            $form[0].reset();
                            $('#selected_address_id').val('');
                            loadAddresses();
                            $('#saveAddressBtn').removeClass('update-mode').text('Save Address');
                        }
                    },
                    complete: function() {
                        $('#saveAddressBtn').prop('disabled', false);
                    }
                });
            });

            $(document).on('keyup change', '#addressForm input, #addressForm select', function() {
                $(this).removeClass('is-invalid').next('.error-message').remove();
            });

            $(document).on("click", "#editAddressBtn", function() {
                $('#addressForm input, #addressForm select, #addressForm textarea').prop("disabled", false);
                $("#saveAddressBtn").text("Update Address").addClass("update-mode").show();
            });

            $(document).on("click", ".remove-address-btn", function() {
                let addressId = $(this).data("id");
                if (!confirm("Are you sure you want to delete this address?")) return;

                $.ajax({
                    url: "{{ url('/delete-address') }}/" + addressId,
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status === "success") loadAddresses();
                    }
                });
            });
        </script>
    @endpush
@endsection
