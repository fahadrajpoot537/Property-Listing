@if($blogs->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($blogs as $blog)
            <article
                class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full hover:-translate-y-1">

                <!-- Image -->
                <div class="relative h-56 overflow-hidden bg-gray-200">
                    <a href="{{ route('blog.show', $blog) }}" class="block w-full h-full">
                        <img src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('assets/img/all-images/hero/1.jpg') }}"
                            alt="{{ $blog->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div
                        class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold text-slate-700">
                        {{ $blog->created_at->format('d M, Y') }}
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 md:p-8 flex flex-col flex-grow">
                    <div class="flex items-center gap-3 mb-4 text-xs font-semibold tracking-wide text-secondary uppercase">
                        <span class="flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            Market Insight
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-800 mb-3 leading-snug group-hover:text-primary transition-colors">
                        <a href="{{ route('blog.show', $blog) }}">
                            {{ $blog->title }}
                        </a>
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-6 flex-grow">
                        {{ Str::limit(strip_tags($blog->content), 120) }}
                    </p>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between mt-auto">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-xs">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-600">
                                {{ $blog->author ?? 'Admin' }}
                            </span>
                        </div>

                        <a href="{{ route('blog.show', $blog) }}"
                            class="text-primary text-sm font-semibold group-hover:translate-x-1 transition-transform inline-flex items-center gap-1"
                            style="color: #8046F1;">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $blogs->links() }}
    </div>
@else
    <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-slate-200">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-regular fa-folder-open text-2xl text-slate-400"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">No Articles Found</h3>
        <p class="text-slate-500">We couldn't find any articles matching your search.</p>
    </div>
@endif