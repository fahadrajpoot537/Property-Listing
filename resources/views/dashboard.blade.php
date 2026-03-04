<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-black text-primary mb-6">Welcome Back, {{ auth()->user()->name }}!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Saved Searches -->
                        <a href="{{ route('saved-searches.index') }}"
                            class="p-6 border-2 border-primary/5 rounded-3xl hover:border-secondary hover:translate-y-[-5px] transition-all group overflow-hidden relative">
                            <i
                                class="fa-solid fa-bell text-3xl text-secondary mb-4 block group-hover:scale-110 transition-transform"></i>
                            <h4 class="font-bold text-lg mb-2">Saved Searches</h4>
                            <p class="text-sm text-gray-500">Manage your property alerts and saved criteria here.</p>
                            <div
                                class="absolute -right-4 -bottom-4 w-20 h-20 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform">
                            </div>
                        </a>

                        <!-- Inquiries -->
                        <a href="{{ route('enquiries.index') }}"
                            class="p-6 border-2 border-primary/5 rounded-3xl hover:border-secondary hover:translate-y-[-5px] transition-all group overflow-hidden relative">
                            <i
                                class="fa-solid fa-paper-plane text-3xl text-secondary mb-4 block group-hover:scale-110 transition-transform"></i>
                            <h4 class="font-bold text-lg mb-2">Inquiry History</h4>
                            <p class="text-sm text-gray-500">Track all the messages and leads you've sent to agents.</p>
                            <div
                                class="absolute -right-4 -bottom-4 w-20 h-20 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform">
                            </div>
                        </a>

                        <!-- Profile/Settings -->
                        <a href="{{ route('profile.edit') }}"
                            class="p-6 border-2 border-primary/5 rounded-3xl hover:border-secondary hover:translate-y-[-5px] transition-all group overflow-hidden relative">
                            <i
                                class="fa-solid fa-user-gear text-3xl text-secondary mb-4 block group-hover:scale-110 transition-transform"></i>
                            <h4 class="font-bold text-lg mb-2">Account Settings</h4>
                            <p class="text-sm text-gray-500">Update your profile, password, and preferences.</p>
                            <div
                                class="absolute -right-4 -bottom-4 w-20 h-20 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>