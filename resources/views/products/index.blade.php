<x-app-layout>
    <div>
        <!-- Search Form -->
        <div class="mx-auto px-4">
            <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                <input type="text" name="query" placeholder="Search..." value="{{ $query ?? '' }}" class="w-full text-white border rounded-lg bg-transparent focus:outline-none focus:ring focus:border-gray-800">
                <button type="submit" class="px-4 py-2 bg-transparent border text-white rounded-lg hover:scale-110 duration-300">
                    Search
                </button>

                <!-- Dropdown for Product Categories -->
                <div class="relative">
                    <select name="category" onchange="this.form.submit()" class="bg-transparent border rounded-lg px-2 py-1 text-white focus:outline-none focus:ring focus:border-gray-800">
                        <option value="" class="text-black">All Categories</option>
                        <option value="dress" class="text-black" {{ (request('category') == 'dress') ? 'selected' : '' }}>Dresses</option>
                        <option value="pants" class="text-black" {{ (request('category') == 'pants') ? 'selected' : '' }}>Pants</option>
                        <option value="jacket" class="text-black" {{ (request('category') == 'jacket') ? 'selected' : '' }}>Jackets</option>
                        <option value="skirt" class="text-black" {{ (request('category') == 'skirt') ? 'selected' : '' }}>Skirts</option>
                        <option value="shirt" class="text-black" {{ (request('category') == 'shirt') ? 'selected' : '' }}>Shirts</option>
                        <!-- Add more categories as needed -->
                    </select>
                </div>
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
                        <td colspan='8' class="text-white px-4 py-2 hover:scale-110 duration-300 hover:bg-gray-700">
                            <div class="bg-gray-300 w-[128px] h-[128px] overflow-hidden mx-auto">
                            <img src="{{ filter_var($item->image_url, FILTER_VALIDATE_URL) ? $item->image_url : asset('storage/' . ltrim($item->image_url, '/')) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-md font-semibold text-center">{{ $item->name }}</h2>
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
</x-app-layout>
