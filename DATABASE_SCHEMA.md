# 🗄️ GREEN CASE - VERİTABANI ŞEMASI

## 📊 GENEL BAKIŞ

**Veritabanı Motoru:** MySQL 8.0+ (MSSQL uyumlu yapı)  
**Karakter Seti:** utf8mb4  
**Collation:** utf8mb4_unicode_ci  
**Tablo Sayısı:** 2 ana tablo (users, customers)  

---

## 📋 TABLOLAR DETAYLI AÇIKLAMA

### **1️⃣ users Tablosu**

**Amaç:** Sistem kullanıcılarını saklar (admin, manager, staff)

| Kolon Adı | Veri Tipi | Null? | Varsayılan | Key | Açıklama |
|-----------|-----------|-------|------------|-----|----------|
| id | BIGINT UNSIGNED | NO | AUTO | PK | Birincil anahtar |
| name | VARCHAR(255) | NO | - | - | Kullanıcı adı soyadı |
| email | VARCHAR(255) | NO | - | UNIQUE | E-posta adresi (login) |
| password | VARCHAR(255) | NO | - | - | Hash'lenmiş şifre (bcrypt) |
| role | VARCHAR(50) | NO | 'staff' | - | Kullanıcı rolü |
| email_verified_at | TIMESTAMP | YES | NULL | - | Email doğrulama zamanı |
| remember_token | VARCHAR(100) | YES | NULL | - | Beni hatırla token |
| created_at | TIMESTAMP | YES | CURRENT | - | Kayıt oluşturma tarihi |
| updated_at | TIMESTAMP | YES | CURRENT | - | Son güncelleme tarihi |
| deleted_at | TIMESTAMP | YES | NULL | - | Soft delete tarihi |

**Kısıtlamalar:**
- `email` → UNIQUE (Her email bir kez kullanılabilir)
- `role` → ENUM değerleri: 'admin', 'manager', 'staff'

**İndeksler:**
- PRIMARY KEY: id
- UNIQUE INDEX: email

**Örnek Veri:**
| ID | Name | Email | Role | Created At |
|----|------|-------|------|------------|
| 1 | Admin User | admin@greenholding.com | admin | 2025-10-04 13:11:09 |
| 2 | Manager User | manager@greenholding.com | manager | 2025-10-04 13:11:09 |
| 3 | Staff User | staff@greenholding.com | staff | 2025-10-04 13:11:09 |

---

### **2️⃣ customers Tablosu**

**Amaç:** Müşteri bilgilerini ve audit trail'i saklar

| Kolon Adı | Veri Tipi | Null? | Varsayılan | Key | Açıklama |
|-----------|-----------|-------|------------|-----|----------|
| id | BIGINT UNSIGNED | NO | AUTO | PK | Birincil anahtar |
| code | VARCHAR(50) | NO | - | UNIQUE | Müşteri kodu (CMP000001) |
| name | VARCHAR(255) | NO | - | INDEX | Müşteri/Firma adı |
| address | VARCHAR(255) | YES | NULL | - | Adres bilgisi |
| phone | VARCHAR(32) | YES | NULL | - | Telefon numarası |
| email | VARCHAR(255) | YES | NULL | INDEX | E-posta adresi |
| created_by | BIGINT UNSIGNED | YES | NULL | FK | Oluşturan kullanıcı ID |
| updated_by | BIGINT UNSIGNED | YES | NULL | FK | Son güncelleyen kullanıcı ID |
| deleted_by | BIGINT UNSIGNED | YES | NULL | FK | Silen kullanıcı ID |
| delete_reason | VARCHAR(255) | YES | NULL | - | Silme nedeni (audit) |
| created_at | TIMESTAMP | YES | CURRENT | - | Oluşturma tarihi |
| updated_at | TIMESTAMP | YES | CURRENT | - | Son güncelleme tarihi |
| deleted_at | TIMESTAMP | YES | NULL | - | Soft delete tarihi |

**Kısıtlamalar:**
- `code` → UNIQUE (Her müşteri kodu tekil)
- `created_by` → FOREIGN KEY users(id) ON DELETE NO ACTION
- `updated_by` → FOREIGN KEY users(id) ON DELETE NO ACTION
- `deleted_by` → FOREIGN KEY users(id) ON DELETE NO ACTION

**İndeksler:**
- PRIMARY KEY: id
- UNIQUE INDEX: code
- INDEX: name, email
- FOREIGN KEY: created_by, updated_by, deleted_by

**Örnek Veri:**
| ID | Code | Name | Created By | Created At | Updated By | Updated At | Deleted At |
|----|------|------|------------|------------|------------|------------|------------|
| 1 | CMP000001 | Gcode İleri Teknoloji | 1 (Admin) | 04.10.2025 13:11 | 2 (Manager) | 05.10.2025 14:00 | NULL |
| 2 | CMP000002 | Baturalp Sağlık Ltd. | 3 (Staff) | 04.10.2025 13:11 | 2 (Manager) | 05.10.2025 14:00 | NULL |

**Kayıt Sayısı:** 10,000 (seeder ile oluşturulmuş)

---

## 🔗 İLİŞKİLER (RELATIONSHIPS)

### **users → customers İlişkileri**

#### **1. Oluşturan İlişkisi (created_by)**
```
users.id (1) ──→ (*) customers.created_by
```
- **Tip:** One-to-Many
- **Açıklama:** Bir kullanıcı birden fazla müşteri oluşturabilir
- **Eloquent:** `$customer->creator` → User modeli döner

#### **2. Güncelleyen İlişkisi (updated_by)**
```
users.id (1) ──→ (*) customers.updated_by
```
- **Tip:** One-to-Many
- **Açıklama:** Bir kullanıcı birden fazla müşteriyi güncelleyebilir
- **Eloquent:** `$customer->updater` → User modeli döner

#### **3. Silen İlişkisi (deleted_by)**
```
users.id (1) ──→ (*) customers.deleted_by
```
- **Tip:** One-to-Many
- **Açıklama:** Bir kullanıcı birden fazla müşteriyi silebilir
- **Eloquent:** `$customer->deleter` → User modeli döner

---

## 🎯 ÖZEL ÖZELLİKLER

### **Soft Delete (Yumuşak Silme)**

**users Tablosu:**
```sql
deleted_at TIMESTAMP NULL
```
- Kullanıcı silindiğinde gerçekten silinmez
- `deleted_at` alanı güncellenir
- Geri yükleme mümkündür

**customers Tablosu:**
```sql
deleted_at TIMESTAMP NULL
deleted_by BIGINT UNSIGNED NULL (FK → users.id)
delete_reason VARCHAR(255) NULL
```
- Müşteri silindiğinde:
  - `deleted_at` → Silinme zamanı
  - `deleted_by` → Kimin sildiği
  - `delete_reason` → Neden silindi

### **Audit Trail (İzlenebilirlik)**

Her müşteri kaydı için:
- ✅ **created_by + created_at:** Kim oluşturdu, ne zaman?
- ✅ **updated_by + updated_at:** Kim güncelledi, ne zaman?
- ✅ **deleted_by + deleted_at + delete_reason:** Kim sildi, ne zaman, neden?

---

## 📈 VERİTABANI İSTATİSTİKLERİ

| Tablo | Kayıt Sayısı | Ortalama Satır Boyutu | Toplam Boyut (tahmini) |
|-------|--------------|----------------------|------------------------|
| users | 3 | 1 KB | 3 KB |
| customers | 10,000 | 2 KB | 20 MB |
| **TOPLAM** | **10,003** | - | **~20 MB** |

**İndeks Boyutu:** ~5 MB  
**Toplam Veritabanı Boyutu:** ~25 MB

---

## 🔐 GÜVENLİK YAPISI

### **Password Hashing:**
```php
// Laravel'in Hash facade'i (bcrypt)
'password' => Hash::make($plainPassword)
```

### **Foreign Key Actions:**
```sql
ON DELETE NO ACTION  -- Kullanıcı silinse bile müşteri kaydı korunur
ON UPDATE CASCADE    -- Kullanıcı ID güncellense ilişkiler güncellenir
```

### **Soft Delete Avantajları:**
- ✅ Veri kaybı olmaz
- ✅ Geri yükleme mümkün
- ✅ Audit trail korunur
- ✅ Compliance gereksinimlerini karşılar

---

## 🚀 PERFORMANS OPTİMİZASYONLARI

### **İndeksleme Stratejisi:**
```sql
-- En çok kullanılan sorgular için
INDEX customers_name_index (name)          -- Arama için
INDEX customers_email_index (email)        -- Email lookup için
UNIQUE customers_code_unique (code)        -- Kod bazlı erişim için

-- Foreign key'ler otomatik index'lenir
INDEX created_by, updated_by, deleted_by
```

### **Query Optimization:**
```php
// Eager Loading (N+1 Query Önleme)
Customer::with(['creator', 'updater', 'deleter'])->get();

// Batch Insert (10,000 kayıt için)
DB::table('customers')->insert($batchData);
```

---

## 📝 MİGRATION DOSYALARI

### **Çalıştırma Sırası:**
1. `2014_10_12_000000_create_users_table.php`
2. `2014_10_12_100000_create_password_reset_tokens_table.php`
3. `2019_08_19_000000_create_failed_jobs_table.php`
4. `2019_12_14_000001_create_personal_access_tokens_table.php`
5. `2025_10_03_190648_create_customers_table.php`
6. `2025_10_04_141902_add_deleted_by_to_customers_table.php`
7. `2025_10_04_144317_add_delete_reason_to_customers_table.php`
8. `2025_10_05_103550_add_deleted_at_to_users_table.php`

### **Komutlar:**
```bash
# Fresh migration + seed
php artisan migrate:fresh --seed

# Sadece migration
php artisan migrate

# Rollback
php artisan migrate:rollback

# Status kontrolü
php artisan migrate:status
```

---

## 🎯 VERİTABANI TASARIM PRENSİPLERİ

### **Uyumluluk:**
1. ✅ **Normalizasyon:** 3NF (Third Normal Form)
2. ✅ **ACID Compliance:** Transaction safety
3. ✅ **Referential Integrity:** Foreign key constraints
4. ✅ **MSSQL Uyumluluk:** NO ACTION constraints

### **Ölçeklenebilirlik:**
- ✅ Partitioning stratejisi uygulanabilir (deleted_at bazlı)
- ✅ Archiving stratejisi (eski kayıtları ayrı tabloya taşıma)
- ✅ Sharding mümkün (customer_code prefix bazlı)

---

**Bu dokümantasyonu README.md veya ayrı bir DATABASE_SCHEMA.md dosyasına ekleyebilirsiniz!** 📚
