# 🏋️‍♂️ PeakPerform - Profesyonel Sporcu Takviyeleri E-Ticaret Platformu

PeakPerform, sporcuların ve fitness tutkunlarının ihtiyaç duyduğu besin takviyelerini (Protein Tozu, Kreatin, Pre-Workout vb.) inceleyebileceği, sepetine ekleyip sipariş verebileceği ve dinamik olarak değerlendirebileceği, modern tasarıma sahip tam donanımlı bir Laravel e-ticaret web uygulamasıdır.

## 🚀 Öne Çıkan Özellikler

* **Premium Koyu Tema (Dark Mode):** Spor ve fitness kültürünün agresif, odaklanmış ve modern yapısına uygun, göz yormayan, tamamen Tailwind CSS ile örülmüş estetik arayüz.
* **Dinamik Sepet Yönetimi:** Ürünleri tek tıkla sepete ekleme, sepet sayfasında anlık olarak miktar artırma/azaltma (+/-) ve miktar 0'a düştüğünde ya da "Sil" butonuna basıldığında otomatik sepet güncelleme mekanizması.
* **Gelişmiş Rol ve Güvenlik Sistemi (is_admin):** Sistemde "Patron (Yönetici)" ve "Müşteri" ayrımı mevcuttur. Kritik butonlar (Ürün ekle, Düzenle, Sil, Yönetim Paneli, Çöp Kutusu) yalnızca patron yetkisine sahip hesaplara görünür ve backend seviyesinde korunur.
* **Gelişmiş Yönetici Paneli (Admin Dashboard):** Toplam ciro, toplam sipariş sayısı ve aktif ürün çeşitliliğini anlık hesaplayan istatistik kartları ve son gelen müşteri siparişlerinin detaylı takibi.
* **Yorum ve Yıldızlı Puanlama Sistemi:** Müşterilerin satın aldıkları takviyelere 1-5 arası yıldız vererek detaylı metin yorumları bırakabileceği etkileşimli alan.
* **Gelişmiş Ürün Detay & Besin Değerleri:** Takviyelerin gramaj, aroma ve servis başına düşen besin makrolarını (Kreatin miktarı, protein oranı vb.) listeleyen şık detay tabloları.
* **Güvenli Silme (Soft Deletes):** Vitrinden silinen ürünler veritabanından tamamen yok olmaz; "Çöp Kutusu" alanına taşınır. Patron, silinen ürünleri tek tıkla vitrine geri getirebilir veya kalıcı olarak silebilir.

## 🛠️ Kullanılan Teknolojiler

* **Backend:** PHP 8.x & Laravel 10.x / 11.x (MVC Mimarisi)
* **Frontend:** Blade Template Engine & Tailwind CSS (Responsive Tasarım)
* **Veritabanı:** MySQL / MariaDB (Eloquent ORM, Migrations & Relationships)
* **Oturum Yönetimi:** Laravel Session Driver (Sepet İşlemleri İçin)

## 🔧 Kurulum ve Çalıştırma

Projeyi yerel bilgisayarınızda çalıştırmak için aşağıdaki adımları takip edebilirsiniz:

1.  **Projeyi Klonlayın:**
    ```bash
    git clone [https://github.com/Mockingbird61/peakperform.git](https://github.com/Mockingbird61/peakperform.git)
    cd peakperform
    ```

2.  **Bağımlılıkları Yükleyin:**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Çevre Dosyasını Ayarlayın:**
    `.env.example` dosyasının adını `.env` olarak değiştirin ve veritabanı bilgilerinizi girin.

4.  **Veritabanı ve Anahtar Kurulumu:**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  **Sunucuyu Başlatın:**
    ```bash
    php artisan serve
    ```