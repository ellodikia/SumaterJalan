<?php
require_once 'config/database.php';
include 'includes/header.php';

$provinsi_list = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();
$filter_provinsi = isset($_GET['provinsi']) ? (int)$_GET['provinsi'] : 0;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$filter_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$query_str = "SELECT budaya.*, provinsi.nama_provinsi 
              FROM budaya 
              JOIN provinsi ON budaya.asal_provinsi_id = provinsi.id 
              WHERE 1=1";
$params = [];

if ($filter_provinsi > 0) {
    $query_str .= " AND budaya.asal_provinsi_id = ?";
    $params[] = $filter_provinsi;
}
if ($search !== '') {
    $query_str .= " AND (budaya.nama_budaya LIKE ? OR budaya.deskripsi LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($filter_kategori !== '') {
    $query_str .= " AND budaya.kategori_budaya = ?";
    $params[] = $filter_kategori;
}

$query_str .= " ORDER BY budaya.id DESC";
$stmt = $pdo->prepare($query_str);
$stmt->execute($params);
$budaya = $stmt->fetchAll();
?>

<main class="bg-white min-h-screen pb-20">
    <section class="bg-slate-900 py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/batik-fractal.png')]"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4">
                Warisan <span class="text-red-700">Budaya</span>
            </h1>
            <p class="text-slate-400 font-bold uppercase tracking-[0.4em] text-xs border-l-4 border-red-700 pl-4">
                Menelusuri Jejak Peradaban Tanah Sumatera
            </p>
        </div>
    </section>

    <section class="sticky top-0 z-40 bg-white border-b border-slate-100 shadow-sm">
        <div class="container mx-auto px-6 py-6">
            <form action="" method="GET" class="flex flex-col lg:flex-row gap-4 items-end">
                <div class="w-full lg:flex-1 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Cari Budaya</label>
                    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Contoh: Tari Piring..." 
                           class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 font-bold uppercase text-[10px] tracking-widest transition">
                </div>

                <div class="w-full lg:w-64 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Kategori</label>
                    <select name="kategori" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none font-bold uppercase text-[10px] tracking-widest cursor-pointer focus:border-red-700 transition">
                        <option value="">Semua Kategori</option>
                        <?php $cats = ['Tarian', 'Upacara Adat', 'Alat Musik', 'Pakaian Adat']; 
                        foreach($cats as $c): ?>
                            <option value="<?= $c ?>" <?= $filter_kategori == $c ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="w-full lg:w-64 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Wilayah</label>
                    <select name="provinsi" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none font-bold uppercase text-[10px] tracking-widest cursor-pointer focus:border-red-700 transition">
                        <option value="0">Semua Wilayah</option>
                        <?php foreach($provinsi_list as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $filter_provinsi == $p['id'] ? 'selected' : '' ?>><?= $p['nama_provinsi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="w-full lg:w-auto bg-red-700 text-white px-10 py-3.5 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition">
                    Terapkan
                </button>
            </form>
        </div>
    </section>

    <section class="container mx-auto px-6 py-16">
        <?php if(empty($budaya)): ?>
            <div class="text-center py-32 border-4 border-dashed border-slate-50">
                <p class="text-slate-300 font-black uppercase tracking-[0.5em] text-sm italic">Data tidak ditemukan</p>
                <a href="budaya.php" class="inline-block mt-8 text-red-700 font-black border-b-2 border-red-700 pb-1 uppercase text-[10px] tracking-widest hover:text-slate-900 transition">Reset Filter</a>
            </div>
        <?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
    <?php foreach($budaya as $b): ?>
        <article class="group flex flex-col h-full">
            <div class="relative aspect-square overflow-hidden mb-6 bg-slate-100 shadow-sm">
                <div class="absolute top-0 left-0 z-20">
                    <span class="bg-red-700 text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest inline-block">
                        <?= $b['kategori_budaya'] ?>
                    </span>
                </div>
                <img src="assets/uploads/<?= $b['foto'] ?>" 
                     class="w-full h-full object-cover transition duration-1000 group-hover:scale-110" 
                     alt="<?= $b['nama_budaya'] ?>">
                <a href="budaya_detail.php?id=<?= $b['id'] ?>" class="absolute inset-0 z-30"></a>
            </div>
            <div class="space-y-4 flex flex-col flex-grow">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600"><?= $b['nama_provinsi'] ?></span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tighter text-slate-900 leading-tight group-hover:text-red-700 transition duration-300">
                    <?= $b['nama_budaya'] ?>
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 font-light italic flex-grow">
                    <?= mb_strimwidth(strip_tags($b['deskripsi']), 0, 150, "...") ?>
                </p>
                <div class="pt-4 border-t border-slate-50">
                    <a href="budaya_detail.php?id=<?= $b['id'] ?>" class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-900 border-b-2 border-red-700 pb-1 hover:text-red-700 transition">
                        Baca Narasi →
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