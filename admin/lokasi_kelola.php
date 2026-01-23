<?php
require_once '../config/database.php';

$query = "SELECT lokasi.id, lokasi.nama_tempat, lokasi.foto_utama, provinsi.nama_provinsi, kategori.nama_kategori 
          FROM lokasi 
          JOIN provinsi ON lokasi.provinsi_id = provinsi.id 
          JOIN kategori ON lokasi.kategori_id = kategori.id 
          ORDER BY lokasi.id DESC";
$lokasi = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Lokasi - Swarnadwipa Admin</title>
</head>
<body class="bg-slate-50 pb-20">
    
    <?php include '../includes/admin_nav.php'; ?>

    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-10">
            <div class="border-l-4 border-red-700 pl-4">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900">
                    Daftar <span class="text-red-700">Destinasi</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Manajemen Peta Wisata Sumatera</p>
            </div>
            <a href="lokasi_tambah.php" class="bg-red-700 text-white px-8 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition shadow-lg shadow-red-100">
                + Tambah Lokasi Baru
            </a>
        </div>

        <div class="bg-white shadow-2xl border-t-4 border-slate-900 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b-2 border-slate-100">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Pratinjau</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Destinasi</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Wilayah</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($lokasi)): ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center text-slate-400 italic font-medium uppercase tracking-widest text-xs">
                                Belum ada jejak lokasi yang terdaftar.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($lokasi as $row): ?>
                        <tr class="hover:bg-slate-50 transition duration-300">
                            <td class="p-6">
                                <img src="../assets/uploads/<?= $row['foto_utama'] ?>" class="w-20 h-14 object-cover border-2 border-slate-100 shadow-sm">
                            </td>
                            <td class="p-6">
                                <span class="font-black text-slate-800 tracking-tight uppercase block"><?= $row['nama_tempat'] ?></span>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-amber-500"></div>
                                    <span class="text-xs font-black text-slate-600 uppercase"><?= $row['nama_provinsi'] ?></span>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="px-4 py-1.5 bg-slate-100 text-slate-700 text-[9px] font-black uppercase tracking-widest border border-slate-200">
                                    <?= $row['nama_kategori'] ?>
                                </span>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center gap-3">
                                    <a href="lokasi_edit.php?id=<?= $row['id'] ?>" class="bg-slate-900 text-white p-3 hover:bg-amber-500 transition shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="lokasi_proses_hapus.php?id=<?= $row['id'] ?>" 
                                       onclick="return confirm('Hapus destinasi ini dari peta?')" 
                                       class="bg-red-700 text-white p-3 hover:bg-red-900 transition shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>