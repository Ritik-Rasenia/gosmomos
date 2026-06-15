@extends('layouts.app')

@section('title', $blog->title . ' — GOS MOMO')

@section('styles')
<style>
/* Premium Typography for Blog Content */
.blog-content {
    font-size: 1.15rem;
    line-height: 1.95;
    color: #333C4E;
}
.blog-content p {
    margin-bottom: 24px;
}
.blog-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--secondary-color);
    margin-top: 40px;
    margin-bottom: 20px;
}
.blog-content h3 {
    font-size: 1.45rem;
    font-weight: 600;
    color: var(--secondary-color);
    margin-top: 30px;
    margin-bottom: 15px;
}
.blog-content img {
    max-width: 100%;
    border-radius: 20px;
    margin: 30px 0;
    box-shadow: var(--shadow-soft);
}
.blog-content blockquote {
    border-left: 5px solid var(--primary-color);
    background: #FFF8F0;
    padding: 24px 30px;
    border-radius: 0 16px 16px 0;
    font-style: italic;
    font-size: 1.25rem;
    color: #4A5568;
    margin: 35px 0;
}

/* Sidebar Widgets */
.sidebar-widget {
    background: white;
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.04);
    box-shadow: 0 4px 25px rgba(0,0,0,0.02);
    padding: 30px;
    margin-bottom: 30px;
}
.sidebar-widget-title {
    font-family: var(--font-outfit);
    font-weight: 700;
    font-size: 1.25rem;
    color: var(--secondary-color);
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}
.sidebar-widget-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background-color: var(--primary-color);
    border-radius: 2px;
}

/* Author Profile */
.author-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #FFF8F0;
    box-shadow: 0 4px 15px rgba(255, 122, 0, 0.15);
}
.author-social-link {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #f8f9fa;
    color: var(--secondary-color);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-smooth);
    text-decoration: none;
}
.author-social-link:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* Share & Stats */
.stat-item {
    font-size: 0.95rem;
    color: #6C757D;
    display: flex;
    align-items: center;
    gap: 12px;
}

.widget-link {
    transition: var(--transition-smooth);
}
.widget-link:hover {
    color: var(--primary-color) !important;
    transform: translateX(4px);
}
.widget-post-item {
    transition: var(--transition-smooth);
}
.widget-post-item:hover .widget-post-title {
    color: var(--primary-color) !important;
}

/* Reviews Styling */
.review-stats-card {
    background: linear-gradient(135deg, #FFFDFB 0%, #FFF8F0 100%);
    border-radius: 20px;
    border: 1px solid rgba(255, 122, 0, 0.12);
    padding: 30px;
}
.review-stat-number {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--primary-color);
    line-height: 1;
}
.rating-bar-label {
    width: 60px;
    font-size: 0.85rem;
    font-weight: 600;
}
.rating-bar-percent {
    width: 45px;
    text-align: right;
    font-size: 0.85rem;
    font-weight: 600;
    color: #6C757D;
}
.review-item {
    background: white;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid rgba(0,0,0,0.04);
    box-shadow: 0 4px 15px rgba(0,0,0,0.01);
    transition: var(--transition-smooth);
}
.review-item:hover {
    box-shadow: 0 8px 25px rgba(255, 122, 0, 0.05);
}

