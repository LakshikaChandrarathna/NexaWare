<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Str; 
use Kreait\Firebase\Factory;

use App\Models\User; 
use App\Models\ecomRegistrationMail;   

class AuthController extends Controller
{
    protected $auth;
public function __construct()
    {
        // Define the exact path to your JSON file
        $credentialsPath = storage_path('app/firebase_credentials.json');

        // Check if the file actually exists before initializing
        if (file_exists($credentialsPath)) {
            // FIXED: Removed the redundant namespace string prefix
            $factory = (new Factory)->withServiceAccount($credentialsPath);
            $this->auth = $factory->createAuth();
        } else {
            $this->auth = null;
        }
    }
    

    // 1. REGISTRATION PROCESS
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'country'      => 'required|string',
            'country_code' => 'required|string', 
            'email'        => 'required|email|string|max:255', 
            'password'     => 'required|string|min:6',
            'user_role'    => 'required|string|in:buyer,seller', 
            'username'     => 'nullable|string|unique:users,username',
            'county_id'    => 'nullable|integer',
            'module_id'    => 'nullable|integer',
            'code'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $emailExists = DB::table('human_emails')->where('email', $request->email)->exists();
        $phoneExists = DB::table('human_contacts')->where('contact_no', $request->phone_number)->exists();

        if ($emailExists) {
            return response()->json(['success' => false, 'errors' => ['email' => ['This email is already registered.']]], 422);
        }
        if ($phoneExists) {
            return response()->json(['success' => false, 'errors' => ['phone_number' => ['This phone number is already registered.']]], 422);
        }

