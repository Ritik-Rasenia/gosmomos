<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        
        $query = Product::available()->with(['category', 'variants']);

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }

        if ($request->has('veg') && $request->veg === '1') {
            $query->veg();
        }

        if ($request->has('spice')) {
            $query->where('spice_level', $request->spice);
        }

        $products = $query->orderBy('sort_order')->get();

        return view('menu.index', compact('categories', 'products'));
    }

    public function show($slug)
    {
        $product = Product::available()->with(['category', 'variants', 'images'])->where('slug', $slug)->firstOrFail();
        
        $relatedProducts = Product::available()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = $product->reviews()->with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('menu.show', compact('product', 'relatedProducts', 'reviews'));
    }
}
