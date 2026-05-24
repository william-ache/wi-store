<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::withCount('products')->get();
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        }

        return view('admin.categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'required|boolean',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $slug = Str::slug($request->name);

        // Check if slug is unique for this shop
        $existing = Category::where('slug', $slug)->first();
        if ($existing) {
            $slug = $slug . '-' . uniqid();
        }

        $category = Category::create([
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'slug' => $slug,
            'status' => $request->status,
            'icon' => $request->icon,
            'color' => $request->color,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada exitosamente.',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'required|boolean',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $slug = Str::slug($request->name);
        if ($slug !== $category->slug) {
            $existing = Category::where('slug', $slug)->where('id', '!=', $category->id)->first();
            if ($existing) {
                $slug = $slug . '-' . uniqid();
            }
            $category->slug = $slug;
        }

        $category->name = $request->name;
        $category->seo_title = $request->seo_title;
        $category->seo_description = $request->seo_description;
        $category->status = $request->status;
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada exitosamente.',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Optional: Check if category contains products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la categoría porque contiene productos asociados.'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada exitosamente.'
        ]);
    }
}
