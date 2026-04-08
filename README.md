PIRAN Dondurma Şirkəti
Veb Tehlukesizlik Zeiflikler Reportu  
Mövzu: SQL Injection zəifliyinin tədqiqi və həlli yolları  

Müəllim: Həsənli Xatirə 
Hazırladı: Abbasov Hüseyn 
Qrup: 693.24
Tarix:  7 Aprel 2026
                                                                                                                                                          


      1. GİRİŞ
Müasir veb-tətbiqlərin ən böyük risklərindən biri verilənlər bazası ilə proqram arasındakı qeyri-kafi təhlükəsizlik baryerləridir. Bu hesabatda "PIRAN IceCream" adlı onlayn mağaza skripti üzərində aparılmış analizlər təqdim olunur. Layihənin əsas məqsədi istifadəçi məlumatlarının toplanması, saxlanılması və bu proses zamanı ortaya çıxan kiber-təhlükəsizlik risklərinin (xüsusilə SQL Injection) müəyyən edilməsidir.

---

2. LAYİHƏ HAQQINDA ÜMUMİ MƏLUMAT
Sistem kiçik bir müəssisənin satış ehtiyaclarını qarşılamaq üçün nəzərdə tutulub. Layihə aşağıdakı əsas komponentlərdən ibarətdir:
* **İstifadəçi İnterfeysi (Front-end):** Müştərilərin məhsulları seçdiyi və ödəmə məlumatlarını daxil etdiyi interaktiv hissə (`lab2.html`, `lab2.js`).
* **Server Məntiqi (Back-end):** PHP dilində yazılmış, məlumatları emal edən və bazaya yönləndirən skriptlər (`save_order.php`, `check_login.php`).
* **Məlumat Bazası (Database):** "rubik_shop" adlı MySQL bazası, burada sifarişlər və admin istifadəçiləri saxlanılır.

---

3. LAYİHƏNİN KOD STRUKTURU VƏ İŞLƏMƏ PRİNSİPİ
Kodun strukturu modul xarakterlidir:
* **`db.php`:** `mysqli` sinfi vasitəsilə verilənlər bazasına qoşulmanı təmin edir. Bütün digər PHP faylları bu faylı `include` edərək bazaya çıxış əldə edir.
* **`lab2.js`:** Müştəri tərəfində (browser) işləyir. Səbət məntiqini idarə edir və `fetch()` API-dən istifadə edərək məlumatları asinxron şəkildə (səhifə yenilənmədən) serverə ötürür.
* **`admin.php`:** Bazadakı `orders` cədvəlindən məlumatları çəkir və cədvəl formatında çıxarır. Burada `htmlspecialchars()` funksiyasından istifadə edilməsi XSS (Cross-Site Scripting) hücumlarının qarşısını almağa xidmət edir.

---

4. SQL INJECTION ZƏİFLİYİ VƏ TƏHLÜKƏ ANALİZİ
Layihənin ən kritik hissəsi `check_login.php` faylındakı giriş (login) sistemidir.

4.1. Zəifliyin İzahı

Kodda istifadəçidən alınan `$user` və `$pass` dəyişənləri heç bir filtrasiyadan keçmədən SQL sorğusuna daxil edilir:
```php
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
```
Bu proqramlaşdırma xətası hackerə imkan verir ki, SQL sintaksisini manipulyasiya etsin.

4.2. Hücum Mexanizmi

Hacker login sahəsinə `' OR 1=1 -- ` daxil etdikdə, server tərəfində icra olunan sorğu buna çevrilir:
`SELECT * FROM users WHERE username = '' OR 1=1 -- ' AND password = '...'`
Burada `--` simvolu SQL-də şərh (comment) mənasına gəlir və sorğunun geri qalanını (şifrə yoxlanışını) ləğv edir. `1=1` həmişə doğru olduğu üçün sistem hacker-i şifrəsiz içəri buraxır.

4.3. Risklərin Qiymətləndirilməsi

Bu zəiflik nəticəsində:
1.  **Konfidensiallıq pozulur:** Müştərilərin tam kart nömrələri, CVV kodları və şəxsi məlumatları hackerin əlinə keçir.
2.  **Məlumat tamlığı itir:** Hacker bazadakı sifarişləri silə və ya məbləğləri dəyişdirə bilər.

---

5. HƏLL YOLLARI VƏ TÖVSİYƏLƏR
Təhlükəsizliyi təmin etmək üçün aşağıdakı addımların atılması mütləqdir:

5.1. Prepared Statements (Tövsiyə olunan)

Dəyişənləri birbaşa sorğuya yazmaq əvəzinə, "hazır qəliblərdən" istifadə edilməlidir:

```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
```
Bu üsul SQL Injection hücumunu 100% zərərsizləşdirir.

5.2. Məlumatların Şifrələnməsi (Hashing)

Bazada şifrələr "12345" kimi deyil, `password_hash()` funksiyası ilə hash şəklində saxlanılmalıdır. Beləliklə, baza oğurlansa belə, hacker şifrələri oxuya bilməz.

5.3. Kart Məlumatlarının Qorunması

Saytda kart nömrələrinin tam saxlanılması təhlükəlidir. Yalnız son 4 rəqəmin saxlanılması və CVV kodunun heç vaxt bazaya yazılmaması (PCI DSS standartı) tövsiyə olunur.

---

6. NƏTİCƏ
Aparılan analiz göstərir ki, "PIRAN IceCream" sistemi funksional olaraq tam işlək olsa da, ciddi kiber-təhlükəsizlik boşluqlarına malikdir. Bu boşluqlar tətbiq edilən sadə kod dəyişiklikləri (Prepared Statements) vasitəsilə aradan qaldırıla bilər. Proqram təminatı hazırlanan zaman "Security by Design" (Layihələndirmədən Təhlükəsizlik) prinsipi əsas götürülməlidir.

---

#💳 Qeyd
Kart məlumatları bölməsi sadəcə demo xarakterlidir. Heç bir real ödəniş sistemi inteqrasiya olunmayıb və daxil edilən məlumatlar şifrələnməmiş şəkildə bazaya gedir (Tədris məqsədli).
