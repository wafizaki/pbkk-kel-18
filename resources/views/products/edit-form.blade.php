<x-app-layout>
    <div class="mx-auto px-4 py-6">
        <h2 class="text-white text-2xl font-semibold mb-4">Edit Product: {{ $product->name }}</h2>

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-white" for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="w-full p-2 border border-gray-600 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-white" for="category">Category:</label>
                <select id="category" name="category" class="w-full border-gray-300 rounded-lg focus:ring focus:border-gray-800" required>
                    <option value="" selected disabled>Select Category</option>
                    <option value="dress" {{ old('category', $product->category) == 'dress' ? 'selected' : '' }}>Dresses</option>
                    <option value="pants" {{ old('category', $product->category) == 'pants' ? 'selected' : '' }}>Pants</option>
                    <option value="jacket" {{ old('category', $product->category) == 'jacket' ? 'selected' : '' }}>Jackets</option>
                    <option value="skirt" {{ old('category', $product->category) == 'skirt' ? 'selected' : '' }}>Skirts</option>
                    <option value="shirt" {{ old('category', $product->category) == 'shirt' ? 'selected' : '' }}>Shirts</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-white" for="price">Price:</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="w-full p-2 border border-gray-600 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-white" for="image">Product Image:</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-600 rounded text-white">
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="ms-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
