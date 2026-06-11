@extends('layouts.app')

@section('title', 'Food Blogs & Stories — GOS MOMO')

@section('styles')
<style>
.blog-hero {
    background: linear-gradient(135deg, #0F5132 0%, #157347 100%);
    padding: 80px 0 40px;
    color: white;
}
.blog-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: none;
    overflow: hidden;
    transition: all 0.3s ease;
}
.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(15,81,50,0.12);
}
</style>
@endsection

@section('content')
<div class="blog-hero text-center">
    <div class="container">
        <h1 class="fw-bold">GOS MOMO Stories</h1>
        <p class="text-white-75 mb-0">Discover recipes, street food culture, franchising tips, and company updates.</p>
    </div>
</div>

<div class="container py-5">
    {{-- Categories & Search --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">
        <div class="d-flex gap-2 overflow-auto pb-1">
            <a href="{{ route('blog.index') }}" class="btn {{ !request('category') ? 'btn-success' : 'btn-outline-success' }} rounded-pill btn-sm px-3">All Stories</a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="btn {{ request('category') == $cat->slug ? 'btn-success' : 'btn-outline-success' }} rounded-pill btn-sm px-3">{{ $cat->name }}</a>
            @endforeach
        </div>
        <form method="GET" action="{{ route('blog.index') }}" class="d-flex" style="max-width:300px;">
            <input type="text" name="search" class="form-control rounded-pill border-success" placeholder="Search articles..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="row g-4">
        @forelse($blogs as $blog)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
            <div class="blog-card h-100 d-flex flex-column justify-content-between">
                <div>
                    @if($blog->image_url)
                        <img src="{{ $blog->image_url }}" class="w-100" style="height:200px; object-fit:cover;" alt="{{ $blog->title }}">
                    @else
                        <div style="height:200px; background:linear-gradient(135deg, #0F5132, #D4A017); display:flex; align-items:center; justify-content:center; font-size:60px;">📝</div>
                    @endif
                    <div class="p-4">
                        <span class="badge bg-success-subtle text-success mb-2">{{ $blog->category->name }}</span>
                        <h5 class="fw-bold text-dark mb-2">{{ $blog->title }}</h5>
                        <p class="text-muted small mb-0" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">{{ strip_tags($blog->content) }}</p>
                    </div>
                </div>
                <div class="p-4 pt-0">
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-premium btn-sm rounded-pill">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size: 80px;">📰</div>
            <h4 class="fw-bold mt-3">No articles found</h4>
            <p class="text-muted">We will publish new stories soon. Stay tuned!</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
