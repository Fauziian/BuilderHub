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
        $admin = User::firstOrCreate(
            ['email' => 'admin@builderhub.id'],
            [
                'name' => 'Admin BuilderHub',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'city' => 'Jakarta',
                'bio' => 'Administrator Platform BuilderHub',
            ]
        );

        // Pelajar / Student (role: course)
        $student = User::firstOrCreate(
            ['email' => 'student@builderhub.id'],
            [
                'name' => 'Adit Saputra',
                'password' => Hash::make('password'),
                'role' => 'course',
                'city' => 'Bandung',
                'expertise' => 'Web Development',
            ]
        );

        // Programmers
        $rizky = User::firstOrCreate(
            ['email' => 'rizky@builderhub.id'],
            [
                'name' => 'Rizky Pratama',
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
            ]
        );

        $dewi = User::firstOrCreate(
            ['email' => 'dewi@builderhub.id'],
            [
                'name' => 'Dewi Sartika',
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
            ]
        );

        // UMKM
        $budi = User::firstOrCreate(
            ['email' => 'budi@batik.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'umkm',
                'phone' => '083456789012',
                'city' => 'Yogyakarta',
                'business_name' => 'Batik Nusantara Collection',
                'business_type' => 'Fashion & Kerajinan',
                'umkm_verified' => true,
                'legal_doc' => 'NIB-001234567',
            ]
        );

        $siti = User::firstOrCreate(
            ['email' => 'siti@warung.id'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'role' => 'umkm',
                'phone' => '084567890123',
                'city' => 'Jakarta',
                'business_name' => 'Warung Makan Bu Siti',
                'business_type' => 'Kuliner & Food',
                'umkm_verified' => true,
                'legal_doc' => 'SIUP-987654321',
            ]
        );

        // New Users for Rifqi
        $rifqiProgrammer = User::firstOrCreate(
            ['email' => 'rifqiprogrammer@gmail.com'],
            [
                'name' => 'rifqiprogrammer',
                'password' => Hash::make('password'),
                'role' => 'programmer',
                'phone' => '081234567891',
                'city' => 'Bandung',
                'bio' => 'Saya adalah seorang Programmer profesional yang siap membangun berbagai project digital seperti website, landing page, dan aplikasi mobile.',
                'is_verified' => true,
                'is_top_programmer' => false,
                'rating' => 0.0,
                'total_projects' => 0,
                'total_earnings' => 0,
                'ktp_number' => '3273123456789012',
                'ktp_photo' => 'verification/ktp/dummy.jpg',
                'cv_file' => 'verification/cv/dummy.pdf',
                'portfolio_file' => 'verification/portfolio/dummy.pdf',
                'expertise' => 'Web Development, Laravel, React',
            ]
        );

        Certificate::firstOrCreate(
            ['programmer_id' => $rifqiProgrammer->id, 'name' => 'Sertifikat Pertama Rifqi'],
            [
                'issuer' => 'Lembaga Sertifikasi Informatika',
                'issue_date' => '2025-05-20',
                'certificate_file' => 'verification/certificates/dummy.pdf',
                'status' => 'approved',
            ]
        );

        $rifqiUmkm = User::firstOrCreate(
            ['email' => 'rifqiumkm@gmail.com'],
            [
                'name' => 'rifqiumkm',
                'password' => Hash::make('password'),
                'role' => 'umkm',
                'phone' => '083456789013',
                'city' => 'Bandung',
                'business_name' => 'Rifqi Creative Studio',
                'business_type' => 'Fashion & Kerajinan',
                'umkm_verified' => true,
                'ktp_number' => '3273123456789013',
                'ktp_photo' => 'verification/ktp/dummy.jpg',
                'business_photo' => 'verification/business/dummy.jpg',
                'legal_doc' => 'NIB-881234567',
            ]
        );

        $rifqiPelajar = User::firstOrCreate(
            ['email' => 'rifqipelajar@gmail.com'],
            [
                'name' => 'rifqipelajar',
                'password' => Hash::make('password'),
                'role' => 'course',
                'phone' => '084567890124',
                'city' => 'Bandung',
                'expertise' => 'Web Development',
            ]
        );

        // Portfolios
        Portfolio::create(['programmer_id' => $rizky->id, 'title' => 'Toko Online UMKM Batik', 'description' => 'Website toko online batik khas Yogyakarta dengan fitur lengkap', 'tags' => ['React', 'Laravel', 'MySQL'], 'status' => 'approved']);
        Portfolio::create(['programmer_id' => $rizky->id, 'title' => 'Sistem POS Warung', 'description' => 'Point of Sale untuk warung makan dengan tracking real-time', 'tags' => ['Vue.js', 'PHP', 'MySQL'], 'status' => 'approved']);
        Portfolio::create(['programmer_id' => $rizky->id, 'title' => 'Marketplace Kerajinan', 'description' => 'Multi-vendor marketplace kerajinan lokal Indonesia', 'tags' => ['Next.js', 'Node.js', 'PostgreSQL'], 'status' => 'approved']);

        // Certificates
        Certificate::create(['programmer_id' => $rizky->id, 'name' => 'Laravel Certified Developer', 'issuer' => 'Laravel', 'issue_date' => '2023-03-15', 'status' => 'approved']);
        Certificate::create(['programmer_id' => $rizky->id, 'name' => 'Google Professional Cloud Developer', 'issuer' => 'Google', 'issue_date' => '2022-09-01', 'status' => 'approved']);
        Certificate::create(['programmer_id' => $rizky->id, 'name' => 'React Certification', 'issuer' => 'Meta', 'issue_date' => '2021-07-20', 'status' => 'approved']);

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
            'escrow_status' => 'held_by_admin',
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
            'escrow_status' => 'released',
            'category' => 'Business Tools',
            'tags' => ['Business Tools', 'React', 'PHP', 'MySQL'],
            'assigned_programmer_id' => $rizky->id,
            'platform_fee' => 2000000,
            'programmer_earning' => 500000,
        ]);

        // 15 Posting Project Baru (Approved / Verified by Admin, status: open)
        $additionalProjects = [
            [
                'umkm_id' => $budi->id,
                'title' => 'Website E-Commerce Batik Tulis Yogyakarta',
                'description' => 'Membangun website e-commerce premium untuk penjualan batik tulis khas Yogyakarta. Fitur utama meliputi katalog batik interaktif, keranjang belanja, integrasi payment gateway, dan manajemen stok.',
                'budget' => 0,
                'deadline' => now()->addDays(20)->toDateString(),
                'status' => 'open',
                'category' => 'E-Commerce',
                'tags' => ['Aplikasi Web'],
            ],
            [
                'umkm_id' => $budi->id,
                'title' => 'Pembuatan Aplikasi Android Studio Katalog Batik',
                'description' => 'Membuat aplikasi mobile Android menggunakan Android Studio dan Kotlin untuk menampilkan katalog produk batik dengan fitur pencarian, filter kategori, dan detail motif batik.',
                'budget' => 0,
                'deadline' => now()->addDays(15)->toDateString(),
                'status' => 'open',
                'category' => 'Marketplace',
                'tags' => ['Aplikasi Mobile'],
            ],
            [
                'umkm_id' => $siti->id,
                'title' => 'Sistem Informasi Manajemen Keuangan UMKM',
                'description' => 'Membangun sistem informasi berbasis web untuk mencatat kas masuk, kas keluar, laporan laba rugi bulanan secara otomatis, dan grafik analisis performa bisnis.',
                'budget' => 0,
                'deadline' => now()->addDays(30)->toDateString(),
                'status' => 'open',
                'category' => 'Business Tools',
                'tags' => ['Sistem Informasi'],
            ],
            [
                'umkm_id' => $siti->id,
                'title' => 'Aplikasi Desktop POS (Point of Sales) Warung Makan',
                'description' => 'Pengembangan aplikasi desktop untuk kasir warung makan dengan antarmuka yang cepat, cetak struk thermal, dan manajemen inventori bahan baku makanan.',
                'budget' => 0,
                'deadline' => now()->addDays(45)->toDateString(),
                'status' => 'open',
                'category' => 'Kuliner & Food Tech',
                'tags' => ['Aplikasi Desktop'],
            ],
            [
                'umkm_id' => $rifqiUmkm->id,
                'title' => 'Website EduTech Kelas Online Coding Pemula',
                'description' => 'Platform pembelajaran online dengan fitur manajemen materi, video streaming, kuis interaktif, dan pelacakan kemajuan belajar siswa secara real-time.',
                'budget' => 0,
                'deadline' => now()->subDays(5)->toDateString(), // Expired 1
                'status' => 'open',
                'category' => 'Education',
                'tags' => ['Aplikasi Web'],
            ],
            [
                'umkm_id' => $budi->id,
                'title' => 'Aplikasi Mobile Android Studio Reservasi Klinik Kesehatan',
                'description' => 'Aplikasi mobile berbasis Android untuk melakukan pendaftaran pasien, memilih jadwal dokter, konsultasi online sederhana, dan resep obat digital.',
                'budget' => 0,
                'deadline' => now()->addDays(60)->toDateString(),
                'status' => 'open',
                'category' => 'Healthcare',
                'tags' => ['Aplikasi Mobile'],
            ],
            [
                'umkm_id' => $siti->id,
                'title' => 'Sistem Informasi Pembayaran Sekolah (SPP Online)',
                'description' => 'Sistem informasi berbasis web untuk mempermudah pembayaran SPP siswa sekolah dengan integrasi payment gateway dan notifikasi WhatsApp otomatis.',
                'budget' => 0,
                'deadline' => now()->addDays(25)->toDateString(),
                'status' => 'open',
                'category' => 'Finance',
                'tags' => ['Sistem Informasi'],
            ],
            [
                'umkm_id' => $rifqiUmkm->id,
                'title' => 'Aplikasi Desktop Reservasi Tiket Pariwisata Lokal',
                'description' => 'Aplikasi desktop untuk agen travel yang memudahkan booking tiket destinasi wisata lokal, cetak e-tiket, serta sinkronisasi data ke cloud.',
                'budget' => 0,
                'deadline' => now()->addDays(90)->toDateString(),
                'status' => 'open',
                'category' => 'Development',
                'tags' => ['Aplikasi Desktop'],
            ],
            [
                'umkm_id' => $budi->id,
                'title' => 'Sistem Monitoring Kelembaban Tanah Smart Farming',
                'description' => 'Platform IoT berbasis web untuk memantau kelembaban tanah dan suhu udara pada perkebunan secara real-time demi meningkatkan produktivitas panen.',
                'budget' => 0,
                'deadline' => now()->subDays(12)->toDateString(), // Expired 2
                'status' => 'open',
                'category' => 'Data Analytics',
                'tags' => ['Sistem Informasi'],
            ],
            [
                'umkm_id' => $rifqiUmkm->id,
                'title' => 'Website Marketplace Jual Beli Properti & Tanah',
                'description' => 'Membangun website marketplace properti yang mempertemukan pembeli dan agen properti, dilengkapi peta interaktif, filter harga, dan fitur chat langsung.',
                'budget' => 0,
                'deadline' => now()->addDays(120)->toDateString(), // 4 months
                'status' => 'open',
                'category' => 'Database',
                'tags' => ['Aplikasi Web'],
            ],
            [
                'umkm_id' => $siti->id,
                'title' => 'Aplikasi Android Studio Tracking Kurir Logistik',
                'description' => 'Aplikasi mobile Android untuk pelacakan lokasi kurir pengantar barang menggunakan GPS secara real-time dan tanda tangan digital penerima barang.',
                'budget' => 0,
                'deadline' => now()->addDays(75)->toDateString(),
                'status' => 'open',
                'category' => 'Mobile App',
                'tags' => ['Aplikasi Mobile'],
            ],
            [
                'umkm_id' => $rifqiUmkm->id,
                'title' => 'Sistem Informasi Manajemen Salon Kecantikan & Spa',
                'description' => 'Sistem informasi berbasis web untuk manajemen pemesanan treatment salon, pemilihan terapis, absensi staf, serta laporan keuangan bulanan.',
                'budget' => 0,
                'deadline' => now()->addDays(35)->toDateString(),
                'status' => 'open',
                'category' => 'Frontend',
                'tags' => ['Sistem Informasi'],
            ],
            [
                'umkm_id' => $budi->id,
                'title' => 'Aplikasi Desktop Portofolio Desainer Kreatif',
                'description' => 'Aplikasi desktop untuk menyusun dan memamerkan karya desainer grafis dengan galeri 3D interaktif, ekspor portofolio ke PDF, dan custom template.',
                'budget' => 0,
                'deadline' => now()->subDays(20)->toDateString(), // Expired 3
                'status' => 'open',
                'category' => 'Backend',
                'tags' => ['Aplikasi Desktop'],
            ],
            [
                'umkm_id' => $rifqiUmkm->id,
                'title' => 'Website Event Organizer & Pemesanan Tiket Konser',
                'description' => 'Website untuk publikasi event, registrasi peserta, pembayaran tiket online dengan QR Code, dan scan e-tiket saat masuk ke area acara.',
                'budget' => 0,
                'deadline' => now()->addDays(110)->toDateString(),
                'status' => 'open',
                'category' => 'Landing Page',
                'tags' => ['Aplikasi Web'],
            ],
            [
                'umkm_id' => $siti->id,
                'title' => 'Aplikasi Android Studio Rental Mobil & Motor',
                'description' => 'Aplikasi mobile rental kendaraan yang menampilkan daftar mobil/motor tersedia, verifikasi KTP pelanggan, sewa harian, dan integrasi peta maps.',
                'budget' => 0,
                'deadline' => now()->addDays(50)->toDateString(),
                'status' => 'open',
                'category' => 'Data Scraping',
                'tags' => ['Aplikasi Mobile'],
            ],
        ];

        foreach ($additionalProjects as $projData) {
            Project::create($projData);
        }

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
