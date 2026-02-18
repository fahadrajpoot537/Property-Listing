@extends('layouts.admin')

@section('header')
    <div class="flex items-center">
        <i class='bx bxs-star text-emerald-500 text-xl mr-2'></i>
        <span class="font-bold text-slate-700">Trustpilot Integration</span>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Settings Card -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Widget Configuration</h3>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ ($review->is_active ?? true) ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ ($review->is_active ?? true) ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="p-6">
                        @if (session('success'))
                            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl flex items-center shadow-sm">
                                <i class='bx bxs-check-circle mr-2 text-xl'></i>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('admin.trustpilot-reviews.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Rating Input -->
                                <div>
                                    <label for="rating" class="block text-sm font-bold text-slate-700 mb-2">Review Score</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bxs-star text-amber-400'></i>
                                        </div>
                                        <input type="text" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-[#00b67a] focus:ring focus:ring-[#00b67a]/20 font-bold text-slate-700 transition-all placeholder:font-normal" 
                                            id="rating" name="rating"
                                            value="{{ old('rating', $review->rating ?? '') }}" 
                                            placeholder="e.g. 4.8">
                                    </div>
                                    @error('rating')
                                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-slate-400 mt-2 ml-1">The numerical rating (0-5)</p>
                                </div>

                                <!-- Count Input -->
                                <div>
                                    <label for="review_count" class="block text-sm font-bold text-slate-700 mb-2">Total Reviews</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bxs-group text-slate-400'></i>
                                        </div>
                                        <input type="text" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-[#00b67a] focus:ring focus:ring-[#00b67a]/20 font-bold text-slate-700 transition-all placeholder:font-normal" 
                                            id="review_count" name="review_count"
                                            value="{{ old('review_count', $review->review_count ?? '') }}" 
                                            placeholder="e.g. 1,245">
                                    </div>
                                    @error('review_count')
                                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-slate-400 mt-2 ml-1">Displayed count (e.g. "1,245")</p>
                                </div>
                            </div>

                            <!-- Visibility Toggle -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-8 flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-700 text-sm">Frontend Visibility</h4>
                                    <p class="text-xs text-slate-500 mt-1">Show this widget on the homepage hero section</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $review->is_active ?? true) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#00b67a]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00b67a]"></div>
                                </label>
                            </div>

                            <button type="submit" class="w-full bg-[#00b67a] hover:bg-[#009e6a] text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-[#00b67a]/30 flex items-center justify-center gap-2">
                                <i class='bx bxs-save'></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="w-full md:w-80">
                <div class="bg-gradient-to-br from-[#131B31] to-[#1e2a4a] rounded-2xl shadow-premium border border-slate-800 p-6 text-center relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'0 0 2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                    <h4 class="text-white/50 text-xs font-bold uppercase tracking-widest mb-6 relative z-10">Live Preview</h4>

                    <div class="relative z-10">
                        <div class="flex flex-col items-center justify-center gap-3 bg-white/10 backdrop-blur-md py-4 px-5 rounded-2xl border border-white/20 shadow-lg">
                            <div class="flex items-center gap-2 mb-1">
                                <i class='bx bxs-star text-[#00b67a] text-2xl'></i>
                                <span class="text-white font-bold text-lg tracking-wide">Trustpilot</span>
                            </div>

                            <div class="flex items-center gap-1 mb-1">
                                @for($i = 0; $i < 5; $i++)
                                    <div class="w-7 h-7 bg-[#00b67a] flex items-center justify-center rounded-sm">
                                        <i class='bx bxs-star text-white text-xs'></i>
                                    </div>
                                @endfor
                            </div>

                            <div class="text-white text-sm mt-1">
                                <span class="font-black text-xl">{{ $review->rating ?? '4.8' }}</span> 
                                <span class="text-white/40 mx-2">|</span> 
                                <span class="font-medium opacity-90">{{ $review->review_count ?? '1,245' }} Reviews</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-white/40 text-xs mt-6 relative z-10">This is how the widget appears on the dark hero background.</p>
                </div>
            </div>
        </div>
    </div>
@endsection