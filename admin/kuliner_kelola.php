<?php
require_once '../config/database.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';
$query_str = "SELECT kuliner.*, provinsi.nama_provinsi 
              FROM kuliner 
              LEFT JOIN provinsi ON kuliner.asal_provinsi_id = provinsi.id";

if ($search) {
    $query_str .= " WHERE kuliner.nama_kuliner LIKE :search OR provinsi.nama_provinsi LIKE :search";
}

$query_str .= " ORDER BY kuliner.id DESC";

$stmt = $pdo->prepare($query_str);
if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$kuliner = $stmt->fetchAll();

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    
    $stmt_foto = $pdo->prepare("SELECT foto FROM kuliner WHERE id = ?");
    $stmt_foto->execute([$id]);
    $f = $stmt_foto->fetch();
    
    if ($f && $f['foto'] != "" && file_exists("../assets/uploads/" . $f['foto'])) {
        unlink("../assets/uploads/" . $f['foto']);
    }

    $pdo->prepare("DELETE FROM kuliner WHERE id = ?")->execute([$id]);
    header("Location: kuliner_kelola.php?status=sukses_hapus");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Kuliner - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 mt-8">
            <div class="border-l-4 border-amber-500 pl-4">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    Database <span class="text-red-700">Kuliner</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Manajemen Warisan Rasa Sumatera</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <form action="" method="GET" class="relative group">
                    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Cari menu..." 
                           class="w-full md:w-64 pl-10 pr-4 py-3 bg-white border-2 border-slate-200 outline-none focus:border-red-700 transition font-bold text-xs uppercase tracking-widest shadow-sm">
                    <svg class="w-4 h-4 absolute left-3 top-3.5 text-slate-400 group-focus-within:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>

                <a href="kuliner_tambah.php" class="bg-red-700 text-white px-8 py-4 font-black uppercase tracking-widest text-[10px] text-center hover:bg-slate-900 transition shadow-lg shadow-red-100">
                    + Tambah Menu Baru
                </a>
            </div>
        </div>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses_hapus'): ?>
            <div class="mb-8 p-4 bg-red-600 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-lg animate-pulse">
                Data kuliner dan file gambar terkait telah dihapus.
            </div>
        <?php endif; ?>

        <?php if (empty($kuliner)): ?>
            <div class="bg-white p-20 text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-400 italic font-black uppercase tracking-widest text-xs">Belum ada menu kuliner yang terdata.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($kuliner as $row): ?>
                <div class="group bg-white border border-slate-200 hover:border-amber-500 transition-all duration-300 flex flex-col shadow-sm hover:shadow-2xl">
                    <div class="relative h-52 overflow-hidden bg-slate-100">
                        <img src="../assets/uploads/<?= $row['foto'] ?>" 
                             class="w-full h-full object-cover  group-hover:grayscale-0 group-hover:scale-110 transition duration-700"
                             alt="<?= htmlspecialchars($row['nama_kuliner']) ?>">
                        
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 <?= $row['status_halal'] == 'Halal' ? 'bg-emerald-600' : 'bg-orange-600' ?> text-white text-[9px] font-black uppercase tracking-widest shadow-lg">
                                <?= $row['status_halal'] ?>
                            </span>
                        </div>

                        <div class="absolute bottom-0 right-0 bg-slate-900 text-white px-4 py-1 text-[8px] font-black uppercase tracking-widest">
                            <?= htmlspecialchars($row['kategori_kuliner']) ?>
                        </div>
                    </div>

                    <div class="p-6 flex-grow">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-black text-red-700 uppercase tracking-widest">
                                <?= htmlspecialchars($row['nama_provinsi']) ?>
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter leading-tight group-hover:text-amber-600 transition">
                            <?= htmlspecialchars($row['nama_kuliner']) ?>
                        </h3>
                    </div>

                    <div class="grid grid-cols-3 border-t border-slate-100">
                        <a href="kuliner_tempat.php?kuliner_id=<?= $row['id'] ?>" 
                           class="py-4 text-center text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-amber-500 hover:text-white transition-colors border-r border-slate-100"
                           title="Kelola Lokasi Toko">
                           Toko
                        </a>
                        <a href="kuliner_edit.php?id=<?= $row['id'] ?>" 
                           class="py-4 text-center text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-900 hover:text-white transition-colors border-r border-slate-100">
                           Edit
                        </a>
                        <a href="?hapus=<?= $row['id'] ?>" 
                           onclick="return confirm('Hapus menu ini beserta data tokonya?')" 
                           class="py-4 text-center text-[9px] font-black uppercase tracking-widest text-slate-400 hover:bg-red-700 hover:text-white transition-colors">
                           Hapus
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


    </main>
    <?php include '../includes/footer.php'; ?>

</body>
</html>