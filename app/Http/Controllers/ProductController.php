<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Store request data:', $request->except('image'));
        
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->getError() !== UPLOAD_ERR_OK) {
                Log::error('File upload error code: ' . $file->getError());
                return back()->withErrors(['image' => 'Upload gagal dengan kode error: ' . $file->getError()]);
            }
            
            $realPath = $file->getRealPath();
            Log::info('File details: Name=' . $file->getClientOriginalName() . ', Size=' . $file->getSize() . ', RealPath=' . ($realPath ?: 'EMPTY'));
            
            try {
                $extension = $file->getClientOriginalExtension() ?: 'jpg';
                $fileName  = 'products/' . Str::uuid() . '.' . $extension;
                
                if (!empty($realPath) && file_exists($realPath)) {
                    // Normal path: temp file exists
                    Storage::disk('public')->put($fileName, file_get_contents($realPath));
                } else {
                    // Fallback: read directly from upload stream
                    $stream = fopen('php://input', 'r');
                    // Since php://input is already consumed, try reading from the $_FILES array
                    $tmpName = $_FILES['image']['tmp_name'] ?? '';
                    if (!empty($tmpName) && file_exists($tmpName)) {
                        Storage::disk('public')->put($fileName, file_get_contents($tmpName));
                    } else {
                        Log::error('Cannot read uploaded file: both getRealPath and $_FILES[tmp_name] are empty.');
                        fclose($stream);
                        return back()->withErrors(['image' => 'Gagal membaca file foto. Coba restart Laragon dan upload ulang.']);
                    }
                    fclose($stream);
                }
                
                Log::info('Image stored successfully at: ' . $fileName);
                $data['image'] = $fileName;
            } catch (\Exception $e) {
                Log::error('Storage store error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal menyimpan foto: ' . $e->getMessage()]);
            }
        } else {
            Log::warning('No file found under "image" key.');
        }

        try {
            Product::create($data);
            Log::info('Product created in DB.');
        } catch (\Exception $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
        }

        return redirect()->route('products.index')->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Update request for Product ID: ' . $product->id);
        Log::info('All request data keys: ' . implode(',', array_keys($request->all())));
        Log::info('All files: ' . implode(',', array_keys($request->allFiles())));
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->getError() !== UPLOAD_ERR_OK) {
                Log::error('Update file upload error code: ' . $file->getError());
                return back()->withErrors(['image' => 'Upload gagal dengan kode error: ' . $file->getError()]);
            }
            $realPath = $file->getRealPath();
            Log::info('Update File details: Path=' . ($realPath ?: 'EMPTY'));

            // Delete old image
            try {
                if (!empty($product->image) && trim($product->image) !== '' && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to delete old image: ' . $e->getMessage());
            }

            try {
                $extension = $file->getClientOriginalExtension() ?: 'jpg';
                $fileName  = 'products/' . Str::uuid() . '.' . $extension;

                if (!empty($realPath) && file_exists($realPath)) {
                    Storage::disk('public')->put($fileName, file_get_contents($realPath));
                } else {
                    $tmpName = $_FILES['image']['tmp_name'] ?? '';
                    if (!empty($tmpName) && file_exists($tmpName)) {
                        Storage::disk('public')->put($fileName, file_get_contents($tmpName));
                    } else {
                        return back()->withErrors(['image' => 'Gagal membaca file foto. Coba restart Laragon dan upload ulang.']);
                    }
                }
                Log::info('New image stored at: ' . $fileName);
                $data['image'] = $fileName;
            } catch (\Exception $e) {
                Log::error('Update store error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal menyimpan foto baru: ' . $e->getMessage()]);
            }
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Data barang berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->stockIns()->count() > 0 || $product->stockOuts()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        try {
            if (!empty($product->image) && trim($product->image) !== "" && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete image on destroy: ' . $e->getMessage());
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data barang berhasil dihapus.');
    }
}
