<?php

namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildrenController extends Controller
{
    // Menampilkan halaman untuk menambah data anak
    public function create  ()
    {
          $children = Children::where('user_id', Auth::id())->get(); 
    return view('children.create', compact('children'));
    }

    

    // Menyimpan data anak ke database
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
        ]);

        // Menyimpan data anak
        $child = new Children();
        $child->user_id = Auth::id(); // Menyimpan user_id yang sedang login
        $child->name = $request->name;
        $child->birth_date = $request->birth_date;
        $child->gender = $request->gender;
        $child->save();

        // Redirect ke halaman pemantauan
        return redirect()->route('children.create')->with('success', 'Data anak berhasil ditambahkan.');
    }

        public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
           
        ]);

        $child = Children::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $child->update($request->all());

        return redirect()->route('children.create')->with('success', 'Data anak berhasil diperbarui!');
    }

        public function destroy($id)
    {
        $child = Children::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $child->delete();

        return redirect()->route('children.create')->with('success', 'Data anak berhasil dihapus!');
    }
}
