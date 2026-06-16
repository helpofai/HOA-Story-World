<?php

namespace App\Modules\Auth\Actions;

use App\Modules\Auth\Http\Requests\StoreLoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    /**
     * Execute the login action.
     *
     * @param StoreLoginUserRequest $request
     * @return void
     *
     * @throws ValidationException
     */
    public function execute(StoreLoginUserRequest $request): void
    {
        $request->authenticate();

        $request->session()->regenerate();
    }
}
