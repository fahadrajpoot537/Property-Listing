@extends('layouts.admin')

@section('header', 'Create Property Type')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.property-types.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="title" type="text" name="title" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description"></textarea>
            </div>
            <div class="mb-4">
                <h3 class="font-bold mb-2">SEO</h3>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="meta_title">Meta Title</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="meta_title" type="text" name="meta_title">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="meta_keywords">Meta Keywords</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="meta_keywords" type="text" name="meta_keywords">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="meta_description">Meta
                        Description</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="meta_description" name="meta_description"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create
                </button>
            </div>
        </form>
    </div>
@endsection