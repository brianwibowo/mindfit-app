@auth
    <!-- ==========================================
    1. MODAL PUSAT INFORMASI (BANTUAN)
    ========================================== -->
    <div class="modal fade" id="helpCenterModal" tabindex="-1" aria-labelledby="helpCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="helpCenterModalLabel">
                        <i class="fas fa-question-circle me-1"></i> Pusat Informasi & Bantuan - MindFit
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-4">
                        Halo <strong>{{ Auth::user()->name }}</strong>, berikut adalah dokumentasi bantuan cepat mengenai fitur-fitur yang tersedia di panel Anda saat ini.
                    </p>

                    @php
                        $role = Auth::user()->role;
                    @endphp

                    <div class="accordion" id="helpAccordion">
                        @if($role === 'admin')
                            <!-- ADMIN HELP -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingAdmin1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin1" aria-expanded="true" aria-controls="collapseAdmin1">
                                        <i class="fas fa-users-cog text-primary me-2"></i> Bagaimana cara mengelola pengguna sistem (RBAC)?
                                    </button>
                                </h2>
                                <div id="collapseAdmin1" class="accordion-collapse collapse show" aria-labelledby="headingAdmin1" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Anda dapat mengelola akun melalui menu <strong>Manajemen User</strong> di sidebar:
                                        <ul>
                                            <li><strong>Manage Klien</strong>: Melihat daftar klien, memantau status premium, serta riwayat pembayaran.</li>
                                            <li><strong>Manage Coach & Nutritionist</strong>: Mengelola instruktur fitness & ahli gizi terdaftar di sistem.</li>
                                            <li><strong>Manage Admin Sistem</strong>: Menambah atau menghapus admin sistem lainnya.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingAdmin2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin2" aria-expanded="false" aria-controls="collapseAdmin2">
                                        <i class="fas fa-file-invoice-dollar text-success me-2"></i> Bagaimana cara verifikasi bukti bayar Klien?
                                    </button>
                                </h2>
                                <div id="collapseAdmin2" class="accordion-collapse collapse" aria-labelledby="headingAdmin2" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Saat klien baru mendaftar atau mengunggah bukti bayar, data tersebut akan masuk ke halaman <strong>Dashboard Utama</strong> Admin bagian "Daftar Pembayaran Menunggu Verifikasi". Anda dapat mengklik tombol <strong>Aksi / Detail</strong> untuk mengunduh bukti transfer bank, kemudian memilih status:
                                        <ul>
                                            <li><strong>Approve (Setujui)</strong>: Klien otomatis menjadi premium, pendamping (PT/Nutritionist) akan ditautkan secara langsung, dan pendapatan otomatis dicatat di Laporan Keuangan.</li>
                                            <li><strong>Reject (Tolak) / Revision</strong>: Anda harus memasukkan catatan revisi alasan penolakan, sehingga klien dapat memperbaikinya.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingAdmin3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin3" aria-expanded="false" aria-controls="collapseAdmin3">
                                        <i class="fas fa-wallet text-info me-2"></i> Bagaimana Laporan Keuangan & Laba Bersih dihitung?
                                    </button>
                                </h2>
                                <div id="collapseAdmin3" class="accordion-collapse collapse" aria-labelledby="headingAdmin3" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Buka menu <strong>Laporan Keuangan</strong> di sidebar. Di sini Anda akan melihat:
                                        <ul>
                                            <li><strong>Pemasukan</strong>: Total harga bersih dari semua pembayaran klien yang telah Anda setujui (*approved*).</li>
                                            <li><strong>Pengeluaran</strong>: Pencatatan manual pengeluaran operasional (Gaji pelatih, listrik, air, sewa ruko, iklan, peralatan) yang dapat di-CRUD.</li>
                                            <li><strong>Laba Bersih</strong>: Dihitung secara otomatis dari `Pemasukan - Pengeluaran`.</li>
                                            <li><strong>Grafik Filter</strong>: Anda dapat mengubah tampilan tren bulanan menjadi harian, mingguan, maupun tahunan menggunakan filter waktu di atas grafik.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingAdmin4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin4" aria-expanded="false" aria-controls="collapseAdmin4">
                                        <i class="fas fa-tags text-warning me-2"></i> Bagaimana cara kerja batasan pada Manajemen Diskon?
                                    </button>
                                </h2>
                                <div id="collapseAdmin4" class="accordion-collapse collapse" aria-labelledby="headingAdmin4" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Menu <strong>Manajemen Diskon</strong> mendukung pembuatan voucher dengan kuota dan kriteria tertentu:
                                        <ul>
                                            <li><strong>Kuota Penggunaan (Orang)</strong>: Berapa banyak kuota maksimal voucher dapat dipakai klien di sistem. Jika kosong, voucher dapat dipakai selamanya.</li>
                                            <li><strong>Minimal Pembelian (Rp)</strong>: Klien tidak bisa menggunakan voucher ini jika harga paket yang dipilih kurang dari nilai ini.</li>
                                            <li><strong>Batas Potongan Maksimal (Rp)</strong>: Berlaku untuk diskon tipe persentase agar potongan nominalnya tidak melebihi cap/limit keuangan yang ditentukan.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        @elseif($role === 'coach')
                            <!-- COACH HELP -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCoach1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCoach1" aria-expanded="true" aria-controls="collapseCoach1">
                                        <i class="fas fa-address-book text-primary me-2"></i> Bagaimana cara melihat daftar klien saya?
                                    </button>
                                </h2>
                                <div id="collapseCoach1" class="accordion-collapse collapse show" aria-labelledby="headingCoach1" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Pada <strong>Dashboard Utama</strong> Coach, Anda akan melihat daftar kartu klien aktif yang ditugaskan kepada Anda. Kartu tersebut berisi informasi target kesehatan klien (misal: menurunkan berat badan, menaikkan massa otot) agar Anda dapat memberikan program bimbingan yang tepat.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCoach2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCoach2" aria-expanded="false" aria-controls="collapseCoach2">
                                        <i class="fas fa-calendar-check text-success me-2"></i> Bagaimana cara mengatur sesi latihan/nutrisi harian?
                                    </button>
                                </h2>
                                <div id="collapseCoach2" class="accordion-collapse collapse" aria-labelledby="headingCoach2" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Gunakan menu <strong>Sesi Latihan / Sesi Nutrisi</strong> untuk memantau program. Klien akan mengajukan permintaan sesi, dan Anda dapat menyetujui jadwal, menulis catatan latihan/nutrisi spesifik (misal: set beban angkat, resep diet), dan mengubah status kehadiran klien saat sesi berlangsung.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCoach3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCoach3" aria-expanded="false" aria-controls="collapseCoach3">
                                        <i class="fas fa-chart-line text-info me-2"></i> Bagaimana memantau progress fisik klien?
                                    </button>
                                </h2>
                                <div id="collapseCoach3" class="accordion-collapse collapse" aria-labelledby="headingCoach3" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Setiap hari klien premium Anda akan menginput berat badan dan kalori makan harian. Anda dapat melihat perkembangan tren grafik mereka dengan mengklik tautan <strong>"Log Progress"</strong> di dashboard atau halaman detail klien Anda untuk memberikan masukan/evaluasi.
                                    </div>
                                </div>
                            </div>

                        @else
                            <!-- CLIENT HELP -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingClient1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClient1" aria-expanded="true" aria-controls="collapseClient1">
                                        <i class="fas fa-gem text-primary me-2"></i> Bagaimana alur pendaftaran paket Premium?
                                    </button>
                                </h2>
                                <div id="collapseClient1" class="accordion-collapse collapse show" aria-labelledby="headingClient1" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Alur pendaftaran paket berlangganan sangatlah mudah:
                                        <ol>
                                            <li>Buka menu <strong>Form Pendaftaran</strong> di sidebar Anda.</li>
                                            <li>Pilih program paket latihan/diet yang Anda inginkan.</li>
                                            <li>Pilih <strong>Personal Trainer (PT)</strong> dan <strong>Nutritionist</strong> pendamping Anda dari daftar coach bersertifikat yang tersedia.</li>
                                            <li>Masukkan kode voucher diskon (jika ada) dan klik <strong>Terapkan</strong> untuk memotong harga paket secara otomatis.</li>
                                            <li>Lakukan transfer pembayaran ke rekening bank resmi MindFit, unggah foto bukti transfer, lalu klik <strong>Daftar Sekarang</strong>.</li>
                                            <li>Tunggu hingga administrator menyetujui transaksi Anda. Setelah disetujui, akun Anda langsung berubah menjadi premium.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingClient2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClient2" aria-expanded="false" aria-controls="collapseClient2">
                                        <i class="fas fa-calendar-alt text-success me-2"></i> Bagaimana cara menjadwalkan sesi konsultasi?
                                    </button>
                                </h2>
                                <div id="collapseClient2" class="accordion-collapse collapse" aria-labelledby="headingClient2" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Setelah status premium Anda aktif, buka menu <strong>Sesi Bimbingan</strong>. Anda dapat mengirim permintaan sesi baru, memilih tanggal, dan menulis tujuan konsultasi. Pelatih Anda (PT / Nutritionist) akan melihat jadwal dan menyetujui janji temu tersebut secara online/offline.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingClient3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClient3" aria-expanded="false" aria-controls="collapseClient3">
                                        <i class="fas fa-weight text-info me-2"></i> Bagaimana cara mencatat progress harian saya?
                                    </button>
                                </h2>
                                <div id="collapseClient3" class="accordion-collapse collapse" aria-labelledby="headingClient3" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Buka menu <strong>Progress Saya</strong> untuk memantau transformasi tubuh Anda. Anda dapat menginput berat badan harian dan jumlah konsumsi kalori. Data tersebut secara otomatis akan diplot menjadi grafik garis tren agar Anda dan coach pendamping Anda dapat mengevaluasi hasil latihan mingguan secara visual.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingClient4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClient4" aria-expanded="false" aria-controls="collapseClient4">
                                        <i class="fas fa-robot text-warning me-2"></i> Apa kegunaan fitur Konsultasi AI?
                                    </button>
                                </h2>
                                <div id="collapseClient4" class="accordion-collapse collapse" aria-labelledby="headingClient4" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        Fitur AI Consultant bertindak sebagai asisten pintar latihan & makanan Anda. Kapan saja Anda membutuhkan masukan cepat (misal: "Berapa protein dalam 100gr dada ayam?" atau "Contoh latihan otot dada di rumah"), ketikkan pertanyaan Anda di menu <strong>Fitur AI</strong> untuk mendapatkan jawaban instan berbasis ilmiah.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Saya Paham</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==========================================
    2. JAVASCRIPT THEME & TOUR SCRIPTS
    ========================================== -->
    <script>
        // ------------------------------------------
        // A. LOGIKA UTAMA THEME SELECTOR
        // ------------------------------------------
        function setThemeMode(mode) {
            localStorage.setItem('theme', mode);
            applyTheme(mode);
        }

        function applyTheme(mode) {
            const htmlEl = document.documentElement;
            const iconEl = document.getElementById('themeCurrentIcon');
            
            if (!iconEl) return; // safety check

            // Reset class list
            iconEl.className = 'fas fa-lg';

            if (mode === 'dark') {
                htmlEl.setAttribute('data-theme', 'dark');
                iconEl.classList.add('fa-moon', 'text-info');
            } else if (mode === 'light') {
                htmlEl.setAttribute('data-theme', 'light');
                iconEl.classList.add('fa-sun', 'text-warning');
            } else { // system mode
                iconEl.classList.add('fa-desktop', 'text-secondary');
                const isSystemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (isSystemDark) {
                    htmlEl.setAttribute('data-theme', 'dark');
                } else {
                    htmlEl.setAttribute('data-theme', 'light');
                }
            }
        }

        // Listen for OS theme updates if system is selected
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (localStorage.getItem('theme') === 'system' || !localStorage.getItem('theme')) {
                applyTheme('system');
            }
        });

        // Initialize header theme icon status on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'system';
            applyTheme(savedTheme);
        });

        // ------------------------------------------
        // B. LOGIKA ONBOARDING FEATURE TOUR (DRIVER.JS)
        // ------------------------------------------
        @if($role === 'client' || $role === 'coach')
            function startTour() {
                const driver = window.driver.js.driver;
                const role = "{{ $role }}";
                
                let steps = [];

                if (role === 'client') {
                    steps = [
                        {
                            element: '#btnStartTour',
                            popover: {
                                title: 'Selamat Datang di MindFit!',
                                description: 'Tombol ini dapat digunakan kapan saja untuk mengulangi panduan keliling fitur web.',
                                position: 'bottom'
                            }
                        },
                        {
                            element: '.sidebar',
                            popover: {
                                title: 'Panel Navigasi MindFit',
                                description: 'Ini adalah sidebar menu utama tempat Anda dapat menjelajahi seluruh fitur aplikasi.',
                                position: 'right'
                            }
                        },
                        {
                            element: '.sidebar-content',
                            popover: {
                                title: 'Menu Layanan Klien',
                                description: 'Gunakan Form Pendaftaran untuk mendaftar premium. Setelah premium, Anda dapat menjadwalkan sesi, menginput progress harian, dan menggunakan robot AI!',
                                position: 'right'
                            }
                        },
                        {
                            element: '#btnHelpCenter',
                            popover: {
                                title: 'Pusat Bantuan Informasi',
                                description: 'Klik ikon tanya ini kapan saja jika Anda butuh panduan tertulis terperinci mengenai fungsi fitur-fitur MindFit.',
                                position: 'bottom'
                            }
                        },
                        {
                            element: '.profile-pic',
                            popover: {
                                title: 'Menu Profil Pengguna',
                                description: 'Di sini Anda dapat mengedit detail biodata profil Anda, mengganti avatar, dan menekan tombol keluar (logout) sistem.',
                                position: 'bottom'
                            }
                        }
                    ];
                } else if (role === 'coach') {
                    steps = [
                        {
                            element: '#btnStartTour',
                            popover: {
                                title: 'Panduan Coach MindFit!',
                                description: 'Gunakan tombol kompas ini untuk mengulangi panduan visual sistem.',
                                position: 'bottom'
                            }
                        },
                        {
                            element: '.sidebar',
                            popover: {
                                title: 'Sidebar Coach',
                                description: 'Menu navigasi instan untuk mengontrol klien dan mengelola sesi latihan.',
                                position: 'right'
                            }
                        },
                        {
                            element: '.sidebar-content',
                            popover: {
                                title: 'Menu Pendampingan',
                                description: 'Kelola sesi latihan (fitness), konsultasi menu diet (nutritionist), dan berikan evaluasi harian klien di sini.',
                                position: 'right'
                            }
                        },
                        {
                            element: '#btnHelpCenter',
                            popover: {
                                title: 'Pusat Informasi & FAQ',
                                description: 'Tekan ikon ini jika Anda butuh panduan cepat operasional pelatih.',
                                position: 'bottom'
                            }
                        },
                        {
                            element: '.profile-pic',
                            popover: {
                                title: 'Pengaturan Akun',
                                description: 'Edit profil pribadi Anda atau keluar dari aplikasi secara aman.',
                                position: 'bottom'
                            }
                        }
                    ];
                }

                const driverObj = driver({
                    showProgress: true,
                    steps: steps,
                    onDestroyed: function() {
                        localStorage.setItem('tour_done_' + role, 'true');
                    }
                });

                driverObj.drive();
            }

            // Auto start check for new users
            document.addEventListener('DOMContentLoaded', function() {
                const role = "{{ $role }}";
                if (!localStorage.getItem('tour_done_' + role)) {
                    // Slight delay to allow animations to load
                    setTimeout(startTour, 1000);
                }

                // Bind manual start button trigger
                const startBtn = document.getElementById('btnStartTour');
                if (startBtn) {
                    startBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        startTour();
                    });
                }
            });
        @endif
    </script>
@endauth
