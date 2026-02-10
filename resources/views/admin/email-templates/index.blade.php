@extends('layouts.admin')

@section('header', 'Email Template Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600">Customize Notification Emails</h3>
        <a href="{{ route('admin.email-templates.create') }}"
            class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2.5 px-6 rounded-xl shadow-lg shadow-purple-100 transition-all flex items-center gap-2 active:scale-95 text-sm uppercase tracking-wider">
            <i class='bx bx-plus-circle text-lg'></i> Create Template
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6 overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $template->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[10px] font-bold uppercase">{{ $template->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $template->subject }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($template->is_active)
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase">Active</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-400 text-[10px] font-black uppercase">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.email-templates.edit', $template) }}"
                                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#8046F1] hover:text-white transition-colors">
                                    <i class='bx bxs-edit'></i>
                                </a>
                                <form action="{{ route('admin.email-templates.destroy', $template) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-rose-100 hover:text-rose-600 transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this template?')">
                                        <i class='bx bxs-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            <i class='bx bx-envelope text-4xl mb-3 block'></i>
                            <p>No templates found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
