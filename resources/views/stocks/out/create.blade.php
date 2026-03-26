<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('stocks.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-orange-700 dark:text-orange-400 leading-tight flex items-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                {{ __('Catat Stok Keluar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="h-2 bg-orange-500 w-full"></div>
                
                <div class="p-6 sm:p-10">
                    @if($errors->has('quantity'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $errors->first('quantity') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('stocks.out.store') }}">
                        @csrf

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <x-input-label for="product_id" :value="__('Pilih Barang')" class="text-gray-700 font-medium mb-2" />
                            <select id="product_id" name="product_id" class="block w-full mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm text-gray-700" autofocus>
                                <option value="" disabled selected>-- Cari & Pilih Barang --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        [{{ $product->category->name }}] {{ $product->name }} - Sisa Stok: {{ $product->stock }}
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
                                        <span class="text-orange-500 font-bold">-</span>
                                    </div>
                                    <x-text-input id="quantity" class="block w-full mt-1 pl-8 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" type="number" min="1" name="quantity" :value="old('quantity', 1)"  />
                                </div>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="date" :value="__('Tanggal Keluar')" class="text-gray-700 font-medium mb-2" />
                                <x-text-input id="date" class="block w-full mt-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" type="date" name="date" :value="old('date', date('Y-m-d'))"  />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Recipient -->
                        <div class="mb-6">
                            <x-input-label for="recipient_name" :value="__('Nama Penerima / Divisi')" class="text-gray-700 font-medium mb-2" />
                            <x-text-input id="recipient_name" class="block w-full mt-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" type="text" name="recipient_name" :value="old('recipient_name')" placeholder="Contoh: Divisi IT / Budi" />
                            <x-input-error :messages="$errors->get('recipient_name')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('Catatan / Keterangan (Opsional)')" class="text-gray-700 font-medium mb-2" />
                            <textarea id="notes" name="notes" rows="3" class="block w-full mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('stocks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition shadow-md">
                                Simpan Stok Keluar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
