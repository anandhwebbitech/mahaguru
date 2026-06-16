@extends('layouts.app')
@section('content')
    <div class="page-content bg-light">
        <section class="px-3">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 faq-side-content">
                    <div class="dz-bnr-inr-entry wow fadeInUp" data-wow-delay="0.1s">
                        <h1>Have any questions? </h1>
                        <nav aria-label="breadcrumb text-align-start" class="breadcrumb-row mb-lg-4 mb-3">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home</a></li>
                                <li class="breadcrumb-item">Faq’s</li>
                            </ul>
                        </nav>
                    </div>
                    <div class="dz-tabs style-1 tab-space wow fadeInUp" data-wow-delay="0.2s">
                        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                            <li class="nav-link active" id="food-1-tab" data-bs-toggle="tab" data-bs-target="#food-1"
                                role="tab" aria-controls="food-1">
                                <i class="icon feather icon-box"></i>
                                <span>General</span>
                            </li>
                            <li class="nav-link" id="food-2-tab" data-bs-toggle="tab" data-bs-target="#food-2"
                                role="tab" aria-controls="food-2">
                                <i class="icon feather icon-shopping-cart"></i>
                                <span>Returns</span>
                            </li>
                            <li class="nav-link" id="food-3-tab" data-bs-toggle="tab" data-bs-target="#food-3"
                                role="tab" aria-controls="food-3">
                                <i class="icon feather icon-gift"></i>
                                <span>Gift</span>
                            </li>
                            <li class="nav-link" id="food-4-tab" data-bs-toggle="tab" data-bs-target="#food-4"
                                role="tab" aria-controls="food-4">
                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                <span>Refunds</span>
                            </li>
                            <li class="nav-link" id="food-5-tab" data-bs-toggle="tab" data-bs-target="#food-5"
                                role="tab" aria-controls="food-5">
                                <i class="icon feather icon-credit-card"></i>
                                <span>Payments</span>
                            </li>
                            <li class="nav-link" id="food-6-tab" data-bs-toggle="tab" data-bs-target="#food-6"
                                role="tab" aria-controls="food-6">
                                <i class="icon feather icon-truck"></i>
                                <span>Shipping</span>
                            </li>
                        </ul>
                    </div>
                    <div class="dz-media d-none d-lg-block d-xl-block wow fadeInUp rounded" data-wow-delay="0.3s">
                        <img class="media" src="images/faq/pic1.jpg" alt="">
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 faq-end-content">
                    <div class="tab-content wow fadeInUp" data-wow-delay="0.5s" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="food-1" role="tabpanel" aria-labelledby="food-1-tab"
                            tabindex="0">
                            <div class="accordion dz-accordion accordion-sm" id="accordionFaq1">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            How can I contact customer support?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1"
                                        data-bs-parent="#accordionFaq1">
                                        <div class="accordion-body">
                                            <p class="m-b0">You can reach our support team via email or through the
                                                contact form on our website. We typically respond within 24 hours. For
                                                urgent queries, you can also use our live chat during business hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Can I cancel my order?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordionFaq1">
                                        <div class="accordion-body">
                                            <p class="m-b0">Yes, you can cancel your order before it is shipped. Once the
                                                order has been dispatched, cancellation is not possible, but you may request
                                                a return after delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading55">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse55" aria-expanded="false"
                                            aria-controls="collapse55">
                                            How do I know if a product is in stock?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse55" class="accordion-collapse collapse" aria-labelledby="heading55"
                                        data-bs-parent="#accordionFaq1">
                                        <div class="accordion-body">
                                            <p class="m-b0">Product availability is displayed on each product page. If an
                                                item is out of stock, you may see an option to get notified when it becomes
                                                available again.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading5">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            Can I place an order over the phone?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                        data-bs-parent="#accordionFaq1">
                                        <div class="accordion-body">
                                            <p class="m-b0">Currently, we only accept orders through our website to
                                                ensure secure and accurate processing. However, our support team can guide
                                                you through the ordering process if needed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="food-2" role="tabpanel" aria-labelledby="food-2-tab"
                            tabindex="0">
                            <div class="accordion dz-accordion accordion-sm" id="accordionFaq">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            How can I contact customer support?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show"
                                        aria-labelledby="heading1" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            <p class="m-b0">You can reach our support team via email or through the
                                                contact form on our website. We typically respond within 24 hours. For
                                                urgent queries, you can also use our live chat during business hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Can I cancel my order?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            <p class="m-b0">Yes, you can cancel your order before it is shipped. Once the
                                                order has been dispatched, cancellation is not possible, but you may request
                                                a return after delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                            How do I know if a product is in stock?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading55"
                                        data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            <p class="m-b0">Product availability is displayed on each product page. If an
                                                item is out of stock, you may see an option to get notified when it becomes
                                                available again.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Can I place an order over the phone?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                        data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            <p class="m-b0">Currently, we only accept orders through our website to
                                                ensure secure and accurate processing. However, our support team can guide
                                                you through the ordering process if needed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="food-3" role="tabpanel" aria-labelledby="food-3-tab"
                            tabindex="0">
                            <div class="accordion dz-accordion accordion-sm" id="accordionFaq2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            How can I contact customer support?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show"
                                        aria-labelledby="heading1" data-bs-parent="#accordionFaq2">
                                        <div class="accordion-body">
                                            <p class="m-b0">You can reach our support team via email or through the
                                                contact form on our website. We typically respond within 24 hours. For
                                                urgent queries, you can also use our live chat during business hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Can I cancel my order?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordionFaq2">
                                        <div class="accordion-body">
                                            <p class="m-b0">Yes, you can cancel your order before it is shipped. Once the
                                                order has been dispatched, cancellation is not possible, but you may request
                                                a return after delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                            How do I know if a product is in stock?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                        data-bs-parent="#accordionFaq2">
                                        <div class="accordion-body">
                                            <p class="m-b0">Product availability is displayed on each product page. If an
                                                item is out of stock, you may see an option to get notified when it becomes
                                                available again.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Can I place an order over the phone?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                        data-bs-parent="#accordionFaq2">
                                        <div class="accordion-body">
                                            <p class="m-b0">Currently, we only accept orders through our website to
                                                ensure secure and accurate processing. However, our support team can guide
                                                you through the ordering process if needed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="food-4" role="tabpanel" aria-labelledby="food-4-tab"
                            tabindex="0">
                            <div class="accordion dz-accordion accordion-sm" id="accordionFaq3">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            How can I contact customer support?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show"
                                        aria-labelledby="heading1" data-bs-parent="#accordionFaq3">
                                        <div class="accordion-body">
                                            <p class="m-b0">You can reach our support team via email or through the
                                                contact form on our website. We typically respond within 24 hours. For
                                                urgent queries, you can also use our live chat during business hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Can I cancel my order?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordionFaq3">
                                        <div class="accordion-body">
                                            <p class="m-b0">Yes, you can cancel your order before it is shipped. Once the
                                                order has been dispatched, cancellation is not possible, but you may request
                                                a return after delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                            How do I know if a product is in stock?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                        data-bs-parent="#accordionFaq3">
                                        <div class="accordion-body">
                                            <p class="m-b0">Product availability is displayed on each product page. If an
                                                item is out of stock, you may see an option to get notified when it becomes
                                                available again.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Can I place an order over the phone?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                        data-bs-parent="#accordionFaq3">
                                        <div class="accordion-body">
                                            <p class="m-b0">Currently, we only accept orders through our website to
                                                ensure secure and accurate processing. However, our support team can guide
                                                you through the ordering process if needed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="food-5" role="tabpanel" aria-labelledby="food-5-tab"
                            tabindex="0">
                            <div class="accordion dz-accordion accordion-sm" id="accordionFaq4">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            How can I contact customer support?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show"
                                        aria-labelledby="heading1" data-bs-parent="#accordionFaq4">
                                        <div class="accordion-body">
                                            <p class="m-b0">You can reach our support team via email or through the
                                                contact form on our website. We typically respond within 24 hours. For
                                                urgent queries, you can also use our live chat during business hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Can I cancel my order?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordionFaq4">
                                        <div class="accordion-body">
                                            <p class="m-b0">Yes, you can cancel your order before it is shipped. Once the
                                                order has been dispatched, cancellation is not possible, but you may request
                                                a return after delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                            How do I know if a product is in stock?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                        data-bs-parent="#accordionFaq4">
                                        <div class="accordion-body">
                                            <p class="m-b0">Product availability is displayed on each product page. If an
                                                item is out of stock, you may see an option to get notified when it becomes
                                                available again.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Can I place an order over the phone?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                        data-bs-parent="#accordionFaq4">
                                        <div class="accordion-body">
                                            <p class="m-b0">Currently, we only accept orders through our website to
                                                ensure secure and accurate processing. However, our support team can guide
                                                you through the ordering process if needed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="food-6" role="tabpanel" aria-labelledby="food-6-tab"
                            tabindex="0">
                            <div class="accordion dz-accordion accordion-sm" id="accordionFaq5">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1">
                                        <a href="#" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            How can I contact customer support?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show"
                                        aria-labelledby="heading1" data-bs-parent="#accordionFaq5">
                                        <div class="accordion-body">
                                            <p class="m-b0">You can reach our support team via email or through the
                                                contact form on our website. We typically respond within 24 hours. For
                                                urgent queries, you can also use our live chat during business hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            Can I cancel my order?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordionFaq5">
                                        <div class="accordion-body">
                                            <p class="m-b0">Yes, you can cancel your order before it is shipped. Once the
                                                order has been dispatched, cancellation is not possible, but you may request
                                                a return after delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                            How do I know if a product is in stock?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                        data-bs-parent="#accordionFaq5">
                                        <div class="accordion-body">
                                            <p class="m-b0">Product availability is displayed on each product page. If an
                                                item is out of stock, you may see an option to get notified when it becomes
                                                available again.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4">
                                        <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Can I place an order over the phone?
                                            <span class="toggle-close"></span>
                                        </a>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                        data-bs-parent="#accordionFaq5">
                                        <div class="accordion-body">
                                            <p class="m-b0">Currently, we only accept orders through our website to
                                                ensure secure and accurate processing. However, our support team can guide
                                                you through the ordering process if needed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
