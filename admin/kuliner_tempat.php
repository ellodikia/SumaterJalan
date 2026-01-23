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

if (isset($_POST['tambah_tempat'])) {
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $link_maps = $_POST['link_maps'];

    $sql = "INSERT INTO kuliner_tempat (kuliner_id, nama_toko, alamat, link_maps) VALUES (?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$kuliner_id, $nama_toko, $alamat, $link_maps]);
    header("Location: kuliner_tempat.php?kuliner_id=$kuliner_id");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_tempat = $_GET['hapus'];
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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelola Lokasi - <?= $kuliner['nama_kuliner'] ?></title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-6 max-w-5xl">
        <div class="mt-10 mb-8 flex justify-between items-center">
            <div>
                <a href="kuliner_kelola.php" class="text-xs font-black uppercase text-red-700 hover:underline">← Kembali ke Database</a>
                <h2 class="text-3xl font-black uppercase tracking-tighter text-slate-900 mt-2">
                    Lokasi <span class="text-red-700"><?= $kuliner['nama_kuliner'] ?></span>
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-1">
                <div class="bg-white p-6 shadow-xl border-t-4 border-slate-900">
                    <h3 class="text-sm font-black uppercase tracking-widest mb-6">Tambah Rekomendasi</h3>
                    <form action="" method="POST" class="space-y-4">
                        <input type="hidden" name="tambah_tempat" value="1">
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase text-slate-400">Nama Toko/Warung</label>
                            <input type="text" name="nama_toko" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 font-bold text-sm" placeholder="Contoh: RM Sederhana" required>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase text-slate-400">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 text-sm" placeholder="Jl. Sudirman No. 12..."></textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase text-slate-400">Link Google Maps (URL)</label>
                            <input type="url" name="link_maps" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 text-sm" placeholder="https://maps.google.com/...">
                        </div>

                        <button type="submit" class="w-full bg-red-700 text-white py-3 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition mt-4">
                            Simpan Lokasi
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white shadow-xl overflow-hidden border-t-4 border-red-700">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="p-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Detail Lokasi</th>
                                <th class="p-4 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(empty($daftar_tempat)): ?>
                                <tr>
                                    <td colspan="2" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada lokasi untuk menu ini.</td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($daftar_tempat as $t): ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4">
                                    <h4 class="font-black text-slate-800 uppercase text-sm"><?= htmlspecialchars($t['nama_toko']) ?></h4>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed"><?= htmlspecialchars($t['alamat']) ?></p>
                                    <?php if($t['link_maps']): ?>
                                        <a href="<?= $t['link_maps'] ?>" target="_blank" class="text-[9px] text-blue-600 font-bold uppercase mt-2 inline-block hover:underline">Buka di Maps ↗</a>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="?kuliner_id=<?= $kuliner_id ?>&hapus=<?= $t['id'] ?>" 
                                       onclick="return confirm('Hapus lokasi ini?')"
                                       class="text-red-700 hover:text-slate-900 transition font-black text-[10px] uppercase">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>