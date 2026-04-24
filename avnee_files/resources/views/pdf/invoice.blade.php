<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; color: #555; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 10px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; font-weight: bold; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #f7f7f7; border-bottom: 1px solid #ddd; font-weight: bold; text-transform: uppercase; font-size: 12px; }
        .invoice-box table tr.details td { padding-bottom: 10px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; font-size: 14px; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td { border-top: 2px solid #eee; font-weight: bold; font-size: 18px; color: #444; }
        .footer { margin-top: 30px; text-align: center; color: #999; font-size: 12px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .badge-paid { background: #dcfce7; color: #166534; }
        .badge-unpaid { background: #fef9c3; color: #854d0e; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td class="title">
                                <span style="color: #4f46e5;">AVNEE</span>
                            </td>
                            <td>
                                Invoice #: {{ $order->order_number }}<br>
                                Created: {{ $order->created_at->format('M d, Y') }}<br>
                                Status: <span class="badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">{{ $order->payment_status }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <strong>Avnee Collections</strong><br>
                                123 Artisan Lane, Jewellery Hub<br>
                                Jaipur, Rajasthan 302001<br>
                                GSTIN: 08AAACA0000A1Z5
                            </td>
                            <td>
                                <strong>Bill To:</strong><br>
                                {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}<br>
                                {{ $order->shipping_address['address'] }}, {{ $order->shipping_address['apartment'] ? $order->shipping_address['apartment'] . ', ' : '' }}<br>
                                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} - {{ $order->shipping_address['pincode'] }}<br>
                                {{ $order->customer_email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item Details</td>
                <td style="text-align: center;">Qty</td>
                <td>Price</td>
            </tr>

            @foreach($order->items as $item)
                <tr class="item {{ $loop->last ? 'last' : '' }}">
                    <td>
                        {{ $item->product_name }}<br>
                        <small style="color: #888;">{{ $item->variant_details }}</small>
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td style="text-align: right; font-size: 14px; color: #888;">Subtotal</td>
                <td>₹{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td style="text-align: right; font-size: 14px; color: #888;">Shipping</td>
                <td>₹{{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td style="text-align: right; color: #4f46e5;">Grand Total</td>
                <td style="color: #4f46e5;">₹{{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for choosing Avnee Collections. For any queries, contact us at support@avnee.com</p>
            <p>Computer generated invoice, no signature required.</p>
        </div>
    </div>
</body>
</html>
