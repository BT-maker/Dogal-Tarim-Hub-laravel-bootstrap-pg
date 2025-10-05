# Blog (Laravel)

Laravel tabanlı bir blog uygulaması. Kategoriler, gönderiler ve kullanıcı yönetimi içerir; JWT ile kimlik doğrulama desteği vardır. Ön yüz varlıkları Vite ile derlenir, Blade görünümleriyle servis edilir.

## Özellikler

- JWT ile kimlik doğrulama (kullanıcı ve admin)
- Gönderi ve kategori yönetimi (migrasyonlar ve seed’ler ile örnek veriler)
- Admin paneli ve JWT tabanlı korumalı rotalar
- Varsayılan admin kullanıcı seed’i (isteğe bağlı çalıştırılır)
- Organik tema stil ve scriptleri (`public/css/organic-theme.css`, `public/js/organic-theme.js`)
- Vite ile asset derleme; Blade ile server-side render

## Gereksinimler

- PHP 8.x
- Composer 2.x
- MySQL/PostgreSQL (veya desteklenen herhangi bir veritabanı)
- Node.js 18+ ve npm

## Kurulum

1. Bağımlılıkları yükleyin:

   ```powershell
   composer install
   npm install
   ```

2. Ortam değişkenlerini oluşturun ve düzenleyin:

   ```powershell
   Copy-Item .env.example .env
   ```

   `.env` içinde veritabanı ve uygulama ayarlarını güncelleyin:

   - `APP_NAME`, `APP_ENV`, `APP_URL`
   - `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - JWT ayarları: `JWT_SECRET`, `JWT_TTL` vb. (`config/jwt.php` dosyasına bakın)

3. Uygulama anahtarını oluşturun:

   ```powershell
   php artisan key:generate
   ```

4. JWT secret anahtarını oluşturun (API için zorunlu):

   ```powershell
   php artisan jwt:secret
   ```

5. Veritabanını hazırlayın (migrasyon ve seed):

   ```powershell
   php artisan migrate
   php artisan db:seed
   # Admin kullanıcıyı eklemek için (DatabaseSeeder çağırmıyor):
   php artisan db:seed --class=AdminUserSeeder
   # Kategori örnek verileri (DatabaseSeeder zaten çağırır, isteğe bağlı):
   php artisan db:seed --class=CategorySeeder
   ```

6. Storage symlink (dosya yüklemeleri için önerilir):

   ```powershell
   php artisan storage:link
   ```

7. Geliştirme sunucusunu ve asset derlemeyi çalıştırın:

   ```powershell
   # PHP geliştirme sunucusu
   php artisan serve

   # Vite ile canlı derleme
   npm run dev
   ```

Uygulama varsayılan olarak `http://localhost:8000` adresinden hizmet verir.

## Admin Paneli

- Giriş sayfası: `http://localhost:8000/admin/login`
- Varsayılan admin (seed ile eklenir):
  - E-posta: `admin@yesilToprak.com`
  - Şifre: `admin123`
- Admin girişinde şifre istemcide SHA-256 ile hashlenir; sunucu tarafında bcrypt ile doğrulanır. Başarılı girişte JWT token cookie (`admin_jwt_token`) olarak saklanır ve korumalı admin rotalarına erişim sağlanır.

## API Uçları (Auth)

- `POST /api/auth/register` — Kayıt (şifreyi SHA-256 hash olarak gönderin; 64 karakter)
- `POST /api/auth/login` — Giriş (şifre SHA-256 hash; başarıyla girişte JWT token döner)
- `POST /api/auth/logout` — Çıkış (token invalidation)
- `POST /api/auth/refresh` — Token yenileme
- `GET /api/auth/profile` — Mevcut kullanıcı profili

Not: Kullanıcı API’sında şifre istemcide SHA-256 hashlenir, backend’de bcrypt ile karşılaştırılır.

## Kimlik Doğrulama ve JWT

- JWT yapılandırması `config/jwt.php` üzerinden yönetilir.
- `.env` içinde `JWT_SECRET` ve ilgili süre ayarlarını (örn. `JWT_TTL`) tanımlayın.
- Admin tarafında token üretimi/doğrulaması için `app/Services/JWTService.php` kullanılır; web admin rotaları `JWTAuth` middleware’i ile korunur.

## Proje Yapısı (Özet)

- `app/Http/Controllers` — HTTP controller’lar
- `app/Models` — Eloquent modelleri (`Post`, `Category`, `User`, `AdminUser`)
- `app/Services/JWTService.php` — JWT ile ilgili servis katmanı
- `database/migrations` — tablo şemaları
- `database/seeders` — örnek veri ve admin kullanıcı
- `resources/views` — Blade görünümleri
- `resources/js` ve `resources/css` — kaynak JS/CSS
- `public/` — derlenmiş varlıklar ve statik dosyalar
- `routes/web.php` ve `routes/api.php` — web ve API rotaları

## Testler

PHPUnit testlerini çalıştırmak için:

```powershell
php artisan test
# veya
vendor/bin/phpunit
```

## Vite ve Asset Yönetimi

- Geliştirme: `npm run dev`
- Üretim derlemesi: `npm run build`
- Vite yapılandırması: `vite.config.js`

## Sorun Giderme

- Veritabanı bağlantı hatalarında `.env` içindeki `DB_*` alanlarını kontrol edin.
- 401/403 hatalarında `JWT_SECRET` ve token süresini doğrulayın; admin için cookie `admin_jwt_token` mevcut ve geçerli olmalı.
- Yapılandırma değişikliklerinden sonra `php artisan config:clear` ve `php artisan cache:clear` çalıştırın.
- 404/rota sorunlarında `routes/web.php` ve `routes/api.php` dosyalarını gözden geçirin.
- Asset’ler yüklenmiyorsa `npm run dev` veya `npm run build` ve Blade içinde doğru yol kullanımını kontrol edin.

## Lisans

Bu proje için lisans bilgisi eklenmemiştir.