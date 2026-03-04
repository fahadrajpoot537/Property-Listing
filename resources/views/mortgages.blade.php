@extends('layouts.modern')

@section('title', 'Mortgage Rates & Calculator - PropertyFinda')

@section('content')
    <div class="bg-gray-50 pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <nav class="flex justify-center mb-4 text-xs font-bold text-gray-400 gap-2 uppercase tracking-widest">
                    <a href="{{ route('home') }}" class="hover:text-secondary">Home</a>
                    <span>/</span>
                    <span class="text-primary">Mortgages</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-black text-primary mb-6">Mortgage Solutions</h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto font-medium leading-relaxed">
                    Find the perfect financial package for your next property investment. Use our precision calculator to
                    estimate your monthly payments.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Calculator Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary/5 p-8 md:p-12 border border-gray-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary text-2xl">
                                <i class="fa-solid fa-calculator"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-primary">Mortgage Calculator</h2>
                                <p class="text-sm text-gray-400 font-bold uppercase tracking-wider">Plan your budget with
                                    confidence</p>
                            </div>
                        </div>

                        <x-mortgage-calculator>0</x-mortgage-calculator>

                        <div class="mt-12 bg-primary text-white p-8 rounded-3xl relative overflow-hidden">
                            <div class="relative z-10">
                                <h3 class="text-2xl font-black mb-2">Need Professional Advice?</h3>
                                <p class="text-gray-300 font-medium mb-6">Our partner mortgage brokers provide exclusive
                                    rates not found on the high street.</p>
                                <a href="{{ route('contact.create') }}"
                                    class="inline-flex items-center gap-2 bg-secondary text-white px-8 py-4 rounded-2xl font-black hover:bg-secondary/90 transition-all shadow-xl shadow-secondary/20">
                                    Connect with a Broker
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                            <div class="absolute -right-8 -bottom-8 opacity-10">
                                <i class="fa-solid fa-house-circle-check text-[12rem]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                        <h3 class="text-xl font-black text-primary mb-6">Why use PropertyFinda?</h3>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 shrink-0">
                                    <i class="fa-solid fa-percent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1 text-sm">Exclusive Rates</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Access over 12,000 mortgage
                                        products from 90+ lenders.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 shrink-0">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1 text-sm">Fast Decisions</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Agreement in Principle
                                        (AIP) often within minutes.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 shrink-0">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1 text-sm">Expert Support</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed font-medium">A dedicated case manager to
                                        handle all your paperwork.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-900 p-8 rounded-[2rem] text-white">
                        <h3 class="text-lg font-black mb-4">Mortgage Terminology</h3>
                        <div class="space-y-4">
                            <div class="border-b border-white/10 pb-3">
                                <h5 class="text-xs font-black text-secondary tracking-widest uppercase mb-1">Fixed Rate</h5>
                                <p class="text-[11px] text-gray-400 font-medium">Your monthly payments stay the same for a
                                    set period.</p>
                            </div>
                            <div class="border-b border-white/10 pb-3">
                                <h5 class="text-xs font-black text-secondary tracking-widest uppercase mb-1">LTV (Loan to
                                    Value)</h5>
                                <p class="text-[11px] text-gray-400 font-medium">The ratio of the loan amount to the value
                                    of the property.</p>
                            </div>
                            <div>
                                <h5 class="text-xs font-black text-secondary tracking-widest uppercase mb-1">Standard
                                    Variable Rate</h5>
                                <p class="text-[11px] text-gray-400 font-medium">The rate you usually move to after a fixed
                                    deal ends.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection