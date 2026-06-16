@extends('layouts.app')
 @section('content')

    <section class="dz-bnr-inr dz-bnr-inr-sm bg-light">
        <div class="container">
            <div class="dz-bnr-inr-entry ">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-7">
                        <div class="text-start mb-xl-0 mb-4">
                            <h1>Your Fashion Journey Starts Here Discover Style at Pixio</h1>
                            <nav aria-label="breadcrumb" class="breadcrumb-row">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}"> Home</a></li>
                                    <li class="breadcrumb-item">About us</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 ">
                        <div class="about-sale  text-start">
                            <div class="row">
                                <div class="col-lg-5 col-md-6 col-6">
                                    <div class="about-content">
                                        <h2 class="title"><span class="counter">50</span>+</h2>
                                        <p class="text">Items Sale</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 col-6">
                                    <div class="about-content">
                                        <h2 class="title">400%</h2>
                                        <p class="text">Return on investment </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-banner overflow-visible">
        <video autoplay loop muted id="video-background">
            <source src="{{ asset('assets/images/new-images/about-banner.mp4') }}" type="video/mp4">
        </video>
        <div class="about-info">
            <h3 class="dz-title">
                <a>why MAHAGURU Boutique ?</a>
            </h3>
            <p class="text mb-0">MAHAGURU Boutique offers exclusive, high-quality fashion that beautifully combines tradition with modern style. Each outfit is carefully designed and handcrafted for comfort, durability, and elegance. We provide unique collections, custom fitting, and friendly personalized service to ensure every customer feels special and confident. </p>
        </div>
    </section>

    <!--Our Mission Section-->
    <section class="content-inner">
        <div class="container">
            <div class="row about-style2 align-items-xl-center align-items-start">
                <div class="col-lg-6 col-lg-5 col-sm-5 m-b30 sticky-top">
                    <div class="about-thumb">
                        <img src="{{ asset('assets/images/new-images/about.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-7 col-sm-7">
                    <div class="about-content">
                        <div class="section-head style-2 d-block">
                            <h3 class="title w-100">A Unique Traditional Saree Experience at Maharaja Boutique </h3>
                            <p>At Untouch, we're dedicated to creating an exclusive fashion destination that transcends the ordinary. Our passion for style, quality, and individuality drives our mission. Our collection is a carefully curated blend of timeless classics and the latest trends,</p>
                            <p>In addition to our extensive collection, we're equally devoted to ensuring your shopping experience is seamless and enjoyable. Our website is designed with your convenience in mind, offering secure transactions and a responsive customer support team to assist you every step of the way.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Get In Touch -->
    <section class="get-in-touch">
        <div class="m-r100 m-md-r0 m-sm-r0">
            <h3 class="dz-title mb-lg-0 mb-3">Questions ?
                <span>Our experts will help find the grar that’s right for you</span>
            </h3>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-light">Get In Touch</a>
    </section>
    <!-- Get In Touch End -->

    <section class="content-inner">
        <div class="container">
            <div class="row g-3 g-xl-4 align-items-center">
                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-head ">
                        <h2 class="title">Meet Our Creative Team</h2>
                        <p>Our dedicated team of skilled designers and creators works with passion to craft unique and beautiful sarees. Combining creativity and expert craftsmanship, we focus on delivering quality, style, and a memorable shopping experience.</p>
                        <a class="btn btn-secondary me-3" href="{{ route('userregister') }}">Join Our Team</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="dz-team style-1 m-md-b0 m-sm-b0 m-b30">
                        <div class="dz-media">
                            <!-- <a href="javascript:void(0);"> -->
                                <img class="founder-img" src="{{ asset('assets/images/new-images/maha.jpg')}}" alt="">
                                <!-- </a> -->
                            <ul class="team-social-icon">
                                <li><a href="https://www.facebook.com/share/179dEVSp57/"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://youtube.com/@mahaaguruboutique?si=xx6PGztkZ-MW9kcH"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="https://www.instagram.com/mahaaguruboutique?igsh=bmY2YXp1ZDQwaDYz"><i class="fab fa-instagram"></i></a></li>
                                <!-- <li><a href="javascript:void(0)"><i class="fa-brands fa-linkedin-in"></i></a></li> -->
                            </ul>
                        </div>
                        <div class="dz-content">
                            <h5 class="title">
                                <!-- <a href="javascript:void(0)">Mahalakshmi</a> --> Mahalakshmi
                            </h5>
                            <span>CEO & Founder</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="dz-team style-1 m-md-b0 m-sm-b0 m-b30">
                        <div class="dz-media">
                            <!-- <a href="javascript:void(0);"> -->
                                <img class="founder-img" src="{{ asset('assets/images/new-images/guru.png') }}" alt="">
                            <!-- </a> -->
                            <!-- <ul class="team-social-icon">
                                <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa-brands fa-linkedin-in"></i></a></li>
                            </ul> -->
                            <ul class="team-social-icon">
                                <li><a href="https://www.facebook.com/share/179dEVSp57/"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://youtube.com/@mahaaguruboutique?si=xx6PGztkZ-MW9kcH"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="https://www.instagram.com/mahaaguruboutique?igsh=bmY2YXp1ZDQwaDYz"><i class="fab fa-instagram"></i></a></li>
                                <!-- <li><a href="javascript:void(0)"><i class="fa-brands fa-linkedin-in"></i></a></li> -->
                            </ul>
                        </div>
                        <div class="dz-content">
                            <h5 class="title">
                                <!-- <a href="javascript:void(0)">Mahaguru</a> -->
                            Mahaguru</h5>
                            <span>Team Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 @endsection
