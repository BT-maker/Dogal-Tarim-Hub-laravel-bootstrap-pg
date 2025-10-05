<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function show(Request $request)
    {
        $admin = $request->admin_user;
        return view('admin.profile.show', compact('admin'));
    }

    public function edit(Request $request)
    {
        $admin = $request->admin_user;
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        /** @var AdminUser $admin */
        $admin = $request->admin_user;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admin_users')->ignore($admin->id)
            ],
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Şifre değişikliği varsa mevcut şifreyi kontrol et
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Yeni şifre belirlemek için mevcut şifrenizi girmelisiniz.'])
                    ->withInput();
            }

            if (!Hash::check($request->current_password, $admin->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Mevcut şifre yanlış.'])
                    ->withInput();
            }
        }

        // Profil bilgilerini güncelle
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Şifre varsa güncelle
        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }
}