        try {
            DB::beginTransaction();

            $roleRecord = DB::table('user_roles')
                ->where('role', $request->user_role)
                ->where('isDelete', 0)
                ->first();

            if ($roleRecord) {
                $finalRoleId = $roleRecord->id;
            } else {
                $finalRoleId = DB::table('user_roles')->insertGetId([
                    'role'      => $request->user_role,
                    'isDelete'  => 0,
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
            }
            
            $humanId = DB::table('humans')->insertGetId([
                'firstname'  => $request->first_name,
                'surname'    => $request->last_name,
                'fullname'   => $request->first_name . ' ' . $request->last_name,
                'country'    => $request->country,
                'password'   => Hash::make($request->password), 
                'status'     => 1,
                'isDelete'   => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // B. Human Contacts Table
            DB::table('human_contacts')->insert([
                'human_id'     => $humanId,
                'contact_type' => 'Mobile',
                'country_code' => $request->country_code,
                'contact_no'   => $request->phone_number,
                'is_primary'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // C. Human Emails Table
            DB::table('human_emails')->insert([
                'human_id'   => $humanId,
                'email'      => $request->email,
                'is_primary' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $userId = DB::table('users')->insertGetId([
                'id'         => $humanId, 
                'name'       => $request->first_name . ' ' . $request->last_name,
                'email'      => $request->email,
                'username'   => $request->username ?? explode('@', $request->email)[0], 
                'password'   => Hash::make($request->password),
                'code'       => $request->code ?? null,
                'county_id'  => $request->county_id ?? null,
                'role_id'    => $finalRoleId, 
                'module_id'  => $request->module_id ?? null,
                'isDelete'   => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit(); 

            $user = User::find($userId);
            if ($user) {
                Auth::login($user);
            }
            session(['human_id' => $humanId, 'human_name' => $request->first_name]);

            $fullName = $request->first_name . ' ' . $request->last_name;
            $email = $request->email;

            try {
                Mail::send('mail.buyerRegistoremail', ['name' => $fullName, 'email' => $email], function ($message) use ($email) {
                    $message->from(config('mail.from.address'), 'DBonda Team')
                            ->to($email)
                            ->subject('Successfully registered - DBonda');
                });

                ecomRegistrationMail::create([
                    'name'   => $fullName,
                    'email'  => $email,
                    'status' => 'success',   
                ]);
            } catch (\Exception $mailEx) {
                Log::error('Registration Mail Failed: ' . $mailEx->getMessage());
                
                ecomRegistrationMail::create([
                    'name'   => $fullName,
                    'email'  => $email,
                    'status' => 'failed',   
                ]);
            }
       
            return response()->json(['success' => true, 'message' => 'Registration successful!']);
        
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong!', 'error' => $e->getMessage()], 500);
        }
    }

    // 2. LOGIN PROCESS
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_field' => 'required|string', 
            'password'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $loginField = $request->login_field;
        $user = null;

        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $loginField)->where('isDelete', 0)->first();
        } else {
            $user = User::where('username', $loginField)->where('isDelete', 0)->first();
            
            if (!$user) {
                $phoneRecord = DB::table('human_contacts')->where('contact_no', $loginField)->first();
                if ($phoneRecord) {
                    $user = User::where('id', $phoneRecord->human_id)->where('isDelete', 0)->first();
                }
            }
        }

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            session(['human_id' => $user->id, 'human_name' => explode(' ', $user->name)[0]]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Login successful!',
                'human_name' => explode(' ', $user->name)[0]
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => ['login_field' => ['The provided credentials do not match our records.']]
        ], 401);
    }

    // 3. LOGOUT PROCESS
    public function logout()
    {
        try {
            if (Auth::check()) {
                Auth::logout();
            }

            session()->forget(['human_id', 'human_name']);
            
            if (session()->isStarted()) {
                session()->invalidate();
                session()->regenerateToken();
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Logout Server Error: ' . $e->getMessage());
            
            if (isset($_SESSION)) {
                session_destroy();
            }
            return response()->json(['success' => true, 'forced' => true]);
        }
    }

    public function googleLogin(Request $request)
    {
        $idToken = $request->input('token');

        if (!$this->auth) {
            return response()->json([
                'success' => false, 
                'message' => 'Server Configuration Error: Firebase instance context not initialized. Ensure storage/app/firebase_credentials.json exists.'
            ], 500);
        }

        try {
            
            $leewayInSeconds = 600; 
            $verifiedIdToken = $this->auth->verifyIdToken($idToken, $leewayInSeconds);
            
            $firebaseUid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $this->auth->getUser($firebaseUid);
            
            $email = $firebaseUser->email;
            $fullName = $firebaseUser->displayName ?? 'Google User';
            $nameParts = explode(' ', $fullName);
            $firstName = $nameParts[0] ?? $fullName;
            $lastName = $nameParts[1] ?? '';

            // 2. Check if the email record already exists
            $existingEmailRecord = DB::table('human_emails')->where('email', $email)->first();

            if (!$existingEmailRecord) {
                DB::beginTransaction();

                $roleId = DB::table('user_roles')->where('role', 'buyer')->value('id') ?? 1;

                // A. Create Human entry
                $humanId = DB::table('humans')->insertGetId([
                    'firstname'  => $firstName,
                    'surname'    => $lastName,
                    'fullname'   => $fullName,
                    'country'    => 'Unknown', 
                    'password'   => Hash::make(Str::random(16)), 
                    'status'     => 1,
                    'isDelete'   => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // B. Create Human Contact placeholder entry
                DB::table('human_contacts')->insert([
                    'human_id'     => $humanId,
                    'contact_type' => 'Mobile',
                    'country_code' => '',
                    'contact_no'   => 'Google_' . Str::random(10),
                    'is_primary'   => 1,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // C. Create Human Email mapping record
                DB::table('human_emails')->insert([
                    'human_id'   => $humanId,
                    'email'      => $email,
                    'is_primary' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // D. Create main User system application record
                DB::table('users')->insert([
                    'id'         => $humanId, 
                    'name'       => $fullName,
                    'email'      => $email,
                    'username'   => explode('@', $email)[0] . rand(10, 99), 
                    'password'   => Hash::make(Str::random(16)),
                    'role_id'    => $roleId, 
                    'code'       => null,
                    'county_id'  => null,
                    'module_id'  => null,
                    'isDelete'   => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                
                // Using explicit where clause instead of find() to safeguard against custom primary key mapping quirks
                $user = User::where('id', $humanId)->first();
                
                if (!$user) {
                    Log::error("Google Auth: Data inserted for ID {$humanId}, but Eloquent failed to retrieve User Model instance.");
                    return response()->json(['success' => false, 'message' => 'User model mapping failed post-registration.'], 500);
                }
            } else {
                // Fetch existing user record
                $user = User::where('id', $existingEmailRecord->human_id)->where('isDelete', 0)->first();
                
                if (!$user) {
                    Log::warning("Google Auth: Email match found for human_id {$existingEmailRecord->human_id}, but no active matching entry found in users table.");
                    return response()->json(['success' => false, 'message' => 'Your account is deactivated or missing its core profile mapping.'], 404);
                }
            }

            // 3. Complete Stateful Session Login authentication setup
            if ($user) {
                Auth::login($user, true); 
                
                session([
                    'human_id'   => $user->id, 
                    'human_name' => explode(' ', $user->name)[0]
                ]);

                return response()->json([
                    'success' => true,
                    'user' => [
                        'firstname' => explode(' ', $user->name)[0],
                        'email' => $user->email
                    ]
                ]);
            }

            return response()->json(['success' => false, 'message' => 'User record matching reference assignment failed.'], 404);

        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            Log::error('Google Auth Failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false, 
                'message' => 'Authentication exception: ' . $e->getMessage()
            ], 401);
        }
    }
}

