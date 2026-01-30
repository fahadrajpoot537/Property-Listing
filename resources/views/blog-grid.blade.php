@extends('layouts.master')

@section('title', 'Blogs - FindaUk')

@section('content')
    <!--===== PAGE HERO AREA STARTS =======-->
    <!--===== PAGE HERO AREA STARTS =======-->
    <div class="common-hero-section-area sp1" style="background-color: #f4f5f7; position: relative;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto my-5">
                    <div class="common-hero-content text-center">
                        <h1 class="text-dark text-anime-style-3">Our Latest Blogs</h1>
                        <div class="space16"></div>
                        <ul class="page-list text-dark d-flex justify-content-center align-items-center"
                            style="list-style: none; padding: 0;">
                            <li class="px-1"><a href="{{ url('/') }}" class="text-dark"
                                    style="text-decoration: none;">Home</a></li>
                            <li class="px-1 text-dark">/</li>
                            <li class="px-1" style="color: #1CD494;">Blogs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== PAGE HERO AREA ENDS =======-->

    <!--===== BLOG GRID AREA STARTS =======-->
    <div class="blog-grid-section-area" style="padding-top: 40px; padding-bottom: 80px;">
        <div class="container">
            <div class="row">
                @forelse($blogs as $blog)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="blog-boxarea"
                            style="background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0px 4px 10px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                            <div class="img1 image-anime position-relative" style="height: 250px; overflow: hidden;">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid w-100 h-100"
                                        alt="{{ $blog->title }}" style="object-fit: cover;">
                                @else
                                    <img src="{{ asset('theme/assets/images/blog/default.jpg') }}" class="img-fluid w-100 h-100"
                                        alt="{{ $blog->title }}" style="object-fit: cover;">
                                @endif
                                <div class="date-badge"
                                    style="position: absolute; top: 20px; right: 20px; background: #ff931e; color: #fff; padding: 5px 15px; border-radius: 5px; font-weight: 600; font-size: 14px;">
                                    {{ $blog->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="content-area p-4">
                                <div class="meta-tags mb-3 d-flex align-items-center text-muted" style="font-size: 14px;">
                                    <span class="mr-3"><i class="fa-regular fa-user mr-1 text-primary"></i>
                                        {{ $blog->author ?? 'Admin' }}</span>
                                </div>
                                <h4 class="mb-3">
                                    <a href="{{ route('blog.show', $blog) }}"
                                        style="color: #1a1a1a; text-decoration: none; font-weight: 700; transition: color 0.3s;">{{ $blog->title }}</a>
                                </h4>
                                <p class="mb-4 text-muted">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                                <div class="btn-area">
                                    <a href="{{ route('blog.show', $blog) }}" class="read-more-btn"
                                        style="color: #ff931e; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                                        Read More <i class="fa-solid fa-arrow-right ml-2" style="margin-left: 8px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-blog fa-3x text-muted opacity-50"></i>
                            </div>
                            <h3 class="mb-3 text-muted">No Blogs Available</h3>
                            <p class="text-muted">Stay tuned! We are crafting amazing content for you.</p>
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

    <style>
        .blog-boxarea:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .blog-boxarea:hover h4 a {
            color: #ff931e !important;
        }
    </style>
@endsection