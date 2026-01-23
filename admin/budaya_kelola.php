<?php
require_once '../config/database.php';

$query = "SELECT budaya.*, provinsi.nama_provinsi 
          FROM budaya 
          LEFT JOIN provinsi ON budaya.asal_provinsi_id = provinsi.id 
          ORDER BY budaya.id DESC";
$stmt = $pdo->query($query);
$budaya = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Budaya - Admin</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-black uppercase tracking-tighter text-slate-900">Arsip <span class="text-red-700">Budaya</span></h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Dokumentasi Warisan Budaya Sumatera</p>
            </div>
            <a href="budaya_tambah.php" class="bg-red-700 text-white px-8 py-3 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition">
                + Tambah Budaya
            </a>
        </div>

        <div class="bg-white shadow-2xl border-t-4 border-slate-900">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Visual</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama & Kategori</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Asal Wilayah</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php foreach ($budaya as $b): ?>
                    <tr>
                        <td class="p-6 w-32">
                            <img src="../assets/uploads/<?= $b['foto'] ?>" class="w-24 h-16 object-cover grayscale hover:grayscale-0 transition duration-500">
                        </td>
                        <td class="p-6">
                            <h4 class="font-black uppercase text-slate-800 tracking-tight"><?= $b['nama_budaya'] ?></h4>
                            <span class="text-[9px] font-bold text-red-700 uppercase tracking-widest"><?= $b['kategori_budaya'] ?></span>
                        </td>
                        <td class="p-6">
                            <span class="font-bold text-slate-600 uppercase text-xs italic"><?= $b['nama_provinsi'] ?></span>
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="budaya_edit.php?id=<?= $b['id'] ?>" class="bg-slate-900 text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-red-700">Edit</a>
                                <a href="budaya_hapus.php?id=<?= $b['id'] ?>" onclick="return confirm('Hapus data budaya ini?')" class="border-2 border-slate-200 text-slate-400 px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:border-red-700 hover:text-red-700">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>