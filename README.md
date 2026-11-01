# FinTrack

## Deskripsi
FinTrack adalah aplikasi pengelolaan keuangan pribadi yang digunakan untuk mencatat pemasukan dan pengeluaran. Aplikasi ini membantu user mengatur wallet, kategori transaksi, budget, dan rencana keuangan bulanan serta melihat laporan keuangan.

## Fitur
- Dashboard keuangan
- Pencatatan pemasukan dan pengeluaran
- Pengelolaan wallet
- Pengelolaan kategori
- Budget
- Monthly Plan
- Laporan keuangan
- Export transaksi
- Login dan registrasi

## Teknologi
- Laravel
- PHP
- Blade
- Database sesuai konfigurasi aplikasi

## Cara Menjalankan Aplikasi

### Persyaratan
- PHP
- Composer
- Database yang didukung dan dikonfigurasi untuk aplikasi

### Instalasi

1. Clone repository:

   `git clone https://github.com/Arelll1204/FinTrack.git`

2. Masuk ke folder project:

   `cd FinTrack`

3. Install dependency:

   `composer install`

4. Salin file konfigurasi:

   `cp .env.example .env`

5. Generate application key:

   `php artisan key:generate`

6. Sesuaikan konfigurasi database pada file `.env`.

7. Jalankan migration:

   `php artisan migrate`

8. Jalankan aplikasi:

   `php artisan serve`

9. Buka aplikasi melalui browser:

   `http://127.0.0.1:8000`

## Deployment
FinTrack telah di-deploy menggunakan Clever Cloud.

Link aplikasi:
https://fintrack.cleverapps.io/login

## Repository
https://github.com/Arelll1204/FinTrack
