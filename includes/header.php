<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="for_sumaterajalan/logo.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SumateraJalan</title>
    <meta name="description" content="Eksplorasi Tak Terbatas di Pulau Emas. Destinasi, Kuliner, dan Budaya Sumatera Terlengkap.">
    <meta name="keywords" content="SumateraJalan, wisata sumatera, destinasi sumatera, kuliner khas sumatera, budaya sumatera, swarnadwipa">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .nav-custom {
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
        }

        #mobile-menu {
            transition: all 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            pointer-events: none; 
        }
        #mobile-menu.open {
            max-height: 500px; 
            opacity: 1;
            pointer-events: auto;
            border-bottom: 1px solid rgba(255,255,255,0.1);
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
            
            <div class="flex items-center space-x-4">
                <a href="login.php" class="hidden md:block text-[10px] font-black uppercase tracking-widest text-white border border-red-700 px-6 py-2.5 rounded-none hover:bg-red-700 transition">
                    Admin Panel
                </a>

                <button id="menu-btn" class="md:hidden text-white focus:outline-none p-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden bg-neutral-900 px-6">
            <div class="flex flex-col space-y-4 py-6 font-bold text-xs uppercase tracking-widest">
                <a href="index.php" class="<?= ($current_page == 'index.php') ? 'text-amber-500' : 'text-slate-300' ?>">
                    Beranda
                </a>
                <a href="eksplor.php" class="<?= ($current_page == 'eksplor.php' || $current_page == 'detail.php') ? 'text-amber-500' : 'text-slate-300' ?>">
                    Destinasi
                </a>
                <a href="kuliner.php" class="<?= ($current_page == 'kuliner.php') ? 'text-amber-500' : 'text-slate-300' ?>">
                    Kuliner
                </a>
                <a href="budaya.php" class="<?= ($current_page == 'budaya.php') ? 'text-amber-500' : 'text-slate-300' ?>">
                    Budaya
                </a>
                <hr class="border-white/10">
                <a href="login.php" class="text-red-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Admin Panel
                </a>
            </div>
        </div>
    </nav>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        menuBtn.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('open');
            
            if (isOpen) {
                    menuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            } else {
                menuIcon.setAttribute('d', 'M4 6h16M4 12h16m-7 6h7');
            }
        });
    </script>
</body>
</html>