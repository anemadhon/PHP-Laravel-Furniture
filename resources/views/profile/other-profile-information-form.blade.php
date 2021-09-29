<x-jet-form-section submit="updateOtherProfileInformation">
    <x-slot name="title">
        {{ __('Other Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Address 1 -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address_one" value="{{ __('Primary Address') }}" />
            <textarea id="address_one" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="address_one" cols="30" rows="3" wire:model.defer="state.address_one"></textarea>
            <x-jet-input-error for="address_one" class="mt-2" />
        </div>
        
        <!-- Address 2 -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address_two" value="{{ __('Secondary Address') }}" />
            <textarea id="address_two" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="address_two" cols="30" rows="3" wire:model.defer="state.address_two"></textarea>
            <x-jet-input-error for="address_two" class="mt-2" />
        </div>
        
        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="phone_number" value="{{ __('Phone Number') }}" />
            <x-jet-input id="phone_number" type="text" class="mt-1 block w-full" wire:model.defer="state.phone_number" />
            <x-jet-input-error for="phone_number" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
