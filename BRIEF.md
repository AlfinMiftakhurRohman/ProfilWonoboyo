PROYEK: Website Profil Desa Wonoboyo (Laravel 11)
Aku Alfin, Kordes KKN UNEJ di Desa Wonoboyo, Kecamatan Klabang, Kabupaten Bondowoso, Jawa Timur. Aku membangun website profil desa sebagai output KKN. Desain sudah final berupa file HTML statis hasil Claude Design, ada di folder proyek. Tugasmu implementasi ke Laravel. Desain visualnya sudah beres, jangan dirombak, cukup diporting.
CARA KERJA YANG AKU MAU
Jujur dan rigor. Jangan asal setuju. Kalau ada keputusanku yang keliru atau berisiko, tunjukkan, jelaskan alasannya, tawarkan alternatif yang lebih baik. Langsung tapi tidak kasar.
Kerjakan bertahap sesuai urutan di bagian bawah. Jangan bangun semuanya sekaligus. Selesaikan satu tahap, tunjukkan hasilnya, tunggu konfirmasiku, baru lanjut. Sebelum menulis kode di tiap tahap, jelaskan dulu rencanamu secara singkat.
TECH STACK, FINAL
Laravel 11, PHP 8.2+. Blade, server-side rendering, bukan React atau SPA, alasannya SEO dan satu repo lebih mudah dimaintain. Tailwind CSS. Alpine.js untuk interaksi ringan saja, yaitu mobile menu, tab filter, dan lightbox galeri. Leaflet.js plus OpenStreetMap untuk peta, bukan Google Maps API, karena Leaflet gratis tanpa API key dan tanpa billing. MySQL. Laravel Breeze untuk auth admin. Vite. Git plus GitHub.
Target deploy: shared hosting cPanel. Ini batasan penting, pertimbangkan di setiap keputusan teknis.
SISTEM USER
Satu role saja, yaitu admin. Pengunjung publik tidak login dan tidak tercatat di database. Tidak ada multi-role, tidak ada register publik. Setelah akun admin dibuat lewat seeder, matikan route register bawaan Breeze. Route login dan logout tetap aktif. Seluruh route admin dilindungi middleware auth.
KONTEN: SEMUA PLACEHOLDER, JANGAN DIISI TEBAKAN
Ini yang paling penting dari seluruh brief ini.
Seluruh isi desain sengaja berupa placeholder seperti [NAMA KEPALA DESA], [NAMA], […], karena data asli masih kukumpulkan dari survei lapangan.
Jangan pernah mengisi placeholder itu dengan nama fiktif, angka karangan, atau data hasil pencarian internet. Biarkan sebagai placeholder, atau buat seeder yang isinya jelas bertanda dummy supaya mudah kuganti nanti. Desain versi sebelumnya penuh data karangan, mulai dari nama kepala desa yang salah, angka penduduk palsu, sampai komoditas yang tidak ada di desa, dan itu sudah kubersihkan dengan susah payah. Jangan diulang.
Data survei lapanganku selalu menang atas data internet manapun.
DATABASE: 7 tabel di luar bawaan Laravel
users — dari Breeze, admin saja.
settings — key-value, satu-satunya tempat data kontak dan konten semi-statis hidup. Key yang dibutuhkan:
sambutan_teks, sejarah, visi, misi,
geo_ketinggian, geo_luas, geo_topografi, geo_batas_utara, geo_batas_selatan, geo_batas_timur, geo_batas_barat, geo_jarak_kota,
stat_penduduk, stat_kk, stat_laki, stat_perempuan, stat_dusun,
kontak_alamat, kontak_kodepos, kontak_telepon, kontak_wa, kontak_email, kontak_jam_layanan,
sosmed_instagram, sosmed_facebook,
peta_center_lat, peta_center_lng, peta_zoom.
Perhatikan: sambutan_teks hanya berisi teks sambutan, tidak berisi nama atau foto kepala desa. Dan tidak ada key stat_luas, karena luas wilayah cukup satu, yaitu geo_luas, dipakai bersama oleh Beranda dan Profil Desa.
officials — name, position, photo (nullable), sort_order, is_head (boolean, default false).
posts — title, slug (unique), excerpt (nullable), body (longtext), image (nullable), image_caption (nullable), category (enum: berita, pengumuman), author (string, nullable), is_published (boolean, default false), published_at (nullable), attachment (nullable), attachment_name (nullable).
galleries — title, image, caption (nullable), ratio (string, contoh 4/5 atau 1/1, untuk layout masonry), sort_order.
products — name, slug (unique), category (enum: umkm, hasil_tani, olahan), description (text), price (unsigned integer), unit (string), seller_name, seller_wa, availability (enum: tersedia, habis, pre_order), is_published (boolean, default false), sort_order.
product_images — product_id (foreign key, onDelete cascade), image, is_primary (boolean), sort_order.
ATURAN LOGIKA YANG WAJIB DIPATUHI
Sumber kebenaran tunggal. Nomor WA, telepon, alamat, jam layanan, dan link sosmed muncul di banyak halaman sekaligus, yaitu Footer, Kontak, dan popup peta. Semuanya hanya ditarik dari tabel settings, tidak pernah diketik ulang di Blade. Kalau tidak begitu, admin mengganti nomor di satu tempat dan tempat lain tetap memakai nomor lama. Footer menampilkan satu nomor saja, ambil dari kontak_wa.
Luas wilayah. Beranda dan Profil Desa sama-sama menampilkan luas wilayah. Keduanya membaca key yang sama, yaitu geo_luas. Jangan bikin dua key.
Kepala desa. Nama, jabatan, dan foto kepala desa hanya hidup di tabel officials pada baris is_head = true. Tabel settings hanya menyimpan teks sambutannya. Blok Sambutan Kepala Desa di Beranda menarik teks dari settings, lalu nama, jabatan, dan foto dari officials. Kalau tidak ada baris is_head = true, sembunyikan blok sambutan dengan aman, jangan sampai error. Hanya boleh ada satu official dengan is_head bernilai true: kalau admin menandai official baru sebagai kepala desa, otomatis lepas tanda dari yang lama, jalankan dalam transaksi database.
Harga. Simpan sebagai integer rupiah polos, contoh 55000, bukan string "Rp 55.000". Pemformatan dilakukan di view. Kalau disimpan sebagai string, harga tidak akan pernah bisa disortir atau difilter.
Nomor WhatsApp. Simpan dalam format internasional tanpa tanda plus dan tanpa spasi, contoh 6281234567890, bukan 0812. Link wa.me hanya bekerja dengan format itu. Lakukan validasi dan normalisasi otomatis di form admin, jangan percaya admin akan mengetik dengan benar. Teks prefill WhatsApp wajib di-urlencode.
Slug. Digenerate otomatis dari judul atau nama produk, tapi bisa diedit manual, dan tidak boleh berubah otomatis ketika judul diedit, karena link yang sudah disebar penjual atau warga akan mati. Pastikan unik, kalau bentrok tambahkan sufiks angka. Slug yang tidak ditemukan menghasilkan halaman 404 yang rapi, bukan error.
Publikasi. Semua query publik untuk posts dan products wajib menyaring is_published = true. Khusus posts, tambahkan syarat published_at <= now(). Tanpa ini, draft yang belum selesai akan bocor ke publik. Buat query scope supaya aturan ini tidak lupa diterapkan di satu tempat.
Paginasi. Halaman Berita, Produk Desa, dan Galeri wajib memakai paginasi Laravel. Jangan memuat semua record sekaligus, karena setelah dua tahun akan ada ratusan post dan website menjadi lambat di ponsel warga.
Filter kategori. Filter Semua, Berita, Pengumuman di halaman Berita, dan filter kategori di halaman Produk, harus lewat query string, contoh ?kategori=pengumuman, bukan JavaScript murni. Alasannya supaya bisa dipadukan dengan paginasi dan supaya link hasil filter bisa dibagikan. Alpine.js hanya mengurus tampilan tab mana yang aktif.
Beranda. Ambil tiga post terbaru yang sudah published, urut published_at menurun. Blok pengumuman yang disorot mengambil satu pengumuman terbaru yang published. Kalau tidak ada pengumuman sama sekali, sembunyikan blok itu, jangan tampilkan kotak kosong.
Berita Detail. Penulis diambil dari kolom author, kalau kosong tampilkan default "Admin Desa". Estimasi baca dihitung otomatis dari jumlah kata di kolom body, jangan disimpan di database, karena angka yang bisa dihitung ulang tidak boleh disimpan, nanti jadi basi. Keterangan foto diambil dari image_caption, kalau kosong jangan tampilkan barisnya.
Lampiran. Blok lampiran di Berita Detail hanya dirender kalau kolom attachment tidak null. Nama file diambil dari attachment_name, ukuran file dihitung dari file aslinya dan ditampilkan dalam KB atau MB. Satu lampiran per post, bukan daftar banyak file.
Produk Detail. Section "Produk lainnya" mengambil produk lain dengan kategori sama, kecualikan produk yang sedang dibuka, batasi jumlahnya. Gambar utama diambil dari product_images yang is_primary = true, sisanya jadi thumbnail. Kalau availability bernilai habis, jangan tampilkan tombol Pesan via WhatsApp, ganti dengan keterangan stok habis. Menampilkan tombol pesan untuk barang yang habis hanya membuat warga menghubungi penjual sia-sia.
Galeri. Kolom ratio menentukan bentuk tiap foto pada layout masonry. Kalau kosong, pakai default 1/1. Lightbox memakai Alpine.js.
Keamanan XSS. Kolom body berisi rich text dan akan dirender memakai {!! !!} di Blade. Ini berbahaya. Saring HTML-nya sebelum disimpan, batasi hanya tag yang aman. Seluruh field lain wajib memakai {{ }} yang otomatis di-escape. Jangan sekali pun merender input admin mentah-mentah.
File upload. Berlaku untuk lampiran post, foto post, foto official, foto galeri, dan foto produk. Validasi memakai whitelist ekstensi, bukan blacklist. Lampiran: pdf, doc, docx, xls, xlsx, jpg, png. Gambar: jpg, jpeg, png, webp. Maksimal 5MB. Kalau file berekstensi .php sampai lolos, penyerang bisa mengeksekusi kode di shared hosting, dan itu celah keamanan serius. Ingat upload_max_filesize di cPanel sering dibatasi antara 2MB sampai 8MB, jadi tampilkan pesan error yang jelas kalau upload gagal.
Simpan semua upload ke public/uploads/ dengan subfolder per jenis, bukan ke storage/app/public, karena php artisan storage:link sering bermasalah di shared hosting cPanel akibat symlink tidak diizinkan. Nama file diacak, jangan pakai nama asli dari pengguna.
File yatim. Ketika record dihapus atau gambarnya diganti, hapus juga file fisiknya. Kalau tidak, kuota disk cPanel akan penuh perlahan tanpa kamu sadari. Menghapus produk berarti menghapus semua barisnya di product_images beserta file fisiknya, gunakan cascade di database ditambah event model untuk file.
Nullable. Semua kolom foto, gambar, dan lampiran bersifat nullable. View wajib merender placeholder yang konsisten dengan desain, jangan sampai muncul ikon gambar rusak.
Lokalisasi. Set timezone aplikasi ke Asia/Jakarta dan locale ke id. Format tanggal dalam bahasa Indonesia, contoh 10 Juli 2026, bukan bahasa Inggris.
Peta. Titik center dan level zoom diambil dari settings. Koordinat polygon batas desa yang ada di desain adalah data karangan, bukan batas asli Wonoboyo. Jangan diperlakukan sebagai kebenaran. Simpan sebagai file GeoJSON terpisah di public/geo/, jangan hard-code di Blade, supaya bisa kuganti tanpa membongkar view. Pertahankan disclaimer yang sudah ada di desain: batas wilayah bersifat ilustratif dan bukan acuan hukum administrasi.
Sosial media. Key sosmed_instagram dan sosmed_facebook berisi URL penuh menuju akun desa. Kalau kolomnya kosong, ikon itu tidak ditampilkan sama sekali, jangan tampilkan link mati. Buka di tab baru dengan target="_blank" dan rel="noopener noreferrer", karena tanpa noopener halaman tujuan bisa memanipulasi tab asal.
Cache settings. Tabel settings dibaca hampir di setiap halaman. Cache hasilnya, dan bersihkan cache setiap kali admin menyimpan perubahan.
TIGA PERBAIKAN WAJIB SAAT PORTING DARI DESAIN

