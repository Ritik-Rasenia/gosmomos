@extends('layouts.admin')
@section('title', $blog->title . ' — Blog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-journal-richtext me-2 text-orange"></i>Blog Post Detail</h4>
        <p class="text-muted mb-0">Preview and manage this article.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-outline-warning rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-dark rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Article Preview --}}
    <div class="col-lg-8">
        <div class="admin-card overflow-hidden">
            @if($blog->image_url)
                <img src="{{ $blog->image_url }}" class="w-100" style="height:320px;object-fit:cover;" alt="{{ $blog->title }}">
            @endif
            <div class="p-4">
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-orange" style="background:#FF7A00!important;">{{ $blog->category->name ?? '—' }}</span>
                    @if($blog->is_published)
                        <span class="badge bg-success-subtle text-success">Published</span>
                    @else
                        <span class="badge bg-warning-subtle text-warning">Draft</span>
                    @endif
                </div>
                <h2 class="fw-bold mb-2">{{ $blog->title }}</h2>
                @if($blog->excerpt)
                    <p class="text-muted border-start border-3 border-warning ps-3 mb-3 fst-italic">{{ $blog->excerpt }}</p>
                @endif
                <hr>
                <div class="blog-content" style="line-height:1.8; font-size:14px; color:#333;">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Meta Info --}}
    <div class="col-lg-4">
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-orange"></i>Post Info</h6>
            <table class="table table-borderless small mb-0">
                <tr>
                    <td class="text-muted fw-semibold ps-0">Author</td>
                    <td>{{ $blog->author->name ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold ps-0">Category</td>
                    <td>{{ $blog->category->name ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold ps-0">Status</td>
                    <td>
                        @if($blog->is_published)
                            <span class="badge bg-success-subtle text-success">Published</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning">Draft</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold ps-0">Views</td>
                    <td>{{ number_format($blog->views) }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold ps-0">Published</td>
                    <td>{{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Not yet' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold ps-0">Created</td>
                    <td>{{ $blog->created_at->format('d M Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-orange"></i>Actions</h6>
            <div class="d-flex flex-column gap-2">
                <form action="{{ route('admin.blogs.toggle-publish', $blog->id) }}" method="POST">
                    @csrf
                    <button class="btn w-100 {{ $blog->is_published ? 'btn-outline-secondary' : 'btn-success' }} rounded-pill">
                        <i class="bi bi-{{ $blog->is_published ? 'eye-slash' : 'cloud-upload' }} me-1"></i>
                        {{ $blog->is_published ? 'Unpublish' : 'Publish Now' }}
                    </button>
                </form>
                @if($blog->is_published)
                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-outline-primary rounded-pill w-100">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View on Site
                </a>
                @endif
                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                      onsubmit="return confirmDelete(this, 'Delete Blog Post?', 'Are you sure you want to permanently delete this blog post?')">
                    @csrf
                    <button class="btn btn-outline-danger rounded-pill w-100">
                        <i class="bi bi-trash me-1"></i> Delete Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
