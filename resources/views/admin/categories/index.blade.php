@extends('layouts.admin')

@section('header', 'Categories')

@section('content')
    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white rounded-t-xl">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase">Categories</h2>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Manage Property Categories
                (Residential, Commercial, etc.)</p>
        </div>
        <button onclick="openModal()"
            class="btn-brand px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest flex items-center gap-2">
            <i class='bx bx-plus-circle text-lg'></i> Add New Category
        </button>
    </div>

    <div class="bg-white rounded-b-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <table id="categoryTable" class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Name</th>
                        <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Slug</th>
                        <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                            Property Types</th>
                        <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($categories as $category)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-4 py-4">
                                <span class="text-sm font-bold text-slate-700">{{ $category->name }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-xs font-medium text-slate-400 font-mono">{{ $category->slug }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span
                                    class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-tighter">
                                    {{ $category->property_types_count }} Types
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick="editCategory({{ json_encode($category) }})"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all">
                                        <i class='bx bx-edit-alt text-lg'></i>
                                    </button>
                                    <button onclick="deleteCategory({{ $category->id }})"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase" id="modalTitle">Add New Category</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <form id="categoryForm" class="p-8 space-y-6">
                @csrf
                <input type="hidden" id="categoryId" name="id">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Category
                        Name</label>
                    <input type="text" name="name" id="categoryName" required
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-100 bg-slate-50 text-sm font-bold focus:bg-white focus:border-indigo-400 outline-none transition-all"
                        placeholder="e.g. Residential">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 px-6 py-3.5 rounded-xl border border-slate-100 text-xs font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-[2] btn-brand px-6 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-100">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#categoryTable').DataTable({
                    responsive: true,
                    dom: '<"flex flex-col md:flex-row justify-between gap-4 mb-4"f>rt<"flex flex-col md:flex-row justify-between items-center gap-4 mt-4"ip>',
                    language: {
                        search: "",
                        searchPlaceholder: "Search categories..."
                    }
                });

                $('#categoryForm').on('submit', function (e) {
                    e.preventDefault();
                    const id = $('#categoryId').val();
                    const url = id ? `/admin/categories/${id}` : '/admin/categories';
                    const method = id ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: $(this).serialize() + (id ? '&_method=PUT' : ''),
                        success: function (res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON?.message || 'Something went wrong!'
                            });
                        }
                    });
                });
            });

            function openModal() {
                $('#categoryId').val('');
                $('#categoryName').val('');
                $('#modalTitle').text('Add New Category');
                $('#categoryModal').removeClass('hidden');
                setTimeout(() => {
                    $('#modalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 10);
            }

            function closeModal() {
                $('#modalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                setTimeout(() => {
                    $('#categoryModal').addClass('hidden');
                }, 300);
            }

            function editCategory(category) {
                $('#categoryId').val(category.id);
                $('#categoryName').val(category.name);
                $('#modalTitle').text('Edit Category');
                $('#categoryModal').removeClass('hidden');
                setTimeout(() => {
                    $('#modalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 10);
            }

            function deleteCategory(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This category and its relationships will be checked!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#131B31',
                    cancelButtonColor: '#f43f5e',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-premium',
                        confirmButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest',
                        cancelButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/categories/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Could not delete category'
                                });
                            }
                        });
                    }
                });
            }
        </script>
    @endpush

@endsection