@extends('layouts.admin')

@section('header', 'Property Locations Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-slate-600">Property Locations</h3>
        <button onclick="openModal()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center gap-2">
            <i class='bx bx-plus'></i> Create New Location
        </button>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-100 p-6">
        <table id="locationTable" class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Coordinates</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Location Modal -->
    <div id="locationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Create Location</h3>
                    <form id="locationForm" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="locationId" name="_method"> <!-- Used for emulation PUT -->

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image" id="image"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <div id="imagePreview" class="mt-2 hidden">
                                <img src="" alt="Preview" class="h-20 w-auto rounded">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address (Google
                                Maps)</label>
                            <input type="text" name="address" id="address"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                placeholder="Search for a location...">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                <input type="text" name="latitude" id="latitude"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm border p-2"
                                    readonly>
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                <input type="text" name="longitude" id="longitude"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm border p-2"
                                    readonly>
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
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
        <script>
            let autocomplete;
            let currentActionUrl = "{{ route('admin.property-locations.store') }}";
            let currentMethod = 'POST';

            function initAutocomplete() {
                const input = document.getElementById("address");
                autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", fillInAddress);
            }

            function fillInAddress() {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }
                document.getElementById("latitude").value = place.geometry.location.lat();
                document.getElementById("longitude").value = place.geometry.location.lng();
                document.getElementById("address").value = place.formatted_address; // Or place.name
            }

            $(document).ready(function () {
                initAutocomplete();

                var table = $('#locationTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('admin.property-locations.index') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        {
                            data: 'image', name: 'image', render: function (data) {
                                return data ? `<img src="/storage/${data}" class="w-12 h-12 rounded object-cover">` : '<span class="text-xs text-slate-400">No Image</span>';
                            }
                        },
                        { data: 'name', name: 'name', class: 'font-medium text-slate-800' },
                        { data: 'address', name: 'address' },
                        {
                            data: null,
                            render: function (data) {
                                return `<span class="text-xs">${parseFloat(data.latitude || 0).toFixed(4)}, ${parseFloat(data.longitude || 0).toFixed(4)}</span>`;
                            }
                        },
                        {
                            data: 'id', name: 'actions', orderable: false, searchable: false, render: function (data) {
                                return `
                                            <div class="flex gap-2">
                                                <button onclick="editLocation(${data})" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors"><i class='bx bxs-edit'></i></button>
                                                <button onclick="deleteLocation(${data})" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-rose-100 hover:text-rose-600 transition-colors"><i class='bx bxs-trash'></i></button>
                                            </div>
                                        `;
                            }
                        }
                    ]
                });

                $('#locationForm').submit(function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    // Adjust for Laravel method spoofing if it's an update
                    if (currentMethod === 'PUT') {
                        formData.append('_method', 'PUT');
                    } else {
                        formData.delete('_method');
                    }

                    $.ajax({
                        url: currentActionUrl,
                        type: 'POST', // Always POST for FormData with file upload, spoof method if needed
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            // If response is a redirect (from my controller logic before), I should change controller to return JSON
                            // Or I can handle the redirect if it returns HTML page? 
                            // Ah, my controller was set to return Redirect in store/update! 
                            // I need to change controller to return JSON for this AJAX to work nicely.
                            // However, if I change the controller, I'm good.
                            // If I don't change the controller, I should use standard form submission, not AJAX.
                            // But I want AJAX for partial page reload.
                            // I'll update the controller to return JSON.

                            closeModal();
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Operation successful',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!',
                            });
                        }
                    });
                });
            });

            function openModal() {
                $('#locationForm')[0].reset();
                $('#imagePreview').addClass('hidden');
                $('#locationId').val('');
                $('#modalTitle').text('Create Location');
                $('#locationModal').removeClass('hidden');
                currentActionUrl = "{{ route('admin.property-locations.store') }}";
                currentMethod = 'POST';
            }

            function closeModal() {
                $('#locationModal').addClass('hidden');
            }

            function editLocation(id) {
                // I need to fetch data. Controller edit method returns view. I should change it to return JSON or use another endpoint.
                // Wait, AdminFeatureController edit returning JSON.
                // I will update my controller to return JSON for edit as well.

                $.get(`/admin/property-locations/${id}/edit`, function (data) {
                    $('#locationId').val('PUT'); // Just a marker, actual method spoofing is in submit handler
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    $('#latitude').val(data.latitude);
                    $('#longitude').val(data.longitude);

                    if (data.image) {
                        $('#imagePreview img').attr('src', '/storage/' + data.image);
                        $('#imagePreview').removeClass('hidden');
                    } else {
                        $('#imagePreview').addClass('hidden');
                    }

                    $('#modalTitle').text('Edit Location');
                    $('#locationModal').removeClass('hidden');
                    currentActionUrl = `/admin/property-locations/${id}`;
                    currentMethod = 'PUT';
                });
            }

            function deleteLocation(id) {
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
                            url: `/admin/property-locations/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                $('#locationTable').DataTable().ajax.reload();
                                Swal.fire('Deleted!', response.message, 'success');
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection