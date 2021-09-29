<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Dashboard') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Carts') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            let datatables = $('#userCartTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'product_id', name: 'product_id'},
                    {data: 'purchase_price', name: 'purchase_price'},
                    {data: 'purchase_quantity', name: 'purchase_quantity'},
                    {data: 'total_each_product', name: 'total_each_product'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                responsive: true
            });
        </script>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    <table class="w-full divide-y divide-gray-200 pt-3" id="userCartTable">
                        <thead class="bg-gray-50 text-center">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @error('checkout')
        <div class="pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <p class="mt-1 text-sm text-red-600">
                        {{ __("Error: {$message}") }}
                    </p>
                </div>
            </div>
        </div>
    @enderror
    {{-- @if ($errors->checkout->count() > 0)
    @php
        dump($errors->checkout)
    @endphp
        <div class="pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <p class="mt-1 text-sm text-red-600">
                        {{-- {{ __("Error: {$errors->checkout->get('message')}") }}
                    </p>
                </div>
            </div>
        </div>
    @endif --}}

    @if ($total_amount !== 0)
        <div class="pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ auth()->user()->name }} {{ __('Cart Details') }} </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                - This information will be displayed publicly.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('dashboard.users.transactions.store', auth()->user()) }}" method="POST">
                            @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                            <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" id="phoneNumber" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                            @error('phone_number')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        @if (auth()->user()->address_one || auth()->user()->address_two)
                                        <div class="col-span-6">
                                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                            <select name="address" id="address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                <option value="">Select Address</option>
                                                <option value="{{ auth()->user()->address_one }}" {{ auth()->user()->address_one ? 'selected' : '' }}>{{ auth()->user()->address_one }}</option>
                                                @if (auth()->user()->address_two)
                                                    <option value="{{ auth()->user()->address_two }}" {{ !auth()->user()->address_one && auth()->user()->address_two ? 'selected' : '' }}>{{ auth()->user()->address_two }}</option>
                                                @endif
                                            </select>
                                            @error('address')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        @endif
                                        @if (!auth()->user()->address_one && !auth()->user()->address_two)
                                            <div class="col-span-6">
                                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                                <textarea name="address" id="address" cols="30" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                    {{ old('address_one', '') }}
                                                </textarea>
                                                @error('address')
                                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="courier" class="block text-sm font-medium text-gray-700">Courier</label>
                                            <select name="courier" id="courier" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                <option value="">Select Courier</option>
                                                <option value="jne">JNE</option>
                                                <option value="tiki">TIKI</option>
                                                <option value="pos">POS INDONESIA</option>
                                            </select>
                                            @error('courier')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="shippingType" class="block text-sm font-medium text-gray-700">Shipping Type</label>
                                            <select id="shippingType" name="shipping_type" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                <option value="">Select Shipping Type</option>
                                            </select>
                                            @error('shipping_type')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="shippingCost" class="block text-sm font-medium text-gray-700">Shipping Cost</label>
                                            <input type="text" name="shipping_cost" id="shippingCost" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly required>
                                            @error('shipping_cost')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="totalAmount" class="block text-sm font-medium text-gray-700">Total Payment</label>
                                            <input type="text" name="total_amount" value="{{ old('total_amount', $total_amount) }}" id="totalAmount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                                            @error('shipping_cost')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-span-6">
                                            <label class="block text-sm font-medium text-gray-700">Payment You have to Pay</label>
                                            <label id="haveToPay" class="block text-xl font-medium text-gray-700"></label> 
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <x-jet-button>
                                        {{ __('Check Out with Midtrans') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    $('#courier').change(function()
    {
        $.post(
            "{{ route('dashboard.shipping.services') }}",
            {'courier': $(this).val()},
            function(services)
            {
                if (!services)
                {
                    $('#shippingType').append('<option value="">Somethings Wrong</option>')

                    return
                }

                const shippingServices = JSON.parse(services)

                $('#shippingType').empty()
                
                $('#shippingType').append('<option value="">Select Shipping Type</option>')

                shippingServices.rajaongkir.results[0].costs.forEach(service =>
                {   
					$("<option />", 
                    {
                        value: service.cost[0].value,
                        text: service.service
                    }).appendTo($('#shippingType'))
                });
            }
        )
    });

    $('#shippingType').change(function()
    {
        let toPay = parseInt($('#totalAmount').val()) + parseInt($(this).val())

        $('#shippingCost').val(parseInt($(this).val()))

        $('#haveToPay').text(`Rp. ${parseFloat(toPay).toLocaleString(('en-US'), {minimumFractionDigits: 2, maximumFraactionDigits: 2})}`)
    })
</script>