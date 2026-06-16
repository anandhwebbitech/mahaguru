@extends('layouts.app')

@section('title', 'My Order')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a {
        text-decoration: none;
    }
</style>


<section class="content-inner">
    <div class="container">

        <h2 class="text-center mb-4">My Orders</h2>

        <!-- Status Filter -->
        <form method="GET" action="{{ route('myorderuser') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-control select2" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="0" {{ request('status')=='0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Processing</option>
                        <option value="4" {{ request('status')=='4' ? 'selected' : '' }}>Completed</option>
                        <option value="3" {{ request('status')=='3' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="card p-3">
            <table class="table table-bordered">
               <thead class="table-primary">
    <tr>
        <th>Order #</th>
        @if(Auth::user()->role == 1)
            <th>User Name</th>
        @endif
        <th>Product Name</th>
        <th>Product Image</th>
        <th>Date Purchased</th>
        <th>Order Status</th>
        <th>Shipping Status</th>
        <th>Payment Status</th>
        <th>Payment Type</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    @php
        $statusText = [
            0 => 'Pending',
            1 => 'Confirmed',
            2 => 'Returned',
            3 => 'Cancelled',
            4 => 'Delivered'
        ];

        $statusBadge = [
            0 => 'primary',
            1 => 'info',
            2 => 'warning',
            3 => 'danger',
            4 => 'success'
        ];

        $shippingStatuses = [
            1 => 'Pending',
            2 => 'Shipped',
            3 => 'Delivered'
        ];

        $shippingBadge = [
            1 => 'warning',
            2 => 'info',
            3 => 'success'
        ];
    @endphp

    @forelse ($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>

            @if(Auth::user()->role == 1)
                <td>{{ $order->user->name ?? 'N/A' }}</td>
            @endif

            <td>{{ $order->product->product_name ?? 'N/A' }}</td>

            <td>
                @php
                    $image = $order->product->images ?? null;
                    $imageUrl = $image
                        ? asset('public/uploads/images/' . explode(',', $image)[0])
                        : asset('assets/images/no-image.png');
                @endphp

                <img src="{{ $imageUrl }}"
                     width="60"
                     height="60"
                     style="object-fit: cover; border-radius: 6px;">
            </td>

            <td>{{ $order->created_at->format('d M Y') }}</td>

            <!-- Order Status -->
            <td>
                <span class="badge bg-{{ $statusBadge[$order->status] ?? 'secondary' }}">
                    {{ $statusText[$order->status] ?? 'Unknown' }}
                </span>
            </td>

            <!-- Shipping Status -->
            <td>
                <span class="badge bg-{{ $shippingBadge[$order->shipping_status] ?? 'secondary' }}">
                    {{ $shippingStatuses[$order->shipping_status] ?? 'Pending' }}
                </span>
            </td>

            <!-- Payment Status -->
            <td>
                @php
                    $paymentStatus = empty($order->payment_status) ? 'Unpaid' : 'Paid';
                    $paymentBadge = empty($order->payment_status) ? 'danger' : 'success';
                @endphp

                <span class="badge bg-{{ $paymentBadge }}">
                    {{ $paymentStatus }}
                </span>
            </td>

            <td>{{ strtoupper($order->payment_type) }}</td>

            <td>₹{{ number_format($order->total, 2) }}</td>

            <td>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="{{ route('orders.invoice', $order->id) }}"
                       class="btn btn-sm btn-primary"
                       target="_blank">
                        View
                    </a>

                    @if($order->status == 4)
                        <button class="btn btn-warning btn-sm reviewBtn"
                                data-order="{{ $order->id }}"
                                data-product="{{ $order->product->id }}">
                            Review
                        </button>
                    @endif

                    @if($order->status == 1)
                        <button class="btn btn-sm btn-danger"
                                onclick="updateOrderStatus({{ $order->id }}, 'cancel')">
                            Cancel
                        </button>

                        <button class="btn btn-sm btn-warning"
                                onclick="updateOrderStatus({{ $order->id }}, 'return')">
                            Return
                        </button>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="{{ Auth::user()->role == 1 ? 11 : 10 }}"
                class="text-center">
                No Orders Found
            </td>
        </tr>
    @endforelse
</tbody>
            </table>

            <div class="mt-3">
                {{ $orders->appends(['status'=> request('status')])->links() }}
            </div>
        </div>
    </div>
    <!-- Hidden Review Div -->
<div id="reviewDiv" class="card p-3 mt-3" style="display: none;">
    <h5>Write a Review</h5>
    <input type="hidden" id="review_order_id">
    <input type="hidden" id="review_product_id">

    <div class="mb-3">
        <label>Rating</label>
        <select id="rating" class="form-control">
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Review</label>
        <textarea id="review" class="form-control" rows="4"></textarea>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button class="btn btn-secondary" id="cancelReview">Cancel</button>
        <button class="btn btn-success" id="submitReview">Submit</button>
    </div>
</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@push('scripts')


<script>
    $(document).on('click', '.reviewBtn', function () {
        $('#review_order_id').val($(this).data('order'));
        $('#review_product_id').val($(this).data('product'));
        $('#reviewDiv').slideDown(); // show div with slide effect

        // Scroll to the review div for better UX
        $('html, body').animate({
            scrollTop: $("#reviewDiv").offset().top
        }, 500);
    });

    // Hide review div
    $('#cancelReview').on('click', function () {
        $('#reviewDiv').slideUp(); // hide div
        $('#review_order_id').val('');
        $('#review_product_id').val('');
        $('#review').val('');
        $('#rating').val('5');
    });
    $('#submitReview').on('click', function () {

    $.ajax({
        url: "{{ route('review.store') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            order_id: $('#review_order_id').val(),
            product_id: $('#review_product_id').val(),
            rating: $('#rating').val(),
            review: $('#review').val()
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Thank you!',
                text: 'Review submitted successfully',
                timer: 2000,
                showConfirmButton: false
            }).then(() => location.reload());
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ?? 'Something went wrong'
            });
        }
    });
});
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Status",
            allowClear: true,
            width: '100%'
        });
    });

    function updateOrderStatus(orderId, type) {
        let actionText = type === 'cancel' ? 'cancelling' : 'returning';
        let route = type === 'cancel' ?
            "{{ route('orders.cancel', ['order' => 'ORDER_ID']) }}" :
            "{{ route('orders.return', ['order' => 'ORDER_ID']) }}";

        route = route.replace('ORDER_ID', orderId);

        Swal.fire({
            title: `Reason for ${actionText} the order`,
            input: 'text',
            inputPlaceholder: 'Enter reason here...',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to provide a reason!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            reason: result.value
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.success ? 'success' : 'error',
                            title: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            text: err.message,
                        });
                    });
            }
        });
    }
    
</script>
@endpush

@endsection