<x-app-layout>
    <div class="mx-auto px-4 py-6">
        <h2 class="text-white text-2xl font-semibold mb-4">Edit Products</h2>

        <table class="table-auto w-full text-white border border-gray-700">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-2 border-b border-gray-600">Image</th>
                    <th class="px-4 py-2 border-b border-gray-600">Name</th>
                    <th class="px-4 py-2 border-b border-gray-600">Category</th>
                    <th class="px-4 py-2 border-b border-gray-600">Price</th>
                    <th class="px-4 py-2 border-b border-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="bg-gray-700 hover:bg-gray-600 transition-colors">
                    <td class="px-4 py-2 border-b border-gray-600">
                        <img src="{{ filter_var($product->image_url, FILTER_VALIDATE_URL) ? $product->image_url : asset('storage/' . ltrim($product->image_url, '/')) }}" alt="{{ $product->name }}" class="h-20 w-20 object-cover">
                    </td>
                    <td class="px-4 py-2 border-b border-gray-600">{{ $product->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-600">{{ $product->category }}</td>
                    <td class="px-4 py-2 border-b border-gray-600">${{ $product->price }}</td>
                    <td class="px-4 py-2 border-b border-gray-600 flex justify-center items-center">
                        <a href="{{ route('product.edit.view', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 3.1L21 10.225l-3.125 3.125L10.75 6.225l3.125-3.125zM3 21v-3.375l12.975-12.975 3.375 3.375L6.375 21H3z" />
                            </svg>
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('product.delete', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>