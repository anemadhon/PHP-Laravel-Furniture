<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Dashboard') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm rounded">
                <div class="border-b border-gray-200">
                    <form action="{{ route('dashboard.products') }}">
                        <input type="text" name="search" placeholder="Search" class="bg-white rounded text-sm w-full" value="{{ request('search') }}">
                        <button type="submit" class="absolute -m-6 mt-3">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="pb-3">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="text-gray-600 body-font">
                <div class="container mx-auto">
                    <div class="flex flex-wrap justify-center">
                        @forelse ($products as $product)
                            <div class="lg:w-1/4 md:w-1/2 w-full border border-indigo-200 p-2">
                                <div class="relative h-48 rounded overflow-hidden">
                                    <a href="{{ route('dashboard.products.show', $product) }}">
                                        <img alt="{{ $product->slug }}" class="object-cover object-center w-full h-full block" src="{{ $product->galleries->count() > 0 ? asset('storage/'.$product->galleries->last()->url) : 'https://ui-avatars.com/api/?name='.urlencode($product->name).'&color=7F9CF5&background=EBF4FF' }}">
                                    </a>
                                </div>
                                <div class="mt-4">
                                    <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category->name }}</h3>
                                    <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                    <p class="text-gray-900 text-md font-medium">Stock: {{ ($product->quantity - $product->details_sum_quantity) }}</p>
                                    <p class="mt-1">Rp. {{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @empty
                            <h3 class="inline-block pb-3 text-lg font-medium leading-6 text-gray-900">No Products Found</h3>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="pt-3 pb-6">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="text-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    
</x-app-layout>
