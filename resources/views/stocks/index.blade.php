<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-left">
                {{ __('Riwayat Transaksi Stok') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('stocks.in.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Stok Masuk
                </a>
                <a href="{{ route('stocks.out.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:ring-2 focus:ring-orange-500 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Stok Keluar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                <form action="{{ route('stocks.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="w-full sm:w-1/3">
                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" class="block w-full mt-1" type="date" name="start_date" value="{{ request('start_date') }}" />
                    </div>
                    <div class="w-full sm:w-1/3">
                        <x-input-label for="end_date" :value="__('Tanggal Akhir')" />
                        <x-text-input id="end_date" class="block w-full mt-1" type="date" name="end_date" value="{{ request('end_date') }}" />
                    </div>
                    <div class="w-full sm:w-auto flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Filter
                        </button>
                        @if(request('start_date') || request('end_date'))
                            <a href="{{ route('stocks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Stok Masuk -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-emerald-50/50 dark:bg-emerald-900/10">
                        <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Stok Masuk
                        </h3>
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Tanggal</th>
                                    <th class="px-6 py-3 font-medium">Barang</th>
                                    <th class="px-6 py-3 font-medium">Qty</th>
                                    <th class="px-6 py-3 font-medium">Supplier</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($stockIns as $in)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-3 whitespace-nowrap">{{ $in->date->format('d M Y') }}</td>
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $in->product->name }}</td>
                                        <td class="px-6 py-3 text-emerald-600 font-bold">+{{ $in->quantity }}</td>
                                        <td class="px-6 py-3">{{ $in->supplier_name ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi stok masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($stockIns->hasPages())
                        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $stockIns->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>

                <!-- Stok Keluar -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-orange-50/50 dark:bg-orange-900/10">
                        <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            Stok Keluar
                        </h3>
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Tanggal</th>
                                    <th class="px-6 py-3 font-medium">Barang</th>
                                    <th class="px-6 py-3 font-medium">Qty</th>
                                    <th class="px-6 py-3 font-medium">Penerima</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($stockOuts as $out)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-3 whitespace-nowrap">{{ $out->date->format('d M Y') }}</td>
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $out->product->name }}</td>
                                        <td class="px-6 py-3 text-orange-600 font-bold">-{{ $out->quantity }}</td>
                                        <td class="px-6 py-3">{{ $out->recipient_name ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi stok keluar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($stockOuts->hasPages())
                        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $stockOuts->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
