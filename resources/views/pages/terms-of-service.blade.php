@extends('layouts.modern')

@section('title', 'Terms of Service | Finda UK')

@section('content')
    <div class="bg-gray-50 py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
                <h1 class="text-3xl md:text-4xl font-black text-primary mb-8 tracking-tight">Terms of Service</h1>
                <p class="text-gray-500 mb-8 text-sm uppercase tracking-widest font-bold">Effective Date: {{ date('F Y') }}
                </p>

                <div class="prose prose-lg prose-slate max-w-none text-gray-600">
                    <h3>1. Acceptance of Terms</h3>
                    <p>By accessing and using Finda UK (the "Service"), you accept and agree to be bound by the terms and
                        provision of this agreement. In addition, when using these particular services, you shall be subject
                        to any posted guidelines or rules applicable to such services.</p>

                    <h3>2. Provision of Services</h3>
                    <p>You agree and acknowledge that Finda UK is entitled to modify, improve or discontinue any of its
                        services at its sole discretion and without notice to you even if it may result in you being
                        prevented from accessing any information contained in it.</p>

                    <h3>3. Proprietary Rights</h3>
                    <p>You acknowledge and agree that Finda UK may contain proprietary and confidential information
                        including trademarks, service marks and patents protected by intellectual property laws and
                        international intellectual property treaties. Finda UK authorizes you to view and make a single copy
                        of portions of its content for offline, personal, non-commercial use. Our content may not be sold,
                        reproduced, or distributed without our written permission.</p>

                    <h3>4. Submitted Content</h3>
                    <p>When you submit content to Finda UK you simultaneously grant Finda UK an irrevocable, worldwide,
                        royalty free license to publish, display, modify, distribute and syndicate your content worldwide.
                        You confirm and warrant that you have the required authority to grant the above license to Finda UK.
                    </p>

                    <h3>5. Termination of Agreement</h3>
                    <p>The Terms of this agreement will continue to apply in perpetuity until terminated by either party
                        without notice at any time for any reason. Terms that are to continue in perpetuity shall be
                        unaffected by the termination of this agreement.</p>

                    <h3>6. Disclaimer of Warranties</h3>
                    <p>You understand and agree that your use of Finda UK is entirely at your own risk and that our services
                        are provided "As Is" and "As Available". Finda UK does not make any express or implied warranties,
                        endorsements or representations whatsoever as to the operation of the Finda UK website, information,
                        content, materials, or products.</p>

                    <h3>7. Jurisdiction</h3>
                    <p>You expressly understand and agree to submit to the personal and exclusive jurisdiction of the courts
                        of the United Kingdom to resolve any legal matter arising from this agreement or related to your use
                        of Finda UK.</p>
                </div>
            </div>
        </div>
    </div>
@endsection