@extends('layouts.admin')

@section('header', 'Affiliate Details')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-4">Affiliate: {{ $affiliate->user->name }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p><strong>Email:</strong> {{ $affiliate->user->email }}</p>
                <p><strong>Phone:</strong> {{ $affiliate->user->phone_number }}</p>
                <p><strong>Referral Code:</strong> {{ $affiliate->referral_code }}</p>
                <p><strong>Total Earnings:</strong> {{ number_format($affiliate->total_earnings, 2) }}</p>
                <p><strong>Joined:</strong> {{ $affiliate->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-2">Status</h3>
                <span
                    class="bg-{{ $affiliate->status == 'active' ? 'green' : 'red' }}-200 text-{{ $affiliate->status == 'active' ? 'green' : 'red' }}-600 py-1 px-3 rounded-full text-xs">
                    {{ ucfirst($affiliate->status) }}
                </span>

                <h3 class="font-bold text-lg mt-4 mb-2">Verification</h3>
                <p><strong>Verified:</strong> {{ $affiliate->is_verified ? 'Yes' : 'No' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.affiliates.edit', $affiliate->id) }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Status</a>
        </div>
    </div>
@endsection