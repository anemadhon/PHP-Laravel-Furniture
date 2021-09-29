<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Admin') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ __('Users') }}
            <svg class="h-5 w-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"> {{ __("{$user->name} Personal Information") }} </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            - This information will be displayed publicly.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $user->name }}</label>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Username</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $user->username }}</label>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $user->email }}</label>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ $user->phone_number }}</label>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Joined</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ \Carbon\Carbon::now()->parse($user->created_at)->diffForHumans(). ' | ' .\Carbon\Carbon::create($user->created_at)->toFormattedDateString() }}</label>
                                </div>
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <label class="block text-xl font-medium text-gray-700">{{ __("{$user->address_one} (alternative: {$user->address_two})") }}</label>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
