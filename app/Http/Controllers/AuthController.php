<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Carbon\Carbon;
use App\Mail\ResetOtpMail;
use Illuminate\Support\Facades\Http;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    //
    // public function loginCheck(Request $request)
    // {
    //     // Validate inputs
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     // Find user
    //     $user = User::where('email', $request->email)->whereNotIn('role', [1])->first();
    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Email not found',
    //         ], 404);
    //     }

    //     // Check password
    //     if (!Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Incorrect password',
    //         ], 401);
    //     }

    //     // Log in user
    //     Auth::login($user);
    //     $request->session()->regenerate();

    //     // Return success with redirect URL
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Login successful',
    //         'redirect_url' => url('/'), // will respect APP_URL and subfolder
    //     ]);
    // }
    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->whereNotIn('role', [1])->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not found',
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password matching registry',
            ], 401);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful! Redirecting...',
            'redirect_url' => url('/'),
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate user session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
    public function registerStore(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            // 'dob'       => 'required|date',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|min:10|max:15',
            'password'  => 'required|min:6',
        ]);

        // Create User
        $user = User::create([
            'name'      => $request->name,
            'role'      => 2,
            // 'dob'       => $request->dob,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password), // ← secure hashing
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration completed'
        ]);
    }

    public function getUser()
    {
        $user = Auth::user(); // or User::find($id)

        return response()->json([
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'phone'      => $user->phone,
        ]);
    }
    public function updateUser(Request $request)
    {
        $user = Auth::user();

        // VALIDATION
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone'        => 'nullable|string|max:20', // Switched to nullable in case phone is missing
            'new_password' => 'nullable|min:6|confirmed',
            'profile_pic'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // BASIC FIELDS
        $user->name  = $request->first_name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // PASSWORD UPDATE
        if ($request->filled('new_password')) {
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'New password cannot be the same as your current password.'
                ], 422);
            }
            $user->password = Hash::make($request->new_password);
        }

        // PROFILE IMAGE UPLOAD
        if ($request->hasFile('profile_pic')) {
            // delete old image if exists
            if ($user->profile_pic && file_exists(public_path('uploads/profile/' . $user->profile_pic))) {
                @unlink(public_path('uploads/profile/' . $user->profile_pic));
            }

            $file = $request->file('profile_pic');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);

            $user->profile_pic = $filename;
        }

        $user->save();

        return response()->json([
            'status'    => true,
            'message'   => 'Profile updated successfully',
            'image_url' => $user->profile_pic ? asset('uploads/profile/' . $user->profile_pic) : null
        ]);
    }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        // Fix: Standardized to 'phone' column matching typical User migrations
        $user = User::where('phone', $request->mobile)
                    ->whereNotIn('role', [1])
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not found in our records'
            ], 404);
        }

        $otp = rand(1000, 9999);

        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        // TODO: Insert external gateway API logic here (e.g., Twilio, MSG91)

        return response()->json([
            'success' => true,
            'message' => 'A security code has been transmitted safely to your phone.'
        ]);
    }

    // 3. Verify OTP code and sign-in
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:4'
        ]);

        // Fix: Querying against 'phone' column to map sendOtp's architecture
        $user = User::where('phone', $request->mobile)
                    ->whereNotIn('role', [1])
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User registry match failure'
            ], 404);
        }

        if (is_null($user->otp) || $user->otp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'The token submitted is invalid'
            ], 422);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Security token has expired. Request a new code.'
            ], 422);
        }

        // Clear security codes on valid confirmation
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect_url' => route('index')
        ]);
    }

    // 4. Generate and dispatch Email OTP
    public function sendEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)
                    ->whereNotIn('role', [1])
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not found'
            ], 404);
        }

        $otp = rand(1000, 9999);

        $user->email_otp = $otp;
        $user->email_otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to email address successfully'
        ]);
    }

    // 5. Verify Email OTP and sign-in
    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4'
        ]);

        $user = User::where('email', $request->email)
                    ->whereNotIn('role', [1])
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User registry match failure'
            ], 404);
        }

        if ($user->email_otp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'The email token submitted is invalid'
            ], 422);
        }

        if (Carbon::now()->gt($user->email_otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Email OTP expired'
            ], 422);
        }

        $user->email_otp = null;
        $user->email_otp_expires_at = null;
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect_url' => route('index')
        ]);
    }


    public function submit(Request $request)
{
    // ✅ Validation
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'required',
        'g-recaptcha-response' => 'required'
    ]);


     $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => '6LeQ09ksAAAAAIag03d7M8wv1YjuqyOWEudxAORY',
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    $result = $response->json();

  if (!$result['success']) {
    return back()->withErrors(['captcha' => 'Captcha verification failed'])->withInput();
}

    // ✅ Store in DB
    $contact = Contact::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
    ]);

    // ✅ Mail Data
    $data = [
        'name' => $contact->name,
        'email' => $contact->email,
        'phone' => $contact->phone,
        'message_text' => $contact->message,
    ];

    // ✅ Send Mail
    Mail::send('pages.contact1', $data, function ($message) use ($data) {
        $message->to('yourgmail@gmail.com')
                ->subject('New Contact Form Message')
                ->replyTo($data['email'], $data['name']);
    });

    return back()->with('success', 'Message stored & sent successfully!');
}


     public function showLinkRequestForm()
    {
        return view('pages.forgot-password'); // create this blade
    }

    
   public function sendForgotOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $user = User::where('email', $request->email)->first();

    $otp = rand(100000, 999999);

    $user->update([
        'otp' => $otp,
        'otp_expires_at' => now()->addMinutes(10)
    ]);

    Mail::to($user->email)->send(new ResetOtpMail($otp));

    return response()->json([
        'status' => true,
        'message' => 'OTP sent to your email'
    ]);
}


public function verifyForgotOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required'
    ]);

    $user = User::where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('otp_expires_at', '>=', now())
        ->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid or expired OTP'
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'OTP verified'
    ]);
}



public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::where('email', $request->email)->first();

    $user->update([
        'password' => Hash::make($request->password),
        'otp' => null,
        'otp_expires_at' => null
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Password reset successful'
    ]);
}   



}
