@extends('layouts.admin')

@section('header', 'Enquiries')

@section('content')
    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
        <div class="px-5 py-3 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <div>
                <h3 class="font-black text-black text-lg tracking-tight uppercase">Manage Enquiries</h3>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="p-5 border-b border-slate-50 bg-white">
            <form action="{{ route('admin.walkthrough.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-3">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Search
                        Requester</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email or phone..."
                            class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-200 bg-slate-50 text-[11px] focus:bg-white focus:border-indigo-400 outline-none transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class='bx bx-search text-base'></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                    <select name="status"
                        class="w-full rounded-lg border-slate-200 bg-slate-50 text-[11px] py-2 px-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Property Type</label>
                    <select name="listing_type"
                        class="w-full rounded-lg border-slate-200 bg-slate-50 text-[11px] py-2 px-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                        <option value="">All Properties</option>
                        <option value="public" {{ request('listing_type') === 'public' ? 'selected' : '' }}>Public Listings</option>
                        <option value="off_market" {{ request('listing_type') === 'off_market' ? 'selected' : '' }}>Off-Market Deals</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2 px-4 rounded-lg shadow-sm transition-all text-[10px] uppercase tracking-widest flex-1">
                        Filter
                    </button>
                    <a href="{{ route('admin.walkthrough.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-black py-2 px-4 rounded-lg transition-all text-[10px] uppercase tracking-widest flex-1 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[13px]" id="walkthrough-table">
                    <thead>
                        <tr
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            <th class="py-3 pl-5 uppercase">Date</th>
                            <th class="py-3 uppercase">Property</th>
                            <th class="py-3 uppercase">Requester</th>
                            <th class="py-3 uppercase">Preferred Time</th>
                            <th class="py-3 uppercase">Contact Info</th>
                            <th class="py-3 text-center uppercase">Status</th>
                            <th class="py-3 text-right pr-5 uppercase">Manage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($inquiries as $inquiry)
                            @php 
                                $property = $inquiry->listing ?? $inquiry->offMarketListing;
                                $isOffMarket = (bool)$inquiry->off_market_listing_id;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-all border-b border-slate-50 last:border-0">
                                <td class="py-3 pl-5">
                                    <span class="font-bold text-slate-800">{{ $inquiry->created_at->format('d M') }}</span>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $inquiry->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        @if($property && $property->thumbnail)
                                            <img src="{{ asset('storage/' . $property->thumbnail) }}"
                                                class="w-8 h-8 rounded border border-slate-100 object-cover">
                                        @endif
                                        <div class="max-w-[150px]">
                                            <p class="font-bold text-slate-800 truncate text-[11px] uppercase tracking-tight" title="{{ $property->property_title }}">
                                                {{ $property->property_title }}
                                            </p>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-[9px] text-slate-400 font-bold">#{{ $property->property_reference_number ?? $property->id }}</span>
                                                @if($isOffMarket)
                                                    <span class="text-[8px] font-black text-rose-500 uppercase">OFF</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5">
                                    <p class="text-sm font-black text-black">{{ $inquiry->name }}</p>
                                    @if($inquiry->sender_id)
                                        <span
                                            class="text-[9px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-black uppercase mb-1 inline-block">Registered
                                            User</span>
                                    @endif
                                    @if($inquiry->message)
                                        <p class="text-xs text-slate-500 italic max-w-[200px] truncate" title="{{ $inquiry->message }}">
                                            "{{ Str::limit($inquiry->message, 50) }}"
                                        </p>
                                    @endif
                                </td>
                                <td class="py-5">
                                    @if($inquiry->preferred_time)
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <i class='bx bx-time-five text-secondary'></i>
                                            <span class="text-sm font-bold">{{ $inquiry->preferred_time }}</span>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-400 font-black uppercase italic">Any Time</span>
                                    @endif
                                </td>
                                <td class="py-5">
                                    <p class="text-xs font-bold text-slate-600 flex items-center gap-2">
                                        <i class='bx bx-envelope text-slate-400'></i> {{ $inquiry->email }}
                                    </p>
                                    <p class="text-xs font-bold text-slate-600 flex items-center gap-2 mt-1">
                                        <i class='bx bx-phone text-slate-400'></i> {{ $inquiry->phone }}
                                    </p>
                                </td>
                                <td class="py-5 text-center">
                                    <form action="{{ route('admin.walkthrough.update-status', $inquiry->id) }}" method="POST"
                                        class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border-none focus:ring-0 cursor-pointer
                                                        {{ $inquiry->status === 'pending' ? 'bg-amber-100 text-amber-600' : ($inquiry->status === 'completed' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600') }}">
                                            <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="completed" {{ $inquiry->status === 'completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option value="cancelled" {{ $inquiry->status === 'cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-3 text-right pr-5">
                                    <div class="flex justify-end gap-1.5">
                                        <a href="mailto:{{ $inquiry->email }}"
                                            class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-[#8046F1] transition-all">
                                            <i class='bx bx-envelope text-base'></i>
                                        </a>
                                        <a href="tel:{{ $inquiry->phone }}"
                                            class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-all">
                                            <i class='bx bx-phone text-base'></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $inquiries->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection