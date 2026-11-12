# Sistem Presensi & Laporan Presensi (Laravel 12)

Aplikasi manajemen presensi karyawan dan pelaporan kehadiran terintegrasi berbasis **Laravel 12**. Proyek ini dirancang untuk memenuhi seluruh **Requirement Wajib (5.1 – 5.8)** dan **Requirement Bonus (6)** sesuai dokumen panduan tugas magang (*Task_Presensi_Laravel - for intern.docx*).

---

## 🚀 Fitur Utama

### 1. Database & Relasi Model (Requirement 5.1)
* **Relasi One-to-Many:** Model `User` memiliki relasi `hasMany(Attendance::class)` dan model `Attendance` memiliki relasi `belongsTo(User::class)`.
* **Integritas Data:** Skema database memiliki constraint unik `unique(['user_id', 'date'])` untuk menjamin 1 user hanya memiliki 1 catatan presensi per hari.
* **Seeder & Factory Otomatis:** Menghasilkan 12 akun pengguna (termasuk akun uji) dan 84 data presensi realistis dengan status Hadir, Terlambat, Izin, dan Sakit.

### 2. Fitur Pencatatan Presensi (Requirement 5.2)
* **Check-in Otomatis:** Mencatat waktu masuk (`time_in`). Status kehadiran ditentukan otomatis berdasarkan batas waktu:
  * Waktu <= 08:00 WIB: **Hadir** (Tepat Waktu).
  * Waktu > 08:00 WIB: **Terlambat**.
* **Pencegahan Check-in Ganda:** Sistem menolak jika user telah melakukan presensi pada hari yang sama.
* **Check-out:** Mencatat waktu keluar (`time_out`). Sistem memvalidasi bahwa user wajib melakukan check-in terlebih dahulu sebelum dapat melakukan check-out.
* **Keterangan Izin & Sakit:** Pencatatan presensi khusus tanpa jam masuk/keluar (`time_in` & `time_out` bernilai `null`). Status Izin/Sakit tidak mengizinkan aksi check-out.

### 3. Tampilan Daftar Presensi (Requirement 5.3)
* Tabel data presensi terstruktur memuat kolom: Nomor urut, Nama Karyawan, Email, Tanggal, Jam Masuk, Jam Pulang, dan Badge Status Presensi.

### 4. Pencarian, Multi-Filter & Sorting Dinamis (Requirement 5.4)
* **Pencarian Nama:** Mencari karyawan berdasarkan potongan nama (`search`).
* **Filter Dropdown User:** Memfilter catatan presensi milik karyawan tertentu (`user_id`).
* **Filter Tanggal Spesifik:** Memfilter presensi pada satu tanggal tertentu (`date`).
* **Filter Rentang Tanggal:** Memfilter presensi dari tanggal awal hingga akhir (`start_date` & `end_date`).
* **Filter Bulan & Tahun:** Memfilter presensi pada bulan (1–12) dan tahun tertentu (`month` & `year`).
* **Filter Status:** Memfilter berdasarkan status `Hadir`, `Terlambat`, `Izin`, atau `Sakit`.
* **Kombinasi Multi-Filter:** Seluruh filter dapat digunakan secara bersamaan.
* **Sorting Dinamis:** Data dapat diurutkan berdasarkan Tanggal, Nama User, Jam Masuk, Jam Keluar, atau Status, baik secara **Menaik (Ascending)** maupun **Menurun (Descending)**.
* **Reset Filter:** Tombol sekali klik untuk membersihkan seluruh parameter pencarian dan filter.

### 5. Pagination dengan Query String (Requirement 5.5)
* Menggunakan sistem pagination 10 data per halaman.
* Parameter pencarian, filter, dan sorting **tetap terbawa otomatis** saat berpindah antar halaman berkat implementasi `->withQueryString()`.

### 6. Empty State, Validasi & Error Handling (Requirement 5.6)
* Tampilan visual informatif saat data presensi tidak ditemukan sesuai kriteria filter, lengkap dengan tombol reset.
* Validasi ketat pada backend untuk seluruh parameter filter dan input form presensi.
* Pesan notifikasi ramah (Flash Message: Sukses & Error).

### 7. Ringkasan Dinamis / Summary (Requirement 5.7)
* Kartu metrik ringkasan (Total Presensi, Hadir, Terlambat, Izin, Sakit) yang **secara dinamis mengikuti hasil filter aktif**, bukan selalu menghitung total keseluruhan tabel.

