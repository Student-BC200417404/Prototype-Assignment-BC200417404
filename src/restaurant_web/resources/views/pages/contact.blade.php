@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">Contact Us</h1>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Contact Section Start -->
<div class="contact-section" style="padding: 120px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">Get In Touch</h3>
                    <h2 class="text-anime-style-2" data-cursor="-opaque">We'd Love to Hear <span>From You</span></h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">
                        Whether you have a question, a reservation inquiry, or feedback, our team is here to help.
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <!-- Contact Form Start -->
                <div class="contact-form wow fadeInUp">
                    <form id="contactForm" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="form-group col-md-6 mb-4">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn-default">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Contact Form End -->
            </div>
            <div class="col-lg-5 offset-lg-1">
                <!-- Contact Info Start -->
                <div class="contact-info wow fadeInUp" data-wow-delay="0.2s">
                    <div class="contact-info-item">
                        <div class="icon-box"><i class="fa-solid fa-location-dot"></i></div>
                        <h3>Our Address</h3>
                        <p>123 Culinary Lane, Foodie City, FS 45678</p>
                    </div>
                    <div class="contact-info-item">
                        <div class="icon-box"><i class="fa-solid fa-envelope"></i></div>
                        <h3>Email Us</h3>
                        <p>contact@eatz.com</p>
                    </div>
                    <div class="contact-info-item">
                        <div class="icon-box"><i class="fa-solid fa-phone"></i></div>
                        <h3>Call Us</h3>
                        <p>+1 (234) 567-890</p>
                    </div>
                </div>
                <!-- Contact Info End -->
            </div>
        </div>
    </div>
</div>
<!-- Contact Section End -->
@endsection 