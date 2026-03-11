@extends('layouts.admin')

@section('header', auth()->user()->hasRole('Agency') ? 'Team Management' : 'Users Management')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-slate-800 font-black text-lg tracking-tight uppercase">
            {{ auth()->user()->hasRole('Agency') ? 'My Team' : 'User Base' }}
        </h3>
        <div class="flex gap-3">
            <button onclick="exportUsers()"
                class="bg-emerald-500 hover:bg-emerald-600 text-white font-black py-2 px-5 rounded-lg shadow-lg shadow-emerald-500/10 transition-all flex items-center gap-2 active:scale-95 text-[10px] uppercase tracking-widest">
                <i class='bx bx-export text-base'></i> Export CSV
            </button>
            <button onclick="openModal()"
                class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2 px-5 rounded-lg shadow-lg shadow-purple-500/10 transition-all flex items-center gap-2 active:scale-95 text-[10px] uppercase tracking-widest">
                <i class='bx bx-plus text-base'></i>
                {{ auth()->user()->hasRole('Agency') ? 'Add Member' : 'Create User' }}
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white border border-slate-100 p-4 mb-5 rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-3">
            <div class="col-span-1 md:col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Search
                    User</label>
                <div class="relative">
                    <input type="text" id="customSearch" placeholder="Name, email or phone..."
                        class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-200 bg-slate-50 text-[11px] focus:bg-white focus:border-indigo-400 outline-none transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class='bx bx-search text-base'></i>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Role</label>
                <select id="roleFilter"
                    class="w-full rounded-lg border-slate-200 bg-slate-50 text-[11px] py-2 px-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            @if(auth()->user()->hasRole('admin'))
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Agency</label>
                    <select id="agencyFilter"
                        class="w-full rounded-lg border-slate-200 bg-slate-50 text-[11px] py-2 px-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                        <option value="">All Agencies</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                <select id="statusFilter"
                    class="w-full rounded-lg border-slate-200 bg-slate-50 text-[11px] py-2 px-2 outline-none focus:bg-white focus:border-indigo-400 transition-all">
                    <option value="">All Statuses</option>
                    <option value="approved">Approved</option>
                    <option value="document_approved">Document Approved</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 p-0 shadow-sm overflow-hidden">
        <table id="usersTable" class="w-full text-[13px] text-left text-slate-500">
            <thead class="text-xs text-slate-400 font-bold uppercase tracking-widest bg-slate-50/50">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">User Profile</th>
                    <th class="px-5 py-3">Auth Details</th>
                    <th class="px-5 py-3">Classification</th>
                    <th class="px-5 py-3">Lifecycle</th>
                    <th class="px-5 py-3">Manage</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50"></tbody>
        </table>
    </div>

    <!-- User Modal -->
    <div id="userModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Create New User</h3>
                    <form id="userForm" class="mt-4">
                        @csrf
                        <input type="hidden" id="userId" name="id">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                        </div>
                        <div class="mb-4 @if(auth()->user()->hasRole('Agency')) hidden @endif">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                @if(auth()->user()->hasRole('Agency')) disabled @endif>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" @if(auth()->user()->hasRole('Agency') && $role->name === 'agent') selected @endif>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            @if(auth()->user()->hasRole('Agency'))
                                <input type="hidden" name="role" value="agent">
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password <span
                                    class="text-xs text-gray-500" id="passwordHint">(Required for creation)</span></label>
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                        </div>
                        <div class="flex justify-end pt-6 border-t border-slate-100 gap-3">
                            <button type="button" onclick="closeModal()"
                                class="px-6 py-2.5 text-sm font-bold text-slate-400 hover:text-rose-500 transition-all">Cancel</button>
                            <button type="submit"
                                class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2.5 px-8 rounded-xl shadow-lg shadow-purple-100 transition-all active:scale-95 text-sm uppercase tracking-wider">Save
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- View User Detail Modal -->
        <div id="userViewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                    onclick="closeViewModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                    <div class="bg-white">
                        <!-- Modal Header -->
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                    <i class='bx bx-user text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800" id="viewUserName">User Details</h3>
                                    <p class="text-xs text-slate-500 font-medium">Complete profile information</p>
                                </div>
                            </div>
                            <button onclick="closeViewModal()"
                                class="text-slate-400 hover:text-slate-600 transition-colors">
                                <i class='bx bx-x text-2xl'></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Basic Info -->
                                <div class="space-y-4">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email
                                            Address</label>
                                        <p class="text-slate-800 font-medium flex items-center gap-2" id="viewUserEmail">
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Phone
                                            Number</label>
                                        <p class="text-slate-800 font-medium flex items-center gap-2" id="viewUserPhone">
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Account
                                            Role</label>
                                        <div id="viewUserRoles" class="flex flex-wrap gap-2"></div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status</label>
                                        <span id="viewUserStatus" class="inline-block"></span>
                                    </div>
                                </div>

                                <!-- Agency/Team Info -->
                                <div class="space-y-4">
                                    <div id="agencySection" class="hidden">
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Affiliated
                                            Agency</label>
                                        <p class="text-indigo-600 font-bold flex items-center gap-2">
                                            <i class='bx bxs-business'></i>
                                            <span id="viewUserAgency"></span>
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Member
                                            Since</label>
                                        <p class="text-slate-800 font-medium" id="viewUserJoined"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents Section -->
                            <div class="mt-8">
                                <label
                                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Verification
                                    Documents</label>
                                <div id="viewUserDocuments" class="grid grid-cols-1 gap-3">
                                    <!-- Documents will be injected here -->
                                </div>
                                <div id="noDocuments" class="bg-slate-50 rounded-xl p-8 text-center text-slate-400 hidden">
                                    <i class='bx bx-file-blank text-4xl mb-2 block'></i>
                                    <span class="text-sm font-medium">No verification documents uploaded yet.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                            <button onclick="closeViewModal()"
                                class="px-6 py-2 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all active:scale-95 text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                // Global Modal Functions
                function openModal() {
                    $('#userForm')[0].reset();
                    $('#userId').val('');
                    $('#modalTitle').text('Create New User');
                    $('#passwordHint').text('(Required)');
                    $('#userModal').removeClass('hidden');
                }

                function closeModal() {
                    $('#userModal').addClass('hidden');
                }

                function viewUser(id) {
                    $.get(`/admin/users/${id}`, function (user) {
                        $('#viewUserName').text(user.name);
                        $('#viewUserEmail').html(`<i class='bx bx-envelope text-slate-400'></i> ${user.email}`);
                        $('#viewUserPhone').html(`<i class='bx bx-phone text-slate-400'></i> ${user.phone_number || 'N/A'}`);
                        $('#viewUserJoined').text(new Date(user.created_at).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' }));

                        // Roles
                        let rolesHtml = user.roles.map(role => `<span class="bg-indigo-100 text-indigo-700 rounded-lg px-3 py-1 text-xs font-bold uppercase tracking-wider">${role.name}</span>`).join('');
                        $('#viewUserRoles').html(rolesHtml);

                        // Status
                        let statusColor = 'bg-slate-100 text-slate-700';
                        if (user.status === 'approved' || user.status === 'document_approved') statusColor = 'bg-emerald-100 text-emerald-700';
                        else if (user.status === 'rejected') statusColor = 'bg-rose-100 text-rose-700';
                        else if (user.status === 'pending') statusColor = 'bg-amber-100 text-amber-700';
                        $('#viewUserStatus').html(`<span class="${statusColor} rounded-lg px-3 py-1 text-xs font-bold uppercase tracking-wider">${(user.status || 'pending').replace(/_/g, ' ')}</span>`);

                        // Agency
                        if (user.agency) {
                            $('#viewUserAgency').text(user.agency.name);
                            $('#agencySection').removeClass('hidden');
                        } else {
                            $('#agencySection').addClass('hidden');
                        }

                        // Documents
                        let docsHtml = '';
                        if (user.documents && user.documents.length > 0) {
                            $('#noDocuments').addClass('hidden');
                            user.documents.forEach(doc => {
                                let typeLabel = doc.type.replace(/_/g, ' ').toUpperCase();
                                let statusClass = doc.status === 'approved' ? 'text-emerald-500' : 'text-amber-500';
                                docsHtml += `
                                                                                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                                                                                                <div class="flex items-center gap-4">
                                                                                                    <div class="h-10 w-10 flex items-center justify-center bg-white rounded-lg border border-slate-200">
                                                                                                        <i class='bx bxs-file-pdf text-xl text-rose-500'></i>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <p class="text-sm font-bold text-slate-800">${typeLabel}</p>
                                                                                                        <p class="text-xs font-medium ${statusClass}">${doc.status.toUpperCase()}</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <a href="/storage/${doc.file_path}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-50 transition-all">
                                                                                                    <i class='bx bx-show'></i> VIEW DOCUMENT
                                                                                                </a>
                                                                                            </div>
                                                                                        `;
                            });
                            $('#viewUserDocuments').html(docsHtml).removeClass('hidden');
                        } else {
                            $('#viewUserDocuments').addClass('hidden');
                            $('#noDocuments').removeClass('hidden');
                        }

                        $('#userViewModal').removeClass('hidden');
                    });
                }

                function closeViewModal() {
                    $('#userViewModal').addClass('hidden');
                }

                function editUser(id) {
                    $.get(`/admin/users/${id}/edit`, function (data) {
                        $('#userId').val(data.id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#phone_number').val(data.phone_number);
                        if (data.roles && data.roles.length > 0) {
                            $('#role').val(data.roles[0].name);
                        }
                        $('#modalTitle').text('Edit User');
                        $('#passwordHint').text('(Leave blank to keep current)');
                        $('#userModal').removeClass('hidden');
                    });
                }

                function updateUserStatus(id, status) {
                    $.ajax({
                        url: `/admin/users-status/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function (response) {
                            $('#usersTable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while updating status.'
                            });
                        }
                    });
                }

                function deleteUser(id) {
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
                                url: `/admin/users/${id}`,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    $('#usersTable').DataTable().ajax.reload();
                                    Swal.fire('Deleted!', response.message, 'success');
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', 'Something went wrong.', 'error');
                                }
                            });
                        }
                    });
                }

                $(document).ready(function () {
                    var table = $('#usersTable').DataTable({
                        processing: true,
                        serverSide: false,
                        ajax: {
                            url: "{{ route('admin.users.index') }}",
                            data: function (d) {
                                d.role = $('#roleFilter').val();
                                d.status = $('#statusFilter').val();
                                d.agency_id = $('#agencyFilter').val();
                                d.search = $('#customSearch').val();
                            }
                        },
                        columns: [
                            { data: 'id', name: 'id' },
                            {
                                data: 'name', name: 'name', render: function (data, type, row) {
                                    return `<div class="flex items-center group cursor-pointer" onclick="window.location.href='/admin/users/${row.id}'">
                                                                                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold mr-3 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">${data.charAt(0)}</div>
                                                                                                <div>
                                                                                                    <div class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors uppercase text-[11px] tracking-wider">${data}</div>
                                                                                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-tight">Click for full profile</div>
                                                                                                </div>
                                                                                            </div>`;
                                }
                            },
                            { data: 'email', name: 'email' },
                            {
                                data: 'roles', name: 'roles', render: function (data, type, row) {
                                    let rolesHtml = data.map(role => `<span class="bg-indigo-50 text-indigo-600 rounded-lg px-3 py-1 text-[10px] font-bold uppercase tracking-widest mr-1 shadow-sm border border-indigo-100">${role.name}</span>`).join('');
                                    if (row.agency && row.agency.name) {
                                        rolesHtml += `<div class="text-[9px] text-slate-400 font-bold uppercase mt-1 flex items-center gap-1"><i class='bx bxs-business text-[10px]'></i> ${row.agency.name}</div>`;
                                    }
                                    return rolesHtml;
                                }
                            },
                            {
                                data: 'status', name: 'status', render: function (data) {
                                    let color = 'bg-slate-50 text-slate-600 border-slate-200';
                                    if (data === 'approved' || data === 'document_approved') color = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                    else if (data === 'rejected') color = 'bg-rose-50 text-rose-600 border-rose-100';
                                    else if (data === 'pending') color = 'bg-amber-50 text-amber-600 border-amber-100';
                                    return `<span class="${color} rounded-lg px-3 py-1 text-[10px] font-bold border uppercase tracking-widest shadow-sm">${(data || 'pending').replace(/_/g, ' ')}</span>`;
                                }
                            },
                            {
                                data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data, type, row) {
                                    let approvalBtn = '';
                                    if (row.status === 'pending' || row.status === 'rejected') {
                                        approvalBtn = `<button onclick="updateUserStatus(${data}, 'approved')" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200 transition-all shadow-sm" title="Approve"><i class='bx bx-check text-xl'></i></button>`;
                                    } else if (row.status === 'approved' || row.status === 'document_approved') {
                                        approvalBtn = `<button onclick="updateUserStatus(${data}, 'rejected')" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition-all shadow-sm" title="Reject"><i class='bx bx-x text-xl'></i></button>`;
                                    }

                                    return `
                                                                                                <div class="flex gap-2">
                                                                                                    ${approvalBtn}
                                                                                                    <button onclick="editUser(${data})" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all shadow-sm" title="Edit"><i class='bx bxs-edit text-lg'></i></button>
                                                                                                    <button onclick="deleteUser(${data})" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-600 transition-all shadow-sm" title="Delete"><i class='bx bxs-trash text-lg'></i></button>
                                                                                                </div>
                                                                                            `;
                                }
                            }
                        ],
                        dom: 'rtip',
                        pageLength: 25,
                        language: { emptyTable: "No users found matching your criteria" }
                    });

                    window.exportUsers = function () {
                        const params = $.param({
                            export: 1,
                            role: $('#roleFilter').val(),
                            status: $('#statusFilter').val(),
                            agency_id: $('#agencyFilter').val(),
                            search: $('#customSearch').val()
                        });
                        window.location.href = "{{ route('admin.users.index') }}?" + params;
                    };

                    // Exact Search and Filter Listeners
                    $('#customSearch').on('keyup', function () { table.ajax.reload(); });
                    $('#roleFilter, #statusFilter, #agencyFilter').on('change', function () { table.ajax.reload(); });

                    // Form Submission
                    $('#userForm').submit(function (e) {
                        e.preventDefault();
                        var id = $('#userId').val();
                        var url = id ? `/admin/users/${id}` : "{{ route('admin.users.store') }}";
                        var method = id ? 'PUT' : 'POST';

                        $.ajax({
                            url: url,
                            type: method,
                            data: $(this).serialize(),
                            success: function (response) {
                                closeModal();
                                table.ajax.reload();
                                Swal.fire({ icon: 'success', title: 'Success!', text: response.message, timer: 1500, showConfirmButton: false });
                            },
                            error: function (xhr) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = '';
                                if (errors) {
                                    $.each(errors, function (key, value) { errorMessage += value[0] + '\n'; });
                                }
                                Swal.fire({ icon: 'error', title: 'Error!', text: errorMessage || 'Something went wrong!', });
                            }
                        });
                    });
                });
            </script>
        @endpush
@endsection