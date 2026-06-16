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
                                <input type="email" id="email" name="email" placeholder="Email ID" required>
                            </div>

                            <label for="password">Password</label>
                            <div class="mb-2 position-relative">
                                <input type="password" id="password" name="password" placeholder="Enter Password" required class="form-control">
                                <span class="toggle-password" onclick="togglePassword('password', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #fff;">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn">Log in</button>
                            </div>
                        </form>

                        {{-- Mobile OTP Login Section --}}
                        <form id="otpLoginForm" class="mt-4">
                            <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>

                            <p class="register-text">
                                Don't have an account?
                                <a class="register-btn" href="{{ route('userregister') }}">Register Now</a>
                            </p>

                            <hr class="line-break">

                            <p class="mobile-login-title">Login using registered Mobile number</p>

                            <label for="mobileNumber">Mobile Number</label>
                            <input type="tel" id="mobileNumber" placeholder="Mobile number" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>

                            <div class="otp-container d-flex justify-content-center gap-2 text-center mt-3">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                                <input type="text" class="otp-input text-center form-control" style="width: 45px; height: 45px; font-size: 18px;" maxlength="1" disabled pattern="[0-9]*" inputmode="numeric">
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn mt-3" id="sendOtpBtn">Send OTP</button>
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
        // Password Visibility Toggle Toggle
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

            // 1. AJAX Standard Email/Password Login
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $('#loginMessage').text('');

                $.ajax({
                    url: "{{ route('logincheck') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#loginMessage').css('color', 'lightgreen').text(response.message);
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 1000);
                        } else {
                            $('#loginMessage').css('color', 'red').text(response.message);
                        }
                    },
                    error: function(xhr) {
                        let msg = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        $('#loginMessage').css('color', 'red').text(msg);
                    }
                });
            });

            // 2. Send Mobile OTP Logic
            $('#sendOtpBtn').on('click', function() {
                sendOtp();
            });

            $('#mobileNumber').on('keypress', function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    sendOtp();
                }
            });

            function sendOtp() {
                let mobile = $("#mobileNumber").val().trim();

                if (mobile.length !== 10) {
                    Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Enter a valid 10-digit mobile number' });
                    return;
                }

                $('#sendOtpBtn').prop('disabled', true).text('Sending...');

                $.ajax({
                    url: "{{ route('send.otp') }}",
                    type: "POST",
                    data: {
                        mobile: mobile,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.success) {
                            // Enable inputs and focus the first box
                            otpInputs.prop('disabled', false).val('');
                            otpInputs.eq(0).focus();

                            Swal.fire({
                                icon: 'success',
                                title: 'OTP Sent!',
                                text: res.message,
                                timer: 2500,
                                showConfirmButton: false
                            });
                            $('#sendOtpBtn').prop('disabled', false).text('Resend OTP');
                        } else {
                            Swal.fire({ icon: 'error', title: 'Failed', text: res.message });
                            $('#sendOtpBtn').prop('disabled', false).text('Send OTP');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.message || 'Could not verify mobile connection.';
                        Swal.fire({ icon: 'error', title: 'Error', text: errorMsg });
                        $('#sendOtpBtn').prop('disabled', false).text('Send OTP');
                    }
                });
            }

            // 3. OTP Box Auto-stepping & Backspace handling
            otpInputs.each(function(index) {
                $(this).on('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, ''); // Ensure numbers only
                    
                    if (this.value && index < otpInputs.length - 1) {
                        otpInputs.eq(index + 1).focus();
                    }
                    submitOtpIfComplete();
                });

                $(this).on('keydown', function(e) {
                    if (e.key === "Backspace" && !this.value && index > 0) {
                        otpInputs.eq(index - 1).focus();
                    }
                });
            });

            function submitOtpIfComplete() {
                let otp = '';
                otpInputs.each(function() {
                    otp += $(this).val();
                });

                if (otp.length === 4) {
                    verifyOtp(otp);
                }
            }

            // 4. Verify OTP and Authenticate Login
            function verifyOtp(otp) {
                $.ajax({
                    url: "{{ route('verify.otp') }}",
                    type: "POST",
                    data: {
                        mobile: $("#mobileNumber").val(),
                        otp: otp,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.success) {
                            $('#loginMessage').css('color', 'lightgreen').text("Verified! Access granted...");
                            setTimeout(() => {
                                window.location.href = res.redirect_url;
                            }, 800);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Verification Failed', text: res.message });
                            otpInputs.val('');
                            otpInputs.eq(0).focus();
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.message || 'Verification Error.';
                        Swal.fire({ icon: 'error', title: 'Error', text: errorMsg });
                    }
                });
            }
        });
    </script>
@endpush