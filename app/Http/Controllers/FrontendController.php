<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CustomAddress;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Material;
use App\Models\Size;
use App\Models\ShippingCharge;  
class FrontendController extends Controller
{
    public function LoginPage()
    {
        return view('pages.login');   // Correct path
    }
    public function RegisterPage()
    {
        return view('pages.register');   // Correct path
    }
    public function allProducts()
    {
        // Fetch all products (example)
        $categories = Category::where('status',1)->get();
        return view('pages.all-products', compact('categories')); // your view file
    }
   public function index()
    {
        $banner = Banner::where('status', 1)->get();
        return view('pages.index', [
            'banner' => $banner
        ]);
    }
   public function mostfetchProducts(Request $request)
{
    // Eager loading constraints mapping
    $query = Product::with(['variants' => function($q) {
        $q->where('status', 1);
    }])->where('status', 1);

    // Category Filter 
    if ($request->has('category') && !empty($request->category)) {
        $query->where('category_id', $request->category);
    }

    // Search Filter 
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('product_name', 'LIKE', "%{$search}%")
              ->orWhere('tags', 'LIKE', "%{$search}%");
        });
    }

    $products = $query->get()->map(function($product) {
        $firstVariant = $product->variants->first();
        
        $price = $firstVariant ? $firstVariant->price : 0;
        $discountPrice = $firstVariant ? $firstVariant->discount_price : 0;
        $discountPercentage = $firstVariant ? $firstVariant->discount_percentage : 0;
        
        // E-commerce logic fallback for matching active layout string arrays
        $productImage = $product->images ?? $product->thumbnail ?? ($firstVariant ? ($firstVariant->images ?? $firstVariant->thumbnail) : null);

        return [
            'id'             => $product->id,
            'product_name'   => $product->product_name,
            'price'          => $price,
            'discount_price' => $discountPrice,
            'discount'       => $discountPercentage,
            'images'         => $productImage, 
        ];
    });

    // Price Filter using Collection processing limits
    if ($request->has('min_price') && $request->has('max_price')) {
        $min = $request->min_price;
        $max = $request->max_price;
        $products = $products->filter(function($p) use ($min, $max) {
            return $p['discount_price'] >= $min && $p['discount_price'] <= $max;
        })->values();
    }

    // Checking authentication rules for user context pipeline
    // $wishlist = auth()->check() ? auth()->user()->wishlist()->pluck('product_id')->toArray() : [];
    $wishlist = session()->get('wishlist', []);
    
    // Oruவேளை session-ல் array keys-ல product_ids இருந்தா (e.g., ['1' => true]) array_keys எடுக்கலாம்,
    // இல்லையெனில் direct value array-வாக இருந்தால் array_values அல்லது direct $wishlist-ஐயே பயன்படுத்தலாம்.
    $wishlistIds = is_array($wishlist) ? array_keys($wishlist) : [];

    return response()->json([
        'products' => $products,
        'wishlist' => $wishlist
    ]);
}
    // B. Blockbuster Deals (Swiper Slide Fetch)
    public function fetchDiscountProducts()
    {
        // 1-க்கும் மேற்பட்ட தள்ளுபடி (Discount Percentage > 0) உள்ள வேரியண்ட்களை மட்டும் எடுக்கிறோம்
        $products = Product::where('status', 1)
            ->whereHas('variants', function($q) {
                $q->where('status', 1)->where('discount_percentage', '>', 0);
            })
            ->with(['variants' => function($q) {
                $q->where('status', 1)->orderBy('discount_percentage', 'desc');
            }])
            ->get()
            ->map(function($product) {
                $bestVariant = $product->variants->first(); // அதிக தள்ளுபடி உள்ள வேரியண்ட்

                $productImage = $product->thumbnail ?? ($bestVariant ? $bestVariant->thumbnail : null);

                return [
                    'id'             => $product->id,
                    'product_name'   => $product->product_name,
                    'price'          => $bestVariant ? $bestVariant->price : 0,
                    'discount_price' => $bestVariant ? $bestVariant->discount_price : 0,
                    'discount'       => $bestVariant ? $bestVariant->discount_percentage : 0,
                    'images'         => $productImage,
                ];
            });

        return response()->json($products);
    }
   

 public function discountProducts()
{
    // 1. fetchProducts போலவே இதிலும் variants, category, material-ஐ eager load செய்கிறோம்
    $products = Product::with(['category', 'material', 'variants'])
        ->where('is_new_arrival', 1)
        ->where('status', 1) // Active-ஆன தயாரிப்புகளை மட்டும் எடுக்க
        ->get()
        ->map(function($product) {
            
            // Name fallback normalizer
            $product->product_name = $product->product_name ?? $product->name;
            
            // Image key structure alignment
            $product->images = $product->images ?? $product->image ?? $product->thumbnail ?? '';
            
            // 💡 முக்கிய மாற்றம்: மெயின் தயாரிப்பிலேயே விலை இல்லை என்றால், 
            // முதலாவது வேரியண்ட்டின் (First Variant) விலையை மெயின் விலையாக செட் செய்கிறோம்.
            if (!$product->price && $product->variants->isNotEmpty()) {
                $firstVariant = $product->variants->first();
                $product->price = $firstVariant->price;
                $product->discount_price = $firstVariant->discount_price ?? $firstVariant->selling_price ?? $firstVariant->price;
                $product->discount = $firstVariant->discount ?? $firstVariant->discount_percentage ?? 0;
            } else {
                // ஒருவேளை மெயின் டேபிளிலேயே விலை இருந்தால் அதற்கான Fallback
                $product->price = $product->price ?? 0;
                $product->discount_price = $product->discount_price ?? $product->selling_price ?? $product->price;
                $product->discount = $product->discount ?? 0;
            }

            return $product;
        });

    // 2. Fetch Wishlist Array Keys (fetchProducts-ல் இருப்பது போலவே 100% சிங் செய்யப்பட்டுள்ளது)
    $wishlist = session()->get('wishlist', []);
    $wishlistIds = array_keys($wishlist);

    // JSON response matching front-end JavaScript pipeline
    return response()->json([
        'products' => $products,
        'wishlist' => $wishlistIds
    ]);
}
    // public function ProductDetails($id)
    // {
    //     $product = Product::with(['category', 'material'])->findOrFail($id);

    //     // explode multiple images (stored as comma-separated string)
    //     $images = $product->images ? explode(',', $product->images) : [];
    //     // explode color names
    //     $colorNames = $product->color ? explode(',', $product->color) : [];
    //     $sizes = $product->size ? explode(',', $product->size) : [];

    //     // convert every color name to HEX
    //     $colors = [];
    //     foreach ($colorNames as $color) {
    //         $color = trim($color);
    //         $colors[] = [
    //             'name' => $color,
    //             'code' => $this->generateColorCode($color),
    //         ];
    //     }
    //     $avgRating = Review::where('product_id', $id)
    //         ->where('status', 1)
    //         ->avg('rating');

    //     $reviewCount = Review::where('product_id', $id)
    //         ->where('status', 1)
    //         ->count();

    //     $reviews = Review::with('user')
    //         ->where('product_id', $id)
    //         ->where('status', 1)
    //         ->latest()
    //         ->get();
    //     $wishlistProductIds = collect(session()->get('wishlist', []))
    //         ->pluck('id')
    //         ->toArray();
            
    //     return view('pages.product-detail', compact(
    //         'product',
    //         'images',
    //         'colors',
    //         'sizes',
    //         'avgRating',
    //         'reviewCount',
    //         'wishlistProductIds',
    //         'reviews'
    //     ));
    // }

    public function ProductDetails($id)
    {
        // Eager load variations or base relationships
        $product = Product::with(['category', 'material', 'variants.size', 'variants.color'])->findOrFail($id);

        // Convert JSON or comma separated images
        $images = [];
        if (!empty($product->thumbnail)) {
            $images[] = $product->thumbnail;
        }

        if (!empty($product->images)) {
            $productImages = str_starts_with($product->images, '[')
                ? json_decode($product->images, true)
                : explode(',', $product->images);

            $images = array_merge($images, $productImages);
        }

        // Variant thumbnails
        foreach ($product->variants as $variant) {
            if (!empty($variant->thumbnail)) {
                $images[] = $variant->thumbnail;
            }
        }

        // Remove duplicates & empty values
        $images = array_values(array_unique(array_filter($images)));

        // FIXED: Robust unique color logic matching frontend JS expectations explicitly
        $uniqueColors = $product->variants->filter(function ($variant) {
            // Safe check: Only process if variant has a valid color record or string fallback
            return !empty($variant->color_id) || !empty($variant->color_name);
        })->groupBy(function ($variant) {
            return $variant->color_id ?? $variant->color_name;
        })->map(function ($group) {
            $firstVariant = $group->first();
            $variantColor = $firstVariant->color; // Direct relationship link
            
            $colorId = $firstVariant->color_id ?? $firstVariant->color_name;
            $colorName = $variantColor ? $variantColor->name : ($firstVariant->color_name ?? 'Standard');
            $colorCode = $variantColor ? $variantColor->code : '#000000'; 

            return [
                'id'   => (string)$colorId, // Strict casting to String to match JS node properties perfectly
                'name' => $colorName,
                'code' => $colorCode
            ];
        })->values();

        // Fetch review matrix
        $avgRating = Review::where('product_id', $id)->where('status', 1)->avg('rating');
        $reviewCount = Review::where('product_id', $id)->where('status', 1)->count();
        $reviews = Review::with('user')->where('product_id', $id)->where('status', 1)->latest()->get();

        // Session-based Wishlist check
        $wishlistProductIds = collect(session()->get('wishlist', []))->pluck('id')->toArray();

        return view('pages.product-detail', compact(
            'product',
            'images',
            'uniqueColors',
            'avgRating',
            'reviewCount',
            'wishlistProductIds',
            'reviews'
        ));
    }
   public function generateColorCode($color)
{
    $colors = [
        'Black'     => '#000000',
        'White'     => '#FFFFFF',
        'Red'       => '#FF0000',
        'Blue'      => '#4169E1',
        'Green'     => '#228B22',
        'Yellow'    => '#FFD700',
        'Orange'    => '#FF8C00',
        'Purple'    => '#800080',
        'Pink'      => '#FFC0CB',
        'Brown'     => '#A52A2A',
        'Gray'      => '#808080',
        'Grey'      => '#808080',
        'Silver'    => '#C0C0C0',
        'Gold'      => '#B8860B',
        'Maroon'    => '#800000',
        'Navy'      => '#000080',
        'Teal'      => '#008080',
        'Turquoise' => '#40E0D0',
        'Plum'      => '#DDA0DD',
        'Beige'     => '#F5DEB3',
        'Crimson'   => '#DC143C',
    ];

    $color = trim($color);

    return $colors[$color] ?? '#000000';
}

   public function CartStore(Request $request)
    {
        // 1. Validation Rules
        $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'required|integer', 
            'quantity'   => 'required|integer|min:1',
            'size'       => 'nullable|string',
            'color'      => 'nullable|string',
        ]);

        $userId = auth()->id();

        // ⚡ டேட்டாபேஸிலிருந்து நேரடியாக வேரியண்ட் ரெக்கார்டை எடுக்கிறோம்
        $variant = \App\Models\ProductVariant::where('id', $request->variant_id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$variant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Requested product variant not found!'
            ], 404);
        }

        // வேரியண்ட்டின் discount_price மற்றும் அளவுகளைப் பிரித்தெடுத்தல்
        $discountPrice = (float) $variant->discount_price;
        $quantity = (int) $request->quantity;

        // கார்ட்டில் ஏற்கனவே அதே தயாரிப்பு மற்றும் வேரியண்ட் உள்ளதா எனச் சரிபார்த்தல்
        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id) 
            ->first();

        if ($cart) {
            // ✅ UPDATE EXISTING CART ITEM
            $cart->quantity += $quantity;

            // ⚡ விலை மற்றும் மொத்தத் தொகையை இங்கும் புதுப்பிக்கிறோம்
            $cart->price = $discountPrice; 
            $cart->total_amount = $cart->quantity * $discountPrice;

            $cart->size = $request->size ?? $cart->size;
            $cart->color = $request->color ?? $cart->color;
            $cart->save();
        } else {
            // 🆕 CREATE NEW CART ITEM
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->product_id = $request->product_id;
            $cart->variant_id = $request->variant_id; 
            $cart->quantity = $quantity;
            $cart->size = $request->size;
            $cart->color = $request->color;
            
            // ⚡ 1. 'price' காலமில் variant discount_price சேமிக்கப்படுகிறது
            $cart->price = $discountPrice; 
            
            // ⚡ 2. 'total_amount' காலமில் மொத்தத் தொகை கணக்கிடப்பட்டு சேமிக்கப்படுகிறது
            $cart->total_amount = $quantity * $discountPrice;
            
            $cart->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product variant added to cart successfully!',
            'redirect_url' => route('cart')
        ]);
    }
    public function Cart()
    {
        return view('pages.view-cart'); // your view file
    }
