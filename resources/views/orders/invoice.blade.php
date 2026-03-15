<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            margin-bottom: 40px;
            border-bottom: 3px solid #4F39F6;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #4F39F6;
            font-size: 32px;
            margin-bottom: 5px;
        }

        .header .tagline {
            color: #666;
            font-size: 14px;
        }

        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .invoice-info>div {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .invoice-info h3 {
            color: #4F39F6;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .invoice-info p {
            margin-bottom: 5px;
        }

        .invoice-details {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .invoice-details table {
            width: 100%;
        }

        .invoice-details td {
            padding: 5px 0;
        }

        .invoice-details td:first-child {
            font-weight: bold;
            width: 150px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background: #4F39F6;
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .items-table tbody tr:hover {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-left: auto;
            width: 300px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .totals td:first-child {
            font-weight: 600;
        }

        .totals td:last-child {
            text-align: right;
        }

        .totals .total-row {
            background: #4F39F6;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        .totals .total-row td {
            padding: 12px 0;
            border: none;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 11px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Morven</h1>
            <p class="tagline">Premium Men's Fashion & Lifestyle</p>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div>
                <h3>Invoice To:</h3>
                <p><strong>{{ $order->customer_name }}</strong></p>
                <p>{{ $order->customer_email }}</p>
                <p>{{ $order->customer_phone }}</p>
                @if ($order->delivery_option === 'delivery' && $order->delivery_address)
                    <p>{{ $order->delivery_address }}</p>
                @endif
            </div>
            <div style="text-align: right;">
                <h3>Invoice Details:</h3>
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Payment Status:</strong>
                    <span class="status-badge status-{{ $order->payment_status }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="invoice-details">
            <table>
                <tr>
                    <td>Order Status:</td>
                    <td>{{ ucfirst($order->order_status) }}</td>
                </tr>
                <tr>
                    <td>Payment Method:</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                </tr>
                @if ($order->payment_via)
                    <tr>
                        <td>Payment Via:</td>
                        <td>{{ ucfirst($order->payment_via) }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Delivery Option:</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $order->delivery_option)) }}</td>
                </tr>
                @if ($order->payment_reference)
                    <tr>
                        <td>Payment Reference:</td>
                        <td>{{ $order->payment_reference }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->size ?? '-' }}</td>
                        <td>{{ $item->color ? ucfirst($item->color) : '-' }}</td>
                        <td class="text-right">GHS {{ number_format($item->price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">GHS {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>GHS {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Delivery Fee:</td>
                    <td>GHS {{ number_format($order->delivery_fee, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total:</td>
                    <td>GHS {{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for shopping with Morven!</strong></p>
            <p>For any inquiries, please contact us at support@Morven.com</p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>

</html>
