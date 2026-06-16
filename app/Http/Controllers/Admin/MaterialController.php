<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::latest()->get();
        return view('admin.material.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.material.create');
    }

    public function store(Request $request)
    {
        Material::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.material.index');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.material.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        Material::findOrFail($id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.material.index');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->back()->with('success', 'Material deleted successfully');
    }
}
