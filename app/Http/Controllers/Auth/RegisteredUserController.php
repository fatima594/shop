<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = strtolower($request->email);

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);
            Log::info('Request Data', ['data' => $request->all()]);


        $token = $user->createToken('MyAwesomeApp-User-')->plainTextToken;

        event(new Registered($user));

        Auth::login($user);

        // بدلاً من إعادة التوجيه، قم بإرجاع استجابة 201
        return response()->json(['token' => $token, 'user' => $user], 201);
    }catch (\Exception $e) {
            Log::error('Error in User Registration', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }



    }





    public function login(Request $request)
    {

            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
                'remember' => ['nullable', 'boolean'], // تحقق من خيار "تذكرني"
            ]);

            // تحقق من محاولة تسجيل الدخول مع خيار "تذكرني"
            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                $token = $user->createToken('MyAwesomeApp-User-')->plainTextToken;

                return response()->json(['token' => $token, 'user' => $user], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }


