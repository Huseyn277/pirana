Piran Dondurma Satış Saytı (Tədris Layihəsi) 🍦

Bu layihə dondurma satışı üçün nəzərdə tutulmuş sadə bir veb-tətbiqdir. Layihə həm backend proqramlaşdırma, həm də **kibertəhlükəsizlik (SQL Injection)** mövzularını öyrənmək və nümayiş etdirmək üçün hazırlanmışdır.

> ⚠️ **XƏBƏRDARLIQ:** Bu layihə qəsdən təhlükəsizlik boşluqları (SQL Injection) ilə təmin edilib. Real serverlərdə və ya istehsalatda (production) istifadəsi qətiyyən tövsiyə edilmir!

---

## 🛠 Texnologiyalar
* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP
* **Verilənlər Bazası:** MySQL (XAMPP / phpMyAdmin)
* **Server:** Apache

---

## 🚀 Quraşdırma (Setup)

Layihəni öz lokal mühitinizdə işə salmaq üçün:

1. **XAMPP** proqramını başladın (Apache və MySQL modullarını aktiv edin).
2. Bu repository-ni yükləyin və faylları `C:/xampp/htdocs/piran/` qovluğuna yerləşdirin.
3. `phpMyAdmin`-ə daxil olun və `piran` adında yeni bir baza yaradın.
4. Qovluqdakı `database.sql` faylını bazaya **Import** edin.
5. Brauzerdə `localhost/piran` ünvanına keçid edin.

---

## 🔒 Təhlükəsizlik Testləri (Cybersecurity)

Bu layihədə xüsusi olaraq aşağıdakı hissələrdə **SQL Injection** boşluğu buraxılmışdır:
- **Admin Panel Girişi:** Login və parol hissəsində SQL sorğuları filtrasiya olunmur.
- **Məqsəd:** `admin' --` kimi bypass üsullarını test etmək və bu boşluqların qarşısını almağı öyrənmək.

### Admin Giriş Məlumatları:
* **İstifadəçi adı:** `admin` (Və ya SQL injection ilə bypass edin)
* **Parol:** `admin123`

---

## 📂 Fayl Strukturu
* `/assets` - Şəkillər və dizayn faylları.
* `/admin` - Admin panel hissəsi.
* `config.php` - Verilənlər bazası bağlantısı.
* `database.sql` - Bazanın strukturu.

---
Sistemi SQL injection hucumunnan qorumaq ucun bu kodu "check_login.php" faylina elave elemliyik.

php
```
$sql = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user, $pass]);
$user = $stmt->fetch();
```
## 💳 Qeyd
Kart məlumatları bölməsi sadəcə demo xarakterlidir. Heç bir real ödəniş sistemi inteqrasiya olunmayıb və daxil edilən məlumatlar şifrələnməmiş şəkildə bazaya gedir (Tədris məqsədli)

