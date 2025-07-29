<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DokterProfileController extends Controller
{
    public function edit()
    {
        return view('dokter.edit-profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'fotoprofil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('fotoprofil')) {
            // Delete old image if exists
            if ($user->fotoprofil && Storage::exists('public/fotoprofil/' . $user->fotoprofil)) {
                Storage::delete('public/fotoprofil/' . $user->fotoprofil);
            }

            // Store new image
            $image = $request->file('fotoprofil');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/fotoprofil', $imageName);
            $user->fotoprofil = $imageName;
        }

        $user->save();

        return redirect()->route('dokter.dashboard')->with('success', 'Profil berhasil diperbarui');
    }
} 