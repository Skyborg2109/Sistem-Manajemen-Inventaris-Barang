<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-left">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Array -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Products -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center shadow-indigo-100/50 dark:shadow-none hover:shadow-md transition">
                    <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Barang</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalProducts }}</h4>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center shadow-blue-100/50 dark:shadow-none hover:shadow-md transition">
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/50 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalCategories }}</h4>
                    </div>
                </div>

                <!-- Low Stock Box -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center shadow-red-100/50 dark:shadow-none hover:shadow-md transition">
                    <div class="w-14 h-14 bg-red-50 dark:bg-red-900/50 rounded-2xl flex items-center justify-center text-red-600 dark:text-red-400 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stok Menipis</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $lowStockProducts->count() }}</h4>
                    </div>
                </div>

                <!-- System Active -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center shadow-emerald-100/50 dark:shadow-none hover:shadow-md transition">
                    <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/50 rounded-2xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Sistem</p>
                        <h4 class="text-xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">Optimal</h4>
                    </div>
                </div>
            </div>

            <!-- Charts & Alerts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        Aktivitas Transaksi (7 Hari Terakhir)
                    </h3>
                    <div class="relative h-72 w-full">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>

                <!-- Low Stock List -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Peringatan Stok Limit
                        </h3>
                    </div>
                    <div class="p-0 overflow-y-auto max-h-[300px]">
                        @forelse($lowStockProducts as $product)
                            <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition flex justify-between items-center group">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/50 flex items-center justify-center text-red-500 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $product->category->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Sisa {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                Semua stok barang aman.
                            </div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 rounded-b-2xl text-center">
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition">Lihat Semua Barang &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('stockChart').getContext('2d');
            
            // Format labels
            const rawDates = JSON.parse('{!! json_encode($dates) !!}');
            const labels = rawDates.map(date => {
                const d = new Date(date);
                return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Stok Masuk',
                            data: JSON.parse('{!! json_encode($stockInsChart) !!}'),
                            backgroundColor: '#10b981', // emerald-500
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Stok Keluar',
                            data: JSON.parse('{!! json_encode($stockOutsChart) !!}'),
                            backgroundColor: '#f97316', // orange-500
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            titleFont: { family: "'Inter', sans-serif", size: 13 },
                            bodyFont: { family: "'Inter', sans-serif", size: 13 },
                            padding: 12,
                            cornerRadius: 8,
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)',
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif" },
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif" }
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                }
            });
        });
    </script>
</x-app-layout>
