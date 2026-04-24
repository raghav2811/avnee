@extends('layouts.front.' . $theme)

@section('content')
@php
    $isDark = $theme === 'jewellery';
    $textColor = $isDark ? 'text-[#fdf2f8]' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-[#a8998a]' : 'text-gray-500';
    $borderColor = $isDark ? 'border-[#4f006a]' : 'border-gray-200';
    $cardBg = $isDark ? 'bg-[#350047]' : 'bg-gray-50';
    $accentColor = $isDark ? 'text-[#f3d9ff]' : 'text-[#b87333]';
    $accentBg = $isDark ? 'bg-[#d4af37]' : 'bg-[#b87333]';
    $accentHoverBg = $isDark ? 'hover:bg-[#6d28d9]' : 'hover:bg-[#9a5a1f]';
    $inputClass = $isDark ? 'bg-[#230030] border-[#4f006a] text-white focus:ring-[#d4af37] focus:border-[#d4af37]' : 'bg-white border-gray-300 text-gray-900 focus:ring-[#b87333] focus:border-[#b87333]';

    $subtotal = $cart->items->sum(function($item) {
        return ($item->product->price ?? $item->price) * $item->quantity;
    });
    $shipping = session('shipping_cost', 0);
    $total = $subtotal - (session('coupon_discount', 0)) + $shipping;
    $selectedPaymentMethod = old('payment_method', $isRazorpayAvailable ? 'razorpay' : ($isCodEnabled ? 'cod' : ''));
@endphp

@section('extra_js')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pincodeInput = document.querySelector('input[name="pincode"]');
        const shippingDisplay = document.getElementById('shipping-cost-display');
        const totalDisplay = document.getElementById('total-amount-display');
        const etdDisplay = document.getElementById('etd-display');
        const shippingCostInput = document.getElementById('shipping-cost-hidden');
        const subtotal = {{ $subtotal }};
        const discount = {{ session('coupon_discount', 0) }};

        pincodeInput.addEventListener('change', function() {
            const pincode = this.value;
            if (pincode.length === 6) {
                shippingDisplay.innerText = 'Calculating...';

                fetch(`{{ route('front.checkout.shipping-details') }}?pincode=${pincode}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const cost = parseFloat(data.shipping_cost);
                            shippingDisplay.innerText = '₹' + cost.toFixed(2);
                            shippingCostInput.value = cost;

                            const newTotal = (subtotal - discount) + cost;
                            totalDisplay.innerText = '₹' + newTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});

                            if (etdDisplay) {
                                etdDisplay.innerText = 'Estimated delivery: ' + data.etd;
                                etdDisplay.classList.remove('hidden');
                            }
                        } else {
                            shippingDisplay.innerText = 'Not available';
                            alert(data.message || 'Shipping not available for this pincode');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        shippingDisplay.innerText = 'Error';
                    });
            }
        });
    });
</script>
@endsection

<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16 {{ $textColor }} font-body">
    <div class="mb-10 pb-4 border-b {{ $borderColor }}">
        <h1 class="font-heading text-3xl sm:text-4xl font-normal tracking-wide text-center">Checkout</h1>
    </div>

    <form id="checkout-form" class="flex flex-col lg:flex-row gap-8 lg:gap-16">
        @csrf

        <!-- Form Section -->
        <div class="w-full lg:w-3/5">
            <!-- Contact -->
            <div class="mb-10">
                <h2 class="font-heading text-xl font-medium tracking-wide mb-6">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Email" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="mb-10">
                <h2 class="font-heading text-xl font-medium tracking-wide mb-6">Shipping Address</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->name ?? '') }}" placeholder="First Name" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('first_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('last_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Address" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                    @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <input type="text" name="apartment" value="{{ old('apartment') }}" placeholder="Apartment, suite, etc. (optional)" class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="City" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('city') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="text" name="state" value="{{ old('state') }}" placeholder="State" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('state') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="text" name="pincode" value="{{ old('pincode') }}" placeholder="PIN Code" required class="w-full text-sm rounded-sm {{ $inputClass }} p-3" />
                        @error('pincode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <p id="etd-display" class="text-[10px] mt-1 hidden {{ $accentColor }} uppercase tracking-wider font-bold"></p>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mb-10">
                <h2 class="font-heading text-xl font-medium tracking-wide mb-6">Payment Method</h2>
                <div class="space-y-4 border {{ $borderColor }} p-4 rounded-sm">
                    @if($isRazorpayAvailable)
                    <label class="flex items-center gap-3 cursor-pointer group pb-4 border-b {{ $borderColor }}">
                        <input type="radio" name="payment_method" value="razorpay" required {{ $selectedPaymentMethod === 'razorpay' ? 'checked' : '' }} class="{{ $isDark ? 'text-[#d4af37] bg-[#230030] border-[#4f006a]' : 'text-[#b87333]' }} focus:ring-0 cursor-pointer" />
                        <div class="flex-1">
                            <span class="text-sm font-semibold group-hover:{{ $accentColor }} transition-colors block">Razorpay Secure</span>
                            <span class="text-xs {{ $mutedColor }}">Credit Card, UPI, Netbanking, Wallets</span>
                        </div>
                        <div class="flex gap-1">
                            <!-- Small fake logos -->
                            <div class="w-8 h-5 {{ $cardBg }} border {{ $borderColor }} rounded-sm flex items-center justify-center text-[8px] font-bold">UPI</div>
                            <div class="w-8 h-5 {{ $cardBg }} border {{ $borderColor }} rounded-sm flex items-center justify-center text-[8px] font-bold">VISA</div>
                        </div>
                    </label>
                    @endif

                    @if($isCodEnabled)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="payment_method" value="cod" required {{ $selectedPaymentMethod === 'cod' ? 'checked' : '' }} class="{{ $isDark ? 'text-[#d4af37] bg-[#230030] border-[#4f006a]' : 'text-[#b87333]' }} focus:ring-0 cursor-pointer" />
                        <div class="flex-1">
                            <span class="text-sm font-semibold group-hover:{{ $accentColor }} transition-colors block">Cash on Delivery</span>
                            <span class="text-xs {{ $mutedColor }}">Pay when you receive your order</span>
                        </div>
                    </label>
                    @endif

                    @if(!$isRazorpayAvailable && !$isCodEnabled)
                    <div class="text-sm text-red-500">
                        No payment method is currently available. Please contact support.
                    </div>
                    @endif
                </div>
                <input type="hidden" name="shipping_cost" id="shipping_cost-hidden" value="{{ $shipping }}">
                <input type="hidden" name="idempotency_key" id="idempotency-key-hidden" value="">
                @error('payment_method') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

        </div>

        <!-- Order Summary Sidebar -->
        <div class="w-full lg:w-2/5">
            <div class="sticky top-24 {{ $cardBg }} border {{ $borderColor }} p-6 sm:p-8 rounded-sm">
                <h2 class="font-heading text-xl font-medium tracking-wide mb-6">Order Summary</h2>

                <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                    @foreach($cart->items as $item)
                    <div class="flex gap-4">
                        <div class="relative w-16 aspect-[3/4] {{ $borderColor }} border rounded-sm">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover object-top" />
                            <span class="absolute -top-2 -right-2 {{ $accentBg }} text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">{{ $item->quantity }}</span>
                        </div>
                        <div class="flex-1 text-sm">
                            <h3 class="font-semibold line-clamp-1">{{ $item->product->name }}</h3>
                            @if($item->variant)
                            <p class="{{ $mutedColor }} text-xs mt-1">{{ $item->variant->size }}</p>
                            @endif
                        </div>
                        <div class="text-sm font-semibold text-right">
                            ₹{{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Coupon Section -->
                <div class="mb-6">
                    @if(session('applied_coupon'))
                        <div class="flex items-center justify-between p-3 {{ $isDark ? 'bg-green-900/20 text-green-400' : 'bg-green-50 text-green-700' }} rounded-sm text-sm">
                            <span>Coupon <strong>{{ session('applied_coupon') }}</strong> applied</span>
                            <form action="{{ route('front.checkout.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="hover:underline font-semibold">Remove</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('front.checkout.coupon.apply') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Coupon Code" class="flex-1 text-sm rounded-sm {{ $inputClass }} p-2" />
                            <button type="submit" class="px-4 py-2 {{ $accentBg }} text-white text-xs font-bold uppercase rounded-sm hover:opacity-90">Apply</button>
                        </form>
                        @if(session('error'))
                            <p class="text-red-500 text-xs mt-1">{{ session('error') }}</p>
                        @endif
                    @endif
                </div>

                <div class="space-y-3 text-sm mb-6 border-t border-b {{ $borderColor }} py-4">
                    <div class="flex justify-between">
                        <span class="{{ $mutedColor }}">Subtotal</span>
                        <span class="font-semibold">₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    @if(session('coupon_discount'))
                    <div class="flex justify-between text-green-500">
                        <span>Discount</span>
                        <span class="font-semibold">-₹{{ number_format(session('coupon_discount'), 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="{{ $mutedColor }}">Shipping</span>
                        <span class="font-semibold" id="shipping-cost-display">{{ $shipping == 0 ? 'Enter Pincode' : '₹'.number_format($shipping, 2) }}</span>
                    </div>
                </div>

                @php
                    $finalTotal = ($subtotal - (session('coupon_discount', 0))) + $shipping;
                @endphp

                <div class="flex justify-between items-end mb-8">
                    <span class="text-base font-semibold tracking-wider uppercase">Total</span>
                    <span class="text-2xl font-semibold {{ $accentColor }}" id="total-amount-display">₹{{ number_format($total, 2) }}</span>
                </div>

                <button type="submit" id="submit-btn" class="w-full {{ $accentBg }} {{ $accentHoverBg }} text-white py-4 text-sm font-bold tracking-[0.2em] uppercase rounded-sm transition-colors shadow-md disabled:opacity-50">
                    <span id="btn-text">Complete Order</span>
                    <span id="btn-loader" class="hidden">Processing...</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function generateIdempotencyKey() {
    if (window.crypto && window.crypto.randomUUID) {
        return window.crypto.randomUUID();
    }

    return 'checkout-' + Date.now() + '-' + Math.random().toString(36).slice(2, 12);
}

document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoader = document.getElementById('btn-loader');

    submitBtn.disabled = true;
    btnText.classList.add('hidden');
    btnLoader.classList.remove('hidden');

    const formData = new FormData(form);
    const idempotencyInput = document.getElementById('idempotency-key-hidden');
    const idempotencyKey = idempotencyInput && idempotencyInput.value
        ? idempotencyInput.value
        : generateIdempotencyKey();

    if (idempotencyInput) {
        idempotencyInput.value = idempotencyKey;
    }

    formData.set('idempotency_key', idempotencyKey);

    fetch("{{ route('front.checkout.process') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-Idempotency-Key': idempotencyKey
        }
    })
    .then(async response => {
        const payload = await response.json();
        if (!response.ok) {
            throw payload;
        }
        return payload;
    })
    .then(data => {
        if (!data.success) {
            alert(data.message || 'Something went wrong');
            submitBtn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoader.classList.add('hidden');
            return;
        }

        if (data.payment_needed) {
            const options = {
                "key": data.key,
                "amount": data.amount,
                "currency": "INR",
                "name": data.name,
                "description": data.description,
                "order_id": data.razorpay_order_id,
                "handler": function (response) {
                    // Verify payment
                    fetch("{{ route('front.checkout.razorpay.verify') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Idempotency-Key': idempotencyKey
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            order_number: data.order_number
                        })
                    })
                    .then(res => res.json())
                    .then(verifyData => {
                        if (verifyData.success) {
                            let successUrl = "{{ route('front.checkout.success', ['orderNumber' => 'TEMP_ORDER_ID']) }}";
                            window.location.href = successUrl.replace('TEMP_ORDER_ID', data.order_number);
                        } else {
                            alert('Payment verification failed');
                            window.location.reload();
                        }
                    });
                },
                "prefill": {
                    "name": data.customer.name,
                    "email": data.customer.email,
                    "contact": data.customer.contact
                },
                "theme": {
                    "color": "{{ $isDark ? '#d4af37' : '#b87333' }}"
                }
            };
            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response){
                alert('Payment Failed: ' + response.error.description);
                window.location.reload();
            });
            rzp.open();
        } else {
            // COD or Free
            window.location.href = data.redirect_url;
        }
    })
    .catch(error => {
        console.error('Checkout error:', error);
        alert(error.message || error.error || 'Unable to place order right now. Please try again.');
        submitBtn.disabled = false;
        btnText.classList.remove('hidden');
        btnLoader.classList.add('hidden');
    });
});
</script>
@endsection
