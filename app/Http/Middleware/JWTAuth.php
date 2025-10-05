<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\JWTService;
use App\Models\AdminUser;

class JWTAuth
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Starting authentication check for URL: ' . $request->url());
        
        // Çerezden veya session'dan JWT token'ı al
        $cookieToken = $request->cookie('admin_jwt_token');
        $sessionToken = session('admin_jwt_token');
        $token = $cookieToken ?? $sessionToken;
        
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Token sources:', [
            'cookie_token' => $cookieToken ? 'exists (length: ' . strlen($cookieToken) . ')' : 'null',
            'session_token' => $sessionToken ? 'exists (length: ' . strlen($sessionToken) . ')' : 'null',
            'final_token' => $token ? 'exists (length: ' . strlen($token) . ')' : 'null',
            'request_method' => $request->method(),
            'request_path' => $request->path()
        ]);
        
        if (!$token) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - No token found in cookie or session');
            return $this->redirectToLogin($request);
        }

        // Token'ı doğrula ve kullanıcı bilgilerini al
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Validating token...');
        $userData = $this->jwtService->validateToken($token);
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Token validation result:', ['userData' => $userData]);
        
        if (!$userData) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - Token validation failed', ['token_preview' => substr($token, 0, 50) . '...']);
            return $this->redirectToLogin($request);
        }

        // Token süresi dolmuş mu kontrol et
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Checking token expiration...');
        if ($this->jwtService->isTokenExpired($token)) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - Token is expired');
            return $this->redirectToLogin($request);
        }

        // Kullanıcı ID'sini payload'dan al
        $adminUserId = $userData['id'] ?? null;
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Admin user ID from token:', ['admin_user_id' => $adminUserId]);
        
        if (!$adminUserId) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - No admin user ID in token payload');
            return $this->redirectToLogin($request);
        }

        // Admin kullanıcısını veritabanından al
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Finding admin user in database...');
        $adminUser = AdminUser::find($adminUserId);
        
        if (!$adminUser) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - Admin user not found in database', ['admin_user_id' => $adminUserId]);
            return $this->redirectToLogin($request);
        }
        
        if (!$adminUser->is_active) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - Admin user is not active', ['admin_user_id' => $adminUserId]);
            return $this->redirectToLogin($request);
        }

        // Rol kontrolü - payload'dan rol bilgisini al
        $userRole = $userData['role'] ?? null;
        \Illuminate\Support\Facades\Log::info('JWT Middleware - User role from token:', ['role' => $userRole]);
        
        if (!$userRole || !in_array($userRole, ['admin', 'editor', 'moderator'])) {
            \Illuminate\Support\Facades\Log::error('JWT Middleware - Invalid user role', ['role' => $userRole]);
            return $this->redirectToLogin($request);
        }

        // Admin kullanıcısını ve rol bilgisini request'e ekle
        $request->merge([
            'admin_user' => $adminUser,
            'admin_role' => $userRole
        ]);
        
        \Illuminate\Support\Facades\Log::info('JWT Middleware - Authentication successful, proceeding to next middleware');
        return $next($request);
    }

    /**
     * Login sayfasına yönlendir
     */
    private function redirectToLogin(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.',
                'redirect' => route('admin.login')
            ], 401);
        }

        return redirect()->route('admin.login')
            ->with('error', 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.');
    }
}
