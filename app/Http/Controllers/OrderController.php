<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CustomAddress;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;






class OrderController extends Controller
{
    //
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('pages.select-payment', compact('order'));
    }

    // public function createInitial(Request $request)
    // {
    //     // $order = Order::create([
    //     //     'shiping_address_id' => $request->address_id,
    //     //     'status' => '1',
    //     //     'shipping_status' => '1',
    //     //     'user_id' => auth()->id(),
    //     //     'product_id' => 2, // Make sure your request contains this
    //     //     'order_id' => '1111',
    //     //     'order_date' => now(),
    //     //     'total' => 1000,    // item total
    //     //     'delivery_date' => now()->addDays(2),
    //     //     'payment_type' => 'cod'

    //     // ]);

    //     // return response()->json([
    //     //     'status' => 'success',
    //     //     'order_id' => $order->id
    //     // ]);
    //     DB::beginTransaction();

    //     try {

    //         $userId = auth()->id();
    //         $productIds = collect($request->products)->pluck('product_id')->toArray();
    //         // 🔹 Cart subtotal
    //         $subtotal = Cart::where('user_id', $userId)->sum('total_amount');
    //         $couponData = session('applied_coupon');
    //         $couponDiscount = 0;
    //         $couponCode = null;
    //         $paymentType = $request->payment_method;

    //         // 🔹 If coupon applied
    //         if ($couponData) {
    //             $couponDiscount = $couponData['discount'];
    //             $couponCode = $couponData['code'];

    //             // 🔹 Increment coupon usage
    //             Coupon::where('id', $couponData['id'])
    //                 ->increment('used_count');
    //         }

    //         // 🔹 Final total
    //         $total = max($subtotal - $couponDiscount, 0);
    //         // dd($productIds);
    //         // 🔹 Create Order
    //         $order = Order::create([
    //             'shiping_address_id' => $request->address_id,
    //             'user_id' => $userId,
    //             'order_id' => 'ORD-' . time(),
    //             'order_date' => now(),
    //             'product_id' => implode(',', $productIds),
    //             'subtotal' => $subtotal,
    //             'coupon_code' => $couponCode,
    //             'coupon_discount' => $couponDiscount,
    //             'total' => $total,

    //             'status' => 1,
    //             'shipping_status' => 1,
    //             // 'payment_type' => 'cod',
    //             'payment_type' => $paymentType,
    //             'delivery_date' => now()->addDays(2)
    //         ]);

    //         // 🔹 Clear cart
    //         Cart::where('user_id', $userId)->delete();

    //         // 🔹 Clear coupon session
    //         session()->forget('applied_coupon');

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'order_id' => $order->id
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function createInitial(Request $request)
    {
        DB::beginTransaction();

        try {
            $userId = auth()->id();

            $cartItems = Cart::with([
                'product',
                'variant'
            ])
                ->where('user_id', $userId)
                ->where('status', 1)
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cart is empty'
                ], 400);
            }

            $couponData = session('applied_coupon', []);
            $couponDiscount = (float) ($couponData['discount'] ?? 0);
            $couponCode = $couponData['code'] ?? null;

            $itemCount = $cartItems->count();
            $orders = [];
            $totalPayable = 0;

            foreach ($cartItems as $item) {

                // Product price
                $subtotal = (float) $item->total_amount;

                // Product GST %
                $taxPercentage = (float) ($item->product->tax ?? 0);

                // GST Amount (Always on original subtotal)
                $gstAmount = ($subtotal * $taxPercentage) / 100;

                // Coupon discount split equally
                $discount = $couponDiscount > 0
                    ? round($couponDiscount / $itemCount, 2)
                    : 0;

                /*
                |--------------------------------------------------------------------------
                | Final Formula
                |--------------------------------------------------------------------------
                | Total = Subtotal + GST - Discount
                |--------------------------------------------------------------------------
                */
                $total = $subtotal + $gstAmount - $discount;

                $totalPayable += $total;

                $orderData = [
                    'shiping_address_id' => $request->address_id,
                    'user_id'            => $userId,
                    'order_id'           => 'ORD-' . strtoupper(uniqid()),
                    'order_date'         => now(),
                    'product_id'         => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name'       => $item->product->product_name,

                    'color_id'           => $item->variant->color_id ?? null,
                    'size_id'            => $item->variant->size_id ?? null,
                    'product_price'      => $item->price,
                    'quantity'           => $item->quantity,

                    'subtotal'           => round($subtotal, 2),
                    'coupon_code'        => $couponCode,
                    'coupon_discount'    => round($discount, 2),
                    'tax'                => round($gstAmount, 2),
                    'total'              => round($total, 2),
                    'payment_type'       => $request->payment_method,
                    'status'             => 0,
                    'shipping_status'    => 0,
                ];

                if ($request->payment_method === 'cod') {
                    $orderData['delivery_date'] = now()->addDays(2);
                }

                $orders[] = Order::create($orderData);
            }

            Cart::where('user_id', $userId)
                ->where('status', 1)
                ->delete();

            session()->forget('applied_coupon');

            DB::commit();

            return response()->json([
                'status'       => 'success',
                'order_ids'    => collect($orders)->pluck('id'),
                'total_amount' => round($totalPayable, 2)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Step 2: Payment select page
    public function selectPayment($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('pages.select-payment', compact('order'));
    }

    // Step 3: COD
    public function cashOnDelivery($order_id)
    {
        $order = Order::findOrFail($order_id);

        $order->update([
            'payment_type' => 'cod',
            'payment_status' => '1',
            'status' => '1'
        ]);

        // return redirect("/order-success/".$order_id);
        return redirect("/");
    }

    // Step 4: Razorpay
    public function razorpayPayment($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Validate that the order total is greater than 0
        if ($order->total <= 0) {
            dd(3);
            return redirect()->back()->with('error', 'Order total must be greater than 0');
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Create Razorpay order
        $razorOrder = $api->order->create([
            'receipt' => 'ORDER_' . $order->order_id, // convert to string with prefix
            'amount' => $order->total * 100,  // amount in paise
            'currency' => 'INR'
        ]);

        return view('pages.razorpay_payment', [
            'order' => $order,
            'rOrder' => $razorOrder
        ]);
    }

    // Step 5: Razorpay callback
    public function razorpayVerify(Request $request)
    {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            Order::where('id', $request->receipt)->update([
                'payment_status' => '1',
                'payment_method' => 'online',
                'status' => '1'
            ]);

            return redirect("/order-success/" . $request->receipt);
        } catch (\Exception $e) {
            return "Payment Verification Failed";
        }
    }
    public function savePayment(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'razorpay_payment_id' => 'required',
                'razorpay_order_id' => 'required',
                'razorpay_signature' => 'required'
            ]);

            $order = Order::findOrFail($request->order_id);

            // ✅ Prevent duplicate payment
            if ($order->status == 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order already paid'
                ]);
            }

            // ✅ Save payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_signature' => $request->razorpay_signature,
                'amount' => $order->total, // 🔥 use DB amount (NOT request)
                'status' => 'completed'
            ]);

            $order->update([
                'status' => 1,
                'shipping_status' => 1,
                'delivery_date' => now()->addDays(2),
                'payment_status' => '1',
            ]);

            // ✅ Clear cart AFTER success
            Cart::where('user_id', $order->user_id)->delete();

            // ✅ Remove coupon
            session()->forget('applied_coupon');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'payment_id' => $payment->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 3; // Cancelled
        $order->reason = $request->reason;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order cancelled successfully!']);
    }

    public function return(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 2; // Returned
        $order->reason = $request->reason;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order returned successfully!']);
    }
    public function ReviewStore(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ]);

        $exists = Review::where('order_id', $request->order_id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already reviewed'], 422);
        }

        Review::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 1
        ]);

        return response()->json(['status' => 'success']);
    }


    public function ReviewShow($id)
    {
        $product = Product::findOrFail($id);

        $avgRating = Review::where('product_id', $id)
            ->where('status', 1)
            ->avg('rating');

        $reviewCount = Review::where('product_id', $id)
            ->where('status', 1)
            ->count();

        $reviews = Review::where('product_id', $id)
            ->where('status', 1)
            ->latest()
            ->get();

        return view('pages.product-detail', compact(
            'product',
            'avgRating',
            'reviewCount',
            'reviews'
        ));
    }

    public function CouponStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
    // public function updateOrderStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'shipping_status' => 'required|integer|in:1,2,3',
    //     ]);

    //     $order = Order::findOrFail($id);

    //     $order->update([
    //         'shipping_status' => $request->shipping_status,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Shipping status updated successfully'
    //     ]);
    // }
    // public function applyCoupon(Request $request)
    // {
    //     $request->validate([
    //         'coupon_code' => 'required|string'
    //     ]);

    //     $coupon = Coupon::where('coupon_code', $request->coupon_code)
    //         ->where('status', 1)
    //         ->first();

    //     if (!$coupon) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid coupon code'
    //         ], 404);
    //     }

    //     // 🔹 Expiry check
    //     if (Carbon::now()->gt($coupon->expiry_date)) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Coupon expired'
    //         ], 400);
    //     }

    //     // 🔹 Usage limit
    //     if ($coupon->used_count >= $coupon->usage_limit) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Coupon usage limit exceeded'
    //         ], 400);
    //     }

    //       $cartItems = Cart::with('product')
    //     ->where('user_id', auth()->id())
    //     ->where('status', 1)
    //     ->get();

    //     // 🔹 Cart subtotal
    //     $cartTotal = Cart::where('user_id', auth()->id())->sum('total_amount');
    //     // dd($cartTotal);
    //     if ($cartTotal < $coupon->min_order_amount) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Minimum order amount not reached'
    //         ], 400);
    //     }

    //     // 🔹 Discount calculation
    //     if ($coupon->discount_type == 1) {
    //         // Percentage
    //         $discount = ($cartTotal * $coupon->discount) / 100;
    //     } else {
    //         // Flat
    //         $discount = $coupon->discount;
    //     }

    //     // 🔹 Max discount cap
    //     if ($coupon->max_discount && $discount > $coupon->max_discount) {
    //         $discount = $coupon->max_discount;
    //     }

    //     $finalTotal = max($cartTotal - $discount, 0);

    //     // ✅ STORE COUPON IN SESSION
    //     session([
    //         'applied_coupon' => [
    //             'id' => $coupon->id,
    //             'code' => $coupon->coupon_code,
    //             'discount' => round($discount, 2),
    //             'subtotal' => $cartTotal,
    //             'final_total' => round($finalTotal, 2)
    //         ]
    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'discount' => round($discount, 2),
    //         'final_total' => round($finalTotal, 2),
    //         'message' => 'Coupon applied successfully'
    //     ]);
    // }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'subtotal'    => 'required|numeric'
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid coupon code'
            ], 422); // AJAX-க்கு 422 Unprocessable Entity கொடுப்பது நல்லது
        }

        if ($coupon->expiry_date && Carbon::now()->gt(Carbon::parse($coupon->expiry_date))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Coupon expired'
            ], 422);
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Coupon usage limit exceeded'
            ], 422);
        }

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->where('status', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cart is empty'
            ], 422);
        }

        $subtotal  = 0;
        $gstTotal  = 0;
        $cartTotal = 0;

        foreach ($cartItems as $item) {
            $price = floatval($item->total_amount); // அசல் தயாரிப்பு விலை
            $taxPercentage = $item->product->tax ?? 0;

            $itemGST   = ($price * $taxPercentage) / 100;
            $itemTotal = $price + $itemGST;

            $subtotal  += $price;
            $gstTotal  += $itemGST;
            $cartTotal += $itemTotal;
        }

        if ($cartTotal < $coupon->min_order_amount) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Minimum order amount should be ₹' . number_format($coupon->min_order_amount, 2)
            ], 422);
        }

        $discount = 0;
        $discountType = strtolower($coupon->discount_type);

        if ($discountType === 'percentage' || $coupon->discount_type == 1) {
            $discount = ($cartTotal * $coupon->discount) / 100;
        } else {
            $discount = $coupon->discount;
        }

        if ($coupon->max_discount && $discount > $coupon->max_discount) {
            $discount = $coupon->max_discount;
        }

        if ($discount > $cartTotal) {
            $discount = $cartTotal;
        }

        $finalTotal = max($cartTotal - $discount, 0);

        session([
            'applied_coupon' => [
                'id'          => $coupon->id,
                'code'        => $coupon->coupon_code,
                'subtotal'    => round($subtotal, 2),
                'gst_total'   => round($gstTotal, 2),
                'cart_total'  => round($cartTotal, 2),
                'discount'    => round($discount, 2),
                'final_total' => round($finalTotal, 2),
            ]
        ]);

        return response()->json([
            'status'      => 'success',
            'subtotal'    => round($subtotal, 2),
            'gst_total'   => round($gstTotal, 2),
            'cart_total'  => round($cartTotal, 2),
            'discount'    => round($discount, 2),
            'final_total' => round($finalTotal, 2),
            'message'     => 'Coupon applied successfully'
        ]);
    }
    // 

    public function invoice($id)
    {
        $order = Order::with([
            'user',
            'product',
            'shippingAddress'
        ])->findOrFail($id);

        // Optional security check
        if (auth()->id() != $order->user_id) {
            abort(403);
        }

        return view('pages.invoice', compact('order'));
    }
}
