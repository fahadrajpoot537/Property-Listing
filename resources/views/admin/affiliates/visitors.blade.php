@extends('layouts.admin')

@section('header', 'Partner Network Analytics')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.affiliates.index') }}"
            class="inline-flex items-center gap-2 text-slate-400 hover:text-indigo-600 font-bold text-sm transition-all mb-4">
            <i class='bx bx-arrow-back'></i> Return to Partners
        </a>
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span
                        class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Network
                        Partner</span>
                    <span class="text-slate-200">|</span>
                    <span class="text-slate-400 font-mono text-xs uppercase">{{ $affiliate->referral_code }}</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800">{{ $affiliate->user->name }} <span
                        class="text-indigo-500">Traffic Source</span></h3>
                <p class="text-slate-500 font-medium">Detailed tracking of all unique and total visitor hits.</p>
            </div>
            <div class="flex items-center gap-10">
                <div class="text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1 group-hover:text-indigo-400 transition-colors">Unique
                        Hits</span>
                    <span
                        class="text-3xl font-black text-slate-800 tracking-tight">{{ $affiliate->visitor_analytics_count }}</span>
                </div>
                <div class="w-px h-12 bg-slate-50"></div>
                <div class="text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1 group-hover:text-emerald-400 transition-colors">Est.
                        Bonus</span>
                    <span
                        class="text-3xl font-black text-emerald-600 tracking-tight">£{{ number_format(($affiliate->visitor_analytics_count / 1000) * 50, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-premium rounded-[2.5rem] border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h4 class="text-lg font-black text-slate-800">Traffic Archive</h4>
            <div class="flex items-center gap-3">
                <span
                    class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-4 py-2 rounded-full">
                    Listing History
                </span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table id="visitorsTable" class="w-full text-left">
                <thead class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50">
                    <tr>
                        <th class="px-10 py-5">Fingerprint / IP</th>
                        <th class="px-10 py-5">Timestamp</th>
                        <th class="px-10 py-5">Geography</th>
                        <th class="px-10 py-5">Device Meta</th>
                        <th class="px-10 py-5">Target URL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($visitors as $visitor)
                        <tr class="hover:bg-slate-50/30 transition-all duration-300 group">
                            <td class="px-10 py-6">
                                <div class="flex flex-col">
                                    <span
                                        class="text-slate-800 font-bold text-sm">{{ substr(md5($visitor->ip_address), 0, 12) }}</span>
                                    <span
                                        class="text-slate-400 font-mono text-[10px] group-hover:text-indigo-500 transition-colors">{{ $visitor->ip_address }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="text-slate-700 font-black text-xs">{{ $visitor->created_at->format('d M, Y') }}
                                </div>
                                <div class="text-slate-400 font-medium text-[10px]">{{ $visitor->created_at->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span
                                    class="inline-flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 text-slate-600 font-bold text-xs">
                                    <i class='bx bx-globe text-slate-300'></i>
                                    {{ $visitor->country ?? 'Global Route' }}
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-all">
                                        <i
                                            class='bx {{ strtolower($visitor->device) == 'mobile' ? 'bx-mobile-alt' : (strtolower($visitor->device) == 'tablet' ? 'bx-tab' : 'bx-laptop') }} text-xl'></i>
                                    </div>
                                    <div>
                                        <div class="text-slate-700 font-black text-xs capitalize">{{ $visitor->device }}</div>
                                        <div class="text-slate-400 text-[10px] font-medium">{{ $visitor->browser }} on
                                            {{ $visitor->platform }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="text-[10px] font-bold text-indigo-500 max-w-[200px] truncate group-hover:text-indigo-700 transition-all font-mono"
                                    title="{{ $visitor->url }}">
                                    {{ parse_url($visitor->url, PHP_URL_PATH) ?: '/' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div
                                    class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200 text-4xl">
                                    <i class='bx bx-user-x'></i>
                                </div>
                                <h4 class="text-xl font-black text-slate-300 uppercase tracking-widest">No Traffic Detected</h4>
                                <p class="text-slate-400 font-medium">This partner hasn't referred any visitors yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-10 py-6 bg-slate-50/50">
            {{ $visitors->links() }}
        </div>
    </div>
@endsection