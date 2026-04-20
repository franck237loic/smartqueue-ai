<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartQueue AI | Premium Queue Management Solution</title>
    
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
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 0, 0, 0.05) 0%, transparent 50%),
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
            max-width: 1400px;
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
        
        .m-4 { margin: 1rem; }
        .m-6 { margin: 1.5rem; }
        .m-8 { margin: 2rem; }
        
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
        
        /* Hover Effects */
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-luxury);
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
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
        
        .btn-outline {
            background: transparent;
            color: var(--primary-gold);
            border: 2px solid var(--primary-gold);
            transition: all var(--transition-base);
        }
        
        .btn-outline:hover {
            background: var(--primary-gold);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        }
        
        .btn-secondary:hover {
            background: var(--primary-gold);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: var(--gradient-hero);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
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
        
        .hero-content {
            position: relative;
            z-index: 2;
            padding: 8rem 0;
            text-align: center;
        }
        
        .hero-title {
            color: white;
            margin-bottom: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            animation: fadeInUp 1s ease-out;
        }
        
        .hero-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.25rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 1s ease-out 0.2s both;
        }
        
        .hero-actions {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.4s both;
        }
        
        .hero-features {
            display: flex;
            gap: 3rem;
            justify-content: center;
            margin-top: 3rem;
            animation: fadeInUp 1s ease-out 0.6s both;
        }
        
        .hero-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }
        
        .hero-feature-icon {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Floating Elements */
        .floating-element {
            position: absolute;
            pointer-events: none;
            opacity: 0.1;
        }
        
        .floating-circle-1 {
            width: 300px;
            height: 300px;
            background: var(--primary-gold);
            border-radius: 50%;
            top: 10%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-circle-2 {
            width: 200px;
            height: 200px;
            background: var(--burgundy);
            border-radius: 50%;
            bottom: 20%;
            right: 15%;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        .floating-square {
            width: 150px;
            height: 150px;
            background: var(--emerald);
            transform: rotate(45deg);
            top: 50%;
            right: 10%;
            animation: float 7s ease-in-out infinite;
        }
        
        /* Features Section */
        .features {
            padding: 6rem 0;
            background: var(--ivory);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title {
            color: var(--gunmetal);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: var(--charcoal);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-slow);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-luxury);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-premium);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-base);
        }
        
        .feature-card:hover .feature-icon {
            transform: rotate(5deg) scale(1.1);
            box-shadow: var(--shadow-luxury);
        }
        
        .feature-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }
        
        .feature-title {
            color: var(--gunmetal);
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: var(--charcoal);
            line-height: 1.7;
        }
        
        /* CTA Section */
        .cta {
            padding: 6rem 0;
            background: var(--gradient-dark);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            pointer-events: none;
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        .cta-title {
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .cta-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.125rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Footer */
        .footer {
            background: var(--gunmetal);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-logo {
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
        }
        
        .footer-brand-name {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            margin-bottom: 2rem;
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all var(--transition-base);
        }
        
        .social-link:hover {
            background: var(--primary-gold);
            transform: translateY(-2px);
        }
        
        .footer-column h4 {
            color: var(--primary-gold);
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
        }
        
        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all var(--transition-base);
        }
        
        .footer-links a:hover {
            color: var(--primary-gold);
            transform: translateX(4px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .footer-copyright {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }
        
        .footer-legal {
            display: flex;
            gap: 2rem;
        }
        
        .footer-legal a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all var(--transition-base);
        }
        
        .footer-legal a:hover {
            color: var(--primary-gold);
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
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
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
        
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 5px rgba(212, 175, 55, 0.5);
            }
            50% {
                box-shadow: 0 0 20px rgba(212, 175, 55, 0.8);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .navbar-nav {
                gap: 1rem;
            }
            
            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .hero-features {
                flex-direction: column;
                gap: 1rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
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
        .nav-link:focus {
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
                <a href="{{ route('welcome') }}" class="navbar-brand">
                    <div class="navbar-logo">SQ</div>
                    <span>SmartQueue AI</span>
                </a>
                
                <div class="navbar-nav">
                    <a href="{{ route('companies.index') }}" class="nav-link">
                        Entreprises
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Connexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="floating-element floating-circle-1"></div>
        <div class="floating-element floating-circle-2"></div>
        <div class="floating-element floating-square"></div>
        
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Gestion Intelligente<br>
                    <span style="color: var(--primary-gold);">de File d'Attente</span>
                </h1>
                <p class="hero-subtitle">
                    Solution premium pour les entreprises modernes. Optimisez l'expérience client avec notre technologie de pointe.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                        Accès Dashboard
                    </a>
                    <a href="{{ route('client.ticket') }}" class="btn btn-secondary" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                        Prendre un ticket
                    </a>
                    <a href="{{ route('companies.index') }}" class="btn btn-outline" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                        Découvrir les entreprises
                    </a>
                </div>
                <div class="hero-features">
                    <div class="hero-feature">
                        <div class="hero-feature-icon">+</div>
                        <span>Enterprise Ready</span>
                    </div>
                    <div class="hero-feature">
                        <div class="hero-feature-icon">+</div>
                        <span>AI Powered</span>
                    </div>
                    <div class="hero-feature">
                        <div class="hero-feature-icon">+</div>
                        <span>Real-time Analytics</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Fonctionnalités Premium</h2>
                <p class="section-subtitle">
                    Découvrez notre suite complète d'outils conçus pour transformer votre gestion de files d'attente
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Tickets Digitaux</h3>
                    <p class="feature-description">
                        Système de prise de ticket numérique avec QR code, notifications SMS et application mobile dédiée.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Appel Vocal Intégré</h3>
                    <p class="feature-description">
                        Synthèse vocale multilingue avec annonces automatiques et personnalisation des messages.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Analytics Avancés</h3>
                    <p class="feature-description">
                        Tableaux de bord en temps réel avec KPIs personnalisables et rapports détaillés.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Prêt à Transformer Votre Gestion ?</h2>
                <p class="cta-subtitle">
                    Rejoignez les entreprises leaders qui utilisent déjà SmartQueue AI pour optimiser leurs opérations.
                </p>
                <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('companies.index') }}" class="btn btn-primary" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                        Voir les entreprises
                    </a>
                    <a href="{{ route('client.ticket') }}" class="btn btn-outline" style="font-size: 1.125rem; padding: 1rem 2.5rem; border: 2px solid var(--primary-gold); color: var(--primary-gold); background: transparent;">
                        Prendre un ticket
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                        Commencer
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <div class="footer-brand">
                        <div class="footer-logo">SQ</div>
                        <span class="footer-brand-name">SmartQueue AI</span>
                    </div>
                    <p class="footer-description">
                        Solution premium de gestion de files d'attente pour les entreprises modernes. 
                        Technologie de pointe au service de l'excellence opérationnelle.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4>Produits</h4>
                    <div class="footer-links">
                        <a href="#">Tickets Digitaux</a>
                        <a href="#">Appel Vocal</a>
                        <a href="#">Analytics</a>
                        <a href="#">API</a>
                    </div>
                </div>
                
                <div>
                    <h4>Solutions</h4>
                    <div class="footer-links">
                        <a href="#">Entreprises</a>
                        <a href="#">Santé</a>
                        <a href="#">Gouvernement</a>
                        <a href="#">Éducation</a>
                    </div>
                </div>
                
                <div>
                    <h4>Support</h4>
                    <div class="footer-links">
                        <a href="#">Documentation</a>
                        <a href="#">Centre d'aide</a>
                        <a href="#">Contact</a>
                        <a href="#">Statut du service</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-copyright">
                    © 2026 SmartQueue AI. Tous droits réservés.
                </div>
                <div class="footer-legal">
                    <a href="#">Confidentialité</a>
                    <a href="#">Conditions</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
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

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            observer.observe(card);
        });

        // Parallax effect for floating elements
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.floating-element');
            
            parallax.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

                
        // Debug login button behavior
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔍 Debug page d\'accueil chargée');
            console.log('URL actuelle:', window.location.href);
            
            // Trouver tous les boutons de connexion
            const loginButtons = document.querySelectorAll('a[href*="login"]');
            console.log('Boutons de connexion trouvés:', loginButtons.length);
            
            loginButtons.forEach((button, index) => {
                const href = button.getAttribute('href');
                console.log(`Bouton ${index + 1}:`, {
                    href: href,
                    text: button.textContent.trim(),
                    onclick: button.getAttribute('onclick')
                });
                
                // Ajouter un écouteur d'événement pour débogage
                button.addEventListener('click', function(e) {
                    console.log('🖱️ Clic sur bouton connexion détecté:', {
                        button: this.textContent.trim(),
                        href: this.getAttribute('href'),
                        onclick: this.getAttribute('onclick')
                    });
                    
                    // Forcer la navigation
                    const loginUrl = this.getAttribute('href');
                    if (loginUrl && loginUrl !== '#') {
                        console.log('🔄 Redirection forcée vers:', loginUrl);
                        e.preventDefault();
                        window.location.href = loginUrl;
                    }
                });
            });
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
