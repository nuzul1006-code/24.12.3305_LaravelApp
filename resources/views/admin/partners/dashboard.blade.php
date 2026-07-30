<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Organizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Organizer: {{ auth()->user()->partner->name }}</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Ke Beranda</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white p-3 shadow-sm">
                <h5>Total Event Diselenggarakan</h5>
                <h3>{{ $totalEvents }} Event</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white p-3 shadow-sm">
                <h5>Total Analitik Pendapatan</h5>
                <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Event Saya</h5>
            {{-- Tombol Tambah Event --}}
            <a href="#" class="btn btn-sm btn-primary">+ Buat Event Baru</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Event</th>
                        <th>Tanggal</th>
                        <th>Harga Tiket</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->date ? $event->date->format('d M Y, H:i') : '-' }}</td>
                        <td>Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                        <td>{{ $event->stock }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada event yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>