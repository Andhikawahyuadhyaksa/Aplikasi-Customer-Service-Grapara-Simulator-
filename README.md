# Grapara Customer Service Application (Simulator)

Grapara adalah aplikasi manajemen antrian dan layanan customer untuk perusahaan telekomunikasi XUL. Aplikasi ini memungkinkan customer untuk mengambil nomor antrian, dan customer service (CS) untuk melayani customer serta merekam masalah yang dihadapi. Aplikasi ini juga dapat mengeluarkan laporan statistik layanan maupun kinerja tiap CS pada perioda waktu tertentu.

## Fitur

### Admin
1. **Mengelola Data User (CS dan Manajer)**
   - Create (insert)
   - Read (show)
   - Update
   - Delete

2. **Mengelola Data Meja Layanan**
   - Create (insert)
   - Read (show)
   - Update
   - Delete

### Customer
1. **Mengambil/Mendapatkan Nomor Antrian**
   - Memasukkan nomor ponsel untuk mendapatkan nomor antrian.

### Customer Service (CS)
1. **Sign Up dan Memasukkan Nomor Meja Tempat Bertugas**
   - Mendaftar dan memasukkan nomor meja tempat bertugas hari itu.

2. **Memilih Nomor Antrian**
   - Memilih nomor antrian (urutan teratas) yang belum dilayani.

3. **Merekam Masalah Customer**
   - Merekam masalah customer berdasarkan nomor antrian yang dipilih dan solusinya.

### Manajer Grapara
1. **Melihat Statistik Layanan Total**
   - Melihat statistik harian jumlah customer, total waktu layanan, dan rata-rata waktu layanan per customer.

2. **Melihat Statistik Layanan Per CS**
   - Melihat statistik harian per CS termasuk jumlah customer, total waktu layanan, dan rata-rata waktu layanan per customer.

3. **Mendapatkan Laporan Mingguan**
   - Mendapatkan laporan mingguan dari CS yang kinerjanya di atas rata-rata berdasarkan jumlah customer dan waktu layanan per minggu.

## Data yang Dikelola

1. **Pengguna**
   - Data CS dan Manajer.

2. **Meja Layanan**
   - Data meja layanan yang tersedia.

3. **Nomor Ponsel dan Antrian**
   - Data nomor ponsel customer dan nomor antrian.

4. **Transaksi Layanan Customer**
   - Data transaksi layanan yang mencakup waktu mulai, waktu akhir, masalah, dan solusi.

## Teknologi yang Digunakan

- PHP: Bahasa pemrograman utama untuk pengembangan aplikasi ini.
- XAMPP: Database yang digunakan untuk menyimpan data.

## Instalasi

1. Clone repository ini:
   ```bash
   git clone https://github.com/Andhikawahyuadhyaksa/Aplikasi-Customer-Service-Grapara-Simulator-
