<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - SmartQueue AI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Senior Developer Level -->
    <style>
        /* CSS Reset & Base */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* Luxury Color Palette */
            --primary-gold: #d4af37;
            --secondary-gold: #f4e4bc;
            --dark-gold: #b8941f;
            --platinum: #e5e4e2;
            --gunmetal: #2c3539;
            --charcoal: #36454f;
            --midnight: #191970;
            --pearl: #f8f6f0;
            --ivory: #fffff0;
            --cream: #fffdd0;
            --burgundy: #800020;
            --deep-blue: #00008b;
            --emerald: #50c878;
            --ruby: #e0115f;
            --sapphire: #0f52ba;
            
            /* Typography */
            --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-display: 'Space Grotesk', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-luxury: 0 35px 60px -12px rgba(212, 175, 55, 0.25);
            --shadow-premium: 0 40px 80px -20px rgba(0, 0, 0, 0.3);
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-gold) 0%, var(--dark-gold) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--platinum) 0%, var(--ivory) 100%);
            --gradient-dark: linear-gradient(135deg, var(--gunmetal) 0%, var(--charcoal) 100%);
            --gradient-hero: linear-gradient(135deg, var(--midnight) 0%, var(--deep-blue) 50%, var(--sapphire) 100%);
            --gradient-luxury: linear-gradient(135deg, var(--primary-gold) 0%, var(--burgundy) 50%, var(--ruby) 100%);
            
            /* Transitions */
            --transition-fast: 0.15s cubic-bezier(0.4, 0.0, 0.2, 1);
            --transition-base: 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0.0, 0.2, 1);
            --transition-super: 0.8s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            font-family: var(--font-primary);
            line-height: 1.6;
            color: var(--gunmetal);
            background: var(--gradient-hero);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Typography System */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        h1 { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 600; }
        h4 { font-size: clamp(1.25rem, 2.5vw, 1.5rem); font-weight: 600; }
        h5 { font-size: clamp(1.125rem, 2vw, 1.25rem); font-weight: 500; }
        h6 { font-size: 1rem; font-weight: 500; }

        p {
            font-size: clamp(0.875rem, 1.5vw, 1rem);
            font-weight: 400;
            line-height: 1.7;
            color: var(--charcoal);
        }

        /* Layout Utilities */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .flex { display: flex; }
        .grid { display: grid; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .text-center { text-align: center; }
        
        /* Spacing System */
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .gap-12 { gap: 3rem; }
        .gap-16 { gap: 4rem; }
        .gap-20 { gap: 5rem; }
        
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }
        .p-12 { padding: 3rem; }
        .p-16 { padding: 4rem; }
        .p-20 { padding: 5rem; }
        
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-16 { padding-top: 4rem; padding-bottom: 4rem; }
        .py-20 { padding-top: 5rem; padding-bottom: 5rem; }
        
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-12 { margin-bottom: 3rem; }
        .mb-16 { margin-bottom: 4rem; }
        .mb-20 { margin-bottom: 5rem; }
        
        /* Border Radius */
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        .rounded-3xl { border-radius: 1.5rem; }
        .rounded-full { border-radius: 50%; }
        
        /* Position */
        .relative { position: relative; }
        .absolute { position: absolute; }
        .sticky { position: sticky; }
        .top-0 { top: 0; }
        .z-50 { z-index: 50; }
        
        /* Colors */
        .text-primary { color: var(--primary-gold); }
        .text-secondary { color: var(--gunmetal); }
        .text-white { color: white; }
        .text-ivory { color: var(--ivory); }
        .text-pearl { color: var(--pearl); }
        
        .bg-primary { background: var(--primary-gold); }
        .bg-secondary { background: var(--gunmetal); }
        .bg-white { background: white; }
        .bg-ivory { background: var(--ivory); }
        .bg-pearl { background: var(--pearl); }
        .bg-gradient-primary { background: var(--gradient-primary); }
        .bg-gradient-secondary { background: var(--gradient-secondary); }
        .bg-gradient-dark { background: var(--gradient-dark); }
        .bg-gradient-hero { background: var(--gradient-hero); }
        .bg-gradient-luxury { background: var(--gradient-luxury); }
        
        /* Shadows */
        .shadow-sm { box-shadow: var(--shadow-sm); }
        .shadow-md { box-shadow: var(--shadow-md); }
        .shadow-lg { box-shadow: var(--shadow-lg); }
        .shadow-xl { box-shadow: var(--shadow-xl); }
        .shadow-2xl { box-shadow: var(--shadow-2xl); }
        .shadow-luxury { box-shadow: var(--shadow-luxury); }
        .shadow-premium { box-shadow: var(--shadow-premium); }
        
        /* Transitions */
        .transition { transition: all var(--transition-base); }
        .transition-fast { transition: all var(--transition-fast); }
        .transition-slow { transition: all var(--transition-slow); }
        .transition-super { transition: all var(--transition-super); }
        
        /* Login Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }
        
        /* Login Card */
        .login-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            box-shadow: var(--shadow-premium);
            border: 1px solid rgba(212, 175, 55, 0.1);
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 2;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-luxury);
        }
        
        /* Logo et Titre */
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gunmetal);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }
        
        .logo p {
            color: var(--charcoal);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gunmetal);
            font-size: 0.875rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            background: var(--ivory);
            color: var(--gunmetal);
            transition: all var(--transition-base);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: white;
        }
        
        .form-input::placeholder {
            color: var(--charcoal);
            opacity: 0.6;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-gold);
            font-weight: 600;
            font-size: 1.125rem;
        }
        
        .input-icon .form-input {
            padding-left: 3rem;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all var(--transition-base);
            position: relative;
            overflow: hidden;
            font-size: 1rem;
            width: 100%;
            justify-content: center;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-lg);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-luxury);
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid;
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--ruby);
        }
        
        .alert p {
            margin: 0;
            font-size: 0.875rem;
        }
        
        /* Error Messages */
        .error-message {
            color: var(--ruby);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }
        
        /* Links */
        .link {
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-base);
        }
        
        .link:hover {
            color: var(--dark-gold);
            text-decoration: underline;
        }
        
        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .login-footer p {
            color: var(--charcoal);
            font-size: 0.875rem;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .login-card {
                padding: 2rem;
                margin: 1rem;
            }
            
            .logo h1 {
                font-size: 1.5rem;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--pearl);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 6px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-gold);
        }
        
        /* Selection */
        ::selection {
            background: var(--primary-gold);
            color: white;
        }
        
        /* Focus States */
        .btn:focus,
        .form-input:focus {
            outline: 2px solid var(--primary-gold);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card animate-fade-in">
            <!-- Logo et Titre -->
            <div class="logo">
                <h1>SmartQueue AI</h1>
                <p>Connectez-vous à votre espace de gestion</p>
            </div>

            <!-- Messages d'erreur -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire de connexion -->
            <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
                <?php echo csrf_field(); ?>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-icon">
                        <span class="icon">@</span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>" 
                            required
                            autocomplete="email"
                            autofocus
                            class="form-input"
                            placeholder="exemple@email.com"
                        >
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="error-message"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-icon">
                        <span class="icon">*</span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            autocomplete="current-password"
                            class="form-input"
                            placeholder="Votre mot de passe"
                        >
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="error-message"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="btn btn-primary">
                    Se connecter
                </button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <p>
                    <a href="<?php echo e(route('welcome')); ?>" class="link">Retour à l'accueil</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Form validation before submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger';
                errorDiv.innerHTML = '<p>Veuillez remplir tous les champs obligatoires.</p>';
                
                const form = document.getElementById('loginForm');
                form.parentNode.insertBefore(errorDiv, form);
                
                // Remove after 5 seconds
                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);
                
                return false;
            }
            
            // Disable submit button to prevent double submission
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Connexion en cours...';
        });

        // Auto-focus first empty field
        document.addEventListener('DOMContentLoaded', function() {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            if (!email.value) {
                email.focus();
            } else if (!password.value) {
                password.focus();
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/auth/login.blade.php ENDPATH**/ ?>