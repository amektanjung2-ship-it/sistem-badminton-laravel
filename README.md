# 🏸 E-Badminton: Smart Arena Management System

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

E-Badminton adalah platform digital mutakhir yang dirancang untuk merevolusi manajemen operasional lapangan badminton. [cite_start]Dikembangkan oleh mahasiswa **Sistem Informasi**, proyek ini mengintegrasikan pemrosesan data real-time dengan visualisasi analitik untuk mendukung pengambilan keputusan bisnis yang lebih akurat[cite: 16].

---

## 🚀 Mengapa E-Badminton?
[cite_start]Sistem ini hadir untuk menyelesaikan masalah operasional yang sering terjadi di lapangan olahraga tradisional[cite: 5, 8]:
- **Double Booking:** Algoritma validasi jadwal memastikan tidak ada jadwal bentrok.
- **Transparansi Keuangan:** Dashboard admin dengan grafik tren pendapatan harian.
- **Efisiensi Inventaris:** Pelacakan stok alat olahraga (raket, kok) yang terintegrasi dengan pemesanan.

---

## 👨‍💻 Tim Pengembang (Kelompok UTS)
[cite_start]Kami adalah tim beranggotakan 4 orang yang berkolaborasi penuh pada pengembangan perangkat lunak dan penyusunan dokumentasi sistem[cite: 16].

| Peran | Nama & NIM | Tugas Utama |
| :---: | :--- | :--- |
| 🛡️ | **Rahmat Tanjung** <br> `[2330407021]` | **Lead & Fullstack Developer** (Arsitektur Sistem & Logika Bisnis) |
| 🗄️ | **Andre** <br> `[2330407004]` | **Backend & Database Engineer** (Struktur ERD & Database MySQL) |
| 🎨 | **Hafis** <br> `[NIM Hafis]` | **Frontend & UI/UX Designer** (Slicing UI & Tailwind CSS) |
| 📝 | **Sindi** <br> `[2330407030]` | **QA & Technical Writer** (Dokumentasi SRS & Pengetesan Fitur) |

---

## 🛠️ Fitur Utama
[cite_start]Aplikasi ini memiliki minimal 3 fitur utama yang sudah berjalan sesuai kriteria demo UTS[cite: 14, 16]:
1. **Advanced Admin Dashboard:** Visualisasi tren pendapatan menggunakan Chart.js.
2. **Intelligent Booking System:** Manajemen jadwal penyewaan lapangan secara dinamis.
3. **Master Data Management:** Pengelolaan data lapangan, alat, dan harga sewa (CRUD).

---

## 💻 Panduan Instalasi Lokal
[cite_start]Berikut adalah cara menjalankan proyek ini di lingkungan pengembangan lokal[cite: 16]:

1. **Clone Repository:** `git clone [https://github.com/amektanjung2-ship-it/sistem-badminton-laravel]`
2. **Install Library:** `composer install` dan `npm install`
3. **Setup Env:** Copy `.env.example` ke `.env` lalu `php artisan key:generate`
4. **Database:** Buat database `sistem-badminton` lalu `php artisan migrate --seed`
5. **Run:** `npm run dev` dan akses via `http://sistem-badminton.test` (Laravel Herd)

---

## 📈 Status Pengembangan (Update: 26 April 2026)
- [x] [cite_start]**Milestone 1:** Desain Database & ERD (100%) [cite: 16]
- [x] **Milestone 2:** Setup Dashboard & Grafik Pendapatan (100%)
- [x] **Milestone 3:** Fitur CRUD Data Master (100%)
- [ ] **Milestone 4:** Integrasi Notifikasi WA (Planned)

---

> [cite_start]**Catatan:** Repository ini dikelola untuk memenuhi tugas UTS Proyek Sistem Informasi (Senin, 27 April 2026)[cite: 1, 16].