<x-app-layout>
    <x-slot name="header">Laporan Keuangan</x-slot>

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h4 class="page-title text-dark mb-0" style="font-weight: 600;">Ringkasan Keuangan</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.finance.export_pdf') }}" class="btn btn-danger btn-sm shadow-sm d-flex align-items-center" target="_blank" style="border-radius: 8px; font-weight: 600; padding: 8px 16px;">
                <i class="fas fa-file-pdf me-2"></i> Unduh PDF
            </a>
            <a href="{{ route('admin.finance.export_excel') }}" class="btn btn-success btn-sm shadow-sm d-flex align-items-center" style="border-radius: 8px; font-weight: 600; padding: 8px 16px;">
                <i class="fas fa-file-excel me-2"></i> Unduh Excel (2 Sheet)
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Summary Cards -->
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pemasukan</p>
                                <h4 class="card-title text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pengeluaran</p>
                                <h4 class="card-title text-danger">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Laba Bersih</p>
                                <h4 class="card-title {{ $netProfit >= 0 ? 'text-primary' : 'text-danger' }}">
                                    Rp {{ number_format($netProfit, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <div class="card-title">Grafik Perbandingan Arus Keuangan</div>
                            <div class="card-category">Pemasukan vs Pengeluaran Operasional</div>
                        </div>
                        <div class="btn-group mt-2 mt-sm-0">
                            <a href="{{ route('admin.finance.index', ['filter' => 'harian']) }}" class="btn btn-sm {{ $filter == 'harian' ? 'btn-primary' : 'btn-outline-primary' }}">Harian</a>
                            <a href="{{ route('admin.finance.index', ['filter' => 'mingguan']) }}" class="btn btn-sm {{ $filter == 'mingguan' ? 'btn-primary' : 'btn-outline-primary' }}">Mingguan</a>
                            <a href="{{ route('admin.finance.index', ['filter' => 'bulanan']) }}" class="btn btn-sm {{ $filter == 'bulanan' ? 'btn-primary' : 'btn-outline-primary' }}">Bulanan</a>
                            <a href="{{ route('admin.finance.index', ['filter' => 'tahunan']) }}" class="btn btn-sm {{ $filter == 'tahunan' ? 'btn-primary' : 'btn-outline-primary' }}">Tahunan</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Table Tabs -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs card-header-tabs" id="financeTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="income-tab" data-bs-toggle="tab" data-bs-target="#income" type="button" role="tab" aria-controls="income" aria-selected="true">
                                    <i class="fas fa-arrow-down text-success me-1"></i> Pemasukan
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense" type="button" role="tab" aria-controls="expense" aria-selected="false">
                                    <i class="fas fa-arrow-up text-danger me-1"></i> Pengeluaran
                                </button>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-sm mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            <i class="fas fa-plus me-1"></i> Catat Pengeluaran
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="financeTabContent">
                        <!-- INCOME TAB -->
                        <div class="tab-pane fade show active" id="income" role="tabpanel" aria-labelledby="income-tab">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Klien</th>
                                            <th>Nama Paket</th>
                                            <th>Kode Diskon</th>
                                            <th class="text-end">Harga Asli</th>
                                            <th class="text-end">Potongan</th>
                                            <th class="text-end">Jumlah Diterima</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $p)
                                            @php
                                                $originalPrice = $p->package_data['package_price'] ?? 0;
                                                $discountPercent = $p->package_data['discount_percent'] ?? 0;
                                                $discountAmount = $p->package_data['discount_amount'] ?? 0;
                                                $totalPrice = $p->package_data['total_price'] ?? $originalPrice;
                                                $discountCode = $p->package_data['discount_code'] ?? null;
                                            @endphp
                                            <tr>
                                                <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                                                <td>{{ $p->user->name ?? 'N/A' }}</td>
                                                <td>{{ str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $p->package_data['package_name'] ?? 'N/A') }}</td>
                                                <td>
                                                    @if($discountCode)
                                                        <span class="badge bg-success">{{ $discountCode }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">Rp {{ number_format($originalPrice, 0, ',', '.') }}</td>
                                                <td class="text-end text-danger">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</td>
                                                <td class="text-end fw-bold text-success">Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center p-4 text-muted">Belum ada pemasukan yang disetujui.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- EXPENSE TAB -->
                        <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th class="text-end">Jumlah</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($expensesList as $exp)
                                            <tr>
                                                <td>{{ $exp->date->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $exp->category }}</span>
                                                </td>
                                                <td>{{ $exp->description }}</td>
                                                <td class="text-end fw-bold text-danger">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-link btn-primary btn-sm p-1" onclick="editExpense({{ json_encode($exp) }})">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.finance.expenses.destroy', $exp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link btn-danger btn-sm p-1" type="submit">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center p-4 text-muted">Belum ada pengeluaran yang dicatat.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD EXPENSE -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addExpenseModalLabel">Catat Pengeluaran Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.finance.expenses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="date" class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="Coach Salary">Gaji Coach</option>
                                <option value="Equipment">Peralatan Gym</option>
                                <option value="Marketing">Pemasaran</option>
                                <option value="Office Rent">Sewa Tempat</option>
                                <option value="Utilities">Air & Listrik</option>
                                <option value="Other">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <input type="text" name="description" class="form-control" placeholder="Contoh: Pembelian Dumbbell Baru" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Nominal Pengeluaran (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control" placeholder="Contoh: 150000" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT EXPENSE -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editExpenseModalLabel">Ubah Catatan Pengeluaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExpenseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="edit_date" class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category" id="edit_category" class="form-select" required>
                                <option value="Coach Salary">Gaji Coach</option>
                                <option value="Equipment">Peralatan Gym</option>
                                <option value="Marketing">Pemasaran</option>
                                <option value="Office Rent">Sewa Tempat</option>
                                <option value="Utilities">Air & Listrik</option>
                                <option value="Other">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <input type="text" name="description" id="edit_description" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_amount" class="form-label">Nominal Pengeluaran (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Edit modal data filler
            function editExpense(exp) {
                // Pre-fill fields
                $('#edit_description').val(exp.description);
                $('#edit_amount').val(exp.amount);
                $('#edit_category').val(exp.category);
                
                // Format date correctly YYYY-MM-DD
                const dateObj = new Date(exp.date);
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                $('#edit_date').val(`${year}-${month}-${day}`);
                
                // Update form action URL
                $('#editExpenseForm').attr('action', `/admin/finance/expenses/${exp.id}`);
                
                // Show modal
                var editModal = new bootstrap.Modal(document.getElementById('editExpenseModal'));
                editModal.show();
            }

            // Render Chart
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('financeChart').getContext('2d');
                
                // Fetch chart data injected from PHP
                const chartLabels = @json($chartData['labels']);
                const incomeVals = @json($chartData['income']);
                const expenseVals = @json($chartData['expense']);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [
                            {
                                label: 'Pemasukan (Rp)',
                                data: incomeVals,
                                backgroundColor: 'rgba(49, 206, 54, 0.7)', // Solid soft green
                                borderColor: '#31ce36',
                                borderWidth: 1,
                                borderRadius: 4,
                            },
                            {
                                label: 'Pengeluaran (Rp)',
                                data: expenseVals,
                                backgroundColor: 'rgba(242, 89, 97, 0.7)', // Solid soft red
                                borderColor: '#f25961',
                                borderWidth: 1,
                                borderRadius: 4,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
