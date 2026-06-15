@extends('layouts.admin')
@section('title', 'Blog Management — Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-journal-richtext me-2 text-orange"></i>Blog Management</h4>
        <p class="text-muted mb-0">Create, manage, and publish blog posts for Expert Chefs Blog.</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-orange rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> New Post
    </a>
</div>

<div class="admin-card p-4">
    @if($blogs->count())
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-light">
                    <th style="width:60px;">Cover</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Views</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>
                        <img src="{{ $blog->image_url ?? 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=80&q=60' }}"
                             style="width:50px;height:40px;object-fit:cover;border-radius:8px;" alt="cover">
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ Str::limit($blog->title, 55) }}</div>
                        <div class="text-muted small">{{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 60) }}</div>
                    </td>
                    <td><span class="badge bg-info-subtle text-info">{{ $blog->category->name ?? '—' }}</span></td>
                    <td class="small">{{ $blog->author->name ?? '—' }}</td>
                    <td><span class="badge bg-light text-dark"><i class="bi bi-eye me-1"></i>{{ number_format($blog->views) }}</span></td>
                    <td>
                        @if($blog->is_published)
                            <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Published</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning"><i class="bi bi-clock me-1"></i>Draft</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $blog->published_at ? $blog->published_at->format('d M Y') : '—' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-outline-primary rounded-2" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-warning rounded-2" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.blogs.toggle-publish', $blog->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $blog->is_published ? 'btn-outline-secondary' : 'btn-outline-success' }} rounded-2"
                                        title="{{ $blog->is_published ? 'Unpublish' : 'Publish' }}">
                                    <i class="bi bi-{{ $blog->is_published ? 'eye-slash' : 'cloud-upload' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirmDelete(this, 'Delete Blog Post?', 'Are you sure you want to delete this blog post?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $blogs->links() }}</div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-journal-x fs-1 d-block mb-3 opacity-25"></i>
        <h5 class="fw-bold">No blog posts yet</h5>
        <p>Start writing to engage your audience!</p>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-orange rounded-pill px-4">
            <i class="bi bi-plus me-1"></i> Create First Post
        </a>
    </div>
    @endif
</div>
@endsection
