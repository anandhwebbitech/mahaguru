@extends('layouts.app')
@section('content')
    <div class="login-sec">
        <div class="login-container">
            <div class="row w-100">
                <div class="col-md-6 col-12 m-auto">
                    <div class="login-box w-100">
                        <form id="registerForm">
                            @csrf
                            <h2 class="text-white">Register</h2>
                            <!-- <div class="col-md-6 col-12"> -->
                            <label for="name">Name</label>
                            <div class="mb-2">
                                <input type="text" id="name" name="name" placeholder="Name" required>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="col-md-6 col-12"> -->
                            {{-- <label for="dob">D.O.B</label>
                            <div class="mb-2">
                                <input type="date" id="dob" name="dob" placeholder="D.O.B" required>
                            </div> --}}
                            <!-- </div> -->
                            <label for="email">Email</label>
                            <div class="mb-2">
                                <input type="email" id="email"name="email" placeholder="Email ID" required>
                            </div>
                            <label for="phone">Phone</label>
                            <div class="mb-2">
                                <input type="number" id="phone" name="phone" placeholder="Phone" required>
                            </div>
                            <!-- PASSWORD -->
                            <label for="password">Password</label>
                            <div class="mb-2 position-relative">
                                <input type="password" id="password" name="password" placeholder="Enter Password" required
                                    class="form-control">
                                <span class="toggle-password" onclick="togglePassword('password', this)">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <label for="confirm_password">Confirm Password</label>
                            <div class="mb-2 position-relative">
                                <input type="password" id="confirm_password" name="confirm_password"
                                    placeholder="Confirm Password" required class="form-control">
                                <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                            <div class="text-center mb-4">
                                <button class="btn">Regsiter</button>
                            </div>
                        </form>
                        <div>
                            <p class="register-text">Do you have an account? <a class="register-btn"
                                    href="{{ route('login') }}">Login Now</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
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
        </script>
        <script>
            $(document).on("submit", "#registerForm", function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('register.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {

                        if (response.status === "success") {
                            alert("Registration successful!");
                            window.location.href = "{{ route('allProducts') }}"; // redirect to login
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let msg = "";

                            $.each(errors, function(key, value) {
                                msg += value + "\n";
                            });

                            alert(msg);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
