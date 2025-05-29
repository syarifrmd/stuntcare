<?php

namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\Rules;
    use Illuminate\View\View;
    use App\Mail\SendOtpMail;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Session;


    class RegisteredUserController extends Controller
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
         *
         * @throws \Illuminate\Validation\ValidationException
         */
        public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan data ke session, bukan database
        Session::put('register_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('otp_email', $request->email);

        // Kirim OTP via email
        Mail::to($request->email)->send(new SendOtpMail($otp));

        return redirect()->route('verify.otp.form')->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }
        public function showOtpForm(): View|RedirectResponse
    {
    // Cek apakah sesi OTP dan email tersedia
    if (!Session::has('otp') || !Session::has('otp_email')) {
        // Jika tidak, redirect ke halaman login atau lainnya
        return redirect()->route('login')->with('error', 'Akses tidak diizinkan.');
    }

    return view('auth.verify-otp');
}

    public function verifyOtp(Request $request): RedirectResponse
  {
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    if ($request->otp != Session::get('otp')) {
        return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
    }

    $data = Session::get('register_data');

    // Cek apakah user sudah ada (untuk mencegah duplikasi jika refresh)
    $existingUser = User::where('email', $data['email'])->first();
    if (!$existingUser) {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'is_verified' => 1,
        ]);
    } else {
        $user = $existingUser;
        $user->is_verified = 1;
        $user->save();
    }

    // Hapus session dan login
    Session::forget(['otp', 'otp_email', 'register_data']);
    // Auth::login($user);

    return redirect()->route('dashboard')->with('success', 'Verifikasi berhasil. Selamat datang!');
}


    }
