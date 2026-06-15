<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Location;
use App\Models\Chef;
use App\Models\Blog;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->orderBy('sort_order')->get();
        $categories = Category::active()->orderBy('sort_order')->get();
        
        $trendingItems = Product::available()
            ->where(function($q) {
                $q->where('is_bestseller', true)->orWhere('is_new', true);
            })
            ->take(6)
            ->get();
            
        $combos = Product::available()
            ->whereHas('category', function($q) {
                $q->where('slug', 'combo-pack');
            })
            ->take(3)
            ->get();

        $testimonials = Testimonial::active()->orderBy('sort_order')->get();
        $reviews = Review::approved()->with(['user', 'product'])->latest()->take(8)->get();
        $locations = Location::active()->get();
        $chefs = Chef::active()->orderBy('sort_order')->get();
        $blogs = Blog::published()->with('category')->latest()->take(3)->get();

        $offerProducts = Product::available()
            ->whereIn('slug', ['classic-chicken-kurkure-momo', 'signature-veg-steam-momo'])
            ->get();

        if ($offerProducts->count() === 2) {
            $offerProducts = $offerProducts->sortBy(function($product) {
                return $product->slug === 'classic-chicken-kurkure-momo' ? 0 : 1;
            })->values();
        } else {
            $offerProducts = Product::available()->take(2)->get();
        }

        return view('home', compact('banners', 'categories', 'trendingItems', 'combos', 'testimonials', 'reviews', 'locations', 'chefs', 'blogs', 'offerProducts'));
    }
}
