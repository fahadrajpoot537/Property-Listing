@extends('layouts.admin')

@section('content')
    <!-- Sticky Header & Step Indicator -->
    <div class="sticky top-0 z-30 bg-slate-50/95 backdrop-blur-md pt-3 pb-4 -mx-6 px-6 border-b border-slate-200/50 mb-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-[#131B31] text-white rounded-lg flex items-center justify-center text-lg shadow-lg">
                        <i class='bx bx-home-alt'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight" id="pageTitle">
                            {{ isset($listing) ? 'Edit Property Listing' : 'Add New Property Listing' }}
                        </h3>
                        <p class="text-[9px] text-black font-bold uppercase tracking-widest mt-0.5">
                            Property Listing • Step <span id="currentStepText" class="text-indigo-600">1</span> of 3
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.listings.index') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-slate-100 text-black hover:text-rose-500 transition-all shadow-sm">
                    <i class='bx bx-x text-xl'></i>
                </a>
            </div>

            <!-- Responsive Step Indicator -->
            <div class="relative flex items-center justify-between px-4 md:px-32">
                <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full">
                    <div id="stepLine" class="w-0 h-full bg-[#8046F1] transition-all duration-700">
                    </div>
                </div>
                @for($i = 1; $i <= 3; $i++)
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="stepCircle{{$i}}"
                            class="w-8 h-8 rounded-lg bg-white border-2 border-slate-100 text-black flex items-center justify-center text-xs font-black shadow-sm transition-all">
                            {{$i}}
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden mb-8 shadow-sm">
        <form id="listingForm" enctype="multipart/form-data" class="flex flex-col flex-1">
            @csrf
            @if(isset($listing))
                @method('PUT')
                <input type="hidden" id="listingId" name="id" value="{{ $listing->id }}">
            @else
                <input type="hidden" id="listingId" name="id">
            @endif

            <div class="px-6 py-6">
                <!-- Step 1: Mandatory Fields (Rightmove Style) -->
                <div id="stage1" class="space-y-6 transition-all duration-500 transform translate-x-0">
                    <!-- Section: Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-[13px] font-black text-black uppercase tracking-widest mb-2">Property
                                Title</label>
                            <input type="text" name="property_title" id="property_title"
                                class="w-full rounded-lg border-slate-100 bg-slate-50 text-[13px] px-4 py-3 outline-none focus:bg-white focus:border-indigo-400 transition-all font-medium"
                                placeholder="e.g. Stunning 3 Bedroom Penthouse in Canary Wharf" required
                                value="{{ $listing->property_title ?? '' }}">
                        </div>

                        <div>
                            <label class="block text-[13px] font-black text-black uppercase tracking-widest mb-2">Internal
                                Reference (Optional)</label>
                            <input type="text" name="property_reference_number"
                                class="w-full rounded-lg border-slate-100 bg-slate-50 text-[13px] px-4 py-3 outline-none focus:bg-white focus:border-indigo-400 transition-all font-medium"
                                placeholder="Auto-generated if left blank" value="{{ $listing->property_reference_number ?? '' }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[13px] font-black text-black uppercase tracking-widest mb-2">Full
                                Address</label>
                            <div class="relative">
                                <i class='bx bx-map absolute left-4 top-1/2 -translate-y-1/2 text-black text-lg'></i>
                                <input type="text" name="address" id="address"
                                    class="w-full rounded-lg border-slate-100 bg-slate-50 text-[13px] px-4 py-3 pl-10 outline-none focus:bg-white focus:border-indigo-400 transition-all font-medium"
                                    placeholder="Search for address..." required value="{{ $listing->address ?? '' }}">
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ $listing->latitude ?? '' }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ $listing->longitude ?? '' }}">
                        </div>


                    </div>

                    <!-- Section: Pricing & Purpose -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 bg-slate-50/50 rounded-3xl border border-slate-100">
                        <div>
                            <label
                                class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Purpose</label>
                            <select name="purpose" id="purpose" class="select2 w-full" required>
                                <option value="Buy" {{ (isset($listing) && $listing->purpose == 'Buy') ? 'selected' : '' }}>
                                    For Sale</option>
                                <option value="Rent" {{ (isset($listing) && $listing->purpose == 'Rent') ? 'selected' : '' }}>
                                    To Rent</option>
                            </select>
                        </div>
                        <!-- <div>
                                                    <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Price
                                                        Qualifier</label>
                                                    <select name="price_qualifier" class="select2 w-full" required>
                                                        @foreach(['Offers in Excess Of', 'Guide Price', 'Fixed Price', 'POA'] as $pq)
                                                            <option value="{{ $pq }}" {{ (isset($listing) && $listing->price_qualifier == $pq) ? 'selected' : '' }}>{{ $pq }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> -->
                        <div>
                            <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Price
                                (£)</label>
                            <input type="number" step="0.01" name="price"
                                class="w-full rounded-2xl border-slate-100 bg-white text-sm p-4 transition-all font-bold"
                                placeholder="0.00" required value="{{ $listing->price ?? '' }}">
                        </div>

                        <!-- Rent Only Fields -->
                        <div id="rent_fields_container"
                            class="{{ (isset($listing) && $listing->purpose == 'Rent') ? '' : 'hidden' }} md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-200/50 mt-2">
                            <div>
                                <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Rent
                                    Frequency</label>
                                <select name="rent_frequency" class="select2 w-full">
                                    <option value="pcm" {{ (isset($listing) && $listing->rent_frequency == 'pcm') ? 'selected' : '' }}>PCM</option>
                                    <option value="pw" {{ (isset($listing) && $listing->rent_frequency == 'pw') ? 'selected' : '' }}>PW</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Security
                                    Deposit (£)</label>
                                <input type="text" name="deposit"
                                    class="w-full rounded-2xl border-slate-100 bg-white text-sm p-4 transition-all font-medium"
                                    placeholder="5 Weeks Rent..." value="{{ $listing->deposit ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Key Specifications (Rightmove Centric) -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 md:gap-6">
                        <style>
                            .chip-group {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 6px;
                                margin-top: 8px;
                            }

                            .chip {
                                padding: 8px 14px;
                                border-radius: 12px;
                                border: 1px solid #e2e8f0;
                                background: white;
                                color: #64748b;
                                font-size: 13px;
                                font-weight: 700;
                                cursor: pointer;
                                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                                text-align: center;
                                min-width: 45px;
                            }

                            .chip:hover {
                                border-color: #cbd5e1;
                                background: #f8fafc;
                            }

                            .chip.active {
                                border-color: #8046f1;
                                background: #8046f1;
                                color: white;
                                box-shadow: 0 4px 12px rgba(128, 70, 241, 0.2);
                            }
                        </style>

                        <div id="bedrooms_container" class="md:col-span-3">
                            <label
                                class="block text-[13px] font-black text-indigo-400 uppercase tracking-widest">Bedrooms</label>
                            <input type="hidden" name="bedrooms" id="bedrooms" value="{{ $listing->bedrooms ?? '' }}"
                                required>
                            <div class="chip-group" id="bedroom-chips">
                                <button type="button"
                                    class="chip {{ (isset($listing) && $listing->bedrooms == 'Studio') ? 'active' : '' }}"
                                    data-val="Studio">Studio</button>
                                @for($i = 1; $i <= 10; $i++)
                                    <button type="button"
                                        class="chip {{ (isset($listing) && $listing->bedrooms == $i) ? 'active' : '' }}"
                                        data-val="{{ $i }}">{{ $i }}</button>
                                @endfor
                                <button type="button"
                                    class="chip {{ (isset($listing) && $listing->bedrooms == '11+') ? 'active' : '' }}"
                                    data-val="11+">11+</button>
                            </div>
                        </div>

                        <div id="bathrooms_container" class="md:col-span-2">
                            <label
                                class="block text-[13px] font-black text-blue-400 uppercase tracking-widest">Bathrooms</label>
                            <input type="hidden" name="bathrooms" id="bathrooms" value="{{ $listing->bathrooms ?? '' }}"
                                required>
                            <div class="chip-group" id="bathroom-chips">
                                @for($i = 1; $i <= 6; $i++)
                                    <button type="button"
                                        class="chip {{ (isset($listing) && $listing->bathrooms == $i) ? 'active' : '' }}"
                                        data-val="{{ $i }}">{{ $i }}</button>
                                @endfor
                                <button type="button"
                                    class="chip {{ (isset($listing) && $listing->bathrooms == '11+') ? 'active' : '' }}"
                                    data-val="7+">7+</button>
                            </div>
                        </div>
                        <div id="receptions_container"
                            class="bg-purple-50/30 p-4 rounded-2xl border border-purple-100/50 hover:border-purple-200 transition-all">
                            <label
                                class="block text-[13px] font-black text-purple-400 uppercase tracking-widest mb-2">Receptions</label>
                            <div class="flex items-center gap-2">
                                <i class='bx bx-chair text-purple-500 text-lg'></i>
                                <input type="text" name="reception_rooms" id="reception_rooms"
                                    class="w-full bg-transparent border-none p-0 text-sm font-bold focus:ring-0"
                                    value="{{ $listing->reception_rooms ?? 0 }}">
                            </div>
                        </div>
                        <div
                            class="bg-amber-50/30 p-4 rounded-2xl border border-amber-100/50 hover:border-amber-200 transition-all">
                            <label class="block text-[13px] font-black text-amber-400 uppercase tracking-widest mb-2">Area
                                (Sq Ft)</label>
                            <div class="flex items-center gap-2">
                                <i class='bx bx-area text-amber-500 text-lg'></i>
                                <input type="text" name="area_size" required
                                    class="w-full bg-transparent border-none p-0 text-sm font-bold focus:ring-0"
                                    value="{{ $listing->area_size ?? '' }}">
                            </div>
                        </div>
                        <div
                            class="bg-rose-50/30 p-4 rounded-2xl border border-rose-100/50 hover:border-rose-200 transition-all">
                            <label class="block text-[13px] font-black text-rose-400 uppercase tracking-widest mb-2">Floor
                                Level</label>
                            <div class="flex items-center gap-2">
                                <i class='bx bx-layer text-rose-500 text-lg'></i>
                                <input type="text" name="floor_level"
                                    class="w-full bg-transparent border-none p-0 text-sm font-bold focus:ring-0"
                                    placeholder="e.g. 1st" value="{{ $listing->floor_level ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Categorization -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Category</label>
                            <select name="category_id" id="category_id" class="select2 w-full" required onchange="filterPropertyTypes()">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (isset($listing) && $listing->category_id == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Property Type</label>
                            <select name="property_type_id" id="property_type_id" class="select2 w-full" required onchange="handleTypeChange()">
                                <option value="">Select Property Type</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}" 
                                            data-category="{{ $type->category_id }}" 
                                            data-title="{{ strtolower($type->title) }}" 
                                            {{ (isset($listing) && $listing->property_type_id == $type->id) ? 'selected' : '' }}>
                                        {{ $type->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="sub_type" value="Not Specified">
                    </div>





                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Detailed
                            Narrative</label>
                        <div class="rounded-3xl overflow-hidden border border-slate-100">
                            <textarea id="description_editor"
                                class="w-full text-sm p-4">{{ $listing->description ?? '' }}</textarea>
                        </div>
                        <input type="hidden" name="description" id="description_hidden"
                            value="{{ $listing->description ?? '' }}">
                    </div>
                </div>

                <!-- Step 2: Property Details -->
                <div id="stage2" class="hidden space-y-12 transition-all duration-500">
                    <!-- Property Features -->
                    <div>
                        <label
                            class="block text-xs font-bold text-bl ack uppercase tracking-wider mb-4 border-b pb-2">Property
                            Features</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($features as $feature)
                                <label
                                    class="flex items-center space-x-3 p-3 rounded-xl border border-slate-100 bg-white hover:bg-slate-50 cursor-pointer transition-all">
                                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" {{ (isset($listing) && $listing->features->contains($feature->id)) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-xs font-medium text-slate-700">{{ $feature->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tenure -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Tenure</label>
                            <select name="tenure" id="tenure" class="select2 w-full text-xs"
                                onchange="toggleLeaseholdFields()">
                                <option value="Freehold" {{ (isset($listing->materialInfo) && $listing->materialInfo->tenure == 'Freehold') ? 'selected' : '' }}>Freehold</option>
                                <option value="Leasehold" {{ (isset($listing->materialInfo) && $listing->materialInfo->tenure == 'Leasehold') ? 'selected' : '' }}>Leasehold</option>
                                <option value="Share of Freehold" {{ (isset($listing->materialInfo) && $listing->materialInfo->tenure == 'Share of Freehold') ? 'selected' : '' }}>Share of
                                    Freehold</option>
                            </select>
                        </div>
                        <div id="leasehold_fields"
                            class="{{ (isset($listing->materialInfo) && $listing->materialInfo->tenure == 'Leasehold') ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-3 gap-4 md:col-span-2">
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Unexpired
                                    Years</label>
                                <input type="text" name="unexpired_years"
                                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3"
                                    value="{{ $listing->materialInfo->unexpired_years ?? '' }}">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Ground
                                    Rent (£)</label>
                                <input type="text" name="ground_rent"
                                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3"
                                    value="{{ $listing->materialInfo->ground_rent ?? '' }}">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Service
                                    Charge (£)</label>
                                <input type="text" name="service_charge"
                                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3"
                                    value="{{ $listing->materialInfo->service_charge ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Utilities -->
                    <div>
                        <label
                            class="block text-xs font-bold text-black uppercase tracking-wider mb-4 border-b pb-2">Utilities
                            & Material Information</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @php
                                $utils = [
                                    ['name' => 'utilities_water', 'label' => 'Water supply', 'value' => $listing->utilities->water ?? $listing->utilities_water ?? 'Ask Agent'],
                                    ['name' => 'utilities_electricity', 'label' => 'Electricity', 'value' => $listing->utilities->electricity ?? $listing->utilities_electricity ?? 'Ask Agent'],
                                    ['name' => 'utilities_sewerage', 'label' => 'Sewerage', 'value' => $listing->utilities->sewerage ?? $listing->utilities_sewerage ?? 'Ask Agent'],
                                    ['name' => 'utilities_heating', 'label' => 'Heating', 'value' => $listing->utilities->heating_type ?? $listing->heating_type ?? 'Ask Agent'],
                                    ['name' => 'utilities_broadband', 'label' => 'Broadband', 'value' => $listing->utilities->broadband ?? $listing->broadband ?? 'Ask Agent'],
                                    ['name' => 'utilities_mobile', 'label' => 'Mobile Coverage', 'value' => $listing->utilities->mobile_coverage ?? $listing->mobile_coverage ?? 'Ask Agent'],
                                ];
                            @endphp
                            @foreach($utils as $ut)
                                <div>
                                    <label
                                        class="block text-[13px] font-black text-black uppercase tracking-widest mb-3">{{ $ut['label'] }}</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach(['Yes', 'No', 'Ask Agent'] as $opt)
                                            <label class="relative group cursor-pointer">
                                                <input type="radio" name="{{ $ut['name'] }}" value="{{ $opt }}" class="hidden peer"
                                                    {{ $ut['value'] == $opt ? 'checked' : '' }}>
                                                <div
                                                    class="py-2.5 px-1 text-center rounded-xl border border-slate-100 text-[9px] font-black uppercase tracking-tighter transition-all duration-200
                                                                                                                                                                                                                                                                                                                                peer-checked:bg-slate-900 peer-checked:text-white peer-checked:border-slate-900 peer-checked:shadow-lg
                                                                                                                                                                                                                                                                                                                                bg-white text-black hover:bg-slate-50">
                                                    {{ $opt }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Parking & Construction -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Parking
                                Type</label>
                            <input type="text" name="parking_type" placeholder="e.g Basement, Garage"
                                class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3"
                                value="{{ $listing->materialInfo->parking_type ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Parking
                                Spaces</label>
                            <input type="text" name="parking_spaces_count" placeholder="e.g 1, 2"
                                class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3"
                                value="{{ $listing->materialInfo->parking_spaces_count ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-black uppercase tracking-wider mb-2">Construction
                                Type</label>
                            <input type="text" name="construction_type" placeholder="Bricks"
                                class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3"
                                value="{{ $listing->materialInfo->construction_type ?? '' }}">
                        </div>
                    </div>

                    <!-- Compliance & Availability -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-slate-50/50 rounded-3xl border border-slate-100">
                        <div>
                            <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Government
                                Scheme</label>
                            <input type="text" name="government_scheme"
                                class="w-full rounded-2xl border-slate-100 bg-white text-sm p-4 font-medium"
                                placeholder="e.g. Help to Buy" value="{{ $listing->government_scheme ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-black uppercase tracking-[0.2em] mb-3">Availability
                                Date</label>
                            <input type="date" name="availability_date"
                                class="w-full rounded-2xl border-slate-100 bg-white text-sm p-4 font-medium"
                                value="{{ $listing->availability_date ?? '' }}">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Media Uploads -->
                <div id="stage3" class="hidden space-y-6 transition-all duration-500">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hero Image -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                                <i class='bx bx-image-add text-lg text-[#02b8f2]'></i> Property Thumbnail (Required)
                            </label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                onchange="previewThumbnail(this)" class="hidden" {{ (isset($listing) && $listing->thumbnail) ? '' : 'required' }}>
                            <label for="thumbnail"
                                class="w-full py-3 bg-white rounded-lg border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-[13px] font-bold text-[#02b8f2] uppercase">Click
                                to Upload</label>
                            <div id="thumbPreview"
                                class="mt-3 {{ isset($listing) && $listing->thumbnail ? '' : 'hidden' }}">
                                @if(isset($listing) && $listing->thumbnail)
                                    <div class="relative group w-full h-32">
                                        <img src="/storage/{{ $listing->thumbnail }}"
                                            class="w-full h-full object-cover rounded-lg shadow-lg">
                                        <button type="button" onclick="removeThumbnail()"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center">
                                            <i class='bx bx-x'></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                                <i class='bx bx-images text-lg text-[#02b8f2]'></i> Property Photos
                            </label>
                            <input type="file" name="gallery[]" id="gallery" multiple accept="image/*"
                                onchange="handleGallerySelect(this)" class="hidden">
                            <label for="gallery"
                                class="w-full py-3 bg-white rounded-lg border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-[13px] font-bold text-[#02b8f2] uppercase">Select
                                Multiple</label>
                            <div id="galleryExisting" class="mt-3 flex flex-wrap gap-1.5">
                                @if(isset($listing) && $listing->media)
                                    @foreach($listing->media->where('type', 'photo') as $media)
                                        <div class="relative group existing-media-item">
                                            <img src="/storage/{{ $media->file_path }}"
                                                class="w-16 h-12 object-cover rounded-xl border border-slate-100 shadow-sm">
                                            <button type="button" onclick="removeExistingMedia({{ $media->id }}, this)"
                                                class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class='bx bx-x'></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div id="galleryNew" class="mt-1.5 flex flex-wrap gap-1.5"></div>
                        </div>
                    </div>

                    <!-- Floor Plans -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                            <i class='bx bx-map-alt text-lg text-[#02b8f2]'></i> FLOOR PLANS
                        </label>
                        <input type="file" name="floor_plans[]" id="floor_plans" multiple accept="image/*"
                            onchange="handleFloorPlansSelect(this)" class="hidden">
                        <label for="floor_plans"
                            class="w-full py-3 bg-white rounded-lg border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-[13px] font-bold text-[#02b8f2] uppercase">Upload
                            Floor Plans</label>
                        <div id="floorPlansExisting" class="mt-3 flex flex-wrap gap-1.5">
                            @if(isset($listing) && $listing->media)
                                @foreach($listing->media->where('type', 'floorplan') as $media)
                                    <div class="relative group existing-media-item">
                                        <img src="/storage/{{ $media->file_path }}"
                                            class="w-16 h-12 object-cover rounded-xl border border-slate-100 shadow-sm">
                                        <button type="button" onclick="removeExistingMedia({{ $media->id }}, this)"
                                            class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs">
                                            <i class='bx bx-x'></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="floorPlansNew" class="mt-1.5 flex flex-wrap gap-1.5"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- EPC -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                                <i class='bx bx-certification text-lg text-emerald-500'></i> EPC UPLOAD
                            </label>
                            <input type="file" name="epc_upload" id="epc_upload" accept="image/*,application/pdf"
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-bold hover:file:bg-emerald-100 cursor-pointer">
                            @if(isset($listing) && $listing->epc_upload)
                                <div class="mt-2 text-[13px] font-bold text-emerald-600 uppercase"><i class='bx bx-check'></i>
                                    EPC Uploaded</div>
                            @endif
                        </div>

                        <!-- Brochure -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                                <i class='bx bxs-file-pdf text-lg text-red-500'></i> BROCHURE (PDF)
                            </label>
                            <input type="file" name="brochure_pdf" id="brochure_pdf" accept="application/pdf"
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-red-50 file:text-red-700 file:font-bold hover:file:bg-red-100 cursor-pointer">
                            @if(isset($listing) && $listing->brochure_pdf)
                                <div class="mt-2 text-[13px] font-bold text-red-600 uppercase"><i class='bx bx-check'></i>
                                    Brochure Uploaded</div>
                            @endif
                        </div>
                    </div>

                    <!-- Video & Virtual Tour -->
                    <div class="p-6 bg-indigo-900 rounded-xl shadow-lg relative overflow-hidden">
                        <label class="block text-sm font-bold text-white mb-4 flex items-center gap-2 italic">
                            <i class='bx bxs-video text-2xl text-rose-400'></i> Property Video
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-[13px] font-bold text-indigo-300 uppercase tracking-widest mb-1">Video
                                        File</label>
                                    <input type="file" name="video" id="video" accept="video/*"
                                        class="w-full text-xs text-indigo-200 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-white file:text-indigo-900 file:font-bold hover:file:bg-indigo-50 cursor-pointer">
                                </div>
                                <div>
                                    <label
                                        class="block text-[13px] font-bold text-indigo-300 uppercase tracking-widest mb-1">Virtual
                                        Tour URL</label>
                                    <input type="url" name="virtual_tour_url"
                                        class="w-full rounded-lg border-indigo-700 bg-indigo-800 text-white text-xs p-3 transition-all"
                                        placeholder="https://my.matterport.com/show/..."
                                        value="{{ $listing->virtual_tour_url ?? '' }}">
                                </div>
                            </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex justify-between rounded-b-3xl flex-shrink-0">
        <button type="button" id="prevBtn" onclick="changeStep(-1)"
            class="hidden px-8 py-3.5 rounded-2xl border-2 border-slate-100 bg-white text-slate-700 text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Previous</button>
        <div class="flex-1 flex justify-end gap-3">
            <a href="{{ route('admin.listings.index') }}"
                class="px-6 py-3.5 text-black text-xs font-black uppercase tracking-widest hover:text-rose-500 transition-all flex items-center">Cancel</a>
            <button type="button" id="draftBtn" onclick="saveAsDraft()"
                class="px-12 py-3.5 rounded-2xl bg-amber-500 text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-amber-100/30 active:scale-95 transition-all">Save
                Draft</button>
            <button type="button" id="nextBtn" onclick="changeStep(1)"
                class="px-12 py-3.5 rounded-2xl bg-[#8046F1] text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-purple-100/30 active:scale-95 transition-all">Next
                Stage</button>
            <button type="submit" id="submitBtn"
                class="hidden px-12 py-3.5 rounded-2xl bg-[#131B31] text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-slate-900/10 active:scale-95 transition-all">Publish
                Property</button>
        </div>
    </div>
    </form>
    </div>

    @push('scripts')
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initAutocomplete"></script>
        <script>
            let autocomplete;
            let currentStep = 1;
            let editorInstance;


            function initAutocomplete() {
                const input = document.getElementById("address");
                if (input && typeof google !== 'undefined' && google.maps && google.maps.places) {
                    const options = { componentRestrictions: { country: "gb" }, fields: ["geometry", "name"] };
                    autocomplete = new google.maps.places.Autocomplete(input, options);
                    autocomplete.addListener("place_changed", () => {
                        const p = autocomplete.getPlace();
                        if (p.geometry) {
                            $('#latitude').val(p.geometry.location.lat());
                            $('#longitude').val(p.geometry.location.lng());
                        }
                    });
                }
            }

            $(document).ready(function () {
                initSelect2();
                setupDragAndDrop();

                ClassicEditor.create(document.querySelector('#description_editor'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                        'undo', 'redo'
                    ]
                }).then(editor => {
                    editorInstance = editor;
                    editor.model.document.on('change:data', () => {
                        $('#description_hidden').val(editor.getData());
                    });
                }).catch(error => console.error(error));

                $('#purpose').on('change', handlePurposeChange);
                handlePurposeChange();

                // Initial setup for edit mode
                toggleDiscountField();

                // Attach change listeners
                $('#property_type_id').on('change', handleTypeChange);

                // Chip Selector Logic
                $('.chip').on('click', function () {
                    const val = $(this).data('val');
                    const container = $(this).closest('.chip-group');
                    const input = container.prev('input');

                    container.find('.chip').removeClass('active');
                    $(this).addClass('active');
                    input.val(val);
                });

                // Initial load
                handleTypeChange();
                filterPropertyTypes();

                // Form Submission
                $('#listingForm').on('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const url = @if(isset($listing)) "{{ route('admin.listings.update', $listing->id) }}" @else"{{ route('admin.listings.store') }}" @endif;

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ route('admin.listings.index') }}";
                                });
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 403 && xhr.responseJSON && xhr.responseJSON.redirect) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Verification Required',
                                    text: xhr.responseJSON.message,
                                    confirmButtonText: 'Verify Now'
                                }).then(() => {
                                    window.location.href = xhr.responseJSON.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Something went wrong'
                                });
                            }
                        }
                    });
                });
            });

            function initSelect2() {
                $('.select2').select2({ minimumResultsForSearch: Infinity });
            }

            function handleTypeChange() {
                const title = ($('#property_type_id option:selected').text() || "").toLowerCase();
                const isCommercial = title.includes('commercial') || title.includes('office') || title.includes('shop') || title.includes('land') || title.includes('industrial') || title.includes('warehouse');

                if (isCommercial) {
                    $('#bedrooms_container, #bathrooms_container, #receptions_container').addClass('hidden');
                } else {
                    $('#bedrooms_container, #bathrooms_container, #receptions_container').removeClass('hidden');
                }
            }

            function filterPropertyTypes() {
                const categoryId = $('#category_id').val();
                const propertyTypeSelect = $('#property_type_id');
                
                propertyTypeSelect.find('option').each(function() {
                    if ($(this).val() === "") return;
                    
                    if (categoryId == "" || $(this).data('category') == categoryId) {
                        $(this).prop('disabled', false);
                    } else {
                        $(this).prop('disabled', true);
                    }
                });
                
                // If current selection is now invalid, reset it
                const currentVal = propertyTypeSelect.val();
                if (currentVal && propertyTypeSelect.find(`option[value="${currentVal}"]:disabled`).length > 0) {
                    propertyTypeSelect.val('').trigger('change');
                } else {
                    propertyTypeSelect.trigger('change');
                }
            }

            function handlePurposeChange() {
                const p = $('#purpose').val();
                if (p === 'Rent') {
                    $('#rent_fields_container').removeClass('hidden');
                } else {
                    $('#rent_fields_container').addClass('hidden');
                }
            }

            function toggleLeaseholdFields() {
                const t = $('#tenure').val();
                if (t === 'Leasehold') {
                    $('#leasehold_fields').removeClass('hidden');
                } else {
                    $('#leasehold_fields').addClass('hidden');
                }
            }

            function removeExistingMedia(id, btn) {
                $('#listingForm').append(`<input type="hidden" name="remove_media[]" value="${id}">`);
                $(btn).closest('.existing-media-item').remove();
            }

            function toggleDiscountField() {
                if ($('#has_discount').is(':checked')) {
                    $('#discount_field_container').removeClass('hidden');
                } else {
                    $('#discount_field_container').addClass('hidden');
                    $('#old_price').val('');
                }
            }

            function changeStep(n) {
                if (n > 0) {
                    let v = true;
                    $(`#stage${currentStep} [required]`).each(function () {
                        const $el = $(this);

                        // Skip if parent container is hidden
                        if ($el.closest('.hidden').length > 0) return;

                        // If it's a visible element or a hidden input that we want to validate
                        let isTypeHidden = $el.attr('type') === 'hidden' || $el.attr('type') === 'file' || $el.hasClass('select2-hidden-accessible');
                        if (!isTypeHidden && $el.is(':hidden')) return;

                        let val = $el.val();
                        if (!val || val === "" || val == null) {
                            $el.addClass('border-rose-400 ring-2 ring-rose-50');

                            // Select2
                            if ($el.hasClass('select2-hidden-accessible')) {
                                $el.next('.select2-container').find('.select2-selection').addClass('border-rose-400 ring-2 ring-rose-50');
                            }

                            // Chips
                            if ($el.next('.chip-group').length > 0) {
                                $el.next('.chip-group').addClass('p-2 rounded-xl bg-rose-50 ring-2 ring-rose-200');
                            }

                            // Custom labels for files (like Thumbnail)
                            if ($el.attr('type') === 'file') {
                                $el.next('label').addClass('border-rose-400 ring-2 ring-rose-50');
                            }

                            v = false;
                        } else {
                            $el.removeClass('border-rose-400 ring-2 ring-rose-50');
                            if ($el.hasClass('select2-hidden-accessible')) {
                                $el.next('.select2-container').find('.select2-selection').removeClass('border-rose-400 ring-2 ring-rose-50');
                            }
                            if ($el.next('.chip-group').length > 0) {
                                $el.next('.chip-group').removeClass('p-2 rounded-xl bg-rose-50 ring-2 ring-rose-200');
                            }
                            if ($el.attr('type') === 'file') {
                                $el.next('label').removeClass('border-rose-400 ring-2 ring-rose-50');
                            }
                        }
                    });

                    if (!v) {
                        Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }).fire({
                            icon: 'error',
                            title: 'Details Required',
                            text: 'Please fill all required fields before proceeding'
                        });
                        return;
                    }
                }

                currentStep += n;
                showStep(currentStep);
                // Scroll the main content area to top
                const mainEl = document.querySelector('main');
                if (mainEl) {
                    mainEl.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }

            function showStep(n) {
                $('#stage1, #stage2, #stage3').addClass('hidden');
                $(`#stage${n}`).removeClass('hidden');
                window.scrollTo({ top: 0, behavior: 'smooth' });

                if (n === 1) $(`#stage${n}`).addClass('form-grid');
                else $(`#stage${n}`).removeClass('form-grid');

                $('#currentStepText').text(n);
                $('#stepLine').css('width', `${(n - 1) * 50}%`);

                for (let i = 1; i <= 3; i++) {
                    const circle = $(`#stepCircle${i}`);
                    const label = $(`#stepLabel${i}`);

                    circle.removeClass('step-circle-active step-circle-completed text-black border-slate-100 bg-dark');
                    label.removeClass('text-indigo-600 text-slate-300 font-black').addClass('text-slate-300');

                    if (i < n) {
                        circle.addClass('step-circle-completed').html('<i class="bx bx-check text-xl"></i>');
                        label.addClass('text-emerald-500 font-bold');
                    } else if (i === n) {
                        circle.addClass('step-circle-active').text(i);
                        label.addClass('text-indigo-600 font-black').removeClass('text-slate-300');
                    } else {
                        circle.addClass('text-black border-slate-100 bg-white').text(i);
                        label.addClass('text-slate-300');
                    }
                }

                $('#prevBtn').toggleClass('hidden', n === 1);
                $('#nextBtn').toggleClass('hidden', n === 3);
                $('#submitBtn').toggleClass('hidden', n !== 3);
                $('#draftBtn').toggleClass('hidden', n !== 1);
            }

            function saveAsDraft() {
                const formData = new FormData($('#listingForm')[0]);
                formData.append('is_draft', '1');
                const url = @if(isset($listing)) "{{ route('admin.listings.update', $listing->id) }}" @else"{{ route('admin.listings.store') }}" @endif;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        Swal.fire({ icon: 'success', title: 'Draft Saved', text: res.message, timer: 2000, showConfirmButton: false })
                            .then(() => window.location.href = "{{ route('admin.listings.drafts') }}");
                    },
                    error: function (err) {
                        Swal.fire({ icon: 'error', title: 'Error', text: err.responseJSON?.message || 'Something went wrong' });
                    }
                });
            }

            const galleryDT = new DataTransfer();
            const floorPlansDT = new DataTransfer();

            function previewThumbnail(input) {
                const preview = $('#thumbPreview');
                console.log('previewThumb called');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.removeClass('hidden').html(`
                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="relative group w-full h-32">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg shadow-lg">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" onclick="removeThumbnail()" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-all shadow-md">
                                                                                                                                                                                                                                                                                                                                                                                                                                        <i class='bx bx-x'></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                            `);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function removeThumbnail() {
                if ($('#thumbPreview img').attr('src')?.includes('/storage/')) {
                    $('#listingForm').append('<input type="hidden" name="remove_thumbnail" value="1">');
                }
                $('#thumbnail').val('');
                $('#thumbPreview').addClass('hidden').html('');
            }

            function previewVideoFile(input) {
                const preview = $('#videoPreview');
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const url = URL.createObjectURL(file);
                    preview.removeClass('hidden').html(`
                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="relative group w-full h-48">
                                                                                                                                                                                                                                                                                                                                                                                                                                <video controls src="${url}" class="w-full h-full rounded-2xl shadow-lg bg-black"></video>
                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button" onclick="removeVideo()" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-all shadow-md z-10">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class='bx bx-x'></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                        `);
                }
            }

            function removeVideo() {
                if ($('#videoPreview video').attr('src')?.includes('/storage/')) {
                    $('#listingForm').append('<input type="hidden" name="remove_video" value="1">');
                }
                $('#video').val('');
                $('#videoPreview').addClass('hidden').html('');
            }

            function handleGallerySelect(input) {
                const files = input.files;
                for (let i = 0; i < files.length; i++) {
                    galleryDT.items.add(files[i]);
                }
                input.files = galleryDT.files;
                renderGalleryPreview();
            }

            function renderGalleryPreview() {
                const container = $('#galleryNew');
                container.empty();

                Array.from(galleryDT.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = $(`
                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="relative group w-16 h-12">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src="${e.target.result}" class="w-full h-full object-cover rounded-xl border border-slate-100 shadow-sm">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" onclick="removeGalleryFile(${index})" class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-rose-600 transition-all shadow-md">
                                                                                                                                                                                                                                                                                                                                                                                                                                        <i class='bx bx-x'></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                            `);
                        container.append(div);
                    }
                    reader.readAsDataURL(file);
                });
            }

            function removeGalleryFile(index) {
                const input = document.getElementById('gallery');
                const dt = new DataTransfer();
                const files = galleryDT.files;

                for (let i = 0; i < files.length; i++) {
                    if (i !== index) {
                        dt.items.add(files[i]);
                    }
                }
                galleryDT.items.clear();
                for (let i = 0; i < dt.files.length; i++) {
                    galleryDT.items.add(dt.files[i]);
                }

                input.files = galleryDT.files;
                renderGalleryPreview();
            }

            function removeExistingImage(btn) {
                const wrapper = $(btn).closest('.relative');
                const val = wrapper.find('input[name="existing_gallery[]"]').val();
                $('#listingForm').append(`<input type="hidden" name="remove_gallery[]" value="${val}">`);
                wrapper.remove();
            }

            function handleFloorPlansSelect(input) {
                const files = input.files;
                for (let i = 0; i < files.length; i++) {
                    floorPlansDT.items.add(files[i]);
                }
                input.files = floorPlansDT.files;
                renderFloorPlansPreview();
            }

            function renderFloorPlansPreview() {
                const container = $('#floorPlansNew');
                container.empty();

                Array.from(floorPlansDT.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = $(`
                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="relative group w-16 h-12">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src="${e.target.result}" class="w-full h-full object-cover rounded-xl border border-slate-100 shadow-sm">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" onclick="removeFloorPlanFile(${index})" class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-rose-600 transition-all shadow-md">
                                                                                                                                                                                                                                                                                                                                                                                                                                        <i class='bx bx-x'></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                            `);
                        container.append(div);
                    }
                    reader.readAsDataURL(file);
                });
            }

            function removeFloorPlanFile(index) {
                const input = document.getElementById('floor_plans');
                const dt = new DataTransfer();
                const files = floorPlansDT.files;

                for (let i = 0; i < files.length; i++) {
                    if (i !== index) {
                        dt.items.add(files[i]);
                    }
                }
                floorPlansDT.items.clear();
                for (let i = 0; i < dt.files.length; i++) {
                    floorPlansDT.items.add(dt.files[i]);
                }

                input.files = floorPlansDT.files;
                renderFloorPlansPreview();
            }

            function removeExistingFloorPlan(btn) {
                const wrapper = $(btn).closest('.relative');
                const val = wrapper.find('input[name="existing_floor_plans[]"]').val();
                $('#listingForm').append(`<input type="hidden" name="remove_floor_plans[]" value="${val}">`);
                wrapper.remove();
            }

            function setupDragAndDrop() {
                const fileInputs = document.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    const container = input.closest('div');
                    if (!container) return;

                    // We look for containers that have a dashed border styling
                    if (!container.className.includes('border-dashed') && !container.className.includes('file:bg-')) return;

                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        container.addEventListener(eventName, preventDefaults, false);
                    });

                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    ['dragenter', 'dragover'].forEach(eventName => {
                        container.addEventListener(eventName, () => {
                            container.classList.add('bg-indigo-50/80', 'border-indigo-400');
                            if (container.className.includes('border-dashed')) {
                                container.classList.remove('border-slate-200');
                                container.style.borderStyle = 'solid';
                            }
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        container.addEventListener(eventName, () => {
                            container.classList.remove('bg-indigo-50/80', 'border-indigo-400');
                            if (container.className.includes('border-dashed')) {
                                container.classList.add('border-slate-200');
                                container.style.borderStyle = 'dashed';
                            }
                        }, false);
                    });

                    container.addEventListener('drop', (e) => {
                        let dt = e.dataTransfer;
                        let files = dt.files;

                        if (files && files.length) {
                            input.files = files;
                            // manually trigger the onchange handler
                            if (typeof input.onchange === 'function') {
                                input.onchange({ target: input });
                            } else {
                                const event = new Event('change', { bubbles: true });
                                input.dispatchEvent(event);
                            }
                        }
                    }, false);
                });
            }
        </script>
    @endpush
@endsection