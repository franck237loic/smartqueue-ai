<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Prise de Ticket - <?php echo e($company->name); ?> | SmartQueue AI</title>
    
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
            background: var(--pearl);
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 0, 0, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
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
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .flex { display: flex; }
        .grid { display: grid; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .text-center { text-align: center; }
        
        /* Spacing System */
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .gap-12 { gap: 3rem; }
        .gap-16 { gap: 4rem; }
        
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
        
        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gunmetal);
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            background: white;
            color: var(--gunmetal);
            transition: all var(--transition-base);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            background: white;
            color: var(--gunmetal);
            transition: all var(--transition-base);
            cursor: pointer;
        }
        
        .form-select:focus {
            outline: none;
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all var(--transition-base);
            position: relative;
            overflow: hidden;
            font-size: 1rem;
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
        
        .btn-secondary {
            background: transparent;
            color: var(--gunmetal);
            border: 2px solid var(--primary-gold);
        }
        
        .btn-secondary:hover {
            background: var(--primary-gold);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-lg {
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all var(--transition-base);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gunmetal);
            text-decoration: none;
        }
        
        .navbar-brand:hover {
            color: var(--primary-gold);
        }
        
        .navbar-logo {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.25rem;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-base);
        }
        
        .navbar-brand:hover .navbar-logo {
            transform: rotate(5deg) scale(1.1);
            box-shadow: var(--shadow-luxury);
        }
        
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .nav-link {
            color: var(--gunmetal);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all var(--transition-base);
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: all var(--transition-base);
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .nav-link:hover {
            color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.05);
        }
        
        /* Ticket Card */
        .ticket-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(212, 175, 55, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-luxury);
        }
        
        .ticket-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .company-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gunmetal);
            margin-bottom: 0.5rem;
        }
        
        .ticket-title {
            font-size: 1.25rem;
            color: var(--charcoal);
            margin-bottom: 1rem;
        }
        
        .ticket-subtitle {
            color: var(--charcoal);
            font-size: 1rem;
        }
        
        /* Queue Display */
        .queue-display {
            background: var(--gradient-secondary);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            border: 2px solid rgba(212, 175, 55, 0.2);
        }
        
        .queue-number {
            font-size: 4rem;
            font-weight: 900;
            color: var(--primary-gold);
            margin-bottom: 0.5rem;
            font-family: var(--font-mono);
        }
        
        .queue-label {
            font-size: 1.125rem;
            color: var(--gunmetal);
            font-weight: 600;
        }
        
        .queue-info {
            display: flex;
            justify-content: space-around;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        .queue-stat {
            text-align: center;
        }
        
        .queue-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gunmetal);
        }
        
        .queue-stat-label {
            font-size: 0.875rem;
            color: var(--charcoal);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        /* Success State */
        .success-state {
            display: none;
            text-align: center;
            padding: 2rem;
            background: rgba(80, 200, 120, 0.1);
            border-radius: 16px;
            border: 2px solid rgba(80, 200, 120, 0.2);
            margin-bottom: 2rem;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--emerald);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }
        
        .success-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--emerald);
            margin-bottom: 0.5rem;
        }
        
        .success-message {
            color: var(--charcoal);
            margin-bottom: 1rem;
        }
        
        .success-ticket {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-gold);
            font-family: var(--font-mono);
            background: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            display: inline-block;
            border: 2px solid var(--primary-gold);
            margin-bottom: 1rem;
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
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .navbar-nav {
                gap: 1rem;
            }
            
            .ticket-card {
                padding: 2rem;
            }
            
            .queue-number {
                font-size: 3rem;
            }
            
            .queue-info {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
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
        .nav-link:focus,
        .form-input:focus,
        .form-select:focus {
            outline: 2px solid var(--primary-gold);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="flex justify-between items-center py-4">
                <a href="<?php echo e(route('welcome')); ?>" class="navbar-brand">
                    <div class="navbar-logo">SQ</div>
                    <span>SmartQueue AI</span>
                </a>
                
                <div class="navbar-nav">
                    <a href="<?php echo e(route('companies.index')); ?>" class="nav-link">
                        Entreprises
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                        Connexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-20">
        <div class="container">
            <!-- Ticket Card -->
            <div class="ticket-card animate-fade-in">
                <!-- Header -->
                <div class="ticket-header">
                    <h1 class="company-name"><?php echo e($company->name); ?></h1>
                    <h2 class="ticket-title">Prise de Ticket</h2>
                    <p class="ticket-subtitle">Sélectionnez votre service et obtenez votre ticket numérique</p>
                </div>
                
                <!-- Queue Display -->
                <div class="queue-display">
                    <div class="queue-number" id="currentQueue">A001</div>
                    <div class="queue-label">Ticket Actuel</div>
                    <div class="queue-info">
                        <div class="queue-stat">
                            <div class="queue-stat-value" id="waitingCount">12</div>
                            <div class="queue-stat-label">En attente</div>
                        </div>
                        <div class="queue-stat">
                            <div class="queue-stat-value">~15</div>
                            <div class="queue-stat-label">Min d'attente</div>
                        </div>
                        <div class="queue-stat">
                            <div class="queue-stat-value">3</div>
                            <div class="queue-stat-label">Guichets</div>
                        </div>
                    </div>
                </div>
                
                <!-- Success State (Hidden by default) -->
                <div class="success-state" id="successState">
                    <div class="success-icon">+</div>
                    <h3 class="success-title">Ticket pris avec succès !</h3>
                    <p class="success-message">Votre ticket a été généré. Veuillez patienter jusqu'à ce que votre numéro soit appelé.</p>
                    <div class="success-ticket" id="ticketNumber">A013</div>
                    <p class="ticket-subtitle">Présentez ce numéro au guichet lorsque vous serez appelé.</p>
                </div>
                
                <!-- Form (Hidden after success) -->
                <form id="ticketForm" class="animate-slide-in">
                    <div class="form-group">
                        <label class="form-label" for="service">Service *</label>
                        <select class="form-select" id="service" name="service" required>
                            <option value="">Sélectionnez un service</option>
                            <?php $__currentLoopData = $company->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="name">Nom Complet *</label>
                        <input type="text" class="form-input" id="name" name="name" placeholder="Entrez votre nom complet" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Téléphone</label>
                        <input type="tel" class="form-input" id="phone" name="phone" placeholder="Entrez votre numéro de téléphone">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-input" id="email" name="email" placeholder="Entrez votre email">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="priority">Priorité</label>
                        <select class="form-select" id="priority" name="priority">
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                            <option value="vip">VIP</option>
                        </select>
                    </div>
                    
                    <div class="flex gap-4 justify-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Prendre mon ticket
                        </button>
                        <a href="<?php echo e(route('companies.index')); ?>" class="btn btn-secondary btn-lg">
                            Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Form submission
        document.getElementById('ticketForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Add CSRF token to form data
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            // Disable submit button
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Génération du ticket...';
            
            try {
                // Submit to server
                const response = await fetch(`/ticket/<?php echo e($company->id); ?>`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update success state with real ticket data
                    document.getElementById('ticketNumber').textContent = data.ticket.number;
                    document.getElementById('currentQueue').textContent = data.ticket.number;
                    
                    // Update service info
                    const serviceInfo = document.querySelector('.success-message');
                    serviceInfo.textContent = `Votre ticket ${data.ticket.number} a été généré pour le service ${data.ticket.service}.`;
                    
                    // Hide form, show success
                    this.style.display = 'none';
                    document.getElementById('successState').style.display = 'block';
                    
                    // Update queue display
                    updateQueueDisplay();
                    
                    // Simulate real-time updates
                    startRealTimeUpdates();
                } else {
                    alert('Erreur lors de la génération du ticket. Veuillez réessayer.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Erreur de connexion. Veuillez réessayer.');
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
        
        // Generate ticket number based on service and priority
        function generateTicketNumber(serviceId, priority) {
            const services = <?php echo json_encode($company->services, 15, 512) ?>;
            const service = services.find(s => s.id == serviceId);
            const prefix = service ? service.prefix : 'A';
            
            // Generate random number (1-999)
            const number = Math.floor(Math.random() * 999) + 1;
            
            // Format: PREFIX + 3 digits
            return `${prefix}${number.toString().padStart(3, '0')}`;
        }
        
        // Update queue display
        function updateQueueDisplay() {
            const waitingCount = document.getElementById('waitingCount');
            const currentCount = parseInt(waitingCount.textContent);
            waitingCount.textContent = currentCount + 1;
        }
        
        // Real-time updates simulation
        function startRealTimeUpdates() {
            setInterval(() => {
                // Update current ticket
                const currentQueue = document.getElementById('currentQueue');
                const current = currentQueue.textContent;
                const prefix = current[0];
                const number = parseInt(current.substring(1)) + 1;
                currentQueue.textContent = prefix + number.toString().padStart(3, '0');
                
                // Update waiting count
                const waitingCount = document.getElementById('waitingCount');
                const waiting = parseInt(waitingCount.textContent);
                if (waiting > 0) {
                    waitingCount.textContent = waiting - 1;
                }
            }, 10000); // Update every 10 seconds
        }
        
        // Auto-focus first input
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('#service');
            if (firstInput) {
                firstInput.focus();
            }
        });
        
        // Navbar scroll effect
        let lastScroll = 0;
        const navbar = document.querySelector('.navbar');
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = 'none';
            }
            
            lastScroll = currentScroll;
        });
        
        // Button ripple effect
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\pages\ticket.blade.php ENDPATH**/ ?>