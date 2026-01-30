<?php
require_once '../config/database.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';
$query_str = "SELECT lokasi.id, lokasi.nama_tempat, lokasi.foto_utama, lokasi.slug, provinsi.nama_provinsi, kategori.nama_kategori 
              FROM lokasi 
              JOIN provinsi ON lokasi.provinsi_id = provinsi.id 
              JOIN kategori ON lokasi.kategori_id = kategori.id";

if ($search) {
    $query_str .= " WHERE lokasi.nama_tempat LIKE :search OR provinsi.nama_provinsi LIKE :search";
}

$query_str .= " ORDER BY lokasi.id DESC";

$stmt = $pdo->prepare($query_str);
if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$lokasi = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Lokasi - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50">
    
    <?php include '../includes/admin_nav.php'; ?>

    <div class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 mt-8">
            <div class="border-l-4 border-red-700 pl-4">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    Kelola <span class="text-red-700">Destinasi</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Manajemen Peta Wisata Sumatera</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <form action="" method="GET" class="relative group">
                    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Cari lokasi..." 
                           class="w-full md:w-64 pl-10 pr-4 py-3 bg-white border-2 border-slate-200 outline-none focus:border-red-700 transition font-bold text-xs uppercase tracking-widest">
                    <svg class="w-4 h-4 absolute left-3 top-3.5 text-slate-400 group-focus-within:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>

                <a href="lokasi_tambah.php" class="bg-red-700 text-white px-8 py-4 font-black uppercase tracking-widest text-[10px] text-center hover:bg-slate-900 transition shadow-lg shadow-red-100">
                    + Tambah Lokasi
                </a>
            </div>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <div class="mb-8 p-4 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-lg animate-pulse">
                <?php 
                    if($_GET['status'] == 'sukses_tambah') echo "Destinasi baru berhasil ditambahkan!";
                    if($_GET['status'] == 'sukses_edit') echo "Data destinasi berhasil diperbarui!";
                    if($_GET['status'] == 'sukses_hapus') echo "Destinasi telah dihapus dari database.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($lokasi)): ?>
            <div class="bg-white p-20 text-center border-2 border-dashed border-slate-200">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <p class="text-slate-400 italic font-black uppercase tracking-widest text-xs">Jejak lokasi tidak ditemukan.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach($lokasi as $row): ?>
                <div class="group bg-white border border-slate-200 hover:border-red-700 transition-all duration-300 flex flex-col shadow-sm hover:shadow-2xl">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="../assets/uploads/<?= $row['foto_utama'] ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                             alt="<?= htmlspecialchars($row['nama_tempat']) ?>">
                        
                        <div class="absolute top-0 right-0 bg-slate-900/80 backdrop-blur-md text-white px-3 py-1 text-[9px] font-black tracking-widest">
                            #<?= $row['id'] ?>
                        </div>
                        
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-red-700 text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest shadow-lg">
                                <?= htmlspecialchars($row['nama_kategori']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-grow">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-1.5 h-1.5 bg-amber-500 rotate-45"></div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <?= htmlspecialchars($row['nama_provinsi']) ?>
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tighter leading-tight group-hover:text-red-700 transition">
                            <?= htmlspecialchars($row['nama_tempat']) ?>
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 border-t border-slate-100 bg-slate-50/50">
                        <a href="lokasi_edit.php?id=<?= $row['id'] ?>" 
                           class="py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-amber-500 hover:text-white transition-colors flex items-center justify-center gap-2 border-r border-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <a href="lokasi_proses_hapus.php?id=<?= $row['id'] ?>" 
                           onclick="return confirm('Hapus permanen destinasi ini?')" 
                           class="py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-red-700 hover:text-white transition-colors flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>