id="map" dipakai di dua file berbeda, yaitu Profil-Desa dan Kontak. Ganti menjadi id="map-profil" dan id="map-kontak". Aman selama dua peta ada di halaman terpisah, tapi kalau suatu saat keduanya muncul di satu halaman, id kembar membuat salah satunya gagal render.
Di halaman Pemerintahan ada caption "Untuk saat ini ditampilkan inisial nama", padahal placeholder fotonya sekarang bertuliskan "Foto" dan field initial sudah dikosongkan. Caption itu bertentangan dengan tampilannya sendiri. Perbaiki dengan memilih salah satu: kembalikan sistem inisial yang diambil dari huruf pertama nama, atau hapus captionnya.
Nav memiliki state aktif per halaman. Implementasikan dengan request()->routeIs(), jangan menyalin logika active dari file desain.

KEPUTUSAN SADAR SOAL HALAMAN POTENSI DESA
Halaman Potensi Desa isinya sepenuhnya hard-code di desain, tanpa placeholder dan tanpa data dinamis. Artinya admin tidak bisa mengubahnya lewat panel, harus lewat kode.
Untuk sekarang, biarkan begitu, jangan bikin tabel baru untuk ini. Alasannya isi halaman itu jarang berubah dan menambah satu tabel plus CRUD hanya untuk tiga blok teks tidak sepadan dengan waktu KKN yang terbatas. Tapi tulis komentar di Blade-nya bahwa konten ini statis dan diubah lewat kode. Kalau nanti desa sering memperbaruinya, barulah dipindahkan ke settings.
STRUKTUR WEBSITE: 8 menu flat, tanpa dropdown
Beranda. Profil Desa, berisi sejarah, visi misi, kondisi geografis, peta Leaflet dengan polygon batas desa, dan statistik kependudukan. Pemerintahan, berisi struktur organisasi, perangkat desa, dan BPD. Potensi Desa. Produk Desa, berupa katalog tanpa transaksi online, dengan tombol WhatsApp per produk dan halaman detail tersendiri. Berita, menggabungkan berita dan pengumuman dalam satu modul yang dibedakan filter kategori. Galeri, berupa grid dengan lightbox. Kontak, berisi alamat, WA, jam layanan, informasi layanan surat tanpa form online, dan peta pin kantor.
YANG SECARA SADAR TIDAK DIBUAT, JANGAN DITAMBAHKAN
Halaman transparansi atau APBDes. Layanan surat online. Sistem BUMDes. Multi-role. Register publik. Kolom komentar. Form pengaduan online. Keranjang belanja atau checkout. Fitur pencarian. API terpisah. WhatsApp Business API, chatbot, atau notifikasi otomatis, karena cukup link wa.me biasa.
Kalau menurutmu salah satu dari ini sebenarnya perlu, katakan alasannya, jangan diam-diam menambahkannya.
URUTAN PENGERJAAN, SATU PER SATU
Tahap 1. Setup Laravel, install Breeze, konfigurasi Tailwind, Vite, timezone, dan locale. Buat migration dan model untuk 7 tabel beserta relasi dan cascade. Buat seeder placeholder yang jelas bertanda dummy.
Tahap 2. Porting 8 halaman publik dari HTML ke Blade. Buat layout utama, komponen Nav dan Footer, plus halaman Berita Detail dan Produk Detail. Terapkan seluruh aturan logika di atas, khususnya paginasi, filter lewat query string, penyaringan is_published, dan sumber kebenaran tunggal dari settings.
Tahap 3. Panel admin. CRUD untuk posts termasuk lampiran, products termasuk multi gambar, galleries, officials, dan settings. Matikan route register. Terapkan validasi upload, normalisasi nomor WA, aturan is_head tunggal, dan penghapusan file fisik.
Tahap 4. Polish. Integrasi Leaflet dengan GeoJSON terpisah, cek responsif di ponsel, kompresi gambar, penanganan 404, lalu persiapan deploy ke cPanel.
Mulai dari Tahap 1 saja. Jelaskan rencanamu dulu, tunggu konfirmasiku, baru tulis kode.