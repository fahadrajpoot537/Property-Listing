@extends('layouts.modern')

@section('title', 'GDPR Compliance | PropertyFinda')

@section('content')
    <div class="bg-gray-50 py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
                <h1 class="text-3xl md:text-4xl font-black text-primary mb-8 tracking-tight">GDPR Compliance</h1>
                <p class="text-gray-500 mb-8 text-sm uppercase tracking-widest font-bold">Statement of Compliance</p>

                <div class="prose prose-lg prose-slate max-w-none text-gray-600">
                    <h3>Our Commitment to GDPR</h3>
                    <p>The General Data Protection Regulation (GDPR) is a regulation in EU law on data protection and
                        privacy in the European Union (EU) and the European Economic Area (EEA). It also addresses the
                        transfer of personal data outside the EU and EEA areas. PropertyFinda is committed to compliance
                        with the
                        GDPR and the UK Data Protection Act 2018.</p>

                    <h3>Processing Personal Data</h3>
                    <p>We process personal data only when we have a lawful basis to do so. The lawful bases we rely on
                        include:</p>
                    <ul>
                        <li><strong>Consent:</strong> You have given clear consent for us to process your personal data for
                            a specific purpose.</li>
                        <li><strong>Contract:</strong> The processing is necessary for a contract we have with you, or
                            because you have asked us to take specific steps before entering into a contract.</li>
                        <li><strong>Legal obligation:</strong> The processing is necessary for us to comply with the law.
                        </li>
                        <li><strong>Legitimate interests:</strong> The processing is necessary for our legitimate interests
                            or the legitimate interests of a third party.</li>
                    </ul>

                    <h3>Data Subject Rights</h3>
                    <p>As a data subject, you have the following rights under GDPR:</p>
                    <ul>
                        <li>The right to be informed about how we use your data.</li>
                        <li>The right of access to your personal data.</li>
                        <li>The right to rectification of inaccurate data.</li>
                        <li>The right to erasure ("right to be forgotten").</li>
                        <li>The right to restrict processing.</li>
                        <li>The right to data portability.</li>
                        <li>The right to object to processing.</li>
                        <li>Rights in relation to automated decision making and profiling.</li>
                    </ul>

                    <h3>Data Breaches</h3>
                    <p>In the event of a data breach that is likely to result in a risk to your rights and freedoms, we will
                        notify the Information Commissioner's Office (ICO) within 72 hours of becoming aware of the breach.
                    </p>

                    <h3>Contact Our Data Protection Officer</h3>
                    <p>If you have any questions about our GDPR compliance or wish to exercise your rights, please contact
                        our Data Protection Officer at: <a href="mailto:dpo@propertyfinda.co.uk"
                            class="text-secondary font-bold">dpo@propertyfinda.co.uk</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection