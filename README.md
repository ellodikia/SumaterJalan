# 🗺️ SumateraJalan - CMS Warisan Swarnadwipa

**SumateraJalan** adalah platform manajemen konten (CMS) berbasis web yang dirancang untuk mendokumentasikan kekayaan destinasi, kuliner, dan budaya di Pulau Sumatera. Dibangun dengan fokus pada performa dan desain yang modern serta responsif.

## 🚀 Fitur Utama
* **Manajemen Destinasi**: Kelola lokasi wisata populer di Sumatera.
* **Arsip Kuliner**: Dokumentasi masakan khas beserta kategori wilayahnya.
* **Warisan Budaya**: Inventarisasi seni, tradisi, dan sejarah budaya.
* **Admin Control Center**: Dashboard eksklusif untuk admin dengan autentikasi aman.
* **UI/UX Modern**: Antarmuka berbasis Tailwind CSS dengan desain high-contrast.

## 🛠️ Teknologi yang Digunakan
* **Bahasa**: PHP 8.x
* **Database**: MySQL/MariaDB
* **Styling**: Tailwind CSS (via CDN)
* **Library**: PDO (PHP Data Objects) untuk koneksi database yang aman.

## 📦 Struktur Folder
```text
SumateraJalan/
├── admin/               # Folder khusus manajemen admin
│   ├── lokasi_kelola.php
│   ├── kuliner_kelola.php
│   └── budaya_kelola.php
├── assets/              # Media (Gambar, Icons, CSS)
│   └── uploads/         # Folder penyimpanan foto yang diunggah
├── config/              # Konfigurasi sistem
│   └── database.php     # Koneksi PDO
├── includes/            # Komponen reusable (Navbar, Footer)
│   └── admin_nav.php
├── index.php            # Halaman utama (Public)
├── login.php            # Halaman masuk admin
├── register.php         # Halaman pendaftaran admin baru
└── logout.php           # Proses penghapusan sesi