@extends('layouts.admin')

@section('header', 'Affiliate Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600 font-black uppercase tracking-widest text-sm">Partner Network</h3>
        <div class="flex gap-2">
            @can('partner.settings')
                <button onclick="openSettingsModal()"
                    class="bg-white hover:bg-slate-50 text-slate-600 font-bold py-2.5 px-6 rounded-xl shadow-sm border border-slate-200 transition-all flex items-center gap-2">
                    <i class='bx bxs-cog'></i> Global Settings
                </button>
            @endcan
            <button onclick="openModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                <i class='bx bx-plus-circle'></i> Onboard New Partner
            </button>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6">
        <table id="affiliatesTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-4 font-black">User / Identity</th>
                    <th class="px-6 py-4 font-black">Referral Code</th>
                    <th class="px-6 py-4 font-black">Unique Visitors</th>
                    <th class="px-6 py-4 font-black">Bonus Payout</th>
                    <th class="px-6 py-4 font-black">Status</th>
                    <th class="px-6 py-4 font-black">Operations</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Affiliate Modal -->
    <div id="affiliateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Create New Affiliate</h3>
                    <form id="affiliateForm" class="mt-4">
                        @csrf
                        <input type="hidden" id="affiliateId" name="id">

                        <!-- Create Mode: Select User -->
                        <div class="mb-4" id="userSelectGroup">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                            <select name="user_id" id="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Edit Mode: Show User Name (Readonly) -->
                        <div class="mb-4 hidden" id="userNameGroup">
                            <label class="block text-sm font-medium text-gray-700">User</label>
                            <input type="text" id="displayUserName"
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 sm:text-sm border p-2"
                                disabled>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="flex justify-end pt-4 border-t">
                            <button type="button" onclick="closeModal()"
                                class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeSettingsModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Affiliate Global Settings</h3>
                    <form action="{{ route('admin.affiliates.update-settings') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="affiliate_rate" class="block text-sm font-medium text-gray-700">Payment Amount
                                ($)</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="affiliate_rate" id="affiliate_rate" step="0.01" min="0"
                                    value="{{ $settings['rate'] }}"
                                    class="block w-full rounded-md border-gray-300 pl-7 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                    required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Amount to pay per batch of unique visitors.</p>
                        </div>

                        <div class="mb-4">
                            <label for="affiliate_batch_size" class="block text-sm font-medium text-gray-700">Batch Size
                                (Visitors)</label>
                            <input type="number" name="affiliate_batch_size" id="affiliate_batch_size" step="1" min="1"
                                value="{{ $settings['batch_size'] }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                            <p class="mt-1 text-xs text-gray-500">Number of unique visitors required to trigger the payment
                                amount.</p>
                        </div>

                        <div class="flex justify-end pt-4 border-t">
                            <button type="button" onclick="closeSettingsModal()"
                                class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save
                                Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                var table = $('#affiliatesTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('admin.affiliates.index') }}",
                    columns: [
                        {
                            data: 'user.name', name: 'user.name', render: function (data, type, row) {
                                return `<div class="font-medium text-slate-800">${data}</div><div class="text-xs text-slate-500">${row.user.email}</div>`;
                            }
                        },
                        {
                            data: 'referral_code', name: 'referral_code', render: function (data) {
                                return `<code class="bg-indigo-50 px-3 py-1 rounded-lg text-indigo-600 font-mono text-[10px] font-black tracking-wider border border-indigo-100">${data}</code>`;
                            }
                        },
                        {
                            data: 'visitor_analytics_count', name: 'visitor_analytics_count', render: function (data) {
                                return `<div class="flex items-center gap-2 font-black text-slate-800"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> ${data} Hits</div>`;
                            }
                        },
                        {
                            data: 'total_earnings', name: 'total_earnings', render: function (data, type, row) {
                                let batchSize = {{ $settings['batch_size'] }};
                                let rate = {{ $settings['rate'] }};
                                let calculated = (row.visitor_analytics_count / batchSize) * rate;
                                return `<span class="font-black text-emerald-600">£${calculated.toFixed(2)}</span>`;
                            }
                        },
                        {
                            data: 'status', name: 'status', render: function (data) {
                                let color = data === 'active' ? 'emerald' : (data === 'inactive' ? 'rose' : 'amber');
                                return `<span class="bg-${color}-50 text-${color}-600 rounded-lg px-3 py-1 text-[10px] font-black uppercase tracking-widest border border-${color}-100">${data}</span>`;
                            }
                        },
                        {
                            data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data, type, row) {
                                return `
                                                                    <div class="flex gap-2">
                                                                        <a href="/admin/affiliates/${data}/visitors" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all border border-transparent hover:border-blue-100" title="Analytics Tree"><i class='bx bx-search-alt text-xl'></i></a>
                                                                        <button onclick="editAffiliate(${data})" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all border border-transparent hover:border-indigo-100" title="Manage Status"><i class='bx bxs-edit-alt text-xl'></i></button>
                                                                        <button onclick="deleteAffiliate(${data})" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all border border-transparent hover:border-rose-100" title="Terminate"><i class='bx bxs-trash-alt text-xl'></i></button>
                                                                    </div>
                                                                `;
                            }
                        }
                    ]
                });

                // Form Submit
                $('#affiliateForm').submit(function (e) {
                    e.preventDefault();
                    var id = $('#affiliateId').val();
                    var url = id ? `/admin/affiliates/${id}` : "{{ route('admin.affiliates.store') }}";
                    var method = id ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        type: method,
                        data: $(this).serialize(),
                        success: function (response) {
                            closeModal();
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function (key, value) {
                                errorMessage += value[0] + '\n';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage || 'Something went wrong!',
                            });
                        }
                    });
                });
            });

            function openModal() {
                $('#affiliateForm')[0].reset();
                $('#affiliateId').val('');
                $('#modalTitle').text('Create New Affiliate');

                // Show select, hide display
                $('#userSelectGroup').removeClass('hidden');
                $('#userNameGroup').addClass('hidden');
                $('#user_id').prop('required', true);

                $('#affiliateModal').removeClass('hidden');
            }

            function closeModal() {
                $('#affiliateModal').addClass('hidden');
            }

            function editAffiliate(id) {
                $.get(`/admin/affiliates/${id}/edit`, function (data) {
                    $('#affiliateId').val(data.id);
                    $('#status').val(data.status);

                    // Hide select, show display
                    $('#userSelectGroup').addClass('hidden');
                    $('#user_id').prop('required', false);

                    $('#userNameGroup').removeClass('hidden');
                    $('#displayUserName').val(data.user.name + ' (' + data.user.email + ')');

                    $('#modalTitle').text('Edit Affiliate Status');
                    $('#affiliateModal').removeClass('hidden');
                });
            }

            function deleteAffiliate(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/affiliates/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                $('#affiliatesTable').DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }

            function openSettingsModal() {
                $('#settingsModal').removeClass('hidden');
            }

            function closeSettingsModal() {
                $('#settingsModal').addClass('hidden');
            }
        </script>
    @endpush
@endsection