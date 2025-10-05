# 🌿 Green Case – Full Stack Developer Case Study

Bu proje, **Green Holding** için geliştirilen bir Full Stack Developer case çalışmasıdır.  
Amaç, modern yazılım geliştirme standartlarına uygun bir **Laravel 12 + Vite + Bootstrap 5** mimarisi oluşturarak müşteri ve kullanıcı yönetim sistemini tasarlamaktır.

---

## 🚀 Teknolojiler

| Katman | Teknoloji |
|:--|:--|
| Backend | **Laravel 12 (PHP 8.3)** |
| Frontend | **Bootstrap 5.3**, **Vite**, **jQuery**, **SCSS** |
| Veritabanı | **MySQL / MariaDB** |
| DataTable | **Yajra Laravel DataTables** |
| Yetkilendirme | **RBAC Policy System** |
| Diğer | Soft Delete, Restore, Toast Notifications, Custom Middleware, DataTables, Laravel Sanctum|

---
[Proje Dökümantasyonu](docs/green-case.pdf)

[Veritabanı Diagramı](docs/database_diagram.pdf)


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


🧩 Proje Özellikleri
🧾 Müşteri Yönetimi

Müşteri ekleme, düzenleme, silme (soft delete)

Silinen kayıtları “Silinen Müşteriler” ekranından geri yükleme

DataTable üzerinden dinamik listeleme ve filtreleme

👤 Kullanıcı Yönetimi

Rol bazlı yetkilendirme (admin / user)

Soft Delete + Restore işlemleri

Toast Notification ile kullanıcı bildirimleri

♻️ Çöp Kutusu (Trash)

Müşteri ve kullanıcı kayıtları ayrı sekmelerde yönetilir

Kalıcı silme veya geri yükleme işlemleri yapılabilir

📊 Dashboard

Toplam aktif müşteri, silinmiş müşteri ve kullanıcı sayısı

Dinamik kartlar ile istatistik gösterimi



<p align="center">
  <img src="docs/dashboard.png" width="80%" alt="Dashboard">
</p>

🧱 Mimari Yapı
app/
 ├── Http/
 │   ├── Controllers/
 │   │   ├── CustomerController.php
 │   │   ├── UsersController.php
 │   │   └── TrashController.php
 │   ├── Middleware/
 │   └── Kernel.php
 ├── Models/
 ├── Policies/
 └── Providers/

resources/
 ├── js/
 │   ├── pages/
 │   └── utils/
 ├── scss/
 └── views/
     ├── customers/
     ├── trash/
     └── users/

🧠 Öne Çıkan Noktalar

Soft Delete & Restore: Laravel SoftDeletes özelliğiyle kayıtları güvenli biçimde siler.

Policy System: Yetkilendirmeler UserPolicy üzerinden dinamik olarak yönetilir.

DataTables: Gelişmiş filtreleme, sıralama ve responsive destek.

Toast Notifications: Her işlemde kullanıcıya görsel bildirim.

Responsive UI: Mobil cihazlar için optimize edilmiş yapı.

👨‍💻 Geliştirici

Mahmut Şeker
📍 Full Stack Developer

Bu proje Green Holding case çalışması kapsamında geliştirilmiştir.
Her hakkı saklıdır © 2025 – Mahmut Şeker