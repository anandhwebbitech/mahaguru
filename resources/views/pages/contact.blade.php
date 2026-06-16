@extends('layouts.app')
@section('content')
    <div class="page-content bg-light">
        <!--banner-->
        <div class="contact-bnr bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-info style-1 text-start text-white">
                            <h2>Contact Us</h2>
                            <div class="contact-bottom wow fadeInUp" data-wow-delay="0.3s">
                                <div class="contact-left mb-3">
                                    <h3>Location</h3>
                                    <ul>
                                        <li><a href="https://maps.app.goo.gl/Uu2g3ayatXFZMxry6" target="_blank">3/2- Raju
                                                Nagar, Vasiyapuram, Zamin Uthukuli (po)
                                                Pollachi - 642004</a></li>
                                    </ul>
                                </div>
                                <div class="contact-left mb-3">
                                    <h3>Email Us</h3>
                                    <ul>
                                        <li><a href="mailto:ananya.priya9597@gmail.com">ananya.priya9597@gmail.com</a></li>
                                    </ul>
                                </div>
                                <div class="contact-left mb-3">
                                    <h3>Call Us</h3>
                                    <ul>
                                        <li><a href="tel:+91 9597990975">+91 9597990975</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pm-selection-wrapper1">
                            <!-- Delivery Location Header -->

                            <!-- Map Iframe Container -->
                            <div class="pm-map-container">
                                <iframe class="pm-map-iframe"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.1154735285395!2d76.98377459999999!3d10.6470305!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba839e87ab00151%3A0xab3f85186cfec348!2sMahaaguru%20Handlooms!5e1!3m2!1sen!2sin!4v1776687593665!5m2!1sen!2sin"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-area1 style-1 m-r20 m-md-r0 wow fadeInUp" data-wow-delay="0.5s">
                            <form class="dz-form dzForm" method="POST" action="{{ route('contact.submit') }}">
                                 @csrf
                                 
                                <input type="hidden" class="form-control" name="dzToDo" value="Contact">
                                <input type="hidden" class="form-control" name="reCaptchaEnable" value="0">
                                <div class="dzFormMsg"></div>
                                <label class="form-label">Your Name</label>
                                <div class="input-group">
                                    <input required type="text" class="form-control" name="name" >
                                </div>
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <input required type="email" class="form-control" name="email">
                                </div>
                                <label class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <input required type="number" class="form-control" name="phone">
                                </div>
                                <label class="form-label">Massage</label>
                                <div class="input-group m-b30">
                                    <textarea name="message" rows="4" required class="form-control m-b10"></textarea>
                                </div>
                               <div class="input-recaptcha m-b30">
<div class="input-recaptcha m-b30">
    <div class="g-recaptcha"
         data-sitekey="6LeQ09ksAAAAACetxtse9haIja-Qdz3AanfKBbVw">
    </div>
</div>


                                <div>
                                    <button name="submit" type="submit" value="submit"
                                        class="btn w-100 btn-white btnhover">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
function verifyRecaptchaCallback(response) {
    document.getElementById('recaptchaToken').value = response;
}

function expiredRecaptchaCallback() {
    document.getElementById('recaptchaToken').value = '';
}
</script>
@endsection
