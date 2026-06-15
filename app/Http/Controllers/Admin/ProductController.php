<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'spice_level' => 'nullable|integer|min:0|max:3',
        ]);

        $imagePath = 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'base_price' => $request->base_price,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imagePath,
            'is_veg' => $request->has('is_veg'),
            'is_bestseller' => $request->has('is_bestseller'),
            'is_new' => $request->has('is_new'),
            'is_available' => true,
            'spice_level' => $request->spice_level ?? 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'spice_level' => 'required|integer|min:0|max:3',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'base_price' => $request->base_price,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imagePath,
            'is_veg' => $request->has('is_veg'),
            'is_bestseller' => $request->has('is_bestseller'),
            'is_new' => $request->has('is_new'),
            'is_available' => $request->has('is_available'),
            'spice_level' => $request->spice_level,
        ]);

        // Process Variants
        if ($request->has('variants')) {
            $variantIdsToKeep = [];
            foreach ($request->variants as $vData) {
                if (!empty($vData['name']) && isset($vData['price'])) {
                    $variant = $product->variants()->updateOrCreate(
                        ['id' => $vData['id'] ?? null],
                        [
                            'name' => $vData['name'],
                            'price' => $vData['price'],
                            'is_available' => isset($vData['is_available']) || (isset($vData['is_available_val']) && $vData['is_available_val'] == 1),
                        ]
                    );
                    $variantIdsToKeep[] = $variant->id;
                }
            }
            $product->variants()->whereNotIn('id', $variantIdsToKeep)->delete();
        } else {
            $product->variants()->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->variants()->delete();
        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }
}
