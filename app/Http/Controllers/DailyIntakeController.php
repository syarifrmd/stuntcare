<?php

namespace App\Http\Controllers;

use App\Models\DailyIntake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DailyIntakeController extends Controller
{
    public function storeFromFood(Request $request)
{
    // dd($request->all());
    $request->validate([
        'food_id' => 'required|exists:foods,id',
        'child_id' => 'nullable|exists:children,id',
        'time_of_day' => 'required|in:Pagi,Siang,Malam',
    ]);

    DailyIntake::create([
        'id'     => Auth::id(),
        'food_id'     => $request->food_id,
        'child_id'    => $request->child_id ?? null,
        'time_of_day' => $request->time_of_day,
        'portion'     => 1,
        'date'        => now()->toDateString(),
    ]);

    return redirect()->back()->with('success', 'Makanan berhasil ditambahkan ke konsumsi harian.');
}

}
