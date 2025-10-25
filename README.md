# ᮓ AksaraQuest

![Screenshot Halaman Dashboard AksaraQuest](./images/screenshot.png)

<h3 align="center">
  <a href="https://aksaraquest.anopus.my.id" target="_blank">🚀 Buka Live Demo 🚀</a>
</h3>

**AksaraQuest** adalah sebuah platform web _gamifikasi_ modern yang dirancang untuk merevitalisasi dan mempopulerkan kembali Aksara Sunda melalui pengalaman belajar yang interaktif, terstruktur, dan menyenangkan. Proyek ini dibangun dengan fokus pada detail, pengalaman pengguna yang memuaskan, dan fondasi teknis yang profesional.

---

## 🚀 Filosofi Proyek

Proyek ini lahir dari keinginan untuk menciptakan solusi atas kurangnya platform digital yang menarik bagi generasi muda untuk mempelajari Aksara Sunda. Dengan pendekatan seperti Duolingo, AksaraQuest mengubah proses belajar dari hafalan monoton menjadi sebuah petualangan yang memotivasi. Logo aplikasi ini menggunakan aksara **"Da" (ᮓ)**, yang melambangkan **"Dalan"** atau **"Jalan"**, merepresentasikan sebuah proses dan perjalanan belajar yang terstruktur di dalam aplikasi ini.

---

## ✨ Fitur Unggulan

Aplikasi ini dikemas dengan fitur-fitur canggih untuk menciptakan ekosistem pembelajaran yang lengkap, dari pemula hingga mahir, dengan kontrol penuh bagi administrator.

### Untuk Pengguna:

-   **Jalur Pembelajaran Terstruktur**: Alur belajar seperti Duolingo yang memandu pengguna dari bab ke bab. Pelajaran baru akan terbuka hanya setelah pengguna lulus kuis dari pelajaran sebelumnya.
-   **Arena Kuis Cerdas**:
    -   **4 Tipe Soal Berbeda**: Kenali karakter, cari karakter, dengarkan & kenali nama, dengarkan & cari karakter.
    -   **Sistem Adaptif**: Algoritma cerdas yang secara otomatis memberikan lebih banyak soal pada aksara yang menjadi kelemahan pengguna.
-   **Mode Dongeng Interaktif**: Pengalaman membaca cerita rakyat Sunda dalam aksara asli, dengan fitur "klik-untuk-terjemahan" yang inovatif untuk melihat transliterasi Latin setiap kata.
-   **Sistem Progresi Lengkap**:
    -   **XP & Level**: Pengguna mendapatkan XP dari setiap kuis untuk menaikkan Level.
    -   **Streak Harian**: Sistem "api" yang memberi penghargaan kepada pengguna karena belajar setiap hari berturut-turut untuk membangun kebiasaan.
-   **Sistem Prestasi & Papan Peringkat**: Puluhan lencana (_achievement_) untuk berbagai pencapaian dan papan peringkat global untuk membandingkan total XP dan _streak_ terpanjang.
-   **Latihan Fokus Personal**: Halaman khusus yang secara otomatis mendeteksi aksara terlemah pengguna dan menyediakan sesi latihan yang tertarget.
-   **Ujian Sertifikasi**: Setelah semua pelajaran selesai, pengguna bisa mengambil ujian akhir komprehensif untuk mendapatkan sertifikat digital "Master Aksara Sunda" yang dapat diunduh.

### Untuk Admin:

-   **Panel Admin Komprehensif**: Antarmuka CRUD (Create, Read, Update, Delete) penuh yang memungkinkan admin mengelola **semua konten dinamis** aplikasi tanpa menyentuh kode, termasuk:
    -   Manajemen Aksara (termasuk upload file audio).
    -   Manajemen Kurikulum (Bab & Pelajaran).
    -   Manajemen Bank Soal.
    -   Manajemen Dongeng (termasuk editor konten kata per kata).

---

## 🛠️ Dibangun Dengan Teknologi

-   **Backend**: Laravel 12
-   **Frontend**: Vue.js 3 & Inertia.js
-   **Database**: MySQL
-   **Styling**: Tailwind CSS
-   **Lingkungan Pengembangan**: Docker (Laravel Sail)

---

## ⚙️ Instalasi & Setup (Lokal dengan Docker)

1.  _Clone_ repositori ini: `git clone https://github.com/haerulyudaaditiya/aksaraquest.git`
2.  Masuk ke direktori: `cd aksaraquest`
3.  Salin file environment: `cp .env.example .env`
4.  Jalankan Docker Sail: `sail up -d`
5.  Install dependensi:
    ```bash
    sail composer install
    sail npm install --legacy-peer-deps
    ```
6.  Generate kunci aplikasi: `sail artisan key:generate`
7.  Jalankan migrasi dan seeder untuk membangun database dan mengisi semua konten awal:
    ```bash
    sail artisan migrate:fresh --seed
    ```
8.  Jalankan server Vite untuk _hot-reloading_: `sail npm run dev`
9.  Akses aplikasi di `http://localhost`.
