<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Location;
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
                $q->where('slug', 'combos');
            })
            ->take(3)
            ->get();

        $testimonials = Testimonial::active()->orderBy('sort_order')->get();
        $locations = Location::active()->get();

        return view('home', compact('banners', 'categories', 'trendingItems', 'combos', 'testimonials', 'locations'));
    }
}
