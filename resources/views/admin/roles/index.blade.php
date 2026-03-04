@extends('layouts.admin')

@section('header', 'Role Management')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-slate-800 font-black text-lg tracking-tight uppercase">Access Control</h3>
        <button onclick="openModal()"
            class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2 px-5 rounded-lg shadow-lg shadow-purple-500/10 transition-all flex items-center gap-2 active:scale-95 text-[10px] uppercase tracking-widest">
            <i class='bx bx-plus text-base'></i> New Role
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
        <table id="rolesTable" class="w-full text-[13px] text-left text-slate-500">
            <thead class="text-[10px] text-slate-400 font-black uppercase tracking-widest bg-slate-50/50">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Identifier</th>
                    <th class="px-5 py-3">Capabilities</th>
                    <th class="px-5 py-3">Manage</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50"></tbody>
        </table>
    </div>

    <!-- Role Modal -->
    <div id="roleModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Create New Role</h3>
                    <form id="roleForm" class="mt-4">
                        @csrf
                        <input type="hidden" id="roleId" name="id">

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                            <div class="grid grid-cols-2 gap-2 h-48 overflow-y-auto border p-2 rounded">
                                @foreach($permissions as $permission)
                                    <div class="flex items-center">
                                        <input id="perm_{{ $permission->id }}" name="permissions[]"
                                            value="{{ $permission->name }}" type="checkbox"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="perm_{{ $permission->id }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
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

    @push('scripts')
        <script>
            $(document).ready(function () {
                var table = $('#rolesTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('admin.roles.index') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        {
                            data: 'name', name: 'name', render: function (data) {
                                return `<span class="font-bold text-slate-800">${data}</span>`;
                            }
                        },
                        {
                            data: 'permissions', name: 'permissions', render: function (data) {
                                if (!data || data.length === 0) return '<span class="text-xs text-gray-400">No permissions</span>';
                                return data.map(perm => `<span class="bg-gray-100 text-gray-600 rounded px-2 py-0.5 text-xs mr-1 mb-1 inline-block">${perm.name}</span>`).join('');
                            }
                        },
                        {
                            data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data, type, row) {
                                return `
                                            <div class="flex gap-1.5">
                                                <button onclick="editRole(${data})" class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-[#8046F1] transition-all"><i class='bx bx-edit-alt'></i></button>
                                                <button onclick="deleteRole(${data})" class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all"><i class='bx bx-trash'></i></button>
                                            </div>
                                        `;
                            }
                        }
                    ]
                });

                // Form Submit
                $('#roleForm').submit(function (e) {
                    e.preventDefault();
                    var id = $('#roleId').val();
                    var url = id ? `/admin/roles/${id}` : "{{ route('admin.roles.store') }}";
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
                $('#roleForm')[0].reset();
                $('#roleId').val('');
                $('input[type=checkbox]').prop('checked', false);
                $('#modalTitle').text('Create New Role');
                $('#roleModal').removeClass('hidden');
            }

            function closeModal() {
                $('#roleModal').addClass('hidden');
            }

            function editRole(id) {
                $.get(`/admin/roles/${id}/edit`, function (data) {
                    $('#roleId').val(data.id);
                    $('#name').val(data.name);

                    // Reset checkboxes first
                    $('input[type=checkbox]').prop('checked', false);

                    // Check permissions
                    if (data.permissions) {
                        data.permissions.forEach(function (perm) {
                            // We need to find checkbox by value (permission name)
                            $(`input[name="permissions[]"][value="${perm.name}"]`).prop('checked', true);
                        });
                    }

                    $('#modalTitle').text('Edit Role');
                    $('#roleModal').removeClass('hidden');
                });
            }

            function deleteRole(id) {
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
                            url: `/admin/roles/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                $('#rolesTable').DataTable().ajax.reload();
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