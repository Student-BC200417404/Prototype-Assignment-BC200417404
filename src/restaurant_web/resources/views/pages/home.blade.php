@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- Hero Section Start -->
    <div class="hero parallaxie">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Hero Content Start -->
                    <div class="hero-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">art of fine dining</h3>
                            <h1 class="text-anime-style-2" data-cursor="-opaque">Dining redefined with <span>every bite</span></h1>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Immerse yourself in a dining experience like no other, where every dish is a masterpiece of flavor, crafted with care and precision. From the freshest ingredients.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Hero Button Start -->
                        <div class="hero-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="{{ route('contact') }}" class="btn-default">book a table</a>
                            </div>
                        <!-- Hero Button End -->
                    </div>
                    <!-- Hero Content End -->                   
                </div>

                <div class="col-lg-6">
                    <!-- Hero Images Start -->
                    <div class="hero-images">
                        <!-- Hero Image Start -->
                        <div class="hero-image">
                            <figure class="image-anime">
                                <img src="{{ asset('images/hero-img.jpg') }}" alt="">
                            </figure>                            
                        </div>  
                        <!-- Hero Image End -->    

                        <!-- Hero Circle Image Start -->
                        <div class="hero-circle-img-1">
                            <figure class="image-anime">
                                <img src="{{ asset('images/hero-circle-img-1.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- Hero Circle Image End -->

                        <!-- Hero Circle Image Start -->
                        <div class="hero-circle-img-2">
                            <figure class="image-anime">
                                <img src="{{ asset('images/hero-circle-img-2.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- Hero Circle Image End -->
                    </div>
                    <!-- Hero Images End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- About Us Section Start -->
    <div class="about-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1 order-2">
                    <!-- About Us Image Start -->
                    <div class="about-us-image">
                        <!-- About Us Img Start -->
                        <div class="about-us-img">
                            <figure class="image-anime">
                                <img src="{{ asset('images/about-us-image.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- About Us Img End -->

                        <!-- Company Experience Box Start -->
                        <div class="company-experience">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-company-experience.svg') }}" alt="">
                            </div>

                            <div class="company-experience-content">
                                <h3><span class="counter">30</span>+ years of experience</h3>
                            </div>
                        </div>
                        <!-- Company Experience Box End -->

                        <!-- About Author Image Start -->
                        <div class="about-author-img">
                            <figure class="image-anime">
                                <img src="{{ asset('images/about-us-img-2.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- About Author Image End -->
                    </div>
                    <!-- About Us Image End -->
                </div>

                <div class="col-lg-6  order-lg-2 order-1">
                    <!-- About Us Content Start -->
                    <div class="about-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">about us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Our Commitment to Authenticity & <span>excellence</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Every dish we create is a celebration of connection, crafted with passion and inspired by diverse flavors. Join us in an inviting space where every bite sparks joy and every moment becomes a cherished memory.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- About Content List Start -->
                        <div class="about-content-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>seasonal & locally sourced ingredients</li>
                                <li>vegetarian & dietary-friendly options</li>
                                <li>exquisite pairings & unique flavors</li>
                            </ul>
                        </div>
                        <!-- About Content List End -->

                        <!-- About Content Buttons Start -->
                        <div class="about-content-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="{{ route('menu') }}" class="btn-default">order now</a>
                            <a href="{{ route('about') }}" class="btn-default btn-highlighted">read more</a>
                        </div>
                        <!-- About Content Buttons End -->
                    </div>
                    <!-- About Us Content End -->
                </div>

                <div class="col-lg-12 order-3">
                    <!-- About Detail Box Start -->
                    <div class="about-detail-box">
                        <!-- About Detail Item Start -->
                        <div class="about-detail-item wow fadeInUp">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-about-detail-1.svg') }}" alt="">
                            </div>
                            <div class="about-detail-content">
                                <h3>premium dining</h3>
                                <p>It's very personal, and can only be a positive experience.</p>
                            </div>
                        </div>
                        <!-- About Detail Item End -->
    
                        <!-- About Detail Item Start -->
                        <div class="about-detail-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-about-detail-2.svg') }}" alt="">
                            </div>
                            <div class="about-detail-content">
                                <h3>abundant flavors</h3>
                                <p>At secret recipe, we take immense pride in crafting.</p>
                            </div>
                        </div>
                        <!-- About Detail Item End -->
    
                        <!-- About Detail Item Start -->
                        <div class="about-detail-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-about-detail-3.svg') }}" alt="">
                            </div>
                            <div class="about-detail-content">
                                <h3>indigenous meal</h3>
                                <p>With local ingredients, unique spins on traditional flavors.</p>
                            </div>
                        </div>
                        <!-- About Detail Item End -->
                    </div>
                    <!-- About Detail Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Section End -->

    <!-- Our Dishes Section Start -->
    <div class="our-dishes">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">our main dishes</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Satisfy your cravings with our <span>signature mains</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                @if($featured_categories->isNotEmpty())
                    @foreach($featured_categories as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="our-dish-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 }}s">
                            <div class="our-dish-img">
                                <figure class="image-anime">
                                    <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/our-dish-image-1.jpg') }}" alt="{{ $category->name }}">
                                </figure>
                            </div>
                            <div class="our-dish-content">
                                <h3>{{ $category->name }}</h3>
                                <p>{{ Str::limit($category->description, 100) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                <div class="col-lg-12">
                    <!-- Section Footer Text Start -->
                    <div class="section-footer-text wow fadeInUp" data-wow-delay="0.8s">
                        <p>Hungry for Something Delicious? <a href="{{ route('menu') }}">View All Dishes!</a></p>
                    </div>
                    <!-- Section Footer Text End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Dishes Section End -->

    <!-- Daily Offer Section Start -->
    <div class="daily-offer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Daily Offer Image Start -->
                    <div class="daily-offer-image">
                        <div class="daily-offer-img">
                            <figure>
                                <img src="{{ asset('images/daily-offer-image.png') }}" alt="">
                            </figure>
                        </div>

                        <!-- Delicious Burger Box Start -->
                         <div class="delicious-burger-box">
                            <div class="delicious-burger-title">
                                <h3>Delicious Burger</h3>
                            </div>
                            <div class="delicious-burger-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="delicious-burger-list">
                                <ul>
                                    <li>tomato sauces</li>
                                    <li>vegitables</li>
                                    <li>lettuce</li>
                                    <li>cheese slice</li>
                                </ul>
                            </div>
                         </div>
                        <!-- Delicious Burger Box End -->
                    </div>
                    <!-- Daily Offer Image End -->
                </div>

                <div class="col-lg-6">
                    <!-- Daily Offer Content Start -->
                    <div class="daily-offer-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">our daily offers</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">taste the savings with our <span>daily specials</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Every day is an opportunity to enjoy your favorites at a discounted price. Explore our daily rotating specials and indulge in flavorful meals at a fraction of the cost.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Daily Offer List Start -->
                        <div class="daily-offer-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>seasonal & locally sourced ingredients</li>
                                <li>vegetarian & dietary-friendly options</li>
                                <li>exquisite pairings & unique flavors</li>
                            </ul>
                        </div>
                        <!-- Daily Offer List End -->

                        <!-- Daily Offer Button Start -->
                        <div class="daily-offer-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="#" class="btn-default">book table</a>
                            <a href="{{ route('menu') }}" class="btn-default btn-highlighted">explore menu</a>
                        </div>
                        <!-- Daily Offer Button End -->
                    </div>
                    <!-- Daily Offer Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Daily Offer Section End -->

    <!-- Our Menu Section Start -->
    <div class="our-menu">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">from our menu</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">An Inspired Menu That <span>Blends Tradition</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Our Menu Tab Start -->
                    <div class="our-menu-tab">
                        @if($menu_categories->isNotEmpty())
                        <!-- Sidebar Our Menu Nav start -->
                        <div class="our-menu-tab-nav wow fadeInUp" data-wow-delay="0.2s">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($menu_categories as $category)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $category->slug ?? Str::slug($category->name) }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $category->slug ?? Str::slug($category->name) }}" type="button" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $category->name }}</button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Sidebar Our Menu Nav End -->

                        <!-- Menu Box Start -->
                        <div class="tab-content" id="myTabContent">
                            @foreach($menu_categories as $category)
                            <!-- Menu Item Start -->
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $category->slug ?? Str::slug($category->name) }}" role="tabpanel">
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <!-- Our Menu List Start -->
                                        <div class="our-menu-list">
                                        @php
                                            // Eager load menus if they haven't been loaded yet
                                            $category->loadMissing('menus');
                                        @endphp
                                        @forelse($category->menus as $item)
                                        <!-- Our Menu Item Start -->
                                        <div class="our-menu-item">
                                            <!-- Our Menu Image Start -->
                                            <div class="our-menu-image">
                                                <figure>
                                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/our-menu-image-1.png') }}" alt="{{ $item->name }}">
                                                </figure>
                                            </div>
                                            <!-- Our Menu Image End -->

                                            <!-- Menu Item Body Start -->
                                            <div class="menu-item-body">
                                                <!-- Menu Item Title Start -->
                                                <div class="menu-item-title">
                                                    <h3>{{ $item->name }}</h3>
                                                    <hr>
                                                    <span>${{ number_format($item->price, 2) }}</span>
                                                </div>
                                                <!-- Menu Item Title End -->

                                                <!-- Menu Item Content Start -->
                                                <div class="menu-item-content">
                                                    <p>{{ $item->description }}</p>
                                                </div>
                                                <!-- Menu Item Content End -->
                                            </div>
                                            <!-- Menu Item Body End -->
                                        </div>
                                        <!-- Our Menu Item End -->
                                        @empty
                                            <p>No menu items found in this category.</p>
                                        @endforelse
                                        </div>
                                        <!-- Our Menu List End -->
                                    </div>
                                </div>
                            </div>
                            <!-- Menu Item End -->
                            @endforeach
                        </div>
                        <!-- Menu Box End -->
                        @endif
                    </div>
                    <!-- Our Menu Tab End -->
                </div>

                <div class="col-lg-12">
                    <!-- Section Footer Text Start -->
                    <div class="section-footer-text wow fadeInUp" data-wow-delay="0.4s">
                        <p>Ready to Savor the Best? <a href="{{ route('menu') }}">Check Our Dishes!</a></p>
                    </div>
                    <!-- Section Footer Text End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Menu Section End -->

    <!-- Intro Video Section Start -->
    <div class="intro-video">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Intro Video Box Start -->
                    <div class="intro-video-box">
                        <div class="intro-bg-video">
                            <!-- Selfhosted Video Start -->
                            <!-- <video autoplay muted loop id="myVideo"><source src="{{ asset('images/hero-bg-video.mp4') }}" type="video/mp4"></video> -->
                            <video autoplay muted loop id="myVideo">
                                <source src="{{ asset('videos/spicyhunt-intro-bg-video.mp4') }}" type="video/mp4">
                            </video>
                            <!-- Selfhosted Video End -->

                            <!-- Youtube Video Start -->
                            <!-- <div id="herovideo" class="player" data-property="{videoURL:'74DWwSxsVSs',containment:'.hero-video', showControls:false, autoPlay:true, loop:true, vol:0, mute:false, startAt:0,  stopAt:296, opacity:1, addRaster:true, quality:'large', optimizeDisplay:true}"></div> -->
                            <!-- Youtube Video End -->
                        </div>
                        <!-- Video Play Button Start -->
                        <div class="video-play-button">
                            <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video" data-cursor-text="Play">play</a>
                        </div>
                        <!-- Video Play Button End -->
                    </div>
                    <!-- Intro Video Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Intro Video Section End -->

    <!-- Our Ingredients Section Start -->
    <div class="our-ingredients">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1 order-2">
                    <!-- Our Ingredients Image Start -->
                    <div class="our-ingredients-image">
                        <!-- Our Ingredients Img Start -->
                        <div class="our-ingredients-img">
                            <figure>
                                <img src="{{ asset('images/our-ingredients-image.png') }}" alt="">
                            </figure>
                        </div>
                        <!-- Our Ingredients Img End -->

                        <!-- Happy Customer Box Start -->
                        <div class="happy-customer-box">
                            <!-- Happy Customer Content Start -->
                            <div class="happy-customer-content">
                                <h3><span class="counter">620</span>+ exclusive</h3>
                                <p>happy customer</p>
                            </div>
                            <!-- Happy Customer Content End -->

                            <!-- Customer Review Images Start -->
                            <div class="happy-customer-images">
                                <!-- Customer Image Start -->
                                <div class="customer-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('images/happy-customer-img-1.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <!-- Customer Image End -->

                                <!-- Customer Image Start -->
                                <div class="customer-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('images/happy-customer-img-2.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <!-- Customer Image End -->

                                <!-- Customer Image Start -->
                                <div class="customer-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('images/happy-customer-img-3.jpg') }}" alt="">
                                    </figure>
                                </div>
                                <!-- Customer Image End -->
                                
                                <!-- Add More Customer Icon Start -->
                                <div class="customer-image add-more">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <!-- Add More Customer Icon End -->
                            </div>
                            <!-- Customer Review Images End -->
                        </div>
                        <!-- Happy Customer Box End -->
                    </div>
                    <!-- Our Ingredients Image End -->
                </div>

                <div class="col-lg-6 order-lg-2 order-1">
                    <!-- Our Ingredients Content Start -->
                    <div class="our-ingredients-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">our ingredients</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Crafting Dishes with <span>freshest Flavors</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We take pride in using only the freshest, hand-picked ingredients that are free from preservatives and artificial additives. Taste the difference with every bite as we serve dishes made from nature's finest.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Our Ingredients List Start -->
                        <div class="our-ingredients-list wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Ingredients List Item Start -->
                            <div class="ingredients-list-item">
                                <div class="icon-box">
                                    <img src="{{ asset('images/icon-ingredients-list-1.svg') }}" alt="">
                                </div>
                                <div class="ingredients-list-content">
                                    <h3>best qualities</h3>
                                </div>
                            </div>
                            <!-- Ingredients List Item End -->

                            <!-- Ingredients List Item Start -->
                            <div class="ingredients-list-item">
                                <div class="icon-box">
                                    <img src="{{ asset('images/icon-ingredients-list-2.svg') }}" alt="">
                                </div>
                                <div class="ingredients-list-content">
                                    <h3>discount system</h3>
                                </div>
                            </div>
                            <!-- Ingredients List Item End -->

                            <!-- Ingredients List Item Start -->
                            <div class="ingredients-list-item">
                                <div class="icon-box">
                                    <img src="{{ asset('images/icon-ingredients-list-3.svg') }}" alt="">
                                </div>
                                <div class="ingredients-list-content">
                                    <h3>first delivery</h3>
                                </div>
                            </div>
                            <!-- Ingredients List Item End -->
                        </div>
                        <!-- Our Ingredients List End -->

                        <!-- Our Ingredients Button Start -->
                        <div class="our-ingredients-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="#" class="btn-default">book table</a>
                        </div>
                        <!-- Our Ingredients Button End -->
                    </div>
                    <!-- Our Ingredients Content End -->
                </div>

                <div class="col-lg-12 order-3">
                    <!-- Ingredient Counter List Start -->
                    <div class="ingredient-counter-list">
                        <!-- Ingredient Counter Item Start -->
                        <div class="ingredient-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-ingredient-counter-1.svg') }}" alt="">
                            </div>
                            <div class="ingredient-counter-content">
                                <h2><span class="counter">309</span></h2>
                                <p>Professional chefs</p>
                            </div>
                        </div>
                        <!-- Ingredient Counter Item End -->
                        
                        <!-- Ingredient Counter Item Start -->
                        <div class="ingredient-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-ingredient-counter-2.svg') }}" alt="">
                            </div>
                            <div class="ingredient-counter-content">
                                <h2><span class="counter">453</span></h2>
                                <p>Items of food</p>
                            </div>
                        </div>
                        <!-- Ingredient Counter Item End -->
                        
                        <!-- Ingredient Counter Item Start -->
                        <div class="ingredient-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-ingredient-counter-3.svg') }}" alt="">
                            </div>
                            <div class="ingredient-counter-content">
                                <h2><span class="counter">25</span>+</h2>
                                <p>Years of experience</p>
                            </div>
                        </div>
                        <!-- Ingredient Counter Item End -->
                        
                        <!-- Ingredient Counter Item Start -->
                        <div class="ingredient-counter-item">
                            <div class="icon-box">
                                <img src="{{ asset('images/icon-ingredient-counter-4.svg') }}" alt="">
                            </div>
                            <div class="ingredient-counter-content">
                                <h2><span class="counter">300</span>+</h2>
                                <p>Satisfied clients</p>
                            </div>
                        </div>
                        <!-- Ingredient Counter Item End -->
                    </div>
                    <!-- Ingredient Counter List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Ingredients Section End -->

    <!-- Our Testimonial Section Start -->
    <div class="our-testimonial parallaxie">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">our testimonials</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">real stories of memorable <span>meals and experiences</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Testimonial Slider Start -->
                    <div class="testimonial-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper" data-cursor-text="Drag">
                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-quote">
                                            <img src="{{ asset('images/testimonial-quote.svg') }}" alt="">
                                        </div>
                                        <div class="testimonial-content">
                                            <p>From the moment we walked in, the ambiance was welcoming, and the service was top-notch. The dish was absolutely delicious, full of fresh flavors, and perfectly cooked. I especially loved how the staff took the time to explain the menu and suggest pairings for our meal.</p>
                                        </div>
                                        <div class="author-info">
                                            <div class="author-image">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('images/author-1.jpg') }}" alt="">
                                                </figure>
                                             </div>            
                                            <div class="author-content">
                                                <h3>wade l warren, developer</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-quote">
                                            <img src="{{ asset('images/testimonial-quote.svg') }}" alt="">
                                        </div>
                                        <div class="testimonial-content">
                                            <p>From the moment we walked in, the ambiance was welcoming, and the service was top-notch. The dish was absolutely delicious, full of fresh flavors, and perfectly cooked. I especially loved how the staff took the time to explain the menu and suggest pairings for our meal.</p>
                                        </div>
                                        <div class="author-info">
                                            <div class="author-image">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('images/author-2.jpg') }}" alt="">
                                                </figure>
                                            </div>            
                                            <div class="author-content">
                                                <h3>liya allen, manager</h3>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                                <!-- Testimonial Slide End -->
                            </div>
                            <div class="testimonial-btn">
                                <div class="testimonial-btn-prev"></div>
                                <div class="testimonial-btn-next"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial Slider End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Testimonial Section End -->


    <!-- Reserve Table Section Start -->
    <div class="reserve-table">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- Reserve table Content Start -->
                    <div class="reserve-table-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">reserve a table</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">reserve now your table and <span>enjoy dining experience.</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Reserve Table Body Start -->
                        <div class="reserve-table-body wow fadeInUp" data-wow-delay="0.2s">
                            <h3>open hours</h3>
                            <ul>
                                <li>Mon - Thu <span>10:00 AM - 09:00 PM</span></li>
                                <li>Fri - Sat <span>09:00 AM - 10:00 PM</span></li>
                                <li>Sun <span>Closed</span></li>
                            </ul>
                        </div>
                        <!-- Reserve Table Body End -->
                    </div>
                    <!-- Reserve table Content End -->
                </div>

                <div class="col-lg-6">
                    <!-- Reserve Table Form Start -->
                    <div class="reserve-table-form">
                        <form id="appointmentForm" action="" method="POST" data-toggle="validator" class="wow fadeInUp">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12 mb-4">
                                    <label class="form-label">your name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="e.g. John" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">email address</label>
                                    <input type="email" name ="email" class="form-control" id="email" placeholder="e.g. John@example.com" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                
                                <div class="form-group col-md-6 mb-4">
                                    <label class="form-label">phone number</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="e.g. + 123 456 8792" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-4 mb-4">
                                    <label class="form-label">date</label>
                                    <input type="date" name="date" class="form-control" id="date" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-4 mb-4">
                                    <label class="form-label">time</label>
                                    <select name="time" class="form-control form-select" id="time" required>
                                        <option value="" disabled selected>Select time</option>
                                        <option value="6_30pm">06:30 PM</option>
                                        <option value="7_00pm">07:00 PM</option>
                                        <option value="7_30pm">07:30 PM</option>
                                        <option value="8_00pm">08:00 PM</option>
                                        <option value="8_30pm">08:30 PM</option>
                                        <option value="9_00pm">09:00 PM</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-4 mb-4">
                                    <label class="form-label">Number Of Person</label>
                                    <select name="person" class="form-control form-select" id="person" required>
                                        <option value="" disabled selected>number of person</option>
                                        <option value="1_person">1 Person</option>
                                        <option value="5_person">5 Person</option>
                                        <option value="10_person">10 Person</option>
                                        <option value="15_person">15 Person</option>
                                        <option value="20_person">20 Person</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="reserve-table-btn">
                                        <button type="submit" class="btn-default">reserve now</button>
                                        <div id="msgSubmit" class="h3 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Reserve Table Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Reserve Table Section End -->
    @endsection