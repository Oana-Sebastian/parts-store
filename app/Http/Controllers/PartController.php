<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Exceptions\PartNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class PartController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function index(Request $request)
    {
        $query = Part::query();

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $request->search . '%');
            });
        }

        $parts = $query->paginate(12);
        $categories = Part::distinct('category')->pluck('category');

        return view('parts.index', compact('parts', 'categories'));
    }

    public function show(string $id)
    {
        if ($id === 'create') {
            $this->create();
            return;
        }
        $part = Part::find($id);

        if (!$part) {
            throw new PartNotFoundException("Part with ID {$id} not found");
        }

        return view('parts.show', compact('part'));
    }

    public function create()
    {
        $this->authorize('create', Part::class);
        return view('parts.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Part::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:parts,code',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'new_category' => 'nullable|string|max:100',
            'manufacturer' => 'required|string|max:255',
            'images' => 'nullable|array',
            'image_urls.*' => 'nullable|url'
        ]);

        $category = $request->category;
        if ($category === 'Other' && $request->filled('new_category')) {
            $category = $request->new_category;
        }

        $images = array_filter($request->input('image_urls', []), function ($value) {
            return !is_null($value) && $value !== '';
        });

        Part::create([
            'name' => $request->name,
            'code' => $request->code,
            'category' => $category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'manufacturer' => $request->manufacturer,
            'images' => array_values($images)
        ]);

        return redirect()->route('parts.index')
            ->with('success', 'Part created successfully!');
    }

    public function edit(int $id)
    {
        $part = Part::findOrFail($id);
        $this->authorize('update', $part);

        return view('parts.edit', compact('part'));
    }

    public function update(Request $request, int $id)
    {
        $part = Part::findOrFail($id);
        $this->authorize('update', $part);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:parts,code,' . $id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'manufacturer' => 'required|string|max:255',
            'image_urls.*' => 'nullable|url',
            'delete_images.*' => 'nullable|string'
        ]);

        $currentImages = $part->images ?? [];

        if ($request->has('delete_images')) {
            $imagesToDelete = $request->input('delete_images');

            $currentImages = array_diff($currentImages, $imagesToDelete);
        }

        if ($request->has('image_urls')) {
            foreach ($request->input('image_urls') as $url) {
                if (!empty($url)) {
                    $currentImages[] = $url;
                }
            }
        }

        $validated['images'] = array_values($currentImages);

        $part->update($validated);

        return redirect()->route('parts.show', $part)
            ->with('success', 'Part updated successfully!');
    }

    public function destroy(int $id)
    {
        $part = Part::findOrFail($id);
        $this->authorize('delete', $part);

        $part->delete();

        return redirect()->route('parts.index')
            ->with('success', 'Part deleted successfully!');
    }
}
