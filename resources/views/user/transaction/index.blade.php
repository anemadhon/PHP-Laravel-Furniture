<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Dashboard') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Transactiions') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            let datatables = $('#transactionUserTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'code', name: 'code'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                responsive: true
            });
        </script>
    </x-slot>
    
    <div class="pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    <table class="w-full divide-y divide-gray-200 pt-3" id="transactionUserTable">
                        <thead class="bg-gray-50 text-center">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Order Id
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Created At
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
</x-app-layout>
