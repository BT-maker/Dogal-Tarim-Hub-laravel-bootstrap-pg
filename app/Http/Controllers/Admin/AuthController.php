<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use App\Services\JWTService;

class AuthController extends Controller
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        // Check if already logged in via JWT token in cookie
        $token = request()->cookie('admin_jwt_token');
        if ($token && $this->jwtService->validateToken($token)) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    /**
     * Handle admin login with JWT and double encryption
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string', // Password is already SHA-256 hashed from frontend
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'password.required' => 'Şifre gereklidir.',
        ]);

        // Find admin user by email
        $admin = AdminUser::findByEmail($request->email);
        
        if (!$admin) {
            return $this->loginError('E-posta adresi veya şifre hatalı.');
        }

        // Verify the SHA-256 hashed password against bcrypt stored password
        if (!$admin->verifyPassword($request->password)) {
            return $this->loginError('E-posta adresi veya şifre hatalı.');
        }

        // Check if admin is active
        if (!$admin->isActive()) {
            return $this->loginError('Hesabınız deaktif durumda.');
        }

        // Update last login info
        $admin->updateLastLogin($request->ip());

        // Generate JWT token
        $adminData = $admin->getJWTData();
        \Illuminate\Support\Facades\Log::info('Admin data for JWT:', $adminData);
        
        $token = $this->jwtService->generateToken($adminData);
        \Illuminate\Support\Facades\Log::info('Generated JWT token:', ['token' => $token]);
        
        // Test token validation immediately
        $validationResult = $this->jwtService->validateToken($token);
        \Illuminate\Support\Facades\Log::info('Token validation result:', ['result' => $validationResult]);

        // Store JWT token in cookie (24 hours) - simplified for testing
        $cookie = cookie('admin_jwt_token', $token, 60 * 24, '/', null, false, false);

        // Set session data
        session([
            'admin_logged_in' => true,
            'admin_jwt_token' => $token,
            'admin_user' => $admin->getJWTData(),
        ]);

        // Return JSON response for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Başarıyla giriş yaptınız!',
                'user' => $admin->getJWTData(),
                'redirect' => route('admin.dashboard')
            ])->cookie($cookie);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Başarıyla giriş yaptınız!')->cookie($cookie);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Admin logout initiated');
        
        // Clear admin session
        session()->forget(['admin_logged_in', 'admin_jwt_token', 'admin_user']);
        session()->flush();
        
        \Illuminate\Support\Facades\Log::info('Session cleared');

        // Clear JWT cookie
        $cookie = cookie('admin_jwt_token', '', -1, '/', null, false, false);
        \Illuminate\Support\Facades\Log::info('JWT cookie cleared');

        // Return JSON response for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            \Illuminate\Support\Facades\Log::info('Logout - returning JSON response');
            return response()->json([
                'success' => true,
                'message' => 'Başarıyla çıkış yaptınız.',
                'redirect' => route('admin.login')
            ])->cookie($cookie);
        }
        
        \Illuminate\Support\Facades\Log::info('Logout - redirecting to login page');
        return redirect()->route('admin.login')->with('success', 'Başarıyla çıkış yaptınız.')->cookie($cookie);
    }

    /**
     * Refresh JWT token
     */
    public function refreshToken(Request $request)
    {
        $token = session('admin_token') ?? $request->bearerToken();
        
        if (!$token) {
            return response()->json(['error' => 'Token bulunamadı'], 401);
        }

        $newToken = $this->jwtService->refreshToken($token);
        
        if (!$newToken) {
            return response()->json(['error' => 'Token yenilenemedi'], 401);
        }

        session(['admin_token' => $newToken]);

        return response()->json([
            'success' => true,
            'token' => $newToken
        ]);
    }

    /**
     * Get current admin user info
     */
    public function me(Request $request)
    {
        $token = session('admin_token') ?? $request->bearerToken();
        
        if (!$token) {
            return response()->json(['error' => 'Token bulunamadı'], 401);
        }

        $userData = $this->jwtService->validateToken($token);
        
        if (!$userData) {
            return response()->json(['error' => 'Geçersiz token'], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $userData
        ]);
    }

    /**
     * Handle login error response
     */
    private function loginError($message)
    {
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        }

        return back()->withErrors(['email' => $message])->withInput(request()->only('email'));
    }
}
