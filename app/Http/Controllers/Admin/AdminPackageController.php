<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::query();

        if ($request->filled('type') && in_array($request->type, ['nutritionist', 'fitness'])) {
            $query->where('type', $request->type);
        }

        $packages = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.packages.partials.table', compact('packages'))->render();
        }

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'duration_days' => 'required|numeric',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB per file
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('packages', 'public');
            }
        }

        Package::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'description' => $request->description,
            'image' => count($imagePaths) > 0 ? json_encode($imagePaths) : null, // Store as JSON
            'is_active' => true,
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function show(Package $package)
    {
        $images = json_decode($package->image);
        $imageUrl = null;
        if (is_array($images) && count($images) > 0) {
            $imageUrl = asset('storage/' . $images[0]);
        } elseif ($package->image && !is_array($images)) {
            $imageUrl = asset('storage/' . $package->image);
        }

        return response()->json(array_merge($package->toArray(), [
            'image_url' => $imageUrl,
            'decoded_images' => $images
        ]));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'duration_days' => 'required|numeric',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except(['images']);

        if ($request->hasFile('images')) {
            // If you want to delete old images, you'd need to decode $package->image (if it's JSON)
            // and delete each path. For now, we're just replacing the reference.
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('packages', 'public');
            }
            $data['image'] = json_encode($imagePaths);
        }

        $data['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus');
    }
}
