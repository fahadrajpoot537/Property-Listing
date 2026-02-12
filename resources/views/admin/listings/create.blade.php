@extends('layouts.admin')

@section('header', 'Create Prmium Listing')

@section('title', 'Create Listing')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: #111827;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }
        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('admin.listings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Primary Information -->
            <div class="form-section">
                <h3 class="section-title">Primary Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="form-label" for="user_id">Listing Agent / Owner</label>
                        <select class="form-input select2" id="user_id" name="user_id" required>
                            <option value="">Select Agent</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label" for="property_title">Property Title</label>
                        <input class="form-input" id="property_title" type="text" name="property_title" 
                            placeholder="e.g. Luxury Apartment in London" value="{{ old('property_title') }}" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-input" id="description" name="description" rows="5" 
                        placeholder="Detailed description of the property..." required>{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="form-label" for="purpose">Listing Purpose</label>
                        <select class="form-input" id="purpose" name="purpose" required>
                            <option value="Rent" {{ old('purpose') == 'Rent' ? 'selected' : '' }}>For Rent</option>
                            <option value="Buy" {{ old('purpose') == 'Buy' ? 'selected' : '' }}>For Sale</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="price">Price (£)</label>
                        <input class="form-input" id="price" type="number" step="0.01" name="price" 
                            placeholder="0.00" value="{{ old('price') }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="area_size">Area Size (sq ft)</label>
                        <input class="form-input" id="area_size" type="text" name="area_size" 
                            placeholder="e.g. 1,200" value="{{ old('area_size') }}" required>
                    </div>
                </div>
            </div>

            <!-- Property Details -->
            <div class="form-section">
                <h3 class="section-title">Property Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="form-label" for="property_type_id">Property Type</label>
                        <select class="form-input select2" id="property_type_id" name="property_type_id" required>
                            <option value="">Select Type</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="unit_type_id">Unit Type</label>
                        <select class="form-input select2" id="unit_type_id" name="unit_type_id" required>
                            <option value="">Select Unit Type</option>
                            @foreach($unitTypes as $type)
                                <option value="{{ $type->id }}" {{ old('unit_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label" for="bedrooms">Bedrooms</label>
                        <input class="form-input" id="bedrooms" type="number" name="bedrooms" 
                            min="0" value="{{ old('bedrooms') }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="bathrooms">Bathrooms</label>
                        <input class="form-input" id="bathrooms" type="number" name="bathrooms" 
                            min="0" value="{{ old('bathrooms') }}" required>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="form-section">
                <h3 class="section-title">Features & Amenities</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($features as $feature)
                        <label class="inline-flex items-center p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                                class="form-checkbox h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                {{ is_array(old('features')) && in_array($feature->id, old('features')) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700 font-medium">{{ $feature->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Media -->
            <div class="form-section">
                <h3 class="section-title">Media Uploads</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="form-label" for="thumbnail">Main Thumbnail Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-2">
                                        <span>Upload a file</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label" for="gallery">Gallery Images</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="gallery" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-2">
                                        <span>Upload multiple files</span>
                                        <input id="gallery" name="gallery[]" type="file" multiple class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB each</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mb-12">
                <a href="{{ route('admin.listings.index') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition-all">Cancel</a>
                <button type="submit" 
                        class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Create Listing
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Check if Select2 is loaded
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    width: '100%',
                    placeholder: "Select an option",
                    allowClear: true
                });
            } else {
                console.error('Select2 is not loaded');
            }

            // Display file names on select
            $('input[type="file"]').change(function(e){
                var fileName = '';
                if(e.target.files.length > 1) {
                    fileName = e.target.files.length + ' files selected';
                } else {
                    fileName = e.target.files[0].name;
                }
                $(this).closest('.flex').next('p').text(fileName).addClass('text-indigo-600 font-medium');
            });
        });
    </script>
@endpush