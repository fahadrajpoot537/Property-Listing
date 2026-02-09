@extends('layouts.modern')

@section('title', 'Cookie Policy | Finda UK')

@section('content')
    <div class="bg-gray-50 py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
                <h1 class="text-3xl md:text-4xl font-black text-primary mb-8 tracking-tight">Cookie Policy</h1>
                <p class="text-gray-500 mb-8 text-sm uppercase tracking-widest font-bold">Last updated: {{ date('F Y') }}
                </p>

                <div class="prose prose-lg prose-slate max-w-none text-gray-600">
                    <h3>1. What Are Cookies</h3>
                    <p>As is common practice with almost all professional websites this site uses cookies, which are tiny
                        files that are downloaded to your computer, to improve your experience. This page describes what
                        information they gather, how we use it and why we sometimes need to store these cookies.</p>

                    <h3>2. How We Use Cookies</h3>
                    <p>We use cookies for a variety of reasons detailed below. Unfortunately in most cases there are no
                        industry standard options for disabling cookies without completely disabling the functionality and
                        features they add to this site.</p>

                    <h3>3. The Cookies We Set</h3>
                    <ul>
                        <li>
                            <strong>Account related cookies:</strong> If you create an account with us then we will use
                            cookies for the management of the signup process and general administration.
                        </li>
                        <li>
                            <strong>Login related cookies:</strong> We use cookies when you are logged in so that we can
                            remember this fact. This prevents you from having to log in every single time you visit a new
                            page.
                        </li>
                        <li>
                            <strong>Site preferences cookies:</strong> In order to provide you with a great experience on
                            this site we provide the functionality to set your preferences for how this site runs when you
                            use it.
                        </li>
                    </ul>

                    <h3>4. Third Party Cookies</h3>
                    <p>In some special cases we also use cookies provided by trusted third parties. The following section
                        details which third party cookies you might encounter through this site.</p>
                    <ul>
                        <li>This site uses Google Analytics which is one of the most widespread and trusted analytics
                            solution on the web for helping us to understand how you use the site and ways that we can
                            improve your experience.</li>
                        <li>We also use social media buttons and/or plugins on this site that allow you to connect with your
                            social network in various ways.</li>
                    </ul>

                    <h3>5. Managing Cookies</h3>
                    <p>You can prevent the setting of cookies by adjusting the settings on your browser (see your browser
                        Help for how to do this). Be aware that disabling cookies will affect the functionality of this and
                        many other websites that you visit.</p>
                </div>
            </div>
        </div>
    </div>
@endsection