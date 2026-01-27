<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Affiliate Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Your Affiliate Stats</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-gray-500 text-sm">Status</div>
                            <div
                                class="text-xl font-bold uppercase {{ $affiliate->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $affiliate->status }}
                            </div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="text-xl font-bold">£{{ number_format($affiliate->total_earnings, 2) }}</div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-gray-500 text-sm">Referral Code</div>
                            <div class="text-xl font-bold">{{ $affiliate->referral_code }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Referral Link</h3>
                    <p class="mb-4">Share this link to earn rewards:</p>
                    <div class="bg-gray-100 p-4 rounded flex items-center justify-between">
                        <code class="text-blue-600">{{ $link }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $link }}')"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>