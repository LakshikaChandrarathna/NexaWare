<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;  
use App\Models\UserNotification;
use App\Models\TwoFactorVerification;  
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;  

class BuyerSettingsController extends Controller
{
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        /** @var User $user */  
        $user = Auth::user(); 

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'The provided current password does not match our records.'
            ])->withInput(); 
        }

        $user->password = Hash::make($request->new_password);
        $user->save(); 

        return redirect()->back()->with('success', 'Your password has been successfully updated!');
    }

     
    public function updateNotifications(Request $request)
    {
        $userId = Auth::id(); 

        UserNotification::updateOrCreate(
            ['user_id' => $userId],
            [
                'email_notifications' => $request->has('email_notifications'),
                'sms_alerts'          => $request->has('sms_alerts'),
                'order_updates'       => $request->has('order_updates'),
            ]
        );

        return redirect()->back()->with('success_notification', 'Notification preferences saved successfully!');
    }

     
    public static function canSendNotification($userId, $channelType)
    {
        $settings = UserNotification::where('user_id', $userId)->first();

        if (!$settings) {
            if ($channelType === 'sms_alerts') {
                return false;  
            }
            return true;  
        }

        return (bool) $settings->$channelType;
    }
 
    public function updateLanguage(Request $request)
    {
         $request->validate([
            'locale' => 'required|in:en,si,ta',
        ]);

        $lang = $request->locale;

        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->language = $lang;
            $user->save();
        }

        session(['locale' => $lang]);
        app()->setLocale($lang);

        if ($lang === 'en') {
            $previousUrl = url()->previous();
            $redirectUrl = $previousUrl . (strpos($previousUrl, '?') !== false ? '&' : '?') . 'hl=en';
            return redirect()->to($redirectUrl)->with('success_language', 'Language updated to English!');
        }

        return redirect()->back()->with('success_language', 'Language preference updated successfully!');
    }

     
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999); 

        try {
            TwoFactorVerification::updateOrCreate(
                ['email' => $email],
                ['otp_code' => $otp, 'is_verified' => false]
            );

            Mail::send('mail.ecomTwoFactorsemail', ['otp' => $otp], function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your 2FA Verification Code');
            });

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to your email successfully.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('2FA Send Code Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please check configuration.'
            ], 500);
        }
    }

    /**
     * Verify the sent 2FA OTP Code.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $record = TwoFactorVerification::where('email', $request->email)
                                    ->where('otp_code', $request->otp)
                                    ->first();

        if ($record) {
            $record->update([
                'is_verified' => true,
                'otp_code' => null 
            ]);

            return response()->json([
                'success' => true,
                'message' => '2FA Enabled successfully!'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code. Please try again.'
        ], 400);
    }
     
    /**
     * Process Account Deletion (Transactional data cleanup).
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or unauthenticated.'
            ], 401);
        }

        $userId = $user->id; 
        DB::beginTransaction();

        try {
            $userName = $user->name;
            $userEmail = $user->email;

            DB::table('delete_accounts_logs')->insert([
                'user_id' => $userId,
                'name' => $userName,
                'email' => $userEmail,
                'deleted_at' => now(),
                'reason' => $request->input('reason', null),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $human = null;
            if (Schema::hasTable('humans')) {
                $query = DB::table('humans');

                if (Schema::hasColumn('humans', 'created_userid') && Schema::hasColumn('humans', 'id')) {
                    $human = $query->where('created_userid', $userId)
                                   ->orWhere('id', $userId)
                                   ->first();
                } elseif (Schema::hasColumn('humans', 'created_userid')) {
                    $human = $query->where('created_userid', $userId)->first();
                } elseif (Schema::hasColumn('humans', 'id')) {
                    $human = $query->where('id', $userId)->first();
                }
            }

            if ($human) {
                DB::table('human_contacts')->where('human_id', $human->id)->delete();
                DB::table('human_emails')->where('human_id', $human->id)->delete();
                DB::table('humans')->where('id', $human->id)->delete();
            }
            
            DB::table('users')->where('id', $userId)->delete();

            DB::commit();

            Auth::logout();
            
            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return response()->json([
                'success' => true,
                'message' => 'Your account has been deleted successfully.'
            ]);

        } catch (Throwable $e) {  
            DB::rollBack();
            
            Log::error('Account deletion failed for User ID ' . $userId . ': ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'An internal server error occurred while deleting your account. Please try again later.'
            ], 500);
        }
    }

    
    public function savePin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        try {
            $hashedPin = Hash::make($request->pin);

             
            TwoFactorVerification::updateOrCreate(
                ['email' => $user->email],  
                [
                    'pin' => $hashedPin,
                    'is_verified' => true,
                ]        
            );

            return response()->json(['success' => true, 'message' => 'PIN set successfully in 2FA!']);

        } catch (\Exception $e) {
            Log::error('PIN Save Error: ' . $e->getMessage());

            return response()->json([
                'success' => false, 
                'message' => 'Database operation failed. Ensure the "pin" column exists on your schema.'
            ], 500);
        }
    }

    public function checkTwoFAStatus()
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['enabled' => false]);
    }

    $exists = \App\Models\TwoFactorVerification::where('email', $user->email)
                    ->where('is_verified', true)
                    ->exists();

    return response()->json(['enabled' => $exists]);
}

// public function disableTwoFA()
// {
//     $user = Auth::user();

//     if (!$user) {
//         return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
//     }

//     try {
        
//         \App\Models\TwoFactorVerification::where('email', $user->email)->delete();

//         return response()->json([
//             'success' => true, 
//             'message' => 'Two-Factor Authentication disabled successfully.'
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('2FA Disable Error: ' . $e->getMessage());
//         return response()->json([
//             'success' => false, 
//             'message' => 'Failed to disable 2FA. Please try again.'
//         ], 500);
//     }
// }

}