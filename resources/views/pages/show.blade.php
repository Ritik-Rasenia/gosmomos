@extends('layouts.app')

@section('title', ($page->meta_title ?? $page->title) . ' — ' . setting('site_name', 'GOS MOMO'))
@section('meta_description', $page->meta_description ?? setting('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? setting('seo_meta_keywords'))

@section('content')
<!-- Page Header Banner -->
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <h1 class="display-4 fw-extrabold text-white mb-2">
            {{ $page->title }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Page Body Content -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="content-body" style="font-family: 'Poppins', sans-serif; font-size: 1.1rem; line-height: 1.8; color: #333333;">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
