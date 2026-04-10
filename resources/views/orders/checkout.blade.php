@extends('layouts.app')

@section('title', 'Checkout - ShopEasy')

@section('content')
<div class="container">
    <x-page-header
        title="Checkout"
        subtitle="Review shipping details, choose a payment method, and place your order securely."
        icon="fas fa-credit-card">
        <x-slot name="actions">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Cart
            </a>
        </x-slot>
    </x-page-header>

    <div class="section-card mb-4">
        <div class="card-body py-3 d-flex flex-wrap gap-3 align-items-center">
            <span class="auth-step active">1</span><span class="small fw-semibold text-muted">Shipping</span>
            <i class="fas fa-arrow-right text-muted small"></i>
            <span class="auth-step active">2</span><span class="small fw-semibold text-muted">Payment</span>
            <i class="fas fa-arrow-right text-muted small"></i>
            <span class="auth-step pending">3</span><span class="small fw-semibold text-muted">Place Order</span>
        </div>
    </div>

    <form action="{{ route('orders.place') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="section-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-truck text-primary me-2"></i>Shipping Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                id="shipping_address"
                                name="shipping_address"
                                rows="3"
                                placeholder="Enter your complete delivery address"
                                autocomplete="street-address"
                                required>{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="e.g., 9876543210"
                                autocomplete="tel"
                                pattern="^\d{10}$"
                                title="Phone number must be exactly 10 digits"
                                required>
                            @error('phone')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-wallet text-success me-2"></i>Payment Method</h5>
                    </div>
                    <div class="card-body p-4">
                        @error('payment_method')
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-option h-100">
                                    <input type="radio" name="payment_method" id="payment_offline" value="offline"
                                        {{ old('payment_method', 'offline') == 'offline' ? 'checked' : '' }}>
                                    <label for="payment_offline">
                                        <div class="text-center py-2">
                                            <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                            <h6 class="fw-bold mb-1">Cash on Delivery</h6>
                                            <small class="text-muted">Pay after delivery at your address.</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-option h-100">
                                    <input type="radio" name="payment_method" id="payment_online" value="online"
                                        {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                                    <label for="payment_online">
                                        <div class="text-center py-2">
                                            <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                            <h6 class="fw-bold mb-1">Online Payment</h6>
                                            <small class="text-muted">UPI, cards, and net banking via Razorpay.</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="section-card summary-card sticky-top summary-sticky">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-1"></i>Order Summary</h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach($cartItems as $item)
                        @php($product = $item->product)
                        <div class="d-flex justify-content-between align-items-start mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                            <div class="d-flex align-items-center flex-fill-min">
                                <div class="thumb-box thumb-square-45 me-2">
                                    @if($product?->image)
                                    <img src="{{ $product->image }}"
                                        alt="{{ $product->name }}"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <i class="fas fa-box text-muted d-none"></i>
                                    @else
                                    <i class="fas fa-box text-muted"></i>
                                    @endif
                                </div>
                                <div>
                                    <small class="fw-bold d-block text-wrap-anywhere">{{ Str::limit($product?->name ?? 'Product unavailable', 25) }}</small>
                                    <small class="text-muted">Qty: {{ $item->quantity }} × ₹{{ number_format($product?->price ?? 0, 0) }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <strong>₹{{ number_format(($product?->price ?? 0) * $item->quantity, 2) }}</strong>
                            </div>
                        </div>
                        @endforeach

                        <hr>

                        <div class="summary-list">
                            <div class="summary-row">
                                <span class="text-muted">Items:</span>
                                <strong>{{ $cartItems->count() }} product(s)</strong>
                            </div>
                            <div class="summary-row">
                                <span class="text-muted">Subtotal:</span>
                                <strong>₹{{ number_format($total, 2) }}</strong>
                            </div>
                            <div class="summary-row">
                                <span class="text-muted">Shipping:</span>
                                <strong class="text-success">FREE</strong>
                            </div>
                        </div>

                        <hr>

                        <div class="summary-row mb-4">
                            <h5 class="fw-bold mb-0">Total Amount:</h5>
                            <h4 class="text-success fw-bold mb-0">₹{{ number_format($total, 2) }}</h4>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg"
                            onclick="return confirm('Are you sure you want to place this order for ₹{{ number_format($total, 2) }}?')">
                            <i class="fas fa-check-circle me-1"></i>Place Order
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>Your information is secure and encrypted
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Hidden Form for Razorpay Verification -->
    <form id="razorpayForm" action="{{ route('payment.verify') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
</div>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (paymentMethod === 'online') {
            e.preventDefault();

            // Show loading state
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing Payment...';

            // Step 1: Create Razorpay Order via AJAX
            const formData = new FormData(this);

            fetch("{{ route('orders.place') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Step 2: Open Razorpay Modal
                        const options = {
                            "key": data.key_id,
                            "amount": data.amount,
                            "currency": "INR",
                            "name": "ShopEasy Online",
                            "description": "Payment for your order",
                            "order_id": data.razorpay_order_id,
                            "handler": function(response) {
                                // Step 3: Payment Success - Submit verification form
                                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                document.getElementById('razorpayForm').submit();
                            },
                            "prefill": {
                                "name": data.name,
                                "email": data.email,
                                "contact": data.contact
                            },
                            "theme": {
                                "color": "#4f46e5"
                            }
                        };
                        const rzp1 = new Razorpay(options);
                        rzp1.open();

                        rzp1.on('payment.failed', function(response) {
                            alert("Payment Failed: " + response.error.description);
                            btn.disabled = false;
                            btn.innerHTML = originalText;
                        });
                    } else {
                        alert("Error: " + (data.error || "Failed to initialize payment"));
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An unexpected error occurred. Please try again.");
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        } else {
            // For COD, proceed with normal form submission
            return true;
        }
    });
</script>
@endsection
