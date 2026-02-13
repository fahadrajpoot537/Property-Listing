@extends('layouts.admin')

@section('header', 'Create Blog')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                    id="title" type="text" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="author">Author</label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('author') border-red-500 @enderror"
                    id="author" name="author" required>
                    <option value="">Select Author</option>
                    @foreach($users as $user)
                        <option value="{{ $user->name }}" {{ old('author') == $user->name ? 'selected' : '' }}>{{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('author')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content Editor -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">Content</label>
                <textarea id="content" name="content"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror"
                    rows="15">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Featured Image</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror"
                    id="image" type="file" name="image">
                @error('image')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create Blog
                </button>
                <a href="{{ route('admin.blogs.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection