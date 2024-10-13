<x-app-layout>
    <head>
        <!-- Add W3.CSS and Font Awesome -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <div>
        <!-- Search Form -->
        <div class="mx-auto px-4">
            <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                <input type="text" name="query" placeholder="Search..." value="{{ $query ?? '' }}" class="w-full text-white border rounded-lg bg-transparent focus:outline-none focus:ring focus:border-gray-800">
                <button type="submit" class="px-4 py-2 border text-white rounded-lg bg-transparent hover:scale-110 duration-300">Search</button>

                <!-- Dropdown for Product Categories -->
                <select name="category" onchange="this.form.submit()" class="bg-transparent border rounded-lg px-2 py-1 text-white focus:outline-none focus:ring focus:border-gray-800">
                    <option value="" class="text-black">All Categories</option>
                    @foreach (['dress', 'pants', 'jacket', 'skirt', 'shirt'] as $cat)
                        <option value="{{ $cat }}" class="text-black" {{ (request('category') == $cat) ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Product Table -->
        <table class="table-auto w-full">
            <tbody>
                @if(isset($query) && $products->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-white">
                            <h2>No products found for '{{ $query }}'.</h2>
                        </td>
                    </tr>
                @else
                    @foreach ($products->chunk(8) as $chunk)
                    <tr>
                        @foreach ($chunk as $item)
                        <td class="text-white px-4 py-2 hover:scale-110 duration-300 hover:bg-gray-700 cursor-pointer" onclick="openModal('{{ $item->name }}', '{{ $item->image_url }}', '{{ $item->price }}', '{{ $item->category }}', {{ $item->id }})">
                            <div class="bg-gray-300 w-[128px] h-[128px] overflow-hidden mx-auto">
                                <img src="{{ filter_var($item->image_url, FILTER_VALIDATE_URL) ? $item->image_url : asset('storage/' . ltrim($item->image_url, '/')) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-semibold text-center">{{ $item->name }}</h2>
                            <h3 class="text-sm text-center">{{ $item->category }}</h3>
                            <h1 class="text-lg font-bold bg-yellow-300 rounded-lg text-center py-1 mt-2 text-black">${{ $item->price }}</h1>                        
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal Popup -->
    <div id="productModal" class="w3-modal" style="display:none;">
        <div class="w3-modal-content w3-animate-opacity w3-card-4 w3-center">
            <span onclick="document.getElementById('productModal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        function openModal(name, imageUrl, price, category, productId) {
            document.getElementById('modalContent').innerHTML = `
                <h2 class="text-2xl font-semibold">${name}</h2>
                <div class="bg-gray-300 w-[256px] h-[256px] overflow-hidden mx-auto my-4">
                    <img src="${imageUrl.startsWith('http') ? imageUrl : '/storage/' + imageUrl.replace(/^\//, '')}" alt="${name}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-lg font-medium text-gray-700">${category}</h3>
                <h1 class="text-xl font-bold bg-yellow-300 rounded-lg text-center py-2 text-black mb-4">$${price}</h1>
                <div class="mb-6">
                    <label for="quantity" class="text-lg font-medium">Quantity:</label>
                    <input type="number" id="quantity" value="1" min="1" class="border rounded-lg w-16 text-center" />
                </div>
                <button onclick="addToCart(${productId});" class="w3-button w3-green w3-round-large w3-margin-bottom">
                    <i class="fa fa-shopping-cart"></i> Add to Cart
                </button>
            `;
            document.getElementById('productModal').style.display = 'block';
        }

        function addToCart(productId) {
            const quantity = document.getElementById('quantity').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/cart/add/${productId}`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="quantity" value="${quantity}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</x-app-layout>