public function getCartItems()
{
    $cartItems = Cart::with(['product', 'productVariant']) 
                    ->where('user_id', auth()->id())
                    ->get();

    $cartItems->transform(function ($item) {
        $price = 0;
        $image = 'no-image.png';

        $variant = $item->productVariant ?? null;
        $product = $item->product ?? null;

        if (!empty($item->price) && floatval($item->price) > 0) {
            $price = $item->price;
        } elseif ($variant) {
            $price = $variant->discount_price ?? $variant->price ?? $variant->variant_price ?? 0;
        } elseif ($product) {
            $price = $product->discount_price ?? $product->price ?? 0;
        }

        if ($variant && (!empty($variant->thumbnail) || !empty($variant->image))) {
            $image = $variant->thumbnail ?? $variant->image;
        } elseif ($product && (!empty($product->thumbnail) || !empty($product->image))) {
            $image = $product->thumbnail ?? $product->image;
        }

        $item->final_price = floatval($price);
        $item->final_image = trim($image);

        return $item;
    });
    return response()->json([
        'status' => 'success',
        'cartItems' => $cartItems
    ]);
}
    public function removeCartItem($id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Item not found']);
        }

        $cartItem->delete();

        return response()->json(['status' => 'success', 'message' => 'Item removed']);
    }
   
    public function updateCart(Request $request) 
    {
        $cartItem = Cart::with(['productVariant'])
                        ->where('id', $request->item_id)
                        ->where('user_id', auth()->id())
                        ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            
            if ($cartItem->productVariant) {
                $price = $cartItem->productVariant->discount_price;
            } else {
                $price = $cartItem->product->discount_price; // Fallback
            }

            $cartItem->total_amount = $price * $request->quantity;
            $cartItem->save();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found'], 404);
    }
    public function CheckOut(Request $request)
    {
        return view('pages.checkout'); // your view file

    }
    // Address
    public function AddressStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'country'       => 'required',
            'address_line1' => 'required',
            'city'          => 'required',
            'state'         => 'required',
            'zip_code'      => 'required',
            'phone'         => 'required',
            'email'         => 'required|email',
            'is_default'    => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $userId = Auth::id();
        $isDefault = $request->has('is_default') ? 1 : 0;
        if ($isDefault === 1) {
            CustomAddress::where('user_id', $userId)
                ->where('is_default', 1)
                ->update(['is_default' => 0]);
        }
        $add = new CustomAddress;
        $add->user_id = Auth::id();
        $add->first_name = $request->first_name;
        $add->last_name = $request->last_name ?? "";
        $add->company_name = $request->company_name ?? '';
        $add->country_region = $request->country;
        $add->street = $request->address_line1 . $request->address_line2 ?? '';
        $add->city = $request->city;
        $add->state = $request->state;
        $add->zip_code = $request->zip_code;
        $add->phone = $request->phone;
        $add->email = $request->email;
        $add->description = $request->description;
        $add->is_default = $isDefault;
        $add->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Address saved successfully'
        ]);
    }

    public function getAddresses()
    {
        $addresses = CustomAddress::where('user_id', auth()->id())->get();
        // $addresses = CustomAddress::where('user_id', '1')->get();

        return response()->json([
            'status' => 'success',
            'addresses' => $addresses
        ]);
    }

    public function getSingleAddress($id)
    {
        $address = CustomAddress::where('id', $id)
            ->where('user_id', auth()->id())
            // ->where('user_id', '1')
            ->first();
        return response()->json(['address' => $address]);
    }
    public function updateAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'country'       => 'required',
            'address_line1' => 'required',
            'city'          => 'required',
            'state'         => 'required',
            'zip_code'      => 'required',
            'phone'         => 'required',
            'email'         => 'required|email',
            'is_default'    => 'nullable|boolean', // Validation adding for toggle flag
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = Auth::id();

        $address = CustomAddress::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Address not found'
            ], 404);
        }

        $isDefault = $request->has('is_default') ? 1 : 0;

        if ($isDefault === 1) {
            CustomAddress::where('user_id', $userId)
                ->where('id', '!=', $id) // Intha current record-ah thavira
                ->where('is_default', 1)
                ->update(['is_default' => 0]);
        } else {
            if ($address->is_default == 1) {
                $isDefault = 1; // Explicit-ah status-ah 1-agave maintain panrom
            }
        }

        $address->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name ?? "",
            'company_name'   => $request->company_name ?? '',
            'country_region' => $request->country,
            'street'         => $request->address_line1 . ' ' . ($request->address_line2 ?? ''),
            'city'           => $request->city,
            'state'          => $request->state,
            'zip_code'       => $request->zip_code,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'description'    => $request->order_notes ?? '',
            'is_default'     => $isDefault // Updating toggle field status here
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Address updated successfully',
            'address' => $address
        ]);
    }
    public function deleteAddress($id)
    {
        CustomAddress::where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Address deleted successfully'
        ]);
    }

    public function addToWishlist($id)
    {
        // dd(2);
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            $wishlist[$id]['quantity']++;
        } else {
            dd($product);
            $wishlist[$id] = [
                "product_name" => $product->product_name,
                "id"           => $product->id,
                "quantity"     => 1,
                "offer_price"  => $product->discount_price,
                "product_img"  => $product->images
            ];
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'message' => 'Added to wishlist',
            'count'   => count($wishlist)
        ]);
    }

    public function removeWishlist($id)
{
    $wishlist = session()->get('wishlist', []);

    if (isset($wishlist[$id])) {
        unset($wishlist[$id]);
        session()->put('wishlist', $wishlist);
    }

    return response()->json([
        'status' => true,
        'message' => 'Removed from wishlist'
    ]);
}
    public function userWishlistList()
    {
        $product = Product::all();

        return view('frontend.user.wishlist', compact('product'));
    }
    public function toggleWishlist($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            $added = false;
        } else {
            $wishlist[$id] = [
                "product_name" => $product->product_name,
                "id"           => $product->id,
                "quantity"     => 1,
                "offer_price"  => $product->discount_price,
                "product_img" => explode(',', $product->images)[0] ?? null,
                "user_id"       => auth()->id()
            ];
            $added = true;
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'message' => $added ? 'Added to wishlist' : 'Removed from wishlist',
            'count' => count($wishlist),
            'added' => $added
        ]);
    }


    public function getWishlist()
    {
        $wishlist = session()->get('wishlist', []);
        return response()->json([
            'items' => $wishlist,
            'count' => count($wishlist)
        ]);
    }
    public function WishListPage()
    {
        return view('pages.wishlist');
    }

    public function NewArive()
    {
        return view('pages.new-arrivals');
    }
    public function Products()
    {
        return view('pages.products');
    }

    public function getNewArrivals()
    {
        
        $products = Product::where('is_new', 1)->where('status', 1)->get();

        $wishlist = session()->get('wishlist', []);
        $wishlistIds = array_keys($wishlist);
        return response()->json([
            'products' => $products,
            'wishlist' => $wishlistIds

        ]);
    }

    public function filterProducts(Request $request)
    {
        $category = $request->category;
        // dd($category);
        if ($category == 'new-arrivals') {
            $products = Product::where('is_new', 1)->where('status', 1)->get();
        } else {
            $products = Product::where('category', $category)
                ->where('status', 1)
                ->get();
        }

        $wishlist = session()->get('wishlist', []);
        $wishlistIds = array_keys($wishlist);

        return response()->json([
            'products' => $products,
            'wishlist' => $wishlistIds
        ]);
    }
    public function About(Request $request)
    {
        return view('pages.about'); // your view file

    }
    public function contact(Request $request)
    {
        return view('pages.contact'); // your view file


    }
    public function privacy(Request $request)
    {
        return view('pages.privacy-policy'); // your view file


    }
    public function shipping(Request $request)
    {
        return view('pages.shipping'); // your view file


    }
    public function terms(Request $request)
    {
        return view('pages.terms'); // your view file


    }


    public function return(Request $request)
    {
        return view('pages.return'); // your view file


    }

    public function FAQ(Request $request)
    {
        return view('pages.faq'); // your view file

    }
    public function userdashboard(Request $request)
    {
        $userId = auth()->id();

        // USER ORDERS
        $orders = Order::with('product')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get();

        // PENDING ORDERS COUNT
        $pendingordersCount = Order::where('user_id', $userId)
            ->where('shipping_status', 1)
            ->count();

        return view('pages.dashboard', compact('orders', 'pendingordersCount'));
    }
    public function OrderStore(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'payment_method' => 'required',
            'order_items' => 'required|array',
        ]);

        // Generate Order ID → O00001 format
        $last = Order::max('id');
        $next = $last ? $last + 1 : 1;
        $orderid = 'O' . sprintf('%05d', $next);

        // ---------------------------------------------------
        // 1️⃣ IF PAYMENT METHOD = RAZORPAY → VERIFY PAYMENT
        // ---------------------------------------------------
        if ($request->payment_method === 'bank') {

            try {
                $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

                // Verify payment signature
                $api->utility->verifyPaymentSignature([
                    "razorpay_order_id" => $request->razorpay_order_id,
                    "razorpay_payment_id" => $request->razorpay_payment_id,
                    "razorpay_signature" => $request->razorpay_signature
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "status" => "failed",
                    "message" => "Payment verification failed"
                ]);
            }
        }

        // ---------------------------------------------------
        // 2️⃣ INSERT ORDER ROWS FOR EACH PRODUCT
        // ---------------------------------------------------
        foreach ($request->order_items as $item) {

            Order::create([
                'user_id' => auth()->id(),
                'order_id' => $orderid,
                'product_id' => $item['product_id'],
                'order_date' => now(),
                'delivery_date' => now()->addDays(2),
                'shiping_address_id' => $request->address_id,
                'shipping_status' => 0,
                'payment_type' => $request->payment_method,
                'status' => 1,
                'total' => $item['total'],

                // Razorpay fields if online payment
                'payment_id' => $request->razorpay_payment_id ?? null,
            ]);
        }

        // ---------------------------------------------------
        // 3️⃣ UPDATE CART ITEMS TO STATUS = 2 (order completed)
        // ---------------------------------------------------
        Cart::where('user_id', auth()->id())
            ->update(['status' => 2]);

        return response()->json([
            'status' => 'success',
            'order_id' => $orderid
        ]);
    }
    // public function OrderStore(Request $request)
    // {
    //     $request->validate([
    //         'address_id' => 'required',
    //         'payment_method' => 'required',
    //         'order_items' => 'required|array',
    //     ]);
    //     // 1. Create MAIN ORDER HEADER
    //     // $order = Order::create([
    //     //     'user_id' => 1,
    //     //     'order_date' => now(),
    //     //     'shiping_address_id' => $request->address_id,
    //     //     'payment_type' => $request->payment_method,
    //     //     'shipping_status' => 0, // pending
    //     //     'delivery_date' => null,
    //     //     'status' => 1, // active order
    //     //     'total' => $request->total,
    //     // ]);
    //     // dd($request->all());
    //     $last = Order::max('id');  // safer than count()

    //     $next = $last ? $last + 1 : 1;

    //     $orderid = 'O' . sprintf('%05d', $next);

    //     // 2. Create CHILD ORDER ITEMS (multiple rows)
    //     foreach ($request->order_items as $item) {
    //         Order::create([
    //             'user_id' => 1,
    //             'order_id' => $orderid,     // FK to main order
    //             'product_id' => $item['product_id'],
    //             'order_date' => now(),
    //             'delivery_date' => now()->addDays(2),
    //             'shiping_address_id' => $request->address_id,
    //             'shipping_status' => 0,
    //             'payment_type' => $request->payment_method,
    //             'status' => 1,
    //             'total' => $item['total'],    // item total
    //         ]);
    //     }

    //     // 3. Update cart items to status = 2 (completed)
    //     Cart::where('user_id', 1)
    //         ->update(['status' => 2]);

    //     return response()->json([
    //         'status' => 'success',
    //         'order_id' => $orderid
    //     ]);
    // }
    public function razorpayCreateOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $request->amount * 100,
            'currency' => 'INR'
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount']
        ]);
    }


    public function MyOrder(Request $request)
    {
        $status = $request->status;

        $orders = Order::with('user') // Eager load user
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });

        // If the user is not admin (role 1), show only their orders
        if (auth()->user()->role != 1) {
            $orders->where('user_id', auth()->id());
        }

        $orders = $orders->orderBy('id', 'DESC')->paginate(10);

        return view('pages.my-order', compact('orders', 'status'));
    }
    public function MyOrderUser(Request $request)
    {
        $status = $request->status;

       $orders = Order::with('user')
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when(auth()->user()->role != 1, function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);
        // dd($orders);
        return view('pages.my-order', compact('orders', 'status'));
    }

 public function calculateGst(Request $request) 
{
    $country = $request->country; 
    $state = $request->state;     
    $subtotal = floatval($request->subtotal);
    $couponCode = $request->coupon_code;

    // 1️⃣ முதலில் டிஸ்கவுண்ட் தொகையைக் கணக்கிடுதல் (Default 0)
    $discount = 0;
    if (!empty($couponCode)) {
        // செஷன் அல்லது டேட்டாபேஸ் மூலம் கூப்பனைச் சரிபார்க்கவும்
        $coupon = Coupon::where('code', $couponCode)->where('status', 1)->first();
        if ($coupon) {
            if ($coupon->type == 'fixed') {
                $discount = floatval($coupon->value);
            } elseif ($coupon->type == 'percent') {
                $discount = ($subtotal * floatval($coupon->value)) / 100;
            }
        }
    }

    // கூப்பனை கழித்த பிறகு இருக்கும் தொகை (இதன் மீதுதான் ஜிஎஸ்டி கணக்கிட வேண்டும்)
    $taxable_amount = $subtotal - $discount;
    if ($taxable_amount < 0) {
        $taxable_amount = 0;
    }

    // 2️⃣ ஷிப்பிங் சார்ஜ் கணக்கிடுதல்
    $shipping = ShippingCharge::where('country', $country)
                              ->where('state', $state)
                              ->first();

    // குறிப்பிட்ட மாநிலம் இல்லை என்றால் 'Other States' செக் செய்யும்
    if (!$shipping) {
        $shipping = ShippingCharge::where('country', $country)
                                  ->where('state', 'Other States')
                                  ->first();
    }

    $shipping_amount = $shipping ? floatval($shipping->charge_amount) : 0;

    // 3️⃣ ஜிஎஸ்டி (GST) கணக்கிடுதல் (உதாரணத்திற்கு 18% வரி என வைத்துக்கொள்வோம்)
    $gst_rate = 18; 
    $cgst = 0;
    $sgst = 0;
    $igst = 0;

    if (trim(strtolower($country)) === 'india') {
        // கஸ்டமர் தமிழ்நாடாக இருந்தால் CGST (9%) + SGST (9%)
        if (trim(strtolower($state)) === 'tamil nadu') {
            $half_rate = $gst_rate / 2;
            $cgst = ($taxable_amount * $half_rate) / 100;
            $sgst = ($taxable_amount * $half_rate) / 100;
        } else {
            // இந்தியாவின் மற்ற மாநிலங்கள் என்றால் IGST (18%)
            $igst = ($taxable_amount * $gst_rate) / 100;
        }
    } else {
        $cgst = 0;
        $sgst = 0;
        $igst = 0;
    }

    $final_total = $taxable_amount + $shipping_amount + $cgst + $sgst + $igst;

    return response()->json([
        'status' => 'success',
        'discount' => round($discount, 2),
        'cgst' => round($cgst, 2),
        'sgst' => round($sgst, 2),
        'igst' => round($igst, 2),
        'shipping_charge' => round($shipping_amount, 2),
        'final_total' => round($final_total, 2)
    ]);
}
}