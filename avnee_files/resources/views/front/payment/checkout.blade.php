@extends('layouts.front.' . (session('theme', 'studio')))

@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm">
            <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('front.product.detail', $product->slug) }}" class="text-gray-500 hover:text-gray-700">{{ $product->name }}</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900">Checkout</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

                <div class="flex gap-4 mb-6">
                    <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-gray-400 text-2xl">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $product->description ? Str::limit($product->description, 100) : 'No description available' }}</p>
                    </div>
                </div>

                <!-- Product Variant Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Variant</label>
                    <select id="variant-select" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Choose a variant</option>
                        @foreach($product->variants as $variant)
                            <option value="{{ $variant->id }}"
                                    data-price="{{ $variant->price }}"
                                    data-compare-price="{{ $variant->compare_price ?? 0 }}"
                                    data-stock="{{ $variant->stock }}"
                                    data-sku="{{ $variant->sku }}"
                                    data-colour="{{ $variant->colour ?? '' }}"
                                    data-size="{{ $variant->size ?? '' }}">
                                {{ $variant->sku }} - {{ $variant->colour ? $variant->colour . ', ' : '' }}{{ $variant->size }} - Rs{{ number_format($variant->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <div class="flex items-center gap-4">
                        <button type="button" id="decrease-qty" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                            <span class="text-gray-600">-</span>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="10" class="w-16 text-center border border-gray-300 rounded-md px-2 py-1">
                        <button type="button" id="increase-qty" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                            <span class="text-gray-600">+</span>
                        </button>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Price per item</span>
                        <span id="price-per-item" class="font-medium">Rs0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Quantity</span>
                        <span id="total-quantity" class="font-medium">1</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span id="total-price" class="text-indigo-600">Rs0.00</span>
                    </div>
                </div>
            </div>

            <!-- Customer Details Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-6">Customer Details</h2>

                <form id="payment-form">
                    @csrf
                    <input type="hidden" id="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="variant_id" name="variant_id">
                    <input type="hidden" id="quantity-input" name="quantity" value="1">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="customer_name" name="customer_name" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <input type="tel" id="customer_phone" name="customer_phone" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                        <input type="email" id="customer_email" name="customer_email" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Shipping Address *</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Enter your complete shipping address"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="md:col-span-1">
                            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1">PIN Code *</label>
                            <input type="text" id="pincode" name="pincode" required maxlength="6"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                            <input type="text" id="notes" name="notes"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   placeholder="Any special instructions">
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button type="submit" id="pay-button" disabled
                            class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md font-medium hover:bg-indigo-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                        <span id="button-text">Select Variant to Proceed</span>
                    </button>

                    <div class="mt-4 text-center text-sm text-gray-500">
                        <p>Secure payment powered by Razorpay</p>
                        <div class="flex justify-center gap-2 mt-2">
                            <img src="https://razorpay.com/static/img/razorpay-logo.svg" alt="Razorpay" class="h-6">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const variantSelect = document.getElementById('variant-select');
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const payButton = document.getElementById('pay-button');
    const buttonText = document.getElementById('button-text');
    const paymentForm = document.getElementById('payment-form');

    let selectedVariant = null;

    // Update price display
    function updatePrice() {
        if (!selectedVariant) {
            document.getElementById('price-per-item').textContent = 'Rs0.00';
            document.getElementById('total-price').textContent = 'Rs0.00';
            return;
        }

        const quantity = parseInt(quantityInput.value);
        const price = parseFloat(selectedVariant.price);
        const total = price * quantity;

        document.getElementById('price-per-item').textContent = `Rs${price.toFixed(2)}`;
        document.getElementById('total-quantity').textContent = quantity;
        document.getElementById('total-price').textContent = `Rs${total.toFixed(2)}`;

        // Enable/disable pay button
        if (selectedVariant && quantity > 0 && selectedVariant.stock >= quantity) {
            payButton.disabled = false;
            buttonText.textContent = `Pay Rs${total.toFixed(2)}`;
        } else {
            payButton.disabled = true;
            if (selectedVariant && selectedVariant.stock < quantity) {
                buttonText.textContent = `Only ${selectedVariant.stock} items available`;
            } else {
                buttonText.textContent = 'Select Variant to Proceed';
            }
        }
    }

    // Variant selection
    variantSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            selectedVariant = {
                id: option.value,
                price: parseFloat(option.dataset.price),
                comparePrice: parseFloat(option.dataset.comparePrice),
                stock: parseInt(option.dataset.stock),
                sku: option.dataset.sku,
                colour: option.dataset.colour,
                size: option.dataset.size
            };
            document.getElementById('variant_id').value = selectedVariant.id;

            // Adjust quantity if needed
            if (quantityInput.value > selectedVariant.stock) {
                quantityInput.value = selectedVariant.stock;
            }
        } else {
            selectedVariant = null;
            document.getElementById('variant_id').value = '';
        }
        updatePrice();
    });

    // Quantity controls
    decreaseBtn.addEventListener('click', function() {
        const current = parseInt(quantityInput.value);
        if (current > 1) {
            quantityInput.value = current - 1;
            updatePrice();
        }
    });

    increaseBtn.addEventListener('click', function() {
        const current = parseInt(quantityInput.value);
        if (selectedVariant && current < selectedVariant.stock && current < 10) {
            quantityInput.value = current + 1;
            updatePrice();
        }
    });

    quantityInput.addEventListener('change', function() {
        let value = parseInt(this.value);
        if (isNaN(value) || value < 1) value = 1;
        if (selectedVariant && value > selectedVariant.stock) value = selectedVariant.stock;
        if (value > 10) value = 10;
        this.value = value;
        updatePrice();
    });

    // Form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!selectedVariant) {
            alert('Please select a product variant');
            return;
        }

        // Disable button
        payButton.disabled = true;
        buttonText.textContent = 'Processing...';

        // Create Razorpay order
        const formData = new FormData(this);
        formData.set('quantity', quantityInput.value);

        fetch('{{ route("payment.create.order") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Open Razorpay checkout
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: data.currency,
                    name: data.name,
                    description: data.description,
                    image: data.image,
                    order_id: data.order_id,
                    handler: function(response) {
                        // Payment successful
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("payment.success") }}';

                        Object.keys(response).forEach(key => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = response[key];
                            form.appendChild(input);
                        });

                        document.body.appendChild(form);
                        form.submit();
                    },
                    modal: {
                        ondismiss: function() {
                            payButton.disabled = false;
                            updatePrice();
                        }
                    },
                    prefill: data.prefill,
                    notes: data.notes,
                    theme: {
                        color: '#4F46E5'
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                alert(data.message || 'Failed to create order');
                payButton.disabled = false;
                updatePrice();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to process payment. Please try again.');
            payButton.disabled = false;
            updatePrice();
        });
    });
});
</script>
@endsection
