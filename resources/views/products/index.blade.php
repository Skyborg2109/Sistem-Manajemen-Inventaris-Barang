<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-5">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-left">
                {{ __('Master Barang') }}
            </h2>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <form action="{{ route('products.index') }}" method="GET" class="w-full sm:w-64">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="Cari nama barang...">
                    </div>
                </form>

                <a href="{{ route('products.create') }}" class="shrink-0 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 group flex flex-col">
                        <div class="relative h-48 bg-gray-100 dark:bg-gray-900 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 text-xs font-semibold bg-white/90 backdrop-blur text-gray-800 rounded-md shadow-sm">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-3 right-3">
                                @if($product->stock <= 5)
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-md shadow-sm border border-red-200">Sisa {{ $product->stock }}</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-md shadow-sm border border-emerald-200">Stok: {{ $product->stock }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1 line-clamp-1" title="{{ $product->name }}">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4 flex-1">
                                {{ $product->description ?: 'Tidak ada deskripsi.' }}
                            </p>
                            
                            <div class="flex items-center gap-2 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ route('products.edit', $product) }}" class="flex-1 text-center py-2 bg-gray-50 dark:bg-gray-700/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg text-sm font-medium transition duration-150">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1 flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex-1 w-full text-center py-2 bg-gray-50 dark:bg-gray-700/50 hover:bg-red-50 dark:hover:bg-red-900/40 text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 rounded-lg text-sm font-medium transition duration-150">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-900 mb-4 text-gray-400 dark:text-gray-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">Belum ada barang</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4 max-w-sm mx-auto">Tambahkan produk pertama Anda ke dalam sistem inventaris ini.</p>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Barang
                        </a>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>
