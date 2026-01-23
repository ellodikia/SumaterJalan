<?php
require_once 'config/database.php';

try {
    // 1. Bersihkan data lama agar tidak duplikat (Opsional)
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE budaya;");
    $pdo->exec("TRUNCATE TABLE kuliner;");
    $pdo->exec("TRUNCATE TABLE lokasi;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "Memulai proses sinkronisasi data dummy...<br>";

    // --- DATA DUMMY BUDAYA ---
    $data_budaya = [
        ['Tari Saman', 1, 'Tarian', 'Tarian harmonisasi ribuan tangan dari Aceh.', 'saman.jpg'],
        ['Lompat Batu', 2, 'Upacara Adat', 'Tradisi kedewasaan pemuda Nias.', 'lompat_batu.jpg'],
        ['Gordang Sambilan', 2, 'Alat Musik', 'Sembilan gendang sakral Mandailing.', 'gordang.jpg'],
        ['Tari Piring', 3, 'Tarian', 'Tarian lincah menggunakan piring dari Minangkabau.', 'tari_piring.jpg'],
        ['Pakaian Aesan Gede', 6, 'Pakaian Adat', 'Busana kebesaran Kerajaan Sriwijaya.', 'aesan_gede.jpg']
    ];

    $stmt_budaya = $pdo->prepare("INSERT INTO budaya (nama_budaya, asal_provinsi_id, kategori_budaya, deskripsi, foto) VALUES (?, ?, ?, ?, ?)");
    foreach ($data_budaya as $row) {
        $stmt_budaya->execute($row);
    }
    echo "- Data Budaya berhasil diisi.<br>";

    $data_kuliner = [
        ['Rendang', 3, 'Makanan Berat', 'Halal', 'Daging rempah yang dimasak berjam-jam.', 'rendang.jpg'],
        ['Pempek', 6, 'Camilan', 'Halal', 'Olahan ikan khas Palembang dengan kuah cuko.', 'pempek.jpg'],
        ['Mie Aceh', 1, 'Makanan Berat', 'Halal', 'Mie kaya rempah dengan daging kambing/seafood.', 'mie_aceh.jpg'],
        ['Teh Talua', 3, 'Minuman', 'Halal', 'Minuman stamina dari campuran teh dan telur.', 'teh_talua.jpg'],
        ['Bika Ambon', 2, 'Camilan', 'Halal', 'Kue legit berongga khas Medan.', 'bika_ambon.jpg']
    ];

    $stmt_kuliner = $pdo->prepare("INSERT INTO kuliner (nama_kuliner, asal_provinsi_id, kategori_kuliner, status_halal, deskripsi, foto) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($data_kuliner as $row) {
        $stmt_kuliner->execute($row);
    }
    echo "- Data Kuliner berhasil diisi.<br>";

    $data_lokasi = [
        ['Danau Toba', 2, 1, 'danau-toba', 'Danau vulkanik terbesar dengan Pulau Samosir.', 'toba.jpg'],
        ['Ngarai Sianok', 3, 1, 'ngarai-sianok', 'Lembah hijau indah di Bukittinggi.', 'sianok.jpg'],
        ['Benteng Marlborough', 7, 2, 'benteng-marlborough', 'Peninggalan sejarah Inggris di Bengkulu.', 'benteng.jpg'],
        ['Pantai Tanjung Tinggi', 8, 3, 'tanjung-tinggi', 'Pantai Laskar Pelangi dengan batu granit.', 'belitung.jpg'],
        ['Gunung Dempo', 6, 1, 'gunung-dempo', 'Puncak tertinggi dengan hamparan kebun teh.', 'dempo.jpg']
    ];

    $stmt_lokasi = $pdo->prepare("INSERT INTO lokasi (nama_tempat, provinsi_id, kategori_id, slug, deskripsi, foto_utama) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($data_lokasi as $row) {
        $stmt_lokasi->execute($row);
    }
    echo "- Data Lokasi Eksplor berhasil diisi.<br>";

    echo "<br><strong>Selesai! Semua data kategori sudah terisi.</strong>";

} catch (PDOException $e) {
    die("Gagal mengisi data: " . $e->getMessage());
}
?>