<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ministry of Health Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #121212, #1a1a2e);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Comic Neue", "Poppins", sans-serif;
            margin: 0;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .login-container {
            background: rgba(30, 30, 46, 0.95);
            padding: 1.5rem;
            border-radius: 10px;
            width: 100%;
            max-width: 350px;
            position: relative;
            z-index: 10;
            color: #e0e0e0;
            border: 1px solid #4a4a6a;
            box-shadow: 0 0 15px rgba(74, 74, 106, 0.5);
            animation: blueGlow 3s ease-in-out infinite alternate;
        }

        @keyframes blueGlow {
            0% { box-shadow: 0 0 8px rgba(58, 123, 213, 0.3), 0 0 15px rgba(58, 123, 213, 0.2); }
            100% { box-shadow: 0 0 15px rgba(58, 123, 213, 0.4), 0 0 25px rgba(58, 123, 213, 0.3); }
        }

        .login-title {
            text-align: center;
            color: #4a8cff;
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 1.8rem;
            font-family: "Comic Neue", cursive;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .admin-icon {
            text-align: center;
            margin-bottom: 0.75rem;
            color: #4a8cff;
            font-size: 2.2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.3rem;
            color: #a0a0c0;
            font-weight: 600;
            font-size: 0.95rem;
            font-family: "Comic Neue", cursive;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #4a4a6a;
            border-radius: 8px;
            font-size: 0.95rem;
            background-color: rgba(40, 40, 60, 0.8);
            color: #ffffff; /* Brighter text color for better visibility */
            transition: all 0.3s;
            font-family: "Comic Neue", cursive;
        }

        .form-control:focus {
            border-color: #4a8cff;
            box-shadow: 0 0 0 0.2rem rgba(74, 140, 255, 0.25);
            background-color: rgba(50, 50, 70, 0.8);
            color: #ffffff; /* Maintain bright color when focused */
        }

        /* Placeholder text styling */
        .form-control::placeholder {
            color: #a0a0c0;
            opacity: 0.7;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 35px;
            background: none;
            border: none;
            color: #a0a0c0;
            cursor: pointer;
            padding: 4px;
            font-size: 1.1rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(135deg, #4a8cff, #3a7bd5);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 0 rgba(44, 95, 179, 0.7);
            font-family: "Comic Neue", cursive;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #3a7bd5, #2c5fb3);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(1px);
            box-shadow: 0 1px 0 rgba(44, 95, 179, 0.7);
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 0.75rem;
            color: #a0a0c0;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: color 0.3s;
            font-family: "Comic Neue", cursive;
        }

        .forgot-password:hover {
            color: #4a8cff;
            text-decoration: underline;
        }

        .security-bg {
            position: absolute;
            color: rgba(74, 140, 255, 0.05);
            font-size: 15rem;
            z-index: 1;
            pointer-events: none;
        }

        .floating-icons {
            position: absolute;
            color: rgba(74, 140, 255, 0.1);
            font-size: 1.5rem;
            animation: float 6s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 1rem;
        }

        .logo-img {
            max-width: 100px;
            height: auto;
        }

        .ministry-name {
            text-align: center;
            color: #e0e0e0;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-family: "Comic Neue", cursive;
        }

        .copyright {
            text-align: center;
            color: #a0a0c0;
            font-size: 0.8rem;
            margin-top: 1rem;
            font-family: "Comic Neue", cursive;
        }
    </style>
</head>
<body>
    <i class="fas fa-shield-alt security-bg" style="top: -40px; left: -40px;"></i>
    <i class="fas fa-lock security-bg" style="bottom: -40px; right: -40px;"></i>

    <!-- Floating icons -->
    <i class="fas fa-user-shield floating-icons" style="top: 20%; left: 10%; animation-delay: 0s;"></i>
    <i class="fas fa-key floating-icons" style="top: 70%; left: 15%; animation-delay: 1s;"></i>
    <i class="fas fa-cog floating-icons" style="top: 30%; right: 10%; animation-delay: 2s;"></i>
    <i class="fas fa-lock floating-icons" style="top: 80%; right: 15%; animation-delay: 3s;"></i>

    <div class="login-container">

        <div class="admin-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h1 class="login-title">Admin Login</h1>

<form id="adminLoginForm" method="POST" action="{{ route('admin.login.form') }}">
            @csrf

    <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror"
               id="email" name="email"
               value="{{ old('email') }}"
               placeholder="admin@example.com" required>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group password-container">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror"
               id="password" name="password"
               placeholder="Enter your password" required>
        <button type="button" class="toggle-password">
            <i class="fas fa-eye"></i>
        </button>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn-login mb-2">Login</button>

    @if (Route::has('admin.password.request'))
        <a href="" class="forgot-password">
            Forgot password?
        </a>
    @endif
</form>
        <div class="copyright">© 2025 Ministry of Health. All rights reserved.</div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector(".toggle-password");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            togglePassword.innerHTML = `<i class="fas fa-eye${type === "password" ? "" : "-slash"}"></i>`;
            togglePassword.style.color = type === "password" ? "#a0a0c0" : "#4a8cff";
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
