@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @if(auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
        <!-- Stat Card 1 -->
        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-purple-50 text-[#8046F1] rounded-xl flex items-center justify-center text-xl mb-4 group-hover:rotate-6 transition-transform">
                <i class='bx bxs-user'></i>
            </div>
            <div class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mb-1">Total Users</div>
            <div class="text-2xl font-black text-black tracking-tighter">{{ number_format($data['usersCount']) }}</div>
        </div>
        @endif

        <!-- Stat Card 2 -->
        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-purple-50 text-[#8046F1] rounded-xl flex items-center justify-center text-xl mb-4 group-hover:rotate-6 transition-transform">
                <i class='bx bxs-city'></i>
            </div>
            <div class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mb-1">Public Listings</div>
            <div class="text-2xl font-black text-black tracking-tighter">{{ number_format($data['listingsCount']) }}</div>
        </div>

        <!-- Stat Card 3 -->
        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-purple-50 text-[#8046F1] rounded-xl flex items-center justify-center text-xl mb-4 group-hover:rotate-6 transition-transform">
                <i class='bx bxs-bolt-circle'></i>
            </div>
            <div class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mb-1">Distress Deals</div>
            <div class="text-2xl font-black text-black tracking-tighter">
                {{ number_format($data['offMarketListingsCount']) }}</div>
        </div>

        <!-- Stat Card 4 -->
        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col items-start relative overflow-hidden group hover:border-[#8046F1]/20 transition-all duration-300">
            <div
                class="w-10 h-10 bg-purple-50 text-[#8046F1] rounded-xl flex items-center justify-center text-xl mb-4 group-hover:rotate-6 transition-transform">
                <i class='bx bxs-zap'></i>
            </div>
            <div class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mb-1">Unique Hits</div>
            <div class="text-2xl font-black text-black tracking-tighter">{{ number_format($data['uniqueVisitors']) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        @if(auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
        <!-- Recent Users -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-black text-sm tracking-tight">Recent Onboardings</h3>
                <a href="{{ route('admin.users.index') }}"
                    class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#8046F1] transition-colors"><i
                        class='bx bx-right-arrow-alt text-xl'></i></a>
            </div>
            <div class="divide-y divide-slate-50 overflow-y-auto max-h-[350px]">
                @foreach($data['recentUsers'] as $user)
                    <div class="px-6 py-4 flex items-center hover:bg-slate-50/50 transition-all group">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#02b8f2]/10 flex items-center justify-center text-[#02b8f2] font-black text-sm group-hover:scale-105 transition-transform">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="ml-4 overflow-hidden">
                            <div class="font-bold text-black text-sm truncate group-hover:text-[#8046F1] transition-colors">
                                {{ $user->name }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase truncate">{{ $user->email }}</div>
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
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-black text-sm tracking-tight">Live Asset Stream</h3>
                <a href="{{ route('admin.listings.index') }}"
                    class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#8046F1] transition-colors"><i
                        class='bx bx-right-arrow-alt text-xl'></i></a>
            </div>
            <div class="divide-y divide-slate-50 overflow-y-auto max-h-[350px]">
                @foreach($data['recentListings'] as $listing)
                    <div class="px-6 py-4 flex items-center hover:bg-slate-50/50 transition-all group">
                        @if($listing->thumbnail)
                            <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                class="w-12 h-12 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform"
                                alt="">
                        @else
                            <div
                                class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-300 group-hover:scale-105 transition-transform">
                                <i class='bx bx-image text-xl'></i>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0 ml-4 overflow-hidden">
                            <div class="font-bold text-black text-sm truncate group-hover:text-[#8046F1] transition-colors">
                                {{ $listing->property_title }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase truncate">
                                {{ $listing->property_type->title ?? 'Asset' }} • <span
                                    class="text-[#8046F1]">{{ $listing->status }}</span></div>
                        </div>
                        <div class="ml-4 font-black text-black text-sm tracking-tighter">
                            £{{ number_format($listing->price) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Analytics Graphs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm h-[400px]">
            <h3 class="font-black text-black text-xl mb-6 italic">Market Penetration Analytics</h3>
            <div class="h-[300px] relative">
                <canvas id="marketChart"></canvas>
            </div>
        </div>
        <div class="bg-black rounded-3xl p-8 shadow-2xl relative overflow-hidden group h-[400px]">
            <div class="absolute inset-0 bg-gradient-to-br from-[#8046F1]/20 to-transparent"></div>
            <h3 class="font-black text-[#8046F1] text-xl mb-6 italic relative z-10">Asset Allocation</h3>
            <div class="h-[200px] relative z-10">
                <canvas id="assetChart"></canvas>
            </div>
            <div class="mt-8 space-y-3 relative z-10">
                <div class="flex justify-between items-center text-[10px] font-black uppercase text-white/50">
                    <span>Performance Rating</span>
                    <span class="text-emerald-400">+12.5%</span>
                </div>
                <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
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
                    labels: ['Commercial', 'Residential', 'Distress', 'Off-Plan'],
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