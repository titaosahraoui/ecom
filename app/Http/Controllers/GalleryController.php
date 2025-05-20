<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $galleries = Gallery::where('approved', true)
            ->with(['user', 'primaryImage'])
            ->latest()
            ->paginate(12);

        $pendingGalleries = collect();

        if (auth()->check() && auth()->user()->can('approve', Gallery::class)) {
            $pendingGalleries = Gallery::where('approved', false)
                ->with(['user', 'primaryImage'])
                ->latest()
                ->get();
        }

        return view('gallery.index', compact('galleries', 'pendingGalleries'));
    }
    public function create()
    {
        $this->authorize('create', Gallery::class);
        return view('gallery.index'); // All in index view
    }
    public function store(Request $request)
    {
        $this->authorize('create', Gallery::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Create the gallery
            $gallery = Gallery::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'approved' => Auth::user()->can('approve', Gallery::class), // Auto-approve if admin
            ]);

            // Process each uploaded image
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('gallery', 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0, // First image is primary
                ]);
            }

            DB::commit();

            return redirect()->route('gallery.index')
                ->with('success', Auth::user()->can('approve', Gallery::class)
                    ? 'Gallery created successfully!'
                    : 'Gallery submitted for approval');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create gallery: ' . $e->getMessage());
        }
    }

    public function show(Gallery $gallery)
    {
        if (!$gallery->approved && !auth()->user()?->can('approve', Gallery::class)) {
            abort(404);
        }

        return view('gallery.show', [
            'gallery' => $gallery->load('images'),
            'previous' => Gallery::where('id', '<', $gallery->id)
                ->where('approved', true)
                ->orderBy('id', 'desc')
                ->first(),
            'next' => Gallery::where('id', '>', $gallery->id)
                ->where('approved', true)
                ->orderBy('id', 'asc')
                ->first()
        ]);
    }

    public function edit(Gallery $gallery)
    {
        $this->authorize('update', $gallery);
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->authorize('update', $gallery);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'approved' => false, // Needs re-approval after edit
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('gallery.show', $gallery)
            ->with('success', 'Gallery item updated and submitted for re-approval');
    }

    public function destroy(Gallery $gallery)
    {
        $this->authorize('delete', $gallery);

        // Delete image file
        Storage::disk('public')->delete($gallery->image);

        $gallery->delete();

        return redirect()->route('gallery.index')
            ->with('success', 'Gallery item deleted successfully');
    }

    // Admin approval methods
    public function approve(Gallery $gallery)
    {
        $this->authorize('approve', Gallery::class);

        $gallery->update(['approved' => true]);

        return back()->with('success', 'Gallery approved successfully');
    }

    public function reject(Gallery $gallery)
    {
        $this->authorize('approve', Gallery::class);

        DB::transaction(function () use ($gallery) {
            foreach ($gallery->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            $gallery->delete();
        });

        return back()->with('success', 'Gallery rejected and deleted');
    }
}
