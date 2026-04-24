# 🏸 E-Badminton: Smart Arena Management System

Selamat datang di *repository* resmi proyek **E-Badminton**. 👋

**E-Badminton** adalah platform berbasis web yang kami bangun untuk mendigitalisasi proses penyewaan lapangan bulu tangkis. Kami membuat sistem ini karena melihat masih banyak pengelola lapangan yang kewalahan mencatat jadwal di buku tulis, yang sering mengakibatkan jadwal bentrok (*double booking*) dan laporan keuangan yang berantakan.

Dengan E-Badminton, mulai dari pemesanan jadwal, kelola stok alat, hingga rekap pendapatan bulanan, semuanya jadi serba otomatis dan mudah dipantau! 🚀

---

## 📑 Daftar Isi
1. [Kenalan Sama Tim Kita](#-kenalan-sama-tim-kita)
2. [Hak Akses & Fitur Utama](#-hak-akses--fitur-utama)
3. [Alat Tempur (Teknologi)](#-alat-tempur-teknologi)
4. [Cara Install di Laptop Kamu](#-cara-install-di-laptop-kamu)
5. [Tangkapan Layar (Screenshot)](#-tangkapan-layar-screenshot)
6. [Progres Pengembangan](#-progres-pengembangan)

---

## 👨‍💻 Kenalan Sama Tim Kita

Proyek ini adalah hasil kolaborasi 4 mahasiswa Sistem Informasi. Berikut adalah tim di balik pengembangan E-Badminton:

| Nama & NIM | Spesialisasi & Peran Utama |
| :--- | :--- |
| **Rahmat Tanjung** <br> `[2330407021]` | **Fullstack Developer** <br> Mengatur arsitektur sistem, *routing* Laravel, dan meracik logika grafik Chart.js di Dashboard. |
| **Andre** <br> `[2330407004]` | **Database Engineer** <br> Merancang ERD, membuat tabel (*migrations*), dan mengatur relasi antar data di MySQL. |
| **Hafis** <br> `[2430407057]` | **UI/UX & Frontend** <br> Mendesain alur pengguna dan menyulap kodingan *layout* jadi ciamik pakai Tailwind CSS. |
| **Sindi** <br> `[2330407030]` | **QA & Tech Writer** <br> Menguji fitur agar bebas *bug* dan menyusun Dokumen SRS (Software Requirements Specification). |

---

## ✨ Hak Akses & Fitur Utama

[cite_start]Sistem ini dirancang untuk 2 jenis pengguna (Aktor) dengan fitur yang berjalan lancar tanpa *error* kritis[cite: 14]:

### 👑 1. Admin (Pemilik/Pengelola Lapangan)
* **Dashboard Pintar:** Visualisasi tren pendapatan 7 hari terakhir dengan grafik interaktif (Chart.js).
* **Manajemen Lapangan:** Operasi CRUD (Create, Read, Update, Delete) data lapangan (VIP/Reguler) dan tarif sewa.
* **Manajemen Inventaris:** Pengaturan sewa alat ekstra seperti raket, sepatu, dan kok.
* **Validasi Booking:** Konfirmasi pesanan masuk untuk mencegah jadwal tumpang tindih.

### 🏸 2. Pelanggan (Penyewa)
* **Cek Ketersediaan:** Melihat jadwal lapangan kosong secara *real-time*.
* **Sistem Booking:** Memesan lapangan dan alat tambahan secara mandiri.

---

## 🛠️ Alat Tempur (Teknologi)

* **Backend:** Laravel 11 (PHP 8.3)
* **Frontend:** Blade Templating, Tailwind CSS 3, Vite
* **Database:** MySQL
* **Library:** Chart.js (Visualisasi Data)

---

## 💻 Cara Install di Laptop Kamu

Ikuti panduan *step-by-step* berikut untuk menjalankan proyek secara lokal:

### 1. Persiapan Awal
Kloning repositori dan masuk ke folder proyek:
```bash
git clone [Link-Repo-GitHub-Kalian]
cd sistem-badminton

### 2.Instalasi Dependecies 
Instal paket-paket PHP dan JavaScript yang diperlukan:
composer install
npm install

### 3.Konfigurasi Environment
Salin file konfigurasi dan buat kunci aplikasi:

Salin file: cp .env.example .env

Generate Key: php artisan key:generate

Buka file .env dan pastikan nama database sesuai: DB_DATABASE=sistem-badminton

### 4.Setup Database
Buat database baru bernama sistem-badminton di phpMyAdmin, lalu jalankan migrasi:
php artisan migrate --seed

### 5. Menjalankan Aplikasi
Nyalakan compiler desain dan server:

Terminal 1: npm run dev

Opsi A (Laravel Herd): Akses langsung via http://sistem-badminton.test

Opsi B (Manual): Buka Terminal 2, ketik php artisan serve, lalu buka http://127.0.0.1:8000