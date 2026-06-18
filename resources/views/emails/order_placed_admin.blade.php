<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Received</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; margin:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:0 auto; background:#fff; border-radius:8px; overflow:hidden;">
        <tr>
            <td style="background:#111827; padding:20px; text-align:center;">
                <h2 style="color:#fff; margin:0;">New Order Received</h2>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">
                <p><strong>Order ID:</strong> {{ $orderId }}</p>
                <p><strong>Customer:</strong> {{ $customer->name ?? 'N/A' }} ({{ $customer->email ?? 'N/A' }})</p>

                <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin-top:10px;">
                    <thead>
                        <tr style="background:#f4f4f4; text-align:left;">
                            <th style="border-bottom:1px solid #e0e0e0;">Product</th>
                            <th style="border-bottom:1px solid #e0e0e0;">Qty</th>
                            <th style="border-bottom:1px solid #e0e0e0;">Price</th>
                            <th style="border-bottom:1px solid #e0e0e0;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                        <tr>
                            <td style="border-bottom:1px solid #f0f0f0;">{{ $item->product_name }}</td>
                            <td style="border-bottom:1px solid #f0f0f0;">{{ $item->quantity }}</td>
                            <td style="border-bottom:1px solid #f0f0f0;">₹{{ number_format($item->product_price, 2) }}</td>
                            <td style="border-bottom:1px solid #f0f0f0;">₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right; font-weight:bold; padding-top:10px;">Grand Total</td>
                            <td style="font-weight:bold; padding-top:10px;">₹{{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>