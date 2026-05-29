<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ImageOptimizer;
use App\Support\PlanLimits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __construct(
        private readonly ImageOptimizer $imageOptimizer,
    ) {}
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
        $usage = PlanLimits::productsUsage();
        if ($usage['at_limit']) {
            return response()->json([
                'success' => false,
                'message' => 'Has alcanzado el límite de ' . $usage['limit_label'] . ' productos del plan ' . $usage['plan_name'] . '. Actualiza a Negocio para ampliar tu catálogo.',
            ], 422);
        }

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

        $imageFields = [];
        if ($request->hasFile('image')) {
            $imageFields = $this->imageOptimizer->storeProductImage($request->file('image'));
        }

        $features = null;
        if ($request->filled('features')) {
            $features = json_decode($request->input('features'), true);
        }

        $product = Product::create(array_merge([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'description' => $request->description,
            'price' => $request->price,
            'is_available' => $request->is_available,
            'features' => $features,
            'preparation_time' => $request->preparation_time,
        ], $imageFields));

        $product->load('category');
        $this->forgetShopSitemapCache($product->shop_id);

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

        $imageFields = [];
        if ($request->hasFile('image')) {
            $this->imageOptimizer->deleteProductImages($product->image_path, $product->image_webp_path);
            $imageFields = $this->imageOptimizer->storeProductImage($request->file('image'));
        }

        $features = $product->features;
        if ($request->has('features')) {
            $features = $request->filled('features') ? json_decode($request->input('features'), true) : null;
        }

        $product->update(array_merge([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'description' => $request->description,
            'price' => $request->price,
            'is_available' => $request->is_available,
            'features' => $features,
            'preparation_time' => $request->preparation_time,
        ], $imageFields));

        $product->load('category');
        $this->forgetShopSitemapCache($product->shop_id);

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
        $this->imageOptimizer->deleteProductImages($product->image_path, $product->image_webp_path);
        $shopId = $product->shop_id;
        $product->delete();
        $this->forgetShopSitemapCache($shopId);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ]);
    }

    private function forgetShopSitemapCache(?int $shopId): void
    {
        if ($shopId) {
            Cache::forget("sitemap.shop.{$shopId}");
        }
    }
}
