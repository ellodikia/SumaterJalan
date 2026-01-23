<?php
require_once 'config/database.php';
include 'includes/header.php';

$filter   = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$halal    = isset($_GET['halal']) ? $_GET['halal'] : '';
$keyword  = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT kuliner.*, provinsi.nama_provinsi 
          FROM kuliner 
          LEFT JOIN provinsi ON kuliner.asal_provinsi_id = provinsi.id 
          WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $query .= " AND kuliner.nama_kuliner LIKE :keyword";
    $params['keyword'] = "%$keyword%";
}
if ($filter !== '') {
    $query .= " AND kuliner.kategori_kuliner = :kategori";
    $params['kategori'] = $filter;
}
if ($halal !== '') {
    $query .= " AND kuliner.status_halal = :halal";
    $params['halal'] = $halal;
}

$query .= " ORDER BY kuliner.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$kuliners = $stmt->fetchAll();
?>

<main class="bg-white min-h-screen pb-20">
    <section class="bg-slate-900 py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/batik-fractal.png')]"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4">
                Cita Rasa <span class="text-red-700">Sumatera</span>
            </h1>
            <p class="text-slate-400 font-bold uppercase tracking-[0.4em] text-xs border-l-4 border-red-700 pl-4">
                Jelajah Kuliner Warisan Swarnadwipa
            </p>
        </div>
    </section>

    <section class="sticky top-0 z-40 bg-white border-b border-slate-100 shadow-sm">
        <div class="container mx-auto px-6 py-6">
            <form action="" method="GET" class="flex flex-col lg:flex-row gap-4 items-end">
                <div class="w-full lg:flex-1 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Cari Kuliner</label>
                    <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>" placeholder="Contoh: Rendang, Pempek..." 
                           class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 font-bold uppercase text-[10px] tracking-widest transition">
                </div>

                <div class="w-full lg:w-64 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Kategori</label>
                    <select name="kategori" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none font-bold uppercase text-[10px] tracking-widest cursor-pointer focus:border-red-700 transition">
                        <option value="">Semua Kategori</option>
                        <?php $cats = ['Makanan Berat', 'Camilan', 'Minuman']; 
                        foreach($cats as $c): ?>
                            <option value="<?= $c ?>" <?= $filter == $c ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="w-full lg:w-48 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Status Halal</label>
                    <select name="halal" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none font-bold uppercase text-[10px] tracking-widest cursor-pointer focus:border-red-700 transition">
                        <option value="">Semua</option>
                        <option value="Halal" <?= $halal == 'Halal' ? 'selected' : '' ?>>Halal</option>
                        <option value="Non-Halal" <?= $halal == 'Non-Halal' ? 'selected' : '' ?>>Non-Halal</option>
                    </select>
                </div>

                <button type="submit" class="w-full lg:w-auto bg-red-700 text-white px-10 py-3.5 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition">
                    Terapkan
                </button>
            </form>
        </div>
    </section>

    <section class="container mx-auto px-6 py-16">
        <?php if (empty($kuliners)): ?>
            <div class="py-32 text-center border-4 border-dashed border-slate-50">
                <p class="text-slate-300 font-black uppercase tracking-[0.5em] text-sm italic">Arsip Tidak Ditemukan</p>
                <a href="kuliner.php" class="inline-block mt-8 text-red-700 font-black border-b-2 border-red-700 pb-1 uppercase text-[10px] tracking-widest hover:text-slate-900 transition">Reset Filter</a>
            </div>
        <?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
    <?php foreach ($kuliners as $k): ?>
        <article class="group flex flex-col h-full">
            <div class="relative aspect-square overflow-hidden mb-6 bg-slate-100 shadow-sm">
                <div class="absolute top-0 left-0 z-20 flex flex-col">
                    <span class="bg-red-700 text-white text-[8px] font-black uppercase px-3 py-2 tracking-widest">
                        <?= $k['kategori_kuliner'] ?>
                    </span>
                    <span class="<?= $k['status_halal'] == 'Halal' ? 'bg-emerald-600' : 'bg-slate-900' ?> text-white text-[8px] font-black uppercase px-3 py-2 tracking-widest">
                        <?= $k['status_halal'] ?>
                    </span>
                </div>
                <img src="assets/uploads/<?= $k['foto'] ?>" 
                     class="w-full h-full object-cover transition duration-1000 group-hover:scale-110" 
                     alt="<?= $k['nama_kuliner'] ?>">
                <a href="kuliner_detail.php?id=<?= $k['id'] ?>" class="absolute inset-0 z-30"></a>
            </div>
            <div class="space-y-4 flex flex-col flex-grow">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600"><?= $k['nama_provinsi'] ?></span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tighter text-slate-900 leading-tight group-hover:text-red-700 transition duration-300">
                    <?= $k['nama_kuliner'] ?>
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-6 font-light line-clamp-3 italic flex-grow">
                    <?= strip_tags($k['deskripsi']) ?>
                </p>
                <div class="pt-4 border-t border-slate-50">
                    <a href="kuliner_detail.php?id=<?= $k['id'] ?>" class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-900 border-b-2 border-red-700 pb-1 hover:text-red-700 transition">
                        Eksplorasi Rasa →
                    </a>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>
        <?php endif; ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>