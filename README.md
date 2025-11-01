# Sistem Absensi HIMA IF

Sistem informasi manajemen kehadiran pengurus Himpunan Mahasiswa Informatika (HIMA IF) berbasis web menggunakan Laravel.

## 🚀 Fitur Utama

### 1. **Manajemen Pengurus**
- CRUD data pengurus dengan role admin/pengurus
- Upload foto profil dengan sinkronisasi otomatis
- Filter dan pencarian pengurus berdasarkan divisi/periode
- Manajemen status pengurus (Aktif/Non-Aktif)

### 2. **Manajemen Acara**
- CRUD data acara dengan detail lengkap
- Status acara: Aktif/Selesai/Dibatalkan
- QR Code generator untuk setiap acara
- Tampilan acara yang sedang berlangsung di dashboard

### 3. **Presensi**
- Scan QR Code untuk presensi
- Status kehadiran: Hadir, Izin, Sakit
- Validasi waktu presensi (sesuai jadwal acara)
- Keterangan untuk izin/sakit

### 4. **Laporan Kehadiran** ⭐
- Filter berdasarkan tanggal, divisi, dan status
- Statistik kehadiran (Total, Hadir, Izin, Sakit) dengan persentase
- **Chart.js Visualization**:
  - Line Chart: Kehadiran per hari (7 hari terakhir)
  - Bar Chart: Kehadiran per kelas/divisi
- **Export Excel** dengan PhpSpreadsheet (format styled)
- **Print/PDF** dengan CSS khusus untuk print
- Pagination dan detail table presensi

### 5. **Dashboard**
- Ringkasan statistik (Total Pengurus, Total Acara)
- Acara yang sedang berlangsung (realtime)
- Acara mendatang
- Quick actions

### 6. **Profil & Autentikasi**
- Login dengan email & password
- Update profil dengan foto
- Change password
- Role-based access (Admin & Pengurus)

## 🛠️ Teknologi

- **Framework**: Laravel 10.x
- **Database**: MySQL
- **Frontend**: 
  - Tailwind CSS (Utility-first CSS)
  - Alpine.js (Interactivity)
  - Chart.js v4.4.0 (Data Visualization)
- **Authentication**: Laravel Breeze
- **QR Code**: SimpleSoftwareIO/simple-qrcode
- **Export Excel**: PhpOffice/PhpSpreadsheet
- **Alerts**: SweetAlert2

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/your-repo/AbsensiHimaIF-Laravel.git
cd AbsensiHimaIF-Laravel
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_hima_if
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder
```bash
php artisan migrate --seed
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Run Development Server
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite (jika diperlukan)
npm run dev
```

Akses: `http://localhost:8000`

## 👤 Default Login

**Admin:**
- Email: `admin@himaif.com`
- Password: `password`

**Pengurus:**
- Email: Sesuai data seeder
- Password: `password`

## 📂 Struktur Database

### Tables
- `users` - Data user (email, password, foto, role)
- `tb_pengurus` - Data pengurus (NIM, divisi, jabatan, periode)
- `tb_acara` - Data acara (nama, tanggal, waktu, tempat, qr_code)
- `tb_presensi_pengurus` - Data presensi (id_pengurus, id_acara, status, jam_scan)

## 🎨 Design System

### Color Palette
- **Primary**: Indigo (#6366f1)
- **Success**: Green (#10b981)
- **Warning**: Yellow (#f59e0b)
- **Danger**: Red (#ef4444)
- **Info**: Blue (#3b82f6)

### Logo
- File: `public/images/logo-hima-if.png`
- Format: PNG dengan background transparan
- Ukuran: 512x512px

## 📊 Laporan Export

### Excel Format
- **Headers**: Styled dengan background indigo, teks putih, borders
- **Auto-size columns**: Otomatis menyesuaikan lebar kolom
- **Data**: Tanggal, NIM/Nama, Kelas, Waktu, Status, Keterangan
- **Filename**: `Laporan_Kehadiran_YYYY-MM-DD_HHmmss.xlsx`

### Print/PDF
- Hide filter form dan buttons saat print
- Print-optimized layout
- Color-accurate dengan `print-color-adjust: exact`

## 🔧 Troubleshooting

### PhpSpreadsheet Error
```bash
composer clear-cache
composer install --no-interaction
```

### Storage Permission
```bash
chmod -R 775 storage bootstrap/cache
```

### QR Code Not Showing
Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

## 📝 Development Notes

### File Structure
```
app/
├── Http/Controllers/
│   ├── AcaraController.php
│   ├── PengurusController.php
│   ├── LaporanController.php ⭐
│   └── ProfileController.php
resources/views/
├── layouts/admin.blade.php (Main Layout)
├── acara/
├── pengurus/
├── laporan/ ⭐
├── presensi/
└── profile/
```

### Key Features Implementation
- **Photo Upload**: Menggunakan Laravel Storage dengan public disk
- **QR Code**: Generate unique QR per acara, simpan di storage
- **Charts**: Chart.js dengan data dari controller (aggregasi SQL)
- **Excel Export**: PhpSpreadsheet dengan styling manual
- **Print**: CSS `@media print` untuk hide elements

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

Developed with ❤️ for HIMA IF

---

**Version**: 1.0.0  
**Last Update**: November 2025
