@extends('layouts.app')

@section('content')
<div class="login-sec">
<div class="login-container">
<div class="row w-100">
<div class="col-md-6 col-12 m-auto">

 <div class="login-box w-100">

<h2 class="text-white">Forgot Password</h2>

<div id="msg" class="text-center mb-2"></div>

<!-- EMAIL -->
<input type="email" id="email" placeholder="Enter Email" class="form-control mb-2">
 <div class="text-center">
<button class="btn mt-2 w-100" id="sendOtpBtn">Send OTP</button>
 </div>
<!-- OTP SECTION (HIDDEN) -->
<div id="otpSection" style="display:none;">
    <div class="otp-container text-center mt-3 d-flex justify-content-center gap-2">
        <input type="text" class="otp-input form-control text-center" maxlength="1" style="width:45px;">
        <input type="text" class="otp-input form-control text-center" maxlength="1" style="width:45px;">
        <input type="text" class="otp-input form-control text-center" maxlength="1" style="width:45px;">
        <input type="text" class="otp-input form-control text-center" maxlength="1" style="width:45px;">
        <input type="text" class="otp-input form-control text-center" maxlength="1" style="width:45px;">
        <input type="text" class="otp-input form-control text-center" maxlength="1" style="width:45px;">
    </div>
</div>

<!-- PASSWORD SECTION (HIDDEN) -->
<div id="passwordSection" style="display:none;">
    <input type="password" id="password" placeholder="New Password" class="form-control mt-3">
    <input type="password" id="confirm_password" placeholder="Confirm Password" class="form-control mt-2">

    <button class="btn w-100 mt-2" id="resetBtn">Reset Password</button>
</div>

</div>
</div>
</div>
</div>
</div>
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    let otpVerified = false;
    let otpInputs = document.querySelectorAll('.otp-input');

    // Initially hide sections
    $('#otpSection').hide();
    $('#passwordSection').hide();

    // ================= SEND OTP =================
    $('#sendOtpBtn').click(function () {

        let email = $('#email').val();

        if (!email) {
            return showMsg("Enter email", "red");
        }

        $.post("{{ route('forgot.otp') }}", {
            email: email,
            _token: "{{ csrf_token() }}"
        }, function (res) {

            if (res.status) {
                showMsg("OTP Sent ✅", "lightgreen");

                // 👉 HIDE EMAIL + BUTTON
                $('#email').hide();
                $('#sendOtpBtn').hide();

                // 👉 SHOW OTP
                $('#otpSection').show();
                otpInputs[0].focus();
            }

        }).fail(function () {
            showMsg("Invalid Email", "red");
        });
    });

    // ================= OTP INPUT =================
    otpInputs.forEach((input, index) => {

        input.addEventListener('input', function () {

            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            verifyOtp();
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === "Backspace" && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

    // ================= VERIFY OTP =================
    function verifyOtp() {

        let otp = '';
        otpInputs.forEach(i => otp += i.value);

        if (otp.length === 6) {

            $.post("{{ route('forgot.verify') }}", {
                email: $('#email').val(),
                otp: otp,
                _token: "{{ csrf_token() }}"
            }, function (res) {

                if (res.status) {
                    otpVerified = true;
                    showMsg("OTP Verified ✅", "lightgreen");

                    // 👉 HIDE OTP
                    $('#otpSection').hide();

                    // 👉 SHOW PASSWORD
                    $('#passwordSection').show();
                } else {
                    showMsg("Invalid OTP ❌", "red");
                }
            });
        }
    }

    // ================= RESET PASSWORD =================
    $('#resetBtn').click(function () {

        if (!otpVerified) {
            return showMsg("Verify OTP first ❌", "red");
        }

        let password = $('#password').val();
        let confirm = $('#confirm_password').val();

        if (password.length < 6) {
            return showMsg("Password min 6 chars", "red");
        }

        if (password !== confirm) {
            return showMsg("Passwords not match", "red");
        }

        $.post("{{ route('forgot.reset') }}", {
            email: $('#email').val(),
            password: password,
            password_confirmation: confirm,
            _token: "{{ csrf_token() }}"
        }, function (res) {

            if (res.status) {
                showMsg("Password Reset Success ✅", "lightgreen");

                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1500);
            } else {
                showMsg(res.message, "red");
            }
        });
    });

    // ================= MESSAGE =================
    function showMsg(msg, color) {
        $('#msg').text(msg).css('color', color);
    }

});
</script>
@endpush