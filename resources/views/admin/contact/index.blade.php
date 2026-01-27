@extends('layouts.admin')

@section('header', 'Contact Messages')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600">Manage Contact Submissions</h3>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6">
        <table id="contactTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Submitted</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-4">{{ $submission->id }}</td>
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $submission->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $submission->email }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ Str::limit($submission->subject, 40) }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $submission->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.contact.show', $submission) }}"
                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#02b8f2] hover:text-white transition-colors"
                                title="View Details">
                                <i class='bx bx-show'></i>
                            </a>
                            <form action="{{ route('admin.contact.destroy', $submission) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-rose-100 hover:text-rose-600 transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this message?')"
                                    title="Delete Message">
                                    <i class='bx bxs-trash'></i>
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