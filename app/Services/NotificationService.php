<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

/**
 * NotificationService
 * Centralized service untuk membuat notifikasi ke seluruh role.
 * Semua event penting di sistem BuilderHub dikirim melalui service ini.
 */
class NotificationService
{
    /**
     * Buat satu notifikasi untuk user tertentu.
     */
    public static function send(int $userId, string $title, string $message, string $type = 'info', ?string $link = null): void
    {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'link'    => $link,
            'is_read' => false,
        ]);
    }

    /**
     * Kirim notifikasi ke semua user dengan role tertentu.
     */
    public static function sendToRole(string $role, string $title, string $message, string $type = 'info', ?string $link = null): void
    {
        User::where('role', $role)->chunk(100, function ($users) use ($title, $message, $type, $link) {
            foreach ($users as $user) {
                self::send($user->id, $title, $message, $type, $link);
            }
        });
    }

    /**
     * Kirim ke semua admin.
     */
    public static function sendToAdmins(string $title, string $message, string $type = 'info', ?string $link = null): void
    {
        self::sendToRole('admin', $title, $message, $type, $link);
    }

    // =========================================================
    // PROJECT EVENTS
    // =========================================================

    /**
     * Event: UMKM upload project baru → Admin + Semua Programmer terverifikasi
     */
    public static function projectSubmitted(int $umkmId, string $umkmName, string $projectTitle): void
    {
        // Notifikasi ke Admin
        self::sendToAdmins(
            '📋 Project Baru Menunggu ACC',
            "{$umkmName} mengajukan project baru: \"{$projectTitle}\". Silakan tinjau dan setujui.",
            'project_pending',
            '/admin/dashboard'
        );

        // Notifikasi ke semua Programmer terverifikasi
        // (hanya dikirim setelah admin ACC, jadi ini dikirim di approveProject)
    }

    /**
     * Event: Admin ACC project UMKM → UMKM pemilik + semua Programmer terverifikasi
     */
    public static function projectApproved(int $umkmId, string $projectTitle, int $projectId): void
    {
        // Notifikasi ke UMKM pemilik
        self::send(
            $umkmId,
            '✅ Project Disetujui Admin!',
            "Project \"{$projectTitle}\" Anda telah disetujui dan dipublikasikan. Programmer sekarang bisa mengajukan penawaran!",
            'project_approved',
            '/umkm/dashboard#projects'
        );

        // Notifikasi ke semua Programmer terverifikasi — ada project baru!
        User::where('role', 'programmer')->where('is_verified', true)->chunk(100, function ($programmers) use ($projectTitle) {
            foreach ($programmers as $programmer) {
                self::send(
                    $programmer->id,
                    '🔥 Project Baru Tersedia!',
                    "Ada project baru yang bisa Anda ambil: \"{$projectTitle}\". Ajukan penawaran sekarang!",
                    'new_project',
                    '/programmer/dashboard#projects'
                );
            }
        });
    }

    /**
     * Event: UMKM menolak project (admin hapus) → UMKM pemilik
     */
    public static function projectRejected(int $umkmId, string $projectTitle): void
    {
        self::send(
            $umkmId,
            '❌ Project Ditolak Admin',
            "Project \"{$projectTitle}\" Anda tidak disetujui oleh admin. Silakan ajukan ulang dengan deskripsi yang lebih lengkap.",
            'project_rejected',
            '/umkm/dashboard'
        );
    }

    // =========================================================
    // BID EVENTS
    // =========================================================

    /**
     * Event: UMKM terima bid → Programmer yang bid
     */
    public static function bidAccepted(int $programmerId, string $umkmName, string $projectTitle, string $amount): void
    {
        self::send(
            $programmerId,
            '🎉 Penawaran Anda Diterima!',
            "{$umkmName} menerima penawaran Anda sebesar {$amount} untuk project \"{$projectTitle}\". Segera mulai pengerjaan!",
            'bid_accepted',
            '/programmer/dashboard#overview'
        );
    }

    /**
     * Event: UMKM tolak bid → Programmer yang bid
     */
    public static function bidRejected(int $programmerId, string $umkmName, string $projectTitle, bool $isPermanent): void
    {
        if ($isPermanent) {
            self::send(
                $programmerId,
                '❌ Penawaran Ditolak Permanen',
                "{$umkmName} menolak penawaran Anda untuk project \"{$projectTitle}\". Anda tidak dapat mengajukan ulang.",
                'bid_rejected',
                '/programmer/dashboard#overview'
            );
        } else {
            self::send(
                $programmerId,
                '⚠️ Penawaran Ditolak — Bisa Ajukan Ulang',
                "{$umkmName} menolak penawaran Anda untuk project \"{$projectTitle}\". Anda masih bisa mengajukan penawaran kembali dengan revisi.",
                'bid_rejected',
                '/programmer/dashboard#overview'
            );
        }
    }

    /**
     * Event: Project selesai → Programmer
     */
    public static function projectCompleted(int $programmerId, string $projectTitle, string $earning): void
    {
        self::send(
            $programmerId,
            '🏆 Project Selesai — Pembayaran Dikirim!',
            "Project \"{$projectTitle}\" telah diselesaikan. Pendapatan {$earning} (20%) sedang diproses ke akun Anda.",
            'project_completed',
            '/programmer/dashboard#overview'
        );
    }

    // =========================================================
    // COURSE EVENTS
    // =========================================================

    /**
     * Event: Programmer buat/submit course → Admin
     */
    public static function courseSubmitted(int $instructorId, string $instructorName, string $courseTitle): void
    {
        self::sendToAdmins(
            '📚 Course Baru Menunggu Review',
            "{$instructorName} mengajukan course baru: \"{$courseTitle}\". Tinjau dan publikasikan jika layak.",
            'course_pending',
            '/admin/courses'
        );
    }

    /**
     * Event: Admin publish/ACC course → Instructor (programmer) + semua Pelajar
     */
    public static function coursePublished(int $instructorId, string $instructorName, string $courseTitle, int $courseId): void
    {
        // Notifikasi ke instructor
        self::send(
            $instructorId,
            '🎉 Course Anda Dipublikasikan!',
            "Course \"{$courseTitle}\" Anda telah disetujui admin dan sekarang live! Pelajar bisa mendaftarkan diri.",
            'course_published',
            '/programmer/dashboard#courses'
        );

        // Notifikasi ke semua Pelajar (role = course)
        User::where('role', 'course')->chunk(100, function ($students) use ($instructorName, $courseTitle) {
            foreach ($students as $student) {
                self::send(
                    $student->id,
                    '🆕 Course Baru Tersedia!',
                    "Course baru dari {$instructorName}: \"{$courseTitle}\" sudah tersedia. Yuk daftarkan diri sekarang!",
                    'new_course',
                    '/course-manager/dashboard?search=' . urlencode($courseTitle) . '#explore'
                );
            }
        });
    }

    /**
     * Event: Admin sembunyikan/unpublish course → Instructor
     */
    public static function courseUnpublished(int $instructorId, string $courseTitle): void
    {
        self::send(
            $instructorId,
            '⚠️ Course Disembunyikan Admin',
            "Course \"{$courseTitle}\" Anda telah disembunyikan dari halaman publik oleh admin. Hubungi admin untuk informasi lebih lanjut.",
            'course_unpublished',
            '/programmer/dashboard#courses'
        );
    }

    // =========================================================
    // VERIFICATION EVENTS
    // =========================================================

    /**
     * Event: Admin verifikasi Programmer → Programmer
     */
    public static function programmerVerified(int $programmerId, string $programmerName): void
    {
        self::send(
            $programmerId,
            '✅ Akun Anda Terverifikasi!',
            "Selamat! Akun programmer Anda telah diverifikasi oleh admin. Anda sekarang bisa mengajukan penawaran ke project UMKM.",
            'account_verified',
            '/programmer/dashboard'
        );
    }

    /**
     * Event: Admin verifikasi UMKM → UMKM
     */
    public static function umkmVerified(int $umkmId, string $umkmName): void
    {
        self::send(
            $umkmId,
            '✅ Akun UMKM Anda Terverifikasi!',
            "Selamat! Akun UMKM Anda telah diverifikasi oleh admin. Badge \"UMKM Verified\" kini tampil di profil Anda.",
            'account_verified',
            '/umkm/dashboard'
        );
    }

    /**
     * Event: Admin approve portofolio → Programmer
     */
    public static function portfolioApproved(int $programmerId, string $portfolioTitle): void
    {
        self::send(
            $programmerId,
            '✅ Portofolio Disetujui!',
            "Portofolio \"{$portfolioTitle}\" Anda telah disetujui admin. Progress verifikasi profil Anda meningkat!",
            'portfolio_approved',
            '/programmer/dashboard#verify'
        );
    }

    /**
     * Event: Admin tolak portofolio → Programmer
     */
    public static function portfolioRejected(int $programmerId, string $portfolioTitle): void
    {
        self::send(
            $programmerId,
            '❌ Portofolio Ditolak',
            "Portofolio \"{$portfolioTitle}\" Anda ditolak admin. Pastikan portofolio Anda relevan dan berkualitas, lalu coba ajukan kembali.",
            'portfolio_rejected',
            '/programmer/dashboard#verify'
        );
    }

    /**
     * Event: Admin approve sertifikat → Programmer
     */
    public static function certificateApproved(int $programmerId, string $certName): void
    {
        self::send(
            $programmerId,
            '✅ Sertifikat Disetujui!',
            "Sertifikat \"{$certName}\" Anda telah disetujui admin. Progress verifikasi profil Anda meningkat!",
            'certificate_approved',
            '/programmer/dashboard#verify'
        );
    }

    /**
     * Event: Admin tolak sertifikat → Programmer
     */
    public static function certificateRejected(int $programmerId, string $certName): void
    {
        self::send(
            $programmerId,
            '❌ Sertifikat Ditolak',
            "Sertifikat \"{$certName}\" Anda ditolak admin. Pastikan sertifikat valid dan terbaca dengan jelas.",
            'certificate_rejected',
            '/programmer/dashboard#verify'
        );
    }
}
