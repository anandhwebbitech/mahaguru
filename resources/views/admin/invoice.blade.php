<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_id }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fb;
            color: #333;
            padding: 30px 15px;
        }

        .invoice-wrapper {
            max-width: 950px;
            margin: auto;
        }

        .invoice-box {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 25px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .company-logo img {
            max-width: 220px;
            height: auto;
        }

        .company-details {
            margin-top: 15px;
            line-height: 1.8;
            font-size: 14px;
            color: #555;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h1 {
            font-size: 42px;
            color: #0d6efd;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .invoice-title p {
            line-height: 1.8;
        }

        .section-title {
            font-size: 22px;
            color: #0d6efd;
            margin-bottom: 15px;
            border-left: 5px solid #0d6efd;
            padding-left: 12px;
        }

        .customer-box,
        .payment-info {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 35px;
            line-height: 1.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: #0d6efd;
            color: #fff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #f9fbff;
        }

        .grand-total {
            margin-top: 30px;
            text-align: right;
        }

        .grand-total h2 {
            display: inline-block;
            background: #0d6efd;
            color: #fff;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 26px;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 30px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-success { background: #198754; }
        .badge-danger { background: #dc3545; }
        .badge-warning { background: #ffc107; color: #000; }
        .badge-primary { background: #0d6efd; }
        .badge-info { background: #0dcaf0; color: #000; }

        .print-btn {
            text-align: center;
            margin-top: 40px;
        }

        .print-btn button {
            background: #198754;
            color: #fff;
            border: none;
            padding: 14px 35px;
            font-size: 17px;
            border-radius: 10px;
            cursor: pointer;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .invoice-box {
                box-shadow: none;
                border-radius: 0;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

@php
    $orderStatuses = [
        0 => 'Pending',
        1 => 'Confirmed',
        2 => 'Returned',
        3 => 'Cancelled',
        4 => 'Delivered',
    ];

    $shippingStatuses = [
        1 => 'Pending',
        2 => 'Shipped',
        3 => 'Delivered',
    ];

    $paymentStatus = empty($order->payment_status) ? 'Unpaid' : 'Paid';
@endphp

<div class="invoice-wrapper">
    <div class="invoice-box">

        <!-- Header -->
        <div class="invoice-header">
            <div>
                <div class="company-logo">
                    <img src="{{ asset('assets/images/new-images/logo.png') }}" alt="Mahaguru Logo">
                </div>

                <div class="company-details">
                    <strong>Mahaguru</strong><br>
                    3/2, Raju Nagar, Vasiyapuram,<br>
                    Zamin Uthukuli (PO), Pollachi - 642004<br>
                    Email: ananya.priya9597@gmail.com<br>
                    Phone: +91 9597990975
                </div>
            </div>

            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>
                    <strong>Invoice No:</strong> #{{ $order->order_id }}<br>
                    <strong>Date:</strong> {{ $order->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- Customer Details -->
        <h3 class="section-title">Customer Details</h3>

        <div class="customer-box">
            <strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}<br>
            <strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}<br>
            <strong>Phone:</strong> {{ $order->shippingAddress->phone ?? '-' }}<br>
            <strong>Address:</strong>
            {{ $order->shippingAddress->street ?? '-' }},
            {{ $order->shippingAddress->city ?? '' }},
            {{ $order->shippingAddress->state ?? '' }} -
            {{ $order->shippingAddress->zip_code ?? '' }}
        </div>

        <!-- Product Details -->
        <h3 class="section-title">Order Details</h3>

        <table>
          <thead>
    <tr>
        <th>Product Name</th>
        <th>Subtotal</th>
        <th>Discount</th>

        @php
            $customerState = strtolower(trim($order->shippingAddress->state ?? ''));
            $companyState  = 'tamil nadu';

            $taxAmount = $order->tax ?? 0;

            $cgst = 0;
            $sgst = 0;
            $igst = 0;

            if ($taxAmount > 0) {
                if ($customerState === $companyState) {
                    $cgst = $taxAmount / 2;
                    $sgst = $taxAmount / 2;
                } else {
                    $igst = $taxAmount;
                }
            }
        @endphp

        @if($customerState === $companyState)
            <th>CGST</th>
            <th>SGST</th>
        @else
            <th>IGST</th>
        @endif

        <th>Total</th>
    </tr>
</thead>

<tbody>
    <tr>
        <td>{{ $order->product->product_name ?? 'N/A' }}</td>
        <td>₹{{ number_format($order->subtotal, 2) }}</td>
        <td>₹{{ number_format($order->coupon_discount ?? 0, 2) }}</td>

        @if($customerState === $companyState)
            <td>₹{{ number_format($cgst, 2) }}</td>
            <td>₹{{ number_format($sgst, 2) }}</td>
        @else
            <td>₹{{ number_format($igst, 2) }}</td>
        @endif

        <td>₹{{ number_format($order->total, 2) }}</td>
    </tr>
</tbody>
        </table>

        <!-- Total -->
        <div class="grand-total">
            <h2>Grand Total: ₹{{ number_format($order->total ?? 0, 2) }}</h2>
        </div>

        <!-- Payment & Status -->
        <h3 class="section-title" style="margin-top:40px;">Payment Information</h3>

        <div class="payment-info">
            <strong>Payment Method:</strong>
            {{ strtoupper($order->payment_type ?? 'COD') }}
            <br><br>

            <strong>Payment Status:</strong>
            <span class="badge {{ empty($order->payment_status) ? 'badge-danger' : 'badge-success' }}">
                {{ $paymentStatus }}
            </span>
            <br><br>

            <strong>Order Status:</strong>
            <span class="badge badge-primary">
                {{ $orderStatuses[$order->status] ?? 'Unknown' }}
            </span>
            <br><br>

            <strong>Shipping Status:</strong>
            <span class="badge badge-info">
                {{ $shippingStatuses[$order->shipping_status] ?? 'Pending' }}
            </span>
        </div>

        <!-- Print -->
        <div class="print-btn">
            <button onclick="window.print()">🖨 Print Invoice</button>
        </div>

    </div>
</div>

</body>
</html>