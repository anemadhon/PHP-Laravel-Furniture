<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;

class OtherProfileInformationForm extends Component
{

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    /**
     * Update the user's profile contact information.
     *
     * @return void
     */
    public function updateOtherProfileInformation()
    {
        $this->resetErrorBag();
        $user = Auth::user();
        $user->address_one = $this->state['address_one'];
        $user->address_two = $this->state['address_two'];
        $user->phone_number = $this->state['phone_number'];
        $user->save();
        $this->emit('saved');
        $this->emit('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile.other-profile-information-form');
    }
}