# 🌐 BuilderHub — Platform Kolaborasi UMKM & Programmer Indonesia

> **BuilderHub** adalah platform digital modern yang dirancang khusus untuk menghubungkan Pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) dengan Programmer profesional di seluruh Indonesia. Platform ini memfasilitasi pembuatan sistem, situs web, dan aplikasi secara terarah dengan transparansi harga dan manajemen estimasi pengerjaan.

---

## 🚀 Fitur Utama & Pembagian Peran (Roles)

BuilderHub mengimplementasikan sistem multi-role yang terintegrasi penuh:

### 1. 💼 UMKM (Usaha Mikro, Kecil, Menengah)
* **Posting Project Tanpa Harga**: UMKM dapat memposting deskripsi kebutuhan project tanpa mencantumkan harga/budget di awal (estimasi budget diserahkan kepada ahlinya).
* **Fitur Chat & Negosiasi**: Berdiskusi langsung mengenai detail teknis dan negosiasi harga sebelum menyetujui penawaran.
* **Persetujuan Penawaran & Pembayaran Rekber**: Memilih programmer terbaik, menyetujui penawaran, dan menyetorkan dana 100% ke Rekber (Held by Admin) agar pengerjaan dapat dimulai secara aman.
* **Tinjauan & Penyelesaian**: Memantau progress pengerjaan. Tombol **"Selesaikan"** akan otomatis muncul setelah progress mencapai 100%. UMKM mengkliknya setelah meninjau berkas untuk mencairkan bagi hasil dana.

### 2. 💻 Programmer
* **Penawaran Biaya & Waktu**: Mengajukan penawaran harga (bid) dan waktu pengerjaan secara mandiri pada project yang dibuka.
* **Validasi Sisa Hari (Deadline Constraint)**: Durasi pengerjaan yang diajukan programmer **tidak boleh melebihi sisa waktu menuju deadline** yang diinginkan UMKM.
* **Ubah Penawaran (Re-Estimation)**: Jika UMKM merasa penawaran terlalu mahal, programmer dapat mengubah estimasi harga dan waktu langsung dari dashboard mereka selama statusnya masih menunggu persetujuan.
* **Pembaruan Progress & Deliverables**: Memperbarui progress pengerjaan secara bertahap hingga 100% dan mengunggah hasil pekerjaan (berkas ZIP, repository GitHub, dan tautan hosting).
* **Sistem Course & Portofolio**: Membuat materi pembelajaran/kursus untuk dibagikan kepada Pelajar dan mengelola portofolio profesional untuk meningkatkan kredibilitas.

### 3. 🎓 Pelajar (Student)
* **Belajar dari Ahlinya**: Membeli dan mengakses video pembelajaran berkualitas tinggi yang dibuat oleh Top Programmer.
* **Sertifikat Digital**: Mendapatkan sertifikat kelulusan setelah menyelesaikan seluruh konten pembelajaran kursus.

### 4. ⚙️ Administrator
* **Validasi & Moderasi Project**: Memeriksa pengajuan project baru dari UMKM untuk disetujui (ACC & Publikasikan) atau ditolak (Tolak & Hapus) demi menjaga kualitas platform.
* **Manajemen Pengguna & Verifikasi**: Mengelola status verifikasi programmer, portofolio, sertifikat, dan kursus secara keseluruhan.
* **Manajemen Kas & Revenue Platform**: Memantau pendapatan total platform yang mencakup dana project berjalan (100% budget Rekber), komisi resmi project selesai (80%), serta komisi kursus berbayar (20%).

---

## 💰 Skema Keuangan & Pembagian Pendapatan (Revenue Split)

Platform BuilderHub menerapkan transparansi penuh pada setiap transaksi:

| Kategori Transaksi | Programmer (Mitra) | Platform (BuilderHub) | Alur Rekber (Escrow) |
| :--- | :---: | :---: | :--- |
| **Project UMKM** | **20%** | **80%** | Dana disimpan 100% di Rekber Admin saat project **berjalan**, lalu dibagi hasil 20/80 saat UMKM mengonfirmasi **selesai**. |
| **Course (Kelas)** | **80%** | **20%** | Pembelian course berbayar langsung dibagi hasil: 80% ke pemateri dan 20% komisi platform. |

---

## 🛠️ Spesifikasi Teknologi (Tech Stack)

* **Backend Framework**: [Laravel 11](https://laravel.com/) (PHP >= 8.2)
* **Frontend**: Vanilla CSS + Responsive Design + Blade Templating System
* **Database**: MySQL / MariaDB
* **Keamanan**: CSRF Protection, Password Hashing (Bcrypt), Middleware Role-based Access Control

---

## 💻 Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan project BuilderHub di komputer lokal Anda:

### 1. Persiapan Environment
Pastikan Anda sudah menginstal **XAMPP (PHP >= 8.2)**, **Composer**, dan **Node.js** di komputer Anda.

### 2. Duplikasi Berkas Environment
Masuk ke direktori `builderhub-app` dan buat salinan file `.env`:
```bash
cd builderhub-app
cp .env.example .env
```

### 3. Instalasi Dependencies
Instal semua package PHP yang dibutuhkan:
```bash
composer install
```

### 4. Konfigurasi Database
1. Aktifkan modul **Apache** dan **MySQL** di Control Panel XAMPP Anda.
2. Buka phpMyAdmin (`http://localhost/phpmyadmin`) dan buat database baru dengan nama `builderhub_db`.
3. Buka file `.env` di folder `builderhub-app` dan sesuaikan konfigurasinya:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=builderhub_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 5. Generate Application Key
Jalankan perintah berikut untuk mengamankan enkripsi sesi:
```bash
php artisan key:generate
```

### 6. Migrasi & Seeder Database
Jalankan migrasi tabel beserta data demo/seeder awal (akun uji coba):
```bash
php artisan migrate --seed
```

### 7. Jalankan Server Lokal
Jalankan server pengembangan Laravel:
```bash
php artisan serve
```
Aplikasi sekarang dapat diakses melalui browser di alamat: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔑 Akun Demo untuk Uji Coba

Gunakan kredensial berikut untuk menguji masing-masing role (semua password adalah `password`):

| Role | Email | Password | Kegunaan |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@builderhub.id` | `password` | Menyetujui/menolak project baru dari UMKM |
| **UMKM** | `rifqiumkm@gmail.com` | `password` | Memposting project baru & negosiasi harga |
| **Programmer** | `rifqiprogrammer@gmail.com` | `password` | Mengajukan bids, memodifikasi tawaran, & chat |
| **Pelajar** | `rifqipelajar@gmail.com` | `password` | Mengikuti kursus & belajar |

---

## 🤝 Panduan Kolaborasi Tim

Untuk menjaga kualitas kode selama proses pengembangan, harap perhatikan aturan berikut:
1. **Batasan Estimasi Hari**: Saat membuat fitur penawaran baru, pastikan untuk menggunakan sisa hari deadline (`$project->deadline->diffInDays(now())`) sebagai batas maksimum (`max`).
2. **Pesan Sukses/Gagal**: Hindari penggunaan emoji ganda (seperti `✅ ✅`) pada return message controller karena sistem layout global sudah menyaring dan menambahkan emoji secara otomatis.
3. **Pemisahan Navigasi**: Sesuai dengan desain alur pengguna, pastikan menu **Beranda** (Home landing page) disembunyikan dari navigasi atas apabila pengguna sudah login (masuk) ke dashboard role mereka masing-masing.

---
*Dibuat dengan 💜 untuk kemajuan UMKM dan Programmer Indonesia.*
