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
      color: #333;
      font-size: 14px;
    }

    .invoice-box {
      max-width: 800px;
      margin: auto;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, .05);
      padding: 20px;
    }

    .header {
      margin-bottom: 20px;
      border-bottom: 2px solid #0d6efd;
      padding-bottom: 10px;
    }

    .header table {
      width: 100%;
    }

    .header h1 {
      color: #0d6efd;
      margin: 0;
      font-size: 32px;
    }

    .invoice-details {
      text-align: right;
      vertical-align: top;
    }

    .information {
      margin-bottom: 20px;
    }

    .information table {
      width: 100%;
    }

    .information td {
      vertical-align: top;
      width: 50%;
    }

    table.items {
      width: 100%;
      border-collapse: collapse;
    }

    table.items th {
      background: #f8f9fa;
      border-bottom: 2px solid #dee2e6;
      color: #495057;
      font-weight: bold;
      text-align: left;
      padding: 10px;
    }

    table.items td {
      border-bottom: 1px solid #eee;
      padding: 10px;
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

    .total-section {
      margin-top: 20px;
      text-align: right;
    }

    .total-table {
      width: 40%;
      margin-left: auto;
      border-collapse: collapse;
    }

    .total-table td {
      padding: 5px;
      border-bottom: 1px solid #ddd;
    }

    .grand-total {
      font-size: 18px;
      font-weight: bold;
      color: #0d6efd;
      border-top: 2px solid #0d6efd !important;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      font-size: 12px;
      color: #777;
      border-top: 1px solid #eee;
      padding-top: 10px;
    }

    .badge {
      display: inline-block;
      padding: 5px 10px;
      font-size: 11px;
      line-height: 1;
      border-radius: 4px;
      color: white;
      background-color: #6c757d;
      vertical-align: middle;
      margin-left: 5px;
    }

    .badge-completed {
      background-color: #198754;
    }

    .badge-pending {
      background-color: #ffc107;
      color: black;
    }

    .badge-cancelled {
      background-color: #dc3545;
    }

    .detail-row {
      margin-bottom: 4px;
    }
  </style>
</head>

<body>
  <div class="invoice-box">
    <!-- Header -->
    <div class="header">
      <table>
        <tr>
          <td style="vertical-align: top;">
            <h1>ShopEasy</h1>
            <small style="color: #777;">Your trusted online store</small>
          </td>
          <td class="invoice-details">
            <div class="detail-row"><strong>INVOICE #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
            <div class="detail-row">Date: {{ $order->created_at->format('F d, Y') }}</div>
            <div class="detail-row" style="margin-top: 8px;">
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
            <small style="color: #666; font-size: 10px;">Category: {{ $item->product->category->name }}</small>
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