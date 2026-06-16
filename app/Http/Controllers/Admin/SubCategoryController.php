<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;


class SubCategoryController extends Controller
{
    //
    public function index()
    {
        $categories = SubCategory::with('category')
                        ->latest()
                        ->get();

        return view('admin.sub-category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();

        return view('admin.sub-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required',
        ]);

        SubCategory::create([
            'category_id'      => $request->category_id,
            'sub_category_name'=> $request->sub_category_name,
            'status'           => $request->status ?? 1,
        ]);

        return redirect()
                ->route('admin.subcategory.index')
                ->with('success', 'Sub Category Added Successfully');
    }

    public function edit($id)
    {
        $category = SubCategory::findOrFail($id);
        $categories = Category::where('status', 1)->get();

        return view('admin.sub-category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required',
        ]);

        $subcategory = SubCategory::findOrFail($id);

        $subcategory->update([
            'category_id'       => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
            'status'            => $request->status ?? 1,
        ]);

        return redirect()
                ->route('admin.subcategory.index')
                ->with('success', 'Sub Category Updated Successfully');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();

        return redirect()
                ->back()
                ->with('success', 'Sub Category Deleted Successfully');
    }
}
