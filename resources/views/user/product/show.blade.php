<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Dashboard') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Products') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Details') }}
        </h2>
    </x-slot>

    <div class="container pt-3 pb-5 px-4 sm:px-6 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            
            <img alt="{{ $product->slug }}" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{ $product->galleries->count() > 0 ? asset('storage/'.$product->galleries->last()->url) : 'https://ui-avatars.com/api/?name='.urlencode($product->name).'&color=7F9CF5&background=EBF4FF' }}">
            
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name }}</h2>
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>

                <div class="hidden sm:block">
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>
            
                <p class="leading-relaxed">
                    {{ $product->description }}
                </p>
            
                <form action="{{ route('dashboard.users.carts.store', auth()->user()) }}" method="POST">
                    @csrf
                    <div class="flex items-center border-b-2 border-gray-100 py-3">
                        <div class="flex">
                            <span class="mr-3">in stock:</span>
                            <span class="mr-3">{{ ($product->quantity - $product->details_sum_quantity) }}</span>
                        </div>
                        <div class="flex ml-6 items-center">
                            <span class="mr-3">Quantity</span>
                                <input type="number" name="purchase_quantity" value="{{ old('purchase_quantity', '') }}" id="purchase_quantity" class="relative focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md" min="1" max="{{ ($product->quantity - $product->total_purchased_quantity) }}">
                                @error('purchase_quantity')
                                    <span class="ml-2 text-sm text-red-600">{{ $message }}</span>
                                @enderror
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="purchase_price" value="{{ $product->price }}">
                    </div>
                    @error('product_id')
                        <span class="text-sm text-red-600">Please be nice and try agains</span>
                    @enderror

                    <div class="hidden sm:block">
                        <div>
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>
                
                    <div class="flex pt-2">
                        <span class="title-font font-medium text-2xl text-gray-900">Rp. {{ number_format($product->price, 2) }}</span>
                        <x-jet-button class="flex ml-auto">
                            {{ __('Add to Cart') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
