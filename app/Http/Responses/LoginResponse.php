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

        elseif ($request->user()->role === 'dokter') {
            return redirect()->intended('/dokter');  // Arahkan ke dashboard dokter
        }

        return redirect()->intended('/user/dashboard');
    }
}
