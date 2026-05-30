<?php

namespace App\Http\Controllers;

use App\Models\PlatformNews;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SuperAdminNewsController extends Controller
{
    public function index(): View
    {
        $newsItems = PlatformNews::query()->latest()->get();

        return view('super-admin.news.index', [
            'newsItems' => $newsItems,
            'activeModule' => 'noticias',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);

        PlatformNews::create($data);

        return redirect()->route('super-admin.news.index')->with('success', 'Noticia creada correctamente.');
    }

    public function update(Request $request, PlatformNews $news): RedirectResponse
    {
        $data = $this->validated($request);

        if ($news->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $news->id);
        }

        $news->update($data);

        return redirect()->route('super-admin.news.index')->with('success', 'Noticia actualizada.');
    }

    public function destroy(PlatformNews $news): RedirectResponse
    {
        $news->delete();

        return redirect()->route('super-admin.news.index')->with('success', 'Noticia eliminada.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published']
            ? ($validated['published_at'] ?? now())
            : null;

        return $validated;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (
            PlatformNews::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
