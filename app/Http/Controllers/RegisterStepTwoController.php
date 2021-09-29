<?php

namespace App\Http\Controllers;

use App\Events\RegisterStepTwo;
use App\Http\Requests\RegisterStepTwoRequest;
use Illuminate\Http\Request;

class RegisterStepTwoController extends Controller
{
    public function create()
    {
        return view('auth.register-two');
    }

    public function store(RegisterStepTwoRequest $request)
    {
        auth()->user()->update($request->validated());

        event(new RegisterStepTwo(auth()->user()));

        return redirect()->route('dashboard.products');
    }
}
