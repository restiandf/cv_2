# Portfolio Database System

Sistem database untuk mengelola konten portfolio secara dinamis tanpa perlu mengedit kode.

## 🚀 Fitur

- **Manajemen Projects**: Tambah, edit, haus project dengan upload gambar
- **About Section**: Kelola konten halaman about me
- **Skills Management**: Tambah/hapus skills dengan kategori
- **Contact Info**: Update informasi kontak dan social media
- **Admin Panel**: Interface yang user-friendly untuk mengelola semua konten
- **Dynamic Content**: Semua konten dimuat dari database

## 📋 Requirements

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx) atau Laragon/XAMPP
- Browser modern

## 🔧 Instalasi

### 1. Setup Database

Buka phpMyAdmin atau MySQL command line, lalu import file SQL:

```bash
# Jika menggunakan command line
mysql -u root -p < database/portfolio_db.sql
```

Atau melalui phpMyAdmin:
1. Buka http://localhost/phpmyadmin
2. Buat database baru dengan nama `portfolio_db`
3. Import file `database/portfolio_db.sql`

### 2. Konfigurasi Database

Edit file `config/database.php` sesuai dengan setting database Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Username MySQL
define('DB_PASS', '');            // Password MySQL
define('DB_NAME', 'portfolio_db');
```

### 3. Setup Upload Directory

Pastikan folder `uploads/` memiliki permission yang benar:

```bash
# Windows
mkdir uploads

# Linux/Mac
mkdir uploads
chmod 755 uploads
```

### 4. Akses Admin Panel

Buka browser dan akses:

```
http://localhost/cv_2/admin/
```

Anda akan melihat dashboard dengan:
- Statistik projects
- Quick actions
- Recent projects

## 📱 Struktur Admin Panel

### Dashboard (`admin/index.php`)
- Overview statistik
- Quick actions untuk navigasi cepat
- Recent projects list

### Projects (`admin/projects.php`)
- Tambah project baru
- Edit project yang ada
- Upload gambar project
- Hapus project
- Set status (Published/Draft)

### About Me (`admin/about.php`)
- Edit hero section (title, subtitle, description)
- Upload hero background image
- Update education & certifications

### Skills (`admin/skills.php`)
- Tambah skills baru
- Pilih kategori (Frontend, Backend, Database, Tools, Other)
- Hapus skills

### Contact Info (`admin/contact.php`)
- Update email, phone, location
- Update social media links (GitHub, LinkedIn, Twitter)

## 🎯 Cara Menggunakan

### Menambahkan Project Baru

1. Login ke admin panel: `http://localhost/cv_2/admin/`
2. Klik "Projects" di sidebar
3. Klik "Add New Project"
4. Isi form:
   - **Title**: Nama project
   - **Description**: Deskripsi project
   - **Image**: Upload gambar (jpg, png, gif, webp)
   - **Technologies**: Contoh: React, Node.js, MySQL
   - **Project URL**: Link live demo
   - **GitHub URL**: Link repository
   - **Category**: Kategori project
   - **Status**: Published atau Draft
5. Klik "Add Project"

### Mengedit Konten About

1. Di admin panel, klik "About Me"
2. Edit hero section:
   - Title dan subtitle
   - Description
   - Upload background image (opsional)
3. Edit Education & Certifications
4. Klik "Save Changes"

### Menambah Skills

1. Klik "Skills" di sidebar
2. Pilih kategori dari dropdown
3. Masukkan nama skill
4. Klik "Add Skill"

### Update Contact Info

1. Klik "Contact Info" di sidebar
2. Edit email, phone, location
3. Update social media URLs
4. Klik "Save Changes"

## 📂 Struktur File

```
cv_2/
├── config/
│   └── database.php          # Konfigurasi database
├── database/
│   └── portfolio_db.sql      # Schema database
├── admin/
│   ├── index.php             # Dashboard admin
│   ├── projects.php          # Manage projects
│   ├── about.php             # Manage about section
│   ├── skills.php            # Manage skills
│   ├── contact.php           # Manage contact info
│   └── upload.php            # Handler upload gambar
├── uploads/                  # Folder untuk gambar yang diupload
├── index.php                 # Halaman utama portfolio
└── README.md                 # Dokumentasi ini
```

## 🔒 Keamanan

**PENTING**: Sistem ini belum memiliki autentikasi admin. Untuk production:

1. Tambahkan sistem login admin
2. Gunakan prepared statements (sudah implemented)
3. Validasi dan sanitize semua input
4. Batasi tipe file yang diupload
5. Batasi ukuran file upload
6. Gunakan HTTPS

## 🎨 Customization

### Mengubah Warna Admin Panel

Edit file admin yang dibutuhkan, cari bagian `tailwind.config`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'admin-bg': '#1e1e1e',      // Background
                'admin-sidebar': '#252526', // Sidebar
                'admin-accent': '#007acc',  // Warna accent
            }
        }
    }
}
```

### Menambah Kategori Skills

Di `admin/skills.php`, tambahkan option di dropdown:

```html
<option value="NewCategory">New Category</option>
```

## 🐛 Troubleshooting

### Error "Connection failed"
- Pastikan MySQL berjalan
- Cek username dan password di `config/database.php`
- Pastikan database `portfolio_db` sudah dibuat

### Upload gambar gagal
- Cek permission folder `uploads/`
- Pastikan folder `uploads/` ada
- Cek php.ini untuk `upload_max_filesize` dan `post_max_size`

### Halaman admin blank
- Cek error log PHP
- Pastikan semua file admin memiliki ekstensi `.php`
- Cek syntax error di file PHP

## 📝 Catatan

- File `pages/` yang lama tidak digunakan lagi, semua konten sekarang dari database
- Untuk menghapus data default, jalankan query DELETE di database
- Backup database secara berkala
- Jangan commit folder `uploads/` ke version control

## 🚀 Next Steps

- [ ] Tambah autentikasi admin
- [ ] Tambah halaman blog/articles
- [ ] Tambah testimonial section
- [ ] Export/Import data
- [ ] Image optimization
- [ ] SEO meta tags management

## 📞 Support

Jika ada pertanyaan atau masalah, silakan hubungi:
- Email: restiandf@gmail.com
- GitHub: https://github.com/restiandf

---

**Dibuat dengan ❤️ menggunakan PHP & MySQL**