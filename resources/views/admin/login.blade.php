<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Page Background Setup */
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Maps perfectly to http://localhost/mahaguru/public/assets/... */
            background: url('/assets/images/new-images/footer-bg.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow: hidden;
        }

        /* Premium heavy dark blue radial shadow layer for perfect typography popup */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle, rgba(10, 17, 40, 0.7) 0%, rgba(5, 10, 25, 0.9) 100%);
            z-index: 1;
        }

        /* Mahaguru Luxury Dark Glass Form Block */
        .login-box {
            position: relative;
            z-index: 2;
            width: 420px;
            padding: 45px 40px;
            border-radius: 24px;
            background: rgba(13, 20, 38, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6), 
                        0 0 50px rgba(49, 130, 206, 0.2);
            animation: formEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes formEntrance {
            from {
                transform: translateY(60px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Branding Gold Highlights */
        .login-box h4 {
            font-weight: 700;
            color: #ffffff;
            font-size: 1.65rem;
            letter-spacing: 0.8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.4);
        }
        
        .login-box h4 span {
            color: #d4af37; /* Royal Gold Touch */
            font-weight: 800;
        }

        /* Labels styling for bright & clean contrast */
        .form-label {
            color: #f1f5f9;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }

        /* Dark Content Blocks to stop colors from blending into background */
        .form-control {
            border-radius: 12px;
            background: rgba(5, 8, 16, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #ffffff !important;
            padding: 14px 16px;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-control:focus {
            background: rgba(5, 8, 16, 0.85) !important;
            border-color: #4299e1;
            box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.3);
        }

        /* Corporate Blue Button with Hover Lighting */
        .btn-unique {
            border-radius: 12px;
            background: linear-gradient(135deg, #2b6cb0 0%, #1d4ed8 100%);
            border: 1px solid rgba(66, 153, 225, 0.5);
            color: #ffffff;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 15px rgba(29, 78, 216, 0.4);
        }

        .btn-unique:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-color: #60a5fa;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.6);
            color: #ffffff;
        }

        /* Password Field Configuration */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 50px;
        }

        /* Dynamic Eye Icon Fix */
        .toggle-password {
            position: absolute;
            right: 16px;
            bottom: 16px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            transition: all 0.2s ease;
            z-index: 5;
        }

        .toggle-password:hover {
            color: #d4af37;
        }

        /* Custom Alert System */
        .custom-alert {
            background: rgba(220, 53, 69, 0.25) !important;
            border: 1px solid rgba(220, 53, 69, 0.45) !important;
            color: #fca5a5 !important;
            border-radius: 12px;
            font-size: 0.9rem;
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h4 class="text-center mb-4">Mahaguru <span>Admin</span></h4>

        @if (session('error'))
            <div class="alert custom-alert p-3 mb-4 text-center">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@mahaguru.com" required autocomplete="off">
            </div>

            <div class="mb-4 password-wrapper">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit" class="btn btn-unique w-100 mt-2">Sign In</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const icon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>