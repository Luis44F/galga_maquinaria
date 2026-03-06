<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Inicio de Sesión</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0f1c;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            color: #e2e8f0;
        }

        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #38bdf8;
            --secondary: #2563eb;
            --success: #10b981;
            --dark-bg: #0a0f1c;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --input-bg: #1e293b;
            --error: #ef4444;
        }

        /* Background Animation */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                        linear-gradient(135deg, #0a0f1c 0%, #111827 100%);
            z-index: -2;
        }

        .bg-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(14, 165, 233, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(14, 165, 233, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: -1;
        }

        @keyframes gridMove {
            0% { transform: translateY(0); }
            100% { transform: translateY(50px); }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }

        .orb-1 {
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(14, 165, 233, 0.15);
            animation: float 15s ease-in-out infinite;
        }

        .orb-2 {
            bottom: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: rgba(37, 99, 235, 0.1);
            animation: float 20s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-50px) scale(1.1); }
        }

        /* Login Container */
        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        /* Login Card */
        .login-card {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(14, 165, 233, 0.2);
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            animation: cardAppear 0.6s ease-out;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--primary));
            background-size: 200% 100%;
            animation: gradientMove 3s linear infinite;
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradientMove {
            0% { background-position: 0% 0%; }
            100% { background-position: 200% 0%; }
        }

        /* Logo */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(45deg);
            animation: rotateIn 0.6s ease-out;
        }

        .logo-icon i {
            transform: rotate(-45deg);
            color: #0a0f1c;
            font-size: 28px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        @keyframes rotateIn {
            from { transform: rotate(0deg) scale(0.8); opacity: 0; }
            to { transform: rotate(45deg) scale(1); opacity: 1; }
        }

        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--text-dim);
            font-size: 15px;
        }

        /* Error Message */
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fecaca;
            font-size: 14px;
            animation: shake 0.5s ease-in-out;
        }

        .error-message i {
            color: var(--error);
            font-size: 18px;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* Form */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: var(--primary);
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-dim);
            font-size: 16px;
            transition: color 0.3s;
            z-index: 1;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: var(--input-bg);
            border: 2px solid transparent;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            color: var(--text-light);
            transition: all 0.3s;
        }

        .input-wrapper input::placeholder {
            color: #4b5563;
            font-size: 14px;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--primary);
            background: #2d3a4f;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .input-wrapper input:focus + .input-icon {
            color: var(--primary);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: var(--text-dim);
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            z-index: 1;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Form Options */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            margin-top: 4px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dim);
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .login-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .login-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        }

        .login-btn i {
            font-size: 16px;
            transition: transform 0.3s;
        }

        .login-btn:hover i {
            transform: translateX(5px);
        }

        /* Footer */
        .login-footer {
            margin-top: 24px;
            text-align: center;
            color: var(--text-dim);
            font-size: 14px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
            transition: color 0.3s;
        }

        .login-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Loading State */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            border: none;
            border-radius: 50%;
            color: #0a0f1c;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            background: var(--primary-dark);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }

            .form-options {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .scroll-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="bg-pattern"></div>
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- Login Container -->
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="logo-text">GALGA</span>
            </div>

            <!-- Header -->
            <div class="login-header">
                <h1>Bienvenido</h1>
                <p>Ingresa tus credenciales para continuar</p>
            </div>

            <!-- Error Message (Laravel Validation) -->
            @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group">
                    <label>
                        <i class="fas fa-envelope"></i>
                        Correo electrónico
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="tu@email.com" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label>
                        <i class="fas fa-lock"></i>
                        Contraseña
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="••••••••" 
                            required
                        >
                        <button 
                            type="button" 
                            class="password-toggle" 
                            onclick="togglePassword()"
                            tabindex="-1"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Options -->
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Recordar mi sesión</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn" id="submitBtn">
                    <span>Ingresar al sistema</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}">Solicitar acceso</a>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('btn-loading');
            btn.innerHTML = '<i class="fas fa-spinner"></i> Verificando...';
        });

        // Scroll to top button visibility
        window.addEventListener('scroll', function() {
            const scrollTop = document.getElementById('scrollTop');
            
            if (window.scrollY > 200) {
                scrollTop.classList.add('visible');
            } else {
                scrollTop.classList.remove('visible');
            }
        });

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>