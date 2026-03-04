@extends('layouts.admin')

@section('header', 'Contact Messages')

@section('content')
    <div class="mb-5">
        <h3 class="text-slate-800 font-black text-lg tracking-tight uppercase">Inquiry Stream</h3>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Manage Direct Contact Submissions
        </p>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
        <table id="contactTable" class="w-full text-[13px] text-left text-slate-500">
            <thead class="text-[10px] text-slate-400 font-black uppercase tracking-widest bg-slate-50/50">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Sender Profile</th>
                    <th class="px-5 py-3">Message Intent</th>
                    <th class="px-5 py-3">Lifecycle</th>
                    <th class="px-5 py-3">Manage</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($submissions as $submission)
                    <tr class="hover:bg-slate-50 border-b border-slate-50 last:border-0 transition-all">
                        <td class="px-5 py-3 text-slate-400">#{{ $submission->id }}</td>
                        <td class="px-5 py-3">
                            <div class="font-bold text-slate-800">{{ $submission->name }}</div>
                            <div class="text-[10px] text-slate-400 font-medium">{{ $submission->email }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="text-slate-600 font-medium truncate max-w-xs">{{ Str::limit($submission->subject, 40) }}
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase">{{ $submission->created_at->format('d M, Y') }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex gap-1.5">
                                <a href="{{ route('admin.contact.show', $submission) }}"
                                    class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-[#8046F1] transition-all"
                                    title="View">
                                    <i class='bx bx-show'></i>
                                </a>
                                <form action="{{ route('admin.contact.destroy', $submission) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all"
                                        onclick="return confirm('Delete message?')"
                                        title="Delete">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            <i class='bx bx-envelope text-4xl mb-3 block'></i>
                            <p>No contact submissions found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($submissions->hasPages())
            <div class="mt-6">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
@endsection