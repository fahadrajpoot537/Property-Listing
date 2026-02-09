@extends('layouts.modern')

@section('title', 'Latest News & Insights | PropertyFinda')

@section('content')
    <!-- Header Section -->
    <div class="relative bg-slate-900 py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-primary/90 opacity-95"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-secondary/10 text-secondary text-xs font-bold tracking-widest uppercase mb-4 border border-secondary/20">
                PropertyFinda Blog
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-4">
                Latest News & Insights
            </h1>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Expert analysis, market trends, and guides to help you make informed property decisions.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <section class="py-16 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Search & Filter Bar -->
            <div
                class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-12 gap-4">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-500 pl-2">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
                    <span class="text-primary">Blog</span>
                </div>

                <div class="relative w-full md:w-80">
                    <input type="text" id="blog-search-input" placeholder="Search articles..."
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                </div>
            </div>

            <!-- Blog Grid Container -->
            <div id="blog-grid-container">
                @include('partials.blog_list')
            </div>

        </div>
    </section>

    <!-- Simple Newsletter -->
    <section class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">Subscribe to our newsletter</h2>
            <p class="text-slate-500 mb-8 max-w-xl mx-auto">Get the latest property market updates and exclusive insights
                delivered straight to your inbox.</p>

            <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                <input type="email" placeholder="Enter your email address"
                    class="flex-1 px-5 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm">
                <button
                    class="px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-slate-800 transition-colors shadow-lg shadow-primary/20"
                    style="background-color: #8046F1;">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('blog-search-input');
            const gridContainer = document.getElementById('blog-grid-container');
            let currentController = null;
            let debounceTimer;

            searchInput.addEventListener('input', function (e) {
                const query = e.target.value;

                // Clear previous timer
                clearTimeout(debounceTimer);

                // Debounce
                debounceTimer = setTimeout(() => {
                    // Abort previous request if running
                    if (currentController) currentController.abort();
                    currentController = new AbortController();

                    // Fetch
                    const url = new URL("{{ route('blog.list') }}");
                    if (query) url.searchParams.set('search', query);

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: currentController.signal
                    })
                        .then(response => response.text())
                        .then(html => {
                            gridContainer.innerHTML = html;
                        })
                        .catch(err => {
                            if (err.name !== 'AbortError') console.error(err);
                        });

                }, 300); // 300ms delay for "Live" feel
            });

            // Handle pagination clicks via AJAX
            gridContainer.addEventListener('click', function (e) {
                const link = e.target.closest('.pagination a');
                if (link) {
                    e.preventDefault();

                    fetch(link.href, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(response => response.text())
                        .then(html => {
                            gridContainer.innerHTML = html;
                            window.scrollTo({ top: gridContainer.offsetTop - 100, behavior: 'smooth' });
                        });
                }
            });
        });
    </script>
@endpush