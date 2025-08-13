<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baby Tracker - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Comic+Neue:wght@400;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #bcdee4, #efb4cd);
            background-repeat: no-repeat;
            min-height: 110vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: "Comic Neue", "Poppins", sans-serif;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
            overflow-y: hidden;
            position: relative;
        }

        .background-element {
            background-repeat: no-repeat;
            position: absolute;
            z-index: 0;
            opacity: 0.7;
        }

        .cloud {
            color: white;
            font-size: 3rem;
        }

        .balloon {
            font-size: 2rem;
        }

        .star {
            color: rgb(255, 255, 255);
            font-size: 1.5rem;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 20px;
            width: 100%;
            max-width: 350px;
            position: relative;
            z-index: 5;
            color: #5d5d5d;
            border: 3px solid #ff9a9e;
            box-shadow: 0 0 10px #ff6b88;
            animation: neonSplash 3s ease-in-out infinite alternate;
        }

        @keyframes neonSplash {
            0% {
                box-shadow:
                    0 0 10px #ffffff,
                    0 0 20px #fbf8f9,
                    0 0 30px #f1eeef,
                    0 0 40px #f9f6f7;
            }

            100% {
                box-shadow:
                    0 0 20px #f8e3e4,
                    0 0 30px #f8e3e4,
                    0 0 40px #f8e3e4,
                    0 0 60px #f8e3e4;
            }
        }

        .login-title {
            text-align: center;
            color: #ff6b88;
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 1.8rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ff6b88;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #a18cd1;
            border-radius: 10px;
            font-size: 1rem;
            font-family: "Comic Neue", "Poppins", sans-serif;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: #ff9a9e;
            box-shadow: 0 0 0 0.25rem rgba(255, 154, 158, 0.25);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 38px;
            background: none;
            border: none;
            color: #a18cd1;
            cursor: pointer;
            padding: 5px;
            z-index: 3;
            font-size: 1.2rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background-color: #ff6b88;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: "Comic Neue", "Poppins", sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 3px 0 #d45d75;
        }

        .btn-login:hover {
            background-color: #ff5777;
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(1px);
            box-shadow: 0 1px 0 #d45d75;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #a18cd1;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #8a74c9;
        }

        .login-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .login-container::before {
            content: "";
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            border: 2px dashed #ff9a9e;
            border-radius: 25px;
            z-index: -1;
            opacity: 0.5;
        }

        .alert {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 10px;
            font-size: 0.9rem;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="background-elements"></div>

    <div class="login-content">
        <div class="login-container">
            <h1 class="login-title">Baby Tracker Login</h1>

            <!-- Display session messages or validation errors -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Auto-close script -->
            <script>
                // Auto close alerts after 6 seconds
                setTimeout(function() {
                    let alerts = document.querySelectorAll('.alert');
                    alerts.forEach(function(alert) {
                        // Bootstrap 5 fade out
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 300); // Remove from DOM after fade
                    });
                }, 1000);
            </script>

            <form method="POST" action="{{ route('baby.login') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter your email" value="{{ old('email') }}" required />
                </div>
                <div class="form-group password-container">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password" required />
                    <button type="button" class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <button type="submit" class="btn-login">Login</button>
                <a href="#" class="forgot-password">Forgot password?</a>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector(".toggle-password");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const type =
                passwordInput.getAttribute("type") === "password" ?
                "text" :
                "password";
            passwordInput.setAttribute("type", type);
            togglePassword.innerHTML = `<i class="fas fa-eye${
          type === "password" ? "" : "-slash"
        }"></i>`;
        });

        const backgroundContainer = document.getElementById("background-elements");

        function createBackgroundElements() {
            const types = ["cloud", "balloon", "star"];
            const icons = {
                cloud: "꩜",
                balloon: "♡",
                star: "☆",
            };

            const elementCount = window.innerWidth < 768 ? 20 : 40;

            for (let i = 0; i < elementCount; i++) {
                const element = document.createElement("div");
                const type = types[Math.floor(Math.random() * types.length)];
                element.className = `background-element ${type}`;
                element.innerHTML = icons[type];

                const size = Math.random() * 1 + 1;
                const startX = Math.random() * window.innerWidth;
                const startY = Math.random() * window.innerHeight;

                element.style.fontSize = `${size}rem`;
                element.style.left = `${startX}px`;
                element.style.top = `${startY}px`;

                backgroundContainer.appendChild(element);

                animateElement(element, type);
            }
        }

        function animateElement(element, type) {
            const duration = 4 + Math.random() * 3; // Faster animation
            const delay = Math.random() * 1.5; // Faster start

            let xMovement, yMovement;

            switch (type) {
                case "cloud":
                    xMovement = 100 + Math.random() * 200;
                    yMovement = 20 + Math.random() * 40;
                    break;
                case "balloon":
                    xMovement = 50 + Math.random() * 150;
                    yMovement = 100 + Math.random() * 200;
                    break;
                case "star":
                    xMovement = 30 + Math.random() * 100;
                    yMovement = 30 + Math.random() * 60;
                    break;
            }

            if (Math.random() > 0.5) xMovement *= -1;
            if (Math.random() > 0.5) yMovement *= -1;

            const rotation = Math.random() * 360 - 180;

            gsap.to(element, {
                x: xMovement,
                y: yMovement,
                rotation: rotation,
                duration: duration,
                delay: delay,
                ease: "none",
                onComplete: () => {
                    element.style.left = `${Math.random() * window.innerWidth}px`;
                    element.style.top = `${Math.random() * window.innerHeight}px`;
                    animateElement(element, type);
                },
            });
        }

        createBackgroundElements();
    </script>
</body>

</html>
