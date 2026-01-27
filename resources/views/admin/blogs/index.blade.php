@extends('layouts.admin')

@section('header', 'Blog Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600">Manage Blog Posts</h3>
        <a href="{{ route('admin.blogs.create') }}"
            class="bg-[#02b8f2] hover:bg-[#019ad1] text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center gap-2">
            <i class='bx bx-plus'></i> Create New Blog
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6">
        <table id="blogsTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Created</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-4">{{ $blog->id }}</td>
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $blog->title }}</td>
                    <td class="px-6 py-4">
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                <i class='bx bx-image'></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $blog->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog) }}"
                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#02b8f2] hover:text-white transition-colors">
                                <i class='bx bxs-edit'></i>
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-rose-100 hover:text-rose-600 transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this blog?')">
                                    <i class='bx bxs-trash'></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        <i class='bx bx-book text-4xl mb-3 block'></i>
                        <p>No blogs found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($blogs->hasPages())
        <div class="mt-6">
            {{ $blogs->links() }}
        </div>
        @endif
    </div>
@endsection