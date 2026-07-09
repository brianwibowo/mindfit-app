# MindFit - Smart Health & Physical Coaching Platform

MindFit adalah sebuah platform manajemen kesehatan dan kepelatihan fisik (*coaching*) terpadu berbasis web yang menghubungkan Klien, Pelatih Fisik (*Coach* / *Personal Trainer*), Ahli Gizi (*Nutritionist*), dan Admin secara efisien. Platform ini memfasilitasi pemantauan perkembangan fisik harian klien, konsultasi nutrisi, penjadwalan sesi kepelatihan, pembayaran paket, serta analisis kesehatan cerdas berbasis kecerdasan buatan (AI).

---

## 🚀 Fitur Utama

### 1. Peran Pengguna (Multi-Role)
*   **Admin**: Dashboard finansial (statistik pendapatan & pengeluaran harian/bulanan/tahunan), persetujuan invoice pembayaran paket klien, manajemen paket latihan, pembuatan kode diskon/promo, serta monitoring penugasan klien ke pelatih.
*   **Coach & Nutritionist**: Manajemen penugasan klien, penjadwalan/pembaruan sesi latihan, pembaruan log perkembangan fisik klien, serta riwayat interaksi.
*   **Client**: Pencatatan metrik fisik harian, unggah foto progres fisik, monitoring riwayat sesi kepelatihan aktif, transaksi pembelian paket, dan pengajuan konsultasi AI.

### 2. Fitur Premium
*   **AI Health Analysis**: Analisis pola makan dan rekomendasi latihan fisik menggunakan AI terintegrasi.
*   **Flexible Scheduling**: Penjadwalan interaktif antara klien dan pelatih.
*   **Finance & Reporting**: Pencatatan pengeluaran operasional admin dan export data pemasukan/pengeluaran dalam format PDF & Excel.

---

## 🛠️ Tech Stack

*   **Backend**: Laravel 12.x (PHP 8.4)
*   **Database**: MySQL
*   **Frontend Layout**: HTML5 / Blade Template / Bootstrap 5 / Vanilla CSS
*   **Admin Template**: KaiAdmin Dashboard Template
*   **Build Tools**: Vite / npm
*   **Deployment**: GitHub Actions SSH-Deploy (CI/CD)

---

## 💻 Cara Menjalankan Project di Lokal

### Prasyarat
Pastikan Anda sudah menginstal:
*   PHP >= 8.4
*   Composer
*   Node.js & npm
*   MySQL

### Langkah Instalasi
1.  **Clone Repositori**:
    ```bash
    git clone https://github.com/brianwibowo/mindfit-app.git
    cd mindfit-app
    ```
2.  **Pasang Dependensi PHP**:
    ```bash
    composer install
    ```
3.  **Pasang Dependensi Javascript**:
    ```bash
    npm install
    ```
4.  **Konfigurasi Environment**:
    Salin file `.env.example` menjadi `.env` lalu sesuaikan kredensial database lokal Anda:
    ```bash
    cp .env.example .env
    ```
5.  **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```
6.  **Jalankan Migrasi & Seed Database**:
    ```bash
    php artisan migrate --seed
    ```
7.  **Compile Assets (Vite)**:
    ```bash
    npm run dev
    ```
8.  **Jalankan Server Lokal**:
    ```bash
    php artisan serve
    ```
    Akses web di browser melalui `http://127.0.0.1:8000`.

---

## 🌐 Deployment (CI/CD)

Aplikasi ini menggunakan **GitHub Actions** (`.github/workflows/deploy.yml`) untuk proses deployment otomatis ke server hosting Rumahweb (`https://app.mindfit.id`):
*   Setiap kali melakukan `git push` ke branch `main`, workflow akan otomatis meng-compile aset Vite.
*   Workflow akan terhubung via SSH ke server hosting untuk menarik kode terbaru (`git pull`), menginstal dependensi (`composer install`), menjalankan migrasi database (`php artisan migrate`), dan mengunggah aset terkompilasi (`public/build`) ke cPanel via SCP.

> [!IMPORTANT]
> Jangan pernah memasukkan file `.env` ke dalam tracking Git (`gitignore` sudah dikonfigurasi). File `.env` di hosting dikelola secara terpisah langsung di direktori server cPanel demi alasan keamanan kredensial produksi.
