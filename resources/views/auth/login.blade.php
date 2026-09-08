<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-BMN Direktorat PAUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex bg-blue-600 p-3 rounded-2xl text-white shadow-lg shadow-blue-600/30 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">E-BMN Dit PAUD</h1>
            <p class="text-xs text-slate-400 mt-1">Sistem Informasi Pengelolaan Barang Milik Negara</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 p-8 rounded-2xl shadow-2xl">
            @if(session('error'))
                <div class="mb-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3 rounded-xl text-xs">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Alamat Email / NIP</label>
                    <input type="email" name="email" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="nama@kemdikbud.go.id" required autofocus>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Kata Sandi</label>
                    <input type="password" name="password" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('password.request') }}" class="text-[11px] font-medium text-blue-400 hover:text-blue-300 transition-colors">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-xl text-xs transition-all shadow-lg shadow-blue-600/25">
                    Masuk ke Sistem
                </button>
            </form>
        </div>

        <!-- Footer Notice -->
        <p class="text-center text-[11px] text-slate-500 mt-6">
            &copy; {{ date('Y') }} Direktorat PAUD - Kemendikbudristek RI
        </p>
    </div>
</body>
</html>