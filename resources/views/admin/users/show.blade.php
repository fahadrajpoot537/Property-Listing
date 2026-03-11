@extends('layouts.admin')

@section('header', 'User Profile Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumbs & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-bold uppercase tracking-widest">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-slate-400 hover:text-indigo-600 flex items-center gap-1">
                                <i class='bx bxs-dashboard'></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class='bx bx-chevron-right text-slate-300 text-lg'></i>
                                <a href="{{ route('admin.users.index') }}"
                                    class="ml-1 text-slate-400 hover:text-indigo-600 transition-colors">Users</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class='bx bx-chevron-right text-slate-300 text-lg'></i>
                                <span class="ml-1 text-indigo-600 italic">User Profile</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    {{ $user->name }}
                    @php
                        $statusColor = 'bg-slate-100 text-slate-500 border-slate-200';
                        if ($user->status === 'approved' || $user->status === 'document_approved')
                            $statusColor = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                        elseif ($user->status === 'rejected')
                            $statusColor = 'bg-rose-50 text-rose-600 border-rose-100';
                        elseif ($user->status === 'pending')
                            $statusColor = 'bg-amber-50 text-amber-600 border-amber-100';
                    @endphp
                    <span
                        class="{{ $statusColor }} text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full border shadow-sm">
                        {{ str_replace('_', ' ', $user->status ?? 'pending') }}
                    </span>
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="editUser({{ $user->id }})"
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 hover:border-indigo-300 hover:text-indigo-600 transition-all active:scale-95 text-xs uppercase tracking-widest shadow-sm">
                    <i class='bx bxs-edit text-lg'></i>
                    Edit Profile
                </button>
                <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @if($user->status !== 'approved')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition-all active:scale-95 text-xs uppercase tracking-widest shadow-lg shadow-indigo-100">
                            <i class='bx bx-check-circle text-lg'></i>
                            Approve User
                        </button>
                    @else
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-rose-500 text-white font-black rounded-xl hover:bg-rose-600 transition-all active:scale-95 text-xs uppercase tracking-widest shadow-lg shadow-rose-100">
                            <i class='bx bx-x-circle text-lg'></i>
                            Reject User
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Sidebar: Profile Card & Quick Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Main Profile Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-indigo-600 to-purple-700"></div>
                    <div class="px-6 pb-8">
                        <div class="relative flex justify-center mt-[-48px] mb-4">
                            <div class="w-32 h-32 rounded-3xl bg-white p-1.5 shadow-xl">
                                <div
                                    class="w-full h-full rounded-2xl bg-indigo-50 flex items-center justify-center text-4xl font-black text-indigo-600 border-2 border-indigo-100">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-black text-slate-800 tracking-tight">{{ $user->name }}</h2>
                            <p class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-widest">
                                {{ $user->roles->first()->name ?? 'No Role' }}
                            </p>
                        </div>

                        <div class="mt-8 space-y-4">
                            <div
                                class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors group">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-slate-200 group-hover:scale-110 transition-transform">
                                    <i class='bx bx-envelope text-xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Address
                                    </p>
                                    <p class="text-sm font-bold text-slate-700 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors group">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-slate-200 group-hover:scale-110 transition-transform">
                                    <i class='bx bx-phone text-xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phone Number
                                    </p>
                                    <p class="text-sm font-bold text-slate-700 truncate">
                                        {{ $user->phone_number ?? 'Not Provided' }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors group">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-slate-200 group-hover:scale-110 transition-transform">
                                    <i class='bx bx-map text-xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Physical
                                        Address</p>
                                    <p class="text-sm font-bold text-slate-700 truncate"
                                        title="{{ $user->address ?? 'Not Provided' }}">
                                        {{ $user->address ?? 'Not Provided' }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors group">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-slate-200 group-hover:scale-110 transition-transform">
                                    <i class='bx bx-calendar text-xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Joined On</p>
                                    <p class="text-sm font-bold text-slate-700 truncate">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agency Info Card -->
                @if($user->agency)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Affiliated Agency</h3>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                                <i class='bx bxs-business text-2xl'></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $user->agency->name }}</p>
                                <p class="text-xs font-bold text-slate-400 italic">Official Partner</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Content: Account Information & Documents -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Verification Documents Section -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-black text-slate-800 tracking-tight">Verification Documents</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Proof of Identity &
                                Compliance</p>
                        </div>
                        <div
                            class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-slate-200 shadow-sm">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                            <span
                                class="text-[10px] font-black text-slate-600 uppercase tracking-widest">{{ $user->documents->count() }}
                                Files</span>
                        </div>
                    </div>
                    <div class="p-8">
                        @if($user->documents->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->documents as $doc)
                                    <div
                                        class="flex flex-col p-5 bg-white rounded-2xl border border-slate-200 hover:border-indigo-400 transition-all group relative">
                                        <div class="flex items-start justify-between mb-4">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-rose-500 border border-slate-100 group-hover:bg-rose-50 transition-colors">
                                                <i class='bx bxs-file-pdf text-2xl'></i>
                                            </div>
                                            <span
                                                class="text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-lg {{ $doc->status === 'approved' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                                {{ $doc->status }}
                                            </span>
                                        </div>
                                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">
                                            {{ str_replace('_', ' ', $doc->type) }}
                                        </h4>
                                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Uploaded
                                            {{ $doc->created_at->diffForHumans() }}
                                        </p>

                                        <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between">
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                class="text-[11px] font-black text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-1 uppercase tracking-widest">
                                                <i class='bx bx-show text-lg'></i>
                                                View File
                                            </a>
                                            <div class="flex gap-2">
                                                <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                                    <i class='bx bx-download text-xl'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="flex flex-col items-center justify-center py-12 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                                <div
                                    class="w-20 h-20 rounded-full bg-white flex items-center justify-center text-slate-200 mb-4 shadow-sm">
                                    <i class='bx bx-file-blank text-4xl'></i>
                                </div>
                                <h4 class="text-lg font-black text-slate-400 tracking-tight">No Documents Uploaded</h4>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 px-8 max-w-sm">The
                                    user has not submitted any verification documents for review yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Team Members Section (For Agencies) -->
                @if($user->hasRole('Agency'))
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black text-slate-800 tracking-tight">Agency Team Members</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Agents and Staff linked to this Agency</p>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-slate-200 shadow-sm text-indigo-600">
                                <i class='bx bx-group'></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $user->teamMembers->count() }} Members</span>
                            </div>
                        </div>
                        <div class="p-8">
                            @if($user->teamMembers->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($user->teamMembers as $member)
                                        <a href="{{ route('admin.users.show', $member->id) }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-200 hover:bg-white transition-all group">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 font-bold shadow-sm border border-slate-200 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-slate-800 truncate group-hover:text-indigo-600 transition-colors uppercase">{{ $member->name }}</p>
                                                <p class="text-[10px] font-medium text-slate-400 truncate">{{ $member->email }}</p>
                                            </div>
                                            <i class='bx bx-chevron-right text-slate-300 group-hover:text-indigo-600 transition-colors text-xl'></i>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-8 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                                    <i class='bx bx-user-plus text-4xl text-slate-200 mb-2'></i>
                                    <h4 class="text-sm font-black text-slate-400 tracking-tight">No Team Members</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">This agency has no registered agents yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Location & Mapping Section -->
                @if($user->latitude && $user->longitude)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black text-slate-800 tracking-tight">Geographic Location</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Precise Pinpoint on
                                    Global Map</p>
                            </div>
                            <div
                                class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-slate-200 shadow-sm text-indigo-600">
                                <i class='bx bxs-map-pin animate-bounce'></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">Active Marker</span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Latitude</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $user->latitude }}</p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Longitude</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $user->longitude }}</p>
                                </div>
                                <div class="md:col-span-2 bg-indigo-50 p-4 rounded-2xl border border-indigo-100">
                                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Formatted
                                        Coordinates</p>
                                    <p class="text-sm font-bold text-indigo-700">{{ $user->latitude }}, {{ $user->longitude }}
                                    </p>
                                </div>
                            </div>

                            <div class="w-full h-[350px] rounded-2xl overflow-hidden border border-slate-200 shadow-inner">
                                <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}&hl=en&z=14&amp;output=embed">
                                </iframe>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Activity / Properties Impact (Optional) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Properties Performance -->
                    <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden group shadow-xl">
                        <div
                            class="absolute top-0 right-0 p-8 opacity-10 scale-150 rotate-12 group-hover:scale-175 transition-transform duration-500">
                            <i class='bx bxs-building-house text-9xl'></i>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-80">Connected Properties</p>
                            <h4 class="text-4xl font-black mt-2 mb-4 tracking-tighter">0</h4>
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-widest backdrop-blur-md">
                                <i class='bx bx-trending-up'></i>
                                Active Listings
                            </div>
                        </div>
                    </div>

                    <!-- Earnings / Activity Score -->
                    <div
                        class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm group hover:border-indigo-200 transition-all">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100 group-hover:scale-110 transition-transform">
                                <i class='bx bxs-zap text-3xl'></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Activity
                                Level</span>
                        </div>
                        <h4 class="text-2xl font-black text-slate-800 tracking-tight uppercase">High Energy</h4>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 italic line-clamp-1">Last
                            activity recorded 2 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editUser(id) {
                // This function needs to be defined if user wants to edit from this page,
                // typically redirects to edit page or opens same modal if available on all admin pages
                window.location.href = `/admin/users/${id}/edit`;
            }
        </script>
    @endpush
@endsection