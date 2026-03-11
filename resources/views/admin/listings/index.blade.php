@extends('layouts.admin')

@section('header', 'Listings Management')

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

        .select2-results__option {
            padding: 8px 12px;
            font-size: 0.875rem;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: var(--brand-blue) !important;
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

        /* Select2 Text Visibility Fix */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1e293b !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            padding-left: 4px !important;
        }

        .select2-results__option {
            color: #475569 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--brand-secondary) !important;
            color: white !important;
        }

        /* Modal Enhancement Animations */
        @keyframes modalEntry {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-animate-in {
            animation: modalEntry 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .modal-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Grid Fixes */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
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

        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 0.5rem !important;
        }
    </style>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-5">
        <div>
            <h3 class="text-slate-800 font-black text-lg tracking-tight uppercase">Manage Listings</h3>

        </div>
        <div class="flex flex-wrap items-center gap-2">
            <div id="bulkActionsBar"
                class="hidden flex items-center gap-2 bg-[#131B31] text-white px-3 py-1.5 rounded-lg shadow-lg">
                <span class="text-[9px] font-black uppercase tracking-widest mr-1 text-white/50"><span
                        id="selectedCount">0</span> Selected</span>
                <select id="bulkActionType"
                    class="bg-white/10 border-none text-[9px] font-bold rounded focus:ring-0 py-0.5 px-1 cursor-pointer">
                    <option value="" class="text-black">Actions</option>
                    <option value="approved" class="text-black">Approve</option>
                    <option value="under_offer" class="text-black">Under Offer</option>
                    <option value="sold" class="text-black">Sold</option>
                    <option value="pending" class="text-black">Set Pending</option>
                    <option value="rejected" class="text-black">Reject</option>
                    <option value="draft" class="text-black">Move to Drafts</option>
                    <option value="duplicate" class="text-black">Duplicate</option>
                    <option value="export" class="text-black">Export to CSV</option>
                    <option value="delete" class="text-black">Delete</option>
                </select>
                <button onclick="applyBulkAction()"
                    class="bg-[#8046F1] hover:opacity-90 text-white text-[9px] font-black uppercase px-3 py-1 rounded transition-all active:scale-95">Apply</button>
            </div>

            <a href="{{ route('admin.listings.export') }}" target="_blank"
                class="flex items-center gap-1.5 border bg-white border-slate-200 hover:border-emerald-400 text-slate-500 hover:text-emerald-500 px-3 py-2 rounded-lg transition-all active:scale-95">
                <i class='bx bx-export text-base'></i>
                <span class="text-[11px] font-black uppercase">Export</span>
            </a>

            <button id="filterToggle"
                class="flex items-center gap-1.5 border bg-white border-slate-200 hover:border-indigo-400 text-slate-500 hover:text-indigo-600 px-3 py-2 rounded-lg transition-all active:scale-95">
                <i class='bx bx-filter-alt text-base'></i>
                <span class="text-[11px] font-black uppercase">Filters</span>
            </button>

            <a href="{{ route('admin.listings.create') }}"
                class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2.5 px-6 rounded-lg shadow-lg shadow-purple-500/10 transition-all flex items-center gap-2 active:scale-95 uppercase tracking-widest text-[11px]">
                <i class='bx bx-plus text-base'></i> Add Listing
            </a>
        </div>
    </div>

    <div id="filtersSection" class="hidden bg-white shadow-sm rounded-xl border border-slate-100 p-5 mb-5">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Search
                    Title</label>
                <input type="text" id="filterPropertyTitle"
                    class="w-full rounded-lg border-slate-100 bg-slate-50 text-[11px] px-3 py-2 outline-none focus:bg-white focus:border-indigo-400 transition-all"
                    placeholder="Enter keywords...">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Type</label>
                <select id="filterPropertyType"
                    class="w-full rounded-lg border-slate-100 bg-slate-50 text-[11px] px-2 py-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                    <option value="">All Types</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Purpose</label>
                <select id="filterPurpose"
                    class="w-full rounded-lg border-slate-100 bg-slate-50 text-[11px] px-2 py-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                    <option value="">Any</option>
                    <option value="Buy">Buy</option>
                    <option value="Rent">Rent</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                <select id="filterStatus"
                    class="w-full rounded-lg border-slate-100 bg-slate-50 text-[11px] px-2 py-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                    <option value="">All</option>
                    <option value="approved">Approved</option>
                    <option value="under_offer">Under Offer</option>
                    <option value="sold">Sold Out</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="flex items-end gap-2 px-1">
                <button onclick="clearFilters()"
                    class="h-9 px-3 text-slate-400 hover:text-slate-600 text-[11px] font-black uppercase transition-all">Clear</button>
                <button onclick="applyFilters()"
                    class="h-9 flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-[11px] font-black uppercase shadow-lg shadow-indigo-600/10 transition-all">Filter</button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-x-auto shadow-sm">
        <div class="min-w-full">
            <table id="listingsTable" class="w-full text-[13px] text-left text-slate-500">
                <thead class="text-[10px] text-slate-400 font-black uppercase tracking-widest bg-slate-50/50">
                    <tr>
                        <th class="px-4 py-4 w-10 text-center">
                            <input type="checkbox" id="selectAll"
                                class="rounded border-slate-300 text-[#02b8f2] focus:ring-0">
                        </th>
                        <th class="px-6 py-4 font-bold">Property Details</th>
                        <th class="px-6 py-4 font-bold">Owner/Agent</th>
                        <th class="px-6 py-4 font-bold">Category</th>
                        <th class="px-6 py-4 font-bold">Valuation</th>
                        <th class="px-6 py-4 font-bold">Current Status</th>
                        <th class="px-6 py-4 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 italic-none"></tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            let table;

            function numberWithCommas(x) {
                if (x === null || x === undefined) return "0";
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            $(document).ready(function () {
                table = $('#listingsTable').DataTable({
                    ajax: {
                        url: "{{ route('admin.listings.index') }}",
                        data: function (d) {
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
                                                                                                                                                    <div class="relative group">
                                                                                                                                                        ${r.thumbnail ? `<img src="/storage/${r.thumbnail}" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-md">` : `<div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400"><i class='bx bx-building-house text-2xl'></i></div>`}
                                                                                                                                                    </div>
                                                                                                                                                    <div class="ml-4">
                                                                                                                                                        <a href="/admin/listings/${r.id}" class="font-extrabold text-slate-800 hover:text-[#02b8f2] transition-colors tracking-tight leading-tight block">${d}</a>
                                                                                                                                                        <div class="text-[10px] font-bold text-slate-400 uppercase mt-1">#${r.property_reference_number} | <span class="text-slate-500">${r.address || 'No Address'}</span></div>
                                                                                                                                                    </div>
                                                                                                                                                </div>`
                        },
                        { data: 'user.name', render: d => `<span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-wide">${d || 'System'}</span>` },
                        {
                            data: 'property_type.title', render: (d, t, r) => `
                                                                                                                                                <div class="flex flex-col">
                                                                                                                                                    <span class="text-[10px] font-black text-slate-700 uppercase">${d || 'Other'}</span>
                                                                                                                                                    <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-tighter">${r.bedrooms ? (r.bedrooms.toString().toLowerCase() === 'studio' ? 'Studio' : r.bedrooms + ' Beds') : 'N/A'}</span>
                                                                                                                                                </div>`
                        },
                        {
                            data: 'price', render: (d, t, r) => `
                                                                                                                        <div class="flex flex-col">
                                                                                                                            ${r.old_price && r.old_price > d ? `<span class="text-[10px] text-slate-400" style="text-decoration: line-through;">£${numberWithCommas(r.old_price)}</span>` : ''}
                                                                                                                            <span class="font-black text-slate-800">£${numberWithCommas(d)}</span>
                                                                                                                        </div>`
                        },
                        {
                            data: 'status', render: (d, t, r) => {
                                let color = d === 'approved' ? 'emerald' : (d === 'under_offer' ? 'indigo' : (d === 'sold' ? 'purple' : (d === 'rejected' ? 'rose' : (d === 'draft' ? 'slate' : 'amber'))));
                                return `
                                                                                                                                                     <select onchange="updateStatus(${r.id}, this.value)" class="bg-${color}-50 text-${color}-600 border border-${color}-100 rounded-lg px-2 py-1 text-[10px] font-black uppercase tracking-wider focus:ring-0 cursor-pointer">
                                                                                                                                                         <option value="pending" ${d === 'pending' ? 'selected' : ''}>Pending</option>
                                                                                                                                                         <option value="approved" ${d === 'approved' ? 'selected' : ''}>Approved</option>
                                                                                                                                                         <option value="under_offer" ${d === 'under_offer' ? 'selected' : ''}>Under Offer</option>
                                                                                                                                                         <option value="sold" ${d === 'sold' ? 'selected' : ''}>Sold</option>
                                                                                                                                                         <option value="rejected" ${d === 'rejected' ? 'selected' : ''}>Rejected</option>
                                                                                                                                                         <option value="draft" ${d === 'draft' ? 'selected' : ''}>Draft</option>
                                                                                                                                                     </select>`;
                            }
                        },
                        {
                            data: 'id', render: d => `
                                                                                                                                                <div class="flex gap-2">
                                                                                                                                                    <a href="/admin/listings/${d}/edit" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center"><i class='bx bxs-edit-alt text-lg'></i></a>
                                                                                                                                                    <button onclick="deleteListing(${d})" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center"><i class='bx bxs-trash text-lg'></i></button>
                                                                                                                                                </div>`
                        }
                    ],
                    drawCallback: function () { toggleBulkBar(); }
                });

                $('#selectAll').on('change', function () { $('.row-checkbox').prop('checked', this.checked); toggleBulkBar(); });
                $(document).on('change', '.row-checkbox', function () { toggleBulkBar(); });

                $('#filterToggle').on('click', function () { $('#filtersSection').toggleClass('hidden'); });
                $('#filtersSection input, #filtersSection select').on('keyup change', function () { table.ajax.reload(); });
            });

            function toggleBulkBar() {
                let checked = $('.row-checkbox:checked').length;
                if (checked > 0) { $('#selectedCount').text(checked); $('#bulkActionsBar').removeClass('hidden'); }
                else { $('#bulkActionsBar').addClass('hidden'); $('#selectAll').prop('checked', false); }
            }

            function updateStatus(id, status) {
                $.ajax({
                    url: `/admin/listings/${id}/status`,
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', status: status },
                    success: function (res) {
                        table.ajax.reload(null, false);
                        Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }).fire({ icon: 'success', title: 'Status synced!' });
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
                            Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Action failed', 'error');
                            table.ajax.reload(null, false);
                        }
                    }
                });
            }

            function applyBulkAction() {
                let action = $('#bulkActionType').val();
                let ids = $('.row-checkbox:checked').map(function () { return $(this).val(); }).get();
                if (!action || ids.length === 0) return;

                Swal.fire({
                    title: 'Confirm Action',
                    text: `Apply ${action} to ${ids.length} selected items?`,
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.listings.bulk-action') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: ids,
                                action: action
                            },
                            success: function (response) {
                                if (response.redirect) {
                                    window.open(response.redirect, '_blank');
                                    table.ajax.reload();
                                    $('#selectAll').prop('checked', false);
                                    toggleBulkBar();
                                } else {
                                    Swal.fire('Success', response.message, 'success');
                                    table.ajax.reload();
                                    $('#selectAll').prop('checked', false);
                                    toggleBulkBar();
                                }
                            },
                            error: function (xhr) {
                                Swal.fire('Error', xhr.responseJSON.message || 'Action failed', 'error');
                            }
                        });
                    }
                });
            }

            function deleteListing(id) {
                Swal.fire({ title: 'Delete?', text: 'Irreversible action.', icon: 'error', showCancelButton: true }).then(r => {
                    if (r.isConfirmed) $.ajax({ url: `/admin/listings/${id}`, type: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: () => table.ajax.reload() });
                });
            }

            function applyFilters() { table.ajax.reload(); }
            function clearFilters() {
                $('#filtersSection input').val('');
                $('#filtersSection select').val('');
                table.ajax.reload();
            }
        </script>
    @endpush
@endsection