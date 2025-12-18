<div align="center">
<h2>SIMAEL</h2>
  <p>
    Sistem Manajemen Kelompok PKL untuk SMK Media Informatika
    <br />
  </p>
    <br />
    <img src="https://img.shields.io/badge/Status-Production-green?style=for-the-badge">
    <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge">
    <img src="https://img.shields.io/badge/Build%20with-Vite-yellow?style=for-the-badge">
    <br />
    <br />
</div>

## About

Simael adalah aplikasi web yang dirancang untuk mempermudah proses pembuatan dan pengelolaan kelompok pkl di lingkungan sekolah. aplikasi ini menggantikan proses manual menggunakan kertas dan input data yang berulang, serta menyediakan platform terpusat bagi murid dan guru dalam mengatur data kelompok, status, dan tujuan perusahaan PKL.

Aplikasi ini digunakan secara internal oleh sekolah, namun dapat di-host agar dapat diakses murid dari luar lingkungan sekolah dengan tetap memperhatikan aspek keamanan.


**Project dikelola dan dipelihara oleh [Maintainer SIMAEL](MAINTAINER.md)**

---

## Fitur Utama

### Fitur untuk Murid

* Membuat dan mengelola Squad PKL (Create Squad, Edit Status, Edit Informasi Perusahaan).
* Mengundang anggota ke Squad.

### Fitur untuk Guru

* Memonitor seluruh Squad yang terdaftar.
* Melihat detail status, anggota, dan informasi perusahaan tujuan.
* Memverifikasi akun murid agar murid dapat membuat atau menerima undangan Squad.
  Verifikasi ini membantu mencegah akun penyusup dan memastikan data murid valid.

### Sistem Akses

* Tidak ada sistem role konvensional.
* Guru dan murid dipisahkan melalui middleware dan memiliki route serta view yang berbeda.
* Memberikan fleksibilitas pengembangan tanpa bergantung pada role bawaan Laravel.

---

## Teknologi dan Requirement

* **Laravel**: 12
* **PHP**: Sesuai requirement Laravel 12
* **Database**: MySQL
* **Dependency Manager**: Composer
* **Frontend Tools**: Node.js dan NPM (untuk Tailwind CSS)

---

## Instalasi dan Setup

Ikuti langkah-langkah berikut untuk menjalankan project secara lokal:

### 1. Clone Repository

```bash
git clone <repository-url>
cd simael
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database dan parameter lain pada file `.env`.

### 4. Migrasi Database

```bash
php artisan migrate
```

Tambahkan seeder jika diperlukan.

### 5. Menjalankan Development Server

Proyek menyediakan script untuk menjalankan backend dan frontend secara bersamaan:

```bash
npm run dev
```

Script ini akan menjalankan `php artisan serve` dan `npm run dev` simultan.

### 6. Build Frontend untuk Production

```bash
npm run build
```

---

## Struktur dan Arsitektur

Project ini mengikuti struktur standar Laravel dengan beberapa penambahan logika akses:

* `app/Http/Middleware`
  Middleware khusus untuk memisahkan akses murid dan guru.

* `app/Models`
  Berisi model seperti `Squad`, `Invite`, dan model akun murid/guru.

* `app/Http/Controllers`
  Controller dipisah berdasarkan jenis pengguna (Student / Guru) untuk menjaga arsitektur yang terorganisir.

* `routes/`
  Route untuk murid dan guru dipisahkan ke file berbeda sesuai kebutuhan.

---

## Standar Commit dan Workflow

Tim menggunakan standar commit sebagai berikut:

### Untuk Commit di Luar PR

Menggunakan format `[context] Description`, misalnya:

```
[dashboard] Add squad status in student dashboard
```

### Untuk Commit di Dalam Pull Request

Mengikuti gaya conventional commit:

```
feat(model/squad): Add status to $fillable
```

### Judul Pull Request

Menggunakan format:

```
[context] Description
```

Ini untuk menjaga konsistensi dan keterbacaan pada riwayat commit.

---

## Deployment

Proses deployment mengikuti prosedur Laravel pada umumnya, termasuk:

* Upload source code
* Install dependency menggunakan Composer dan NPM
* Konfigurasi environment production
* Menjalankan migrasi
* Build frontend (`npm run build`)
* Konfigurasi web server (Nginx/Apache)

Jika server menyediakan PHP-FPM atau panel lain, sesuaikan dengan penyedia host.

---

## Lisensi

Lisensi Project ini menggunakan [MIT License](https://github.com/simaelworks/simael/blob/main/LICENSE.md)

## Kontribusi

Kontribusi sangat diperbolehkan. [Maintainer SIMAEL](MAINTAINER.md) membutuhkan kontribusi kalian agar project ini terus stabil.

Silahkan buka [Pull Request](https://github.com/simaelworks/simael/pulls) untuk mengirim kontribusi!
