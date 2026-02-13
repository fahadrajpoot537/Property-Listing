@extends('layouts.admin')

@section('header', 'Edit Listing')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- User (Hidden or Readonly usually, but editable here for admin) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">User / Agent</label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="user_id" name="user_id" disabled>
                    <option value="{{ $listing->user_id }}" selected>{{ $listing->user->name }}
                        ({{ $listing->user->email }})</option>
                </select>
            </div>

            <!-- Property Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="property_title">Property Title</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="property_title" type="text" name="property_title" value="{{ $listing->property_title }}" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description" required>{{ $listing->description }}</textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status</label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="status" name="status" required>
                    <option value="pending" {{ $listing->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $listing->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $listing->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>


            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Purpose -->
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="purpose">Purpose</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="purpose" name="purpose" required>
                        <option value="Rent" {{ $listing->purpose == 'Rent' ? 'selected' : '' }}>Rent</option>
                        <option value="Buy" {{ $listing->purpose == 'Buy' ? 'selected' : '' }}>Buy</option>
                    </select>
                </div>
                <!-- Price -->
                <div class="w-full md:w-1/2 px-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price (£)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="price" type="number" step="0.01" name="price" value="{{ $listing->price }}" required>

                    <div class="mt-2 flex items-center" id="discount_checkbox_container">
                        <input type="checkbox" id="has_discount"
                            class="rounded border-gray-300 text-blue-600 focus:ring-0 mr-2" onchange="toggleDiscountField()"
                            {{ $listing->old_price ? 'checked' : '' }}>
                        <label for="has_discount" class="text-sm font-bold text-gray-600">Add Discount?</label>
                    </div>
                </div>
            </div>

            <div id="discount_field_container" class="mb-6 {{ $listing->old_price ? '' : 'hidden' }}">
                <label class="block text-gray-700 text-sm font-bold mb-2 text-rose-500" for="old_price">Old Price (£) - Will
                    be shown with strikethrough</label>
                <input
                    class="shadow appearance-none border border-rose-100 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-rose-50/20"
                    id="old_price" type="number" step="0.01" name="old_price" value="{{ $listing->old_price }}">
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Area Size -->
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="area_size">Area Size (sqft)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="area_size" type="text" name="area_size" value="{{ $listing->area_size }}" required>
                </div>
                <!-- Bedrooms -->
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bedrooms">Bedrooms</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="bedrooms" type="number" name="bedrooms" value="{{ $listing->bedrooms }}" required>
                </div>
                <!-- Bathrooms -->
                <div class="w-full md:w-1/3 px-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bathrooms">Bathrooms</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="bathrooms" type="number" name="bathrooms" value="{{ $listing->bathrooms }}" required>
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
                            <option value="{{ $type->id }}" {{ $listing->property_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->title }}
                            </option>
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
                            <option value="{{ $type->id }}" {{ $listing->unit_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Features -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Features</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @php $listingFeatures = $listing->features->pluck('id')->toArray(); @endphp
                    @foreach($features as $feature)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="features[]" value="{{ $feature->id }}" {{ in_array($feature->id, $listingFeatures) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">{{ $feature->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Images -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">Thumbnail</label>
                @if($listing->thumbnail)
                    <img src="{{ asset('storage/' . $listing->thumbnail) }}" alt="Thumbnail"
                        class="h-20 w-20 object-cover mb-2 rounded">
                @endif
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="thumbnail" type="file" name="thumbnail">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gallery">Gallery Images</label>
                @if($listing->gallery)
                    <div class="flex space-x-2 mb-2">
                        @foreach($listing->gallery as $img)
                            <img src="{{ asset('storage/' . $img) }}" alt="Gallery" class="h-20 w-20 object-cover rounded">
                        @endforeach
                    </div>
                @endif
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="gallery" type="file" name="gallery[]" multiple>
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Update Listing
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#purpose').on('change', handlePurposeChange);
                handlePurposeChange(); // Initialize
            });

            function handlePurposeChange() {
                const purpose = $('#purpose').val();
                if (purpose === 'Rent') {
                    $('#discount_checkbox_container').addClass('hidden');
                    $('#discount_field_container').addClass('hidden');
                    $('#has_discount').prop('checked', false);
                    $('#old_price').val('');
                } else {
                    $('#discount_checkbox_container').removeClass('hidden');
                    toggleDiscountField(); // Re-evaluate based on checkbox
                }
            }

            function toggleDiscountField() {
                const isChecked = $('#has_discount').is(':checked');
                const container = $('#discount_field_container');
                if (isChecked) {
                    container.removeClass('hidden');
                } else {
                    container.addClass('hidden');
                    $('#old_price').val('');
                }
            }
        </script>
    @endpush
@endsection