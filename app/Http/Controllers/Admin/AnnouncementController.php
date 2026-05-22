<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $announcements = Announcement::orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $announcements
            ]);
        }

        $count = Announcement::count();
        return view('admin.announcements.index', compact('count'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $count = Announcement::count();
        if ($count >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Límite alcanzado. Solo puedes tener un máximo de 3 anuncios simultáneos.'
            ], 422);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // max 2MB
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'expires_at' => $request->expires_at,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Anuncio creado exitosamente.',
            'data' => $announcement
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return response()->json([
            'success' => true,
            'data' => $announcement
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $imagePath = $announcement->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'expires_at' => $request->expires_at,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Anuncio actualizado exitosamente.',
            'data' => $announcement
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        if ($announcement->image_path && Storage::disk('public')->exists($announcement->image_path)) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anuncio eliminado exitosamente.'
        ]);
    }
}
