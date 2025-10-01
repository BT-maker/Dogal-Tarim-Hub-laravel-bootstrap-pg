<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:255',
            'contact_email' => 'required|email|max:255',
            'posts_per_page' => 'required|integer|min:1|max:50',
            'allow_comments' => 'boolean',
            'site_maintenance' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $settings = $request->only([
            'site_name',
            'site_description', 
            'site_keywords',
            'contact_email',
            'posts_per_page',
            'allow_comments',
            'site_maintenance'
        ]);

        // Cache'e ayarları kaydet
        Cache::forever('site_settings', $settings);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site ayarları başarıyla güncellendi.');
    }

    private function getSettings()
    {
        return Cache::get('site_settings', [
            'site_name' => 'Blog Sitesi',
            'site_description' => 'Modern ve kullanıcı dostu blog platformu',
            'site_keywords' => 'blog, yazı, makale, teknoloji',
            'contact_email' => 'admin@example.com',
            'posts_per_page' => 10,
            'allow_comments' => true,
            'site_maintenance' => false,
        ]);
    }
}
