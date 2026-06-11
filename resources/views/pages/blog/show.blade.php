@extends('layouts.app')

@section('title', $blog->title . ' — GOS MOMO')

@section('styles')
<style>
.blog-content img {
    max-width: 100%;
    border-radius: 16px;
    margin: 20px 0;
}
.blog-header {
    padding: 60px 0;
    background: #FFF8F0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
</style>
@endsection

@section('content')
<div class="blog-header">
    <div class="container text-center">
        <a href="{{ route('blog.index') }}" class="btn btn-outline-success btn-sm rounded-pill mb-3">← Back to Stories</a>
        <h1 class="fw-bold text-primary-color mb-3">{{ $blog->title }}</h1>
        <div class="d-flex justify-content-center align-items-center gap-3 text-muted small">
            <span><i class="bi bi-person me-1"></i>{{ $blog->author->name ?? 'GOS MOMO Team' }}</span>
            <span>•</span>
            <span><i class="bi bi-clock me-1"></i>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
            <span>•</span>
            <span><i class="bi bi-eye me-1"></i>{{ $blog->views }} Views</span>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            @if($blog->image_url)
                <img src="{{ $blog->image_url }}" class="w-100 rounded-4 shadow-sm mb-4" alt="{{ $blog->title }}" style="max-height: 400px; object-fit: cover;">
            @endif

            <div class="blog-content text-muted lh-lg" style="font-size: 16px; font-family: 'Poppins', sans-serif;">
                {!! $blog->content !!}
            </div>

            <hr class="my-5">

            {{-- Related Blogs --}}
            @if($relatedBlogs->count() > 0)
            <div class="mt-5">
                <h4 class="fw-bold text-primary-color mb-4">Related Stories</h4>
                <div class="row g-4">
                    @foreach($relatedBlogs as $rb)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                            @if($rb->image_url)
                                <img src="{{ $rb->image_url }}" class="w-100" style="height:150px; object-fit:cover;" alt="{{ $rb->title }}">
                            @endif
                            <div class="p-4">
                                <h6 class="fw-bold mb-2">{{ $rb->title }}</h6>
                                <a href="{{ route('blog.show', $rb->slug) }}" class="btn btn-link text-success p-0 small">Read More →</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
