<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseVideo;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::where('email', 'rifqiprogrammer@gmail.com')->first();
        if (!$instructor) {
            $this->command->error('User rifqiprogrammer@gmail.com tidak ditemukan!');
            return;
        }

        // Hapus semua course lama milik rifqiprogrammer
        $oldIds = Course::where('instructor_id', $instructor->id)->pluck('id');
        CourseEnrollment::whereIn('course_id', $oldIds)->delete();
        CourseVideo::whereIn('course_id', $oldIds)->delete();
        Course::where('instructor_id', $instructor->id)->delete();

        $this->command->info('Course lama dihapus. Membuat 10 course baru...');

        $courses = [
            // ============================================================
            // 1. HTML – GRATIS – PEMULA
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'Memahami HTML – Fondasi Dasar Web',
                    'description'    => 'Pelajari HTML dari nol! Mulai dari pengenalan apa itu HTML, struktur dokumen, tag-tag penting, cara membuat form, hingga project membuat halaman profil sederhana. Course ini cocok untuk Anda yang benar-benar baru pertama kali belajar web development.',
                    'price'          => 0,
                    'level'          => 'pemula',
                    'category'       => 'Web Development',
                    'is_free'        => true,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '1 jam 52 menit',
                ],
                'videos' => [
                    ['title' => 'Pembukaan & Apa Itu HTML?',          'url' => 'https://www.youtube.com/watch?v=qz0aGYrrlhU', 'duration' => '14 menit'],
                    ['title' => 'Struktur Dasar Dokumen HTML',         'url' => 'https://www.youtube.com/watch?v=HD13eq_Wvwg', 'duration' => '22 menit'],
                    ['title' => 'Tag-Tag Penting & Semantik HTML',     'url' => 'https://www.youtube.com/watch?v=PlxWf493en4', 'duration' => '28 menit'],
                    ['title' => 'Membuat Form & Tabel di HTML',        'url' => 'https://www.youtube.com/watch?v=2O8pkybH6po', 'duration' => '26 menit'],
                    ['title' => 'Project: Halaman Profil Sederhana',   'url' => 'https://www.youtube.com/watch?v=pQN-pnXPaVg', 'duration' => '22 menit'],
                ],
            ],

            // ============================================================
            // 2. CSS – GRATIS – PEMULA
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'Belajar CSS – Tampilkan Website dengan Gaya',
                    'description'    => 'CSS adalah bahasa yang mengatur tampilan halaman web. Di course ini Anda akan belajar dari pengenalan CSS, selector, box model, Flexbox untuk layout modern, hingga membuat tampilan website yang rapi dan profesional.',
                    'price'          => 0,
                    'level'          => 'pemula',
                    'category'       => 'Web Development',
                    'is_free'        => true,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '2 jam 10 menit',
                ],
                'videos' => [
                    ['title' => 'Pembukaan & Pengenalan CSS',          'url' => 'https://www.youtube.com/watch?v=yfoY53QXEnI', 'duration' => '12 menit'],
                    ['title' => 'Selector, Properties & Values CSS',   'url' => 'https://www.youtube.com/watch?v=1Rs2ND1ryYc', 'duration' => '25 menit'],
                    ['title' => 'Box Model: Margin, Border & Padding', 'url' => 'https://www.youtube.com/watch?v=rIO5326FgPE', 'duration' => '20 menit'],
                    ['title' => 'Flexbox – Layout Modern yang Mudah',  'url' => 'https://www.youtube.com/watch?v=3YW65K6LcIA', 'duration' => '38 menit'],
                    ['title' => 'Project: Styling Halaman Web Nyata',  'url' => 'https://www.youtube.com/watch?v=p0bGHP-PXD4', 'duration' => '35 menit'],
                ],
            ],

            // ============================================================
            // 3. JavaScript Dasar – Rp 100.000 – PEMULA
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'JavaScript Dasar – Logika Pemrograman Web',
                    'description'    => 'JavaScript adalah bahasa pemrograman utama di web. Anda akan belajar variabel, tipe data, operator, kondisi, perulangan, function, dan cara memanipulasi elemen HTML secara dinamis. Ditutup dengan project kalkulator interaktif.',
                    'price'          => 100000,
                    'level'          => 'pemula',
                    'category'       => 'Web Development',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '2 jam 30 menit',
                ],
                'videos' => [
                    ['title' => 'Pengenalan JavaScript & Setup Lingkungan', 'url' => 'https://www.youtube.com/watch?v=hdI2bqOjy3c', 'duration' => '18 menit'],
                    ['title' => 'Variabel, Tipe Data & Operator JS',        'url' => 'https://www.youtube.com/watch?v=W6NZfCO5SIk', 'duration' => '28 menit'],
                    ['title' => 'Kondisi if/else & Perulangan (Loop)',      'url' => 'https://www.youtube.com/watch?v=IsG4Xd6LlsQ', 'duration' => '32 menit'],
                    ['title' => 'Function & DOM Manipulation',              'url' => 'https://www.youtube.com/watch?v=5fb2aPlgoys', 'duration' => '35 menit'],
                    ['title' => 'Project: Kalkulator Interaktif',           'url' => 'https://www.youtube.com/watch?v=j59qQ7YWLxw', 'duration' => '37 menit'],
                ],
            ],

            // ============================================================
            // 4. PHP Backend – Rp 150.000 – MENENGAH
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'PHP Backend – Server-Side Web Programming',
                    'description'    => 'PHP adalah bahasa server-side paling populer di dunia. Di course ini Anda belajar dasar PHP, OOP (Object Oriented Programming), koneksi dengan database MySQL, validasi data, dan membuat aplikasi CRUD (Create Read Update Delete) dari nol.',
                    'price'          => 150000,
                    'level'          => 'menengah',
                    'category'       => 'Backend',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '3 jam 15 menit',
                ],
                'videos' => [
                    ['title' => 'Pengenalan PHP & Cara Kerja Server',  'url' => 'https://www.youtube.com/watch?v=Ak6VTSekGP4', 'duration' => '22 menit'],
                    ['title' => 'Variabel, Array & Fungsi dalam PHP',  'url' => 'https://www.youtube.com/watch?v=a7_WFUlFS94', 'duration' => '35 menit'],
                    ['title' => 'OOP PHP: Class, Object & Method',     'url' => 'https://www.youtube.com/watch?v=Anz0ArcQ5kI', 'duration' => '40 menit'],
                    ['title' => 'Koneksi PHP dengan Database MySQL',   'url' => 'https://www.youtube.com/watch?v=WGuyxGJW9hs', 'duration' => '33 menit'],
                    ['title' => 'Project: CRUD Sederhana dengan PHP',  'url' => 'https://www.youtube.com/watch?v=3DBNZ8GqOHE', 'duration' => '45 menit'],
                ],
            ],

            // ============================================================
            // 5. MySQL – Rp 150.000 – MENENGAH
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'MySQL & Database Relasional – Kelola Data Anda',
                    'description'    => 'Database adalah jantung dari setiap aplikasi modern. Di course ini Anda akan belajar SQL dari dasar: membuat tabel, memanipulasi data dengan DDL & DML, relasi antar tabel dengan JOIN, hingga optimasi query dengan indexing.',
                    'price'          => 150000,
                    'level'          => 'menengah',
                    'category'       => 'Database',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '2 jam 48 menit',
                ],
                'videos' => [
                    ['title' => 'Pengenalan Database & SQL',                   'url' => 'https://www.youtube.com/watch?v=7S_tz1z_5bA', 'duration' => '20 menit'],
                    ['title' => 'DDL: CREATE, ALTER & DROP Table',             'url' => 'https://www.youtube.com/watch?v=zbMHLJ0dY4w', 'duration' => '28 menit'],
                    ['title' => 'DML: INSERT, UPDATE, DELETE & SELECT',        'url' => 'https://www.youtube.com/watch?v=p3qvj9hO_Bo', 'duration' => '35 menit'],
                    ['title' => 'JOIN, Relasi Antar Tabel & Subquery',         'url' => 'https://www.youtube.com/watch?v=9yeOJ0ZMUYw', 'duration' => '38 menit'],
                    ['title' => 'Optimasi Query, Index & Best Practice',       'url' => 'https://www.youtube.com/watch?v=BHwzDmr6d7s', 'duration' => '27 menit'],
                ],
            ],

            // ============================================================
            // 6. Git & GitHub – GRATIS – MENENGAH
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'Git & GitHub – Version Control untuk Developer',
                    'description'    => 'Git adalah skill wajib bagi setiap developer profesional. Di course ini Anda belajar konsep version control, cara kerja Git, branching dan merging, kolaborasi tim dengan GitHub, serta Pull Request dan Code Review layaknya tim developer nyata.',
                    'price'          => 0,
                    'level'          => 'menengah',
                    'category'       => 'Tools & DevOps',
                    'is_free'        => true,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '2 jam 5 menit',
                ],
                'videos' => [
                    ['title' => 'Apa Itu Git & Version Control?',          'url' => 'https://www.youtube.com/watch?v=RGOj5yH7evk', 'duration' => '18 menit'],
                    ['title' => 'Git Init, Add, Commit & Push ke GitHub',  'url' => 'https://www.youtube.com/watch?v=Uszj_k0DGsg', 'duration' => '25 menit'],
                    ['title' => 'Branching, Checkout & Merging di Git',    'url' => 'https://www.youtube.com/watch?v=e9lnsKot_SQ', 'duration' => '30 menit'],
                    ['title' => 'Kolaborasi Tim & Fork di GitHub',         'url' => 'https://www.youtube.com/watch?v=MnUd31TvBoU', 'duration' => '28 menit'],
                    ['title' => 'Pull Request, Code Review & Konflik',     'url' => 'https://www.youtube.com/watch?v=Q1kHG842HoI', 'duration' => '24 menit'],
                ],
            ],

            // ============================================================
            // 7. Laravel – Rp 200.000 – MENENGAH
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'Laravel Framework – PHP Modern Pola MVC',
                    'description'    => 'Laravel adalah framework PHP paling populer di Indonesia. Pelajari instalasi, routing, controller, Blade templating, Eloquent ORM, database migration, autentikasi bawaan Laravel, middleware, hingga cara deploy aplikasi ke hosting/VPS secara langsung.',
                    'price'          => 200000,
                    'level'          => 'menengah',
                    'category'       => 'Backend',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '3 jam 45 menit',
                ],
                'videos' => [
                    ['title' => 'Instalasi Laravel & Struktur Folder Project', 'url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE', 'duration' => '22 menit'],
                    ['title' => 'Routing, Controller & View Blade',            'url' => 'https://www.youtube.com/watch?v=MYyJ4PuL4pY', 'duration' => '40 menit'],
                    ['title' => 'Eloquent ORM & Database Migration',           'url' => 'https://www.youtube.com/watch?v=V1HMXOlPUTY', 'duration' => '45 menit'],
                    ['title' => 'Authentication Bawaan & Middleware',          'url' => 'https://www.youtube.com/watch?v=mFXCIKRZsFQ', 'duration' => '38 menit'],
                    ['title' => 'Project: Deploy Laravel ke cPanel/VPS',       'url' => 'https://www.youtube.com/watch?v=gE1B03Cs-pE', 'duration' => '40 menit'],
                ],
            ],

            // ============================================================
            // 8. React.js – Rp 200.000 – MAHIR
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'React.js – Frontend Modern & Interaktif',
                    'description'    => 'React.js adalah library JavaScript paling dicari di dunia kerja. Pelajari konsep JSX, component-based architecture, props & state, React Hooks (useState & useEffect), fetch data dari REST API, hingga membangun dashboard interaktif sebagai project akhir.',
                    'price'          => 200000,
                    'level'          => 'mahir',
                    'category'       => 'Frontend',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '4 jam 5 menit',
                ],
                'videos' => [
                    ['title' => 'Pengenalan React.js & JSX Syntax',        'url' => 'https://www.youtube.com/watch?v=w7ejDZ8SWv8', 'duration' => '25 menit'],
                    ['title' => 'Component, Props & Komposisi UI',         'url' => 'https://www.youtube.com/watch?v=4UZrsTqkcW4', 'duration' => '38 menit'],
                    ['title' => 'React Hooks: useState & useEffect',       'url' => 'https://www.youtube.com/watch?v=TNhaISOUy6Q', 'duration' => '45 menit'],
                    ['title' => 'Fetch Data REST API dengan React',        'url' => 'https://www.youtube.com/watch?v=T3Px88x_PsA', 'duration' => '40 menit'],
                    ['title' => 'Project: Dashboard Interaktif dengan React', 'url' => 'https://www.youtube.com/watch?v=mxK8b99iJTg', 'duration' => '37 menit'],
                ],
            ],

            // ============================================================
            // 9. Node.js & Express – Rp 250.000 – MAHIR
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'Node.js & Express – Membangun REST API Backend',
                    'description'    => 'Node.js memungkinkan Anda menulis backend dengan JavaScript. Di course ini Anda belajar arsitektur REST API, Express.js routing & middleware, koneksi database dengan Sequelize/Mongoose, autentikasi JWT yang aman, rate limiting, hingga deploy API ke Railway atau Heroku.',
                    'price'          => 250000,
                    'level'          => 'mahir',
                    'category'       => 'Backend',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '4 jam 30 menit',
                ],
                'videos' => [
                    ['title' => 'Pengenalan Node.js, NPM & Arsitektur',   'url' => 'https://www.youtube.com/watch?v=fBNz5xF-Kx4', 'duration' => '22 menit'],
                    ['title' => 'Express.js: Routing & Middleware',        'url' => 'https://www.youtube.com/watch?v=L72fhGm1tfE', 'duration' => '40 menit'],
                    ['title' => 'Koneksi Database & ORM (Sequelize)',      'url' => 'https://www.youtube.com/watch?v=ExUYKeoHEhE', 'duration' => '48 menit'],
                    ['title' => 'JWT Authentication & Keamanan API',       'url' => 'https://www.youtube.com/watch?v=mbsmsi7l3r4', 'duration' => '42 menit'],
                    ['title' => 'Deploy REST API ke Railway & Testing',    'url' => 'https://www.youtube.com/watch?v=l134cBAJCuc', 'duration' => '38 menit'],
                ],
            ],

            // ============================================================
            // 10. Flutter – Rp 300.000 – MAHIR
            // ============================================================
            [
                'data' => [
                    'instructor_id'  => $instructor->id,
                    'title'          => 'Flutter – Aplikasi Mobile Android & iOS dari Nol',
                    'description'    => 'Flutter by Google adalah teknologi terdepan untuk membangun aplikasi mobile yang berjalan di Android dan iOS sekaligus dari satu codebase. Pelajari Dart, Widget, Layout, Navigation, State Management dengan Provider, integrasi REST API, hingga proses build dan publish ke Play Store.',
                    'price'          => 300000,
                    'level'          => 'mahir',
                    'category'       => 'Mobile',
                    'is_free'        => false,
                    'is_published'   => true,
                    'total_students' => 0,
                    'rating'         => 0.0,
                    'total_videos'   => 5,
                    'duration'       => '5 jam 15 menit',
                ],
                'videos' => [
                    ['title' => 'Setup Flutter, Dart Basics & Hello World',  'url' => 'https://www.youtube.com/watch?v=VPvVD8t02U8', 'duration' => '30 menit'],
                    ['title' => 'Widget, Layout & Navigasi Antar Halaman',   'url' => 'https://www.youtube.com/watch?v=TSIhiZ5jRB0', 'duration' => '55 menit'],
                    ['title' => 'State Management dengan Provider',           'url' => 'https://www.youtube.com/watch?v=d_m5csmrf7I', 'duration' => '60 menit'],
                    ['title' => 'HTTP Request & Integrasi REST API',         'url' => 'https://www.youtube.com/watch?v=1rXFKhBZXxY', 'duration' => '48 menit'],
                    ['title' => 'Build APK & Publish ke Google Play Store',  'url' => 'https://www.youtube.com/watch?v=g-0B_Vfc9qM', 'duration' => '42 menit'],
                ],
            ],
        ];

        foreach ($courses as $index => $courseData) {
            $course = Course::create($courseData['data']);
            foreach ($courseData['videos'] as $order => $video) {
                CourseVideo::create([
                    'course_id' => $course->id,
                    'title'     => $video['title'],
                    'video_url' => $video['url'],
                    'duration'  => $video['duration'],
                    'order'     => $order + 1,
                ]);
            }
            $this->command->info(($index + 1) . '. ✅ Course dibuat: ' . $courseData['data']['title']);
        }

        $this->command->info('');
        $this->command->info('🎉 Selesai! 10 course berhasil dibuat (3 Gratis + 7 Berbayar).');
    }
}
