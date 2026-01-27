@extends('layouts.admin')

@section('header', 'Payment Instrument Setup')

@section('content')
    <div class="flex justify-between items-center mb-10">
        <div>
            <h3 class="text-3xl font-black text-black tracking-tighter">Cheque Definitions</h3>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Define payment instalment
                requirements</p>
        </div>
        <button onclick="openModal()"
            class="bg-black hover:bg-[#02b8f2] text-white font-black py-4 px-8 rounded-2xl shadow-xl transition-all flex items-center gap-3 active:scale-95">
            <i class='bx bx-wallet text-xl'></i> Add Definition
        </button>
    </div>

    <div class="bg-white shadow-2xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-50 p-8">
        <table id="mainTable" class="w-full text-sm text-left">
            <thead>
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                    <th class="px-6 py-5">ID</th>
                    <th class="px-6 py-5">Definition</th>
                    <th class="px-6 py-5">SEO Data</th>
                    <th class="px-6 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50"></tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="setupModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <div class="px-8 pt-8 pb-8 bg-white sm:p-10">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-black text-black tracking-tighter" id="modalTitle">Instalment Configuration
                        </h3>
                        <button onclick="closeModal()"
                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>

                    <form id="setupForm" class="space-y-6">
                        @csrf
                        <input type="hidden" id="recordId" name="id">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Definition
                                    Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50/50 text-sm p-4 focus:ring-4 focus:ring-blue-50 focus:border-[#02b8f2] transition-all font-bold"
                                    placeholder="e.g. 4 Cheques, 1 Cheque" required>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta
                                    Title</label>
                                <input type="text" name="meta_title" id="meta_title"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50/50 text-sm p-4 focus:ring-4 focus:ring-blue-50 focus:border-[#02b8f2] transition-all"
                                    placeholder="SEO Title">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta
                                    Keywords</label>
                                <input type="text" name="meta_keywords" id="meta_keywords"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50/50 text-sm p-4 focus:ring-4 focus:ring-blue-50 focus:border-[#02b8f2] transition-all"
                                    placeholder="Keywords...">
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Meta
                                    Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50/50 text-sm p-4 focus:ring-4 focus:ring-blue-50 focus:border-[#02b8f2] transition-all"
                                    placeholder="Short SEO summary..."></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Legal/Internal
                                    Notes</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50/50 text-sm p-4 focus:ring-4 focus:ring-blue-50 focus:border-[#02b8f2] transition-all"
                                    placeholder="Internal notes for this payment method..."></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 gap-4">
                            <button type="button" onclick="closeModal()"
                                class="px-8 py-4 bg-slate-50 text-slate-400 font-black text-[11px] uppercase tracking-widest rounded-2xl hover:bg-slate-100 transition-all">Discard</button>
                            <button type="submit"
                                class="px-10 py-4 bg-[#02b8f2] text-white font-black text-[11px] uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-200 active:scale-95 transition-all">Save
                                Definition</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                var table = $('#mainTable').DataTable({
                    ajax: "{{ route('admin.cheques.index') }}",
                    responsive: true,
                    columns: [
                        { data: 'id', class: 'font-black text-slate-300 px-6 py-5' },
                        {
                            data: 'title', render: function (d) {
                                return `<div class="font-black text-black text-base italic tracking-tight">${d}</div>`;
                            }
                        },
                        {
                            data: 'meta_title', render: function (d, t, r) {
                                return `<div class="text-[10px] font-bold text-slate-400 uppercase leading-tight">${d || 'No SEO Meta'}<br><span class="text-[#02b8f2]">Type: Mandatory</span></div>`;
                            }
                        },
                        {
                            data: 'id', orderable: false, class: 'text-right px-6 py-5', render: function (d) {
                                return `
                                            <div class="flex justify-end gap-2">
                                                <button onclick="editRecord(${d})" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all flex items-center justify-center shadow-sm"><i class='bx bxs-edit-alt text-xl'></i></button>
                                                <button onclick="deleteRecord(${d})" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center shadow-sm"><i class='bx bxs-trash text-xl'></i></button>
                                            </div>
                                        `;
                            }
                        }
                    ]
                });

                $('#setupForm').submit(function (e) {
                    e.preventDefault();
                    var id = $('#recordId').val();
                    var url = id ? `/admin/cheques/${id}` : "{{ route('admin.cheques.store') }}";
                    var method = id ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        type: method,
                        data: $(this).serialize(),
                        success: function (res) {
                            closeModal();
                            table.ajax.reload();
                            Swal.fire({ icon: 'success', title: 'Definition Saved', text: res.message, timer: 2000, showConfirmButton: false });
                        }
                    });
                });
            });

            function openModal() {
                $('#setupForm')[0].reset();
                $('#recordId').val('');
                $('#modalTitle').text('New Cheque Requirement');
                $('#setupModal').removeClass('hidden');
            }

            function closeModal() { $('#setupModal').addClass('hidden'); }

            function editRecord(id) {
                $.get(`/admin/cheques/${id}/edit`, function (d) {
                    $('#recordId').val(d.id);
                    $('#title').val(d.title);
                    $('#meta_title').val(d.meta_title);
                    $('#meta_keywords').val(d.meta_keywords);
                    $('#meta_description').val(d.meta_description);
                    $('#description').val(d.description);
                    $('#modalTitle').text('Modify Cheque Requirement');
                    $('#setupModal').removeClass('hidden');
                });
            }

            function deleteRecord(id) {
                Swal.fire({ title: 'Purge Definition?', text: "Ensure no properties are linked to this cheque pattern.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#000', cancelButtonColor: '#f1f5f9' }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({ url: `/admin/cheques/${id}`, type: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: () => { table.ajax.reload(); Swal.fire('Deleted!', 'Registry cleared.', 'success'); } });
                    }
                });
            }
        </script>
    @endpush
@endsection