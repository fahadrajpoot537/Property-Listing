@extends('layouts.admin')

@section('header', auth()->user()->hasRole('Agency') ? 'Team Management' : 'Users Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600">{{ auth()->user()->hasRole('Agency') ? 'My Team' : 'User Management' }}</h3>
        <button onclick="openModal()"
            class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2.5 px-6 rounded-xl shadow-lg shadow-purple-100 transition-all flex items-center gap-2 active:scale-95 text-sm uppercase tracking-wider">
            <i class='bx bx-plus-circle text-lg'></i>
            {{ auth()->user()->hasRole('Agency') ? 'Add Team Member' : 'Create New User' }}
        </button>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6">
        <table id="usersTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
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
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                var table = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: false, // Client-side handling for now as controller returns all data
                    ajax: "{{ route('admin.users.index') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        {
                            data: 'name', name: 'name', render: function (data, type, row) {
                                return `<div class="flex items-center">
                                                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold mr-3">${data.charAt(0)}</div>
                                                                    <div><div class="font-medium text-slate-800">${data}</div></div>
                                                                </div>`;
                            }
                        },
                        { data: 'email', name: 'email' },
                        {
                            data: 'roles', name: 'roles', render: function (data) {
                                return data.map(role => `<span class="bg-indigo-100 text-indigo-700 rounded-full px-3 py-1 text-xs font-semibold mr-1">${role.name}</span>`).join('');
                            }
                        },
                        {
                            data: 'status', name: 'status', render: function (data) {
                                let color = 'bg-slate-100 text-slate-700';
                                if (data === 'approved') color = 'bg-emerald-100 text-emerald-700';
                                if (data === 'rejected') color = 'bg-rose-100 text-rose-700';
                                if (data === 'pending') color = 'bg-amber-100 text-amber-700';
                                return `<span class="${color} rounded-full px-3 py-1 text-xs font-semibold uppercase">${data || 'pending'}</span>`;
                            }
                        },
                        {
                            data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data, type, row) {
                                let approvalBtn = '';
                                if (row.status === 'pending' || row.status === 'rejected') {
                                    approvalBtn = `<button onclick="updateUserStatus(${data}, 'approved')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-emerald-600 hover:bg-emerald-100 transition-colors" title="Approve"><i class='bx bx-check'></i></button>`;
                                } else if (row.status === 'approved') {
                                    approvalBtn = `<button onclick="updateUserStatus(${data}, 'rejected')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-rose-600 hover:bg-rose-100 transition-colors" title="Reject"><i class='bx bx-x'></i></button>`;
                                }

                                return `
                                                            <div class="flex gap-2">
                                                                ${approvalBtn}
                                                                <button onclick="editUser(${data})" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors" title="Edit"><i class='bx bxs-edit'></i></button>
                                                                <button onclick="deleteUser(${data})" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-rose-100 hover:text-rose-600 transition-colors" title="Delete"><i class='bx bxs-trash'></i></button>
                                                            </div>
                                                        `;
                            }
                        }
                    ]
                });

                // Form Submit
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
                $('#userForm')[0].reset();
                $('#userId').val('');
                $('#modalTitle').text('Create New User');
                $('#passwordHint').text('(Required)');
                $('#userModal').removeClass('hidden');
            }

            function closeModal() {
                $('#userModal').addClass('hidden');
            }

            function editUser(id) {
                $.get(`/admin/users/${id}/edit`, function (data) {
                    $('#userId').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#phone_number').val(data.phone_number);
                    // Handle role selection - simpler if single role, if multiple needs adjustment
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
        </script>
    @endpush
@endsection