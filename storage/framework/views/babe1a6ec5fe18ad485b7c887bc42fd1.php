<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entreprises Premium | SmartQueue AI</title>
    
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
        
        .btn-secondary:hover {
            background: var(--primary-gold);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        /* Hero Section */
        .hero {
            min-height: 60vh;
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
            padding: 6rem 0;
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
        
        .hero-stats {
            display: flex;
            gap: 3rem;
            justify-content: center;
            margin-top: 3rem;
            animation: fadeInUp 1s ease-out 0.4s both;
            flex-wrap: wrap;
        }
        
        .hero-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .hero-stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-gold);
        }
        
        .hero-stat-label {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        /* Companies Section */
        .companies {
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
        
        .companies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }
        
        .company-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-slow);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .company-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-luxury);
        }
        
        .company-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-premium);
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .company-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .company-logo {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.5rem;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-base);
        }
        
        .company-card:hover .company-logo {
            transform: rotate(5deg) scale(1.1);
            box-shadow: var(--shadow-luxury);
        }
        
        .company-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .company-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .badge-active {
            background: rgba(80, 200, 120, 0.1);
            color: var(--emerald);
            border: 1px solid rgba(80, 200, 120, 0.2);
        }
        
        .badge-premium {
            background: rgba(212, 175, 55, 0.1);
            color: var(--primary-gold);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gunmetal);
            margin-bottom: 0.5rem;
        }
        
        .company-description {
            color: var(--charcoal);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .company-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .company-info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--charcoal);
            font-size: 0.875rem;
        }
        
        .company-info-icon {
            width: 20px;
            height: 20px;
            color: var(--primary-gold);
            flex-shrink: 0;
        }
        
        .company-actions {
            display: flex;
            gap: 1rem;
        }
        
        .company-actions .btn {
            flex: 1;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
        }
        
        /* Filter Section */
        .filters {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gunmetal);
        }
        
        .filter-results {
            color: var(--charcoal);
            font-size: 0.875rem;
        }
        
        .filter-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            background: transparent;
            color: var(--gunmetal);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-base);
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .empty-icon {
            width: 120px;
            height: 120px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: var(--primary-gold);
        }
        
        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gunmetal);
            margin-bottom: 1rem;
        }
        
        .empty-description {
            color: var(--charcoal);
            margin-bottom: 2rem;
            max-width: 400px;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .navbar-nav {
                gap: 1rem;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .companies-grid {
                grid-template-columns: 1fr;
            }
            
            .company-actions {
                flex-direction: column;
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
                <a href="<?php echo e(route('welcome')); ?>" class="navbar-brand">
                    <div class="navbar-logo">SQ</div>
                    <span>SmartQueue AI</span>
                </a>
                
                <div class="navbar-nav">
                    <a href="<?php echo e(route('welcome')); ?>" class="nav-link">
                        Accueil
                    </a>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Entreprises Premium
                </h1>
                <p class="hero-subtitle">
                    Découvrez les entreprises leaders qui utilisent SmartQueue AI pour optimiser leur gestion de files d'attente
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">
                            <?php
                            $count = \App\Models\Company::where('status', 'active')->count();
                            echo $count;
                            ?>
                        </div>
                        <div class="hero-stat-label">Entreprises Actives</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">24/7</div>
                        <div class="hero-stat-label">Service Continu</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">99.9%</div>
                        <div class="hero-stat-label">Uptime</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Companies Section -->
    <section class="companies">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Nos Entreprises Partenaires</h2>
                <p class="section-subtitle">
                    Rejoignez les entreprises innovantes qui font confiance à notre technologie de pointe
                </p>
            </div>
            
            <!-- Filters -->
            <div class="filters">
                <div class="filter-header">
                    <h3 class="filter-title">Filtrer par secteur</h3>
                    <div class="filter-results">
                        <?php
                        $count = \App\Models\Company::where('status', 'active')->count();
                        echo $count . ' entreprises trouvées';
                        ?>
                    </div>
                </div>
                <div class="filter-options">
                    <button class="filter-btn active" data-filter="all">Tous</button>
                    <button class="filter-btn" data-filter="retail">Commerce</button>
                    <button class="filter-btn" data-filter="health">Santé</button>
                    <button class="filter-btn" data-filter="government">Public</button>
                    <button class="filter-btn" data-filter="education">Éducation</button>
                </div>
            </div>
            
            <!-- Companies Grid -->
            <div class="companies-grid">
                <?php
                $companies = \App\Models\Company::where('status', 'active')->get();
                ?>
                
                <?php if($companies->count() > 0): ?>
                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="company-card" data-category="<?php echo e($company->sector ?? 'all'); ?>">
                        <div class="company-header">
                            <div class="company-logo">
                                <?php echo e(strtoupper(substr($company->name, 0, 2))); ?>

                            </div>
                            <div class="company-badges">
                                <span class="company-badge badge-active">Active</span>
                                <?php if($company->is_premium ?? false): ?>
                                <span class="company-badge badge-premium">Premium</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <h3 class="company-name"><?php echo e($company->name); ?></h3>
                        <p class="company-description">
                            <?php echo e($company->description ?? 'Leader dans son secteur, cette entreprise utilise SmartQueue AI pour offrir une expérience client exceptionnelle.'); ?>

                        </p>
                        
                        <div class="company-info">
                            <div class="company-info-item">
                                <svg class="company-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span><?php echo e($company->city ?? 'Paris, France'); ?></span>
                            </div>
                            <div class="company-info-item">
                                <svg class="company-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span><?php echo e($company->email ?? 'contact@' . strtolower(str_replace(' ', '', $company->name)) . '.com'); ?></span>
                            </div>
                            <div class="company-info-item">
                                <svg class="company-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span><?php echo e($company->phone ?? '+33 1 23 45 67 89'); ?></span>
                            </div>
                        </div>
                        
                        <div class="company-actions">
                            <a href="<?php echo e(route('ticket', $company->id)); ?>" class="btn btn-primary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Prendre un ticket
                            </a>
                            <a href="#" class="btn btn-secondary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="empty-title">Aucune entreprise disponible</h3>
                        <p class="empty-description">
                            Aucune entreprise n'est actuellement disponible. Veuillez réessayer plus tard ou contacter notre support.
                        </p>
                        <a href="<?php echo e(route('welcome')); ?>" class="btn btn-primary">
                            Retour à l'accueil
                        </a>
                    </div>
                <?php endif; ?>
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
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const companyCards = document.querySelectorAll('.company-card');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                
                // Show/hide company cards based on filter
                companyCards.forEach(card => {
                    if (filter === 'all' || card.dataset.category === filter) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeInUp 0.5s ease-out';
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Update results count
                const visibleCards = Array.from(companyCards).filter(card => 
                    card.style.display !== 'none'
                ).length;
                
                document.querySelector('.filter-results').textContent = 
                    `${visibleCards} entreprises trouvées`;
            });
        });

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

        // Observe company cards
        document.querySelectorAll('.company-card').forEach(card => {
            observer.observe(card);
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

        // Company card hover effect
        document.querySelectorAll('.company-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/pages/companies.blade.php ENDPATH**/ ?>