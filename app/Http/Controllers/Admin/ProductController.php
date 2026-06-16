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
    // 1. துல்லியமான Validation
    $request->validate([
        'name'                      => 'required|string|max:255',
        'category_id'               => 'required|exists:categories,id',
        'sub_category_id'           => 'nullable|exists:sub_categories,id',
        'material_id'               => 'required|exists:materials,id',
        'variants'                  => 'required|array|min:1',
        'variants.*.color_id'       => 'nullable|integer', 
        'variants.*.size_id'        => 'nullable|integer',  
        'variants.*.price'            => 'required|numeric|min:0', // அசல் விலை (Original Price)
        'variants.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        'variants.*.discount_price'   => 'nullable|numeric|min:0', // சலுகை விலை (Offer Price)
        'variants.*.gst'              => 'nullable|numeric|min:0',
        'variants.*.stock'            => 'required|integer|min:0',
        'variants.*.image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'thumbnail'                   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    DB::beginTransaction();

    try {
        // தானாக Slug உருவாக்குதல்
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // தானாக SKU உருவாக்குதல்
        $sku = 'SKU-' . strtoupper(Str::random(6)) . '-' . time();

        // Main Product Data தயார் செய்தல் (boolean() முறை பயன்படுத்தப்பட்டுள்ளது)
        $productData = [
            'product_name'         => $request->name,
            'slug'                 => $slug,
            // 'sku'                  => $sku,
            'category_id'          => $request->category_id,
            'sub_category_id'      => $request->sub_category_id,
            'material_id'          => $request->material_id,
            'status'               => $request->boolean('status') ? 1 : 0,
            'is_new_arrival'       => $request->boolean('is_new_arrival') ? 1 : 0,
            'is_best_selling'      => $request->boolean('is_best_selling') ? 1 : 0,
            'is_featured'          => $request->boolean('is_featured') ? 1 : 0,
            'tags'                 => $request->tags,
            'short_description'    => $request->short_description,
            'description'          => $request->description,
        ];

        // Main Thumbnail பதிவேற்றம்
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_product.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $productData['thumbnail'] =  $filename;
        }

        // Product உருவாக்கம்
        $product = Product::create($productData);

        // Variants சேமித்தல்
        foreach ($request->variants as $index => $variant) {
    
            $variantImage = null;
            if ($request->file("variants.$index.image")) {
                $file = $request->file("variants.$index.image");
                $filename = time() . '_variant_' . $index . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $variantImage = $filename;
            }

            // HTML-ல் இருந்து வரும் விலைகள்
            $originalPrice = floatval($variant['price']); 
            $sellingPrice = floatval($variant['discount_price']);
            $discountPercentage = isset($variant['discount_percentage']) ? intval($variant['discount_percentage']) : 0;

            ProductVariant::create([
                'product_id'          => $product->id,
                'color_id'            => !empty($variant['color_id']) ? $variant['color_id'] : null,
                'size_id'             => !empty($variant['size_id']) ? $variant['size_id'] : null,
                'price'               => $originalPrice, 
                'discount_price'      => $sellingPrice,     
                'discount_percentage' => $discountPercentage,
                'stock'               => $variant['stock'],
                'thumbnail'           => $variantImage,
                'status'              => 1,
            ]);
        }

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Product and variants created successfully.'
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
    // 1. துல்லியமான Validation (Store-ல் உள்ளதைப்போலவே)
    $request->validate([
        'name'                          => 'required|string|max:255',
        'category_id'                   => 'required|exists:categories,id',
        'sub_category_id'               => 'nullable|exists:sub_categories,id',
        'material_id'                   => 'required|exists:materials,id',
        'variants'                      => 'required|array|min:1',
        'variants.*.id'                 => 'nullable|exists:product_variants,id', // பழைய வேரியண்ட் என்றால் ID வரும்
        'variants.*.color_id'           => 'nullable|integer', 
        'variants.*.size_id'            => 'nullable|integer',  
        'variants.*.price'              => 'required|numeric|min:0',
        'variants.*.discount_percentage'=> 'nullable|numeric|min:0|max:100',
        'variants.*.discount_price'     => 'nullable|numeric|min:0',
        'variants.*.stock'              => 'required|integer|min:0',
        'variants.*.image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'thumbnail'                     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    $product = Product::findOrFail($id);
    DB::beginTransaction();

    try {
        // Name மாறினால் மட்டும் புது Slug உருவாக்குதல்
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

        // Main Product Data-வை அப்டேட் செய்தல்
        $product->product_name     = $request->name;
        $product->category_id      = $request->category_id;
        $product->sub_category_id  = $request->sub_category_id;
        $product->material_id      = $request->material_id;
        $product->status           = $request->boolean('status') ? 1 : 0;
        $product->is_new_arrival   = $request->boolean('is_new_arrival') ? 1 : 0;
        $product->is_best_selling  = $request->boolean('is_best_selling') ? 1 : 0;
        $product->is_featured      = $request->boolean('is_featured') ? 1 : 0;
        $product->tags             = $request->tags;
        $product->short_description= $request->short_description;
        $product->description      = $request->description;

        // New Main Thumbnail பதிவேற்றம் (பழைய இமேஜை நீக்கிவிட்டு)
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                unlink(public_path($product->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_product.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $product->thumbnail =  $filename;
        }

        $product->save();

        // --- VARIANTS MANAGEMENT ---
        
        // Form-ல் இருந்து வரும் வேரியண்ட் ID-க்களைச் சேகரிக்கிறோம் (நீக்கப்படாதவற்றைத் தக்கவைக்க)
        $keepVariantIds = [];

        foreach ($request->variants as $index => $variant) {
            
            $variantImage = null;
            
            // புது இமேஜ் அப்லோட் செய்யப்பட்டால்
            if ($request->file("variants.$index.image")) {
                $file = $request->file("variants.$index.image");
                $filename = time() . '_variant_' . $index . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $variantImage = $filename;
            }

            $originalPrice = floatval($variant['price']); 
            $sellingPrice = floatval($variant['discount_price']);
            $discountPercentage = isset($variant['discount_percentage']) ? intval($variant['discount_percentage']) : 0;

            if (!empty($variant['id'])) {
                // அப்டேட் செய்யும் பகுதி (Existing Variant)
                $existingVariant = ProductVariant::findOrFail($variant['id']);
                
                $vData = [
                    'color_id'            => !empty($variant['color_id']) ? $variant['color_id'] : null,
                    'size_id'             => !empty($variant['size_id']) ? $variant['size_id'] : null,
                    'price'               => $originalPrice,
                    'discount_price'      => $sellingPrice,
                    'discount_percentage' => $discountPercentage,
                    'stock'               => $variant['stock'],
                ];

                if ($variantImage) {
                    // பழைய இமேஜை டெலீட் செய்கிறோம்
                    if ($existingVariant->thumbnail && file_exists(public_path($existingVariant->thumbnail))) {
                        unlink(public_path($existingVariant->thumbnail));
                    }
                    $vData['thumbnail'] = $variantImage;
                }

                $existingVariant->update($vData);
                $keepVariantIds[] = $existingVariant->id;

            } else {
                // புதிதாகச் சேர்க்கப்படும் பகுதி (New Variant Added during Edit)
                $newVariant = ProductVariant::create([
                    'product_id'          => $product->id,
                    'color_id'            => !empty($variant['color_id']) ? $variant['color_id'] : null,
                    'size_id'             => !empty($variant['size_id']) ? $variant['size_id'] : null,
                    'price'               => $originalPrice,
                    'discount_price'      => $sellingPrice,
                    'discount_percentage' => $discountPercentage,
                    'stock'               => $variant['stock'],
                    'thumbnail'           => $variantImage,
                    'status'              => 1,
                ]);
                $keepVariantIds[] = $newVariant->id;
            }
        }

        // எடிட் செய்யும்போது ஏதேனும் ஒரு வேரியண்ட்டை யூசர் நீக்கியிருந்தால், அதை DB மற்றும் Folder-ல் இருந்தும் நீக்குதல்
        $deletedVariants = ProductVariant::where('product_id', $product->id)
                            ->whereNotIn('id', $keepVariantIds)
                            ->get();

        foreach ($deletedVariants as $dVariant) {
            if ($dVariant->thumbnail && file_exists(public_path($dVariant->thumbnail))) {
                unlink(public_path($dVariant->thumbnail));
            }
            $dVariant->delete();
        }

        DB::commit();

        return response()->json([
            'status'       => true,
            'message'      => 'Product and variants updated successfully.',
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
        $product = Product::findOrFail($id);

        // delete images
        foreach (explode(",", $product->images) as $img) {
            if (file_exists(public_path("uploads/images/" . $img))) {
                unlink(public_path("uploads/images/" . $img));
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
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
