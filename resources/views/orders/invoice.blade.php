<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Invoice #{{ $order->id }}</title>
  <style>
    @font-face {
      font-family: 'DejaVu Sans';
      src: url('vendor/dompdf/dompdf/lib/fonts/DejaVuSans.ttf') format('truetype');
    }

    body {
      font-family: 'DejaVu Sans', sans-serif;
      color: #1f2937;
      font-size: 14px;
      background: #ffffff;
    }

    .invoice-box {
      max-width: 800px;
      margin: auto;
      border: 1px solid #e5e7eb;
      box-shadow: 0 0 8px rgba(15, 23, 42, 0.06);
      padding: 22px;
      border-radius: 10px;
    }

    .header {
      margin-bottom: 18px;
      border-bottom: 2px solid #4f46e5;
      padding-bottom: 12px;
    }

    .header table {
      width: 100%;
    }

    .header h1 {
      color: #4338ca;
      margin: 0;
      font-size: 30px;
      line-height: 1;
    }

    .brand-cell {
      vertical-align: top;
    }

    .brand-subtitle {
      color: #6b7280;
    }

    .invoice-details {
      text-align: right;
      vertical-align: top;
    }

    .detail-row {
      margin-bottom: 4px;
    }

    .status-row {
      margin-top: 8px;
    }

    .information {
      margin-bottom: 16px;
    }

    .information table {
      width: 100%;
    }

    .information td {
      vertical-align: top;
      width: 50%;
      overflow-wrap: anywhere;
      word-break: break-word;
    }

    table.items {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #e5e7eb;
    }

    table.items th {
      background: #f9fafb;
      border-bottom: 2px solid #d1d5db;
      color: #374151;
      font-weight: bold;
      text-align: left;
      padding: 9px 10px;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.03em;
    }

    table.items td {
      border-bottom: 1px solid #e5e7eb;
      padding: 9px 10px;
      vertical-align: top;
      overflow-wrap: anywhere;
      word-break: break-word;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .fw-bold {
      font-weight: bold;
    }

    .item-meta {
      color: #6b7280;
      font-size: 10px;
    }

    .total-section {
      margin-top: 16px;
      text-align: right;
    }

    .total-table {
      width: 42%;
      margin-left: auto;
      border-collapse: collapse;
    }

    .total-table td {
      padding: 5px;
      border-bottom: 1px solid #e5e7eb;
      overflow-wrap: anywhere;
      word-break: break-word;
    }

    .grand-total {
      font-size: 18px;
      font-weight: bold;
      color: #4338ca;
      border-top: 2px solid #4f46e5 !important;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 12px;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
      padding-top: 12px;
    }

    .badge {
      display: inline-block;
      padding: 4px 9px;
      font-size: 11px;
      line-height: 1;
      border-radius: 999px;
      color: white;
      background-color: #6b7280;
      vertical-align: middle;
      margin-left: 5px;
    }

    .badge-completed {
      background-color: #198754;
    }

    .badge-pending {
      background-color: #ffc107;
      color: #1f2937;
    }

    .badge-processing {
      background-color: #0ea5e9;
      color: #ffffff;
    }

    .badge-cancelled {
      background-color: #dc3545;
    }
  </style>
</head>

<body>
  <div class="invoice-box">
    <!-- Header -->
    <div class="header">
      <table>
        <tr>
          <td class="brand-cell">
            <h1>ShopEasy</h1>
            <small class="brand-subtitle">Your trusted online store</small>
          </td>
          <td class="invoice-details">
            <div class="detail-row"><strong>INVOICE #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
            <div class="detail-row">Date: {{ $order->created_at->format('F d, Y') }}</div>
            <div class="detail-row status-row">
              Status: <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <!-- Information -->
    <div class="information">
      <table>
        <tr>
          <td>
            <strong>Bill To:</strong><br>
            {{ $order->user->name }}<br>
            {!! nl2br(e($order->shipping_address)) !!}<br>
            Tel: {{ $order->phone }}<br>
            Email: {{ $order->user->email }}
          </td>
          <td class="text-right">
            <strong>Payment Method:</strong><br>
            {{ ucfirst($order->payment_method) }}<br><br>
            <strong>Shipping Method:</strong><br>
            Standard Delivery (Free)
          </td>
        </tr>
      </table>
    </div>

    <!-- Items Table -->
    <table class="items">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th width="50%">Item / Description</th>
          <th width="15%" class="text-center">Qty</th>
          <th width="15%" class="text-right">Price</th>
          <th width="15%" class="text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->orderItems as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>
            <span class="fw-bold">{{ $item->product->name }}</span><br>
            <small class="item-meta">Category: {{ $item->product->category->name }}</small>
          </td>
          <td class="text-center">{{ $item->quantity }}</td>
          <td class="text-right">&#8377; {{ number_format($item->price, 2) }}</td>
          <td class="text-right">&#8377; {{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Totals -->
    <div class="total-section">
      <table class="total-table">
        <tr>
          <td>Subtotal:</td>
          <td class="text-right">&#8377; {{ number_format($order->total_amount, 2) }}</td>
        </tr>
        <tr>
          <td>Tax (0%):</td>
          <td class="text-right">&#8377; 0.00</td>
        </tr>
        <tr>
          <td>Shipping:</td>
          <td class="text-right">Free</td>
        </tr>
        <tr class="grand-total">
          <td>Total:</td>
          <td class="text-right">&#8377; {{ number_format($order->total_amount, 2) }}</td>
        </tr>
      </table>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>Thank you for shopping with ShopEasy!<br>
        For any queries, contact support@shopeasy.com or call +91-9876543210</p>
      <p><small>This is a computer-generated invoice and does not require a signature.</small></p>
    </div>
  </div>
</body>

</html>