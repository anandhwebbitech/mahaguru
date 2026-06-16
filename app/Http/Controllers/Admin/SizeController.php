<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;


class SizeController extends Controller
{
    //
    public function index()
    {
        $sizes = Size::latest()->get();

        return view('admin.size.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.size.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sizes,name'
        ]);

        Size::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Size Added Successfully');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);

        return view('admin.size.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:sizes,name,' . $id
        ]);

        $size->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Size Updated Successfully');
    }

    public function destroy($id)
    {
        Size::findOrFail($id)->delete();

        return back()->with('success', 'Size Deleted Successfully');
    }
}
