<x-app-layout>
    <div >
        <!-- Search Form -->
        <div class="mx-auto px-4">
                <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                    <input type="text" name="query" placeholder="Search..." value="{{$query ?? ''}}" class="w-full text-white border rounded-lg bg-transparent focus:outline-none focus:ring focus:border-gray-800">
                    <button type="submit" class="px-4 py-2 bg-transparent border text-white rounded-lg hover:scale-110 duration-300">
                        Search
                    </button>
                </form>
            </div>

        <!-- Product Table -->
        <table class="table-auto w-fit">
            <tbody>
                @if(isset($query) && $products->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-white">
                            <h2>No products found for '{{ $query }}'.</h2>
                        </td>
                    </tr>
                @else
                    @foreach ($products->chunk(8) as $chunk)
                    <tr>
                        @foreach ($chunk as $item)
                        <td colspan='8' class="text-white px-4 py-2 hover:scale-110 duration-300 hover:bg-gray-700 ">
                            <div class="bg-gray-300 w-[128px] ">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" 
                                class="w-full h-full">
                            </div>
                            <h1 class="text-lg font-bold">${{ $item->price }}</h1>
                            <h2 class="text-md font-semibold">{{ $item->name }}</h2>
                            <h3 class="text-sm">{{ $item->category }}</h3>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</x-app-layout>
