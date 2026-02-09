@extends('layouts.modern')

@section('title', $blog->title . ' | PropertyFinda Insights')

@section('content')
    <!-- Premium Blog Article Hero -->
    <!-- Blog Article Hero -->
    <section class="relative min-h-[60vh] flex items-center pt-5 pb-20 overflow-hidden bg-primary">
        <!-- Background Image with Stronger Overlay -->
        <div class="absolute inset-0 z-0">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="w-full h-full object-cover opacity-10"
                    alt="{{ $blog->title }}">
            @else
                <img src="{{ asset('assets/img/all-images/hero/1.jpg') }}" class="w-full h-full object-cover opacity-10"
                    alt="Background">
            @endif
            <!-- High Contrast Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/90 to-primary/80"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                <!-- Breadcrumb & Badge -->
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    <span
                        class="px-4 py-2 bg-secondary/20 border border-secondary/30 rounded-xl text-secondary text-xs font-bold uppercase tracking-widest">
                        Insights
                    </span>
                    <span class="text-gray-400 text-sm font-medium">{{ $blog->created_at->format('d M Y') }}</span>
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-10 leading-tight">
                    {{ $blog->title }}
                </h1>

                <!-- Author & Meta in White -->
                <div class="flex flex-wrap items-center gap-8 md:gap-12 pb-8 border-b border-white/10">
                    <!-- Author -->
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center text-lg shadow-lg">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Written By</p>
                            <p class="text-base font-bold text-white">{{ $blog->author ?? 'Editorial Team' }}</p>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-white/10 text-white flex items-center justify-center text-lg border border-white/10">
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Published</p>
                            <p class="text-base font-bold text-white">{{ $blog->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Read Time -->
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-white/10 text-white flex items-center justify-center text-lg border border-white/10">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Read Time</p>
                            <p class="text-base font-bold text-white">7 Min Read</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="bg-gray-50 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid Container -->
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-16">

                <!-- Main Content Column (Left) -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100 mb-8">
                        <!-- Content Body -->
                        <article class="prose prose-lg max-w-none 
                                                            prose-headings:text-primary prose-headings:font-bold prose-headings:tracking-tight
                                                            prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-6
                                                            prose-li:text-gray-600
                                                            prose-strong:text-primary prose-strong:font-bold
                                                            prose-blockquote:border-l-4 prose-blockquote:border-secondary prose-blockquote:bg-gray-50 prose-blockquote:px-6 prose-blockquote:py-4 prose-blockquote:rounded-r-lg prose-blockquote:italic prose-blockquote:text-primary prose-blockquote:font-medium
                                                            prose-img:rounded-xl prose-img:shadow-md prose-img:my-10">
                            {!! $blog->content !!}
                        </article>

                        <!-- Share Section -->
                        <div class="mt-12 pt-8 border-t border-gray-100">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                                <h4 class="text-sm font-bold text-primary uppercase tracking-widest">Share this insight:
                                </h4>
                                <div class="flex gap-3">
                                    @foreach(['facebook-f', 'twitter', 'linkedin-in', 'whatsapp'] as $icon)
                                        <button
                                            class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all duration-300">
                                            <i class="fa-brands fa-{{ $icon }}"></i>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Author Box -->
                    <div
                        class="bg-primary rounded-2xl p-8 text-white flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                        <div
                            class="w-16 h-16 rounded-xl bg-white/10 flex items-center justify-center shrink-0 text-2xl text-secondary">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="text-lg font-bold mb-2">{{ $blog->author ?? 'Editorial Team' }}</h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">Expert analysis and reporting on the UK
                                property market. Helping you make informed decisions with data-driven insights.</p>
                            <div class="flex justify-center sm:justify-start gap-4">
                                <a href="#" class="text-white/60 hover:text-white transition-colors"><i
                                        class="fa-brands fa-twitter"></i></a>
                                <a href="#" class="text-white/60 hover:text-white transition-colors"><i
                                        class="fa-brands fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column (Right) -->
                <div class="lg:w-1/3 space-y-8">

                    <!-- Search Widget -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="text-base font-bold text-primary mb-4">Search Insights</h3>
                        <form action="#" class="relative w-full">
                            <input type="text" placeholder="Keywords..."
                                class="w-full pl-5 pr-14 py-3 bg-gray-50 border border-gray-100 rounded-lg focus:bg-white focus:border-secondary outline-none transition-all font-bold text-sm text-primary">
                            <button type="button"
                                class="bg-secondary rounded-md flex items-center justify-center text-white shadow-md hover:bg-secondary-dark transition-colors"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); width: 32px; height: 32px;">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Recommended Feed -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="text-base font-bold text-primary mb-5 flex items-center gap-3">
                            <span class="w-1 h-4 bg-secondary rounded-full"></span> Latest News
                        </h3>

                        <div class="space-y-5">
                            @php
                                $briefs = \App\Models\Blog::where('id', '!=', $blog->id)->latest()->take(4)->get();
                            @endphp
                            @foreach($briefs as $brief)
                                <a href="{{ route('blog.show', $brief) }}" class="flex gap-4 group">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                        <img src="{{ $brief->image ? asset('storage/' . $brief->image) : asset('assets/img/all-images/hero/1.jpg') }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h4
                                            class="text-primary font-bold text-sm leading-snug group-hover:text-secondary transition-colors line-clamp-2 mb-1">
                                            {{ $brief->title }}
                                        </h4>
                                        <span
                                            class="text-xs font-semibold text-gray-400">{{ $brief->created_at->format('M d, Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter Component -->
                    <div class="bg-primary rounded-2xl p-6 text-white relative overflow-hidden">
                        <!-- Decorative Circle -->
                        <div class="absolute -top-10 -right-10 w-24 h-24 bg-secondary/20 rounded-full blur-2xl"></div>

                        <div class="relative z-10">
                            <div
                                class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-secondary text-lg mb-4 border border-white/10">
                                <i class="fa-solid fa-paper-plane"></i>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Weekly Intelligence</h3>
                            <p class="text-gray-400 text-xs font-medium mb-4 leading-relaxed">
                                Join 15,000+ professionals getting the latest data.
                            </p>
                            <form class="space-y-3">
                                <div class="relative">
                                    <input type="email" placeholder="Email address"
                                        class="w-full pl-5 pr-12 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:bg-white/10 focus:border-secondary outline-none font-bold text-xs transition-all">
                                    <i
                                        class="fa-regular fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                </div>
                                <button
                                    class="w-full py-3 bg-secondary text-white font-bold text-xs uppercase tracking-widest rounded-lg hover:bg-secondary-dark transition-all shadow-lg">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection