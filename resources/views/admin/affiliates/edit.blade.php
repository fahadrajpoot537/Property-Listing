@extends('layouts.admin')

@section('header', 'Edit Affiliate')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h3 class="font-bold mb-4">Edit Affiliate for: {{ $affiliate->user->name }}</h3>
        <form action="{{ route('admin.affiliates.update', $affiliate->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status</label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="status" name="status" required>
                    <option value="active" {{ $affiliate->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ $affiliate->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="inactive" {{ $affiliate->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Update Affiliate
                </button>
            </div>
        </form>
    </div>
@endsection