/* Interactive Star Rating Selector */
.star-rating-select {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.star-rating-select label {
    font-size: 32px;
    color: #e9ecef;
    cursor: pointer;
    transition: color 0.15s ease-in-out;
}
.star-rating-select input:checked ~ label,
.star-rating-select label:hover,
.star-rating-select label:hover ~ label {
    color: #FF7A00 !important;
}
</style>
@endsection

@section('content')
@php
    $reviews = $blog->reviews;
    $totalReviews = $reviews->count();
    $avgRating = $blog->averageRating();
    $ratingPercentages = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    if ($totalReviews > 0) {
        foreach ($reviews as $rev) {
            if (isset($ratingPercentages[$rev->rating])) {
                $ratingPercentages[$rev->rating]++;
            }
        }
        foreach ($ratingPercentages as $star => $count) {
            $ratingPercentages[$star] = round(($count / $totalReviews) * 100);
        }
    }
@endphp

<!-- Page Header Banner -->
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">{{ $blog->category->name }}</span>
        <h1 class="display-4 fw-extrabold text-white mb-3">{{ $blog->title }}</h1>
        <nav aria-label="breadcrumb" class="d-flex justify-content-center">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">{{ Str::limit($blog->title, 30) }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-center align-items-center gap-3 text-white-50 small mt-3">
            <span><i class="bi bi-person me-1 text-white"></i>{{ $blog->author->name ?? 'GOS MOMO Team' }}</span>
            <span>•</span>
            <span><i class="bi bi-clock me-1 text-white"></i>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
            <span>•</span>
            <span><i class="bi bi-eye me-1 text-white"></i>{{ $blog->views }} Views</span>
        </div>
    </div>
</section>

<!-- Blog Layout Section -->
<div class="container py-5">
    <div class="row g-4">
        <!-- Main Content (Left Column) -->
        <div class="col-lg-8" data-aos="fade-right">
            <div class="bg-white rounded-4 border p-4 p-md-5 mb-5 shadow-sm">
                @if($blog->image_url)
                    <img src="{{ $blog->image_url }}" class="w-100 rounded-4 shadow-sm mb-4" alt="{{ $blog->title }}" style="max-height: 450px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=1200&q=80';">
                @endif

                <!-- Content Area -->
                <div class="blog-content">
                    {!! $blog->content !!}
                </div>
            </div>

            <!-- Review/Comment Section -->
            <div class="bg-white rounded-4 border p-4 p-md-5 mb-5 shadow-sm" id="reviews-section">
                <h3 class="fw-bold text-dark mb-4 font-outfit">Community Reviews ({{ $totalReviews }})</h3>

                <!-- Rating Stats Card -->
                <div class="review-stats-card mb-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center border-end-md">
                            <div class="review-stat-number mb-1">{{ $avgRating }}</div>
                            <div class="text-warning fs-4 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star-fill {{ $i <= round($avgRating) ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                @endfor
                            </div>
                            <span class="small text-muted d-block">Based on {{ $totalReviews }} reviews</span>
                        </div>
                        <div class="col-md-8 px-md-4">
                            <div class="d-flex flex-column gap-2">
                                @foreach([5, 4, 3, 2, 1] as $star)
                                <div class="d-flex align-items-center">
                                    <span class="rating-bar-label text-muted">{{ $star }} Star</span>
                                    <div class="progress flex-grow-1 mx-2" style="height: 8px; border-radius: 4px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $ratingPercentages[$star] }}%; border-radius: 4px;" aria-valuenow="{{ $ratingPercentages[$star] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="rating-bar-percent">{{ $ratingPercentages[$star] }}%</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="reviews-list d-flex flex-column gap-4 mb-5">
                    @forelse($reviews as $rev)
                    <div class="review-item">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #FF7A00, #E26C00); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem;" class="shadow-sm">
                                    {{ strtoupper(substr($rev->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $rev->user->name ?? 'GOS MOMO Fan' }}</h6>
                                    <span class="text-muted small" style="font-size:0.8rem;">{{ $rev->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="text-warning">
                                @for($r = 1; $r <= 5; $r++)
                                    <i class="bi bi-star-fill {{ $r <= $rev->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-muted mb-0 lh-relaxed" style="font-size: 0.95rem;">{{ $rev->comment }}</p>
                        
                        @if($rev->admin_reply)
                        <div class="mt-3 p-3 bg-light rounded-3 border-start border-warning border-3 small">
                            <strong>GOS MOMO response:</strong> {{ $rev->admin_reply }}
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted bg-light rounded-4">
                        <i class="bi bi-chat-left-dots fs-1 opacity-25 d-block mb-2 text-primary-color"></i>
                        <p class="mb-0">No reviews yet for this story. Be the first to share your thoughts!</p>
                    </div>
                    @endforelse
                </div>

                <!-- Review Form / Prompt -->
                <div class="border-top pt-5">
                    @auth
                        <h4 class="fw-bold text-dark mb-3 font-outfit">Leave a Review</h4>
                        <p class="text-muted small mb-4">Your email address will not be published. Required fields are marked *</p>

                        <form method="POST" action="{{ route('blog.review.store', $blog->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-dark d-block">Your Rating *</label>
                                <div class="star-rating-select">
                                    <input type="radio" id="star5" name="rating" value="5" class="d-none" required />
                                    <label for="star5" class="bi bi-star-fill me-1" title="5 stars"></label>
                                    <input type="radio" id="star4" name="rating" value="4" class="d-none" />
                                    <label for="star4" class="bi bi-star-fill me-1" title="4 stars"></label>
                                    <input type="radio" id="star3" name="rating" value="3" class="d-none" />
                                    <label for="star3" class="bi bi-star-fill me-1" title="3 stars"></label>
                                    <input type="radio" id="star2" name="rating" value="2" class="d-none" />
                                    <label for="star2" class="bi bi-star-fill me-1" title="2 stars"></label>
                                    <input type="radio" id="star1" name="rating" value="1" class="d-none" />
                                    <label for="star1" class="bi bi-star-fill me-1" title="1 star"></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-dark">Your Comment *</label>
                                <textarea name="comment" class="form-control rounded-3" rows="4" placeholder="Write your feedback/review here..." required style="border-color: #E2E8F0;"></textarea>
                            </div>

                            <button type="submit" class="btn btn-premium px-5 py-3">Submit Review</button>
                        </form>
                    @else
                        <div class="p-4 bg-light rounded-4 text-center border border-dashed">
                            <i class="bi bi-lock-fill fs-2 text-warning d-block mb-2"></i>
                            <h5 class="fw-bold mb-2">Write a Review</h5>
                            <p class="text-muted small mb-3">You must be logged in to rate this post and leave comments.</p>
                            <a href="{{ route('login') }}" class="btn btn-premium px-4 py-2">Log In to Continue</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Related Blogs -->
            @if($relatedBlogs->count() > 0)
            <div class="mt-5">
                <h3 class="fw-bold text-dark mb-4 font-outfit">Related Stories</h3>
                <div class="row g-4">
                    @foreach($relatedBlogs as $rb)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="border: 1px solid rgba(0,0,0,0.04) !important;">
                            @if($rb->image_url)
                                <img src="{{ $rb->image_url }}" class="w-100" style="height:180px; object-fit:cover;" alt="{{ $rb->title }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=600&q=80';">
                            @endif
                            <div class="p-4 d-flex flex-column justify-content-between h-100">
                                <div>
                                    <span class="badge bg-success-subtle text-success mb-2" style="font-size: 11px;">{{ $rb->category->name }}</span>
                                    <h6 class="fw-bold mb-3" style="font-size: 1.05rem; line-height: 1.4;">{{ $rb->title }}</h6>
                                </div>
                                <a href="{{ route('blog.show', $rb->slug) }}" class="btn btn-link text-primary-color p-0 small fw-bold text-decoration-none d-inline-flex align-items-center gap-1">Read Story <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar (Right Column) -->
        <div class="col-lg-4" data-aos="fade-left">
            <!-- Author Card -->
            <div class="sidebar-widget text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->author->name ?? 'GOS Team') }}&background=FF7A00&color=fff&size=200" alt="{{ $blog->author->name ?? 'Author' }}" class="author-avatar mb-3">
                <h5 class="fw-bold text-dark mb-1 font-outfit">{{ $blog->author->name ?? 'GOS MOMO Team' }}</h5>
                <span class="badge bg-light text-muted border mb-3">GOS Food Expert</span>
                <p class="text-muted small mb-4">A passionate food writer and culinary strategist. Dedicated to bringing clean, hygienic, and extremely mouth-watering street food stories from GOS MOMO's kitchens to India's foodie community.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="#" class="author-social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="author-social-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="author-social-link"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

            <!-- Share & Stats Widget -->
            <div class="sidebar-widget">
                <h5 class="sidebar-widget-title">Story Insights</h5>
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="stat-item">
                        <div class="p-2 bg-light rounded-3 text-primary-color"><i class="bi bi-eye-fill"></i></div>
                        <div>
                            <span class="d-block small text-muted">Total Views</span>
                            <strong class="text-dark">{{ number_format($blog->views) }} views</strong>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="p-2 bg-light rounded-3 text-primary-color"><i class="bi bi-book-fill"></i></div>
                        <div>
                            <span class="d-block small text-muted">Reading Time</span>
                            <strong class="text-dark">{{ $blog->reading_time }} min read</strong>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="p-2 bg-light rounded-3 text-primary-color"><i class="bi bi-calendar-check-fill"></i></div>
                        <div>
                            <span class="d-block small text-muted">Published On</span>
                            <strong class="text-dark">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : now()->format('M d, Y') }}</strong>
                        </div>
                    </div>
                </div>
                
                <hr class="mb-4">

                <h6 class="fw-bold text-dark mb-3">Share this Story</h6>
                <div class="row g-2">
                    <div class="col-6">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" target="_blank" class="btn btn-outline-success btn-sm w-100 rounded-pill d-flex align-items-center justify-content-center gap-2 py-2">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-secondary btn-sm w-100 rounded-pill d-flex align-items-center justify-content-center gap-2 py-2" onclick="copyBlogLink()">
                            <i class="bi bi-link-45deg"></i> Copy Link
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="sidebar-widget">
                <h5 class="sidebar-widget-title">Categories</h5>
                <ul class="list-unstyled mb-0">
                    @foreach($categories as $cat)
                    <li class="mb-2 pb-2 border-bottom border-light">
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="text-decoration-none text-dark d-flex justify-content-between align-items-center widget-link">
                            <span class="small"><i class="bi bi-tag-fill text-primary-color me-2"></i>{{ $cat->name }}</span>
                            <span class="badge bg-light text-muted border small">{{ $cat->blogs()->published()->count() }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Popular Widget -->
            @if($popularBlogs->count() > 0)
            <div class="sidebar-widget">
                <h5 class="sidebar-widget-title">Trending Stories</h5>
                <div class="d-flex flex-column gap-3">
                    @foreach($popularBlogs as $pBlog)
                    <a href="{{ route('blog.show', $pBlog->slug) }}" class="text-decoration-none text-dark widget-post-item">
                        <div class="d-flex gap-3 align-items-center">
                            @if($pBlog->image_url)
                                <img src="{{ $pBlog->image_url }}" alt="{{ $pBlog->title }}" style="width:70px; height:70px; object-fit:cover; border-radius:12px;" class="flex-shrink-0">
                            @else
                                <div style="width:70px; height:70px; border-radius:12px; background:linear-gradient(135deg, #FF7A00, #E26C00); display:flex; align-items:center; justify-content:center; font-size:24px; flex-shrink:0;">📝</div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-1 small leading-snug widget-post-title" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $pBlog->title }}</h6>
                                <span class="text-muted small" style="font-size:0.75rem;"><i class="bi bi-eye me-1"></i>{{ $pBlog->views }} Views</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function copyBlogLink() {
    navigator.clipboard.writeText(window.location.href);
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        icon: 'success',
        title: 'Link copied to clipboard!',
        timerProgressBar: true
    });
}
</script>
@endsection
