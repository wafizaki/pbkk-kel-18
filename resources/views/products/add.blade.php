<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Item') }}
        </h2>
</x-slot>
<form method="POST" action="{{ route('shop.add') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="category" :value="__('category')" />
            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" required autocomplete="username" />
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="image_url" :value="__('Random Numbers')" />

            <x-text-input id="image_url" class="block mt-1 w-full"
                            name="image_url"
                            type="text"
                            required autocomplete="username" />

            <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />

            <x-text-input id="price" class="block mt-1 w-full"
                            type="text"
                            name="price" required autocomplete="image_url" />

            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Add New Item') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>