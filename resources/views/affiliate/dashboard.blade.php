@extends('layouts.modern')

@section('title', 'Partner Dashboard - PropertyFinda')

@section('content')
    <div class="pt-32 pb-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span
                            class="bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Partner
                            Status: {{ strtoupper($affiliate->status) }}</span>
                        <span class="text-gray-300">/</span>
                        <span class="text-gray-400 font-bold text-xs uppercase tracking-widest">ID:
                            {{ $affiliate->referral_code }}</span>
                    </div>
                    <h1 class="text-4xl font-black text-primary">Partner <span class="text-secondary">Dashboard</span></h1>
                    <p class="text-gray-500 font-bold mt-1">Monitor your traffic and track your unique referrals.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}"
                        class="px-6 py-3 bg-white text-primary font-bold rounded-2xl border border-gray-100 shadow-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-house"></i> View Site
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Total Visitors -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-3">Total Traffic Hits
                        </div>
                        <div class="text-5xl font-black text-primary mb-2 tracking-tight">
                            {{ number_format($stats['total_visitors']) }}
                        </div>
                        <p class="text-gray-400 text-sm font-medium">Total clicks on your link</p>
                    </div>
                    <div
                        class="absolute -bottom-6 -right-6 text-gray-50 text-7xl transform group-hover:-translate-y-2 transition-transform duration-500">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>

                <!-- Unique Visitors -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="text-blue-500 text-[10px] font-black uppercase tracking-[0.2em] mb-3">Unique Visitors
                            (Verified)</div>
                        <div class="text-5xl font-black text-blue-600 mb-2 tracking-tight">
                            {{ number_format($stats['unique_visitors']) }}
                        </div>
                        <p class="text-gray-400 text-sm font-medium">Distinct IPs that visited listings</p>
                    </div>
                    <div
                        class="absolute -bottom-6 -right-6 text-blue-50 text-7xl transform group-hover:-translate-y-2 transition-transform duration-500">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>

                <!-- Estimated Earnings -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em] mb-3">Estimated
                            Earnings</div>
                        <div class="text-5xl font-black text-emerald-600 mb-2 tracking-tight">
                            £{{ $stats['total_earnings'] }}</div>
                        <p class="text-gray-400 text-sm font-medium">Based on £{{ $stats['rate'] }} per
                            {{ number_format($stats['batch_size']) }} unique
                        </p>
                    </div>
                    <div
                        class="absolute -bottom-6 -right-6 text-emerald-50 text-7xl transform group-hover:-translate-y-2 transition-transform duration-500">
                        <i class="fa-solid fa-pound-sign"></i>
                    </div>
                </div>
            </div>

            <!-- Referral Link Box -->
            <div class="bg-primary rounded-[3rem] p-10 mb-12 shadow-2xl relative overflow-hidden">
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                    <div class="text-white max-w-xl text-center lg:text-left">
                        <h2 class="text-3xl font-black mb-3">Secure Your Referral Link</h2>
                        <p class="text-blue-100/60 text-lg font-medium leading-relaxed">
                            Share this unique link within your circle or network. Every unique person you bring helps us
                            grow, and we reward you for it.
                        </p>
                    </div>
                    <div class="w-full lg:w-auto">
                        <div class="bg-white rounded-3xl p-2 md:p-4 flex flex-col sm:flex-row items-center gap-4">
                            <input type="text" value="{{ $stats['referral_link'] }}" id="referralLink" readonly
                                class="bg-transparent border-none text-black font-black text-xl px-4 py-2 w-full sm:w-[400px] outline-none">
                            <button onclick="copyLink()"
                                class="w-full sm:w-auto bg-secondary text-white px-10 py-5 rounded-2xl font-black hover:bg-secondary/90 shadow-xl shadow-secondary/20 transition-all flex items-center justify-center gap-3">
                                <i class="fa-solid fa-copy"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Decoration -->
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-secondary/10 rounded-full blur-[100px]"></div>
                <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px]"></div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-10 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-primary">Real-time Activity</h3>
                        <p class="text-gray-400 font-bold text-sm">Most recent unique hits tracked to your account.</p>
                    </div>
                    <div
                        class="flex items-center gap-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-ping"></span> Live Tracking
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Time
                                    Tracking</th>
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Device
                                    Identity</th>
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    Location Hint</th>
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    Browser Agent</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentVisitors as $visitor)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-10 py-6">
                                        <div class="text-primary font-black text-sm">{{ $visitor->created_at->format('H:i:s') }}
                                        </div>
                                        <div class="text-gray-400 text-xs font-bold">
                                            {{ $visitor->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500">
                                                <i
                                                    class="fa-solid fa-{{ strtolower($visitor->device) == 'mobile' ? 'mobile-screen' : (strtolower($visitor->device) == 'tablet' ? 'tablet-screen' : 'desktop') }}"></i>
                                            </div>
                                            <div>
                                                <div class="text-primary font-black text-sm capitalize">{{ $visitor->device }}
                                                </div>
                                                <div class="text-gray-400 text-xs font-medium">{{ $visitor->platform }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <span
                                            class="inline-flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 text-gray-600 font-bold text-xs">
                                            <i class="fa-solid fa-globe text-gray-300"></i>
                                            {{ $visitor->country ?? 'Global' }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-6 text-gray-500 font-bold text-sm">
                                        {{ $visitor->browser }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-32 text-center">
                                        <div
                                            class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200 text-4xl">
                                            <i class="fa-solid fa-user-ninja"></i>
                                        </div>
                                        <h4 class="text-xl font-black text-gray-300">No visitors tracked yet</h4>
                                        <p class="text-gray-400 font-medium">Your circle hasn't started clicking yet!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyLink() {
            var copyText = document.getElementById("referralLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            Swal.fire({
                title: '<span style="color:white;font-weight:900">Success!</span>',
                html: '<span style="color:#94a3b8;font-weight:bold">Referral link copied to clipboard.</span>',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                background: '#131B31',
                iconColor: '#ff9d00',
                padding: '3em'
            });
        }
    </script>
@endsection