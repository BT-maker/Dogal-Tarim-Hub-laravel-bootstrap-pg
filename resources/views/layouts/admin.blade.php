<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Yeşil Toprak')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body class="min-h-screen bg-neutral-50 font-[Inter]">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-emerald-700 to-emerald-600 text-white shadow-xl transform transition-transform duration-200 md:translate-x-0 -translate-x-full z-50">
            <div class="px-4 py-5 border-b border-white/10 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=120&h=120&fit=crop&crop=faces" alt="Logo" class="h-8 w-8 rounded-full ring-2 ring-white/40">
                    <span class="text-lg font-semibold tracking-wide group-hover:text-emerald-200">Yeşil Toprak</span>
                </a>
                <button onclick="toggleSidebar()" class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 6h16.5m-16.5 6h16.5" />
                    </svg>
                </button>
            </div>

            <nav class="px-3 py-4 space-y-6 overflow-y-auto">
                <!-- Dashboard -->
                <div>
                    <div class="px-3 text-xs uppercase tracking-wider text-white/60 font-semibold">Dashboard</div>
                    <a href="{{ route('admin.dashboard') }}" class="mt-2 flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>
                        <span class="font-medium">Ana Sayfa</span>
                    </a>
                </div>

                <!-- İçerik Yönetimi -->
                <div>
                    <div class="px-3 text-xs uppercase tracking-wider text-white/60 font-semibold">İçerik Yönetimi</div>
                    <a href="{{ route('admin.posts.index') }}" class="mt-2 flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.posts.*') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.651-1.651a1.875 1.875 0 112.652 2.652l-8.954 8.954a4.5 4.5 0 01-1.897 1.13L7.5 16.5l.978-2.814a4.5 4.5 0 011.13-1.897l7.254-7.302z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 7.5L16.5 4.5"/></svg>
                        <span class="font-medium">Yazılar</span>
                        <span class="ml-auto text-emerald-700 bg-emerald-100 text-xs font-semibold px-2 py-0.5 rounded-full">{{ \App\Models\Post::count() }}</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.categories.*') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7.5h18M3 12h18M3 16.5h18"/></svg>
                        <span class="font-medium">Kategoriler</span>
                        <span class="ml-auto text-emerald-700 bg-emerald-100 text-xs font-semibold px-2 py-0.5 rounded-full">{{ \App\Models\Category::count() }}</span>
                    </a>
                </div>

                <!-- Kullanıcı Yönetimi -->
                <div>
                    <div class="px-3 text-xs uppercase tracking-wider text-white/60 font-semibold">Kullanıcı Yönetimi</div>
                    <a href="{{ route('admin.users.index') }}" class="mt-2 flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a3.001 3.001 0 00-6 0M12 7.5a3 3 0 110 6 3 3 0 010-6z"/></svg>
                        <span class="font-medium">Kullanıcılar</span>
                        <span class="ml-auto text-emerald-700 bg-emerald-100 text-xs font-semibold px-2 py-0.5 rounded-full">{{ \App\Models\User::count() }}</span>
                    </a>
                </div>

                <!-- Ayarlar -->
                <div>
                    <div class="px-3 text-xs uppercase tracking-wider text-white/60 font-semibold">Ayarlar</div>
                    <a href="{{ route('admin.settings.index') }}" class="mt-2 flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.settings.*') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.25 2.25l1.5 0M3.75 12l0 0m16.5 0l0 0M12 20.25l0 0"/></svg>
                        <span class="font-medium">Site Ayarları</span>
                    </a>
                </div>

                <!-- Hızlı İşlemler -->
                <div>
                    <div class="px-3 text-xs uppercase tracking-wider text-white/60 font-semibold">Hızlı İşlemler</div>
                    <a href="{{ route('admin.posts.create') }}" class="mt-2 flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span class="font-medium">Yeni Yazı</span>
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="font-medium">Siteyi Görüntüle</span>
                    </a>
                </div>

                <!-- Hesap -->
                <div>
                    <div class="px-3 text-xs uppercase tracking-wider text-white/60 font-semibold">Hesap</div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 text-white/90">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3"/></svg>
                            <span class="font-medium">Çıkış Yap</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 hidden md:hidden" onclick="closeSidebar()"></div>

        <!-- Main -->
        <main class="flex-1 md:ml-72">
            <!-- Topbar -->
            <div class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-neutral-200">
                <div class="max-w-screen-2xl mx-auto px-4 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg hover:bg-neutral-100" onclick="openSidebar()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 6h16.5m-16.5 6h16.5" />
                            </svg>
                        </button>
                        <h1 class="text-lg md:text-xl font-semibold text-emerald-800">@yield('page-title', 'Admin Panel')</h1>
                    </div>
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center gap-3 px-3 py-1.5 rounded-lg hover:bg-neutral-100">
                            <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=64&h=64&fit=crop&crop=faces" alt="Admin" class="h-8 w-8 rounded-full">
                            <span class="hidden sm:inline text-sm font-medium text-neutral-700">Admin</span>
                            <svg class="w-4 h-4 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white border border-neutral-200 rounded-lg shadow-lg hidden">
                            <a href="{{ route('admin.profile.show') }}" class="block px-3 py-2 text-sm hover:bg-neutral-50">Profil</a>
                            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 text-sm hover:bg-neutral-50">Ayarlar</a>
                            <div class="my-1 border-t border-neutral-200"></div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm hover:bg-neutral-50">Çıkış Yap</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Decorative banner image -->
                <div class="h-20 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1467043153537-b4f33d5b088c?q=80&w=1200&fit=crop');"></div>
            </div>

            <!-- Content -->
            <div class="max-w-screen-2xl mx-auto px-4 py-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-800 px-4 py-3">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-800 px-4 py-3">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar(){
            const el = document.getElementById('adminSidebar');
            el.classList.toggle('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.toggle('hidden');
        }
        function openSidebar(){
            const el = document.getElementById('adminSidebar');
            el.classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }
        function closeSidebar(){
            const el = document.getElementById('adminSidebar');
            el.classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
        document.addEventListener('click', (e)=>{
            const btn = document.getElementById('userMenuBtn');
            const menu = document.getElementById('userMenu');
            if(btn.contains(e.target)){
                menu.classList.toggle('hidden');
            } else if(!menu.contains(e.target)){
                menu.classList.add('hidden');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>