<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('stocks.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-emerald-700 dark:text-emerald-400 leading-tight flex items-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ __('Catat Stok Masuk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="h-2 bg-emerald-500 w-full"></div>
                <div class="p-6 sm:p-10">
                    <form method="POST" action="{{ route('stocks.in.store') }}">
                        @csrf

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <x-input-label for="product_id" :value="__('Pilih Barang')" class="text-gray-700 font-medium mb-2" />
                            <select id="product_id" name="product_id" class="block w-full mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-gray-700 dark:text-gray-300" required autofocus>
                                <option value="" disabled selected>-- Cari & Pilih Barang --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        [{{ $product->category->name }}] {{ $product->name }} - Stok: {{ $product->stock }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Jumlah (Qty)')" class="text-gray-700 font-medium mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-emerald-500 font-bold">+</span>
                                    </div>
                                    <x-text-input id="quantity" class="block w-full mt-1 pl-8 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="number" min="1" name="quantity" :value="old('quantity', 1)" required />
                                </div>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="date" :value="__('Tanggal Masuk')" class="text-gray-700 font-medium mb-2" />
                                <x-text-input id="date" class="block w-full mt-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="date" name="date" :value="old('date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Supplier -->
                        <div class="mb-6">
                            <x-input-label for="supplier_name" :value="__('Nama Supplier (Opsional)')" class="text-gray-700 font-medium mb-2" />
                            <x-text-input id="supplier_name" class="block w-full mt-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="supplier_name" :value="old('supplier_name')" placeholder="Contoh: PT. Sumber Makmur" />
                            <x-input-error :messages="$errors->get('supplier_name')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('Catatan (Opsional)')" class="text-gray-700 font-medium mb-2" />
                            <textarea id="notes" name="notes" rows="3" class="block w-full mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('stocks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition shadow-md">
                                Simpan Stok Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
