<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Review;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

   

   public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    // Email not found
    if (!$user) {
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email address not found.');
    }

    // Incorrect password
    if (!Hash::check($request->password, $user->password)) {
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Incorrect password.');
    }

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Admin login successful.');
}
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate user session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('admin/login')->with('error', 'Logged out successfully.');
    }
// Controller

public function dashboard()
{
    return view('admin.dashboard', [
        'userCount'       => User::count(),
        'orderCount'      => Order::count(),

        // Order Status Counts
        'pendingOrders'   => Order::where('status', 0)->count(),
        'confirmedOrders' => Order::where('status', 1)->count(),
        'returnedOrders'  => Order::where('status', 2)->count(),
        'cancelledOrders' => Order::where('status', 3)->count(),
        'deliveredOrders' => Order::where('status', 4)->count(),

        // Today's Orders
        'todayOrders'     => Order::whereDate('created_at', today())->count(),

        // Products & Users
        'productCount'    => Product::count(),

        // Active Coupons
        'couponCount'     => Coupon::where('status', 1)->count(),

        // Total Income (Exclude Returned & Cancelled)
        'totalIncome' => Order::whereNotIn('status', [2, 3])
    ->where('payment_status', 1)
    ->sum('total'),
    ]);
}

    public function UserList(Request $request)
    {
        $status = $request->status;

        $users = User::where('role', 2);

        if (!empty($status)) {
            $users = $users->where('status', $status);
        }

        // Make sure to get the results
        $users = $users->get();

        return view('admin.userlist', compact('users', 'status'));
    }

    public function coupon()
    {

        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.couponadd', compact('coupons'));
    }

      public function CouponStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // FIXED HERE 👇
            'code' => 'required|string|max:50|unique:coupons,coupon_code',
            'discount_type'    => 'required|integer',
            'discount'         => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount'     => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'expiry_date'      => 'required|date|after_or_equal:today',
            'status'           => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        Coupon::create([
            // FIXED HERE 👇
            'coupon_code'      => strtoupper($request->code),
            'discount_type'    => $request->discount_type,
            'discount'         => $request->discount,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount'     => $request->max_discount ?? 0,
            'usage_limit'      => $request->usage_limit ?? 1,
            'used_count'       => 0,
            'expiry_date'      => $request->expiry_date,
            'status'           => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon added successfully'
        ]);
    }
    public function CouponEdit($id)
    {
        return Coupon::findOrFail($id);
    }
    public function CouponUpdate(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'coupon_code')->ignore($id),
            ],
            'discount_type' => 'required|in:1,2',
            'discount' => 'required|numeric|min:1',
            'expiry_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $coupon->update([
            'coupon_code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount ?? 0,
            'usage_limit' => $request->usage_limit ?? 1,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon updated successfully'
        ]);
    }

    /**
     * Delete coupon
     */
    public function CouponDestroy($id)
    {
        Coupon::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully'
        ]);
    }

    // Update Order & Shipping Status
   // Controller
public function updateOrderStatus(Request $request, $id)
{
    $request->validate([
        'status'          => 'required|integer|in:0,1,2,3,4',
        'shipping_status' => 'required|integer|in:1,2,3',
    ]);

    $order = Order::findOrFail($id);

    $updateData = [
        'status'          => $request->status,
        'shipping_status' => $request->shipping_status,
    ];

    // If payment type is COD and order is Delivered
    if (
        strtolower($order->payment_type) === 'cod' &&
        (int) $request->status === 4
    ) {
        $updateData['payment_status'] = 1;
    }

    $order->update($updateData);

    return response()->json([
        'success' => true,
        'message' => 'Order status updated successfully.',
    ]);
}
    public function OrderList()
    {

        $orders = Order::with(['user', 'product'])
            ->latest()
            ->paginate(10);

        return view('admin.orderlistpage', compact('orders'));
    }
    public function ReviewList()
    {

        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->paginate(10);

        return view('admin.productreviews', compact('reviews'));
    }

  
    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect()->route('admin.login')->with('error', 'Admin Logout Successfully!');
    // }

    // public function profile()
    // {
    //     $user = auth()->user();
    //     return view('admin.profile', compact('user'));
    // }

    // public function updateProfile(Request $request)
    // {
    //     $user = auth()->user();

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'password' => 'nullable|min:6',
    //         'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //     ];

    //     // ✅ PASSWORD UPDATE
    //     if ($request->filled('password')) {
    //         $data['password'] = $request->password; // auto hashed via model cast
    //     }

    //     // ✅ IMAGE UPDATE (OPTIONAL)
    //     if ($request->hasFile('profile_image')) {

    //         $file = $request->file('profile_image');

    //         // Delete old image
    //         if ($user->profile_image && file_exists(public_path('uploads/profile_images/' . $user->profile_image))) {
    //             unlink(public_path('uploads/profile_images/' . $user->profile_image));
    //         }

    //         $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    //         $file->move(public_path('uploads/profile_images/'), $fileName);

    //         $data['profile_image'] = $fileName;
    //     }

    //     // ✅ UPDATE USER
    //     $user->update($data);

    //     return back()->with('success', 'Profile updated successfully');
    // }

    // public function settings()
    // {
    //     $setting = Setting::first();
    //     return view('admin.settings', compact('setting'));
    // }

    // public function updateSettings(Request $request)
    // {
    //     $setting = Setting::first();

    //     // ✅ If no record, create new
    //     if (!$setting) {
    //         $setting = new Setting();
    //     }

    //     $request->validate([
    //         'site_name' => 'required',
    //         'admin_email' => 'required|email',
    //         'logo' => 'nullable|image',
    //         'favicon' => 'nullable|image'
    //     ]);

    //     if ($request->hasFile('logo')) {
    //         $setting->logo = $request->file('logo')->store('settings', 'public');
    //     }

    //     if ($request->hasFile('favicon')) {
    //         $setting->favicon = $request->file('favicon')->store('settings', 'public');
    //     }

    //     $setting->site_name = $request->site_name;
    //     $setting->admin_email = $request->admin_email;
    //     $setting->footer_text = $request->footer_text;

    //     $setting->save();

    //     return back()->with('success', 'Settings saved successfully');
    // }

  public function invoice($id)
{
    $order = Order::with(['user', 'product'])->findOrFail($id);

    return view('admin.invoice', compact('order'));
}

public function enquiry() {
    $contact =Contact::all();
    return view('admin.enquiry',compact('contact'));
}
public function deleteEnquiry($id)
{
    $data = Contact::find($id);

    if($data){
        $data->delete();
        return redirect()->back()->with('success', 'Enquiry deleted successfully');
    }

    return redirect()->back()->with('error', 'Enquiry not found');
}

}
