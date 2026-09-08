<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-BMN Dit PAUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-slate-800 border border-slate-700/80 rounded-2xl p-8 shadow-2xl">
        <div class="text-center mb-8">
            <div class="inline-flex bg-blue-600 p-3 rounded-xl text-white mb-3 shadow-lg shadow-blue-600/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-white">E-BMN PAUD</h1>
            <p class="text-xs text-slate-400 mt-1">Sistem Manajemen Inventaris BMN</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-lg text-xs text-center">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3 rounded-lg text-xs text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email Akses</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="block text-xs font-semibold text-slate-300">Password</label>
                    <a href="{{ route('password.request') }}" class="text-[11px] text-blue-400 hover:text-blue-300 transition-colors">Lupa kata sandi?</a>
                </div>
                <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs py-3 rounded-lg shadow-lg shadow-blue-600/20 transition-all mt-2">
                Masuk ke Sistem
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-700/60 text-[11px] text-slate-400 space-y-1.5">
            <div class="font-bold text-slate-300 mb-1">Akun Testing (Password: password):</div>
            <div>• <span class="text-blue-400 font-mono">pegawai@bmn.go.id</span> (Pegawai)</div>
            <div>• <span class="text-blue-400 font-mono">reviewer@bmn.go.id</span> (Reviewer)</div>
            <div>• <span class="text-blue-400 font-mono">approver@bmn.go.id</span> (Kasubag TU)</div>
        </div>
    </div>

</body>
</html>