@extends('layouts.admin')

@section('header', 'Mortgage Settings')

@section('content')
    <div class="bg-white rounded-premium shadow-premium p-6 sm:p-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Setup Mortgage Defaults</h2>
                <p class="text-slate-500 mt-1 text-sm">Configure default values for the front-end mortgage calculator.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.mortgage-settings.update', $setting->id) }}"
            class="space-y-6 max-w-2xl">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- Down Payment Percentage -->
                <div>
                    <label for="down_payment_percentage" class="block text-sm font-semibold text-slate-700 mb-2">Default
                        Down Payment (%)</label>
                    <div class="relative">
                        <input type="number" step="0.01" min="0" max="100" id="down_payment_percentage"
                            name="down_payment_percentage"
                            value="{{ old('down_payment_percentage', $setting->down_payment_percentage) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#1cd494] focus:border-[#1cd494] outline-none transition-all font-medium text-slate-800 placeholder-slate-400">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-bold">%</span>
                        </div>
                    </div>
                    @error('down_payment_percentage')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Interest Rate -->
                <div>
                    <label for="interest_rate" class="block text-sm font-semibold text-slate-700 mb-2">Default Interest Rate
                        (%)</label>
                    <div class="relative">
                        <input type="number" step="0.01" min="0" max="100" id="interest_rate" name="interest_rate"
                            value="{{ old('interest_rate', $setting->interest_rate) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#1cd494] focus:border-[#1cd494] outline-none transition-all font-medium text-slate-800 placeholder-slate-400">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-bold">%</span>
                        </div>
                    </div>
                    @error('interest_rate')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Term Years -->
                <div>
                    <label for="loan_term_years" class="block text-sm font-semibold text-slate-700 mb-2">Default Loan Term
                        (Years)</label>
                    <div class="relative">
                        <input type="number" step="1" min="1" max="50" id="loan_term_years" name="loan_term_years"
                            value="{{ old('loan_term_years', $setting->loan_term_years) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#1cd494] focus:border-[#1cd494] outline-none transition-all font-medium text-slate-800 placeholder-slate-400">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-bold">Years</span>
                        </div>
                    </div>
                    @error('loan_term_years')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit"
                    class="bg-[#1cd494] hover:bg-[#15a875] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-emerald-100 transition-all transform hover:-translate-y-1">
                    Save Changes (Update)
                </button>
            </div>
        </form>
    </div>
@endsection