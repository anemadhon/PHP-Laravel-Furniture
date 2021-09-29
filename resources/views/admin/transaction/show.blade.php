<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Admin') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ __('Transactions Details') }} </h3>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Order Id</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $transaction->code }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $transaction->status }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Courier</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ strtoupper($transaction->shipping->courier) }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Shipping Status</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $transaction->shipping->status }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Shipping to</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ auth()->user()->address_one }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Owner Contact</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ auth()->user()->phone_number }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Payment</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ strtoupper($transaction->payment->method) }} {{ "({$transaction->payment->status})" }}</label> 
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ number_format($transaction->payment->total, 2) }}</label> 
                                </div>
                                <div class="col-span-6">
                                    <div class="hidden sm:block">
                                        <div class="py-1">
                                            <div class="border-t border-gray-200"></div>
                                        </div>
                                    </div>                                    
                                </div>
                                @if ($transaction->status === 'PENDING')
                                    <div class="col-span-6">
                                        <label for="statusTransaction" class="block text-sm font-medium text-gray-700">Update Status Transaction</label>
                                        <select id="statusTransaction" name="status_transaction" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Select Shipping Type</option>
                                            <option value="COMPLETED">COMPLETED</option>
                                        </select>
                                    </div>
                                @endif
                                @if ($transaction->shipping->status !== 'DELIVERED')
                                    <div class="col-span-6">
                                        <label for="statusShipping" class="block text-sm font-medium text-gray-700">Update Status Shipping</label>
                                        <select id="statusShipping" name="status_shipping" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Select Shipping Type</option>
                                            @if ($transaction->shipping->status === 'PENDING')
                                                <option value="ON DELIVERY">ON DELIVERY</option>
                                            @endif
                                            @if ($transaction->shipping->status === 'ON DELIVERY')
                                                <option value="DELIVERED">DELIVERED</option>
                                            @endif
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                Id
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
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($transaction->details->load('product') as $details)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $details->code }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $details->product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp. {{ number_format($details->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $details->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp. {{ number_format($details->total_each_product, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    $('#statusTransaction').change(function()
    {
        $.ajax({
            url: "{!! url()->current() !!}",
            type: "PUT",
            data: {
                status: $(this).val()
            },
            success: function(status) {
                if (!status)
                {
                    $('#statusTransaction').append('<option value="">Somethings Wrong</option>')

                    return
                }

                console.log(status);
            }
        })
    });
    
    $('#statusShipping').change(function()
    {
        $.ajax({
            url: "{{ route('admin.update.payments', [$transaction->user, $transaction]) }}",
            type: "PUT",
            data: {
                status: $(this).val()
            },
            success: function(status) {
                if (!status)
                {
                    $('#statusShipping').append('<option value="">Somethings Wrong</option>')

                    return
                }

                console.log(status);
            }
        })
    });
</script>