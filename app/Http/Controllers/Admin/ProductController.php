<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function addProductsPage()
    {
        $categories = Category::all();
        $materials = Material::all();
        $colors = Color::where('status',1)->get();
        $sizes = Size::where('status',1)->get();

        // dd( $colors );
        return view('admin.productsadd', compact('categories', 'materials','colors','sizes')); // your view file
    }

    public function store(Request $request)
{
    $request->validate([
        'name'                           => 'required|string|max:255',
        'category_id'                   => 'required|exists:categories,id',
        'sub_category_id'              => 'nullable|exists:sub_categories,id',
        'material_id'                  => 'required|exists:materials,id',
        'variants'                      => 'required|array|min:1',
        'variants.*.color_id'           => 'nullable|integer', 
        'variants.*.size_id'            => 'nullable|integer',  
        'variants.*.price'              => 'required|numeric|min:0',
        'variants.*.discount_percentage'=> 'nullable|numeric|min:0|max:100',
        'variants.*.discount_price'     => 'nullable|numeric|min:0',
        'variants.*.gst'                => 'nullable|numeric|min:0',
        'variants.*.stock'              => 'required|integer|min:0',
        
        'variants.*.images'             => 'nullable|array',
        'variants.*.images.*'           => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        
        'thumbnail'                     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    DB::beginTransaction();

    try {
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $productData = [
            'product_name'      => $request->name,
            'slug'              => $slug,
            'category_id'       => $request->category_id,
            'sub_category_id'   => $request->sub_category_id,
            'material_id'       => $request->material_id,
            'status'            => $request->boolean('status') ? 1 : 0,
            'is_new_arrival'    => $request->boolean('is_new_arrival') ? 1 : 0,
            'is_best_selling'   => $request->boolean('is_best_selling') ? 1 : 0,
            'is_featured'       => $request->boolean('is_featured') ? 1 : 0,
            'tags'              => $request->tags,
            'short_description' => $request->short_description,
            'description'       => $request->description,
        ];

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_product.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $productData['thumbnail'] = $filename;
        }
        $product = Product::create($productData);
        foreach ($request->variants as $index => $variant) {
            $originalPrice = floatval($variant['price']); 
            $sellingPrice = floatval($variant['discount_price']);
            $discountPercentage = isset($variant['discount_percentage']) ? intval($variant['discount_percentage']) : 0;
            $variantImages = [];
            if ($request->hasFile("variants.$index.images")) {
                $files = $request->file("variants.$index.images");
                
                foreach ($files as $imgIndex => $file) {
                    $filename = time() . '_variant_' . $index . '_' . $imgIndex . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/products'), $filename);
                    $variantImages[] = $filename;
                }
            }
            ProductVariant::create([
                'product_id'          => $product->id,
                'color_id'            => !empty($variant['color_id']) ? $variant['color_id'] : null,
                'size_id'             => !empty($variant['size_id']) ? $variant['size_id'] : null,
                'price'               => $originalPrice, 
                'discount_price'      => $sellingPrice,     
                'discount_percentage' => $discountPercentage,
                'stock'               => $variant['stock'],
                'thumbnail'           => !empty($variantImages) ? $variantImages : null, 
                'status'              => 1,
            ]);
        }
        DB::commit();
        return response()->json([
            'status'  => true,
            'message' => 'Product and variants created successfully with multiple images.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
    public function ProductEdit($id)
    {
        $product = Product::with(['variants'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
public function ProductUpdate(Request $request, $id)
{
    $request->validate([
        'name'                           => 'required|string|max:255',
        'category_id'                   => 'required|exists:categories,id',
        'sub_category_id'              => 'nullable|exists:sub_categories,id',
        'material_id'                  => 'required|exists:materials,id',
        'variants'                      => 'required|array|min:1',
        'variants.*.id'                 => 'nullable|exists:product_variants,id', 
        'variants.*.color_id'           => 'nullable|integer', 
        'variants.*.size_id'            => 'nullable|integer',  
        'variants.*.price'              => 'required|numeric|min:0',
        'variants.*.discount_percentage'=> 'nullable|numeric|min:0|max:100',
        'variants.*.discount_price'     => 'nullable|numeric|min:0',
        'variants.*.stock'              => 'required|integer|min:0',
        
        'variants.*.images'             => 'nullable|array',
        'variants.*.images.*'           => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        
        'thumbnail'                     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);
    $product = Product::findOrFail($id);
    DB::beginTransaction();

    try {
        if ($product->product_name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $product->slug = $slug;
        }
        $product->product_name       = $request->name;
        $product->category_id        = $request->category_id;
        $product->sub_category_id   = $request->sub_category_id;
        $product->material_id        = $request->material_id;
        $product->status             = $request->boolean('status') ? 1 : 0;
        $product->is_new_arrival    = $request->boolean('is_new_arrival') ? 1 : 0;
        $product->is_best_selling   = $request->boolean('is_best_selling') ? 1 : 0;
        $product->is_featured       = $request->boolean('is_featured') ? 1 : 0;
        $product->tags               = $request->tags;
        $product->short_description = $request->short_description;
        $product->description        = $request->description;
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && file_exists(public_path('uploads/products/' . $product->thumbnail))) {
                unlink(public_path('uploads/products/' . $product->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_product.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $product->thumbnail = $filename;
        }
        $product->save();
        // --- VARIANTS MANAGEMENT ---
        $keepVariantIds = [];
        foreach ($request->variants as $index => $variant) {
            $originalPrice = floatval($variant['price']); 
            $sellingPrice = floatval($variant['discount_price']);
            $discountPercentage = isset($variant['discount_percentage']) ? intval($variant['discount_percentage']) : 0;
            $uploadedImages = [];
            if ($request->hasFile("variants.$index.images")) {
                $files = $request->file("variants.$index.images");
                foreach ($files as $imgIndex => $file) {
                    $filename = time() . '_variant_' . $index . '_' . $imgIndex . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/products'), $filename);
                    $uploadedImages[] = $filename;
                }
            }
            if (!empty($variant['id'])) {
                $existingVariant = ProductVariant::findOrFail($variant['id']);
                $vData = [
                    'color_id'            => !empty($variant['color_id']) ? $variant['color_id'] : null,
                    'size_id'             => !empty($variant['size_id']) ? $variant['size_id'] : null,
                    'price'               => $originalPrice,
                    'discount_price'      => $sellingPrice,
                    'discount_percentage' => $discountPercentage,
                    'stock'               => $variant['stock'],
                ];
                if (!empty($uploadedImages)) {
                    if (!empty($existingVariant->thumbnail) && is_array($existingVariant->thumbnail)) {
                        foreach ($existingVariant->thumbnail as $oldImg) {
                            if (file_exists(public_path('uploads/products/' . $oldImg))) {
                                unlink(public_path('uploads/products/' . $oldImg));
                            }
                        }
                    }
                    $vData['thumbnail'] = $uploadedImages;
                }
                $existingVariant->update($vData);
                $keepVariantIds[] = $existingVariant->id;

            } else {
                $finalVariantImages = !empty($uploadedImages) ? $uploadedImages : ($product->thumbnail ? [$product->thumbnail] : null);

                $newVariant = ProductVariant::create([
                    'product_id'          => $product->id,
                    'color_id'            => !empty($variant['color_id']) ? $variant['color_id'] : null,
                    'size_id'             => !empty($variant['size_id']) ? $variant['size_id'] : null,
                    'price'               => $originalPrice,
                    'discount_price'      => $sellingPrice,
                    'discount_percentage' => $discountPercentage,
                    'stock'               => $variant['stock'],
                    'thumbnail'           => $finalVariantImages, 
                    'status'              => 1,
                ]);
                $keepVariantIds[] = $newVariant->id;
            }
        }
        $deletedVariants = ProductVariant::where('product_id', $product->id)
                            ->whereNotIn('id', $keepVariantIds)
                            ->get();
        foreach ($deletedVariants as $dVariant) {
            if (!empty($dVariant->thumbnail) && is_array($dVariant->thumbnail)) {
                foreach ($dVariant->thumbnail as $delImg) {
                    if (file_exists(public_path('uploads/products/' . $delImg))) {
                        unlink(public_path('uploads/products/' . $delImg));
                    }
                }
            }
            $dVariant->delete();
        }

        DB::commit();

        return response()->json([
            'status'       => true,
            'message'      => 'Product and variants updated successfully with multiple images.',
            'redirect_url' => route('admin.addProductspage') 
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
public function deleteProduct($id)
{
    try {

        $product = Product::find($id);

        if (!$product) {

            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);

    } catch (\Exception $e) {

        \Log::error('Product Delete Error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred while deleting the product.'
        ], 500);
    }
}
   public function fetchProducts(Request $request)
{
    // 1. தேவையற்ற பழைய foreach லூப்களைத் தவிர்த்து, Eloquent Relationship மூலமே வேரியண்ட்களை இழுக்கிறோம்
    $products = Product::with([
        'category',
        'material',
        'variants.size',  // வேரியண்ட்டிற்குள் இருக்கும் சைஸ் ரிலேஷன்
        'variants.color'  // வேரியண்ட்டிற்குள் இருக்கும் கலர் ரிலேஷன்
    ])
    ->orderBy('id', 'desc') // புதிய ப்ராடக்ட்கள் முதலில் வர
    ->get();

    return response()->json([
        'products' => $products
    ]);
}
    public function getSubCategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();

        return response()->json($subcategories);
    }
}
