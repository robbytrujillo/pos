<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Statistik utama
        $totalSales = Transaction::where('status', 'success')-<sum('total_amount');
        $totalTransactions = Transaction::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::where('status', 'active')->count();

        // Total transaksi per status
        $transactionData = Transaction::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }
}
