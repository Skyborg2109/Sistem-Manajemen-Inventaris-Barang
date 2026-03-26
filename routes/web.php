<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $totalProducts = \App\Models\Product::count();
    $totalCategories = \App\Models\Category::count();
    $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)->get();
    
    // Data for Chart (Last 7 Days)
    $dates = collect();
    for ($i = 6; $i >= 0; $i--) {
        $dates->push(now()->subDays($i)->format('Y-m-d'));
    }

    $stockInsChart = [];
    $stockOutsChart = [];

    foreach ($dates as $date) {
        $stockInsChart[] = \App\Models\StockIn::where('date', $date)->sum('quantity');
        $stockOutsChart[] = \App\Models\StockOut::where('date', $date)->sum('quantity');
    }

    return view('dashboard', compact('totalProducts', 'totalCategories', 'lowStockProducts', 'dates', 'stockInsChart', 'stockOutsChart'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);

    // Stock Routes
    Route::get('/stocks', [App\Http\Controllers\StockController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/in', [App\Http\Controllers\StockController::class, 'createIn'])->name('stocks.in.create');
    Route::post('/stocks/in', [App\Http\Controllers\StockController::class, 'storeIn'])->name('stocks.in.store');
    Route::get('/stocks/out', [App\Http\Controllers\StockController::class, 'createOut'])->name('stocks.out.create');
    Route::post('/stocks/out', [App\Http\Controllers\StockController::class, 'storeOut'])->name('stocks.out.store');

    // Report Route
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
