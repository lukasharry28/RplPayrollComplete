<?php

namespace App\Http\Controllers;

use App\Pajak;
use Illuminate\Http\Request;

class PajakController extends Controller
{
    public function index()
    {
        $pajaks = Pajak::all();
        return view('pajak.index', compact('pajaks'));
    }

    public function create()
    {
        return view('pajak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tax_amount' => 'required|numeric|min:0',
        ]);

        Pajak::create($request->all());

        return redirect()->route('pajak.index')->with('success', 'Pajak berhasil ditambahkan.');
    }

    public function edit(Pajak $pajak)
    {
        return view('pajak.edit', compact('pajak'));
    }

    public function update(Request $request, Pajak $pajak)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tax_amount' => 'required|numeric|min:0',
        ]);

        $pajak->update($request->all());

        return redirect()->route('pajak.index')->with('success', 'Pajak berhasil diperbarui.');
    }

    public function destroy(Pajak $pajak)
    {
        $pajak->delete();

        return redirect()->route('pajak.index')->with('success', 'Pajak berhasil dihapus.');
    }
}
