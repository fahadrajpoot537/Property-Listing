@extends('layouts.modern')

@section('title', 'Verify Your Email - PropertyFinda')

@section('content')
    <div class="min-h-screen pt-24 md:pt-32 pb-12 flex items-center justify-center px-4 bg-gray-50">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100 animate-fadeInUp">
            
            <!-- Icon Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto bg-secondary/10 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-envelope-circle-check text-4xl text-secondary"></i>
                </div>
                <h2 class="text-3xl font-black text-primary mb-2">Verify Your Email</h2>
                <p class="text-gray-500 font-medium">Thanks for signing up! A verification email has been sent to you.</p>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-5 mb-8">
                <p class="text-sm text-blue-700 font-medium leading-relaxed">
                    <i class="fa-solid fa-info-circle mr-2"></i>
                    Please check your inbox and click the verification link to activate your account. If you don't see it, check your spam folder.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 font-medium flex items-start gap-3">
                    <i class="fa-solid fa-circle-check mt-0.5"></i>
                    <span>A new verification link has been sent to your email address.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mb-6">
                @csrf
                <button type="submit"
                    class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-extrabold text-lg rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-paper-plane"></i>
                    Resend Verification Email
                </button>
            </form>

            <div class="text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-gray-600 hover:text-secondary font-bold text-sm transition-colors underline">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection