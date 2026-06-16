<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    //
     public function index()
    {
        $banners = Banner::latest()->get();

        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'banner_name' => 'required|string|max:255',
        'banner'      => 'required|image|mimes:jpg,jpeg,png,webp',
        'status'      => 'required'
    ]);

    $bannerImage = null;

    if ($request->hasFile('banner')) {

        $bannerImage = time() . '.' . $request->banner->extension();

        $request->banner->move(
            public_path('uploads/banner'),
            $bannerImage
        );
    }

    Banner::create([
        'banner_name' => $request->banner_name,
        'banner'      => $bannerImage,
        'status'      => $request->status
    ]);

    return redirect()
        ->route('admin.banner.index')
        ->with('success', 'Banner Added Successfully');
}

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'banner_name' => 'required|string|max:255',
        'status'      => 'required'
    ]);

    $banner = Banner::findOrFail($id);

    $bannerImage = $banner->banner;

    if ($request->hasFile('banner')) {

        if (
            $banner->banner &&
            file_exists(public_path('uploads/banner/' . $banner->banner))
        ) {
            unlink(public_path('uploads/banner/' . $banner->banner));
        }

        $bannerImage = time() . '.' . $request->banner->extension();

        $request->banner->move(
            public_path('uploads/banner'),
            $bannerImage
        );
    }

    $banner->update([
        'banner_name' => $request->banner_name,
        'banner'      => $bannerImage,
        'status'      => $request->status
    ]);

    return redirect()
        ->route('admin.banner.index')
        ->with('success', 'Banner Updated Successfully');
}

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->banner && file_exists(public_path('uploads/banner/'.$banner->banner))) {
            unlink(public_path('uploads/banner/'.$banner->banner));
        }

        $banner->delete();

        return redirect()->back()
            ->with('success', 'Banner Deleted Successfully');
    }
}
