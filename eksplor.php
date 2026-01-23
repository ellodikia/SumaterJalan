<?php
require_once 'config/database.php';

$all_provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();
$all_kategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC")->fetchAll();

$filter_provinsi = isset($_GET['provinsi']) ? $_GET['provinsi'] : '';
$filter_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$sql = "SELECT lokasi.*, provinsi.nama_provinsi, kategori.nama_kategori 
        FROM lokasi 
        JOIN provinsi ON lokasi.provinsi_id = provinsi.id 
        JOIN kategori ON lokasi.kategori_id = kategori.id 
        WHERE 1=1"; 
$params = [];

if (!empty($filter_provinsi)) {
    $sql .= " AND lokasi.provinsi_id = ?";
    $params[] = $filter_provinsi;
}
if (!empty($filter_kategori)) {
    $sql .= " AND lokasi.kategori_id = ?";
    $params[] = $filter_kategori;
}

$sql .= " ORDER BY lokasi.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$locations = $stmt->fetchAll();

include 'includes/header.php';
?>

<main class="bg-white min-h-screen pb-20">
    <section class="bg-slate-900 py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/batik-fractal.png')]"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4">
                Eksplorasi <span class="text-red-700">Sumatera</span>
            </h1>
            <p class="text-slate-400 font-bold uppercase tracking-[0.4em] text-xs border-l-4 border-red-700 pl-4">
                Temukan Keajaiban di Setiap Sudut Swarnadwipa
            </p>
        </div>
    </section>

    <section class="sticky top-0 z-40 bg-white border-b border-slate-100 shadow-sm">
        <div class="container mx-auto px-6 py-6">
            <form action="" method="GET" class="flex flex-col lg:flex-row gap-4 items-end">
                <div class="w-full lg:flex-1 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Wilayah Provinsi</label>
                    <select name="provinsi" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 font-bold uppercase tracking-widest text-[10px] transition cursor-pointer">
                        <option value="">Seluruh Sumatera</option>
                        <?php foreach($all_provinsi as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= ($filter_provinsi == $p['id']) ? 'selected' : '' ?>>
                                <?= $p['nama_provinsi'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="w-full lg:flex-1 space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Jenis Wisata</label>
                    <select name="kategori" class="w-full p-3 bg-slate-50 border border-slate-200 outline-none focus:border-red-700 font-bold uppercase tracking-widest text-[10px] transition cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <?php foreach($all_kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= ($filter_kategori == $k['id']) ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="w-full lg:w-auto bg-red-700 text-white px-10 py-3.5 font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 transition">
                    Terapkan
                </button>
                
                <?php if(!empty($filter_provinsi) || !empty($filter_kategori)): ?>
                    <a href="eksplor.php" class="w-full lg:w-auto text-center bg-slate-100 text-slate-400 px-6 py-3.5 font-black uppercase tracking-widest text-[10px] hover:text-red-700 transition">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </section>

    <section class="container mx-auto px-6 py-16">
        <?php if(empty($locations)): ?>
            <div class="text-center py-32 border-4 border-dashed border-slate-50">
                <p class="text-slate-300 font-black uppercase tracking-[0.5em] text-sm italic">Jejak Destinasi Tidak Ditemukan</p>
                <a href="eksplor.php" class="inline-block mt-8 text-red-700 font-black border-b-2 border-red-700 pb-1 uppercase text-[10px] tracking-widest hover:text-slate-900 transition">Tampilkan Semua</a>
            </div>
        <?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
    <?php foreach($locations as $loc): ?>
        <article class="group flex flex-col h-full">
            <div class="relative aspect-square overflow-hidden mb-6 bg-slate-100 shadow-sm">
                <div class="absolute top-0 left-0 z-20">
                    <span class="bg-red-700 text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest inline-block">
                        <?= $loc['nama_kategori'] ?>
                    </span>
                </div>
                <img src="assets/uploads/<?= $loc['foto_utama'] ?>" 
                     class="w-full h-full object-cover transition duration-1000 group-hover:scale-110" 
                     alt="<?= $loc['nama_tempat'] ?>">
                <a href="detail.php?slug=<?= $loc['slug'] ?>" class="absolute inset-0 z-30"></a>
            </div>
            <div class="space-y-4 flex flex-col flex-grow">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600"><?= $loc['nama_provinsi'] ?></span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tighter text-slate-900 leading-tight group-hover:text-red-700 transition duration-300">
                    <?= $loc['nama_tempat'] ?>
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 font-light italic flex-grow">
                    "<?= strip_tags($loc['deskripsi']) ?>"
                </p>
                <div class="pt-4 border-t border-slate-50">
                    <a href="detail.php?slug=<?= $loc['slug'] ?>" class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-900 border-b-2 border-red-700 pb-1 hover:text-red-700 transition">
                        Lihat Jejak Selengkapnya →
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