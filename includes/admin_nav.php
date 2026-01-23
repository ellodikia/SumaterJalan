<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="bg-slate-900 text-white p-6 mb-10 flex justify-between items-center shadow-2xl">
    <div class="flex items-center gap-8">
        <a href="../index.php" class="text-xl font-black uppercase tracking-tighter border-r border-white/20 pr-8">
            Sumatera<span class="text-amber-500">Jalan</span> <span class="text-xs font-light lowercase text-slate-400">admin</span>
        </a>
        <div class="flex gap-6 text-[10px] font-black uppercase tracking-widest">
            <a href="lokasi_kelola.php" 
               class="<?= (strpos($current_page, 'lokasi') !== false) ? 'text-amber-500 underline underline-offset-8' : 'hover:text-amber-500 transition' ?>">
               Kelola Lokasi
            </a>

            <a href="kuliner_kelola.php" 
               class="<?= (strpos($current_page, 'kuliner') !== false) ? 'text-amber-500 underline underline-offset-8' : 'hover:text-amber-500 transition' ?>">
               Kelola Kuliner
            </a>
            <a href="budaya_kelola.php" 
               class="<?= (strpos($current_page, 'budaya') !== false) ? 'text-amber-500 underline underline-offset-8' : 'hover:text-amber-500 transition' ?>">
               Kelola Budaya
            </a>
        </div>
    </div>
    <a href="../index.php" class="text-[10px] font-black uppercase tracking-widest bg-white/10 px-4 py-2 hover:bg-red-700 transition">
        Lihat Situs
    </a>
</nav>