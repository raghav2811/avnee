<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ $order->order_number }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 0; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f6f9fc; padding-bottom: 40px; }
        .main { background-color: #ffffff; border-radius: 8px; max-width: 600px; margin: 0 auto; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }
        .header { background-color: #4f46e5; padding: 40px 20px; text-align: center; color: #ffffff; }
        .content { padding: 40px 30px; color: #4a5568; line-height: 1.6; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #a0aec0; }
        .order-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .order-table th { text-align: left; padding: 12px; border-bottom: 2px solid #edf2f7; font-size: 14px; text-transform: uppercase; color: #718096; }
        .order-table td { padding: 12px; border-bottom: 1px solid #edf2f7; font-size: 14px; }
        .total-row td { border-bottom: none; font-weight: bold; font-size: 16px; color: #2d3748; }
        .button { background-color: #4f46e5; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold; margin-top: 20px; }
        .address-box { background-color: #f7fafc; padding: 20px; border-radius: 6px; margin: 20px 0; }
        h1 { margin: 0; font-size: 24px; font-weight: 700; }
        h2 { font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #2d3748; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <div class="header">
                <h1>Order Confirmed!</h1>
                <p>Order #{{ $order->order_number }}</p>
            </div>
            
            <div class="content">
                <p>Hi {{ $order->shipping_address['first_name'] }},</p>
                <p>Thank you for your order! We're processing it now and will notify you as soon as it's on its way. We've attached your invoice to this email for your records.</p>
                
                <h2>Order Summary</h2>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product_name }}</strong><br>
                                    <small>{{ $item->variant_details }}</small>
                                </td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: right;">₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="2" style="text-align: right; padding-top: 20px;">Shipping</td>
                            <td style="text-align: right; padding-top: 20px;">₹{{ number_format($order->shipping_cost, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2" style="text-align: right;">Grand Total</td>
                            <td style="text-align: right; color: #4f46e5;">₹{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="address-box">
                    <h2>Shipping Address</h2>
                    <p style="margin: 0; font-size: 14px;">
                        {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}<br>
                        {{ $order->shipping_address['address'] }}<br>
                        {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} - {{ $order->shipping_address['pincode'] }}
                    </p>
                </div>

                <div style="text-align: center;">
                    <a href="{{ route('dashboard') }}" class="button">View Order Details</a>
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Avnee Collections. All rights reserved.</p>
                <p>123 Artisan Lane, Jewellery Hub, Jaipur, Rajasthan</p>
            </div>
        </div>
    </div>
</body>
</html>
