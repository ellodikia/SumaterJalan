<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SumateraJalan - Jelajahi Keindahan Swarnadwipa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .nav-custom {
            background: rgba(26, 26, 26, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-50">
    <nav class="nav-custom sticky top-0 z-50 border-b border-white/10 text-white">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-black tracking-tighter uppercase">
                Sumatera<span class="text-amber-500">Jalan</span>
            </a>
            
            <div class="hidden md:flex space-x-8 font-bold text-xs uppercase tracking-widest">
                <a href="index.php" class="<?= ($current_page == 'index.php') ? 'text-amber-500 border-b-2 border-amber-500 pb-1' : 'hover:text-amber-500 transition' ?>">
                    Beranda
                </a>
                <a href="eksplor.php" class="<?= ($current_page == 'eksplor.php' || $current_page == 'detail.php' || $current_page == 'pencarian.php') ? 'text-amber-500 border-b-2 border-amber-500 pb-1' : 'hover:text-amber-500 transition' ?>">
                    Destinasi
                </a>
                <a href="kuliner.php" class="<?= ($current_page == 'kuliner.php') ? 'text-amber-500 border-b-2 border-amber-500 pb-1' : 'hover:text-amber-500 transition' ?>">
                    Kuliner
                </a>
                <a href="budaya.php" class="<?= ($current_page == 'budaya.php') ? 'text-amber-500 border-b-2 border-amber-500 pb-1' : 'hover:text-amber-500 transition' ?>">
                    Budaya
                </a>
            </div>
            
            <a href="admin/lokasi_kelola.php" class="text-[10px] font-black uppercase tracking-widest text-white border border-red-700 px-6 py-2.5 rounded-none hover:bg-red-700 transition">
                Admin Panel
            </a>
        </div>
    </nav>