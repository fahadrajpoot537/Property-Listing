<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Identity Verification') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Upload your identity documents to verify your account. Once verified, you can start listing properties.') }}
        </p>
    </header>

    @if (session('status') === 'document-uploaded')
        <p class="mt-2 font-medium text-sm text-green-600">
            {{ __('Document uploaded successfully and account status updated.') }}
        </p>
    @endif

    @if (session('error'))
        <p class="mt-2 font-medium text-sm text-red-600">
            {{ session('error') }}
        </p>
    @endif

    <form method="post" action="{{ route('profile.document.store') }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="type" :value="__('Document Type')" />
            <select id="type" name="type"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="passport">Passport</option>
                <option value="id_card">ID Card</option>
                <option value="driving_license">Driving License</option>
            </select>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="document" :value="__('Upload Document')" />
            <input id="document" name="document" type="file"
                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none"
                required />
            <x-input-error :messages="$errors->get('document')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Upload') }}</x-primary-button>
        </div>
    </form>

    <div class="mt-6">
        <h3 class="text-md font-medium text-gray-900">{{ __('Your Documents') }}</h3>
        <ul class="mt-4 space-y-2">
            @foreach($user->documents as $doc)
                <li class="bg-gray-50 p-3 rounded-lg flex justify-between items-center">
                    <div>
                        <span class="font-bold capitalize">{{ str_replace('_', ' ', $doc->type) }}</span>
                        <span class="text-xs text-gray-500 block">{{ $doc->created_at->format('d M Y') }}</span>
                    </div>
                    <span
                        class="px-2 py-1 text-xs rounded-full {{ $doc->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($doc->status) }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</section>