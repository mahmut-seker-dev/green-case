# 🌿 Green Case – Full Stack Developer Case Study

Bu proje, **Green Holding** için geliştirilen bir Full Stack Developer case çalışmasıdır.  
Amaç, modern yazılım geliştirme standartlarına uygun bir **Laravel 10 + Vite + Bootstrap 5** mimarisi oluşturarak müşteri ve kullanıcı yönetim sistemini tasarlamaktır.

---

## 🚀 Teknolojiler

| Katman | Teknoloji |
|:--|:--|
| Backend | **Laravel 12+ (PHP 8.2)** |
| Frontend | **Bootstrap 5.3**, **Vite**, **jQuery**, **SCSS** |
| Veritabanı | **MySQL / MariaDB** |
| DataTable | **Yajra Laravel DataTables** |
| Yetkilendirme | **RBAC Policy System** |
| Diğer | Soft Delete, Restore, Toast Notifications, Custom Middleware |

---

## ⚙️ Kurulum Adımları

```bash
# 1. Projeyi klonla
git clone https://github.com/mahmut-seker-dev/green-case.git
cd green-case

# 2. Laravel bağımlılıklarını yükle
composer install

# 3. Node bağımlılıklarını yükle
npm install

# 4. .env dosyasını oluştur
cp .env.example .env

# 5. Uygulama anahtarını üret
php artisan key:generate

# 6. Veritabanı bağlantısını .env dosyasına gir

# 7. Migration + Seeder çalıştır
php artisan migrate --seed

# 8. Geliştirme sunucusunu başlat
npm run dev
php artisan serve
