# Struktur dan Hierarki Frontend SIMALAB

Dokumen ini menjelaskan struktur folder dan hierarki file frontend pada proyek SIMALAB yang berbasis Laravel.

## 📂 Lokasi Utama Frontend
Seluruh file frontend utama berada di direktori:
`Simalab/resources/views/`

---

## 🏗️ Hierarki Direktori `resources/views`

### 1. `layouts/` (Template Utama)
Berisi kerangka utama halaman (Master Layouts).
- **`app.blade.php`**: Layout utama untuk user yang sudah login.
- **`admin.blade.php`**: Layout khusus untuk halaman Administrator.
- **`user.blade.php`**: Layout khusus untuk halaman User/Mahasiswa.
- **`guest.blade.php`**: Layout untuk halaman publik (seperti Login/Register).
- **`navigation.blade.php`**: Komponen navigasi (Navbar/Sidebar).

### 2. `components/` (Komponen Reusable)
Berisi potongan UI kecil yang dapat digunakan berulang kali.
- `application-logo.blade.php`: Logo aplikasi.
- `primary-button.blade.php`, `secondary-button.blade.php`, `danger-button.blade.php`: Berbagai jenis tombol.
- `modal.blade.php`: Template popup modal.
- `text-input.blade.php`, `input-label.blade.php`, `input-error.blade.php`: Komponen form input.
- `dropdown.blade.php`, `nav-link.blade.php`: Komponen navigasi.

### 3. `admin/` (Halaman Administrator)
- **`dashboard.blade.php`**: Ringkasan statistik dan kontrol admin.
- **`users.blade.php`**: Manajemen data pengguna dan role.

### 4. `user/` (Halaman Mahasiswa/User)
- **`dashboard.blade.php`**: Halaman utama user.
- **`barang.blade.php`**: Daftar barang yang tersedia untuk dipinjam.
- **`pinjam.blade.php`**: Form pengajuan peminjaman.
- **`riwayat.blade.php`**: Catatan peminjaman yang pernah dilakukan.
- **`ketersediaan.blade.php`**: Cek status ketersediaan alat.

### 5. `items/` (Manajemen Inventaris)
Berisi view untuk pengelolaan barang (CRUD Barang).

### 6. `borrowings/` & `peminjaman/`
Modul yang menangani alur peminjaman dan pengembalian alat laboratorium.

### 7. `auth/` (Autentikasi)
Halaman terkait akses masuk:
- `login.blade.php`, `register.blade.php`, `forgot-password.blade.php`, dll.

### 8. `livewire/` (Komponen Interaktif)
Komponen yang menggunakan Laravel Livewire untuk interaksi tanpa refresh halaman.
- `assistant-notifications.blade.php`: Notifikasi untuk asisten lab.

---

## 📑 Halaman Utama Lainnya
- **`welcome.blade.php`**: Landing page saat pertama kali membuka aplikasi.
- **`katalog.blade.php`**: Katalog publik untuk melihat daftar alat lab.
- **`dashboard.blade.php`**: Dashboard umum.

---

## 💡 Ringkasan Alur Layout
1. **Request** datang dari route.
2. **Controller** memanggil view (misal: `admin/dashboard`).
3. View tersebut meng-`extend` layout (misal: `@extends('layouts.admin')`).
4. Layout tersebut memanggil **components** untuk elemen kecil (misal: `<x-primary-button>`).
