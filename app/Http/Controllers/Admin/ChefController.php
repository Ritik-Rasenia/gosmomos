<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chef;
use Illuminate\Support\Facades\Storage;

class ChefController extends Controller
{
    public function index()
    {
        $chefs = Chef::orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.chefs.index', compact('chefs'));
    }

    public function create()
    {
        return view('admin.chefs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:150',
            'role'          => 'required|string|max:150',
            'bio'           => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'facebook_url'  => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url'   => 'nullable|url|max:255',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chefs', 'public');
        }

        Chef::create([
            'name'          => $request->name,
            'role'          => $request->role,
            'bio'           => $request->bio,
            'image'         => $imagePath,
            'facebook_url'  => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'twitter_url'   => $request->twitter_url,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->route('admin.chefs.index')->with('success', 'Chef profile created successfully!');
    }

    public function edit($id)
    {
        $chef = Chef::findOrFail($id);
        return view('admin.chefs.edit', compact('chef'));
    }

    public function update(Request $request, $id)
    {
        $chef = Chef::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:150',
            'role'          => 'required|string|max:150',
            'bio'           => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'facebook_url'  => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url'   => 'nullable|url|max:255',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $imagePath = $chef->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists and is a local file
            if ($chef->image && !filter_var($chef->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($chef->image);
            }
            $imagePath = $request->file('image')->store('chefs', 'public');
        }

        $chef->update([
            'name'          => $request->name,
            'role'          => $request->role,
            'bio'           => $request->bio,
            'image'         => $imagePath,
            'facebook_url'  => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'twitter_url'   => $request->twitter_url,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->route('admin.chefs.index')->with('success', 'Chef profile updated successfully!');
    }

    public function destroy($id)
    {
        $chef = Chef::findOrFail($id);

        // Delete image if it is local
        if ($chef->image && !filter_var($chef->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($chef->image);
        }

        $chef->delete();

        return redirect()->route('admin.chefs.index')->with('success', 'Chef profile deleted successfully!');
    }

    public function toggleActive($id)
    {
        $chef = Chef::findOrFail($id);
        $chef->update([
            'is_active' => !$chef->is_active
        ]);

        return back()->with('success', 'Chef status updated successfully!');
    }
}
