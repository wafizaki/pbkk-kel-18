<x-app-layout>
    <div class="container mx-auto py-8 text-white">
        <h1 class="text-2xl font-bold text-center mb-8">Your Cart</h1>

        <!-- Display success message if present in session -->
        @if (Session::has('success'))
            <div class="bg-green-500 p-4 rounded-lg mb-6">{{ Session::get('success') }}</div>
        @endif

        <!-- Check if the cart is not empty -->
        @if ($cart)
            <form id="cartForm" action="{{ route('checkout') }}" method="POST">
                @csrf
                <table class="table-auto w-full mb-6">
                    <thead>
                        <tr class="text-left">
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr class="border-b">
                                <td class="px-4 py-2 flex items-center">
                                    <!-- Display product image and name -->
                                    <img src="{{ filter_var($item['image_url'], FILTER_VALIDATE_URL) ? $item['image_url'] : asset('storage/' . ltrim($item['image_url'], '/')) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover mr-4">
                                    {{ $item['name'] }}
                                </td>
                                <td class="px-4 py-2 text-black">
                                    <!-- Input for product quantity -->
                                    <input type="number" name="products[{{ $id }}][quantity]" value="{{ $item['quantity'] }}" min="1" class="quantity-input border rounded-lg w-16 text-center" oninput="calculateTotalPrice()">
                                </td>
                                <td class="px-4 py-2">${{ number_format($item['price'], 2) }}</td>
                                <td class="px-4 py-2">
                                    <!-- Button to remove product from cart -->
                                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded" onclick="removeFromCart({{ $id }})">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Display total price -->
                <div class="text-right font-bold mb-4">
                    Total Price: $<span id="totalPrice">0.00</span>
                    <input type="hidden" name="total_price" id="hiddenTotalPrice" value="0.00">
                </div>

                <!-- Checkout button -->
                <div class="text-right">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Proceed to Checkout</button>
                </div>
            </form>
        @else
            <!-- Message if cart is empty -->
            <p class="text-center text-lg">Your cart is empty!</p>
            <div class="text-center mt-4">
                <a href="{{ route('shop.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Start Shopping</a>
            </div>
        @endif
    </div>

    <script>
        // Function to calculate the total price based on quantities
        const calculateTotalPrice = () => {
            const total = Array.from(document.querySelectorAll('.quantity-input')).reduce((sum, input) => {
                const price = parseFloat(input.closest('tr').querySelector('td:nth-child(3)').innerText.replace('$', ''));
                return sum + price * input.value; // Calculate total
            }, 0);
            // Update total price displayed on the page
            document.getElementById('totalPrice').innerText = total.toFixed(2);
            document.getElementById('hiddenTotalPrice').value = total.toFixed(2); // Hidden input for form submission
        };

        // Function to remove a product from the cart
        const removeFromCart = (id) => {
            fetch(`/cart/remove/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Reload the page if removal is successful
                data.success ? location.reload() : alert(data.message); // Show message if not successful
            });
        };

        // Calculate total price on page load
        document.addEventListener('DOMContentLoaded', calculateTotalPrice);
    </script>
</x-app-layout>
