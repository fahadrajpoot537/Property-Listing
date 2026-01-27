@extends('layouts.master')

@section('title', 'Blogs - FindaUk')

@section('extra_styles')
<link rel="stylesheet" href="{{ asset('css/custom-blog-service.css') }}">
@endsection

@section('content')
<!--===== BLOG HEADER AREA STARTS =======-->
<div class="page-banner-area" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('theme/assets/images/blog/blog-header.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-banner-content text-center">
                    <h1 class="text-white">Our Latest Blogs</h1>
                    <p class="text-white-50 mt-3">Stay updated with the latest news and insights from our experts</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== BLOG HEADER AREA ENDS =======-->

<!--===== BLOG GRID AREA STARTS =======-->
<div class="blog-grid-section-area sp2">
    <div class="container">
        <div class="row">
            @forelse($blogs as $blog)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-grid-card h-100">
                    <div class="blog-image position-relative overflow-hidden rounded-top">
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid w-100" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('theme/assets/images/blog/default.jpg') }}" class="img-fluid w-100" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover; background-color: #f8f9fa;">
                        @endif
                        <div class="date-badge bg-primary text-white px-3 py-1 position-absolute top-0 end-0 mt-3 me-3 rounded-pill">
                            {{ $blog->created_at->format('M d') }}
                        </div>
                    </div>
                    <div class="blog-content bg-white p-4 border border-top-0 rounded-bottom">
                        <h4 class="blog-title mb-3">
                            <a href="{{ route('blog.show', $blog) }}" class="text-decoration-none text-dark">{{ $blog->title }}</a>
                        </h4>
                        <p class="blog-excerpt text-muted mb-4">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                        <div class="blog-meta d-flex justify-content-between align-items-center">
                            <a href="{{ route('blog.show', $blog) }}" class="btn btn-primary btn-sm">Read More</a>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ $blog->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-blog fa-3x text-muted"></i>
                    </div>
                    <h3 class="mb-3">No Blogs Available</h3>
                    <p class="text-muted">We're working on creating amazing content for you. Please check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>
        
        @if($blogs->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="pagination-wrapper d-flex justify-content-center mt-5">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!--===== BLOG GRID AREA ENDS =======-->
@endsection