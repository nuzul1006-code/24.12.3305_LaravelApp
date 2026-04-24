<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. AKUN ADMIN
        \App\Models\User::create([
            'name'     => 'Admin Amikom',
            'email'    => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // 2. KATEGORI EVENT
        $katSeminar = \App\Models\Category::create([
            'name' => 'Seminar & Talkshow',
            'slug' => 'seminar-talkshow',
        ]);

        $katWorkshop = \App\Models\Category::create([
            'name' => 'Workshop & Pelatihan',
            'slug' => 'workshop-pelatihan',
        ]);

        $katHiburan = \App\Models\Category::create([
            'name' => 'Hiburan & Kompetisi',
            'slug' => 'hiburan-kompetisi',
        ]);

        // 3. DATA EVENTS

        // Event 1
        \App\Models\Event::create([
            'category_id' => $katSeminar->id,
            'title'       => 'Tech Future Talk: AI & Society',
            'description' => 'Seminar yang membahas perkembangan kecerdasan buatan dan dampaknya terhadap kehidupan serta dunia kerja di masa depan.',
            'date'        => '2026-06-10 09:00:00',
            'location'    => 'Auditorium Kampus',
            'price'       => 30000,
            'stock'       => 150,
            'poster_path' => 'assets/workshop.png',
        ]);

        // Event 2
        \App\Models\Event::create([
            'category_id' => $katSeminar->id,
            'title'       => 'Digital Marketing Trends 2026',
            'description' => 'Talkshow mengenai strategi pemasaran digital terbaru, termasuk social media dan content marketing.',
            'date'        => '2026-06-18 13:00:00',
            'location'    => 'Ruang Seminar',
            'price'       => 25000,
            'stock'       => 120,
            'poster_path' => 'assets/workshop.png',
        ]);

        // Event 3
        \App\Models\Event::create([
            'category_id' => $katWorkshop->id,
            'title'       => 'Workshop Laravel untuk Pemula',
            'description' => 'Pelatihan membuat aplikasi web menggunakan Laravel dari dasar hingga bisa membuat CRUD sederhana.',
            'date'        => '2026-07-05 08:00:00',
            'location'    => 'Lab Komputer Lt. 3',
            'price'       => 50000,
            'stock'       => 40,
            'poster_path' => 'assets/hackathon.png',
        ]);

        // Event 4
        \App\Models\Event::create([
            'category_id' => $katWorkshop->id,
            'title'       => 'UI Design with Figma',
            'description' => 'Workshop desain antarmuka menggunakan Figma, mulai dari wireframe hingga prototype interaktif.',
            'date'        => '2026-07-12 09:00:00',
            'location'    => 'Lab Desain Kreatif',
            'price'       => 60000,
            'stock'       => 35,
            'poster_path' => 'assets/workshop.png',
        ]);

        // Event 5
        \App\Models\Event::create([
            'category_id' => $katHiburan->id,
            'title'       => 'Campus Music Festival',
            'description' => 'Festival musik kampus yang menampilkan band mahasiswa dan guest star lokal.',
            'date'        => '2026-08-01 16:00:00',
            'location'    => 'Lapangan Kampus',
            'price'       => 75000,
            'stock'       => 200,
            'poster_path' => 'assets/concert.png',
        ]);

        // Event 6
        \App\Models\Event::create([
            'category_id' => $katHiburan->id,
            'title'       => 'Mobile Legends Campus Tournament',
            'description' => 'Turnamen e-sport antar mahasiswa dengan sistem tim dan hadiah menarik.',
            'date'        => '2026-08-15 08:00:00',
            'location'    => 'Cinema Kampus',
            'price'       => 20000,
            'stock'       => 100,
            'poster_path' => 'assets/hackathon.png',
        ]);

        // 4. SAMPLE TRANSAKSI
        \App\Models\Transaction::create([
            'event_id'       => 5,
            'order_id'       => 'TRX-99210',
            'customer_name'  => 'Pebri Kopong',
            'customer_email' => 'pebri34@gmail.com',
            'customer_phone' => '081234567890',
            'total_price'    => 80000,
            'status'         => 'Success',
            'snap_token'     => null,
        ]);

        \App\Models\Transaction::create([
            'event_id'       => 3,
            'order_id'       => 'TRX-99209',
            'customer_name'  => 'Wahyu Fadil',
            'customer_email' => 'wahyu34@gmail.com',
            'customer_phone' => '082345678901',
            'total_price'    => 55000,
            'status'         => 'Pending',
            'snap_token'     => null,
        ]);

        \App\Models\Transaction::create([
            'event_id'       => 6,
            'order_id'       => 'TRX-99208',
            'customer_name'  => 'Nuzul Kurniawan',
            'customer_email' => 'nuzul34@gmail.com',
            'customer_phone' => '083456789012',
            'total_price'    => 25000,
            'status'         => 'Success',
            'snap_token'     => null,
        ]);
    }
}