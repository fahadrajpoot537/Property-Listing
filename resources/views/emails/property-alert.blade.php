<x-mail::message>
# New Properties Matching Your Search: {{ $savedSearch->name ?? 'Update' }}

Hi {{ $savedSearch->user->name }},

We found {{ $listings->count() }} new properties matching your saved search criteria.

@foreach($listings as $listing)
<x-mail::panel>
### {{ $listing->property_title }}
**Price:** £{{ number_format($listing->price) }}
**Location:** {{ $listing->display_address }}

<x-mail::button :url="route('listing.show', $listing->slug ?? $listing->id)">
View Property
</x-mail::button>
</x-mail::panel>
@endforeach

<x-mail::button :url="url('/dashboard/saved-searches')" color="success">
Manage Your Alerts
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>