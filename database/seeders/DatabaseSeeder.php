<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseVideo;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin BuilderHub',
            'email' => 'admin@builderhub.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'city' => 'Jakarta',
            'bio' => 'Administrator Platform BuilderHub',
        ]);

        // Pelajar / Student (role: course)
        $student = User::create([
            'name' => 'Adit Saputra',
            'email' => 'student@builderhub.id',
            'password' => Hash::make('password'),
            'role' => 'course',
            'city' => 'Bandung',
            'expertise' => 'Web Development',
        ]);

        // Programmers
        $rizky = User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky@builderhub.id',
            'password' => Hash::make('password'),
            'role' => 'programmer',
            'phone' => '081234567890',
            'city' => 'Bandung',
            'bio' => 'Full Stack Developer dengan 5+ tahun pengalaman',
            'is_verified' => true,
            'is_top_programmer' => true,
            'rating' => 4.9,
            'total_projects' => 12,
            'total_earnings' => 48000000,
        ]);

        $dewi = User::create([
            'name' => 'Dewi Sartika',
            'email' => 'dewi@builderhub.id',
            'password' => Hash::make('password'),
            'role' => 'programmer',
            'phone' => '082345678901',
            'city' => 'Surabaya',
            'bio' => 'Mobile Developer spesialis Flutter',
            'is_verified' => true,
            'is_top_programmer' => false,
            'rating' => 4.6,
            'total_projects' => 7,
            'total_earnings' => 21000000,
        ]);

        // UMKM
        $budi = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@batik.id',
            'password' => Hash::make('password'),
            'role' => 'umkm',
            'phone' => '083456789012',
            'city' => 'Yogyakarta',
            'business_name' => 'Batik Nusantara Collection',
            'business_type' => 'Fashion & Kerajinan',
            'umkm_verified' => true,
            'legal_doc' => 'NIB-001234567',
        ]);

        $siti = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@warung.id',
            'password' => Hash::make('password'),
            'role' => 'umkm',
            'phone' => '084567890123',
            'city' => 'Jakarta',
            'business_name' => 'Warung Makan Bu Siti',
            'business_type' => 'Kuliner & Food',
            'umkm_verified' => true,
            'legal_doc' => 'SIUP-987654321',
        ]);

        // Portfolios
        Portfolio::create(['programmer_id' => $rizky->id, 'title' => 'Toko Online UMKM Batik', 'description' => 'Website toko online batik khas Yogyakarta dengan fitur lengkap', 'tags' => ['React', 'Laravel', 'MySQL']]);
        Portfolio::create(['programmer_id' => $rizky->id, 'title' => 'Sistem POS Warung', 'description' => 'Point of Sale untuk warung makan dengan tracking real-time', 'tags' => ['Vue.js', 'PHP', 'MySQL']]);
        Portfolio::create(['programmer_id' => $rizky->id, 'title' => 'Marketplace Kerajinan', 'description' => 'Multi-vendor marketplace kerajinan lokal Indonesia', 'tags' => ['Next.js', 'Node.js', 'PostgreSQL']]);

        // Certificates
        Certificate::create(['programmer_id' => $rizky->id, 'name' => 'Laravel Certified Developer', 'issuer' => 'Laravel', 'issue_date' => '2023-03-15']);
        Certificate::create(['programmer_id' => $rizky->id, 'name' => 'Google Professional Cloud Developer', 'issuer' => 'Google', 'issue_date' => '2022-09-01']);
        Certificate::create(['programmer_id' => $rizky->id, 'name' => 'React Certification', 'issuer' => 'Meta', 'issue_date' => '2021-07-20']);

        // Projects
        $project1 = Project::create([
            'umkm_id' => $budi->id,
            'title' => 'Marketplace Kerajinan Tangan Lokal',
            'description' => 'Platform multi-vendor untuk penjual kerajinan lokal. Fitur: registrasi penjual, upload produk, sistem pembayaran, chat penjual-pembeli.',
            'budget' => 8000000,
            'deadline' => '2025-04-01',
            'status' => 'pending',
            'category' => 'Marketplace',
            'tags' => ['Marketplace', 'Next.js', 'PostgreSQL', 'Stripe', 'Socket.io'],
            'platform_fee' => 6400000,
            'programmer_earning' => 1600000,
        ]);

        $project2 = Project::create([
            'umkm_id' => $budi->id,
            'title' => 'Website Toko Online Batik Nusantara',
            'description' => 'Membuat website toko online lengkap dengan fitur katalog produk, keranjang belanja, payment gateway Midtrans, dan dashboard admin.',
            'budget' => 5000000,
            'deadline' => '2025-03-01',
            'status' => 'open',
            'category' => 'E-Commerce',
            'tags' => ['E-Commerce', 'React', 'Laravel', 'MySQL', 'Midtrans API'],
            'platform_fee' => 4000000,
            'programmer_earning' => 1000000,
        ]);

        $project3 = Project::create([
            'umkm_id' => $siti->id,
            'title' => 'Aplikasi Pemesanan Warung Makan Online',
            'description' => 'Website pemesanan makanan online lengkap dengan menu digital, sistem order, notifikasi WhatsApp, dan tracking pesanan real-time.',
            'budget' => 3500000,
            'deadline' => '2025-02-15',
            'status' => 'in_progress',
            'category' => 'Kuliner & Food Tech',
            'tags' => ['Vue.js', 'Node.js', 'WhatsApp API', 'MongoDB'],
            'assigned_programmer_id' => $rizky->id,
            'platform_fee' => 2800000,
            'programmer_earning' => 700000,
        ]);

        $project4 = Project::create([
            'umkm_id' => $siti->id,
            'title' => 'Sistem Manajemen Inventori UMKM',
            'description' => 'Aplikasi web untuk mengelola stok barang, laporan penjualan harian, ekspor ke Excel, dan notifikasi stok menipis.',
            'budget' => 2500000,
            'deadline' => '2025-01-30',
            'status' => 'completed',
            'category' => 'Business Tools',
            'tags' => ['Business Tools', 'React', 'PHP', 'MySQL'],
            'assigned_programmer_id' => $rizky->id,
            'platform_fee' => 2000000,
            'programmer_earning' => 500000,
        ]);

        // Bids
        Bid::create([
            'project_id' => $project2->id,
            'programmer_id' => $rizky->id,
            'amount' => 5000000,
            'message' => 'Saya tertarik dengan project ini. Dengan pengalaman 5 tahun di Laravel & React, saya dapat menyelesaikannya dalam 4 minggu.',
            'timeline_days' => 30,
            'status' => 'pending',
        ]);

        Bid::create([
            'project_id' => $project2->id,
            'programmer_id' => $dewi->id,
            'amount' => 4800000,
            'message' => 'Project ini sesuai dengan portofolio saya. Bisa selesai dalam 35 hari.',
            'timeline_days' => 35,
            'status' => 'pending',
        ]);

        // Courses
        $course1 = Course::create([
            'instructor_id' => $rizky->id,
            'title' => 'Belajar React.js dari Nol',
            'description' => 'Mulai perjalanan coding Anda dari dasar HTML, CSS, JavaScript hingga React.js modern. Cocok untuk pemula.',
            'price' => 0,
            'level' => 'pemula',
            'category' => 'Frontend',
            'is_free' => true,
            'is_published' => true,
            'total_students' => 1284,
            'rating' => 4.8,
            'total_videos' => 9,
            'duration' => '9+ jam',
        ]);

        $course2 = Course::create([
            'instructor_id' => $dewi->id,
            'title' => 'Node.js & Express Backend Development',
            'description' => 'Pelajari cara membuat REST API profesional dengan Node.js, Express, dan PostgreSQL. Termasuk autentikasi JWT.',
            'price' => 149000,
            'level' => 'menengah',
            'category' => 'Backend',
            'is_free' => false,
            'is_published' => true,
            'total_students' => 876,
            'rating' => 4.7,
            'total_videos' => 6,
            'duration' => '7+ jam',
        ]);

        $course3 = Course::create([
            'instructor_id' => $rizky->id,
            'title' => 'Full Stack Web App: React + Laravel',
            'description' => 'Bangun aplikasi full-stack lengkap dari frontend React hingga backend Laravel. Project nyata: sistem manajemen UMKM.',
            'price' => 299000,
            'level' => 'mahir',
            'category' => 'Full Stack',
            'is_free' => false,
            'is_published' => true,
            'total_students' => 543,
            'rating' => 4.9,
            'total_videos' => 9,
            'duration' => '13+ jam',
        ]);

        $course4 = Course::create([
            'instructor_id' => $dewi->id,
            'title' => 'Flutter Mobile App untuk UMKM',
            'description' => 'Buat aplikasi mobile Android & iOS untuk bisnis UMKM menggunakan Flutter dari nol hingga deploy.',
            'price' => 199000,
            'level' => 'menengah',
            'category' => 'Mobile',
            'is_free' => false,
            'is_published' => true,
            'total_students' => 412,
            'rating' => 4.6,
            'total_videos' => 4,
            'duration' => '5+ jam',
        ]);

        // Course Videos for course1
        CourseVideo::create(['course_id' => $course1->id, 'title' => 'Pengenalan HTML & CSS Dasar', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'duration' => '45 menit', 'order' => 1]);
        CourseVideo::create(['course_id' => $course1->id, 'title' => 'JavaScript Fundamentals', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'duration' => '60 menit', 'order' => 2]);
        CourseVideo::create(['course_id' => $course1->id, 'title' => 'Pengenalan React.js', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'duration' => '55 menit', 'order' => 3]);

        // Enrollments
        CourseEnrollment::create(['course_id' => $course1->id, 'user_id' => $student->id, 'amount_paid' => 0, 'status' => 'active']);
        CourseEnrollment::create(['course_id' => $course3->id, 'user_id' => $student->id, 'amount_paid' => 299000, 'status' => 'active']);
    }
}
