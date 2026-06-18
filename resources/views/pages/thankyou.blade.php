@extends('layouts.app')
@section('content')
<div class="page-content bg-light">
    <div class="dz-bnr-inr bg-secondary overlay-black-light" style="background-image:url(images/new-images/site-banner.jpg);">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Order Confirmed</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item">Thank You</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="content-inner-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-circle-check text-success" style="font-size:60px;"></i>
                        <h3 class="mt-3">Thank you for your order!</h3>
                        <p class="text-muted">Your payment was successful and your order is being processed.</p>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap mb-3">
                                <div><strong>Order ID:</strong> {{ $orderId }}</div>
                                <div><strong>Order Date:</strong> {{ optional($orders->first()->order_date)->format('d M Y, h:i A') }}</div>
                            </div>

                            @if($orders->first()->shippingAddress)
                                @php $addr = $orders->first()->shippingAddress; @endphp
                                <div class="mb-3">
                                    <strong>Shipping Address:</strong><br>
                                    {{ $addr->first_name ?? '' }} {{ $addr->last_name ?? '' }}<br>
                                    {{ $addr->street ?? '' }}, {{ $addr->city ?? '' }}, {{ $addr->state ?? '' }} - {{ $addr->zip_code ?? '' }}<br>
                                    {{ $addr->country_region ?? '' }}<br>
                                    Phone: {{ $addr->phone ?? '' }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Tax</th>
                                            <th>Discount</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>₹{{ number_format($item->product_price, 2) }}</td>
                                            <td>₹{{ number_format($item->tax, 2) }}</td>
                                            <td>₹{{ number_format($item->coupon_discount, 2) }}</td>
                                            <td class="text-end">₹{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-end">Grand Total</th>
                                            <th class="text-end">₹{{ number_format($total, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <p class="text-muted mb-0">Estimated delivery: {{ optional($orders->first()->delivery_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ url('/') }}" class="btn btn-secondary me-2">Continue Shopping</a>
                        <a href="{{ url('/my-orders') }}" class="btn btn-outline-secondary">View My Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection