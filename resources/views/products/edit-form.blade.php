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
                <x-input-label for="category" :value="__('Category')" />
                <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:border-gray-800" required>
                    <option value="" selected disabled>Select Category</option>
                    <option value="dress" {{ (old('category', $product->category) == 'dress') ? 'selected' : '' }}>Dresses</option>
                    <option value="pants" {{ (old('category', $product->category) == 'pants') ? 'selected' : '' }}>Pants</option>
                    <option value="jacket" {{ (old('category', $product->category) == 'jacket') ? 'selected' : '' }}>Jackets</option>
                    <option value="skirt" {{ (old('category', $product->category) == 'skirt') ? 'selected' : '' }}>Skirts</option>
                    <option value="shirt" {{ (old('category', $product->category) == 'shirt') ? 'selected' : '' }}>Shirts</option>
                    <!-- Add more categories as needed -->
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label class="block text-white" for="price">Price:</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="w-full p-2 border border-gray-600 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-white" for="image">Product Image:</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-600 rounded">
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button type="submit" class="ms-4">
                    {{ __('Update Product') }}
                </x-primary-button>
            </div>        </form>
    </div>
</x-app-layout>
