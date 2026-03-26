<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of transaction history (Stock In & Out).
     */
    public function index(Request $request)
    {
        $queryIn = StockIn::with('product')->latest();
        $queryOut = StockOut::with('product')->latest();

        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $queryIn->whereBetween('date', [$request->start_date, $request->end_date]);
            $queryOut->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $stockIns = $queryIn->paginate(5, ['*'], 'in_page');
        $stockOuts = $queryOut->paginate(5, ['*'], 'out_page');

        return view('stocks.index', compact('stockIns', 'stockOuts'));
    }

    /**
     * Show form for Stock In.
     */
    public function createIn()
    {
        $products = Product::all();
        return view('stocks.in.create', compact('products'));
    }

    /**
     * Store Stock In transaction.
     */
    public function storeIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'supplier_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $stockIn = StockIn::create($request->all());
            
            $product = Product::find($request->product_id);
            $product->stock += $request->quantity;
            $product->save();
        });

        return redirect()->route('stocks.index')->with('success', 'Stok masuk berhasil dicatat, dan stok barang bertambah.');
    }

    /**
     * Show form for Stock Out.
     */
    public function createOut()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('stocks.out.create', compact('products'));
    }

    /**
     * Store Stock Out transaction.
     */
    public function storeOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'recipient_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->withInput()->withErrors(['quantity' => 'Stok tidak mencukupi! Stok saat ini: ' . $product->stock]);
        }

        DB::transaction(function () use ($request, $product) {
            StockOut::create($request->all());
            
            $product->stock -= $request->quantity;
            $product->save();
        });

        return redirect()->route('stocks.index')->with('success', 'Stok keluar berhasil dicatat, dan stok barang berkurang.');
    }
}
