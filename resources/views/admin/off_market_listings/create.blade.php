@extends('layouts.admin')

@section('header', 'Create Off-Market Listing')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.off-market-listings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- User -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">User / Agent</label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="user_id" name="user_id" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Property Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="property_title">Property Title</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="property_title" type="text" name="property_title" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description" required></textarea>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Purpose -->
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="purpose">Purpose</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="purpose" name="purpose" required>
                        <option value="Rent">Rent</option>
                        <option value="Buy">Buy</option>
                    </select>
                </div>
                <!-- Price -->
                <div class="w-full md:w-1/2 px-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="price" type="number" step="0.01" name="price" required>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Area Size -->
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="area_size">Area Size (sqft)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="area_size" type="text" name="area_size" required>
                </div>
                <!-- Bedrooms -->
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bedrooms">Bedrooms</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="bedrooms" type="number" name="bedrooms" required>
                </div>
                <!-- Bathrooms -->
                <div class="w-full md:w-1/3 px-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bathrooms">Bathrooms</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="bathrooms" type="number" name="bathrooms" required>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Property Type -->
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="property_type_id">Property Type</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="property_type_id" name="property_type_id" required>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Unit Type -->
                <div class="w-full md:w-1/2 px-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="unit_type_id">Unit Type</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="unit_type_id" name="unit_type_id" required>
                        @foreach($unitTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Features -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Features</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($features as $feature)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">{{ $feature->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Images -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">Thumbnail</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="thumbnail" type="file" name="thumbnail">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gallery">Gallery Images</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="gallery" type="file" name="gallery[]" multiple>
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create Listing
                </button>
            </div>
        </form>
    </div>
@endsection