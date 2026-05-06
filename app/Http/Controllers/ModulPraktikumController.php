<?php

namespace App\Http\Controllers;

use App\Models\ModulPraktikum;
use Illuminate\Http\Request;

class ModulPraktikumController extends Controller
{
    public function index()
    {
        $moduls = ModulPraktikum::all();
        return view('modul.index', compact('moduls'));
    }

    public function create()
    {
        return view('modul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'nullable',
            'file_path' => 'nullable|url'
        ]);

        ModulPraktikum::create($request->all());

        return redirect()->route('modul.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function edit(ModulPraktikum $modul)
    {
        return view('modul.edit', compact('modul'));
    }

    public function update(Request $request, ModulPraktikum $modul)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'nullable',
            'file_path' => 'nullable|url'
        ]);

        $modul->update($request->all());

        return redirect()->route('modul.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy(ModulPraktikum $modul)
    {
        $modul->delete();
        return redirect()->route('modul.index')->with('success', 'Modul berhasil dihapus.');
    }
}
