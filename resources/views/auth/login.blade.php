<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-indigo-900 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full">

        {{-- Logo & Title --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center text-indigo-600 font-black text-3xl mx-auto mb-4 shadow-2xl">
                AH
            </div>
            <h1 class="text-3xl font-black">Admin Login</h1>
            <p class="text-indigo-300 mt-2">AmikomEventHub Dashboard</p>
        </div>

        {{-- Card --}}
        <div class="bg-white text-slate-900 rounded-[2rem] p-8 shadow-2xl">

            {{-- Flash Error --}}
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 font-bold text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation Error --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 font-bold text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="admin@amikom.ac.id"
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                        Password
                    </label>
                    <input type="password" name="password"
                        placeholder="••••••••"
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                        required>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition">
                    Masuk ke Dashboard
                </button>

            </form>

            <p class="text-center text-xs text-slate-400 mt-6">
                Akses hanya untuk Admin Penyelenggara
            </p>
        </div>

        <p class="text-center text-indigo-400 text-sm mt-6">
            <a href="{{ route('home') }}" class="hover:text-white transition">← Kembali ke Beranda</a>
        </p>
    </div>

</body>
</html>