<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('author')
            ->where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('modules.index', compact('modules'));
    }

    public function show(Module $module)
    {
        abort_unless($module->is_published || auth()->user()->hasRole(['asisten_lab', 'pj']), 403);
        return view('modules.show', compact('module'));
    }

    public function create()
    {
        return view('modules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file'         => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('modules', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('module-covers', 'public');
        }

        $validated['created_by']   = auth()->id();
        $validated['slug']         = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');

        Module::create($validated);

        return redirect()->route('modules.index')
            ->with('success', 'Modul berhasil ditambahkan!');
    }

    public function destroy(Module $module)
    {
        if ($module->file_path) Storage::disk('public')->delete($module->file_path);
        if ($module->cover_image) Storage::disk('public')->delete($module->cover_image);
        $module->delete();

        return back()->with('success', 'Modul berhasil dihapus.');
    }
}
