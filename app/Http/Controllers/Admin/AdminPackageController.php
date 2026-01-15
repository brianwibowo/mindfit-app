<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
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
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
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
            // Delete old images if need OR keep them.
            // For simplicity, we replace them if new ones are uploaded, OR we specific logic.
            // "Standard" is usually replace.

            // If you want to delete old images, you'd need to decode $package->image (if it's JSON)
            // and delete each path. For now, we're just replacing the reference.
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('packages', 'public');
            }
            $data['image'] = json_encode($imagePaths);
        }

        $data['is_active'] = $request->has('is_active'); // Checkbox handling

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
