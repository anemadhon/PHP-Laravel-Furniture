<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register-step-two.store') }}">
            @csrf

            <div>
                <x-jet-label for="address_one" value="{{ __('Address') }}" />
                <textarea id="address_one" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="address_one" cols="30" rows="3" required autofocus>{{ old('address_one') }}</textarea>
            </div>

            <div class="mt-4">
                <x-jet-label for="phone_number" value="{{ __('Phone Number') }}" />
                <x-jet-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Finish Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
