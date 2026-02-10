<x-mail::message>
    # New Property Match Found!

    Hi {{ $inquiry->name }},

    We found a new property that matches your previous interests.

    **{{ $listing->property_title }}**
    - **Price:** £{{ number_format($listing->price, 2) }}
    - **Bedrooms:** {{ $listing->bedrooms }}
    - **Bathrooms:** {{ $listing->bathrooms }}
    - **Location:** {{ $listing->address }}

    <x-mail::button :url="url('/properties/' . $listing->slug)">
        View Property Details
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>