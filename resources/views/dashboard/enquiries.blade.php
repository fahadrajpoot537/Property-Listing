<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inquiry History (Sent Leads)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-100 mb-6">
                    <p class="text-gray-500 text-sm">Every time you click "Contact Agent" or send an enquiry on a property, it is logged here so you can keep track of which properties you've reached out to.</p>
                </div>
                
                <div class="p-6">
                    @if($enquiries->isEmpty())
                        <div class="text-center py-10">
                            <i class="fa-solid fa-paper-plane text-4xl text-gray-200 mb-4 block"></i>
                            <p class="text-gray-400">You haven't sent any enquiries yet.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($enquiries as $enquiry)
                                @php $prop = $enquiry->listing ?? $enquiry->offMarketListing; @endphp
                                <div class="flex flex-col md:flex-row gap-6 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all items-start">
                                    <div class="w-full md:w-1/4">
                                        @if($prop && $prop->thumbnail)
                                            <img src="{{ asset('uploads/property/'.$prop->thumbnail) }}" class="rounded-xl w-full h-32 object-cover">
                                        @else
                                            <div class="w-full h-32 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">No Image</div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="font-bold text-lg text-primary">
                                                    @if($prop)
                                                        <a href="{{ route('listing.show', $prop->slug ?? $prop->id) }}" class="hover:underline">
                                                            {{ $prop->property_title }}
                                                        </a>
                                                    @else
                                                        Deleted Property
                                                    @endif
                                                </h3>
                                                <p class="text-sm text-gray-500 font-medium">To: {{ $enquiry->agent_email }}</p>
                                            </div>
                                            <span class="px-3 py-1 bg-primary/5 text-primary rounded-full text-xs font-bold uppercase tracking-wider">
                                                {{ ucfirst($enquiry->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="bg-gray-50 p-4 rounded-xl text-sm italic text-gray-600 mb-4">
                                            "{{ $enquiry->message }}"
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <span class="text-xs text-gray-400">Sent on {{ $enquiry->created_at->format('M d, Y \a\t H:i') }}</span>
                                            
                                            <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST" onsubmit="return confirm('Remove this from your history?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-400 hover:text-red-600 uppercase font-black tracking-widest transition-colors">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
