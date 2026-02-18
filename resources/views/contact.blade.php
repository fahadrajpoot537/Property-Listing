@extends('layouts.modern')

@section('title', 'Contact Us | PropertyFinda')

@section('content')
    <!-- Portal Hero Search Section (Reused Style) -->
    <div class="relative bg-primary overflow-visible">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('1.jpg') }}" class="w-full h-full object-cover opacity-40 mix-blend-overlay"
                alt="Background">
            <div class="absolute inset-0 bg-primary/80 mix-blend-multiply"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center">
                <h1 class="text-3xl md:text-6xl font-extrabold text-white mb-4 tracking-tight">Get in touch</h1>
                <p class="text-xl text-gray-300 font-medium">We're here to help you find your happy place</p>
            </div>
        </div>
    </div>

    <!-- Contact Content Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8 items-start">

                <!-- Contact Info Cards (Home Category Style) -->
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="flex flex-col items-center p-8 bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-secondary hover:shadow-xl hover:shadow-secondary/5 transition-all group">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-secondary group-hover:text-white transition-colors mb-4">
                            <i class="fa-solid fa-envelope text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Email us</span>
                        <span class="font-bold text-gray-800 text-lg">info@propertyfinda.co.uk</span>
                    </div>

                    <div
                        class="flex flex-col items-center p-8 bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-secondary hover:shadow-xl hover:shadow-secondary/5 transition-all group">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-secondary group-hover:text-white transition-colors mb-4">
                            <i class="fa-solid fa-location-dot text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Visit us</span>
                        <span class="font-bold text-gray-800 text-lg text-center">5-7 High Street London United Kingdom. E
                            13 0AD</span>
                    </div>
                    <div id="map" style="
                                                width:100%;
                                                height:165px;
                                                border-radius:15px;
                                                box-shadow: 0 8px 25px rgba(128, 70, 241, 0.45);
                                            ">
                    </div>

                </div>

                <!-- Contact Form (Search Box Inspired Style) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 border border-gray-100">
                        <h2 class="text-2xl font-extrabold text-primary mb-8 tracking-tight">Send us a message</h2>

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">Full Name</label>
                                    <input type="text" name="name" required placeholder="Your name"
                                        class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-900">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">Email Address</label>
                                    <input type="email" name="email" required placeholder="your@email.com"
                                        class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-900">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone" placeholder="+44"
                                        class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-900">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">Subject</label>
                                    <input type="text" name="subject" required placeholder="How can we help?"
                                        class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-900">
                                </div>
                            </div>

                            <div class="space-y-2 mb-8">
                                <label class="text-sm font-bold text-gray-700">Message</label>
                                <textarea name="message" rows="5" required placeholder="Tell us more about your inquiry..."
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-900 resize-none"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full md:w-auto px-12 py-4 bg-secondary hover:bg-secondary-dark text-white font-extrabold text-lg rounded-xl shadow-lg shadow-secondary/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                Send Message <i class="fa-solid fa-paper-plane text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->

    <script>
        function initMap() {
            const location = { lat: 51.531156, lng: 0.017096 };

            // Check if google is defined (it should be from the layout)
            if (typeof google === 'undefined') {
                console.error("Google Maps API not loaded");
                return;
            }

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: location,
                styles: [
                    {
                        elementType: "geometry",
                        stylers: [{ color: "#ffffff" }]
                    },
                    {
                        elementType: "labels.text.fill",
                        stylers: [{ color: "#000000" }]
                    },
                    {
                        elementType: "labels.text.stroke",
                        stylers: [{ color: "#ffffff" }]
                    },
                    {
                        featureType: "road",
                        elementType: "geometry",
                        stylers: [{ color: "#474242ff" }]
                    },
                    {
                        featureType: "road",
                        elementType: "labels.text.fill",
                        stylers: [{ color: "#000000" }]
                    },
                    {
                        featureType: "poi",
                        stylers: [{ visibility: "off" }]
                    },
                    {
                        featureType: "transit",
                        stylers: [{ visibility: "off" }]
                    },
                    {
                        featureType: "water",
                        elementType: "geometry",
                        stylers: [{ color: "#ffffff" }]
                    }
                ]
            });

            new google.maps.Marker({
                position: location,
                map: map
            });
        }

        // Wait for the Google Maps API key from the layout to load
        window.addEventListener('load', function () {
            // Helper to check if API is ready
            const checkGoogle = setInterval(function () {
                if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                    clearInterval(checkGoogle);
                    initMap();
                }
            }, 100);
        });
    </script>

@endsection