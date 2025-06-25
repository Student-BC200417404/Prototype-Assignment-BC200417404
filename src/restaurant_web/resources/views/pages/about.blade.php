@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">About Us</h1>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- About Us Section Start -->
<div class="about-us">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <!-- About Us Image Start -->
                <div class="about-us-image">
                    <div class="about-us-img">
                        <figure class="image-anime">
                            <img src="{{ asset('images/about-us-image.jpg') }}" alt="Our restaurant's inviting interior">
                        </figure>
                    </div>
                    <div class="company-experience">
                        <div class="icon-box">
                            <img src="{{ asset('images/icon-company-experience.svg') }}" alt="">
                        </div>
                        <div class="company-experience-content">
                            <h3><span class="counter">30</span>+ years of experience</h3>
                        </div>
                    </div>
                    <div class="about-author-img">
                        <figure class="image-anime">
                            <img src="{{ asset('images/about-us-img-2.jpg') }}" alt="Our head chef">
                        </figure>
                    </div>
                </div>
                <!-- About Us Image End -->
            </div>

            <div class="col-lg-6">
                <!-- About Us Content Start -->
                <div class="about-us-content">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Our Story</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">A Tradition of <span>Excellence</span></h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            Founded over three decades ago, {{ config('app.name') }} began as a humble family kitchen with a passion for authentic flavors and heartfelt hospitality. Our journey has been one of dedication—to sourcing the finest local ingredients, to perfecting timeless recipes, and to creating a space where every guest feels like part of our family.
                        </p>
                        <p class="wow fadeInUp" data-wow-delay="0.3s">
                            We believe that dining is more than just food; it's an experience. It's about the celebration of connection, the joy of discovery, and the creation of cherished memories.
                        </p>
                    </div>
                    <div class="about-content-list wow fadeInUp" data-wow-delay="0.4s">
                        <ul>
                            <li>Commitment to seasonal & locally sourced ingredients</li>
                            <li>A wide range of vegetarian & dietary-friendly options</li>
                            <li>Exquisite pairings & a curated selection of unique flavors</li>
                        </ul>
                    </div>
                </div>
                <!-- About Us Content End -->
            </div>
        </div>
    </div>
</div>
<!-- About Us Section End -->

<!-- Our Team Section Start -->
<div class="our-team" style="padding: 100px 0;">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">Our Professionals</h3>
                    <h2 class="text-anime-style-2" data-cursor="-opaque">Meet The <span>Team</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="team-member wow fadeInUp">
                    <div class="team-member-image">
                        <img src="https://images.pexels.com/photos/3771120/pexels-photo-3771120.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Team Member 1">
                    </div>
                    <div class="team-member-content">
                        <h3>Marco Bianchi</h3>
                        <p>Head Chef</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team-member wow fadeInUp" data-wow-delay="0.2s">
                    <div class="team-member-image">
                        <img src="https://images.pexels.com/photos/3762800/pexels-photo-3762e00.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Team Member 2">
                    </div>
                    <div class="team-member-content">
                        <h3>Isabella Rossi</h3>
                        <p>Restaurant Manager</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team-member wow fadeInUp" data-wow-delay="0.4s">
                    <div class="team-member-image">
                        <img src="https://images.pexels.com/photos/5668858/pexels-photo-5668858.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Team Member 3">
                    </div>
                    <div class="team-member-content">
                        <h3>Leo Ricci</h3>
                        <p>Lead Sommelier</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Team Section End -->
@endsection 