<?php

namespace App\Http\Controllers;

use App\Tunjangan;
use Illuminate\Http\Request;

class TunjanganController extends Controller
{
    public function index()
    {
        $tunjangans = Tunjangan::all();
        return view('tunjangan.index', compact('tunjangans'));
    }

    public function create()
    {
        return view('tunjangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rate_amount' => 'required|numeric|min:0',
        ]);

        Tunjangan::create($request->all());

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil ditambahkan.');
    }

    public function edit(Tunjangan $tunjangan)
    {
        return view('tunjangan.edit', compact('tunjangan'));
    }

    public function update(Request $request, Tunjangan $tunjangan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rate_amount' => 'required|numeric|min:0',
        ]);

        $tunjangan->update($request->all());

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil diperbarui.');
    }

    public function destroy(Tunjangan $tunjangan)
    {
        $tunjangan->delete();

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil dihapus.');
    }
}
