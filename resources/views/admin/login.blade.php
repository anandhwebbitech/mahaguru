<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Page */
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f8fb;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Login Box */
        .login-box {
            width: 400px;
            padding: 40px;
            border-radius: 16px;
            background: #ffffff;
            border: 1px solid #eee;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Title */
        .login-box h4 {
            font-weight: 600;
            color: #222;
        }

        /* Inputs */
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #2b6cb0;
            box-shadow: none;
            transform: scale(1.02);
        }

        /* Button */
        .btn-primary {
            border-radius: 10px;
            background: #2b6cb0;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #1e4e8c;
            transform: translateY(-2px);
        }

        /* Password wrapper */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        /* Eye icon */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #2b6cb0;
            font-size: 16px;
            transition: 0.3s;
        }

        .toggle-password:hover {
            color: #1e4e8c;
            transform: translateY(-50%) scale(1.1);
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h4 class="text-center mb-4">Admin Login</h4>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email address" required>
            </div>

            <div class="mb-3 password-wrapper">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Password" required>

                <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.querySelector(".toggle-password");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
                icon.style.transform = "translateY(-50%) scale(1.2)";
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
                icon.style.transform = "translateY(-50%) scale(1)";
            }
        }
    </script>

</body>

</html>