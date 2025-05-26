<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LihatProfilController extends Controller
{
     public function index()
    {
        return view('lihatprofile.index');
    }
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $validated = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:users,email,' . $id,
        'password' => 'nullable|min:8',
        'telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:20',
        'pekerjaan' => 'nullable|string|max:40',
        'fotoprofil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    } else {
        unset($validated['password']);
    }
     // Jika ada file foto diunggah
    if ($request->hasFile('fotoprofil')) {
        // Hapus foto lama jika ada
        if ($user->fotoprofil) {
            Storage::delete('public/fotoprofil/' . $user->fotoprofil);
        }

        // Simpan file foto baru
        $file = $request->file('fotoprofil');
        $filename = time() . '_' . $file->getClientOriginalName();
        Storage::disk('public')->putFileAs('fotoprofil', $file, $filename);
        $validated['fotoprofil'] = $filename;
    }

    $user->update($validated);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
}

    
}
