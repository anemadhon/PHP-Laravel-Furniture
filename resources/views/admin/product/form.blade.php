<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Admin') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Products') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ isset($product) ? __('Update') : __('Create') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ isset($product) ? __("$product->name Information") : __('Product Information') }} </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            - This information will be displayed publicly.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST">
                        @csrf
                        @if (isset($product))
                            @method('PUT')
                        @endif
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name" value="{{ old('name', (isset($product) ? $product->name : '')) }}" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('name')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', (isset($product) ? $product->description : '')) }}</textarea>
                                        @error('description')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <input type="text" name="price" value="{{ old('price', (isset($product) ? $product->price : '')) }}" id="price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('price')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6">
                                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <input type="text" name="quantity" value="{{ old('quantity', (isset($product) ? $product->quantity : '')) }}" id="quantity" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('quantity')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-6">
                                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="category_id" id="category" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', (isset($product) && $product->category_id == $category->id ? 'selected' : '')) }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <x-jet-button>
                                    {{ isset($product) ? __('Update') : __('Create') }}
                                </x-jet-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if (isset($product))
        <div class="hidden sm:block">
            <div class="pb-6">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ __("$product->name Galleries") }} </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                - This information will be displayed publicly.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="url" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                                            <input type="file" name="url[]" value="{{ old('url', '') }}" id="url" class="appearance-none ml-5 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded" multiple>
                                            @error('name')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <x-jet-button>
                                        {{ __('Add') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (isset($product) && isset($product->galleries))
        <div class="py-6 text-gray-600 body-font">
            <div class="container mx-auto">
                <div class="flex flex-wrap justify-center">
                    @foreach ($product->galleries as $gallery)
                        <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                            <div class="block relative h-48 rounded overflow-hidden">
                                <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="{{ asset('storage/'.$gallery->url) }}">
                            </div>
                            <form class="mt-4" action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                {!! method_field('delete') . csrf_field() !!}
                                <input type="submit" class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Delete">
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
