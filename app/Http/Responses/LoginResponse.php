<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard'); // biasanya halaman Filament
        }
        elseif ($user->role === 'dokter') {
            return redirect()->intended('/dokter/dashboard');
        }

        return redirect()->intended('/user/dashboard');
    }
}
