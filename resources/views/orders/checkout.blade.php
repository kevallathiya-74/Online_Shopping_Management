@extends('layouts.app')

@section('title', 'Checkout - ShopEasy')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-credit-card text-primary"></i> Checkout</h2>
            <p class="text-muted mb-0">Complete your order by providing shipping details</p>
        </div>
        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Cart
        </a>
    </div>

    <form action="{{ route('orders.place') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row">
            <!-- Shipping & Payment Form -->
            <div class="col-lg-7 mb-4">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-truck text-primary"></i> Shipping Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt"></i> Shipping Address <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" 
                                      name="shipping_address" 
                                      rows="3" 
                                      placeholder="Enter your complete delivery address"
                                      required>{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone"></i> Phone Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="e.g., 9876543210"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <div class="card-header py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-wallet text-success"></i> Payment Method</h5>
                    </div>
                    <div class="card-body p-4">
                        @error('payment_method')
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        <div class="row g-3">
                            <!-- Cash on Delivery -->
                            <div class="col-md-6">
                                <div class="form-check card h-100" style="cursor: pointer;">
                                    <div class="card-body p-3">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="payment_offline" value="offline" 
                                               {{ old('payment_method', 'offline') == 'offline' ? 'checked' : '' }}
                                               style="position: absolute; top: 15px; right: 15px;">
                                        <label class="form-check-label d-block" for="payment_offline" style="cursor: pointer;">
                                            <div class="text-center py-2">
                                                <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                                <h6 class="fw-bold mb-1">Cash on Delivery</h6>
                                                <small class="text-muted">Pay when you receive your order</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Online Payment -->
                            <div class="col-md-6">
                                <div class="form-check card h-100" style="cursor: pointer;">
                                    <div class="card-body p-3">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="payment_online" value="online"
                                               {{ old('payment_method') == 'online' ? 'checked' : '' }}
                                               style="position: absolute; top: 15px; right: 15px;">
                                        <label class="form-check-label d-block" for="payment_online" style="cursor: pointer;">
                                            <div class="text-center py-2">
                                                <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                                <h6 class="fw-bold mb-1">Online Payment</h6>
                                                <small class="text-muted">Pay securely via UPI / Card / Net Banking</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Note:</strong> Online payment is simulated for this demo. 
                            No real payment will be processed.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-receipt"></i> Order Summary</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Cart Items List -->
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-start mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                                <div class="d-flex align-items-center" style="flex: 1;">
                                    <div style="width: 45px; height: 45px; background: #f8f9fc; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                        @if($item->product->image)
                                            <img src="{{ $item->product->image }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 style="max-width: 35px; max-height: 35px; object-fit: contain;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <i class="fas fa-box text-muted" style="display:none;"></i>
                                        @else
                                            <i class="fas fa-box text-muted"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="fw-bold d-block">{{ Str::limit($item->product->name, 25) }}</small>
                                        <small class="text-muted">Qty: {{ $item->quantity }} × ₹{{ number_format($item->product->price, 0) }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <strong>₹{{ number_format($item->product->price * $item->quantity, 2) }}</strong>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Items:</span>
                            <strong>{{ $cartItems->count() }} product(s)</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <strong>₹{{ number_format($total, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping:</span>
                            <strong class="text-success">FREE</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">Total Amount:</h5>
                            <h4 class="text-success fw-bold mb-0">₹{{ number_format($total, 2) }}</h4>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg"
                                onclick="return confirm('Are you sure you want to place this order for ₹{{ number_format($total, 2) }}?')">
                            <i class="fas fa-check-circle"></i> Place Order
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock"></i> Your information is secure and encrypted
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
