@extends('layouts.master')

@section('title', 'Contact Us')

@section('content')
<!--===== CONTACT US AREA STARTS =======-->
<div class="contact-page-section-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact-page-header-area text-center">
                    <h1>Contact Us</h1>
                    <div class="space24"></div>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CONTACT US AREA ENDS =======-->

<!--===== CONTACT FORM AREA STARTS =======-->
<div class="contact-form-section-area sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-form-area">
                    <div class="section-title1 text-center">
                        <h2>Get In Touch</h2>
                        <div class="space16"></div>
                        <p>Feel free to contact us for any queries or information you need.</p>
                    </div>
                    <div class="space32"></div>
                    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-area mb-4">
                                    <label>Name</label>
                                    <input type="text" name="name" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-area mb-4">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" placeholder="Your Phone Number">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-area mb-4">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-area mb-4">
                                    <label>Subject</label>
                                    <input type="text" name="subject" placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-area mb-4">
                                    <label>Message</label>
                                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="theme-btn1 w-100">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CONTACT FORM AREA ENDS =======-->

<!--===== CONTACT DETAILS AREA STARTS =======-->
<div class="contact-info-section-area sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title1 text-center">
                    <h2>Contact Details</h2>
                    <div class="space16"></div>
                    <p>Reach out to us through the following channels</p>
                </div>
            </div>
        </div>
        <div class="space48"></div>
        <div class="row">
            <div class="col-lg-4">
                <div class="contact-single-info text-center">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"></path>
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"></path>
                        </svg>
                    </div>
                    <div class="space16"></div>
                    <h5>Email Us</h5>
                    <div class="space8"></div>
                    <p>findauk@gmail.com</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-single-info text-center">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"></path>
                        </svg>
                    </div>
                    <div class="space16"></div>
                    <h5>Call Us</h5>
                    <div class="space8"></div>
                    <p>(234) 345-4574</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-single-info text-center">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="space16"></div>
                    <h5>Visit Us</h5>
                    <div class="space8"></div>
                    <p>123 Business Street, London, UK</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CONTACT DETAILS AREA ENDS =======-->
@endsection