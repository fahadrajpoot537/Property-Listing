@extends('layouts.admin')

@section('header', 'Message Intelligence')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Navigation Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.contact.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#1CD494] hover:border-[#1CD494] transition-all shadow-sm">
                    <i class='bx bx-left-arrow-alt text-2xl'></i>
                </a>
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Viewing Submission</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Inquiry ID:
                        #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="mailto:{{ $submission->email }}"
                    class="flex items-center gap-2 px-6 py-2.5 bg-[#1CD494] text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-[#1CD494]/20 hover:-translate-y-0.5 transition-all">
                    <i class='bx bx-reply text-lg'></i> Reply via Email
                </a>
                <form action="{{ route('admin.contact.destroy', $submission->id) }}" method="POST"
                    onsubmit="return confirm('Archive this message permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                        <i class='bx bx-trash text-xl'></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Message Card -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <!-- Message Metadata Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 border-b border-slate-50">
                <div class="p-8 border-r border-slate-50">
                    <div class="flex items-start gap-5">
                        <div
                            class="w-12 h-12 rounded-[1.25rem] bg-blue-50 flex items-center justify-center text-[#02b8f2] shrink-0">
                            <i class='bx bxs-user-circle text-2xl'></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Sender
                                Information</p>
                            <h4 class="text-lg font-black text-slate-900 mb-1 leading-tight">{{ $submission->name }}</h4>
                            <p class="text-sm font-bold text-slate-500">{{ $submission->email }}</p>
                            @if($submission->phone)
                                <p class="text-sm font-bold text-[#1CD494] mt-1">{{ $submission->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-start gap-5">
                        <div
                            class="w-12 h-12 rounded-[1.25rem] bg-orange-50 flex items-center justify-center text-[#ff931e] shrink-0">
                            <i class='bx bxs-calendar text-2xl'></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Timestamp</p>
                            <h4 class="text-lg font-black text-slate-900 mb-1 leading-tight">
                                {{ $submission->created_at->format('d M, Y') }}
                            </h4>
                            <p class="text-sm font-bold text-slate-500">{{ $submission->created_at->format('h:i A') }}
                                ({{ $submission->created_at->diffForHumans() }})</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject Section -->
            <div class="p-8 bg-slate-50/30 border-b border-slate-50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Inquiry Subject</p>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-snug">
                    {{ $submission->subject ?: 'General Property Inquiry' }}
                </h2>
            </div>

            <!-- Message Body -->
            <div class="p-10 md:p-14">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Message Content</p>
                <div class="prose max-w-none">
                    <div class="text-slate-700 text-lg leading-[1.8] font-medium whitespace-pre-wrap italic">
                        "{{ $submission->message }}"
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="px-8 py-6 bg-slate-50/50 flex items-center justify-end border-t border-slate-50">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Read & Logged</span>
                </div>
            </div>
        </div>
    </div>
@endsection