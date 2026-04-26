#  Sistem Informasi Booking Lapangan Badminton

##  Deskripsi Proyek

Sistem Informasi Booking Lapangan Badminton adalah aplikasi berbasis web yang dibangun menggunakan framework **Laravel** untuk memudahkan pengguna dalam melakukan pemesanan lapangan badminton secara online.

Sistem ini memungkinkan pengguna untuk melihat jadwal ketersediaan lapangan, melakukan booking, serta membantu admin dalam mengelola data pemesanan, jadwal, dan pengguna secara efisien.

---

##  Tim Pengembang

| No | Nama           | NIM        |
| -- | -------------- | ---------- |
| 1  | Rahmat Tanjung | 2330407021 |
| 2  | Andre          | 2330407004 |
| 3  | Hafis          | 2430407057 |
| 4  | Sindi          | 2330407030 |

---

##  Fitur Utama

*  **Autentikasi User (Login & Register)**
*  **Booking Lapangan Badminton**
*  **Manajemen Jadwal Booking**
*  **Dashboard Admin**
*  **Riwayat Booking**
*  **Validasi Booking (mencegah double booking)**
*  **Tampilan modern menggunakan Tailwind CSS**
*  **Frontend interaktif dengan Vite**

---

##  Teknologi yang Digunakan

* **Backend**: PHP (Laravel Framework)
* **Frontend**: Blade Template, Tailwind CSS
* **Build Tool**: Vite
* **Database**: MySQL
* **Version Control**: Git
* **Library Tambahan**:

  * FullCalendar (opsional untuk fitur kalender)
  * Axios / Fetch API

---

##  Cara Instalasi Lokal

Ikuti langkah berikut untuk menjalankan project di lokal:

### 1. Clone Repository

```bash
git clone https://github.com/amektanjung2-ship-it/sistem-badminton-laravel.git 

cd sistem-badminton
```

---

### 2. Install Dependency

```bash
composer install
npm install
```

---

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan database:

```env
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4. Generate Key

```bash
php artisan key:generate
```

---

### 5. Migrasi Database

```bash
php artisan migrate
```

---

### 6. Jalankan Server

```bash
php artisan serve
npm run dev
```

Akses aplikasi di:

```
http://127.0.0.1:8000
```

---

##  Status Pengembangan

🟡 **Dalam Pengembangan (Development Stage)**

Fitur yang sudah tersedia:

* Sistem login & register
* CRUD booking
* Dashboard dasar

Fitur yang sedang / akan dikembangkan:

* 📅 Kalender booking interaktif
* 💳 Sistem pembayaran
* 🔔 Notifikasi pengguna
* 📊 Statistik dashboard yang lebih lengkap

---

##  Tujuan Pengembangan

* Mempermudah proses booking lapangan badminton
* Mengurangi kesalahan pencatatan manual
* Meningkatkan efisiensi pengelolaan jadwal
* Memberikan pengalaman pengguna yang lebih baik

---

##  Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan pengembangan sistem informasi.

---
