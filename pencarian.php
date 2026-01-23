<?php
require_once 'config/database.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$query = "SELECT lokasi.*, provinsi.nama_provinsi, kategori.nama_kategori 
          FROM lokasi 
          JOIN provinsi ON lokasi.provinsi_id = provinsi.id 
          JOIN kategori ON lokasi.kategori_id = kategori.id 
          WHERE lokasi.nama_tempat LIKE ? 
          OR lokasi.deskripsi LIKE ? 
          OR provinsi.nama_provinsi LIKE ?
          ORDER BY lokasi.id DESC";

$stmt = $pdo->prepare($query);
$searchTerm = "%$keyword%";
$stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
$results = $stmt->fetchAll();

include 'includes/header.php';
?>

<main class="container mx-auto px-6 py-20">
    <div class="mb-16 border-l-8 border-red-700 pl-6">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 uppercase tracking-tighter">
            Jejak Pencarian: <span class="text-red-700">"<?= htmlspecialchars($keyword) ?>"</span>
        </h1>
        <p class="text-slate-500 mt-2 font-bold uppercase tracking-[0.3em] text-xs">Ditemukan <?= count($results) ?> lokasi di tanah Swarnadwipa</p>
    </div>

    <?php if (empty($results)): ?>
        <div class="text-center py-24 bg-white border-b-4 border-red-700 shadow-xl">
            <div class="inline-block p-8 bg-slate-50 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-4">Pencarian Tidak Membuahkan Hasil</h2>
            <p class="text-slate-500 max-w-md mx-auto leading-relaxed mb-10">Maaf, kami tidak menemukan lokasi yang sesuai dengan kata kunci tersebut. Cobalah mencari dengan nama provinsi atau kategori wisata.</p>
            <a href="index.php" class="inline-block bg-slate-900 text-white px-10 py-4 font-black uppercase tracking-widest text-[10px] hover:bg-red-700 transition">Kembali Ke Gerbang Utama</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <?php foreach ($results as $loc): ?>
                <div class="group bg-white border-b-4 border-red-700 shadow-lg hover:shadow-2xl transition-all flex flex-col h-full transform hover:-translate-y-2 duration-500">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="assets/uploads/<?= $loc['foto_utama'] ?>" class="w-full h-full object-cover grayscale-[40%] group-hover:grayscale-0 group-hover:scale-110 transition duration-700" alt="<?= $loc['nama_tempat'] ?>">
                        <div class="absolute top-0 left-0 bg-amber-500 text-black px-4 py-2 text-[10px] font-black uppercase tracking-widest shadow-md">
                            <?= $loc['nama_kategori'] ?>
                        </div>
                    </div>
                    
                    <div class="p-8 flex flex-col flex-1">
                        <h3 class="text-2xl font-black mb-4 text-slate-900 group-hover:text-red-700 transition tracking-tight uppercase leading-none">
                            <?= $loc['nama_tempat'] ?>
                        </h3>
                        <p class="text-slate-500 text-sm mb-8 line-clamp-2 leading-relaxed italic font-light">
                            <?= $loc['deskripsi'] ?>
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <?= $loc['nama_provinsi'] ?>
                            </span>
                            <a href="detail.php?slug=<?= $loc['slug'] ?>" class="text-[11px] font-black border-b-2 border-amber-500 pb-1 text-slate-900 hover:text-red-700 transition uppercase tracking-[0.15em]">
                                Lihat Jejak →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>