### 8. Export Laporan PDF (Requirement 5.8)
* Menggunakan library `barryvdh/laravel-dompdf`.
* Format dokumen landscape A4 dengan:
  * Kop resmi laporan presensi.
  * **Informasi parameter filter yang sedang aktif** (misal: Pencarian, Periode Tanggal, Bulan/Tahun, Status).
  * Ringkasan angka statistik.
  * Tabel data presensi lengkap.
  * Tempat tanda tangan / pengesahan HRD.
  * Penamaan file otomatis: `laporan-presensi-YYYY-MM-DD.pdf`.

### 9. Fitur Bonus (Requirement 6)
* **Export CSV:** Unduh laporan berformat CSV via route `/attendances/report/csv` dengan data yang selaras dengan filter aktif.
* **Dashboard Visualisasi:** Dashboard modern dengan Donut Chart (Chart.js) untuk visualisasi persentase kehadiran dan tabel presensi hari ini.
* **Automated Testing:** 19 pengujian otomatis (PHPUnit Feature & Unit tests) dengan 42 assertions yang mencakup seluruh alur presensi, filtering, sorting, pagination, dan ekspor file.
* **Antarmuka Responsif & Modern:** Desain antarmuka bersih menggunakan Google Font *Plus Jakarta Sans*, palet warna modern, dan tata letak responsif untuk desktop maupun mobile.

---

## 🛠️ Arsitektur Aplikasi & Skema Database

### Alur Request Lifecycle (MVC)
```
Browser / Klien 
       ↓ HTTP Request
 routes/web.php (Routing & Middleware Auth)
       ↓
 AttendanceController / DashboardController / ReportController
       ↓ Query Eloquent & Validation
 Database (SQLite / MySQL)
       ↓ Model (User & Attendance)
 View (Blade Template) / PDF Response / CSV Stream
       ↓ HTTP Response
Browser / Klien
```

### Relasi Database
* **Tabel `users`**:
  * `id` (PK)
  * `name` (string)
  * `email` (string, unique)
  * `password` (hashed string)
  * `timestamps`
* **Tabel `attendances`**:
  * `id` (PK)
  * `user_id` (FK -> `users.id`, cascade on delete)
  * `date` (date)
  * `time_in` (time, nullable)
  * `time_out` (time, nullable)
  * `status` (enum: `'Hadir', 'Terlambat', 'Izin', 'Sakit'`)
  * `timestamps`
  * *Unique Key:* `['user_id', 'date']`

---

## 💻 Panduan Instalasi & Menjalankan Aplikasi

### 1. Prasyarat Sistem
* PHP >= 8.2 (dengan ekstensi `pdo_sqlite`, `pdo_mysql`, `mbstring`, `dom`, `fileinfo`)
* Composer
* Node.js & NPM (opsional, aset CSS murni telah disertakan)

### 2. Langkah Instalasi

1. **Clone repository atau buka direktori proyek:**
   ```bash
   cd c:\Users\User\sistem-presensi
   ```

2. **Pastikan file konfigurasi `.env` telah tersedia:**
   Jika belum ada, salin dari `.env.example`:
   ```bash
   cp .env.example .env
   ```

3. **Install dependensi PHP via Composer:**
   ```bash
   composer install
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Database Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Perintah ini akan membuat database SQLite otomatis dan mengisi 12 user serta 84 data presensi uji coba.*

6. **Jalankan Server Development:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser di: [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 🔑 Akun Uji Coba (Demo Credentials)

Untuk menguji seluruh fitur yang memerlukan login:

| Peran | Alamat Email | Kata Sandi |
| :--- | :--- | :--- |
| **Administrator** | `admin@presensi.com` | `password123` |
| **Karyawan Magang** | `intern@presensi.com` | `password123` |
| **Akun Pribadi** | `rachmat.akbar@jakarta.go.id` | `password123` |
---

## 🧪 Menjalankan Pengujian Otomatis (Automated Tests)

Test suite dikonfigurasi menggunakan SQLite in-memory (`:memory:`) sehingga berjalan cepat tanpa konfigurasi database tambahan:

```bash
php artisan test
```

### Hasil Test Suite:
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\AttendanceTest
  ✓ guest is redirected to login
  ✓ authenticated user can view attendances page
  ✓ user can check in successfully
  ✓ check in after eight am is marked as terlambat
  ✓ duplicate check in on same day is prevented
  ✓ user can check out after check in
  ✓ check out without prior check in is prevented
  ✓ user can record izin or sakit without check in out
  ✓ filter by user name search
  ✓ filter by status
  ✓ filter by date range
  ✓ filter by month and year
  ✓ sorting by date asc and desc
  ✓ pdf export returns pdf stream with active filters
  ✓ csv export returns stream with headers
  ✓ pagination preserves query string parameters

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response
  ✓ authenticated user can view user detail report

  Tests:    19 passed (42 assertions)
```
