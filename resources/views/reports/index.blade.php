<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-5 print:hidden">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Laporan Transaksi Barang') }}
            </h2>
            <div class="flex gap-3">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm print:hidden">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Simpan / Cetak PDF
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Print Header (Hidden on Web) -->
    <div class="hidden print:block mb-8 text-left pb-4 border-b-2 border-gray-800">
        <h1 class="text-3xl font-bold uppercase tracking-wider text-gray-900 mb-2">Laporan Transaksi Inventaris</h1>
        <p class="text-gray-600">
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
            <br>
            Filter Jenis: <strong>{{ $type === 'all' ? 'Semua Transaksi' : ($type === 'in' ? 'Barang Masuk' : 'Barang Keluar') }}</strong>
        </p>
    </div>

    <div class="py-6">
        <div class="sm:px-6 lg:px-8">
            
            <!-- Filter Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6 print:hidden">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Transaksi</label>
                        <select name="type" id="type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all" {{ $type === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="in" {{ $type === 'in' ? 'selected' : '' }}>Barang Masuk</option>
                            <option value="out" {{ $type === 'out' ? 'selected' : '' }}>Barang Keluar</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @if($type === 'all' || $type === 'in')
                <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl p-6 border border-emerald-100 dark:border-emerald-800 flex items-center print:border-gray-300 print:bg-white">
                    <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl mr-4 print:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400 print:text-gray-800 uppercase tracking-widest mb-1">Total Barang Masuk</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 print:text-gray-900">{{ number_format($totalIn) }} Unit</p>
                    </div>
                </div>
                @endif
                
                @if($type === 'all' || $type === 'out')
                <div class="bg-orange-50 dark:bg-orange-900/30 rounded-2xl p-6 border border-orange-100 dark:border-orange-800 flex items-center print:border-gray-300 print:bg-white">
                    <div class="p-3 bg-orange-100 text-orange-600 rounded-xl mr-4 print:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-orange-600 dark:text-orange-400 print:text-gray-800 uppercase tracking-widest mb-1">Total Barang Keluar</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 print:text-gray-900">{{ number_format($totalOut) }} Unit</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden print:border-gray-400 print:shadow-none">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 print:divide-gray-300 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 print:bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider print:text-gray-800">Tanggal</th>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider print:text-gray-800">Tipe</th>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider print:text-gray-800">Barang & Kategori</th>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider print:text-gray-800">Supplier/Penerima</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider print:text-gray-800">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 print:divide-gray-300">
                            @forelse($transactions as $trx)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 print:hover:bg-transparent">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300 print:text-gray-800">
                                        {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                        <div class="text-xs text-gray-400 dark:text-gray-500 print:hidden">{{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($trx->transaction_type === 'in')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 print:border print:border-gray-400 print:bg-transparent print:text-gray-800">
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400 print:border print:border-gray-400 print:bg-transparent print:text-gray-800">
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 print:text-gray-800">
                                        <div class="font-medium text-gray-900 dark:text-gray-200">{{ $trx->product->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $trx->product->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300 print:text-gray-800">
                                        {{ $trx->party ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-gray-900 dark:text-gray-100 font-bold print:text-gray-800">
                                        <span class="{{ $trx->transaction_type === 'in' ? 'text-emerald-600 dark:text-emerald-400 print:text-gray-800' : 'text-orange-600 dark:text-orange-400 print:text-gray-800' }}">
                                            {{ $trx->transaction_type === 'in' ? '+' : '-' }}{{ $trx->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 print:text-gray-600 font-medium">
                                        Tidak ada transaksi pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Print Footer -->
            <div class="hidden print:block mt-10 pt-4 border-t border-gray-300 text-sm text-gray-500">
                Dicetak pada: {{ now()->format('d/m/Y H:i') }} oleh {{ Auth::user()->name }}
            </div>
            
        </div>
    </div>
</x-app-layout>
