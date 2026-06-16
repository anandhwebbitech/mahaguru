 <!-- Footer -->
 <footer class="site-footer style-1">
     <div class="footer-top">
         <div class="container">
             <div class="row">
                 <div class="col-xl-4 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                     <div class="widget widget_about me-2">
                         <div class="footer-logo logo-white">
                             <a href="{{ route('index') }}"><img src="{{ asset('assets/images/new-images/logo.png') }}"
                                     alt=""></a>
                         </div>
                         <ul class="widget-address">
                             <li>
                                 <p><span>Address</span> : 3/2- Raju Nagar, Vasiyapuram, Zamin Uthukuli (po)
                                     Pollachi - 642004</p>
                             </li>
                             <li>
                                 <p><span>E-mail</span> : ananya.priya9597@gmail.com</p>
                             </li>

                             <li>
                                 <p><span>Phone</span> : +91 9597990975</p>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-xl-2 col-md-4 col-sm-4 col-6 wow fadeInUp" data-wow-delay="0.3s">
                     <div class="widget widget_services">
                         <h5 class="footer-title">Quick Links</h5>
                         <ul>
                             <li><a href="{{ route('about') }}">About Us</a></li>
                             <li><a href="{{ route('contact') }}">Contact Us</a></li>
                             <li><a href="{{ route('faq') }}">FAQ / Help</a></li>
                             <!-- <li><a href="javascript:void(0);">Blog</a></li> -->
                             <!-- <li><a href="javascript:void(0);">Saree Care</a></li> -->
                         </ul>
                     </div>
                 </div>
                 <div class="col-xl-3 col-md-4 col-sm-4 col-6 wow fadeInUp" data-wow-delay="0.4s">
                     <div class="widget widget_services">
                         <h5 class="footer-title">Customer Services</h5>
                         <ul>
                             <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                             <li><a href="{{ route('shipping') }}">Shipping & Delivery</a></li>
                             <li><a href="{{ route('return') }}">Easy Returns</a></li>
                             <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                             <!-- <li><a href="javascript:void(0);">Contact Information</a></li> -->
                         </ul>
                     </div>
                 </div>
                 <div class="col-xl-3 col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.5s">
                     <div class="widget widget_services">
                         <h5 class="footer-title">Information</h5>
                         <ul>
                             <li><a href="{{ route('allProducts') }}">How to Shop</a></li>
                             <!-- <li><a href="javascript:void(0);">Silk Tips</a></li>
                             <li><a href="javascript:void(0);">Safe Purchase</a></li>
                             <li><a href="javascript:void(0);">Exchange Policy</a></li> -->
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer Top End -->
     <div class="container mb-3">
         <div class="d-flex align-items-center justify-content-center ">
             <span class="me-3 text-white">We Accept: </span>
             <img src="{{ asset('assets/images/footer-img.png') }}" alt="">
         </div>
     </div>
 </footer>

 <button class="scroltop" type="button"><i class="fas fa-arrow-up"></i></button>

 <!-- Quick Modal Start -->
 <div class="modal quick-view-modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 <i class="icon feather icon-x"></i>
             </button>
             <div class="modal-body">
                 <div class="row g-xl-4 g-3">
                     <div class="col-xl-6 col-md-6">
                         <div class="dz-product-detail mb-0">
                             <div class="swiper-btn-center-lr">
                                 <div class="swiper quick-modal-swiper2">
                                     <div class="swiper-wrapper" id="lightgallery">
                                         <div class="swiper-slide">
                                             <div class="dz-media DZoomImage">
                                                 <a class="mfp-link lg-item"
                                                     href="{{ asset('assets/images/products/lady-1.png') }}"
                                                     data-src="images/products/lady-1.png">
                                                     {{-- <i class="feather icon-maximize dz-maximize top-right"></i> --}}
                                                 </a>
                                                 <img src="{{ asset('assets/images/products/lady-1.png') }}"
                                                     alt="image">
                                             </div>
                                         </div>
                                         <div class="swiper-slide">
                                             <div class="dz-media DZoomImage">
                                                 <a class="mfp-link lg-item"
                                                     href="{{ asset('assets/images/products/lady-2.png') }}"
                                                     data-src="images/products/lady-2.png">
                                                     {{-- <i class="feather icon-maximize dz-maximize top-right"></i> --}}
                                                 </a>
                                                 <img src="{{ asset('assets/images/products/lady-2.png') }}"
                                                     alt="image">
                                             </div>
                                         </div>
                                         <div class="swiper-slide">
                                             <div class="dz-media DZoomImage">
                                                 <a class="mfp-link lg-item"
                                                     href="{{ asset('assets/images/products/lady-3.png') }}"
                                                     data-src="images/products/lady-3.png">
                                                     {{-- <i class="feather icon-maximize dz-maximize top-right"></i> --}}
                                                 </a>
                                                 <img src="{{ asset('assets/images/products/lady-3.png') }}"
                                                     alt="image">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="swiper quick-modal-swiper thumb-swiper-lg thumb-sm swiper-vertical">
                                     <div class="swiper-wrapper">
                                         <div class="swiper-slide">
                                             <img src="{{ asset('assets/images/products/thumb-img/lady-1.png') }}"
                                                 alt="image">
                                         </div>
                                         <div class="swiper-slide">
                                             <img src="{{ asset('assets/images/products/thumb-img/lady-2.png') }}"
                                                 alt="image">
                                         </div>
                                         <div class="swiper-slide">
                                             <img src="{{ asset('assets/images/products/thumb-img/lady-3.png') }}"
                                                 alt="image">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-6 col-md-6">
                         <div class="dz-product-detail style-2 ps-xl-3 ps-0 pt-2 mb-0">
                             <div class="dz-content">
                                 <div class="dz-content-footer">
                                     <div class="dz-content-start">
                                         <span class="badge bg-secondary mb-2">SALE 20% Off</span>
                                         <h4 class="title mb-1"><a href="javascript:void(0)">Cozy Knit Cardigan
                                                 Sweater</a></h4>
                                         <div class="review-num">
                                             <ul class="dz-rating me-2">
                                                 <li class="star-fill">
                                                     <i class="flaticon-star-1"></i>
                                                 </li>
                                                 <li class="star-fill">
                                                     <i class="flaticon-star-1"></i>
                                                 </li>
                                                 <li class="star-fill">
                                                     <i class="flaticon-star-1"></i>
                                                 </li>
                                                 <li>
                                                     <i class="flaticon-star-1"></i>
                                                 </li>
                                                 <li>
                                                     <i class="flaticon-star-1"></i>
                                                 </li>
                                             </ul>
                                             <span class="text-secondary me-2">4.7 Rating</span>
                                             <a href="javascript:void(0);">(5 customer reviews)</a>
                                         </div>
                                     </div>
                                 </div>
                                 <p class="para-text">
                                     Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                     Ipsum has.
                                 </p>
                                 <div class="meta-content m-b20 d-flex align-items-end">
                                     <div class="me-3">
                                         <span class="form-label">Price</span>
                                         <span class="price">₹125.75 <del>$132.17</del></span>
                                     </div>
                                     <div class="btn-quantity light me-0">
                                         <label class="form-label">Quantity</label>
                                         <input type="text" value="1" name="demo_vertical2">
                                     </div>
                                 </div>
                                 <div class=" cart-btn">
                                     <a href="javascript:void(0)" class="btn btn-secondary text-uppercase">Add To
                                         Cart</a>
                                     <a href="javascript:void(0)" class="btn btn-md btn-outline-secondary btn-icon">
                                         <svg width="19" height="17" viewBox="0 0 19 17" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path
                                                 d="M9.24805 16.9986C8.99179 16.9986 8.74474 16.9058 8.5522 16.7371C7.82504 16.1013 7.12398 15.5038 6.50545 14.9767L6.50229 14.974C4.68886 13.4286 3.12289 12.094 2.03333 10.7794C0.815353 9.30968 0.248047 7.9162 0.248047 6.39391C0.248047 4.91487 0.755203 3.55037 1.67599 2.55157C2.60777 1.54097 3.88631 0.984375 5.27649 0.984375C6.31552 0.984375 7.26707 1.31287 8.10464 1.96065C8.52734 2.28763 8.91049 2.68781 9.24805 3.15459C9.58574 2.68781 9.96875 2.28763 10.3916 1.96065C11.2292 1.31287 12.1807 0.984375 13.2197 0.984375C14.6098 0.984375 15.8885 1.54097 16.8202 2.55157C17.741 3.55037 18.248 4.91487 18.248 6.39391C18.248 7.9162 17.6809 9.30968 16.4629 10.7792C15.3733 12.094 13.8075 13.4285 11.9944 14.9737C11.3747 15.5016 10.6726 16.1001 9.94376 16.7374C9.75136 16.9058 9.50417 16.9986 9.24805 16.9986ZM5.27649 2.03879C4.18431 2.03879 3.18098 2.47467 2.45108 3.26624C1.71033 4.06975 1.30232 5.18047 1.30232 6.39391C1.30232 7.67422 1.77817 8.81927 2.84508 10.1066C3.87628 11.3509 5.41011 12.658 7.18605 14.1715L7.18935 14.1743C7.81021 14.7034 8.51402 15.3033 9.24654 15.9438C9.98344 15.302 10.6884 14.7012 11.3105 14.1713C13.0863 12.6578 14.6199 11.3509 15.6512 10.1066C16.7179 8.81927 17.1938 7.67422 17.1938 6.39391C17.1938 5.18047 16.7858 4.06975 16.045 3.26624C15.3152 2.47467 14.3118 2.03879 13.2197 2.03879C12.4197 2.03879 11.6851 2.29312 11.0365 2.79465C10.4585 3.24179 10.0558 3.80704 9.81975 4.20255C9.69835 4.40593 9.48466 4.52733 9.24805 4.52733C9.01143 4.52733 8.79774 4.40593 8.67635 4.20255C8.44041 3.80704 8.03777 3.24179 7.45961 2.79465C6.811 2.29312 6.07643 2.03879 5.27649 2.03879Z"
                                                 fill="black"></path>
                                         </svg>
                                         Add To Wishlist
                                     </a>
                                 </div>
                                 <div class="dz-info mb-0">
                                     <ul>
                                         <li><strong>SKU:</strong></li>
                                         <li>PRT584E63A</li>
                                     </ul>
                                     <ul>
                                         <li><strong>Category:</strong></li>
                                         <li><a href="javascript:void(0)">Dresses,</a></li>
                                         <li><a href="javascript:void(0)">Jeans,</a></li>
                                         <li><a href="javascript:void(0)">Swimwear,</a></li>
                                         <li><a href="javascript:void(0)">Summer,</a></li>
                                         <li><a href="javascript:void(0)">Clothing</a></li>
                                     </ul>
                                     <ul>
                                         <li><strong>Tags:</strong></li>
                                         <li><a href="javascript:void(0)">Casual</a></li>
                                         <li><a href="javascript:void(0)">Athletic,</a></li>
                                         <li><a href="javascript:void(0)">Workwear,</a></li>
                                         <li><a href="javascript:void(0)">Accessories</a></li>
                                     </ul>
                                     <div class="dz-social-icon">
                                         <ul>
                                             <li><a target="_blank" class="text-dark"
                                                     href="https://www.facebook.com/dexignzone">
                                                     <i class="fab fa-facebook-f"></i>
                                                 </a></li>
                                             <li><a target="_blank" class="text-dark"
                                                     href="https://twitter.com/dexignzones">
                                                     <i class="fab fa-twitter"></i>
                                                 </a></li>
                                             <li><a target="_blank" class="text-dark"
                                                     href="https://www.youtube.com/@dexignzone1723">
                                                     <i class="fa-brands fa-youtube"></i>
                                                 </a></li>
                                             <li><a target="_blank" class="text-dark"
                                                     href="https://www.linkedin.com/showcase/3686700/admin/">
                                                     <i class="fa-brands fa-linkedin-in"></i>
                                                 </a></li>
                                             <li><a target="_blank" class="text-dark"
                                                     href="https://www.instagram.com/dexignzone/">
                                                     <i class="fab fa-instagram"></i>
                                                 </a></li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="footer-bottom">
     <div class="container text-center">
         <p class="copyright-text mb-0">
             © <span id="year"></span>
             <a href="{{ route('index') }}" target="_blank">Mahaguru</a>.
             All Rights Reserved. |
             Developed by
             <a href="https://webbitech.com/" target="_blank">Webbitech</a>
         </p>
     </div>
 </div>
 <script>
     function changeImage(src, element) {
         document.getElementById("mainProductImage").src = src;

         let thumbs = document.querySelectorAll(".thumb");
         thumbs.forEach(t => t.classList.remove("active"));
         element.classList.add("active");
     }

     const minRange = document.getElementById("minRange");
     const maxRange = document.getElementById("maxRange");
     const minPrice = document.getElementById("minPrice");
     const maxPrice = document.getElementById("maxPrice");
     const gap = 500;

     function updateSlider() {
         let minVal = parseInt(minRange.value);
         let maxVal = parseInt(maxRange.value);

         minPrice.value = minVal;
         maxPrice.value = maxVal;

         let percent1 = (minVal / minRange.max) * 100;
         let percent2 = (maxVal / maxRange.max) * 100;

         minRange.style.background =
             `linear-gradient(to right, #d7d7d7 ${percent1}%, #003cff ${percent1}%, #003cff ${percent2}%, #d7d7d7 ${percent2}%)`;
         maxRange.style.background = minRange.style.background;
     }

     minRange.addEventListener("input", () => {
         if (+maxRange.value - +minRange.value < gap) {
             minRange.value = +maxRange.value - gap;
         }
         updateSlider();
     });

     maxRange.addEventListener("input", () => {
         if (+maxRange.value - +minRange.value < gap) {
             maxRange.value = +minRange.value + gap;
         }
         updateSlider();
     });

     minPrice.addEventListener("input", () => {
         minRange.value = minPrice.value;
         updateSlider();
     });

     maxPrice.addEventListener("input", () => {
         maxRange.value = maxPrice.value;
         updateSlider();
     });

     updateSlider();
 </script>

 <!-- JAVASCRIPT FILES ========================================= -->
 <script src="{{ asset('assets/js/jquery.min.js') }}"></script><!-- JQUERY MIN JS -->
 <script src="{{ asset('assets/vendor/wow/wow.min.js') }}"></script><!-- WOW JS -->
 <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP MIN JS -->
 <script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script><!-- BOOTSTRAP SELECT MIN JS -->
 <script src="{{ asset('assets/vendor/bootstrap-touchspin/bootstrap-touchspin.js') }}"></script><!-- BOOTSTRAP TOUCHSPIN JS -->
 <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script><!-- SWIPER JS -->
 <script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
 <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED-->
 <script src="{{ asset('assets/vendor/masonry/masonry-4.2.2.js') }}"></script><!-- MASONRY -->
 <script src="{{ asset('assets/vendor/masonry/isotope.pkgd.min.js') }}"></script><!-- ISOTOPE -->
 <script src="{{ asset('assets/vendor/countdown/jquery.countdown.js') }}"></script><!-- COUNTDOWN FUCTIONS  -->
 <script src="{{ asset('assets/vendor/wnumb/wNumb.js') }}"></script><!-- WNUMB -->
 <script src="{{ asset('assets/vendor/nouislider/nouislider.min.js') }}"></script><!-- NOUSLIDER MIN JS-->
 <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script><!-- CAROUSEL MIN JS -->
 <script src="{{ asset('assets/vendor/lightgallery/dist/lightgallery.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/lightgallery/dist/plugins/thumbnail/lg-thumbnail.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/lightgallery/dist/plugins/zoom/lg-zoom.min.js') }}"></script>
 <script src="{{ asset('assets/js/dz.carousel.js') }}"></script><!-- DZ CAROUSEL JS -->
 <script src="{{ asset('assets/js/dz.ajax.js') }}"></script><!-- AJAX -->
 <script src="{{ asset('assets/js/custom.min.js') }}"></script><!-- CUSTOM JS -->
 <script>
     $(document).ready(function() {
         $('.select2').select2({
             allowClear: true
         });
     });
     const heroSlider = document.querySelector('#heroSlider');
     const carousel = new bootstrap.Carousel(heroSlider, {
         interval: 3500,
         pause: false
     });

     let startX = 0;
     let endX = 0;

     heroSlider.addEventListener('touchstart', function(e) {
         startX = e.touches[0].clientX;
     });

     heroSlider.addEventListener('touchmove', function(e) {
         endX = e.touches[0].clientX;
     });

     heroSlider.addEventListener('touchend', function() {
         if (startX > endX + 50) {
             carousel.next();
         } else if (startX < endX - 50) {
             carousel.prev();
         }
     });

     // Mouse drag support
     let isDown = false;

     heroSlider.addEventListener('mousedown', (e) => {
         isDown = true;
         startX = e.clientX;
     });

     heroSlider.addEventListener('mouseup', (e) => {
         if (!isDown) return;
         endX = e.clientX;
         if (startX > endX + 50) {
             carousel.next();
         } else if (startX < endX - 50) {
             carousel.prev();
         }
         isDown = false;
     });

     function loadWishlist() {
         $.ajax({
             url: '{{ route('get.wishlist') }}', // Make sure this route points to getWishlist()
             method: 'GET',
             success: function(data) {

                 let html = '';
                 let items = data.items;

                 if (Object.keys(items).length === 0) {
                     html = '<li>No items in wishlist.</li>';
                 } else {

                     $.each(items, function(id, item) {

                         html += `
                <li>
                    <div class="cart-widget">
                        <div class="dz-media me-3">
                            <img src="{{ asset('public/uploads/images') }}/${item.product_img}" alt="">
                        </div>
                        <div class="cart-content">
                           <h6 class="title">
                                <a href="{{ url('product') }}/${item.id}">
                                    ${item.product_name}
                                </a>
                            </h6>
                            <div class="d-flex align-items-center">
                                <h6 class="dz-price mb-0">₹${item.offer_price}</h6>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="wish-close" onclick="removeFromWishlist(${id})">
                            <i class="ti-close"></i>
                        </a>
                    </div>
                </li>
                <br>
            `;
                     });
                 }

                 $('.sidebar-wish-list').html(html);
                 $(".wish-count").text(data.count); // now works!
             }
         });
     }

     function loadCart() {
         $.ajax({
            url: "{{ route('cart.items') }}",
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    let tbody = '';
                    let grandTotal = 0;   
                    
                    // ⚡ FIX: Array மற்றும் Object இரண்டையும் பாதுகாப்பாக கையாள Object.values() பயன்படுத்துகிறோம்
                    let itemsArray = Object.values(response.cartItems);
                    let itemCount = itemsArray.length;

                    if(itemCount === 0) {
                        cartItemCount = 0;
                        togglePlaceOrderButton();
                        $('#cartTableBody').html('<tr><td colspan="6" class="text-center py-4">Your cart is empty.</td></tr>');
                        return;
                    }

                    itemsArray.forEach(function(item) {
                        // 1. கண்ட்ரோலரில் இருந்து வரும் நேரடி துல்லியமான விலை
                        let price = parseFloat(item.final_price) || 0;
                        
                        // 2. கண்ட்ரோலரில் இருந்து வரும் துல்லியமான இமேஜ் பெயர்
                        let productImage = item.final_image ? item.final_image.trim() : '';
                        let finalImgSrc = (productImage === 'no-image.png' || !productImage) ? fallbackImg : (storageUrl + productImage);

                        // 3. வேரியண்ட் விவரங்கள் (Size, Color)
                        let variantDetails = '';
                        let sizeName = item.size ? `Size: ${item.size}` : '';
                        let colorName = item.color ? `Color: ${item.color}` : '';
                        if (sizeName || colorName) {
                            variantDetails = `(${sizeName}${sizeName && colorName ? ', ' : ''}${colorName})`;
                        }

                        // 4. கணிதக் கணக்கீடுகள்
                        let itemQuantity = parseInt(item.quantity) || 1;
                        let itemTotal = price * itemQuantity;
                        grandTotal += itemTotal;

                        // தயாரிப்பு பெயர் (உங்கள் டேட்டாபேஸ் படி 'product_name')
                        let productName = (item.product && item.product.product_name) ? item.product.product_name : 'Unknown Product';

                        tbody += `
                        <tr data-id="${item.id}" data-price="${price}">
                            <td class="product-item-img">
                                <img src="${finalImgSrc}" onerror="this.src='${fallbackImg}'" alt="${productName}" style="width:80px; height:80px; object-fit:cover;">
                            </td>
                            <td class="product-item-name">
                                ${productName} <br>
                                <small class="text-danger font-weight-bold">${variantDetails}</small>
                            </td>
                            <td class="product-item-price">₹${price.toFixed(2)}</td>
                            <td class="product-item-quantity">
                                <div class="qty-wrapper">
                                    <button class="qty-btn minus" type="button">−</button>
                                    <span class="qty-number">${itemQuantity}</span>
                                    <button class="qty-btn plus" type="button">+</button>
                                </div>
                            </td>
                            <td class="product-item-totle subtotal">₹${itemTotal.toFixed(2)}</td>
                            <td class="product-item-close">
                                <a href="javascript:void(0);" class="text-danger" onclick="removeCartItem(${item.id})">
                                    <i class="ti-close"></i>
                                </a>
                            </td>
                        </tr>
                        `;
                    });
                    
                    $('#cartTableBody').html(tbody);
                    $('#overall_total').text("₹" + grandTotal.toFixed(2));
                    cartItemCount = itemCount;
                    togglePlaceOrderButton();
                }
            },
            error: function() {
                $('#cartTableBody').html('<tr><td colspan="6" class="text-center text-danger py-4">Failed to load cart.</td></tr>');
            }
        });
     }
 </script>
