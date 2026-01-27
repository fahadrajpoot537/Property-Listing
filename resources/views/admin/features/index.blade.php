@extends('layouts.admin')

@section('header', 'Features Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600">Property Features</h3>
        <button onclick="openModal()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center gap-2">
            <i class='bx bx-plus'></i> Create New Feature
        </button>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6">
        <table id="featureTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Parent Feature</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Feature Modal -->
    <div id="featureModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Create Feature</h3>
                    <form id="featureForm" class="mt-4">
                        @csrf
                        <input type="hidden" id="featureId" name="id">

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Feature
                                (Optional)</label>
                            <select name="parent_id" id="parent_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                <option value="">None (Top Level)</option>
                                @foreach($parentFeatures as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"></textarea>
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
                var table = $('#featureTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('admin.features.index') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        {
                            data: 'title', name: 'title', render: function (data) {
                                return `<span class="font-medium text-slate-800">${data}</span>`;
                            }
                        },
                        {
                            data: 'parent.title', name: 'parent.title', defaultContent: '<span class="text-xs text-slate-400">N/A</span>', render: function (data) {
                                return data ? `<span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs">${data}</span>` : '<span class="text-xs text-slate-400">N/A</span>';
                            }
                        },
                        {
                            data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data) {
                                return `
                                    <div class="flex gap-2">
                                        <button onclick="editFeature(${data})" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors"><i class='bx bxs-edit'></i></button>
                                        <button onclick="deleteFeature(${data})" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-rose-100 hover:text-rose-600 transition-colors"><i class='bx bxs-trash'></i></button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });

                $('#featureForm').submit(function (e) {
                    e.preventDefault();
                    var id = $('#featureId').val();
                    var url = id ? `/admin/features/${id}` : "{{ route('admin.features.store') }}";
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
                $('#featureForm')[0].reset();
                $('#featureId').val('');
                $('#modalTitle').text('Create Feature');
                $('#featureModal').removeClass('hidden');
            }

            function closeModal() {
                $('#featureModal').addClass('hidden');
            }

            function editFeature(id) {
                $.get(`/admin/features/${id}/edit`, function (data) {
                    $('#featureId').val(data.id);
                    $('#title').val(data.title);
                    $('#parent_id').val(data.parent_id);
                    $('#description').val(data.description);
                    $('#modalTitle').text('Edit Feature');
                    $('#featureModal').removeClass('hidden');
                });
            }

            function deleteFeature(id) {
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
                            url: `/admin/features/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                $('#featureTable').DataTable().ajax.reload();
                                Swal.fire('Deleted!', response.message, 'success');
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection