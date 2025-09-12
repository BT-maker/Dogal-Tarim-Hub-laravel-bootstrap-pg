# Basit Blog (Laravel 12 + PostgreSQL)

Bu proje, Laravel 12 ile geliştirilmiş basit bir blog uygulamasıdır. Yazı oluşturma/düzenleme/silme, yayında/taslak durumu ve Bootstrap 5 tabanlı arayüz içerir.

## Kurulum

### Gereksinimler
- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL 12+

### Adımlar
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

`.env` veritabanı ayarları (PostgreSQL):
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=blog_db
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Windows/PHP için gerekli eklentiler: `pdo_pgsql`, `pgsql` (php.ini içinde etkinleştirin ve CLI’yi/sunucuyu yeniden başlatın).

Migrasyonlar:
```bash
php artisan migrate
```

Geliştirme sunucusu ve Vite:
```bash
php artisan serve
npm run dev
```

Uygulama: `http://127.0.0.1:8000`

## Özellikler
- Yazı CRUD (create, read, update, delete)
- Yayında/Taslak ve yayın tarihi
- Başlıktan otomatik slug üretimi
- Bootstrap 5 tabanlı arayüz

## Önemli Dosyalar
- Controller: `app/Http/Controllers/PostController.php`
- Model: `app/Models/Post.php`
- Migration: `database/migrations/*create_posts_table.php`
- Görünümler:
  - `resources/views/layouts/app.blade.php`
  - `resources/views/posts/index.blade.php`
  - `resources/views/posts/show.blade.php`
  - `resources/views/admin/posts/index.blade.php`
  - `resources/views/admin/posts/create.blade.php`
  - `resources/views/admin/posts/edit.blade.php`

## Rotalar (routes/web.php)
```
GET  /                       → PostController@index (liste)
GET  /post/{post:slug}       → PostController@show (detay)
GET  /admin/posts            → Admin liste
GET  /admin/posts/create     → Yeni yazı formu
POST /admin/posts            → Kaydet
GET  /admin/posts/{post}/edit→ Düzenle
PUT  /admin/posts/{post}     → Güncelle
DELETE /admin/posts/{post}   → Sil
```

## Sorun Giderme
- `could not find driver (pgsql)`: `pdo_pgsql` ve `pgsql` eklentilerini etkinleştirin, `php --ini` ile doğru php.ini’yi doğrulayın.
- IDE uyarıları (protected visibility): Request alanlarına `input()`/`boolean()` ile erişin (örn. `$request->input('title')`).

## Lisans
MIT
# laravel-blog-bootstrap-pg
