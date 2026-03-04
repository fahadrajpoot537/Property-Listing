@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg shadow-sm">
                <i class='bx bxs-zap'></i>
            </div>
            <h3 class="font-black text-slate-800 text-xs tracking-[0.2em] uppercase">Quick Launch</h3>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @can('listing.create')
                <a href="{{ route('admin.listings.create') }}"
                    class="group bg-white p-3 rounded-xl border border-slate-100 hover:border-indigo-500/30 transition-all flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class='bx bx-plus'></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-slate-800 text-[11px] uppercase tracking-tighter leading-tight mt-0.5">
                            Add Listing</h4>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Public</p>
                    </div>
                </a>
            @endcan

            @can('off-market.create')
                <a href="{{ route('admin.off-market-listings.create') }}"
                    class="group bg-white p-3 rounded-xl border border-slate-100 hover:border-purple-500/30 transition-all flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class='bx bx-lock-alt'></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-slate-800 text-[11px] uppercase tracking-tighter leading-tight mt-0.5">
                            Add Off-Market</h4>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Private</p>
                    </div>
                </a>
            @endcan

            @if(auth()->user()->hasAnyRole(['admin', 'Agency']))
                <a href="{{ route('admin.users.index') }}"
                    class="group bg-white p-3 rounded-xl border border-slate-100 hover:border-emerald-500/30 transition-all flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class='bx bx-user'></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-slate-800 text-[11px] uppercase tracking-tighter leading-tight mt-0.5">
                            Users</h4>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Access</p>
                    </div>
                </a>
            @endif

            <a href="{{ route('admin.walkthrough.index') }}"
                class="group bg-white p-3 rounded-xl border border-slate-100 hover:border-amber-500/30 transition-all flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class='bx bx-play-circle'></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-black text-slate-800 text-[11px] uppercase tracking-tighter leading-tight mt-0.5">
                        Tours</h4>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Requests</p>
                </div>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @if(auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
            <!-- Stat Card 1 -->
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
                <div
                    class="w-10 h-10 bg-purple-50 text-[#8046F1] rounded-lg flex items-center justify-center text-lg mb-4 transition-transform group-hover:scale-105">
                    <i class='bx bx-user'></i>
                </div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Users</div>
                <div class="text-xl font-black text-slate-900 tracking-tight">{{ number_format($data['usersCount']) }}</div>
            </div>
        @endif

        <!-- Stat Card 2 -->
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-blue-50 text-[#02b8f2] rounded-lg flex items-center justify-center text-lg mb-4 transition-transform group-hover:scale-105">
                <i class='bx bx-building-house'></i>
            </div>
            <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Active Assets</div>
            <div class="text-xl font-black text-slate-900 tracking-tight">{{ number_format($data['listingsCount']) }}</div>
        </div>

        <!-- Stat Card 3 -->
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-slate-900 text-white rounded-lg flex items-center justify-center text-lg mb-4 transition-transform group-hover:scale-105">
                <i class='bx bx-lock-alt'></i>
            </div>
            <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Private Deals</div>
            <div class="text-xl font-black text-slate-900 tracking-tight">
                {{ number_format($data['offMarketListingsCount']) }}
            </div>
        </div>

        <!-- Stat Card 4 -->
        <a href="{{ route('admin.walkthrough.index') }}"
            class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col items-start relative overflow-hidden group hover:border-amber-500/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center text-lg mb-4 transition-transform group-hover:scale-105">
                <i class='bx bx-play-circle'></i>
            </div>
            <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Queue Tours</div>
            <div class="text-xl font-black text-slate-900 tracking-tight">{{ number_format($data['walkthroughCount']) }}
            </div>
            @if($data['walkthroughCount'] > 0)
                <div class="absolute top-4 right-4 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </div>
            @endif
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        @if(auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
            <!-- Recent Users -->
            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
                <div class="px-5 py-3 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-xs tracking-widest uppercase">Latest Members</h3>
                    <a href="{{ route('admin.users.index') }}"
                        class="w-6 h-6 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors"><i
                            class='bx bx-right-arrow-alt'></i></a>
                </div>
                <div class="divide-y divide-slate-50 overflow-y-auto max-h-[300px]">
                    @foreach($data['recentUsers'] as $user)
                        <div class="px-5 py-3 flex items-center hover:bg-slate-50 transition-all group">
                            <div
                                class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs transition-transform group-hover:scale-105">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="ml-3 overflow-hidden">
                                <div
                                    class="font-bold text-slate-900 text-[13px] truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $user->name }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-bold tracking-tighter truncate">{{ $user->email }}</div>
                            </div>
                            <div class="ml-auto text-[9px] font-black text-slate-300 uppercase italic">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Listings -->
        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-xs tracking-widest uppercase">Asset Monitor</h3>
                <a href="{{ route('admin.listings.index') }}"
                    class="w-6 h-6 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors"><i
                        class='bx bx-right-arrow-alt'></i></a>
            </div>
            <div class="divide-y divide-slate-50 overflow-y-auto max-h-[300px]">
                @foreach($data['recentListings'] as $listing)
                    <div class="px-5 py-3 flex items-center hover:bg-slate-50 transition-all group text-xs">
                        <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : asset('img/placeholder.jpg') }}"
                            class="w-10 h-10 rounded-lg object-cover shadow-sm group-hover:scale-105 transition-transform">
                        <div class="flex-1 min-w-0 ml-3 overflow-hidden">
                            <div class="font-bold text-slate-900 truncate group-hover:text-indigo-600 transition-colors">
                                {{ $listing->property_title }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase truncate">
                                {{ $listing->property_type->title ?? 'Asset' }} • <span
                                    class="text-indigo-600">{{ $listing->status }}</span>
                            </div>
                        </div>
                        <div class="ml-3 font-black text-slate-900 tracking-tight">
                            £{{ number_format($listing->price) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Analytics Graphs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 p-6 shadow-sm h-[350px]">
            <h3 class="font-black text-slate-800 text-xs tracking-[0.2em] uppercase mb-6 italic">Growth Analytics</h3>
            <div class="h-[250px] relative">
                <canvas id="marketChart"></canvas>
            </div>
        </div>
        <div class="bg-[#131B31] rounded-xl p-6 shadow-lg relative overflow-hidden group h-[350px]">
            <div class="absolute inset-0 bg-gradient-to-br from-[#8046F1]/10 to-transparent"></div>
            <h3 class="font-black text-white text-[10px] tracking-widest uppercase mb-6 relative z-10">Asset Split</h3>
            <div class="h-[180px] relative z-10">
                <canvas id="assetChart"></canvas>
            </div>
            <div class="mt-6 space-y-3 relative z-10">
                <div class="flex justify-between items-center text-[9px] font-black uppercase text-white/40">
                    <span>Performance</span>
                    <span class="text-emerald-400">+12%</span>
                </div>
                <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                    <div class="w-[75%] h-full bg-[#8046F1]"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const marketCtx = document.getElementById('marketChart').getContext('2d');
            new Chart(marketCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Asset Listings',
                        data: [120, 150, 180, 220, 210, 250, 290, 310, 280, 320, 350, 400],
                        borderColor: '#131B31',
                        backgroundColor: 'rgba(19, 27, 49, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }, {
                        label: 'Premium Deals',
                        data: [40, 60, 55, 80, 95, 110, 130, 120, 150, 170, 190, 210],
                        borderColor: '#8046F1',
                        backgroundColor: 'rgba(128, 70, 241, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } },
                        x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                    }
                }
            });

            const assetCtx = document.getElementById('assetChart').getContext('2d');
            new Chart(assetCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Commercial', 'Residential', 'Off-Market', 'Off-Plan'],
                    datasets: [{
                        data: [35, 45, 15, 5],
                        backgroundColor: ['#131B31', '#ffffff', '#8046F1', 'rgba(255,255,255,0.1)'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: { legend: { position: 'bottom', labels: { color: '#fff', font: { weight: 'bold', size: 10 } } } }
                }
            });
        </script>
    @endpush
@endsection