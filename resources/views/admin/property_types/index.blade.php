@extends('layouts.admin')

@section('header', 'Property Types Management')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-slate-800 font-black text-lg tracking-tight uppercase">Property Types</h3>
        <button onclick="openModal()"
            class="bg-[#8046F1] hover:bg-[#6D28D9] text-white font-black py-2 px-5 rounded-lg shadow-lg shadow-purple-500/10 transition-all flex items-center gap-2 active:scale-95 text-[10px] uppercase tracking-widest">
            <i class='bx bx-plus text-base'></i> New Type
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
        <table id="propertyTable" class="w-full text-[13px] text-left text-slate-500">
            <thead class="text-[10px] text-slate-400 font-black uppercase tracking-widest bg-slate-50/50">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Category</th>
                    <th class="px-5 py-3">Slug</th>
                    <th class="px-5 py-3">Manage</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50"></tbody>
        </table>
    </div>

    <!-- Property Type Modal -->
    <div id="typeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Create Property Type</h3>
                    <form id="typeForm" class="mt-4">
                        @csrf
                        <input type="hidden" id="typeId" name="id">

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
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
                var table = $('#propertyTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('admin.property-types.index') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        {
                            data: 'title', name: 'title', render: function (data) {
                                return `<span class="font-medium text-slate-800">${data}</span>`;
                            }
                        },
                        {
                            data: 'category', name: 'category.name', render: function (data) {
                                return data ? `<span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] uppercase">${data.name}</span>` : 'N/A';
                            }
                        },
                        { data: 'slug', name: 'slug' },
                        {
                            data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data) {
                                return `
                                                            <div class="flex gap-1.5">
                                                                <button onclick="editType(${data})" class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-[#8046F1] transition-all"><i class='bx bx-edit-alt'></i></button>
                                                                <button onclick="deleteType(${data})" class="w-7 h-7 rounded bg-slate-50 flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all"><i class='bx bx-trash'></i></button>
                                                            </div>
                                                        `;
                            }
                        }
                    ]
                });

                $('#typeForm').submit(function (e) {
                    e.preventDefault();
                    var id = $('#typeId').val();
                    var url = id ? `/admin/property-types/${id}` : "{{ route('admin.property-types.store') }}";
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong!',
                            });
                        }
                    });
                });
            });

            function openModal() {
                $('#typeForm')[0].reset();
                $('#typeId').val('');
                $('#modalTitle').text('Create Property Type');
                $('#typeModal').removeClass('hidden');
            }

            function closeModal() {
                $('#typeModal').addClass('hidden');
            }

            function editType(id) {
                $.get(`/admin/property-types/${id}/edit`, function (data) {
                    $('#typeId').val(data.id);
                    $('#title').val(data.title);
                    $('#category_id').val(data.category_id);
                    $('#description').val(data.description);
                    $('#meta_title').val(data.meta_title);
                    $('#modalTitle').text('Edit Property Type');
                    $('#typeModal').removeClass('hidden');
                });
            }

            function deleteType(id) {
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
                            url: `/admin/property-types/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                $('#propertyTable').DataTable().ajax.reload();
                                Swal.fire('Deleted!', response.message, 'success');
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection