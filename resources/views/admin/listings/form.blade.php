@extends('layouts.admin')

@section('content')
    <div class="pt-4 pb-4">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl flex items-center justify-center text-2xl rotate-3 shadow-lg shadow-indigo-200">
                    <i class='bx bxs-home-circle'></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight" id="pageTitle">
                        {{ isset($listing) ? 'Modify Listing' : 'New Property Listing' }}
                    </h3>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Portfolio Optimizer
                        <span class="mx-2 text-slate-200">•</span> Step <span id="currentStepText"
                            class="text-indigo-600">1</span> of 3
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.listings.index') }}"
                class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all duration-300">
                <i class='bx bx-x text-2xl'></i>
            </a>
        </div>

        <div class="relative flex items-center justify-between mb-10 px-24">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full overflow-hidden">
                <div id="stepLine"
                    class="w-0 h-full bg-gradient-to-r from-indigo-500 to-purple-600 transition-all duration-1000 cubic-bezier(0.4, 0, 0.2, 1)">
                </div>
            </div>
            @for($i = 1; $i <= 3; $i++)
                <div class="relative z-10 flex flex-col items-center">
                    <div id="stepCircle{{$i}}"
                        class="w-12 h-12 rounded-2xl bg-white border-2 border-slate-100 text-slate-400 flex items-center justify-center text-sm font-black shadow-sm transition-all duration-500">
                        {{$i}}
                    </div>
                    <span id="stepLabel{{$i}}"
                        class="absolute -bottom-7 text-[9px] font-black uppercase tracking-widest text-slate-300 transition-all">
                        {{ $i == 1 ? 'Details' : ($i == 2 ? 'Features' : 'Media') }}
                    </span>
                </div>
            @endfor
        </div>
    </div>

    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 overflow-hidden mb-8">
        <form id="listingForm" enctype="multipart/form-data" class="flex flex-col flex-1">
            @csrf
            @if(isset($listing))
                @method('PUT')
                <input type="hidden" id="listingId" name="id" value="{{ $listing->id }}">
            @else
                <input type="hidden" id="listingId" name="id">
            @endif

            <div class="px-8 py-8">
                <!-- Stage 1 : Basic Details -->
                <div id="stage1" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Property
                            Headline</label>
                        <input type="text" name="property_title" id="property_title"
                            class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                            placeholder="Enter a catchy title..." required value="{{ $listing->property_title ?? '' }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Property
                            Location (UK Only)</label>
                        <div class="relative">
                            <input type="text" name="address" id="address"
                                class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 pl-11 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                                placeholder="Search UK address..." required value="{{ $listing->address ?? '' }}">
                            <i class='bx bxs-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl'></i>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ $listing->latitude ?? '' }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ $listing->longitude ?? '' }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Purpose</label>
                        <select name="purpose" id="purpose" class="select2 w-full text-xs" required>
                            <option value="Rent" {{ (isset($listing) && $listing->purpose == 'Rent') ? 'selected' : '' }}>To
                                Rent</option>
                            <option value="Buy" {{ (isset($listing) && $listing->purpose == 'Buy') ? 'selected' : '' }}>For
                                Sale</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Price/Rent
                            (£)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="price" id="price"
                                class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 pl-8 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                                placeholder="0.00" required value="{{ $listing->price ?? '' }}">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">£</span>
                        </div>
                        <div class="mt-2 flex items-center">
                            <input type="checkbox" id="has_discount"
                                class="rounded border-slate-300 text-[#02b8f2] focus:ring-0 mr-2"
                                onchange="toggleDiscountField()" {{ (isset($listing) && $listing->old_price) ? 'checked' : '' }}>
                            <label for="has_discount" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Add
                                Discount?</label>
                        </div>
                    </div>

                    <div id="discount_field_container"
                        class="{{ (isset($listing) && $listing->old_price) ? '' : 'hidden' }}">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Old Price
                            (£)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="old_price" id="old_price"
                                class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 pl-8 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                                placeholder="0.00" value="{{ $listing->old_price ?? '' }}">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">£</span>
                        </div>
                    </div>

                    <!-- Conditional Fields -->
                    <div id="for-sale-fields" class="hidden md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ownership
                                    Status</label>
                                <select name="ownership_status_id" id="ownership_status_id" class="select2 w-full text-xs">
                                    <option value="">Select Ownership</option>
                                    @foreach($ownershipStatuses as $os)
                                        <option value="{{ $os->id }}" {{ (isset($listing) && $listing->ownership_status_id == $os->id) ? 'selected' : '' }}>{{ $os->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 text-rose-500">No
                                    Onward Chain?</label>
                                <select name="no_onward_chain" id="no_onward_chain" class="select2 w-full text-xs">
                                    <option value="0" {{ (isset($listing) && !$listing->no_onward_chain) ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ (isset($listing) && $listing->no_onward_chain) ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="to-rent-fields" class="hidden md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rent
                                    Frequency</label>
                                <select name="rent_frequency_id" id="rent_frequency_id" class="select2 w-full text-xs">
                                    <option value="">Select Frequency</option>
                                    @foreach($rentFrequencies as $rf)
                                        <option value="{{ $rf->id }}" {{ (isset($listing) && $listing->rent_frequency_id == $rf->id) ? 'selected' : '' }}>{{ $rf->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cheques
                                    Required</label>
                                <select name="cheque_id" id="cheque_id" class="select2 w-full text-xs">
                                    <option value="">Select Cheques</option>
                                    @foreach($cheques as $c)
                                        <option value="{{ $c->id }}" {{ (isset($listing) && $listing->cheque_id == $c->id) ? 'selected' : '' }}>{{ $c->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Availability
                                    Date</label>
                                <input type="date" name="availability_date" id="availability_date"
                                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                                    value="{{ $listing->availability_date ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Property
                            Type</label>
                        <select name="property_type_id" id="property_type_id" onchange="handleTypeChange()"
                            class="select2 w-full text-xs" required>
                            <option value="">Select Type</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" data-title="{{ strtolower($type->title) }}" {{ (isset($listing) && $listing->property_type_id == $type->id) ? 'selected' : '' }}>{{ $type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unit
                            Type</label>
                        <select name="unit_type_id" id="unit_type_id" class="select2 w-full text-xs" required
                            data-selected="{{ $listing->unit_type_id ?? '' }}">
                            <option value="">Choose Category</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Area (Sq
                            Ft)</label>
                        <input type="text" name="area_size" id="area_size"
                            class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                            placeholder="e.g. 1500" required value="{{ $listing->area_size ?? '' }}">
                    </div>
                    <div id="bedBathContainer">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Beds &
                            Baths</label>
                        <div class="grid grid-cols-2 gap-3">
                            <select name="bedrooms" id="bedrooms" class="select2 w-full text-xs">
                                <option value="">N/A</option>
                                <option value="0" {{ (isset($listing) && $listing->bedrooms === 0) ? 'selected' : '' }}>Studio
                                </option>
                                @for($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ (isset($listing) && $listing->bedrooms == $i) ? 'selected' : '' }}>{{ $i }} Bed{{$i > 1 ? 's' : ''}}</option>
                                @endfor
                                <option value="10" {{ (isset($listing) && $listing->bedrooms == 10) ? 'selected' : '' }}>10+
                                    Beds</option>
                            </select>
                            <select name="bathrooms" id="bathrooms" class="select2 w-full text-xs">
                                <option value="">N/A</option>
                                @for($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ (isset($listing) && $listing->bathrooms == $i) ? 'selected' : '' }}>{{ $i }} Bath{{$i > 1 ? 's' : ''}}</option>
                                @endfor
                                <option value="10" {{ (isset($listing) && $listing->bathrooms == 10) ? 'selected' : '' }}>10+
                                    Baths</option>
                            </select>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Full
                            Description</label>
                        <textarea id="description_editor" class="w-full rounded-lg text-xs p-2"
                            rows="6">{{ $listing->description ?? '' }}</textarea>
                        <input type="hidden" name="description" id="description_hidden"
                            value="{{ $listing->description ?? '' }}">
                    </div>
                </div>

                <!-- Stage 2: Features & Legal -->
                <div id="stage2" class="hidden space-y-8">
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 border-b pb-2">Property
                            Features & Amenities</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                            @foreach($features as $feature)
                                <label
                                    class="group relative flex items-center p-3 bg-slate-50 rounded-xl border border-slate-100 hover:border-indigo-200 hover:bg-white transition-all cursor-pointer">
                                    <input id="feat_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}"
                                        type="checkbox" class="h-4 w-4 text-indigo-600 rounded border-slate-300 focus:ring-0" {{ (isset($listing) && $listing->features->contains($feature->id)) ? 'checked' : '' }}>
                                    <span
                                        class="ml-2 text-[11px] font-bold text-slate-600 uppercase tracking-tighter">{{ $feature->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 border-b pb-2">Legal
                            & Information</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Council
                                    Tax Band</label>
                                <select name="council_tax_band" class="select2 w-full text-xs">
                                    <option value="">Select Band</option>
                                    @foreach(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'] as $band)
                                        <option value="{{ $band }}" {{ (isset($listing) && $listing->council_tax_band == $band) ? 'selected' : '' }}>Band {{ $band }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">EPC
                                    Rating</label>
                                <select name="epc_rating" class="select2 w-full text-xs">
                                    <option value="">Select Rating</option>
                                    @foreach(['A', 'B', 'C', 'D', 'E', 'F', 'G'] as $rating)
                                        <option value="{{ $rating }}" {{ (isset($listing) && $listing->epc_rating == $rating) ? 'selected' : '' }}>{{ $rating }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Floors
                                    Count</label>
                                <input type="number" name="floors_count"
                                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 transition-all"
                                    value="{{ $listing->floors_count ?? '' }}">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Listed
                                    Property Status</label>
                                <select name="listed_property" class="select2 w-full text-xs">
                                    <option value="">None</option>
                                    <option value="Grade I" {{ (isset($listing) && $listing->listed_property == 'Grade I') ? 'selected' : '' }}>Grade I</option>
                                    <option value="Grade II*" {{ (isset($listing) && $listing->listed_property == 'Grade II*') ? 'selected' : '' }}>Grade II*</option>
                                    <option value="Grade II" {{ (isset($listing) && $listing->listed_property == 'Grade II') ? 'selected' : '' }}>Grade II</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Flood
                                    Risk</label>
                                <select name="flood_risk" class="select2 w-full text-xs">
                                    <option value="Very Low" {{ (isset($listing) && $listing->flood_risk == 'Very Low') ? 'selected' : '' }}>Very Low</option>
                                    <option value="Low" {{ (isset($listing) && $listing->flood_risk == 'Low') ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ (isset($listing) && $listing->flood_risk == 'Medium') ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ (isset($listing) && $listing->flood_risk == 'High') ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                            <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Restrictions
                                        / Covenants</label>
                                    <textarea name="restrictions"
                                        class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 mt-1"
                                        rows="2">{{ $listing->restrictions ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Private
                                        Rights of Way</label>
                                    <textarea name="private_rights_of_way"
                                        class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 mt-1"
                                        rows="2">{{ $listing->private_rights_of_way ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Flood
                                        History</label>
                                    <textarea name="flood_history"
                                        class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 mt-1"
                                        rows="2">{{ $listing->flood_history ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Flood
                                        Defenses</label>
                                    <textarea name="flood_defenses"
                                        class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-3 mt-1"
                                        rows="2">{{ $listing->flood_defenses ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stage 3 -->
                <div id="stage3" class="hidden space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                                <i class='bx bx-image-add text-lg text-[#02b8f2]'></i> HERO IMAGE
                            </label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                onchange="previewThumbnail(this)" class="hidden">
                            <label for="thumbnail"
                                class="w-full py-3 bg-white rounded-lg border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-[10px] font-bold text-[#02b8f2] uppercase">Click
                                to Upload</label>
                            <div id="thumbPreview"
                                class="mt-3 {{ isset($listing) && $listing->thumbnail ? '' : 'hidden' }}">
                                @if(isset($listing) && $listing->thumbnail)
                                    <div class="relative group w-full h-32">
                                        <img src="/storage/{{ $listing->thumbnail }}"
                                            class="w-full h-full object-cover rounded-lg shadow-lg">
                                        <button type="button" onclick="removeThumbnail()"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-all shadow-md">
                                            <i class='bx bx-x'></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                                <i class='bx bx-images text-lg text-[#02b8f2]'></i> GALLERY
                            </label>
                            <input type="file" name="gallery[]" id="gallery" multiple accept="image/*"
                                onchange="handleGallerySelect(this)" class="hidden">
                            <label for="gallery"
                                class="w-full py-3 bg-white rounded-lg border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-[10px] font-bold text-[#02b8f2] uppercase">Select
                                Multiple</label>
                            <div id="galleryExisting" class="mt-3 flex flex-wrap gap-1.5">
                                @if(isset($listing) && $listing->gallery)
                                    @foreach($listing->gallery as $index => $image)
                                        <div class="relative group existing-gallery-item">
                                            <img src="/storage/{{ $image }}"
                                                class="w-16 h-12 object-cover rounded-xl border border-slate-100 shadow-sm">
                                            <button type="button" onclick="removeExistingImage(this)"
                                                class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity hover:bg-rose-600">
                                                <i class='bx bx-x'></i>
                                            </button>
                                            <input type="hidden" name="existing_gallery[]" value="{{ $image }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div id="galleryNew" class="mt-1.5 flex flex-wrap gap-1.5"></div>
                        </div>
                    </div>
                    <div class="p-6 bg-indigo-900 rounded-xl shadow-lg shadow-indigo-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                        <label class="block text-sm font-bold text-white mb-3 flex items-center gap-2 italic">
                            <i class='bx bxs-video text-2xl text-rose-400'></i> PROPERTY WALKTHROUGH
                        </label>
                        <input type="file" name="video" id="video" accept="video/*" onchange="previewVideoFile(this)"
                            class="w-full text-xs text-indigo-200 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-white file:text-indigo-900 file:font-bold hover:file:bg-indigo-50 cursor-pointer">
                        <p class="text-[10px] text-indigo-300 mt-3 font-bold uppercase tracking-wider">Accepted: MP4, MOV •
                            Max 35MB for best playback</p>
                        <div id="videoPreview" class="mt-4 {{ isset($listing) && $listing->video ? '' : 'hidden' }}">
                            @if(isset($listing) && $listing->video)
                                <div class="relative group w-full h-48">
                                    <video controls class="w-full h-full rounded-2xl shadow-lg bg-black"
                                        src="/storage/{{ $listing->video }}"></video>
                                    <button type="button" onclick="removeVideo()"
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-all shadow-md z-10">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-3 flex items-center gap-2 italic">
                            <i class='bx bx-map-alt text-lg text-[#02b8f2]'></i> FLOOR PLANS
                        </label>
                        <input type="file" name="floor_plans[]" id="floor_plans" multiple accept="image/*"
                            onchange="handleFloorPlansSelect(this)" class="hidden">
                        <label for="floor_plans"
                            class="w-full py-3 bg-white rounded-lg border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-[10px] font-bold text-[#02b8f2] uppercase">Select
                            Multiple Plans</label>
                        <div id="floorPlansExisting" class="mt-3 flex flex-wrap gap-1.5">
                            @if(isset($listing) && $listing->floor_plans)
                                @foreach($listing->floor_plans as $index => $image)
                                    <div class="relative group existing-floorplan-item">
                                        <img src="/storage/{{ $image }}"
                                            class="w-16 h-12 object-cover rounded-xl border border-slate-100 shadow-sm">
                                        <button type="button" onclick="removeExistingFloorPlan(this)"
                                            class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity hover:bg-rose-600">
                                            <i class='bx bx-x'></i>
                                        </button>
                                        <input type="hidden" name="existing_floor_plans[]" value="{{ $image }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="floorPlansNew" class="mt-1.5 flex flex-wrap gap-1.5"></div>
                    </div>

                    <!-- Brochure PDF Section -->
                    <div class="p-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <label class="block text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                            <i class='bx bxs-file-pdf text-2xl text-red-500'></i> PROPERTY BROCHURE (PDF)
                        </label>
                        <input type="file" name="brochure_pdf" id="brochure_pdf" accept="application/pdf"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-red-50 file:text-red-700 file:font-bold hover:file:bg-red-100 cursor-pointer">
                        @if(isset($listing) && $listing->brochure_pdf)
                            <div class="mt-4 flex items-center gap-3 p-3 bg-white rounded-lg border border-slate-100">
                                <i class='bx bxs-file-pdf text-xl text-red-500'></i>
                                <span class="text-xs font-bold text-slate-600">Current Brochure:</span>
                                <a href="/storage/{{ $listing->brochure_pdf }}" target="_blank"
                                    class="text-xs font-black text-indigo-600 hover:underline">View PDF</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div
                class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex justify-between rounded-b-3xl flex-shrink-0">
                <button type="button" id="prevBtn" onclick="changeStep(-1)"
                    class="hidden px-8 py-3.5 rounded-2xl border-2 border-slate-100 bg-white text-slate-700 text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Previous</button>
                <div class="flex-1 flex justify-end gap-3">
                    <a href="{{ route('admin.listings.index') }}"
                        class="px-6 py-3.5 text-slate-400 text-xs font-black uppercase tracking-widest hover:text-rose-500 transition-all flex items-center">Cancel</a>
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
            const unitTypesData = @json($unitTypes);

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

                ClassicEditor.create(document.querySelector('#description_editor')).then(editor => {
                    editorInstance = editor;
                    editor.model.document.on('change:data', () => {
                        $('#description_hidden').val(editor.getData());
                    });
                }).catch(error => console.error(error));

                $('#purpose').on('change', handlePurposeChange);
                handlePurposeChange();

                // Initial setup for edit mode
                toggleDiscountField();

                // Setup Unit Types if we have a selected value (Edit mode)
                const selectedPropertyType = $('#property_type_id').val();
                if (selectedPropertyType) {
                    const selectedUnitType = $('#unit_type_id').data('selected');
                    const validUnits = unitTypesData.filter(u => u.property_type_id == selectedPropertyType);
                    $('#unit_type_id').empty().append('<option value="">Choose Category</option>');
                    validUnits.forEach(u => $('#unit_type_id').append(new Option(u.title, u.id, false, u.id == selectedUnitType)));
                }

                const title = ($('#property_type_id option:selected').data('title') || "");
                if (title.includes('commercial') || title.includes('land')) {
                    $('#bedBathContainer').addClass('hidden');
                } else {
                    $('#bedBathContainer').removeClass('hidden');
                }

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
                        error: function (err) {
                            Swal.fire({ icon: 'error', title: 'Error', text: err.responseJSON?.message || 'Something went wrong' });
                        }
                    });
                });
            });

            function initSelect2() {
                $('.select2').select2({ minimumResultsForSearch: Infinity });
            }

            function handleTypeChange() {
                const id = $('#property_type_id').val();
                const validUnits = unitTypesData.filter(u => u.property_type_id == id);
                $('#unit_type_id').empty().append('<option value="">Choose Category</option>');
                validUnits.forEach(u => $('#unit_type_id').append(new Option(u.title, u.id)));

                const title = ($('#property_type_id option:selected').data('title') || "");
                if (title.includes('commercial') || title.includes('land')) {
                    $('#bedBathContainer').addClass('hidden');
                    $('#bedrooms, #bathrooms').val('').trigger('change');
                } else {
                    $('#bedBathContainer').removeClass('hidden');
                }
            }

            function handlePurposeChange() {
                const p = $('#purpose').val();
                if (p === 'Buy') {
                    $('#for-sale-fields').removeClass('hidden');
                    $('#to-rent-fields').addClass('hidden');
                    $('#rent_frequency_id, #cheque_id').val('').trigger('change');
                } else if (p === 'Rent') {
                    $('#to-rent-fields').removeClass('hidden');
                    $('#for-sale-fields').addClass('hidden');
                    $('#ownership_status_id').val('').trigger('change');
                } else {
                    $('#for-sale-fields, #to-rent-fields').addClass('hidden');
                }
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
                        if ($el.is(':hidden') || $el.closest('.hidden').length > 0) return;
                        let val = $el.val();
                        if (!val || val === "" || val == null) {
                            $el.addClass('border-rose-400 ring-2 ring-rose-50');
                            if ($el.hasClass('select2-hidden-accessible')) {
                                $el.next('.select2-container').addClass('border-rose-400 ring-2 ring-rose-50');
                            }
                            v = false;
                        } else {
                            $el.removeClass('border-rose-400 ring-2 ring-rose-50');
                            if ($el.hasClass('select2-hidden-accessible')) {
                                $el.next('.select2-container').removeClass('border-rose-400 ring-2 ring-rose-50');
                            }
                        }
                    });
                    if (!v) {
                        Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }).fire({ icon: 'error', title: 'Details Required', text: 'Please check marked fields' });
                        return;
                    }
                }

                currentStep += n;
                showStep(currentStep);
            }

            function showStep(n) {
                $('#stage1, #stage2, #stage3').addClass('hidden');
                $(`#stage${n}`).removeClass('hidden');

                if (n === 1) $(`#stage${n}`).addClass('form-grid');
                else $(`#stage${n}`).removeClass('form-grid');

                $('#currentStepText').text(n);
                $('#stepLine').css('width', `${(n - 1) * 50}%`);

                for (let i = 1; i <= 3; i++) {
                    const circle = $(`#stepCircle${i}`);
                    const label = $(`#stepLabel${i}`);

                    circle.removeClass('step-circle-active step-circle-completed text-slate-400 border-slate-100 bg-white');
                    label.removeClass('text-indigo-600 text-slate-300 font-black').addClass('text-slate-300');

                    if (i < n) {
                        circle.addClass('step-circle-completed').html('<i class="bx bx-check text-xl"></i>');
                        label.addClass('text-emerald-500 font-bold');
                    } else if (i === n) {
                        circle.addClass('step-circle-active').text(i);
                        label.addClass('text-indigo-600 font-black').removeClass('text-slate-300');
                    } else {
                        circle.addClass('text-slate-400 border-slate-100 bg-white').text(i);
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
        </script>
    @endpush
@endsection