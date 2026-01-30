@extends('layouts.master')

@section('title', 'Contact Us')

@section('content')
    <!--===== PAGE HERO AREA STARTS =======-->
    <div class="common-hero-section-area sp1" style="background-color: #f4f5f7; position: relative;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto my-5">
                    <div class="common-hero-content text-center">
                        <h1 class="text-dark text-anime-style-3">Contact Us</h1>
                        <div class="space16"></div>
                        <ul class="page-list text-dark d-flex justify-content-center align-items-center"
                            style="list-style: none; padding: 0;">
                            <li class="px-1"><a href="{{ url('/') }}" class="text-dark"
                                    style="text-decoration: none;">Home</a></li>
                            <li class="px-1 text-dark">/</li>
                            <li class="px-1" style="color: #1CD494;">Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== PAGE HERO AREA ENDS =======-->

    <!--===== CONTACT AREA STARTS =======-->
    <div class="contact-main-section-area" style="padding-top: 40px; padding-bottom: 80px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="contact-info-box-area">
                        <div class="heading1">
                            <h5>Contact Info</h5>
                            <div class="space16"></div>
                            <h2>Get In Touch With Us</h2>
                            <div class="space16"></div>
                            <p>We are here to help you. Reach out to us via any of the following channels.</p>
                        </div>
                        <div class="space32"></div>

                        <div class="contact-info-list">
                            <div class="single-info-box d-flex align-items-center mb-4">
                                <div class="icon-box"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: #eef2f6; border-radius: 50%; color: #000; margin-right: 20px;">
                                    <i class="fa-solid fa-envelope fa-lg"></i>
                                </div>
                                <div class="content">
                                    <p class="mb-1 text-muted">Email address</p>
                                    <h6 class="m-0 font-weight-bold">findauk@gmail.com</h6>
                                </div>
                            </div>

                            <div class="single-info-box d-flex align-items-center mb-4">
                                <div class="icon-box"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: #eef2f6; border-radius: 50%; color: #000; margin-right: 20px;">
                                    <i class="fa-solid fa-phone fa-lg"></i>
                                </div>
                                <div class="content">
                                    <p class="mb-1 text-muted">Phone Number</p>
                                    <h6 class="m-0 font-weight-bold">(234) 345-4574</h6>
                                </div>
                            </div>

                            <div class="single-info-box d-flex align-items-center">
                                <div class="icon-box"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: #eef2f6; border-radius: 50%; color: #000; margin-right: 20px;">
                                    <i class="fa-solid fa-location-dot fa-lg"></i>
                                </div>
                                <div class="content">
                                    <p class="mb-1 text-muted">Office Address</p>
                                    <h6 class="m-0 font-weight-bold">123 Business Street, London, UK</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-form-box-area bg-white p-5 rounded shadow-sm border">
                        <div class="heading1 mb-4">
                            <h2>Send us a Message</h2>
                        </div>
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-area mb-3">
                                        <label class="form-label font-weight-bold">Your Name</label>
                                        <input type="text" name="name" class="form-control p-3 bg-light border-0"
                                            placeholder="John Doe" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-area mb-3">
                                        <label class="form-label font-weight-bold">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control p-3 bg-light border-0"
                                            placeholder="+1 (123) 456-7890">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-area mb-3">
                                        <label class="form-label font-weight-bold">Email Address</label>
                                        <input type="email" name="email" class="form-control p-3 bg-light border-0"
                                            placeholder="example@gmail.com" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-area mb-3">
                                        <label class="form-label font-weight-bold">Subject</label>
                                        <input type="text" name="subject" class="form-control p-3 bg-light border-0"
                                            placeholder="How can we help?">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-area mb-3">
                                        <label class="form-label font-weight-bold">Message</label>
                                        <textarea name="message" rows="5" class="form-control p-3 bg-light border-0"
                                            placeholder="Write your message here..." required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="space24"></div>
                                    <button type="submit" class="theme-btn1 w-100">Send Message <span><i
                                                class="fa-solid fa-paper-plane"></i></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== CONTACT AREA ENDS =======-->

    <!--===== MAP AREA STARTS =======-->
    <div class="map-section-area">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158857.7281066703!2d-0.24168144921176335!3d51.5287718408761!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C%20UK!5e0!3m2!1sen!2sbd!4v1687258066558!5m2!1sen!2sbd"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!--===== MAP AREA ENDS =======-->
@endsection