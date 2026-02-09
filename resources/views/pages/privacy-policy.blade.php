@extends('layouts.modern')

@section('title', 'Privacy Policy | Finda UK')

@section('content')
    <div class="bg-gray-50 py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
                <h1 class="text-3xl md:text-4xl font-black text-primary mb-8 tracking-tight">Privacy Policy</h1>
                <p class="text-gray-500 mb-8 text-sm uppercase tracking-widest font-bold">Last updated: {{ date('F Y') }}
                </p>

                <div class="prose prose-lg prose-slate max-w-none text-gray-600">
                    <h3>1. Introduction</h3>
                    <p>Welcome to Finda UK ("we," "our," or "us"). We are committed to protecting your personal data and
                        respecting your privacy. This privacy policy explains how we handle your personal data when you
                        visit our website (regardless of where you visit it from) and tells you about your privacy rights
                        and how the law protects you.</p>

                    <h3>2. Data We Collect</h3>
                    <p>We may collect, use, store and transfer different kinds of personal data about you which we have
                        grouped together follows:</p>
                    <ul>
                        <li><strong>Identity Data:</strong> includes first name, last name, username or similar identifier.
                        </li>
                        <li><strong>Contact Data:</strong> includes billing address, delivery address, email address and
                            telephone numbers.</li>
                        <li><strong>Technical Data:</strong> includes internet protocol (IP) address, your login data,
                            browser type and version, time zone setting and location, browser plug-in types and versions,
                            operating system and platform, and other technology on the devices you use to access this
                            website.</li>
                    </ul>

                    <h3>3. How We Use Your Data</h3>
                    <p>We will only use your personal data when the law allows us to. Most commonly, we will use your
                        personal data in the following circumstances:</p>
                    <ul>
                        <li>Where we need to perform the contract we are about to enter into or have entered into with you.
                        </li>
                        <li>Where it is necessary for our legitimate interests (or those of a third party) and your
                            interests and fundamental rights do not override those interests.</li>
                        <li>Where we need to comply with a legal obligation.</li>
                    </ul>

                    <h3>4. Data Security</h3>
                    <p>We have put in place appropriate security measures to prevent your personal data from being
                        accidentally lost, used or accessed in an unauthorized way, altered or disclosed. In addition, we
                        limit access to your personal data to those employees, agents, contractors and other third parties
                        who have a business need to know.</p>

                    <h3>5. Your Legal Rights</h3>
                    <p>Under certain circumstances, you have rights under data protection laws in relation to your personal
                        data, including the right to receive a copy of the personal data we hold about you and the right to
                        make a complaint at any time to the Information Commissioner's Office (ICO), the UK supervisory
                        authority for data protection issues (www.ico.org.uk).</p>

                    <h3>6. Contact Details</h3>
                    <p>If you have any questions about this privacy policy or our privacy practices, please contact us at:
                        <a href="mailto:privacy@propertyfinda.co.uk"
                            class="text-secondary font-bold">privacy@propertyfinda.co.uk</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection