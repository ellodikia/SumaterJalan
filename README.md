# 🏛️ Arsip Swarnadwipa: Jejak Sumatera

**Arsip Swarnadwipa** adalah platform digital berbasis web yang didedikasikan untuk mendokumentasikan dan mempromosikan kekayaan warisan leluhur Pulau Sumatera, mulai dari destinasi wisata, kuliner autentik, hingga seni budaya.

## 🚀 Fitur Utama

- **Eksplorasi Destinasi**: Pencarian tempat wisata berdasarkan wilayah provinsi dan kategori (Alam, Sejarah, Religi, dll).
- **Galeri Kuliner**: Katalog makanan dan minuman khas Sumatera dengan filter status Halal/Non-Halal.
- **Warisan Budaya**: Dokumentasi tarian, upacara adat, pakaian, dan alat musik tradisional.
- **Filter & Search Modern**: Sistem filter dinamis yang *user-friendly* dan *sticky toolbar* untuk kemudahan navigasi.
- **Desain Responsif**: Antarmuka yang optimal untuk perangkat mobile maupun desktop menggunakan Tailwind CSS.

## 🛠️ Teknologi yang Digunakan

- **Frontend**: [Tailwind CSS](https://tailwindcss.com/) (Styling), HTML5, JavaScript.
- **Backend**: PHP 8.x (Native/PDO).
- **Database**: MySQL / MariaDB.
- **Design Pattern**: Monolithic Architecture dengan pemisahan komponen (includes/header & footer).

## 📂 Struktur Folder Utama

```text
├── assets/             # Gambar, CSS, dan file statis lainnya
├── config/             # Konfigurasi database (database.php)
├── includes/           # Komponen layout (header.php, footer.php)
├── eksplor.php         # Halaman eksplorasi destinasi wisata
├── kuliner.php         # Halaman katalog kuliner
├── budaya.php          # Halaman warisan budaya
└── detail.php          # Halaman detail masing-masing konten