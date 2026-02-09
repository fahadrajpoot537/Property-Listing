@extends('layouts.admin')

@section('header', 'Draft Off-Market Deals')

@section('content')
    <style>
        /* Modern Select2 Styling */
        .select2-container--default .select2-selection--single {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            height: 44px;
            display: flex;
            align-items: center;
            background-color: #f8fafc;
            padding-left: 8px;
            transition: all 0.2s;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50%;
            transform: translateY(-50%);
            right: 10px;
        }

        .select2-dropdown {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 4px;
        }

        /* CKEditor Customization */
        .ck-editor__encoded {
            border-radius: 0.75rem !important;
            overflow: hidden;
        }

        .ck-content {
            min-height: 200px;
            font-size: 0.875rem;
            border-radius: 0 0 0.75rem 0.75rem !important;
        }

        .ck-toolbar {
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
            background: #f8fafc !important;
        }

        /* Grid Fixes */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .full-width {
            grid-column: span 3;
        }

        @media (max-width: 1024px) {
            .full-width {
                grid-column: span 2;
            }
        }

        @media (max-width: 640px) {
            .full-width {
                grid-column: span 1;
            }
        }

        /* Google Autocomplete Suggestions fix */
        .pac-container {
            z-index: 100000 !important;
            border-radius: 1rem;
            margin-top: 5px;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            border: 1px solid #f1f5f9;
        }
        }

        @media (max-width: 1024px) {
            .full-width {
                grid-column: span 2;
            }
        }

        @media (max-width: 640px) {
            .full-width {
                grid-column: span 1;
            }
        }
    </style>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h3 class="text-slate-800 font-extrabold text-2xl tracking-tight">Draft Distress Deals</h3>
            <p class="text-slate-500 text-sm mt-1 flex items-center gap-1">
                <i class='bx bxs-bolt text-amber-500'></i> Exclusive off-market and distress deals.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div id="bulkActionsBar"
                class="hidden flex items-center gap-2 bg-black border border-slate-700 text-white px-4 py-2 rounded-2xl shadow-xl animate-in fade-in slide-in-from-top-4">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mr-2"><span
                        id="selectedCount">0</span> Selected</span>
                <select id="bulkActionType"
                    class="bg-slate-800 border-none text-[11px] font-bold rounded-lg focus:ring-0 py-1 cursor-pointer">
                    <option value="">Actions</option>
                    <option value="approved">Approve</option>
                    <option value="pending">Set Pending</option>
                    <option value="rejected">Reject</option>
                    <option value="draft">Move to Drafts</option>
                    <option value="delete">Delete</option>
                </select>
                <button onclick="applyBulkAction()"
                    class="bg-[#02b8f2] hover:opacity-90 text-white text-[11px] font-black uppercase px-4 py-1.5 rounded-lg transition-all active:scale-95">Apply</button>
            </div>

            <!-- Filters Button -->
            <button id="filterToggle"
                class="flex items-center gap-2 border-2 bg-white border-slate-200 hover:border-[#02b8f2] text-slate-600 hover:text-[#02b8f2] px-4 py-2.5 rounded-2xl transition-all active:scale-95">
                <i class='bx bx-filter text-lg'></i>
                <span class="text-sm font-bold">Filters</span>
            </button>

            <button onclick="openModal()"
                class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-3 px-8 rounded-2xl shadow-xl shadow-purple-100/50 transition-all flex items-center gap-3 active:scale-95 uppercase tracking-wider text-sm">
                <i class='bx bxs-zap text-xl text-yellow-300'></i> Add Distress Deal
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div id="filtersSection"
        class="hidden bg-white shadow-lg rounded-2xl border border-slate-100 p-6 mb-6 transition-all duration-300">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Property Title Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deal Headline</label>
                <input type="text" id="filterPropertyTitle"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                    placeholder="Search headline...">
            </div>

            <!-- Property Type Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Property Type</label>
                <select id="filterPropertyType"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all">
                    <option value="">All Types</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Purpose Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Purpose</label>
                <select id="filterPurpose"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all">
                    <option value="">All Purposes</option>
                    <option value="Buy">For Sale</option>
                    <option value="Rent">To Rent</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                <select id="filterStatus"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all">
                    <option value="">All Statuses</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <!-- Price Range Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Min Price (£)</label>
                <input type="number" id="filterMinPrice"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                    placeholder="0">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Max Price (£)</label>
                <input type="number" id="filterMaxPrice"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all"
                    placeholder="1000000">
            </div>

            <!-- Bedrooms Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bedrooms</label>
                <select id="filterBedrooms"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all">
                    <option value="">Any</option>
                    @for($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}+</option>
                    @endfor
                </select>
            </div>

            <!-- Bathrooms Filter -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bathrooms</label>
                <select id="filterBathrooms"
                    class="w-full rounded-lg border-slate-100 bg-slate-50/50 text-xs p-2 focus:ring-blue-100 focus:border-[#02b8f2] transition-all">
                    <option value="">Any</option>
                    @for($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}+</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Filter Actions -->
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
            <button onclick="clearFilters()"
                class="px-4 py-2 text-slate-600 hover:text-slate-800 text-sm font-bold rounded-lg transition-all">Clear
                All</button>
            <button onclick="applyFilters()"
                class="bg-[#02b8f2] hover:opacity-90 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all active:scale-95">Apply
                Filters</button>
        </div>
    </div>

    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 p-6 overflow-hidden">
        <table id="offMarketTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-400 uppercase bg-slate-50/50">
                <tr>
                    <th class="px-4 py-4 w-10 text-center">
                        <input type="checkbox" id="selectAll" class="rounded border-slate-300 text-[#02b8f2] focus:ring-0">
                    </th>
                    <th class="px-6 py-4 font-bold">Deal Details</th>
                    <th class="px-6 py-4 font-bold">Source</th>
                    <th class="px-6 py-4 font-bold">Type</th>
                    <th class="px-6 py-4 font-bold">Price</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 italic-none"></tbody>
        </table>
    </div>

    <!-- Distress List Modal -->
    <div id="listingModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-md transition-opacity" onclick="closeModal()"></div>

            <div
                class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all z-10 border border-white/20">
                <div class="px-8 pt-10 pb-4 flex-shrink-0">
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-purple-50 text-[#8046F1] rounded-2xl flex items-center justify-center text-2xl rotate-3 shadow-inner">
                                <i class='bx bxs-zap'></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-black tracking-tighter" id="modalTitle">New Distress
                                    Deal</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Off-Market Channel
                                    • Step <span id="currentStepText">1</span> of 3</p>
                            </div>
                        </div>
                        <button onclick="closeModal()"
                            class="w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-rose-500 hover:text-white transition-all duration-300">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>

                    <div class="relative flex items-center justify-between mb-10 px-16">
                        <div
                            class="absolute top-1/2 left-0 w-full h-1.5 bg-slate-100 -translate-y-1/2 rounded-full overflow-hidden">
                            <div id="stepLine"
                                class="w-0 h-full bg-[#8046F1] transition-all duration-1000 cubic-bezier(0.4, 0, 0.2, 1)">
                            </div>
                        </div>
                        @for($i = 1; $i <= 3; $i++)
                            <div class="relative z-10 flex flex-col items-center">
                                <div id="stepCircle{{$i}}"
                                    class="w-12 h-12 rounded-2xl bg-white border-2 border-slate-100 text-slate-400 flex items-center justify-center text-sm font-black shadow-sm transition-all duration-500">
                                    {{$i}}
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <form id="listingForm" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    <input type="hidden" id="listingId" name="id">

                    <div class="flex-1 overflow-y-auto px-8 py-2 pb-8">
                        <!-- Stage 1 -->
                        <div id="stage1" class="form-grid">
                            <div class="full-width">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deal
                                    Headline</label>
                                <input type="text" name="property_title" id="property_title"
                                    class="w-full rounded-xl border-slate-100 bg-slate-50/50 text-sm p-3 focus:ring-purple-100 focus:border-[#8046F1] transition-all"
                                    placeholder="Enter headline..." required>
                            </div>
                            <div class="full-width">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deal
                                    Location (UK Only)</label>
                                <div class="relative">
                                    <input type="text" name="address" id="address"
                                        class="w-full rounded-xl border-slate-100 bg-slate-50/50 text-sm p-3 pl-11 focus:ring-purple-100 focus:border-[#8046F1] transition-all"
                                        placeholder="Search address..." required>
                                    <i
                                        class='bx bxs-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl'></i>
                                </div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Marketing
                                    Purpose</label>
                                <select name="purpose" id="purpose" class="select2 w-full" required>
                                    <option value="Rent">To Rent</option>
                                    <option value="Buy">For Sale</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Distress
                                    Price (£)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="price" id="price"
                                        class="w-full rounded-xl border-slate-100 bg-slate-50/50 text-sm p-3 pl-8 focus:ring-purple-100 focus:border-[#8046F1] transition-all"
                                        placeholder="0.00" required>
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">£</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deal
                                    Status</label>
                                <select name="status" id="status" class="select2 w-full" required>
                                    <option value="pending">Pending Review</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <!-- Conditional Fields -->
                            <div id="for-sale-fields" class="hidden full-width">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-1">
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ownership
                                            Status</label>
                                        <select name="ownership_status_id" id="ownership_status_id" class="select2 w-full">
                                            <option value="">Select Ownership</option>
                                            @foreach($ownershipStatuses as $os)
                                                <option value="{{ $os->id }}">{{ $os->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="to-rent-fields" class="hidden full-width">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-1">
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rent
                                            Frequency</label>
                                        <select name="rent_frequency_id" id="rent_frequency_id" class="select2 w-full">
                                            <option value="">Select Frequency</option>
                                            @foreach($rentFrequencies as $rf)
                                                <option value="{{ $rf->id }}">{{ $rf->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cheques
                                            Required</label>
                                        <select name="cheque_id" id="cheque_id" class="select2 w-full">
                                            <option value="">Select Cheques</option>
                                            @foreach($cheques as $c)
                                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prop
                                    Type</label>
                                <select name="property_type_id" id="property_type_id" onchange="handleTypeChange()"
                                    class="select2 w-full" required>
                                    <option value="">Select Type</option>
                                    @foreach($propertyTypes as $type) <option value="{{ $type->id }}"
                                    data-title="{{ strtolower($type->title) }}">{{ $type->title }}</option> @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Category</label>
                                <select name="unit_type_id" id="unit_type_id" class="select2 w-full" required>
                                    <option value="">Choose Unit Type</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Area (Sq
                                    Ft)</label>
                                <input type="text" name="area_size" id="area_size"
                                    class="w-full rounded-xl border-slate-100 bg-slate-50/50 text-sm p-3 focus:ring-purple-100 focus:border-[#8046F1] transition-all"
                                    placeholder="e.g. 1500" required>
                            </div>
                            <div id="bedBathContainer">
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bedrooms</label>
                                <select name="bedrooms" id="bedrooms" class="select2 w-full" required>
                                    @for($i = 0; $i <= 100; $i++)
                                        <option value="{{ $i }}">{{ $i }} Bed{{$i > 1 ? 's' : ''}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bathrooms</label>
                                <select name="bathrooms" id="bathrooms" class="select2 w-full" required>
                                    @for($i = 0; $i <= 100; $i++)
                                        <option value="{{ $i }}">{{ $i }} Bath{{$i > 1 ? 's' : ''}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="full-width">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Internal
                                    Notes / Description</label>
                                <textarea id="description_editor" class="w-full rounded-xl" rows="6"></textarea>
                                <input type="hidden" name="description" id="description_hidden">
                            </div>

                            <!-- Stage 1 Buttons -->
                            <div class="full-width pt-6">
                                <div class="flex justify-between items-center">
                                    <div></div> <!-- Empty div for spacing -->
                                    <div class="flex gap-3">
                                        <button type="button" onclick="saveAsDraft()"
                                            class="px-8 py-3 rounded-2xl bg-amber-500 text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-amber-100/30 active:scale-95 transition-all">Save
                                            Draft</button>
                                        <button type="button" id="nextBtn" onclick="changeStep(1)"
                                            class="px-8 py-3 rounded-2xl bg-[#8046F1] text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-purple-100/30 active:scale-95 transition-all">Next
                                            Stage</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stage 2 -->
                        <div id="stage2" class="hidden">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-6">Deal
                                Features & Specifics</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                                @foreach($features as $feature)
                                    <label
                                        class="group relative flex items-center p-3 bg-slate-50 rounded-xl border border-slate-100 hover:border-purple-100 hover:bg-white transition-all cursor-pointer">
                                        <input id="feat_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}"
                                            type="checkbox"
                                            class="h-4 w-4 text-[#8046F1] rounded border-slate-300 focus:ring-0">
                                        <span
                                            class="ml-2 text-[11px] font-bold text-slate-600 uppercase tracking-tighter">{{ $feature->title }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Stage 2 Buttons -->
                            <div class="full-width pt-8">
                                <div class="flex justify-between items-center">
                                    <button type="button" id="prevBtn" onclick="changeStep(-1)"
                                        class="px-8 py-3 rounded-2xl border-2 border-slate-100 bg-white text-slate-700 text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Previous</button>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="saveAsDraft()"
                                            class="px-8 py-3 rounded-2xl bg-amber-500 text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-amber-100/30 active:scale-95 transition-all">Save
                                            Draft</button>
                                        <button type="button" id="nextBtn2" onclick="changeStep(1)"
                                            class="px-8 py-3 rounded-2xl bg-[#8046F1] text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-purple-100/30 active:scale-95 transition-all">Next
                                            Stage</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stage 3 -->
                        <div id="stage3" class="hidden space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="p-6 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                                    <label
                                        class="block text-sm font-black text-slate-700 mb-4 italic flex items-center gap-2">
                                        <i class='bx bx-image-add text-xl text-[#02b8f2]'></i> MAIN ASSET
                                    </label>
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                        onchange="previewImage(this, 'thumbPreview')" class="hidden">
                                    <label for="thumbnail"
                                        class="w-full py-4 bg-white rounded-2xl border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-xs font-black text-[#02b8f2]">UPLOAD
                                        PHOTO</label>
                                    <div id="thumbPreview" class="mt-4 hidden"><img src=""
                                            class="w-full h-40 object-cover rounded-2xl shadow-lg"></div>
                                </div>
                                <div class="p-6 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                                    <label
                                        class="block text-sm font-black text-slate-700 mb-4 italic flex items-center gap-2">
                                        <i class='bx bx-images text-xl text-[#02b8f2]'></i> EVIDENCE
                                    </label>
                                    <input type="file" name="gallery[]" id="gallery" multiple accept="image/*"
                                        onchange="previewGallery(this, 'galleryPreview')" class="hidden">
                                    <label for="gallery"
                                        class="w-full py-4 bg-white rounded-2xl border border-slate-100 text-center cursor-pointer hover:shadow-md transition-all block text-xs font-black text-[#02b8f2]">UPLOAD
                                        MULTIPLE</label>
                                    <div id="galleryPreview" class="mt-4 flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                            <div class="p-8 bg-slate-900 rounded-3xl shadow-xl shadow-slate-100 relative overflow-hidden">
                                <label class="block text-lg font-black text-white mb-4 flex items-center gap-2 italic">
                                    <i class='bx bxs-video-recording text-2xl text-rose-500'></i> DEAL WALKTHROUGH
                                </label>
                                <input type="file" name="video" id="video" accept="video/*"
                                    class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-6 file:rounded-xl file:border-0 file:bg-indigo-600 file:text-white file:font-black hover:file:bg-indigo-500 cursor-pointer">
                                <p class="text-[10px] text-slate-500 mt-3 font-bold uppercase tracking-wider">Accepted: MP4,
                                    MOV • Keep files under 20MB for best results</p>
                            </div>

                            <!-- Stage 3 Buttons -->
                            <div class="full-width pt-8">
                                <div class="flex justify-between items-center">
                                    <button type="button" id="prevBtn2" onclick="changeStep(-1)"
                                        class="px-8 py-3 rounded-2xl border-2 border-slate-100 bg-white text-slate-700 text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Previous</button>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="saveAsDraft()"
                                            class="px-8 py-3 rounded-2xl bg-amber-500 text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-amber-100/30 active:scale-95 transition-all">Save
                                            Draft</button>
                                        <button type="submit" id="submitBtn"
                                            class="px-8 py-3 rounded-2xl bg-[#131B31] text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-slate-900/10 active:scale-95 transition-all">Publish
                                            Deal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initAutocomplete"></script>
        <script>
            let autocomplete; let currentStep = 1; let table; let editorInstance;
            const unitTypesData = @json($unitTypes);

            $(document).ready(function () {
                initSelect2();
                initCKEditor();

                table = $('#offMarketTable').DataTable({
                    ajax: {
                        url: "{{ route('admin.off-market-listings.drafts') }}",
                        data: function (d) {
                            d.is_draft = 1;
                            d.filters = {
                                property_title: $('#filterPropertyTitle').val(),
                                property_type_id: $('#filterPropertyType').val(),
                                purpose: $('#filterPurpose').val(),
                                status: $('#filterStatus').val(),
                                min_price: $('#filterMinPrice').val(),
                                max_price: $('#filterMaxPrice').val(),
                                bedrooms: $('#filterBedrooms').val(),
                                bathrooms: $('#filterBathrooms').val()
                            };
                        }
                    },
                    responsive: true,
                    columns: [
                        { data: 'id', orderable: false, className: 'text-center', render: d => `<input type="checkbox" class="row-checkbox rounded-md border-slate-300 text-[#02b8f2] focus:ring-0" value="${d}">` },
                        {
                            data: 'property_title', render: (d, t, r) => `
                                                                                                                                                            <div class="flex items-center py-2">
                                                                                                                                                                ${r.thumbnail ? `<img src="/storage/${r.thumbnail}" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-md">` : `<div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400"><i class='bx bx-landscape text-2xl'></i></div>`}
                                                                                                                                                                <div class="ml-4">
                                                                                                                                                    <a href="/admin/off-market-listings/${r.id}" class="font-extrabold text-slate-800 hover:text-[#02b8f2] transition-colors tracking-tight leading-tight block">${d}</a>
                                                                                                                                                    <div class="text-[10px] font-bold text-slate-400 uppercase mt-1">Ref: ${r.property_reference_number}</div>
                                                                                                                                                </div>
                                                                                                                                            </div>`
                        },
                        { data: 'user.name', render: d => `<span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-[10px] font-black uppercase">${d}</span>` },
                        {
                            data: 'property_type.title', render: (d, t, r) => `
                                                                                                                                                            <div class="flex flex-col">
                                                                                                                                                                <span class="text-[10px] font-black text-[#02b8f2] uppercase tracked-widest">${d}</span>
                                                                                                                                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">${r.unit_type ? r.unit_type.title : 'Deal'}</span>
                                                                                                                                                            </div>`
                        },
                        { data: 'price', render: d => `<span class="font-black text-slate-800">£${numberWithCommas(d)}</span>` },
                        {
                            data: 'status', render: (d, t, r) => {
                                let color = d === 'approved' ? 'emerald' : (d === 'rejected' ? 'rose' : 'amber');
                                return `
                                                                                                                                                                <select onchange="updateStatus(${r.id}, this.value)" class="bg-${color}-50 text-${color}-600 border border-${color}-100 rounded-lg px-2 py-1 text-[10px] font-black uppercase focus:ring-0 cursor-pointer">
                                                                                                                                                                    <option value="pending" ${d === 'pending' ? 'selected' : ''}>Pending</option>
                                                                                                                                                                    <option value="approved" ${d === 'approved' ? 'selected' : ''}>Approved</option>
                                                                                                                                                                    <option value="rejected" ${d === 'rejected' ? 'selected' : ''}>Rejected</option>
                                                                                                                                                                    <option value="draft" ${d === 'draft' ? 'selected' : ''}>Draft</option>
                                                                                                                                                                </select>`;
                            }
                        },
                        {
                            data: 'id', render: d => `
                                                                                                                                                            <div class="flex gap-2">
                                                                                                                                                                <button onclick="editListing(${d})" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-900 hover:text-white transition-all flex items-center justify-center"><i class='bx bxs-edit-alt text-lg'></i></button>
                                                                                                                                                                <button onclick="deleteListing(${d})" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center"><i class='bx bxs-trash text-lg'></i></button>
                                                                                                                                                            </div>`
                        }
                    ],
                    drawCallback: function () { toggleBulkBar(); }
                });

                $('#purpose').on('change', handlePurposeChange);
                handlePurposeChange();

                $('#selectAll').on('change', function () { $('.row-checkbox').prop('checked', this.checked); toggleBulkBar(); });
                $(document).on('change', '.row-checkbox', function () { toggleBulkBar(); });

                $('#listingForm').submit(function (e) {
                    e.preventDefault();
                    if (editorInstance) { $('#description_hidden').val(editorInstance.getData()); }
                    var id = $('#listingId').val();
                    var formData = new FormData(this);
                    formData.delete('description');
                    formData.append('description', $('#description_hidden').val());
                    if (id) formData.append('_method', 'PUT');

                    // Debug: Log remove_gallery data
                    console.log('remove_gallery data:');
                    for (var pair of formData.entries()) {
                        if (pair[0] === 'remove_gallery[]') {
                            console.log(pair[0], pair[1]);
                        }
                    }

                    Swal.fire({ title: 'Processing Deal...', didOpen: () => Swal.showLoading() });
                    $.ajax({
                        url: id ? `/admin/off-market-listings/${id}` : "{{ route('admin.off-market-listings.store') }}",
                        type: 'POST', data: formData, processData: false, contentType: false,
                        success: (res) => { closeModal(); table.ajax.reload(); Swal.fire('Saved!', res.message, 'success'); },
                        error: (xhr) => {
                            let msg = 'Action failed.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                            Swal.fire({ icon: 'error', title: 'Error', html: msg });
                        }
                    });
                });
            });

            function saveAsDraft() {
                if (editorInstance) { $('#description_hidden').val(editorInstance.getData()); }
                var id = $('#listingId').val();
                var formData = new FormData($('#listingForm')[0]);
                formData.delete('description');
                formData.append('description', $('#description_hidden').val());
                formData.append('is_draft', "1");
                if (id) formData.append('_method', 'PUT');

                Swal.fire({ title: 'Saving Draft...', didOpen: () => Swal.showLoading() });
                $.ajax({
                    url: id ? `/admin/off-market-listings/${id}` : "{{ route('admin.off-market-listings.store') }}",
                    type: 'POST', data: formData, processData: false, contentType: false,
                    success: (res) => { closeModal(); if (table) table.ajax.reload(); Swal.fire('Saved!', 'Deal saved as draft.', 'success'); },
                    error: (xhr) => {
                        let msg = 'Technical error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        Swal.fire({ icon: 'error', title: 'Action Failed', html: msg });
                    }
                });
            }

            function initSelect2() { $('.select2').select2({ dropdownParent: $('#listingModal'), width: '100%' }); }
            function initCKEditor() {
                ClassicEditor.create(document.querySelector('#description_editor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                    placeholder: 'Enter deal specifics, financials, and exit strategy details...'
                }).then(newEditor => { editorInstance = newEditor; }).catch(err => { console.error(err); });
            }

            function handleTypeChange() { toggleUnitTypes(); toggleBedBathFields(); }

            function toggleUnitTypes(selectedUnitId = null) {
                const propTypeId = $('#property_type_id').val();
                const unitSelect = $('#unit_type_id');
                unitSelect.empty().append('<option value="">Choose Unit Type</option>');
                if (propTypeId) {
                    const filtered = unitTypesData.filter(u => u.property_type_id == propTypeId);
                    filtered.forEach(u => {
                        const selected = (selectedUnitId == u.id) ? 'selected' : '';
                        unitSelect.append(`<option value="${u.id}" ${selected}>${u.title}</option>`);
                    });
                }
                unitSelect.trigger('change');
            }

            function handlePurposeChange() {
                const purpose = $('#purpose').val();
                if (purpose === 'Buy') {
                    $('#for-sale-fields').removeClass('hidden');
                    $('#to-rent-fields').addClass('hidden');
                    $('#rent_frequency_id, #cheque_id').val('').trigger('change');
                } else if (purpose === 'Rent') {
                    $('#to-rent-fields').removeClass('hidden');
                    $('#for-sale-fields').addClass('hidden');
                    $('#ownership_status_id').val('').trigger('change');
                } else {
                    $('#for-sale-fields, #to-rent-fields').addClass('hidden');
                }
            }

            function toggleBedBathFields() {
                const title = ($('#property_type_id option:selected').data('title') || "");
                if (title.includes('commercial') || title.includes('land')) {
                    $('#bedBathContainer').addClass('hidden');
                    $('#bedrooms, #bathrooms').val(0).trigger('change');
                } else {
                    $('#bedBathContainer').removeClass('hidden');
                }
            }

            function initAutocomplete() {
                // Initialize autocomplete after a small delay to ensure DOM is ready
                setTimeout(() => {
                    const input = document.getElementById("address");
                    if (!input) return;
                    const options = { componentRestrictions: { country: "gb" }, fields: ["geometry", "name"] };
                    autocomplete = new google.maps.places.Autocomplete(input, options);
                    autocomplete.addListener("place_changed", () => {
                        const p = autocomplete.getPlace();
                        if (p.geometry) {
                            $('#latitude').val(p.geometry.location.lat());
                            $('#longitude').val(p.geometry.location.lng());
                        }
                    });
                }, 500);
            }
            window.initAutocomplete = initAutocomplete;

            function changeStep(n) {
                if (n > 0) {
                    let v = true;
                    // Validate only the required fields in the current stage
                    $(`#stage${currentStep} [required]`).each(function () {
                        const $el = $(this);

                        // Skip validation if the field or its parent container is hidden
                        if ($el.is(':hidden') || $el.closest('.hidden').length > 0) return;

                        let val = $el.val();
                        const isSelect2 = $el.hasClass('select2-hidden-accessible');
                        const target = isSelect2 ? $el.next('.select2-container') : $el;

                        if (!val || val === "" || val == null) {
                            target.addClass('border-rose-400 ring-2 ring-rose-50');
                            v = false;
                        } else {
                            target.removeClass('border-rose-400 ring-2 ring-rose-50');
                        }
                    });
                    if (!v) {
                        Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }).fire({ icon: 'error', title: 'Details Required', text: 'Please check marked fields' });
                        return;
                    }
                }
                currentStep += n; showStep(currentStep);
            }

            function showStep(n) {
                // Hide all stages
                $('#stage1, #stage2, #stage3').addClass('hidden');

                // Show current stage
                const $currentStage = $(`#stage${n}`);
                $currentStage.removeClass('hidden');

                // Apply specific layout classes based on stage
                if (n === 1) {
                    $currentStage.addClass('form-grid');
                } else {
                    $currentStage.removeClass('form-grid');
                }

                $('#currentStepText').text(n);
                $('#stepLine').css('width', `${(n - 1) * 50}%`);

                // Update step circles
                for (let i = 1; i <= 3; i++) {
                    const c = $(`#stepCircle${i}`);
                    if (i <= n) {
                        c.html(`<i class='bx bx-check'></i>`).addClass('bg-[#8046F1] border-[#8046F1] text-white shadow-lg shadow-purple-100').removeClass('border-slate-100 text-slate-400');
                    } else {
                        c.html(i).removeClass('bg-[#8046F1] border-[#8046F1] text-white shadow-lg shadow-purple-100').addClass('bg-white border-slate-100 text-slate-400');
                    }
                }
            }

            function toggleBulkBar() {
                let checked = $('.row-checkbox:checked').length;
                if (checked > 0) { $('#selectedCount').text(checked); $('#bulkActionsBar').removeClass('hidden'); }
                else { $('#bulkActionsBar').addClass('hidden'); $('#selectAll').prop('checked', false); }
            }

            function updateStatus(id, status) {
                $.post(`/admin/off-market-listings/${id}/status`, { _token: '{{ csrf_token() }}', status: status }, res => {
                    table.ajax.reload(null, false);
                    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }).fire({ icon: 'success', title: 'Deal status synced!' });
                });
            }

            function applyBulkAction() {
                let action = $('#bulkActionType').val();
                let ids = $('.row-checkbox:checked').map(function () { return $(this).val(); }).get();
                if (!action || ids.length === 0) return;
                Swal.fire({ title: 'Bulk Process', text: `Apply ${action} to ${ids.length} items?`, icon: 'warning', showCancelButton: true }).then(r => {
                    if (r.isConfirmed) $.post("{{ route('admin.off-market-listings.bulk-action') }}", { _token: '{{ csrf_token() }}', ids: ids, action: action }, () => { table.ajax.reload(); $('#selectAll').prop('checked', false); toggleBulkBar(); });
                });
            }

            function openModal() {
                $('#listingForm')[0].reset(); $('#listingId').val(''); $('#thumbPreview, #galleryPreview').addClass('hidden').html('');
                $('.select2').val('').trigger('change');
                if (editorInstance) editorInstance.setData('');
                currentStep = 1;
                showStep(1);
                $('#modalTitle').text('New Distress Deal');
                $('#listingModal').removeClass('hidden');
                handleTypeChange();

                // Reinitialize autocomplete when modal opens
                setTimeout(() => {
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
                }, 300);
            }

            function closeModal() { $('#listingModal').addClass('hidden'); }

            function editListing(id) {
                $.get(`/admin/off-market-listings/${id}/edit`, function (d) {
                    $('#listingId').val(d.id); $('#property_title').val(d.property_title); $('#purpose').val(d.purpose).trigger('change');
                    $('#price').val(d.price); $('#area_size').val(d.area_size);
                    $('#property_type_id').val(d.property_type_id).trigger('change');
                    toggleUnitTypes(d.unit_type_id);
                    $('#bedrooms').val(d.bedrooms).trigger('change'); $('#bathrooms').val(d.bathrooms).trigger('change');
                    if (editorInstance) editorInstance.setData(d.description || '');
                    $('#address').val(d.address); $('#latitude').val(d.latitude); $('#longitude').val(d.longitude);
                    $('#status').val(d.status).trigger('change');
                    $('input[type=checkbox]').prop('checked', false); if (d.features) d.features.forEach(f => $(`#feat_${f.id}`).prop('checked', true));
                    if (d.thumbnail) { $('#thumbPreview').removeClass('hidden').find('img').attr('src', '/storage/' + d.thumbnail); }

                    // Handle gallery preview for existing images
                    if (d.gallery && Array.isArray(d.gallery)) {
                        const galleryPreview = $('#galleryPreview').html('');
                        d.gallery.forEach((image, index) => {
                            galleryPreview.append(`
                                                                        <div class="relative group">
                                                                            <img src="/storage/${image}" class="w-16 h-12 object-cover rounded-xl border border-slate-100 shadow-sm">
                                                                            <button type="button" onclick="removeExistingImage(${index})" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity hover:bg-rose-600">
                                                                                <i class='bx bx-x'></i>
                                                                            </button>
                                                                            <input type="hidden" name="existing_gallery[]" value="${image}">
                                                                        </div>
                                                                    `);
                        });
                    }

                    // Set IDs for new dropdowns
                    $('#ownership_status_id').val(d.ownership_status_id).trigger('change');
                    $('#rent_frequency_id').val(d.rent_frequency_id).trigger('change');
                    $('#cheque_id').val(d.cheque_id).trigger('change');
                    handlePurposeChange();

                    $('#modalTitle').text('Modify Deal'); currentStep = 1; showStep(1); $('#listingModal').removeClass('hidden');
                    toggleBedBathFields(); // Call this instead of handleTypeChange to avoid clearing unit type

                    // Reinitialize autocomplete when editing
                    setTimeout(() => {
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
                    }, 300);
                });
            }

            function deleteListing(id) {
                Swal.fire({ title: 'Delete?', text: 'Irreversible action.', icon: 'error', showCancelButton: true }).then(r => {
                    if (r.isConfirmed) $.ajax({ url: `/admin/off-market-listings/${id}`, type: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: () => table.ajax.reload() });
                });
            }

            function previewImage(input, targetId) { if (input.files && input.files[0]) { const reader = new FileReader(); reader.onload = e => $(`#${targetId}`).removeClass('hidden').find('img').attr('src', e.target.result); reader.readAsDataURL(input.files[0]); } }
            function previewGallery(input, targetId) { const t = $(`#${targetId}`).html(''); if (input.files) Array.from(input.files).forEach(f => { const r = new FileReader(); r.onload = e => t.append(`<img src="${e.target.result}" class="w-16 h-12 object-cover rounded-xl border border-slate-100 shadow-sm">`); r.readAsDataURL(f); }); }
            function removeExistingImage(index) {
                // Remove the image container
                $(`#galleryPreview .relative`).eq(index).remove();

                // Add the image path to the remove_gallery hidden input
                const hiddenInput = $(`input[name="existing_gallery[]"]`).eq(index);
                const imageValue = hiddenInput.val();

                // Create or update the remove_gallery input
                let removeInput = $('input[name="remove_gallery[]"]');
                if (removeInput.length === 0) {
                    $('#listingForm').append(`<input type="hidden" name="remove_gallery[]" value="${imageValue}">`);
                } else {
                    // Check if this image is already marked for removal
                    let existingValues = [];
                    removeInput.each(function () {
                        existingValues.push($(this).val());
                    });
                    if (!existingValues.includes(imageValue)) {
                        $('#listingForm').append(`<input type="hidden" name="remove_gallery[]" value="${imageValue}">`);
                    }
                }
            }

            // Filter functions
            $(document).ready(function () {
                // Filter toggle button
                $('#filterToggle').on('click', function () {
                    $('#filtersSection').toggleClass('hidden');

                    // Add smooth animation for filters appearance
                    if (!$('#filtersSection').hasClass('hidden')) {
                        $('html, body').animate({
                            scrollTop: $('#filtersSection').offset().top - 80
                        }, 500);
                    }
                });

                // Handle filter change to trigger search
                $('#filtersSection input, #filtersSection select').on('keyup change', function () {
                    table.ajax.reload();
                });
            });

            // Apply filters to DataTable
            function applyFilters() {
                table.ajax.reload();
                $('html, body').animate({
                    scrollTop: $('#offMarketTable').offset().top - 80
                }, 500);
            }

            function clearFilters() {
                $('#filterPropertyTitle').val('');
                $('#filterPropertyType').val('');
                $('#filterPurpose').val('');
                $('#filterStatus').val('');
                $('#filterMinPrice').val('');
                $('#filterMaxPrice').val('');
                $('#filterBedrooms').val('');
                $('#filterBathrooms').val('');
                table.ajax.reload();

                $('html, body').animate({
                    scrollTop: $('#offMarketTable').offset().top - 80
                }, 500);
            }
            function numberWithCommas(x) { return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }
        </script>
    @endpush
@endsection