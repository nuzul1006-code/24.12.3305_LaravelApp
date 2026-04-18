<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Hub</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- ===== NAVBAR ===== -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">EventHub</h1>

            <div class="space-x-4">
                <a href="/" class="text-gray-600 hover:text-blue-500">Home</a>
                <a href="/profil" class="text-gray-600 hover:text-blue-500">Profil</a>
                <a href="/katalog" class="text-gray-600 hover:text-blue-500">Katalog</a>
                <a href="/bantuan" class="text-gray-600 hover:text-blue-500">Bantuan</a>
                <a href="/kontak" class="text-gray-600 hover:text-blue-500">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- ===== CONTENT (DINAMIS) ===== -->
    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-white border-t mt-10">
        <div class="container mx-auto px-6 py-4 text-center text-gray-500">
            © {{ date('Y') }} EventHub. All rights reserved.
        </div>
    </footer>

</body>
</html>