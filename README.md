# SIMALAB (Sistem Manajemen Inventaris Lab)

SIMALAB adalah sebuah sistem informasi berbasis web yang dibangun menggunakan **Laravel 11** untuk mengelola inventaris laboratorium (khususnya Lab Teknik Digital). Sistem ini dirancang untuk memudahkan staf lab, asisten, koordinator, dan mahasiswa dalam mengelola, meminjam, serta memantau barang dan peralatan yang ada di dalam laboratorium.

## 🚀 Fitur Utama

- **Manajemen Inventaris:** Pencatatan dan pengelolaan barang lab dengan mendetail (Kondisi, Lokasi, dsb).
- **Role-Based Access Control (RBAC):** Menggunakan paket **Spatie Permission** untuk mengatur hak akses pengguna yang terdiri dari beberapa role:
  - `Admin`
  - `Koordinator`
  - `PLP` (Pranata Laboratorium Pendidikan)
  - `Asisten`
  - `Mahasiswa`
- **Real-Time Notifications:** Dilengkapi dengan fitur notifikasi secara real-time menggunakan **Laravel Reverb** dan **Livewire**.
- **Dashboard Admin:** Dashboard khusus untuk Admin dan Koordinator Lab dalam mengelola peran pengguna (User Roles) dan inventaris.
- **Katalog Barang:** Antarmuka katalog untuk melihat daftar inventaris lab yang tersedia.
- **UI/UX Modern:** Antarmuka responsif yang dibangun menggunakan **Tailwind CSS** dan komponen-komponen pendukung lainnya (TALL stack).

## 🛠️ Teknologi yang Digunakan (Tech Stack)

Aplikasi ini menggunakan **TALL Stack** beserta teknologi pendukung lainnya:

- **Framework PHP:** [Laravel 11](https://laravel.com)
- **Frontend Framework / Styling:** [Tailwind CSS](https://tailwindcss.com) via Vite
- **Reactivity & Components:** [Livewire](https://livewire.laravel.com/) & Alpine.js
- **Role & Permission Management:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- **WebSockets / Real-Time:** Laravel Reverb & Laravel Echo
- **Database:** MySQL

## ⚙️ Persyaratan Sistem (Prerequisites)

Sebelum menjalankan project ini secara lokal, pastikan Anda telah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB Database

## 💻 Cara Instalasi dan Menjalankan Project

Ikuti langkah-langkah di bawah ini untuk menjalankan SIMALAB di environment lokal:

1. **Clone repository ini:**
   ```bash
   git clone <url-repo-anda>
   cd SIMALAB_Baru/Simalab
   ```

2. **Install dependency PHP (Composer):**
   ```bash
   composer install
   ```

3. **Install dependency NPM (Node.js):**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan atur konfigurasi database Anda.
   ```bash
   cp .env.example .env
   ```
   *Buka file `.env` dan sesuaikan bagian `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai dengan konfigurasi lokal Anda.*

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database dan Seeding (Dummy Data):**
   Jalankan migrasi untuk membuat tabel dan jalankan seeder untuk memasukkan data awal termasuk role dan dummy user:
   ```bash
   php artisan migrate --seed
   ```

7. **Compile Asset Frontend:**
   Jalankan Vite untuk melakukan build pada asset Tailwind CSS dan JavaScript:
   ```bash
   npm run dev
   ```

8. **Jalankan Laravel Development Server:**
   Buka terminal baru dan jalankan server PHP:
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://localhost:8000`.

9. **(Opsional) Jalankan WebSocket untuk Notifikasi Real-time:**
   Jika ingin menggunakan fitur real-time Laravel Reverb, pastikan Reverb sedang berjalan:
   ```bash
   php artisan reverb:start
   ```

## 👥 Hak Akses (Roles)

Secara default (melalui Seeder), sistem memiliki beberapa tingkatan user:
1. **Admin/Koordinator:** Memiliki akses penuh ke sistem termasuk manajemen user (role assignments) dan manajemen inventaris.
2. **PLP / Asisten:** Memiliki akses untuk mengelola data barang dan inventaris.
3. **Mahasiswa:** Memiliki akses terbatas, umumnya untuk melihat katalog atau meminjam barang.

---

*Dikembangkan untuk keperluan manajemen inventaris Lab Teknik Digital.*
