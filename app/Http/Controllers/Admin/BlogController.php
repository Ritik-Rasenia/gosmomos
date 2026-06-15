<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'author'])->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        $authors    = User::all();
        return view('admin.blogs.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:200',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'is_published'     => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . Str::random(4),
            'blog_category_id' => $request->blog_category_id,
            'user_id'          => $request->user_id ?? auth()->id(),
            'content'          => $request->content,
            'excerpt'          => $request->excerpt,
            'image'            => $imagePath,
            'is_published'     => $request->has('is_published'),
            'published_at'     => $request->has('is_published') ? now() : null,
            'views'            => 0,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    public function show($id)
    {
        $blog = Blog::with(['category', 'author'])->findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog       = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        $authors    = User::all();
        return view('admin.blogs.edit', compact('blog', 'categories', 'authors'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:200',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $wasPublished  = $blog->is_published;
        $nowPublishing = $request->has('is_published');

        $blog->update([
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . Str::random(4),
            'blog_category_id' => $request->blog_category_id,
            'user_id'          => $request->user_id ?? $blog->user_id,
            'content'          => $request->content,
            'excerpt'          => $request->excerpt,
            'image'            => $imagePath,
            'is_published'     => $nowPublishing,
            'published_at'     => ($nowPublishing && !$wasPublished) ? now() : $blog->published_at,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();
        return back()->with('success', 'Blog post deleted successfully!');
    }

    public function togglePublish($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => !$blog->is_published ? now() : $blog->published_at,
        ]);
        return back()->with('success', 'Blog status updated!');
    }
}
