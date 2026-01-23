<?php
require_once 'config/database.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT budaya.*, provinsi.nama_provinsi 
          FROM budaya 
          LEFT JOIN provinsi ON budaya.asal_provinsi_id = provinsi.id 
          WHERE budaya.id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$b = $stmt->fetch();

if (!$b) { 
    echo "<script>location.href='budaya.php';</script>"; 
    exit; 
}

$query_terkait = "SELECT id, nama_budaya, foto FROM budaya 
                  WHERE asal_provinsi_id = ? AND id != ? 
                  ORDER BY RAND() LIMIT 3";
$stmt_terkait = $pdo->prepare($query_terkait);
$stmt_terkait->execute([$b['asal_provinsi_id'], $id]);
$budaya_terkait = $stmt_terkait->fetchAll();
?>

<main class="container mx-auto px-6 py-12">
    <nav class="flex text-[10px] uppercase tracking-[0.2em] text-slate-400 mb-12 font-bold">
        <a href="index.php" class="hover:text-red-700 transition">Beranda</a>
        <span class="mx-3 text-slate-200">/</span>
        <a href="budaya.php" class="hover:text-red-700 transition">Budaya</a>
        <span class="mx-3 text-slate-200">/</span>
        <span class="text-slate-900"><?= htmlspecialchars($b['nama_budaya']) ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
        <div class="lg:col-span-2">
            <div class="mb-4">
                <span class="bg-red-700 text-white px-4 py-1 text-[10px] font-black uppercase tracking-widest">
                    <?= $b['kategori_budaya'] ?>
                </span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black text-slate-900 mb-10 leading-[0.9] tracking-tighter uppercase italic">
                <?= htmlspecialchars($b['nama_budaya']) ?>
            </h1>
            
            <div class="relative mb-16">
                <div class="absolute -inset-4 bg-slate-100 -z-10 translate-x-2 translate-y-2"></div>
                <div class="overflow-hidden shadow-2xl">
                    <img src="assets/uploads/<?= $b['foto'] ?>" 
                         class="w-full h-[400px] md:h-[650px] object-cover hover:scale-105 transition duration-1000" 
                         alt="<?= htmlspecialchars($b['nama_budaya']) ?>">
                </div>
            </div>

            <div class="max-w-none">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-[2px] w-12 bg-red-700"></div>
                    <h3 class="text-xl font-black uppercase tracking-tighter text-slate-900 italic">Filosofi & Sejarah</h3>
                </div>
                
                <div class="text-slate-700 leading-relaxed text-lg space-y-6">
                    <p class="text-justify first-letter:text-5xl first-letter:font-black first-letter:text-red-700 first-letter:mr-3 first-letter:float-left">
                        <?= nl2br(htmlspecialchars($b['deskripsi'])) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-8">
                <div class="bg-slate-900 text-white p-10 border-t-8 border-red-700 shadow-2xl">
                    <h3 class="text-xs font-black uppercase tracking-[0.3em] mb-10 border-b border-white/10 pb-4 text-slate-400">Arsip Identitas</h3>
                    
                    <div class="space-y-10">
                        <div class="flex items-start gap-5">
                            <div class="bg-red-700/20 p-3 text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Provinsi Asal</p>
                                <p class="font-bold text-xl italic text-amber-500 uppercase"><?= $b['nama_provinsi'] ?></p>
                            </div>
                        </div>

                        <div class="flex items-start gap-5">
                            <div class="bg-red-700/20 p-3 text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Status Warisan</p>
                                <p class="font-bold text-xl uppercase italic">Aktif / Terjaga</p>
                            </div>
                        </div>
                    </div>

                    <button onclick="window.print()" class="w-full mt-12 bg-white text-slate-900 font-black uppercase tracking-widest py-4 text-[10px] hover:bg-red-700 hover:text-white transition duration-500">
                        Cetak Dokumentasi
                    </button>
                </div>

                <?php if($budaya_terkait): ?>
                <div class="p-2">
                    <h4 class="text-[10px] font-black uppercase tracking-widest mb-6 text-slate-400 italic">Budaya Lain di <?= $b['nama_provinsi'] ?></h4>
                    <div class="space-y-4">
                        <?php foreach($budaya_terkait as $bt): ?>
                        <a href="budaya_detail.php?id=<?= $bt['id'] ?>" class="flex items-center gap-4 group">
                            <div class="w-16 h-16 overflow-hidden bg-slate-200">
                                <img src="assets/uploads/<?= $bt['foto'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition">
                            </div>
                            <span class="text-xs font-black uppercase tracking-tighter group-hover:text-red-700 transition">
                                <?= htmlspecialchars($bt['nama_budaya']) ?>
                            </span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>