<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month if no dates provided
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $type = $request->input('type', 'all'); // 'all', 'in', 'out'

        $queryIn = StockIn::with('product')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);
            
        $queryOut = StockOut::with('product')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate);

        $transactions = collect();
        $totalIn = 0;
        $totalOut = 0;

        if ($type === 'all' || $type === 'in') {
            $ins = $queryIn->get()->map(function($item) use (&$totalIn) {
                $totalIn += $item->quantity;
                $item->transaction_type = 'in';
                $item->party = $item->supplier_name; // To unify column
                return $item;
            });
            $transactions = $transactions->concat($ins);
        }

        if ($type === 'all' || $type === 'out') {
            $outs = $queryOut->get()->map(function($item) use (&$totalOut) {
                $totalOut += $item->quantity;
                $item->transaction_type = 'out';
                $item->party = $item->recipient_name; // To unify column
                return $item;
            });
            $transactions = $transactions->concat($outs);
        }

        // Sort by date descending, then by created_at descending
        $transactions = $transactions->sortByDesc(function ($transaction) {
            return $transaction->date . ' ' . $transaction->created_at;
        })->values();

        return view('reports.index', compact('transactions', 'startDate', 'endDate', 'type', 'totalIn', 'totalOut'));
    }
}
