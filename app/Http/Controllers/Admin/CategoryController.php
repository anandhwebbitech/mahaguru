<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB Max
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
        }

        Category::create([
            'name'  => $request->name,
            'image' => $imageName
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $imageName = $category->image;

        if ($request->hasFile('image')) {
            // பழைய படம் இருந்தால் அதை நீக்குதல்
            $oldImagePath = public_path('uploads/categories/' . $category->image);
            if (File::exists($oldImagePath) && $category->image) {
                File::delete($oldImagePath);
            }

            // புதிய படத்தை பதிவேற்றுதல்
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
        }

        $category->update([
            'name'  => $request->name,
            'image' => $imageName
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // டேட்டாபேஸில் இருந்து நீக்குவதற்கு முன் கோப்புறையில் உள்ள படத்தை நீக்குதல்
        $imagePath = public_path('uploads/categories/' . $category->image);
        if (File::exists($imagePath) && $category->image) {
            File::delete($imagePath);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}