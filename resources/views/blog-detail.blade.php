@extends('layouts.master')

@section('title', $blog->title . ' - FindaUk')

@section('extra_styles')
<link rel="stylesheet" href="{{ asset('css/custom-blog-service.css') }}">
@endsection

@section('content')
<!--===== BLOG DETAIL HEADER AREA STARTS =======-->
<div class="blog-detail-header" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('@if($blog->image){{ asset('storage/' . $blog->image) }}@else{{ asset('theme/assets/images/blog/blog-header.jpg') }}@endif'); background-size: cover; background-position: center; padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-5 fw-bold mb-4">{{ $blog->title }}</h1>
                <div class="blog-meta d-flex justify-content-center align-items-center gap-4 text-white-75">
                    <span><i class="fas fa-calendar me-2"></i>{{ $blog->created_at->format('F d, Y') }}</span>
                    <span><i class="fas fa-clock me-2"></i>{{ $blog->created_at->diffForHumans() }}</span>
                    <span><i class="fas fa-user me-2"></i>FindaUk Team</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== BLOG DETAIL HEADER AREA ENDS =======-->

<!--===== BLOG DETAIL CONTENT AREA STARTS =======-->
<div class="blog-detail-content-area sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="blog-article bg-white rounded shadow-sm p-5 mb-5">
                    <!-- Featured Image -->
                    @if($blog->image)
                        <div class="blog-featured-image mb-5 text-center">
                            <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid rounded" alt="{{ $blog->title }}" style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    
                    <!-- Content -->
                    <div class="blog-content">
                        {!! $blog->content !!}
                    </div>
                    
                    <!-- Tags and Social Sharing -->
                    <div class="blog-footer mt-5 pt-4 border-top">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="blog-tags">
                                    <span class="fw-semibold me-2">Tags:</span>
                                    <a href="#" class="badge bg-primary text-decoration-none me-1">Real Estate</a>
                                    <a href="#" class="badge bg-primary text-decoration-none me-1">Property</a>
                                    <a href="#" class="badge bg-primary text-decoration-none">Investment</a>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <div class="social-sharing">
                                    <span class="fw-semibold me-2">Share:</span>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle me-1"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-info rounded-circle me-1"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger rounded-circle me-1"><i class="fab fa-pinterest"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-success rounded-circle"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                
                <!-- Author Box -->
                <div class="author-box bg-white rounded shadow-sm p-4 mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <img src="{{ asset('theme/assets/images/team/author.jpg') }}" class="rounded-circle" alt="Author" width="100" height="100" style="object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <h5 class="mb-2">About the Author</h5>
                            <h6 class="text-primary mb-3">FindaUk Team</h6>
                            <p class="mb-0 text-muted">We are a team of real estate professionals dedicated to helping you find your perfect property. With years of experience in the industry, we provide expert guidance and personalized service.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section bg-white rounded shadow-sm p-5">
                    <h4 class="mb-4">Comments (0)</h4>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-comments fa-2x mb-3"></i>
                        <p class="mb-0">Comments are coming soon! Stay tuned for interactive discussions.</p>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="blog-sidebar">
                    <!-- Recent Posts Widget -->
                    <div class="widget bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="widget-title mb-4 pb-2 border-bottom">Recent Posts</h5>
                        <div class="recent-posts">
                            @php
                                $recentBlogs = \App\Models\Blog::orderBy('created_at', 'desc')->take(5)->get();
                            @endphp
                            @foreach($recentBlogs as $recentBlog)
                                <div class="recent-post-item mb-3 pb-3 border-bottom">
                                    <div class="row g-2">
                                        <div class="col-4">
                                            @if($recentBlog->image)
                                                <img src="{{ asset('storage/' . $recentBlog->image) }}" class="img-fluid rounded" alt="{{ $recentBlog->title }}" style="height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-8">
                                            <h6 class="mb-1">
                                                <a href="{{ route('blog.show', $recentBlog) }}" class="text-decoration-none text-dark">{{ Str::limit($recentBlog->title, 50) }}</a>
                                            </h6>
                                            <small class="text-muted">{{ $recentBlog->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="widget bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="widget-title mb-4 pb-2 border-bottom">Categories</h5>
                        <div class="categories-list">
                            <a href="#" class="d-block py-2 text-decoration-none text-dark border-bottom">Real Estate Tips <span class="float-end text-muted">(12)</span></a>
                            <a href="#" class="d-block py-2 text-decoration-none text-dark border-bottom">Property Investment <span class="float-end text-muted">(8)</span></a>
                            <a href="#" class="d-block py-2 text-decoration-none text-dark border-bottom">Market Trends <span class="float-end text-muted">(15)</span></a>
                            <a href="#" class="d-block py-2 text-decoration-none text-dark">Home Buying <span class="float-end text-muted">(6)</span></a>
                        </div>
                    </div>
                    
                    <!-- Newsletter Widget -->
                    <div class="widget bg-primary text-white rounded shadow-sm p-4">
                        <h5 class="widget-title mb-3">Subscribe to Newsletter</h5>
                        <p class="mb-3">Get the latest property updates and market insights delivered to your inbox.</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your Email Address">
                            </div>
                            <button type="submit" class="btn btn-light w-100">Subscribe</button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!--===== BLOG DETAIL CONTENT AREA ENDS =======-->
@endsection