<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Presensi Magang Bappeda DKI Jakarta</title>
    
    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CSS with Civic Horizon tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#00173b",
                        "primary-container": "#0f2c59",
                        "on-primary": "#ffffff",
                        "secondary": "#0051d5",
                        "secondary-container": "#316bf3",
                        "surface": "#f8f9ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "surface-container": "#e5eeff",
                        "surface-container-high": "#dce9ff",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#44474f",
                        "error": "#ba1a1a"
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-[#00173b] via-[#0f2c59] to-[#002b5c] font-sans antialiased text-on-surface">

    <div class="w-full max-w-md bg-white/95 backdrop-blur-xl rounded-3xl shadow-[0_20px_50px_rgba(0,23,59,0.4)] border border-white/20 p-6 sm:p-8 flex flex-col">
        <!-- Official Logo & Header -->
        <div class="flex flex-col items-center text-center mb-6">
            <div class="p-3 rounded-2xl bg-surface-container-low border border-surface-container shadow-sm mb-3">
                <img src="https://lh3.googleusercontent.com/aida/AEtjO1W7A9Imo7Xi_Uh1n3iggTZ9ftgey78SAPg2m122-AWd7EmojWULRjqzXBVRov7e1IQDq3_VOCIhVkSrrXOIH6kXW5Cgp81ig_arWvZY_L74uRqRd-4V_5F3lC5q8j1zHWa9ZufJgBhgNFnTFrKPGdsx9ct684zw41_hhG2n-GLGZhpWC3W1refg3EJAemkB5F60RYozPyTLBKFqRvu5DAcplUSv9n1NITBOdyF7PEPdHA" 
                     alt="Logo Bappeda DKI" 
                     class="h-10 w-auto object-contain"
                     onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/e/eb/Coat_of_arms_of_Jakarta.svg';">
            </div>
            <span class="px-2.5 py-0.5 rounded-full bg-surface-container text-secondary text-[11px] font-bold tracking-wider uppercase mb-1.5">
                Portal Magang 2026
            </span>
            <h1 class="font-bold text-xl text-primary leading-tight">
                Bappeda DKI Jakarta
            </h1>
            <p class="text-xs text-on-surface-variant mt-1">
                Sistem Presensi Elektronik Magang Balai Kota
            </p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-bold text-primary">Alamat Email Dinas / Akun</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[18px]">mail</span>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@presensi.com') }}" 
                           placeholder="nama@jakarta.go.id" required autofocus 
                           class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-surface-container bg-surface-container-low text-xs text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white transition-all">
                </div>
                @error('email')
                    <span class="text-[11px] font-semibold text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-bold text-primary">Kata Sandi (Password)</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[18px]">lock</span>
                    <input type="password" id="password" name="password" value="password123" 
                           placeholder="••••••••" required 
                           class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-surface-container bg-surface-container-low text-xs text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white transition-all">
                </div>
                @error('password')
                    <span class="text-[11px] font-semibold text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full mt-2 py-3 px-4 rounded-xl font-bold text-xs text-white bg-primary hover:bg-primary-container shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                <span>Masuk ke Sistem Presensi</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-200 text-center text-[11px] text-on-surface-variant">
            <span class="font-medium">Subbagian Kepegawaian & Tata Usaha</span>
            <p class="mt-0.5 text-[10px] text-outline">Bappeda Balai Kota Blok G Lantai 2, Jakarta Pusat</p>
        </div>
    </div>

</body>
</html>
