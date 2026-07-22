<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminFinanceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'monthly'); // harian, mingguan, bulanan, tahunan
        
        // 1. Fetch Income & Expense lists
        $payments = Payment::where('status', 'approved')->with('user')->orderBy('created_at', 'desc')->get();
        $expensesList = Expense::orderBy('date', 'desc')->get();

        // 2. Calculate summary totals
        // Note: package_data stores total_price paid
        $totalIncome = 0;
        foreach ($payments as $payment) {
            $totalIncome += $payment->package_data['total_price'] ?? $payment->package_data['package_price'] ?? 0;
        }

        $totalExpenses = Expense::sum('amount');
        $netProfit = $totalIncome - $totalExpenses;

        // 3. Prepare Chart Data based on selected filter
        $chartData = $this->getChartData($filter);

        return view('admin.finance.index', compact(
            'payments',
            'expensesList',
            'totalIncome',
            'totalExpenses',
            'netProfit',
            'filter',
            'chartData'
        ));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
            'category' => 'required|string',
            'date' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('admin.finance.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function updateExpense(Request $request, Expense $expense)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
            'category' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense->update($request->all());

        return redirect()->route('admin.finance.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.finance.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }

    private function getChartData($filter)
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        if ($filter == 'harian') {
            // Last 15 days
            for ($i = 14; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $labels[] = $date->format('d M');
                
                // Income for day
                $dayIncome = 0;
                $dayPayments = Payment::where('status', 'approved')
                    ->whereDate('created_at', $date)
                    ->get();
                foreach ($dayPayments as $p) {
                    $dayIncome += $p->package_data['total_price'] ?? $p->package_data['package_price'] ?? 0;
                }
                $incomeData[] = $dayIncome;

                // Expenses for day
                $dayExpense = Expense::query()->whereDate('date', $date)->sum('amount');
                $expenseData[] = (int) $dayExpense;
            }
        } elseif ($filter == 'mingguan') {
            // Last 8 weeks
            for ($i = 7; $i >= 0; $i--) {
                $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
                $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
                $labels[] = 'W' . $startOfWeek->format('W') . ' (' . $startOfWeek->format('d M') . ')';

                // Income for week
                $weekIncome = 0;
                $weekPayments = Payment::where('status', 'approved')
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->get();
                foreach ($weekPayments as $p) {
                    $weekIncome += $p->package_data['total_price'] ?? $p->package_data['package_price'] ?? 0;
                }
                $incomeData[] = $weekIncome;

                // Expenses for week
                $weekExpense = Expense::whereBetween('date', [$startOfWeek, $endOfWeek])->sum('amount');
                $expenseData[] = (int) $weekExpense;
            }
        } elseif ($filter == 'tahunan') {
            // Last 5 years
            for ($i = 4; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->format('Y');
                $labels[] = $year;

                // Income for year
                $yearIncome = 0;
                $yearPayments = Payment::where('status', 'approved')
                    ->whereYear('created_at', $year)
                    ->get();
                foreach ($yearPayments as $p) {
                    $yearIncome += $p->package_data['total_price'] ?? $p->package_data['package_price'] ?? 0;
                }
                $incomeData[] = $yearIncome;

                // Expenses for year
                $yearExpense = Expense::whereYear('date', $year)->sum('amount');
                $expenseData[] = (int) $yearExpense;
            }
        } else { // bulanan (default)
            // Last 12 months
            for ($i = 11; $i >= 0; $i--) {
                $monthDate = Carbon::now()->subMonths($i);
                $labels[] = $monthDate->format('M Y');

                // Income for month
                $monthIncome = 0;
                $monthPayments = Payment::where('status', 'approved')
                    ->whereMonth('created_at', $monthDate->month)
                    ->whereYear('created_at', $monthDate->year)
                    ->get();
                foreach ($monthPayments as $p) {
                    $monthIncome += $p->package_data['total_price'] ?? $p->package_data['package_price'] ?? 0;
                }
                $incomeData[] = $monthIncome;

                // Expenses for month
                $monthExpense = Expense::whereMonth('date', $monthDate->month)
                    ->whereYear('date', $monthDate->year)
                    ->sum('amount');
                $expenseData[] = (int) $monthExpense;
            }
        }

        return [
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }

    public function exportPdf()
    {
        $payments = Payment::where('status', 'approved')->with('user')->orderBy('created_at', 'desc')->get();
        $expensesList = Expense::orderBy('date', 'desc')->get();

        $totalIncome = 0;
        foreach ($payments as $payment) {
            $totalIncome += $payment->package_data['total_price'] ?? $payment->package_data['package_price'] ?? 0;
        }
        $totalExpenses = Expense::sum('amount');
        $netProfit = $totalIncome - $totalExpenses;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.finance.export_pdf', compact(
            'payments',
            'expensesList',
            'totalIncome',
            'totalExpenses',
            'netProfit'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Keuangan_Mindfit_' . date('Ymd_His') . '.pdf');
    }

    public function exportExcel()
    {
        $payments = Payment::where('status', 'approved')->with('user')->orderBy('created_at', 'desc')->get();
        $expenses = Expense::orderBy('date', 'desc')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // --- SHEET 1: PEMASUKAN ---
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Pemasukan');

        $sheet1->setCellValue('A1', 'No');
        $sheet1->setCellValue('B1', 'Tanggal');
        $sheet1->setCellValue('C1', 'Nama Klien');
        $sheet1->setCellValue('D1', 'Nama Paket');
        $sheet1->setCellValue('E1', 'Harga Paket');
        $sheet1->setCellValue('F1', 'Total Pembayaran');

        $sheet1->getStyle('A1:F1')->getFont()->setBold(true);

        $row1 = 2;
        foreach ($payments as $index => $payment) {
            $price = $payment->package_data['package_price'] ?? 0;
            $total = $payment->package_data['total_price'] ?? $price;
            
            $sheet1->setCellValue('A' . $row1, $index + 1);
            $sheet1->setCellValue('B' . $row1, $payment->created_at->format('d/m/Y'));
            $sheet1->setCellValue('C' . $row1, $payment->user->name ?? 'Klien Mindfit');
            $sheet1->setCellValue('D' . $row1, $payment->package_data['package_name'] ?? 'Paket Premium');
            $sheet1->setCellValue('E' . $row1, $price);
            $sheet1->setCellValue('F' . $row1, $total);
            
            $sheet1->getStyle('E' . $row1)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('F' . $row1)->getNumberFormat()->setFormatCode('#,##0');
            $row1++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // --- SHEET 2: PENGELUARAN ---
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Pengeluaran');

        $sheet2->setCellValue('A1', 'No');
        $sheet2->setCellValue('B1', 'Tanggal');
        $sheet2->setCellValue('C1', 'Kategori');
        $sheet2->setCellValue('D1', 'Deskripsi');
        $sheet2->setCellValue('E1', 'Jumlah (Rupiah)');

        $sheet2->getStyle('A1:E1')->getFont()->setBold(true);

        $row2 = 2;
        foreach ($expenses as $index => $exp) {
            $sheet2->setCellValue('A' . $row2, $index + 1);
            $sheet2->setCellValue('B' . $row2, Carbon::parse($exp->date)->format('d/m/Y'));
            $sheet2->setCellValue('C' . $row2, ucfirst($exp->category));
            $sheet2->setCellValue('D' . $row2, $exp->description);
            $sheet2->setCellValue('E' . $row2, $exp->amount);

            $sheet2->getStyle('E' . $row2)->getNumberFormat()->setFormatCode('#,##0');
            $row2++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Laporan_Keuangan_Mindfit_' . date('Ymd_His') . '.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache',
        ]);
    }
}
