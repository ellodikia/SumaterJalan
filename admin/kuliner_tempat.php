<?php
require_once '../config/database.php';

if (!isset($_GET['kuliner_id'])) {
    header("Location: kuliner_kelola.php");
    exit;
}

$kuliner_id = (int)$_GET['kuliner_id'];

$stmt_k = $pdo->prepare("SELECT nama_kuliner FROM kuliner WHERE id = ?");
$stmt_k->execute([$kuliner_id]);
$kuliner = $stmt_k->fetch();

if (!$kuliner) {
    header("Location: kuliner_kelola.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_tempat'])) {
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $link_maps = $_POST['link_maps'];

    $sql = "INSERT INTO kuliner_tempat (kuliner_id, nama_toko, alamat, link_maps) VALUES (?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$kuliner_id, $nama_toko, $alamat, $link_maps]);
    
    header("Location: kuliner_tempat.php?kuliner_id=$kuliner_id");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_tempat = (int)$_GET['hapus'];
    $pdo->prepare("DELETE FROM kuliner_tempat WHERE id = ?")->execute([$id_tempat]);
    
    header("Location: kuliner_tempat.php?kuliner_id=$kuliner_id");
    exit;
}


$stmt_t = $pdo->prepare("SELECT * FROM kuliner_tempat WHERE kuliner_id = ? ORDER BY id DESC");
$stmt_t->execute([$kuliner_id]);
$daftar_tempat = $stmt_t->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Lokasi - <?= htmlspecialchars($kuliner['nama_kuliner']) ?></title>
</head>
<body class="bg-slate-50 ">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6 max-w-6xl">
        <div class="mt-8 md:mt-12 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <a href="kuliner_kelola.php" class="text-[10px] font-black uppercase text-red-700 hover:text-slate-900 transition flex items-center gap-2">
                    <span>←</span> Kembali ke Database
                </a>
                <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tighter text-slate-900 mt-2">
                    Lokasi <span class="text-red-700"><?= htmlspecialchars($kuliner['nama_kuliner']) ?></span>
                </h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Daftar Rekomendasi Tempat Menikmati Sajian</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-10">
            <div class="lg:col-span-4">
                <div class="bg-white p-6 md:p-8 shadow-2xl border-t-4 border-slate-900 sticky top-10">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] mb-6 text-slate-800 border-b pb-4 border-slate-100">Tambah Rekomendasi</h3>
                    
                    <form action="" method="POST" class="space-y-5">
                        <input type="hidden" name="tambah_tempat" value="1">
                        
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-slate-400">Nama Toko / Warung</label>
                            <input type="text" name="nama_toko" required
                                   class="w-full p-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 font-bold text-sm transition" 
                                   placeholder="Contoh: RM Pagi Sore">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-slate-400">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" required
                                      class="w-full p-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 text-sm transition" 
                                      placeholder="Jl. Lintas Sumatera KM..."></textarea>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-slate-400">Link Google Maps (URL)</label>
                            <input type="url" name="link_maps" 
                                   class="w-full p-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 text-sm transition" 
                                   placeholder="https://goo.gl/maps/...">
                        </div>

                        <button type="submit" class="w-full bg-red-700 text-white py-4 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition shadow-lg shadow-red-100 mt-2">
                            Simpan Lokasi Baru
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white shadow-2xl overflow-hidden border-t-4 border-red-700">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b-2 border-slate-100">
                                    <th class="p-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Detail Tempat & Alamat</th>
                                    <th class="p-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php if(empty($daftar_tempat)): ?>
                                    <tr>
                                        <td colspan="2" class="p-16 text-center">
                                            <p class="text-slate-300 text-[10px] font-black uppercase tracking-[0.3em] italic">Belum ada lokasi yang terdaftar untuk menu ini.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php foreach ($daftar_tempat as $t): ?>
                                <tr class="hover:bg-slate-50/80 transition group">
                                    <td class="p-5">
                                        <div class="flex flex-col">
                                            <h4 class="font-black text-slate-800 uppercase text-base tracking-tight group-hover:text-red-700 transition">
                                                <?= htmlspecialchars($t['nama_toko']) ?>
                                            </h4>
                                            <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed font-medium">
                                                <?= htmlspecialchars($t['alamat']) ?>
                                            </p>
                                            <?php if($t['link_maps']): ?>
                                                <a href="<?= htmlspecialchars($t['link_maps']) ?>" target="_blank" 
                                                   class="text-[8px] text-amber-600 font-black uppercase mt-3 flex items-center gap-1 hover:text-slate-900 transition">
                                                    Lihat Navigasi ↗
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <a href="?kuliner_id=<?= $kuliner_id ?>&hapus=<?= $t['id'] ?>" 
                                           onclick="return confirm('Hapus rekomendasi lokasi ini?')"
                                           class="inline-block border-2 border-slate-100 text-slate-300 hover:border-red-700 hover:text-red-700 transition px-4 py-2 font-black text-[9px] uppercase tracking-widest bg-white">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4 lg:hidden text-center">
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest italic">* Geser tabel jika data terpotong</p>
                </div>
            </div>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>

</body>
</html>