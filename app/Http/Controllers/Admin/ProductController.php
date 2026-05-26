<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Support\PlanLimits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category')->get();
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        }

        $categories = Category::where('status', true)->get();

        return view('admin.products.index', [
            'categories' => $categories,
            'usage' => PlanLimits::productsUsage(),
            'activeProductsCount' => Product::where('is_available', true)->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // max 2MB
            'is_available' => 'required|boolean',
            'features' => 'nullable|string',
            'preparation_time' => 'nullable|string|max:50',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $features = null;
        if ($request->filled('features')) {
            $features = json_decode($request->input('features'), true);
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'is_available' => $request->is_available,
            'features' => $features,
            'preparation_time' => $request->preparation_time,
        ]);

        // Load relation for response
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente.',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'required|boolean',
            'features' => 'nullable|string',
            'preparation_time' => 'nullable|string|max:50',
        ]);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $features = $product->features;
        if ($request->has('features')) {
            $features = $request->filled('features') ? json_decode($request->input('features'), true) : null;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'is_available' => $request->is_available,
            'features' => $features,
            'preparation_time' => $request->preparation_time,
        ]);

        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente.',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ]);
    }
}
