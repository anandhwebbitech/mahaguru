<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedAdminMail;
use App\Mail\OrderPlacedUserMail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Step 1: create the order rows for everything in the cart (one row per
     * cart line, all sharing a single order_id), then immediately kick off
     * PhonePe for the full total. No COD, no intermediate "select payment" page.
     */
    // public function createInitial(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $userId = auth()->id();

    //         $cartItems = Cart::with(['product', 'variant'])
    //             ->where('user_id', $userId)
    //             ->where('status', 1)
    //             ->get();

    //         if ($cartItems->isEmpty()) {
    //             DB::rollBack();
    //             return response()->json([
    //                 'status'  => 'error',
    //                 'message' => 'Cart is empty'
    //             ], 400);
    //         }

    //         $couponData     = session('applied_coupon', []);
    //         $couponDiscount = (float) ($couponData['discount'] ?? 0);
    //         $couponCode     = $couponData['code'] ?? null;

    //         $itemCount    = $cartItems->count();
    //         $orders       = [];
    //         $totalPayable = 0;

    //         // One shared order_id for every row in this checkout
    //         $orderId = 'ORD-' . strtoupper(uniqid());

    //         foreach ($cartItems as $item) {
    //             $subtotal      = (float) $item->total_amount;
    //             $taxPercentage = (float) ($item->product->tax ?? 0);
    //             $gstAmount     = ($subtotal * $taxPercentage) / 100;

    //             $discount = $couponDiscount > 0
    //                 ? round($couponDiscount / $itemCount, 2)
    //                 : 0;

    //             $total = $subtotal + $gstAmount - $discount;
    //             $totalPayable += $total;

    //             $orders[] = Order::create([
    //                 'shiping_address_id' => $request->address_id,
    //                 'user_id'            => $userId,
    //                 'order_id'           => $orderId,
    //                 'order_date'         => now(),
    //                 'product_id'         => $item->product_id,
    //                 'product_variant_id' => $item->product_variant_id,
    //                 'product_name'       => $item->product->product_name,
    //                 'color_id'           => $item->variant->color_id ?? null,
    //                 'size_id'            => $item->variant->size_id ?? null,
    //                 'product_price'      => $item->price,
    //                 'quantity'           => $item->quantity,
    //                 'subtotal'           => round($subtotal, 2),
    //                 'coupon_code'        => $couponCode,
    //                 'coupon_discount'    => round($discount, 2),
    //                 'tax'                => round($gstAmount, 2),
    //                 'total'              => round($total, 2),
    //                 'payment_type'       => 'phonepe',
    //                 'status'             => 0,       // pending
    //                 'shipping_status'    => 0,
    //                 'payment_status'     => 0,        // pending
    //             ]);
    //         }

    //         if ($totalPayable <= 0) {
    //             DB::rollBack();
    //             return response()->json([
    //                 'status'  => 'error',
    //                 'message' => 'Order total must be greater than 0'
    //             ], 422);
    //         }

    //         Cart::where('user_id', $userId)->where('status', 1)->delete();
    //         session()->forget('applied_coupon');

    //         DB::commit();

    //         // Now start the PhonePe payment session for the combined total
    //         $auth = $this->getAuthToken();
    //         if (!$auth['success']) {
    //             Order::where('order_id', $orderId)->update(['status' => 3, 'payment_status' => 2]);
    //             return response()->json(['status' => 'error', 'message' => 'PhonePe Auth Failed']);
    //         }

    //         $amount  = (int) round($totalPayable * 100); // paise
    //         $payment = $this->createPayment($auth['access_token'], $orderId, $amount);
    //         // dd($payment);
    //         if ($payment['success'] && $payment['redirect_url']) {
    //             return response()->json([
    //                 'status'       => 'success',
    //                 'order_id'     => $orderId,
    //                 'total_amount' => round($totalPayable, 2),
    //                 'redirect_url' => $payment['redirect_url'],
    //             ]);
    //         }

    //         Order::where('order_id', $orderId)->update(['status' => 3, 'payment_status' => 2]);

    //         return response()->json(['status' => 'error', 'message' => 'Payment initiation failed.']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function createInitial(Request $request)
    {
        $userId = auth()->id();

        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', $userId)
            ->where('status', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        $couponData     = session('applied_coupon', []);
        $couponDiscount = (float) ($couponData['discount'] ?? 0);
        $couponCode     = $couponData['code'] ?? null;

        $itemCount    = $cartItems->count();
        $orderRows    = [];
        $totalPayable = 0;

        $orderId = 'ORD-' . strtoupper(uniqid());

        foreach ($cartItems as $item) {
            $subtotal      = (float) $item->total_amount;
            $taxPercentage = (float) ($item->product->tax ?? 0);
            $gstAmount     = ($subtotal * $taxPercentage) / 100;

            $discount = $couponDiscount > 0
                ? round($couponDiscount / $itemCount, 2)
                : 0;

            $total = $subtotal + $gstAmount - $discount;
            $totalPayable += $total;

            $orderRows[] = [
                'shiping_address_id' => $request->address_id,
                'user_id'            => $userId,
                'order_id'           => $orderId,
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
                'payment_type'       => 'phonepe',
                'status'             => 0,
                'shipping_status'    => 0,
                'payment_status'     => 0,
            ];
        }

        if ($totalPayable <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Order total must be greater than 0'], 422);
        }

        // Talk to PhonePe BEFORE writing anything to the DB.
        $auth = $this->getAuthToken();
        if (!$auth['success']) {
            return response()->json(['status' => 'error', 'message' => 'PhonePe Auth Failed']);
        }

        $amount  = (int) round($totalPayable * 100); // paise
        $payment = $this->createPayment($auth['access_token'], $orderId, $amount);

        if (!$payment['success'] || !$payment['redirect_url']) {
            return response()->json(['status' => 'error', 'message' => 'Payment initiation failed.']);
        }

        // Only commit + clear the cart once PhonePe has confirmed a session.
        DB::beginTransaction();
        try {
            foreach ($orderRows as $row) {
                Order::create($row);
            }

            Cart::where('user_id', $userId)->where('status', 1)->delete();
            session()->forget('applied_coupon');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json([
            'status'       => 'success',
            'order_id'     => $orderId,
            'total_amount' => round($totalPayable, 2),
            'redirect_url' => $payment['redirect_url'],
        ]);
    }

    /**
     * Step 2: PhonePe redirects the browser back here. Look up every row
     * sharing this order_id (one per cart item) and finalize them together.
     */
    public function phonepeCallback(Request $request, $orderId)
    {
        DB::beginTransaction();

        try {
            $orders = Order::where('order_id', $orderId)->get();

            if ($orders->isEmpty()) {
                DB::rollBack();
                Log::error('PhonePe Callback: no orders found for ' . $orderId);
                return redirect('/checkout')->with('error', 'Order not found.');
            }

            // Already processed (e.g. duplicate callback hit)
            if ($orders->first()->payment_status == 1) {
                DB::rollBack();
                return redirect('/thank-you/' . $orderId);
            }

            $auth = $this->getAuthToken();
            if (!$auth['success']) {
                DB::rollBack();
                return redirect('/checkout')->with('error', 'Payment verification failed.');
            }

            $verify = $this->verifyPhonePePayment($auth['access_token'], $orderId);

            if (data_get($verify, 'state') === 'COMPLETED') {

                Order::where('order_id', $orderId)->update([
                    'status'          => 1,
                    'shipping_status' => 1,
                    'payment_status'  => 1,
                    'delivery_date'   => now()->addDays(2),
                ]);

                $couponCode = $orders->first()->coupon_code;
                if ($couponCode) {
                    Coupon::where('coupon_code', $couponCode)->increment('used_count');
                }

                DB::commit();

                $this->sendOrderEmails($orderId, $orders);

                return redirect('/thank-you/' . $orderId);
            }

            Order::where('order_id', $orderId)->update([
                'status'         => 3, // cancelled
                'payment_status' => 2, // failed
            ]);
            DB::commit();

            return redirect('/checkout')->with('error', 'Payment failed or was cancelled.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PhonePe Callback Error: ' . $e->getMessage());
            return redirect('/checkout')->with('error', 'Critical error during payment verification.');
        }
    }

    public function thankYou($orderId)
    {
        $orders = Order::with('product')->where('order_id', $orderId)->get();

        if ($orders->isEmpty() || $orders->first()->payment_status != 1) {
            return redirect('/checkout')->with('error', 'This order has not been completed yet.');
        }

        $total = $orders->sum('total');

        return view('frontend.partials.thankyou', [
            'orderId' => $orderId,
            'orders'  => $orders,
            'total'   => $total,
        ]);
    }

    private function sendOrderEmails($orderId, $orders)
    {
        $user = $orders->first()->user; // assumes Order belongsTo User

        Mail::to($user->email)->send(new OrderPlacedUserMail($orderId, $orders));
        Mail::to('kavinwebbitech@gmail.com')->send(new OrderPlacedAdminMail($orderId, $orders));
    }

    private function getAuthToken()
    {
        $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token';

        $response = Http::asForm()->post($url, [
            'client_id'      => config('services.phonepe.client_id'),
            'client_secret'  => config('services.phonepe.client_secret'),
            'grant_type'     => 'client_credentials',
            'client_version' => config('services.phonepe.client_version'),
        ]);

        if (!$response->successful()) {
            Log::error('PhonePe Auth Failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return ['success' => false];
        }

        return [
            'success'      => true,
            'access_token' => $response['access_token'],
            'token_type'   => $response['token_type'],
        ];
    }

    // private function createPayment($accessToken, $orderId, $amount)
    // {
    //     $url = '	https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token';

    //     $payload = [
    //         "merchantId"      => config('services.phonepe.merchant_id'),
    //         "merchantOrderId" => $orderId,
    //         "amount"          => $amount,
    //         "currency"        => "INR",
    //         "paymentFlow" => [
    //             "type"    => "PG_CHECKOUT",
    //             "message" => "Payment for order " . $orderId,
    //             "merchantUrls" => [
    //                 "redirectUrl" => url('/phonepe/callback/' . $orderId),
    //             ],
    //         ],
    //     ];

    //     try {
    //         $response = Http::withHeaders([
    //             'Content-Type'  => 'application/json',
    //             'Authorization' => 'O-Bearer ' . $accessToken,
    //         ])->post($url, $payload);

    //         Log::info('PhonePe payment response', [
    //             'status' => $response->status(),
    //             'body'   => $response->body(),
    //         ]);

    //         if (!$response->successful()) {
    //             return ['success' => false, 'message' => $response->body()];
    //         }

    //         $data = $response->json();
    //         $redirectUrl = null;

    //         if (isset($data['redirectUrl'])) {
    //             $redirectUrl = $data['redirectUrl'];
    //         } elseif (isset($data['data']['redirectUrl'])) {
    //             $redirectUrl = $data['data']['redirectUrl'];
    //         } elseif (isset($data['data']['instrumentResponse']['redirectInfo']['url'])) {
    //             $redirectUrl = $data['data']['instrumentResponse']['redirectInfo']['url'];
    //         }

    //         if (!$redirectUrl) {
    //             Log::error('PhonePe Redirect URL Missing', $data);
    //         }

    //         return ['success' => true, 'data' => $data, 'redirect_url' => $redirectUrl];
    //     } catch (\Exception $e) {
    //         Log::error('PhonePe payment exception', ['error' => $e->getMessage()]);
    //         return ['success' => false, 'message' => $e->getMessage()];
    //     }
    // }

    private function createPayment($accessToken, $orderId, $amount)
    {
        $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay';

        $payload = [
            "merchantOrderId" => $orderId,
            "amount"          => $amount,
            "paymentFlow" => [
                "type"    => "PG_CHECKOUT",
                "message" => "Payment for order " . $orderId,
                "merchantUrls" => [
                    "redirectUrl" => url('/phonepe/callback/' . $orderId),
                ],
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => 'O-Bearer ' . $accessToken,
            ])->post($url, $payload);

            Log::info('PhonePe payment response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            if (!$response->successful()) {
                return ['success' => false, 'message' => $response->body()];
            }

            $data = $response->json();
            $redirectUrl = null;

            if (isset($data['redirectUrl'])) {
                $redirectUrl = $data['redirectUrl'];
            } elseif (isset($data['data']['redirectUrl'])) {
                $redirectUrl = $data['data']['redirectUrl'];
            } elseif (isset($data['data']['instrumentResponse']['redirectInfo']['url'])) {
                $redirectUrl = $data['data']['instrumentResponse']['redirectInfo']['url'];
            }

            if (!$redirectUrl) {
                Log::error('PhonePe Redirect URL Missing', $data);
            }

            return ['success' => true, 'data' => $data, 'redirect_url' => $redirectUrl];
        } catch (\Exception $e) {
            Log::error('PhonePe payment exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function verifyPhonePePayment($accessToken, $orderId)
    {
        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/{$orderId}/status";

        $response = Http::withHeaders([
            'Authorization' => 'O-Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->get($url);

        Log::info('PhonePe Verify Response', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        return $response->json();
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 3;
        $order->reason = $request->reason;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order cancelled successfully!']);
    }

    public function return(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->reason = $request->reason;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order returned successfully!']);
    }

    public function ReviewStore(Request $request)
    {
        $request->validate([
            'order_id'   => 'required',
            'product_id' => 'required',
            'rating'     => 'required',
            'review'     => 'required',
        ]);

        $exists = Review::where('order_id', $request->order_id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already reviewed'], 422);
        }

        Review::create([
            'order_id'   => $request->order_id,
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'review'     => $request->review,
            'status'     => 1
        ]);

        return response()->json(['status' => 'success']);
    }

    public function ReviewShow($id)
    {
        $product = Product::findOrFail($id);

        $avgRating = Review::where('product_id', $id)->where('status', 1)->avg('rating');
        $reviewCount = Review::where('product_id', $id)->where('status', 1)->count();
        $reviews = Review::where('product_id', $id)->where('status', 1)->latest()->get();

        return view('pages.product-detail', compact('product', 'avgRating', 'reviewCount', 'reviews'));
    }

    public function CouponStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'             => 'required|string|max:50|unique:coupons,coupon_code',
            'discount_type'    => 'required|integer',
            'discount'         => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount'     => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'expiry_date'      => 'required|date|after_or_equal:today',
            'status'           => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
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

        return response()->json(['success' => true, 'message' => 'Coupon added successfully']);
    }

    public function CouponEdit($id)
    {
        return Coupon::findOrFail($id);
    }

    public function CouponUpdate(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'coupon_code')->ignore($id)],
            'discount_type' => 'required|in:1,2',
            'discount' => 'required|numeric|min:1',
            'expiry_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $coupon->update([
            'coupon_code'      => strtoupper(trim($request->code)),
            'discount_type'    => $request->discount_type,
            'discount'         => $request->discount,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount'     => $request->max_discount ?? 0,
            'usage_limit'      => $request->usage_limit ?? 1,
            'expiry_date'      => $request->expiry_date,
            'status'           => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Coupon updated successfully']);
    }

    public function CouponDestroy($id)
    {
        Coupon::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Coupon deleted successfully']);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'subtotal'    => 'required|numeric'
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)->where('status', 1)->first();

        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Invalid coupon code'], 422);
        }

        if ($coupon->expiry_date && Carbon::now()->gt(Carbon::parse($coupon->expiry_date))) {
            return response()->json(['status' => 'error', 'message' => 'Coupon expired'], 422);
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['status' => 'error', 'message' => 'Coupon usage limit exceeded'], 422);
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->where('status', 1)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 422);
        }

        $subtotal = 0;
        $gstTotal = 0;
        $cartTotal = 0;

        foreach ($cartItems as $item) {
            $price = floatval($item->total_amount);
            $taxPercentage = $item->product->tax ?? 0;

            $itemGST = ($price * $taxPercentage) / 100;
            $itemTotal = $price + $itemGST;

            $subtotal += $price;
            $gstTotal += $itemGST;
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

    public function invoice($id)
    {
        $order = Order::with(['user', 'product', 'shippingAddress'])->findOrFail($id);

        if (auth()->id() != $order->user_id) {
            abort(403);
        }

        return view('pages.invoice', compact('order'));
    }
}
