<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Item') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('shop.add') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="category" :value="__('Category')" />
            <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:border-gray-800" required>
                <option value="" disabled selected>Select Category</option>
                @foreach(['dress' => 'Dresses', 'pants' => 'Pants', 'jacket' => 'Jackets', 'skirt' => 'Skirts', 'shirt' => 'Shirts'] as $value => $label)
                    <option value="{{ $value }}" {{ (old('category') == $value) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="image" :value="__('Upload Photo')" />
            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" required />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" required autocomplete="price" />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button class="ms-4">{{ __('Add New Item') }}</x-primary-button>
        </div>
    </form>
</x-app-layout>
