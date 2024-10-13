<x-app-layout>
    <head>
        <!-- Add W3.CSS and Font Awesome -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <div>
        <div class="mx-auto px-4">
            <form action="{{ route('search') }}" method="GET" class="flex gap-4 font-semibold">
                <input type="text" name="query" placeholder="Search..." value="{{ $query ?? '' }}" class="w-[80%] flex text-white border rounded-lg bg-transparent focus:outline-none focus:ring focus:border-gray-800">
                <button type="submit" class="w-[7%] px-4 py-2 border justify-center text-white rounded-lg bg-transparent hover:scale-110 duration-300 flex">Search</button>
                <!-- Dropdown for Product Categories -->
                <div class="relative flex w-[13%]">
                    <select name="category" id="categorySelect" onchange="this.form.submit()" class="w-full bg-transparent border rounded-lg px-2 text-white border-white focus:outline-none focus:ring focus:border-gray-800 hover:scale-110 duration-300">
                        <option value="" class="text-black">All Categories</option>
                        <option value="dress" class="text-black" {{ (request('category') == 'dress') ? 'selected' : '' }}>Dresses</option>
                        <option value="pants" class="text-black" {{ (request('category') == 'pants') ? 'selected' : '' }}>Pants</option>
                        <option value="jacket" class="text-black" {{ (request('category') == 'jacket') ? 'selected' : '' }}>Jackets</option>
                        <option value="skirt" class="text-black" {{ (request('category') == 'skirt') ? 'selected' : '' }}>Skirts</option>
                        <option value="shirt" class="text-black" {{ (request('category') == 'shirt') ? 'selected' : '' }}>Shirts</option>
                    </select>
                </div>
                
            </form>            
            <form id="imageUploadForm" class="flex flex-row items-center my-4 justify-center">
                <label for="imageInput" class="text-white font-semibold text-xl my-2 mr-4">Find via Picture!</label>
                <input type="file" id="imageInput" accept="image/*" class="file-input hidden" 
                    onchange="document.getElementById('processImageBtn').click()">
                <label for="imageInput" class="py-2 px-4 flex border text-white items-center rounded-lg bg-transparent hover:scale-110 duration-300 cursor-pointer">
                    <i class="fas fa-camera mr-2 text-white"></i>
                </label>
                <button type="button" id="processImageBtn" 
                    class="hidden py-2 px-4 flex border text-white items-center rounded-lg bg-transparent hover:scale-110 duration-300">
                    Process Image
                </button>
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
                        <td class="text-white px-4 py-2 hover:scale-110 duration-300 hover:bg-gray-700 cursor-pointer" onclick="openModal('{{ $item->name }}', '{{ $item->image_url }}', '{{ $item->price }}', '{{ $item->category }}', '{{ $item->id }}')">
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
            <div id="modalContent" ></div>
        </div>
    </div>
    <script src="{{ asset('js/detectObject.js') }}"></script>

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
