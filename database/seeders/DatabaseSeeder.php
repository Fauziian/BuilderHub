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
                'is_top_programmer' => true,
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

        Certificate::firstOrCreate(
            ['programmer_id' => $rifqiProgrammer->id, 'name' => 'Sertifikat Web Developer Expert (Dicoding)'],
            [
                'issuer' => 'Dicoding Indonesia',
                'issue_date' => '2024-08-15',
                'certificate_file' => 'verification/certificates/dummy.pdf',
                'status' => 'approved',
            ]
        );

        Certificate::firstOrCreate(
            ['programmer_id' => $rifqiProgrammer->id, 'name' => 'Sertifikat Back-End Developer (Alibaba Cloud)'],
            [
                'issuer' => 'Alibaba Cloud Academy',
                'issue_date' => '2024-11-10',
                'certificate_file' => 'verification/certificates/dummy.pdf',
                'status' => 'approved',
            ]
        );

        // Portfolios for rifqiProgrammer
        Portfolio::firstOrCreate(
            ['programmer_id' => $rifqiProgrammer->id, 'title' => 'Website Landing Page UMKM Hijab Bandung'],
            [
                'description' => 'Website e-commerce landing page modern dengan optimasi SEO untuk produk hijab lokal.',
                'tags' => ['HTML', 'CSS', 'JavaScript', 'TailwindCSS'],
                'project_url' => 'https://hijabbandung.com',
                'status' => 'approved',
            ]
        );

        Portfolio::firstOrCreate(
            ['programmer_id' => $rifqiProgrammer->id, 'title' => 'Sistem ERP Toko Material Sinar Abadi'],
            [
                'description' => 'Aplikasi internal web POS dan Inventory Management berbasis Laravel dan Livewire.',
                'tags' => ['Laravel', 'Livewire', 'MySQL', 'Bootstrap'],
                'project_url' => 'https://sinarabadi.co.id',
                'status' => 'approved',
            ]
        );

        Portfolio::firstOrCreate(
            ['programmer_id' => $rifqiProgrammer->id, 'title' => 'Aplikasi Manajemen Laundry Online'],
            [
                'description' => 'Sistem manajemen tracking laundry berbasis React dan Node.js dengan notifikasi WhatsApp.',
                'tags' => ['React', 'Node.js', 'Express', 'MongoDB'],
                'project_url' => 'https://laundryonline.web.id',
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
                'umkm_id' => $budi->id,
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
                'umkm_id' => $siti->id,
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
                'umkm_id' => $budi->id,
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
                'umkm_id' => $siti->id,
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
                'umkm_id' => $budi->id,
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

        // 30 projects for rifqiUmkm
        // 8 past deadlines (expired, from June 27, 2026 backwards)
        for ($i = 1; $i <= 8; $i++) {
            $diffDays = $i;
            $deadlineDate = now()->subDays($diffDays)->toDateString();
            $budget = 1500000 + ($i * 500000); // Rp 2M to Rp 5.5M
            $platformFee = $budget * 0.80;
            $programmerEarning = $budget * 0.20;

            Project::create([
                'umkm_id' => $rifqiUmkm->id,
                'title' => "Project UMKM Mandiri " . $i . " (Sistem Kasir / Toko)",
                'description' => "Pengembangan aplikasi web sederhana untuk membantu usaha mikro lokal mengelola transaksi harian secara efisien dan aman.",
                'budget' => $budget,
                'deadline' => $deadlineDate,
                'status' => 'open',
                'category' => 'E-Commerce',
                'tags' => ['Aplikasi Web', 'Laravel', 'MySQL'],
                'platform_fee' => $platformFee,
                'programmer_earning' => $programmerEarning,
            ]);
        }

        // 23 future/scheduled deadlines (15 days, 25 days, up to 120 days/4 months)
        $futureDeadlines = [
            15, 15, 18, 20, 22,
            25, 25, 28, 30, 35,
            45, 45, 50, 60, 70,
            80, 90, 90, 100, 110, 115, 120, 120
        ];

        foreach ($futureDeadlines as $idx => $days) {
            $num = $idx + 9;
            $deadlineDate = now()->addDays($days)->toDateString();
            
            if ($days <= 22) {
                $budget = 1500000 + ($idx * 300000);
                $difficulty = "Sederhana";
                $cat = "Landing Page";
            } elseif ($days <= 35) {
                $budget = 4000000 + (($idx - 5) * 400000);
                $difficulty = "Menengah";
                $cat = "E-Commerce";
            } elseif ($days <= 70) {
                $budget = 8000000 + (($idx - 10) * 800000);
                $difficulty = "Kompleks";
                $cat = "Mobile App";
            } else {
                $budget = 15000000 + (($idx - 15) * 1200000);
                $difficulty = "Enterprise";
                $cat = "Sistem Informasi";
            }

            $platformFee = $budget * 0.80;
            $programmerEarning = $budget * 0.20;

            Project::create([
                'umkm_id' => $rifqiUmkm->id,
                'title' => "Pengembangan Aplikasi " . $difficulty . " Kelompok " . $num,
                'description' => "Kebutuhan pembuatan sistem dengan skala " . $difficulty . " untuk mendukung efisiensi operasional digitalisasi UMKM daerah.",
                'budget' => $budget,
                'deadline' => $deadlineDate,
                'status' => 'open',
                'category' => $cat,
                'tags' => ['Aplikasi Web', 'Database', 'REST API'],
                'platform_fee' => $platformFee,
                'programmer_earning' => $programmerEarning,
            ]);
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

        // 20 Courses for rifqiProgrammer
        $rifqiCoursesData = [
            [
                'title' => 'HTML & CSS Dasar untuk Desain Web',
                'description' => 'Mulai belajar membuat website pertama Anda dari dasar HTML5 hingga dasar styling CSS3.',
                'price' => 100000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 140,
                'rating' => 4.7,
                'duration' => '32 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Kuasai Semantik HTML5',
                'description' => 'Pelajari cara menulis markup HTML yang semantis dan terstruktur untuk mempermudah SEO dan aksesibilitas.',
                'price' => 120000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 95,
                'rating' => 4.6,
                'duration' => '14 menit',
                'videos' => [
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit']
                ]
            ],
            [
                'title' => 'Membangun Layout Responsif dengan CSS Grid & Flexbox',
                'description' => 'Pelajari teknik layouting modern dengan CSS Grid dan Flexbox agar website Anda tampil sempurna di semua perangkat.',
                'price' => 150000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 110,
                'rating' => 4.8,
                'duration' => '21 menit',
                'videos' => [
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Pemrograman Web Frontend Tingkat Pemula',
                'description' => 'Panduan komprehensif bagi pemula untuk memahami HTML5 dan CSS dasar sebelum masuk ke dunia JavaScript framework.',
                'price' => 180000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 210,
                'rating' => 4.9,
                'duration' => '46 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Konsep Dasar Styling Web Modern',
                'description' => 'Pelajari bagaimana CSS bekerja di balik layar, termasuk cascading, inheritance, dan specificity.',
                'price' => 130000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 88,
                'rating' => 4.5,
                'duration' => '32 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Struktur Dasar Halaman Web dengan HTML5',
                'description' => 'Langkah awal menyusun dokumen HTML, tag dasar, list, tabel, dan tautan internal/eksternal.',
                'price' => 110000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 130,
                'rating' => 4.6,
                'duration' => '25 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit']
                ]
            ],
            [
                'title' => 'Pengembangan UI Web Elegan & Responsif',
                'description' => 'Gunakan CSS media queries dan teknik desain responsif untuk mempercantik antarmuka web Anda.',
                'price' => 160000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 74,
                'rating' => 4.7,
                'duration' => '21 menit',
                'videos' => [
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Pengenalan Web Development dari Nol',
                'description' => 'Kursus dasar yang merangkum teknologi web paling penting: struktur konten (HTML) dan visualisasi (CSS).',
                'price' => 140000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 155,
                'rating' => 4.7,
                'duration' => '46 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Teknik Layouting CSS Modern',
                'description' => 'Pelajari flex direction, wrapping, alignment, serta bagaimana memadukannya dengan struktur HTML bagian 2.',
                'price' => 170000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 62,
                'rating' => 4.8,
                'duration' => '35 menit',
                'videos' => [
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Optimasi Struktur HTML untuk SEO',
                'description' => 'Optimalkan penulisan kode HTML agar mudah di-crawl oleh mesin pencari seperti Google dan Bing.',
                'price' => 190000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 80,
                'rating' => 4.6,
                'duration' => '25 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit']
                ]
            ],
            [
                'title' => 'Best Practices Menulis HTML & CSS Bersih',
                'description' => 'Tips menulis kode HTML/CSS yang efisien, terstandarisasi, dan mudah dipelihara oleh tim developer.',
                'price' => 200000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 93,
                'rating' => 4.8,
                'duration' => '46 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Slicing Desain Figma ke HTML/CSS',
                'description' => 'Ubah desain UI dari Figma menjadi baris kode HTML and styling CSS responsif yang interaktif.',
                'price' => 220000,
                'level' => 'mahir',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 67,
                'rating' => 4.9,
                'duration' => '32 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Mastering Flexbox & CSS Positioning',
                'description' => 'Pahami position relative, absolute, fixed, sticky, dan cara membangun layout kompleks dengan Flexbox.',
                'price' => 210000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 58,
                'rating' => 4.7,
                'duration' => '21 menit',
                'videos' => [
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Membangun Form Interaktif & Aksesibel',
                'description' => 'Bagaimana membuat form login, register, dan kontak yang ramah pengguna serta mudah diisi di HP.',
                'price' => 230000,
                'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 70,
                'rating' => 4.8,
                'duration' => '25 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit']
                ]
            ],
            [
                'title' => 'Dasar-Dasar Pemrograman Web Dinamis',
                'description' => 'Memahami hubungan antara HTML sebagai tulang punggung, CSS sebagai kulit, dan JS sebagai otot situs web.',
                'price' => 240000,
                'level' => 'pemula',
                'category' => 'Frontend',
                'thumbnail' => 'js',
                'total_students' => 115,
                'rating' => 4.8,
                'duration' => '46 menit',
                'videos' => [
                    ['title' => 'Belajar HTML untuk pemula', 'url' => 'https://www.youtube.com/embed/0oA1Z6UKM5M', 'dur' => '11 menit'],
                    ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/embed/qwKm_7GmgBU', 'dur' => '14 menit'],
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Pengenalan CSS Custom Properties & Variables',
                'description' => 'Buat website bertema terang dan gelap (dark mode) menggunakan variabel CSS murni.',
                'price' => 250000,
                'level' => 'mahir',
                'category' => 'Frontend',
                'thumbnail' => 'css',
                'total_students' => 45,
                'rating' => 4.7,
                'duration' => '21 menit',
                'videos' => [
                    ['title' => 'CSS bagian 1', 'url' => 'https://www.youtube.com/embed/V-DD30lGAL0', 'dur' => '21 menit']
                ]
            ],
            [
                'title' => 'Struktur Konten Web Kompleks',
                'description' => 'Bagaimana membuat struktur data semantis untuk artikel blog, galeri foto, dan embed video pihak ketiga.',
'level' => 'menengah',
                'category' => 'Frontend',
                'thumbnail' => 'html',
                'total_students' => 60,
                'rating' => 4.6
            ]
        ];

        // 50 Courses for rifqiProgrammer
        $courseTemplates = [
            [
                'title' => 'HTML & CSS Dasar untuk Desain Web',
                'description' => 'Mulai belajar membuat website pertama Anda dari dasar HTML5 hingga dasar styling CSS3.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'html'
            ],
            [
                'title' => 'Kuasai Semantik HTML5',
                'description' => 'Pelajari cara menulis markup HTML yang semantis dan terstruktur untuk mempermudah SEO dan aksesibilitas.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'html'
            ],
            [
                'title' => 'CSS Grid & Flexbox untuk Layout Modern',
                'description' => 'Kuasai teknik layout modern menggunakan Flexbox dan Grid untuk website yang sangat responsive.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'css'
            ],
            [
                'title' => 'Animasi CSS Tingkat Lanjut',
                'description' => 'Tambahkan transisi, transformasi, dan keyframe animasi interaktif untuk mempercantik UI/UX web Anda.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'css'
            ],
            [
                'title' => 'Dasar Pemrograman JavaScript',
                'description' => 'Pelajari variabel, tipe data, kondisi, looping, fungsi, dan logika dasar pemrograman Javascript.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'js'
            ],
            [
                'title' => 'DOM Manipulation dengan Vanilla JS',
                'description' => 'Manipulasi elemen HTML, class CSS, event listener, dan buat web Anda interaktif tanpa library.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'js'
            ],
            [
                'title' => 'JavaScript ES6+ Konsep Modern',
                'description' => 'Pelajari fitur ES6+ terbaru seperti arrow functions, destructuring, template literals, dan modules.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'js'
            ],
            [
                'title' => 'Asynchronous JavaScript (Promises & Async/Await)',
                'description' => 'Pahami cara kerja asinkronus, callback hell, Promises, serta Async/Await untuk memanggil API.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'js'
            ],
            [
                'title' => 'Membangun Aplikasi CRUD dengan PHP & MySQL',
                'description' => 'Belajar memproses data form, koneksi database, dan membuat aplikasi CRUD sederhana dengan PHP native.',
                'level' => 'pemula', 'category' => 'Backend', 'thumbnail' => 'php'
            ],
            [
                'title' => 'Object-Oriented Programming (OOP) di PHP',
                'description' => 'Pahami konsep OOP dalam PHP mulai dari Class, Object, Inheritance, Polymorphism, hingga Encapsulation.',
                'level' => 'menengah', 'category' => 'Backend', 'thumbnail' => 'php'
            ],
            [
                'title' => 'Pemula Laravel 11: Instalasi & Routing',
                'description' => 'Langkah pertama menguasai Laravel 11. Pelajari routing dasar, controller, dan struktur folder Laravel.',
                'level' => 'pemula', 'category' => 'Backend', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Laravel Eloquent ORM Mendalam',
                'description' => 'Pelajari interaksi database modern menggunakan Eloquent, relasi database (One to Many, Many to Many).',
                'level' => 'menengah', 'category' => 'Backend', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Sistem Autentikasi & Otorisasi Laravel',
                'description' => 'Implementasikan login, register, reset password, verifikasi email, dan role-based access control.',
                'level' => 'menengah', 'category' => 'Backend', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Membuat RESTful API dengan Laravel',
                'description' => 'Membangun endpoint API yang aman menggunakan API Resources, autentikasi Sanctum, dan request validation.',
                'level' => 'menengah', 'category' => 'Backend', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Laravel Livewire untuk Aplikasi Reaktif',
                'description' => 'Buat interface yang interaktif dan dinamis menggunakan Laravel Livewire tanpa menulis baris kode Javascript.',
                'level' => 'mahir', 'category' => 'Backend', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Pengenalan React.js & JSX',
                'description' => 'Pelajari dasar-dasar library React, sintaksis JSX, rendering element, dan struktur project React.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'React State & Props Management',
                'description' => 'Kuasai bagaimana data mengalir antar component melalui Props dan bagaimana menyimpan state internal.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'React Hooks Terlengkap (useState, useEffect, useContext)',
                'description' => 'Maksimalkan penggunaan functional components di React dengan Hooks bawaan untuk state, efek, dan context.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'Integrasi REST API di React dengan Axios',
                'description' => 'Hubungkan aplikasi React Anda dengan database backend via REST API menggunakan Axios dan fetch.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'React Router untuk Single Page Application',
                'description' => 'Pelajari routing sisi client, dynamic routes, nested routes, dan navigasi di aplikasi React.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'State Management React dengan Redux Toolkit',
                'description' => 'Kelola state global aplikasi React berskala besar dengan Redux Toolkit secara terstruktur dan efisien.',
                'level' => 'mahir', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'Next.js 14: Server Components & App Router',
                'description' => 'Membangun aplikasi web dengan performa tinggi menggunakan framework Next.js 14 dan Server Components.',
                'level' => 'mahir', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'Node.js Dasar & NPM Package Manager',
                'description' => 'Mengenal runtime Node.js, file system module, HTTP module, dan cara mengelola dependencies dengan NPM.',
                'level' => 'pemula', 'category' => 'Backend', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Membangun Server Web dengan Express.js',
                'description' => 'Framework minimalis tercepat untuk Node.js. Pelajari routing, static files, dan REST API dasar.',
                'level' => 'pemula', 'category' => 'Backend', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Express Middleware & Error Handling',
                'description' => 'Pahami daur hidup request-response di Express, middleware kustom, dan penanganan error yang baik.',
                'level' => 'menengah', 'category' => 'Backend', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Autentikasi JWT di Node.js',
                'description' => 'Amankan endpoint REST API Anda menggunakan JSON Web Token (JWT), enkripsi bcrypt, dan middleware proteksi.',
                'level' => 'menengah', 'category' => 'Backend', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Database NoSQL dengan MongoDB & Mongoose',
                'description' => 'Integrasikan server Node.js dengan database non-relasional MongoDB menggunakan Mongoose ODM.',
                'level' => 'menengah', 'category' => 'Database', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Optimasi Database MySQL untuk Programmer',
                'description' => 'Belajar indexing, query optimization, view, store procedure, dan cara merancang skema DB yang efisien.',
                'level' => 'menengah', 'category' => 'Database', 'thumbnail' => 'mysql'
            ],
            [
                'title' => 'Dasar Git: Init, Commit, Push & Pull',
                'description' => 'Langkah awal mengelola riwayat perubahan kode Anda menggunakan Git dan GitHub.',
                'level' => 'pemula', 'category' => 'DevOps', 'thumbnail' => 'git'
            ],
            [
                'title' => 'Branching & Merging Strategi Git',
                'description' => 'Bekerja secara paralel dengan branch, merge konflik resolver, dan best practice Git Flow.',
                'level' => 'menengah', 'category' => 'DevOps', 'thumbnail' => 'git'
            ],
            [
                'title' => 'Kolaborasi Team dengan Pull Request & Fork',
                'description' => 'Cara berkontribusi ke open source atau bekerja dalam tim menggunakan GitHub Pull Request.',
                'level' => 'menengah', 'category' => 'DevOps', 'thumbnail' => 'git'
            ],
            [
                'title' => 'CI/CD Pipeline Sederhana dengan GitHub Actions',
                'description' => 'Otomatisasikan testing dan deploy kode Anda setiap kali melakukan push menggunakan GitHub Actions.',
                'level' => 'mahir', 'category' => 'DevOps', 'thumbnail' => 'git'
            ],
            [
                'title' => 'Flutter untuk Pemula: Widget & Layout',
                'description' => 'Mulai belajar Flutter. Pelajari basic widgets seperti Container, Row, Column, Image, dan Text.',
                'level' => 'pemula', 'category' => 'Mobile', 'thumbnail' => 'flutter'
            ],
            [
                'title' => 'Navigasi & Oper Data di Flutter',
                'description' => 'Pelajari perpindahan halaman, parsing data antar screen, dan custom transition di Flutter.',
                'level' => 'pemula', 'category' => 'Mobile', 'thumbnail' => 'flutter'
            ],
            [
                'title' => 'State Management Flutter: Provider & BLoC',
                'description' => 'Kelola state aplikasi Flutter Anda agar bersih dan terstruktur menggunakan Provider dan BLoC.',
                'level' => 'menengah', 'category' => 'Mobile', 'thumbnail' => 'flutter'
            ],
            [
                'title' => 'Flutter dengan REST API Backend',
                'description' => 'Hubungkan UI Flutter Anda dengan server database eksternal menggunakan package HTTP atau Dio.',
                'level' => 'menengah', 'category' => 'Mobile', 'thumbnail' => 'flutter'
            ],
            [
                'title' => 'UI/UX Design untuk Programmer Web',
                'description' => 'Belajar prinsip dasar desain seperti tata letak, warna, tipografi, dan kontras untuk programmer.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'css'
            ],
            [
                'title' => 'Responsive Web Design dengan Media Queries',
                'description' => 'Cara mendesain website agar ramah diakses dari layar handphone, tablet, hingga desktop.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'css'
            ],
            [
                'title' => 'Tailwind CSS: Desain UI Tanpa Menulis CSS',
                'description' => 'Belajar mempercepat styling web dengan utility-first CSS framework Tailwind CSS.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'css'
            ],
            [
                'title' => 'Bootstrap 5: Kerangka Kerja CSS Terpopuler',
                'description' => 'Gunakan komponen siap pakai Bootstrap 5 untuk membangun prototype website dengan super cepat.',
                'level' => 'pemula', 'category' => 'Frontend', 'thumbnail' => 'css'
            ],
            [
                'title' => 'TypeScript Dasar untuk Developer JavaScript',
                'description' => 'Tingkatkan kualitas code JS Anda dengan static typing, interfaces, types, dan generic di TypeScript.',
                'level' => 'menengah', 'category' => 'Frontend', 'thumbnail' => 'js'
            ],
            [
                'title' => 'Unit Testing dengan Jest di React',
                'description' => 'Belajar menguji component React Anda secara otomatis menggunakan Jest dan React Testing Library.',
                'level' => 'mahir', 'category' => 'Frontend', 'thumbnail' => 'react'
            ],
            [
                'title' => 'Feature Testing Laravel dengan Pest',
                'description' => 'Pahami penulisan test case yang ringkas, bersih, dan modern di Laravel menggunakan Pest PHP.',
                'level' => 'mahir', 'category' => 'Backend', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Web Security: Mencegah SQL Injection & XSS',
                'description' => 'Amankan aplikasi web Anda dari serangan hacker paling umum seperti SQL Injection dan XSS.',
                'level' => 'mahir', 'category' => 'DevOps', 'thumbnail' => 'php'
            ],
            [
                'title' => 'Deploy Web App ke Vercel & Netlify',
                'description' => 'Cara termudah dan gratis mempublikasikan aplikasi frontend/static website Anda ke internet.',
                'level' => 'pemula', 'category' => 'DevOps', 'thumbnail' => 'git'
            ],
            [
                'title' => 'Deploy Laravel ke VPS Ubuntu & Nginx',
                'description' => 'Belajar setup VPS dari nol, install PHP, Nginx, MySQL, SSL gratis, dan deploy project Laravel.',
                'level' => 'mahir', 'category' => 'DevOps', 'thumbnail' => 'laravel'
            ],
            [
                'title' => 'Membangun Chat App Realtime dengan Socket.io',
                'description' => 'Gunakan Node.js dan Socket.io untuk membuat aplikasi pengiriman pesan instan dua arah.',
                'level' => 'mahir', 'category' => 'Backend', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Docker Dasar untuk Developer',
                'description' => 'Pahami konsep containerization, Dockerfile, docker-compose, untuk standarisasi lingkungan development.',
                'level' => 'mahir', 'category' => 'DevOps', 'thumbnail' => 'git'
            ],
            [
                'title' => 'GraphQL API: Alternatif REST API',
                'description' => 'Belajar membuat query API yang fleksibel menggunakan GraphQL di Node.js.',
                'level' => 'mahir', 'category' => 'Backend', 'thumbnail' => 'node'
            ],
            [
                'title' => 'Membangun E-Commerce Sederhana dengan MERN Stack',
                'description' => 'Proyek gabungan: MongoDB, Express, React, dan Node.js untuk toko online lengkap dengan keranjang belanja.',
                'level' => 'mahir', 'category' => 'Fullstack', 'thumbnail' => 'react'
            ]
        ];

        $rifqiCoursesData = [];
        $presetVideos = [
            'html' => [
                ['title' => 'HTML5', 'url' => 'https://www.youtube.com/watch?v=Q2VqCG13ejA&list=PLFIM0718LjIX-K5eeHRImnZhPUMhsw9A7', 'dur' => '18 menit'],
                ['title' => 'HTML bagian 2', 'url' => 'https://www.youtube.com/watch?v=o3m15BWi2HM&list=PLFIM0718LjIX-K5eeHRImnZhPUMhsw9A7&index=2', 'dur' => '21 menit']
            ],
            'css' => [
                ['title' => 'Css3', 'url' => 'https://www.youtube.com/watch?v=J0a6YUUAsd4&list=PLFIM0718LjIVCmrSWbZPKCccCkfFw-Naa', 'dur' => '11 menit'],
                ['title' => 'Css3 border radius', 'url' => 'https://www.youtube.com/watch?v=3xbW5YHln78&list=PLFIM0718LjIVCmrSWbZPKCccCkfFw-Naa&index=2', 'dur' => '8 menit']
            ],
            'js' => [
                ['title' => 'Javascript', 'url' => 'https://www.youtube.com/watch?v=RUTV_5m4VeI&list=PLFIM0718LjIWXagluzROrA-iBY9eeUt4w', 'dur' => '7 menit']
            ],
            'php' => [
                ['title' => 'PHP dasar', 'url' => 'https://www.youtube.com/watch?v=TaBWhb5SPfc&list=PL-CtdCApEFH9EmZy4zYfW1ATIJ-qMXxGt', 'dur' => '5 jam 28 menit']
            ],
            'mysql' => [
                ['title' => 'Tutorial MySQL', 'url' => 'https://www.youtube.com/watch?v=xYBclb-sYQ4&list=PL-CtdCApEFH_P2_2zR6pvDublvpD3fF6W', 'dur' => '6 jam 37 Menit']
            ],
            'laravel' => [
                ['title' => 'Laravel bagian 1', 'url' => 'https://www.youtube.com/watch?v=upOxC-rVJsU&list=PLPqeNG7ba3a_Sz3tJ1YukfqHE5jZGBmHn', 'dur' => '9 menit'],
                ['title' => 'Laravel bagian 2 Struktur folder', 'url' => 'https://www.youtube.com/watch?v=BXGhDPsJwFA&list=PLPqeNG7ba3a_Sz3tJ1YukfqHE5jZGBmHn&index=2', 'dur' => '7 menit']
            ],
            'react' => [
                ['title' => 'React JS', 'url' => 'https://www.youtube.com/watch?v=s2skans2dP4&t=1s', 'dur' => '10 menit']
            ],
            'node' => [
                ['title' => 'Node JS', 'url' => 'https://www.youtube.com/watch?v=sSLJx5t4OJ4&list=PLFIM0718LjIW-XBdVOerYgKegBtD6rSfD', 'dur' => '20 Menit']
            ],
            'flutter' => [
                ['title' => 'apa itu flutter', 'url' => 'https://www.youtube.com/watch?v=epRWFH47xCI&list=PL7jdfftn7HKsfTtv8FOaTbLIf7feiQTRu', 'dur' => '10 menit']
            ],
            'git' => [
                ['title' => 'Git', 'url' => 'https://www.youtube.com/watch?v=lTMZxWMjXQU&list=PLFIM0718LjIVknj6sgsSceMqlq242-jNf', 'dur' => '25 Menit']
            ]
        ];

        foreach ($courseTemplates as $index => $tpl) {
            $prices = [0, 100000, 150000, 200000, 250000, 300000];
            $price = $prices[$index % count($prices)];

            $videos = $presetVideos[$tpl['thumbnail']] ?? [
                ['title' => 'HTML5', 'url' => 'https://www.youtube.com/watch?v=Q2VqCG13ejA&list=PLFIM0718LjIX-K5eeHRImnZhPUMhsw9A7', 'dur' => '18 menit']
            ];

            // Calculate total duration
            $totalMinutes = 0;
            foreach ($videos as $vData) {
                $durStr = strtolower($vData['dur']);
                if (str_contains($durStr, 'jam')) {
                    preg_match('/(\d+)\s*jam/', $durStr, $jamMatches);
                    preg_match('/(\d+)\s*menit/', $durStr, $menitMatches);
                    $jam = isset($jamMatches[1]) ? intval($jamMatches[1]) : 0;
                    $menit = isset($menitMatches[1]) ? intval($menitMatches[1]) : 0;
                    $totalMinutes += ($jam * 60) + $menit;
                } else {
                    preg_match('/(\d+)\s*menit/', $durStr, $menitMatches);
                    $menit = isset($menitMatches[1]) ? intval($menitMatches[1]) : 0;
                    $totalMinutes += $menit;
                }
            }

            if ($totalMinutes >= 60) {
                $h = intval($totalMinutes / 60);
                $m = $totalMinutes % 60;
                $durationFormatted = $h . ' jam' . ($m > 0 ? ' ' . $m . ' menit' : '');
            } else {
                $durationFormatted = $totalMinutes . ' menit';
            }

            $rifqiCoursesData[] = [
                'title' => $tpl['title'],
                'description' => $tpl['description'],
                'price' => $price,
                'level' => $tpl['level'],
                'category' => $tpl['category'],
                'thumbnail' => $tpl['thumbnail'],
                'total_students' => 0,
                'rating' => 0.0,
                'duration' => $durationFormatted,
                'videos' => $videos
            ];
        }

        foreach ($rifqiCoursesData as $cData) {
            $course = Course::create([
                'instructor_id' => $rifqiProgrammer->id,
                'title' => $cData['title'],
                'description' => $cData['description'],
                'thumbnail' => $cData['thumbnail'],
                'price' => $cData['price'],
                'level' => $cData['level'],
                'category' => $cData['category'],
                'is_free' => ($cData['price'] == 0),
                'is_published' => true,
                'total_students' => $cData['total_students'],
                'rating' => $cData['rating'],
                'total_videos' => count($cData['videos']),
                'duration' => $cData['duration'],
            ]);

            foreach ($cData['videos'] as $vIdx => $vData) {
                CourseVideo::create([
                    'course_id' => $course->id,
                    'title' => $vData['title'],
                    'video_url' => $vData['url'],
                    'duration' => $vData['dur'],
                    'order' => $vIdx + 1,
                ]);
            }
        }

        // Course Videos for course1
        CourseVideo::create(['course_id' => $course1->id, 'title' => 'Pengenalan HTML & CSS Dasar', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'duration' => '45 menit', 'order' => 1]);
        CourseVideo::create(['course_id' => $course1->id, 'title' => 'JavaScript Fundamentals', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'duration' => '60 menit', 'order' => 2]);
        CourseVideo::create(['course_id' => $course1->id, 'title' => 'Pengenalan React.js', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'duration' => '55 menit', 'order' => 3]);

        // Enrollments
        CourseEnrollment::create(['course_id' => $course1->id, 'user_id' => $student->id, 'amount_paid' => 0, 'status' => 'active']);
        CourseEnrollment::create(['course_id' => $course3->id, 'user_id' => $student->id, 'amount_paid' => 299000, 'status' => 'active']);
    }
}
