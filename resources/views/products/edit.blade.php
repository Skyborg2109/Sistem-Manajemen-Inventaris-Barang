<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ubah Master Barang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-10">
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Nama Barang')" class="text-gray-700 font-medium mb-2" />
                                    <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Category -->
                                <div>
                                    <x-input-label for="category_id" :value="__('Kategori')" class="text-gray-700 font-medium mb-2" />
                                    <select id="category_id" name="category_id" class="block w-full mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>

                                <!-- Description -->
                                <div>
                                    <x-input-label for="description" :value="__('Deskripsi Barang')" class="text-gray-700 font-medium mb-2" />
                                    <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('description', $product->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Stock Initial -->
                                <div>
                                    <x-input-label for="stock" :value="__('Stok Saat Ini')" class="text-gray-700 font-medium mb-2" />
                                    <x-text-input id="stock" class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" type="number" name="stock" :value="$product->stock" readonly title="Stok hanya dapat diubah melalui fitur Stok Masuk / Keluar" />
                                    <p class="text-xs text-gray-500 mt-1">Stok diperbarui melalui transaksi Stok Masuk dan Stok Keluar.</p>
                                </div>

                                <!-- Image Upload -->
                                <div>
                                    <x-input-label for="image" :value="__('Foto Barang (Ubah/Hapus Opsional)')" class="text-gray-700 font-medium mb-2" />
                                    
                                    @if($product->image)
                                    <div class="mb-4 relative rounded-xl overflow-hidden border border-gray-200">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover" alt="Current Image">
                                        <div class="absolute inset-0 bg-gray-900/60 flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                                            <span class="text-white font-medium text-sm mb-2">Gambar Saat Ini</span>
                                        </div>
                                    </div>
                                    @endif

                                    <label for="image" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl group hover:border-indigo-500 dark:hover:border-indigo-500 transition cursor-pointer relative">
                                        <div class="space-y-2 text-center">
                                            <svg class="mx-auto h-10 w-10 text-gray-400 group-hover:text-indigo-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <span class="relative font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    <span>Upload gambar baru</span>
                                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="document.getElementById('file-name').textContent = this.files[0].name;">
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                    <p id="file-name" class="mt-2 text-sm text-gray-500 italic text-center"></p>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 transition mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-md hover:shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
