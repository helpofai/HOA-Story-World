<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Actions\RegisterUserAction;
use App\Modules\Auth\Http\Requests\StoreRegisterUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterAuthController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(StoreRegisterUserRequest $request, RegisterUserAction $action): RedirectResponse
    {
        $action->execute($request->validated());

        return redirect(route('dashboard', absolute: false));
    }
}
