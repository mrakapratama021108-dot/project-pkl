<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - E-BMN Dit PAUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-white tracking-wide">Lupa Password</h1>
            <p class="text-xs text-slate-400 mt-1">Masukkan email terdaftar untuk menerima link reset password.</p>
        </div>

        @if(session('success'))
            <div class="mb-5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs p-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs p-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-medium text-slate-300 block mb-1">Email Akses</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs py-3 px-4 rounded-xl shadow-lg transition-all">
                Kirim Link Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-xs text-slate-400 hover:text-slate-200">← Kembali ke Halaman Login</a>
        </div>
    </div>

</body>
</html>