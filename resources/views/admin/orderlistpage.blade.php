@extends('admin.layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<section class="content-inner">
    <div class="container">
        <!-- Add Coupon Form -->


        <!-- Coupon List Table -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                   <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="orderTable">
                        <thead class="table-dark">
                            <tr>
                                <th>S.No</th>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Shipping Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>#{{ $order->order_id }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ $order->product->product_name ?? 'N/A' }}</td>
                                <td>₹{{ number_format($order->total, 2) }}</td>
                                <td>
                                @php
                                    $paymentStatus = empty($order->payment_status) ? 'Unpaid' : 'Paid';
                                    $paymentBadge = empty($order->payment_status) ? 'danger' : 'success';
                                @endphp

                                <span class="badge bg-{{ $paymentBadge }}">
                                    {{ $paymentStatus }}
                                </span>
                            </td>
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
                                1 => 'info', // Confirmed → green
                                2 => 'warning', // Returned → yellow/orange
                                3 => 'danger', // Cancelled → red
                                4 => 'success', // Cancelled → red
                                ];

                                @endphp
                                <td>
                                    <select class="form-select order-status" data-id="{{ $order->id }}">
                                        @foreach($statusText as $key => $status)
                                            <option value="{{ $key }}"
                                                {{ $order->status == $key ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Shipping Status -->
                                @php
                                $shippingStatuses = [
                                1 => 'pending',
                                2 => 'shipped',
                                3 => 'delivered',
                                ];
                                @endphp

                               <td>
                                    <select class="form-select shipping-status" data-id="{{ $order->id }}">
                                        @foreach($shippingStatuses as $key => $ship)
                                            <option value="{{ $key }}"
                                                {{ $order->shipping_status == $key ? 'selected' : '' }}>
                                                {{ ucfirst($ship) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <button class="btn btn-primary btn-sm updateStatusBtn"
                                        data-id="{{ $order->id }}">
                                        Update
                                    </button>

                                       <a href="{{ route('admin.orders.invoice', $order->id) }}"
                                        class="btn btn-info btn-sm"
                                        target="_blank">
                                             View 
                                        </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#orderTable').DataTable();
});
</script>

{{-- @push('scripts') --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    $('.updateStatusBtn').click(function () {

        let id = $(this).data('id');
        let button = $(this);

        let orderStatus = $('.order-status[data-id="' + id + '"]').val();
        let shippingStatus = $('.shipping-status[data-id="' + id + '"]').val();

        $.ajax({
            url: "{{ url('admin/orders/update-status') }}/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: orderStatus,
                shipping_status: shippingStatus
            },
            beforeSend: function () {
                button.prop('disabled', true).text('Updating...');
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                let message = 'Something went wrong.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            },
            complete: function () {
                button.prop('disabled', false).text('Update');
            }
        });

    });

});
</script>
{{-- @endpush --}}
@endsection