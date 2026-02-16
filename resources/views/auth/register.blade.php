@extends('layouts.modern')

@section('title', 'Join PropertyFinda - Register Your Account')

@section('content')
    <div
        class="min-h-screen pt-20 md:pt-32 pb-12 flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-2xl w-full space-y-8 animate-fadeInUp">
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-primary tracking-tight">Register</h2>
                <p class="mt-2 text-base md:text-lg text-gray-500 font-medium">Create your account to get started.</p>
            </div>

            <div class="bg-white rounded-[2rem] md:rounded-3xl shadow-2xl p-5 sm:p-8 md:p-10 border border-gray-100">
                <form method="POST" action="{{ route('register') }}" class="space-y-6"
                    x-data="{ role: '{{ old('role', 'buyer') }}' }">
                    @csrf

                    <!-- Role Selection -->
                    <div>
                        <label class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 block">Select Account
                            Type</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="agent" x-model="role" class="sr-only" required>
                                <div :class="role === 'agent' ? 'border-secondary bg-secondary/5' : 'border-gray-100'"
                                    class="p-2 sm:p-4 border-2 rounded-2xl text-center transition-all group-hover:border-secondary/30">
                                    <div :class="role === 'agent' ? 'bg-secondary/10' : 'bg-gray-50'"
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <i :class="role === 'agent' ? 'text-secondary' : 'text-gray-400'"
                                            class="fa-solid fa-user-tie group-hover:text-secondary text-sm md:text-base"></i>
                                    </div>
                                    <span :class="role === 'agent' ? 'text-secondary' : 'text-gray-600'"
                                        class="text-xs md:text-sm font-bold">Agent</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="agency" x-model="role" class="sr-only">
                                <div :class="role === 'agency' ? 'border-secondary bg-secondary/5' : 'border-gray-100'"
                                    class="p-2 sm:p-4 border-2 rounded-2xl text-center transition-all group-hover:border-secondary/30">
                                    <div :class="role === 'agency' ? 'bg-secondary/10' : 'bg-gray-50'"
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <i :class="role === 'agency' ? 'text-secondary' : 'text-gray-400'"
                                            class="fa-solid fa-building group-hover:text-secondary text-sm md:text-base"></i>
                                    </div>
                                    <span :class="role === 'agency' ? 'text-secondary' : 'text-gray-600'"
                                        class="text-xs md:text-sm font-bold">Agency</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="landlord" x-model="role" class="sr-only">
                                <div :class="role === 'landlord' ? 'border-secondary bg-secondary/5' : 'border-gray-100'"
                                    class="p-2 sm:p-4 border-2 rounded-2xl text-center transition-all group-hover:border-secondary/30">
                                    <div :class="role === 'landlord' ? 'bg-secondary/10' : 'bg-gray-50'"
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <i :class="role === 'landlord' ? 'text-secondary' : 'text-gray-400'"
                                            class="fa-solid fa-house-chimney group-hover:text-secondary text-sm md:text-base"></i>
                                    </div>
                                    <span :class="role === 'landlord' ? 'text-secondary' : 'text-gray-600'"
                                        class="text-xs md:text-sm font-bold">Landlord</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="buyer" x-model="role" class="sr-only">
                                <div :class="role === 'buyer' ? 'border-secondary bg-secondary/5' : 'border-gray-100'"
                                    class="p-2 sm:p-4 border-2 rounded-2xl text-center transition-all group-hover:border-secondary/30">
                                    <div :class="role === 'buyer' ? 'bg-secondary/10' : 'bg-gray-50'"
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-xl flex items-center justify-center mx-auto mb-2">
                                        <i :class="role === 'buyer' ? 'text-secondary' : 'text-gray-400'"
                                            class="fa-solid fa-cart-shopping group-hover:text-secondary text-sm md:text-base"></i>
                                    </div>
                                    <span :class="role === 'buyer' ? 'text-secondary' : 'text-gray-600'"
                                        class="text-xs md:text-sm font-bold">Buyer</span>
                                </div>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Agent Warning -->
                    <div x-show="role === 'agent'" x-transition
                        class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 mt-1"></i>
                        <div>
                            <p class="text-sm font-bold text-red-800 uppercase tracking-tight">Warning</p>
                            <p class="text-xs text-red-600 font-medium leading-relaxed">If You Are An Estate Agent Don't
                                Contact LandLords As Account Will Be Banned.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="space-y-2">
                            <label for="name" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Full
                                Name*</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-user text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium"
                                    placeholder="Enter full name">
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email"
                                class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Email*</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-envelope text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium"
                                    placeholder="name@example.co.uk">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone"
                            class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Phone*</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fa-solid fa-phone text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                            </div>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', '+44') }}" required
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium"
                                placeholder="+44 7000 000 000">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>

                    <!-- Address with Google Places -->
                    <div class="space-y-2">
                        <label for="address"
                            class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fa-solid fa-location-dot text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                            </div>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium"
                                placeholder="Start typing your address...">
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password"
                                class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Password*</label>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-lock text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                    class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium"
                                    placeholder="••••••••">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-secondary transition-colors">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation"
                                class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Confirm
                                Password*</label>
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-lock text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" id="password_confirmation"
                                    name="password_confirmation" required
                                    class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium"
                                    placeholder="••••••••">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-secondary transition-colors">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Password hint -->
                    <div class="flex items-start gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-tight px-1">
                        <i class="fa-solid fa-circle-info text-secondary mt-0.5"></i>
                        <span>Password must contain: 1 capital letter, 1 number, and 1 special character</span>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-extrabold text-lg rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            Create Account
                        </button>

                        <p class="mt-6 text-center text-gray-500 font-medium">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-secondary font-bold hover:underline">Sign in</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initAutocomplete"
            async defer></script>
        <script>
            let autocomplete;

            function initAutocomplete() {
                const addressInput = document.getElementById('address');

                if (!addressInput) return;

                // Initialize autocomplete
                autocomplete = new google.maps.places.Autocomplete(addressInput, {
                    componentRestrictions: { country: 'gb' },
                    fields: ['address_components', 'geometry', 'formatted_address']
                });

                // Listen for place selection
                autocomplete.addListener('place_changed', function () {
                    const place = autocomplete.getPlace();

                    if (!place.geometry) {
                        console.log('No geometry found for this place');
                        return;
                    }

                    // Set latitude and longitude
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();

                    // Set formatted address
                    document.getElementById('address').value = place.formatted_address;

                    console.log('Address:', place.formatted_address);
                    console.log('Latitude:', place.geometry.location.lat());
                    console.log('Longitude:', place.geometry.location.lng());
                });
            }

            // Fallback if callback doesn't work
            window.addEventListener('load', function () {
                if (typeof google !== 'undefined' && !autocomplete) {
                    initAutocomplete();
                }
            });
        </script>
    @endpush
@endsection