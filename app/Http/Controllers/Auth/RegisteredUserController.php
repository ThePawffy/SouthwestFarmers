<?php

namespace App\Http\Controllers\Auth;

use App\Models\Plan;
use App\Models\User;
use App\Models\Business;
use App\Models\PlanSubscribe;
use App\Mail\RegistrationMail;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class RegisteredUserController extends Controller
{
    /**
     * Handle registration
     */
    public function store(Request $request)
    {
        Log::info('REGISTER: Request received', $request->all());

        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'shopOpeningBalance' => 'nullable|numeric',
            'business_category_id' => 'required|exists:business_categories,id',
            'phoneNumber' => 'required|max:15',
            'email' => 'required|email|max:255',
            'password' => 'required|max:25',
        ]);

        Log::info('REGISTER: Validation passed');

        DB::beginTransaction();

        try {
            /** ---------------- FREE PLAN ---------------- */
            $freePlan = Plan::where('subscriptionPrice', '<=', 0)
                ->orWhere('offerPrice', '<=', 0)
                ->first();

            Log::info('REGISTER: Free plan', [
                'plan_id' => $freePlan->id ?? null
            ]);

            /** ---------------- BUSINESS ---------------- */
            $business = Business::create([
                'address' => $request->address,
                'companyName' => $request->companyName,
                'phoneNumber' => $request->phoneNumber,
                'subscriptionDate' => $freePlan ? now() : null,
                'shopOpeningBalance' => $request->shopOpeningBalance ?? 0,
                'business_category_id' => $request->business_category_id,
                'will_expire' => $freePlan ? now()->addDays($freePlan->duration) : null,
            ]);

            Log::info('REGISTER: Business created', [
                'business_id' => $business->id
            ]);

            /** ---------------- EMAIL CHECK ---------------- */
            if (User::where('email', $request->email)->exists()) {
                DB::rollBack();

                Log::warning('REGISTER: Email already exists', [
                    'email' => $request->email
                ]);

                return response()->json([
                    'errors' => [
                        'email' => ['This email is already associated with a business.']
                    ]
                ], 422);
            }

            /** ---------------- USER ---------------- */
            $user = User::create([
                'business_id' => $business->id,
                'phone' => $request->phoneNumber,
                'name' => $business->companyName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Log::info('REGISTER: User created', [
                'user_id' => $user->id
            ]);

            /** ---------------- PLAN SUBSCRIBE ---------------- */
            if ($freePlan) {
                $subscribe = PlanSubscribe::create([
                    'plan_id' => $freePlan->id,
                    'business_id' => $business->id,
                    'duration' => $freePlan->duration,
                ]);

                $business->update([
                    'plan_subscribe_id' => $subscribe->id,
                ]);

                Log::info('REGISTER: Plan subscribed', [
                    'subscribe_id' => $subscribe->id
                ]);
            }

            /** ---------------- OTP ---------------- */
            $otp = random_int(100000, 999999);
            $expire = now()->addMinutes(env('OTP_VISIBILITY_TIME', 3));

            $user->update([
                'remember_token' => $otp,
                'email_verified_at' => $expire,
            ]);

            Log::info('REGISTER: OTP generated', [
                'otp' => $otp,
                'expires_at' => $expire
            ]);

            /** ---------------- MAIL ---------------- */
            if (!env('MAIL_USERNAME')) {
                DB::rollBack();

                Log::error('REGISTER: Mail not configured');

                return response()->json([
                    'errors' => [
                        'email' => ['Mail service is not configured. Please contact admin.']
                    ]
                ], 422);
            }

           if (env('QUEUE_MAIL')) {
    Mail::to($request->email)->queue(
        new RegistrationMail([
            'code' => $otp,
            'name' => $request->companyName,
        ])
    );
} else {
    Mail::to($request->email)->send(
        new RegistrationMail([
            'code' => $otp,
            'name' => $request->companyName,
        ])
    );
}

            Log::info('REGISTER: OTP mail sent');

            DB::commit();

            return response()->json([
                'message' => 'An OTP code has been sent to your email.',
                'openModal' => true,
                'email' => $request->email,
                'otp_expiration' => now()->diffInSeconds($expire),
            ]);

        } catch (\Throwable $e) {
    DB::rollBack();

    Log::error('REGISTER: Exception', [
        'message' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
    ]);

    return response()->json([
        'errors' => [
            'general' => [
                'Something went wrong. Please contact admin.',
                'Error: '.$e->getMessage().' ('.$e->getFile().':'.$e->getLine().')',
            ],
        ],
    ], 422);
}
    }

    /**
     * Resend OTP
     */
    public function otpResend(Request $request)
    {
        Log::info('OTP RESEND: Request', $request->all());

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = random_int(100000, 999999);
        $expire = now()->addMinutes(env('OTP_VISIBILITY_TIME', 3));

        User::where('email', $request->email)->update([
            'remember_token' => $otp,
            'email_verified_at' => $expire,
        ]);

        if (env('QUEUE_MAIL')) {
    Mail::to($request->email)->queue(
        new RegistrationMail([
            'code' => $otp,
            'name' => $request->companyName,
        ])
    );
} else {
    Mail::to($request->email)->send(
        new RegistrationMail([
            'code' => $otp,
            'name' => $request->companyName,
        ])
    );
}

        Log::info('OTP RESEND: OTP sent', [
            'email' => $request->email,
            'otp' => $otp
        ]);

        return response()->json([
            'message' => 'OTP resent successfully.',
            'otp_expiration' => now()->diffInSeconds($expire),
        ]);
    }

    /**
     * Verify OTP
     */
    public function otpSubmit(Request $request)
    {
        Log::info('OTP VERIFY: Request', $request->all());

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|min:4|max:15',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'email' => ['User not found.']
                ]
            ], 422);
        }

        if ($user->remember_token != $request->otp) {
            return response()->json([
                'errors' => [
                    'otp' => ['Invalid OTP.']
                ]
            ], 422);
        }

        if ($user->email_verified_at < now()) {
            return response()->json([
                'errors' => [
                    'otp' => ['OTP has expired.']
                ]
            ], 422);
        }

        $user->update([
            'remember_token' => null,
            'email_verified_at' => now(),
        ]);

        Log::info('OTP VERIFY: Success', [
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'OTP verified successfully.',
            'redirect' => route('login'),
        ]);
    }
}
