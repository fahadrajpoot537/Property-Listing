<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Saved Searches & Property Alerts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($savedSearches->isEmpty())
                        <p class="text-center text-gray-500 py-4">You haven't saved any searches yet. Search for properties and click "Save Search" on the results page!</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3">Search Name</th>
                                        <th class="px-4 py-3">Criteria</th>
                                        <th class="px-4 py-3">Last Checked</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($savedSearches as $search)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">{{ $search->name }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                @php $f = $search->filters; @endphp
                                                @if(!empty($f['purpose'])) {{ ucfirst($f['purpose']) }} @endif
                                                @if(!empty($f['property_type_id'])) | Type ID: {{ $f['property_type_id'] }} @endif
                                                @if(!empty($f['min_price']) || !empty($f['max_price'])) 
                                                    | £{{ number_format($f['min_price'] ?? 0) }} - £{{ number_format($f['max_price'] ?? 0) }} 
                                                @endif
                                                @if(!empty($f['bedrooms'])) | {{ $f['bedrooms'] }}+ Beds @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ $search->last_checked_at ? $search->last_checked_at->diffForHumans() : 'Never' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $search->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                    {{ $search->is_active ? 'Active' : 'Paused' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <form action="{{ route('saved-searches.destroy', $search->id) }}" method="POST" onsubmit="return confirm('Delete this saved search?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
