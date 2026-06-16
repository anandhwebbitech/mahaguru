<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;


class ColorController extends Controller
{
    //
    public function index()
    {
        $colors = Color::latest()->get();

        return view('admin.color.index', compact('colors'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store new color
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|max:20',
            'status' => 'required'
        ]);

        Color::create([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'Color Added Successfully');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return view('admin.color.edit', compact('color'));
    }

    /**
     * Update color
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|max:20',
            'status' => 'required'
        ]);

        $color = Color::findOrFail($id);

        $color->update([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'Color Updated Successfully');
    }

    /**
     * Delete color
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        $color->delete();

        return redirect()
            ->back()
            ->with('success', 'Color Deleted Successfully');
    }
}
