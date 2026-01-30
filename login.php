<?php
session_start();
require_once 'config/database.php'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['nama'];
        
        header("Location: admin/lokasi_kelola.php");
        exit;
    } else {
        $error = 'Akses Ditolak: Kredensial tidak valid.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="for_sumaterajalan/logo.png" type="image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Admin - SumateraJalan</title>
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-10">
            <div class="bg-red-700 p-3 rotate-45 mb-4 shadow-2xl shadow-red-900/40">
                <svg class="w-8 h-8 text-white -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black uppercase tracking-tighter text-white leading-none">
                Sumatera<span class="text-amber-500">Jalan</span>
            </h1>
            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.5em] mt-2">Administrator Control Center</p>
        </div>

        <div class="bg-white p-8 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-t-8 border-red-700 relative">
            <div class="mb-8">
                <h2 class="text-2xl font-black uppercase tracking-tight text-slate-900 leading-none">Authentication</h2>
                <div class="h-1 w-12 bg-amber-500 mt-2"></div>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-50 text-red-700 p-4 mb-6 text-[10px] font-black uppercase tracking-widest border-l-4 border-red-700 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Username</label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 transition font-bold text-slate-800 placeholder-slate-300"
                           placeholder="Masukkan ID Admin">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 transition font-bold text-slate-800 placeholder-slate-300"
                           placeholder="••••••••">
                </div>

                <div class="flex flex-col gap-3 pt-4">
                    <button type="submit" 
                            class="w-full bg-slate-900 text-white py-5 font-black uppercase tracking-[0.2em] text-xs hover:bg-red-700 transition duration-500 shadow-xl">
                        Masuk ke Dashboard
                    </button>
                    
                    <div class="flex items-center gap-2">
                        <a href="index.php" 
                           class="flex-1 text-center border-2 border-slate-100 text-slate-400 py-3 font-black uppercase tracking-[0.2em] text-[9px] hover:text-slate-900 hover:border-slate-900 transition duration-300 flex items-center justify-center gap-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Beranda
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-10 text-center">
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.3em]">
                &copy; 2026 SumateraJalan • Secure System
            </p>
        </div>
    </div>

</body>
</html>