@extends('layouts.app')

@section('content')
    <div class="login-sec">
        <div class="login-container">
            <div class="row w-100">
                <div class="col-md-6 col-12 m-auto">
                    <div class="login-box w-100">

                        {{-- Main Alert Message Box --}}
                        <div id="loginMessage" class="text-center mt-2 fw-bold" style="font-size: 14px;"></div>

                        {{-- Standard Password Login Form --}}
                        <form id="loginForm">
                            @csrf
                            <h2 class="text-white">Login</h2>

                            <label for="email">Email</label>
                            <div class="mb-2">
                                <input type="email" id="email" name="email" placeholder="Email ID" required class="form-control">
                            </div>

                            <label for="password">Password</label>
                            <div class="mb-2 position-relative">
                                <input type="password" id="password" name="password" placeholder="Enter Password" required class="form-control">
                                <span class="toggle-password" onclick="togglePassword('password', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #fff;">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn" id="loginSubmitBtn">Log in</button>
                            </div>
                        </form>

                        {{-- Email OTP Verification Section --}}
                        <form id="otpLoginForm" class="mt-4">
                            @csrf
                            <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>

                            <p class="register-text">
                                Don't have an account?
                                <a class="register-btn" href="{{ route('userregister') }}">Register Now</a>
                            </p>

                            <hr class="line-break">

                            <p class="mobile-login-title">Enter OTP sent to your registered Email</p>

                            <div class="otp-container d-flex justify-content-center gap-2 text-center mt-3">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn mt-3" id="verifyOtpBtn" disabled>Verify OTP</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Password Visibility Toggle
        function togglePassword(fieldId, el) {
            const input = document.getElementById(fieldId);
            const icon = el.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        $(document).ready(function() {
            const otpInputs = $('.otp-input');

            // 1. Email & Password போட்டு லாகின் கிளிக் செய்யும் போது OTP அனுப்புதல்
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $('#loginMessage').text('');
                $('#loginSubmitBtn').prop('disabled', true).text('Verifying & Sending OTP...');

                $.ajax({
                    url: "{{ route('logincheck') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#loginSubmitBtn').prop('disabled', false).text('Log in');
                        
                        if (response.success) {
                            $('#loginMessage').css('color', 'lightgreen').text(response.message);
                            
                            // OTP கட்டங்களை ஆக்டிவேட் செய்து முதல் கட்டத்தில் கர்சரை நிறுத்துதல்
                            otpInputs.prop('disabled', false).val('');
                            $('#verifyOtpBtn').prop('disabled', false);
                            otpInputs.eq(0).focus();

                            Swal.fire({
                                icon: 'success',
                                title: 'OTP Sent!',
                                text: 'Please check your Mailtrap sandbox inbox.',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            $('#loginMessage').css('color', 'red').text(response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#loginSubmitBtn').prop('disabled', false).text('Log in');
                        let msg = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        $('#loginMessage').css('color', 'red').text(msg);
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });

            // 2. OTP கட்டங்களின் வடிவமைப்பு மற்றும் அடுத்தடுத்த நகர்வு (Auto-stepping)
            otpInputs.each(function(index) {
                $(this).on('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, ''); // எண்கள் மட்டும்
                    
                    if (this.value && index < otpInputs.length - 1) {
                        otpInputs.eq(index + 1).focus();
                    }
                });

                $(this).on('keydown', function(e) {
                    if (e.key === "Backspace" && !this.value && index > 0) {
                        otpInputs.eq(index - 1).focus();
                    }
                });
            });

            // 3. Verify OTP பொத்தானை கிளிக் செய்யும் போது நடக்கும் செயல்பாடு
            $('#verifyOtpBtn').on('click', function() {
                let otp = '';
                otpInputs.each(function() {
                    otp += $(this).val();
                });

                if (otp.length !== 4) {
                    Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Please enter the complete 4-digit OTP.' });
                    return;
                }

                verifyOtp(otp);
            });

            // 4. Controller-க்கு OTP-ஐ அனுப்பி சரிபார்த்து உள்நுழைதல்
            function verifyOtp(otp) {
                $('#verifyOtpBtn').prop('disabled', true).text('Verifying...');

                $.ajax({
                    url: "{{ route('verify.email.otp') }}",
                    type: "POST",
                    data: {
                        otp: otp,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.success) {
                            $('#loginMessage').css('color', 'lightgreen').text(res.message);
                            Swal.fire({
                                icon: 'success',
                                title: 'Verified!',
                                text: 'Redirecting to dashboard...',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                window.location.href = res.redirect_url;
                            }, 1000);
                        } else {
                            $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP');
                            Swal.fire({ icon: 'error', title: 'Verification Failed', text: res.message });
                            otpInputs.val('');
                            otpInputs.eq(0).focus();
                        }
                    },
                    error: function(xhr) {
                        $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP');
                        let errorMsg = xhr.responseJSON?.message || 'Verification Error.';
                        Swal.fire({ icon: 'error', title: 'Error', text: errorMsg });
                    }
                });
            }
        });
    </script>
@endpush