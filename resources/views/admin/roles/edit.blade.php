@extends('layouts.admin')

@section('header', 'Edit Role')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Role Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" value="{{ $role->name }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Permissions</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @php $rolePermissions = $role->permissions->pluck('id')->toArray(); @endphp
                    @foreach($permissions as $permission)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection