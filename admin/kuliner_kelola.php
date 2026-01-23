<?php
require_once '../config/database.php';

$query = "SELECT kuliner.*, provinsi.nama_provinsi 
          FROM kuliner 
          LEFT JOIN provinsi ON kuliner.asal_provinsi_id = provinsi.id 
          ORDER BY kuliner.id DESC";
$stmt = $pdo->query($query);
$kuliner = $stmt->fetchAll();

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $stmt_foto = $pdo->prepare("SELECT foto FROM kuliner WHERE id = ?");
    $stmt_foto->execute([$id]);
    $f = $stmt_foto->fetch();
    
    if ($f && file_exists("../assets/uploads/" . $f['foto'])) {
        unlink("../assets/uploads/" . $f['foto']);
    }

    $pdo->prepare("DELETE FROM kuliner WHERE id = ?")->execute([$id]);
    header("Location: kuliner_kelola.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Kuliner - Swarnadwipa</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-black uppercase tracking-tighter text-slate-900">Database <span class="text-red-700">Kuliner</span></h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Manajemen Warisan Rasa Sumatera</p>
            </div>
            <a href="kuliner_tambah.php" class="bg-red-700 text-white px-8 py-3 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition shadow-lg shadow-red-100">
                + Tambah Menu Baru
            </a>
        </div>

        <div class="bg-white shadow-2xl overflow-hidden border-t-4 border-slate-900">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b-2 border-slate-100">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Visual</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Detail Menu</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori & Status</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($kuliner as $row): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 w-32">
                            <img src="../assets/uploads/<?= $row['foto'] ?>" class="w-24 h-16 object-cover border-2 border-white shadow-md">
                        </td>
                        <td class="p-6">
                            <h4 class="font-black uppercase text-slate-800 tracking-tight text-lg"><?= $row['nama_kuliner'] ?></h4>
                            <p class="text-[10px] font-bold text-red-700 uppercase tracking-widest mt-1">Asal: <?= $row['nama_provinsi'] ?></p>
                        </td>
                        <td class="p-6">
                            <div class="flex flex-col gap-2">
                                <span class="w-fit px-3 py-1 bg-slate-100 text-slate-600 text-[9px] font-black uppercase tracking-widest">
                                    <?= $row['kategori_kuliner'] ?>
                                </span>
                                <span class="w-fit px-3 py-1 <?= $row['status_halal'] == 'Halal' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' ?> text-[9px] font-black uppercase tracking-widest">
                                    <?= $row['status_halal'] ?>
                                </span>
                            </div>
                        </td>
                        <td class="p-6">
                            <div class="flex flex-wrap justify-center gap-3">
                                <a href="kuliner_tempat.php?kuliner_id=<?= $row['id'] ?>" class="bg-amber-500 text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-slate-900 transition">
                                    Lokasi
                                </a>
                                
                                <a href="kuliner_edit.php?id=<?= $row['id'] ?>" class="bg-slate-900 text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-red-700 transition">
                                    Edit
                                </a>
                                
                                <a href="?hapus=<?= $row['id'] ?>" 
                                   onclick="return confirm('Hapus menu ini beserta semua data lokasinya?')"
                                   class="bg-white border-2 border-slate-200 text-slate-400 px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:border-red-700 hover:text-red-700 transition">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php if(empty($kuliner)): ?>
                <div class="p-20 text-center">
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Belum ada data kuliner terdaftar.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>