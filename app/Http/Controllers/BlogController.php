<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::all();
        
        $query = Blog::published()->with(['category', 'author']);

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(6);

        return view('pages.blog.index', compact('blogs', 'categories'));
    }

    public function show($slug)
    {
        $blog = Blog::published()
            ->with(['category', 'author', 'reviews' => function($query) {
                $query->approved()->with('user');
            }])
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Increment views safely
        $blog->increment('views');

        $relatedBlogs = Blog::published()
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->take(3)
            ->get();

        $categories = \App\Models\BlogCategory::all();
        
        $popularBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        return view('pages.blog.show', compact('blog', 'relatedBlogs', 'categories', 'popularBlogs'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $blog = Blog::findOrFail($id);

        \App\Models\BlogReview::create([
            'user_id' => auth()->id(),
            'blog_id' => $blog->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Auto-approved for simple setup
        ]);

        return back()->with('success', 'Your review has been posted successfully!');
    }
}
