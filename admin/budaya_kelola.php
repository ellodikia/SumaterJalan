<?php
require_once '../config/database.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';
$query_str = "SELECT budaya.*, provinsi.nama_provinsi 
              FROM budaya 
              LEFT JOIN provinsi ON budaya.asal_provinsi_id = provinsi.id";

if ($search) {
    $query_str .= " WHERE budaya.nama_budaya LIKE :search OR provinsi.nama_provinsi LIKE :search OR budaya.kategori_budaya LIKE :search";
}

$query_str .= " ORDER BY budaya.id DESC";

$stmt = $pdo->prepare($query_str);
if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$budaya = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Budaya - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 mt-8">
            <div class="border-l-4 border-red-700 pl-4">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    Arsip <span class="text-red-700">Budaya</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Dokumentasi Warisan Budaya Sumatera</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <form action="" method="GET" class="relative group">
                    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Cari budaya/wilayah..." 
                           class="w-full md:w-64 pl-10 pr-4 py-3 bg-white border-2 border-slate-200 outline-none focus:border-red-700 transition font-bold text-xs uppercase tracking-widest shadow-sm">
                    <svg class="w-4 h-4 absolute left-3 top-3.5 text-slate-400 group-focus-within:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>

                <a href="budaya_tambah.php" class="bg-red-700 text-white px-8 py-4 font-black uppercase tracking-widest text-[10px] text-center hover:bg-slate-900 transition shadow-lg shadow-red-100">
                    + Tambah Budaya
                </a>
            </div>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <div class="mb-8 p-4 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">
                <?php 
                    if($_GET['status'] == 'sukses_tambah') echo "Data budaya berhasil diarsipkan!";
                    if($_GET['status'] == 'sukses_edit') echo "Data budaya berhasil diperbarui!";
                    if($_GET['status'] == 'sukses_hapus') echo "Arsip budaya telah dihapus.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($budaya)): ?>
            <div class="bg-white p-20 text-center border-2 border-dashed border-slate-200">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-slate-400 italic font-black uppercase tracking-widest text-xs">Belum ada arsip budaya yang ditemukan.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($budaya as $b): ?>
                <div class="group bg-white border border-slate-200 hover:border-red-700 transition-all duration-300 flex flex-col shadow-sm hover:shadow-2xl overflow-hidden">
                    
                    <div class="relative h-52 overflow-hidden bg-slate-100">
                        <img src="../assets/uploads/<?= $b['foto'] ?>" 
                             class="w-full h-full object-cover  group-hover:grayscale-0 group-hover:scale-110 transition duration-700"
                             alt="<?= htmlspecialchars($b['nama_budaya']) ?>">
                        
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-slate-900/90 backdrop-blur-sm text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest border-l-4 border-red-700">
                                <?= htmlspecialchars($b['nama_provinsi']) ?>
                            </span>
                        </div>

                        <div class="absolute top-0 right-0 bg-white/10 backdrop-blur-md text-slate-400 px-3 py-1 text-[9px] font-black">
                            #<?= $b['id'] ?>
                        </div>
                    </div>

                    <div class="p-6 flex-grow">
                        <span class="text-[9px] font-black text-red-700 uppercase tracking-widest mb-2 block">
                            <?= htmlspecialchars($b['kategori_budaya']) ?>
                        </span>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter leading-tight group-hover:text-red-700 transition">
                            <?= htmlspecialchars($b['nama_budaya']) ?>
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 border-t border-slate-100 bg-slate-50/50">
                        <a href="budaya_edit.php?id=<?= $b['id'] ?>" 
                           class="py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-900 hover:text-white transition-all flex items-center justify-center gap-2 border-r border-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Arsip
                        </a>
                        <a href="budaya_hapus.php?id=<?= $b['id'] ?>" 
                           onclick="return confirm('PERHATIAN: Data budaya ini akan dihapus permanen. Lanjutkan?')" 
                           class="py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400 hover:bg-red-700 hover:text-white transition-all flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-12 text-center border-t border-slate-200 pt-8">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                Total Arsip Terdata: <span class="text-slate-900"><?= count($budaya) ?></span> Objek Budaya
            </p>
        </div>
    </main>
</body>
</html>