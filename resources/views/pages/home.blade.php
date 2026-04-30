<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartQueue AI | Gestion Intelligente de Files d'Attente</title>
    <meta name="description" content="Solution moderne de gestion de files d'attente avec IA pour optimiser l'expérience client et réduire les temps d'attente.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            font-weight: 400;
            color: #1a202c;
            background: #ffffff;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        @media (min-width: 640px) {
            .container {
                padding: 0 40px;
            }
        }
        
        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            color: #3b82f6;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 40px;
        }
        
        .nav-link {
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: #3b82f6;
        }
        
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: #3b82f6;
            border: 2px solid #3b82f6;
        }
        
        .btn-secondary:hover {
            background: #3b82f6;
            color: white;
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
            background-size: 600% 600%;
            animation: gradientShift 20s ease infinite;
        }
        
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
            pointer-events: none;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
            backdrop-filter: blur(2px);
            z-index: 1;
        }
        
        .hero-content {
            text-align: center;
            color: white;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            z-index: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Hero Badge */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 8px 20px;
            margin-bottom: 32px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .badge-icon {
            font-size: 16px;
        }
        
        .badge-text {
            color: white;
            font-size: 14px;
            font-weight: 600;
        }
        
        .hero-title {
            font-size: clamp(36px, 5vw, 64px);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 24px;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: clamp(18px, 2vw, 24px);
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Hero Stats */
        .hero-stats {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 32px;
            margin: 0 auto 48px auto;
            flex-wrap: wrap;
            width: 100%;
            max-width: 800px;
        }
        
        .stat-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px 24px;
            min-width: 160px;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 200px;
        }
        
        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }
        
        /* Hero Trust */
        .hero-trust {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 24px;
            margin-top: 48px;
            flex-wrap: wrap;
            width: 100%;
            max-width: 600px;
        }
        
        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.05);
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .trust-item i {
            color: #10b981;
            flex-shrink: 0;
        }
        
        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            padding: 16px 32px;
            font-size: 18px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        .btn-hero-white {
            background: white;
            color: #3b82f6;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }
        
        .btn-hero-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
        
        .btn-hero-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-hero-outline:hover {
            background: white;
            color: #3b82f6;
        }
        
        /* Sections */
        .section {
            padding: 100px 0;
        }
        
        .section-light {
            background: #f8fafc;
        }
        
        .section-white {
            background: white;
        }
        
        .section-title {
            text-align: center;
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 16px;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 18px;
            color: #4a5568;
            max-width: 600px;
            margin: 0 auto 60px;
            line-height: 1.6;
        }
        
        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }
        
        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }
        
        .feature-title {
            font-size: 24px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 16px;
        }
        
        .feature-description {
            font-size: 16px;
            color: #4a5568;
            line-height: 1.6;
        }
        
        /* Steps */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }
        
        .step {
            text-align: center;
        }
        
        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 24px;
            font-weight: 700;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }
        
        .step-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 16px;
        }
        
        .step-description {
            font-size: 16px;
            color: #4a5568;
            line-height: 1.6;
        }
        
        /* Testimonials */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }
        
        .testimonial-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 16px;
            object-fit: cover;
        }
        
        .testimonial-info h4 {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 4px;
        }
        
        .testimonial-info p {
            font-size: 14px;
            color: #4a5568;
        }
        
        .testimonial-text {
            font-size: 16px;
            color: #2d3748;
            line-height: 1.6;
            font-style: italic;
        }
        
        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 800;
            color: #3b82f6;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 16px;
            color: #4a5568;
            font-weight: 500;
        }
        
        /* CTA */
        .cta-card {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            padding: 60px 40px;
            border-radius: 24px;
            text-align: center;
            color: white;
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.3);
        }
        
        .cta-title {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 700;
            margin-bottom: 16px;
        }
        
        .cta-subtitle {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-cta {
            padding: 16px 32px;
            font-size: 18px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        .btn-cta-white {
            background: white;
            color: #3b82f6;
        }
        
        .btn-cta-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-cta-outline:hover {
            background: white;
            color: #3b82f6;
        }
        
        /* Footer */
        .footer {
            background: #1a202c;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column li {
            margin-bottom: 12px;
        }
        
        .footer-column a {
            color: #a0aec0;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .footer-column a:hover {
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid #2d3748;
            padding-top: 30px;
            text-align: center;
            color: #a0aec0;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .features-grid,
            .steps-grid,
            .testimonials-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="{{ route('welcome') }}" class="logo">
                    <div class="logo-icon">
                        <i data-lucide="layers" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div class="logo-text">SmartQueue<span> AI</span></div>
                </a>
                
                <div class="nav-links">
                    <a href="#features" class="nav-link">Fonctionnalités</a>
                    <a href="#how-it-works" class="nav-link">Comment ça marche</a>
                    <a href="#testimonials" class="nav-link">Témoignages</a>
                </div>
                
                <div class="nav-actions">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-secondary">Connexion</a>
                    @endif
                    <a href="{{ route('companies.index') }}" class="btn btn-primary">
                        <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                        Commencer
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <!-- Badge d'accueil -->
                <div class="hero-badge">
                    <span class="badge-icon">🎯</span>
                    <span class="badge-text">Solution #1 en Gestion de Files d'Attente</span>
                </div>
                
                <h1 class="hero-title">
                    Gestion Intelligente des Files d'Attente avec l'IA
                </h1>
                
                <p class="hero-subtitle">
                    Transformez l'expérience de vos clients avec notre système de files d'attente intelligent. 
                    Réduisez les temps d'attente jusqu'à 60% et augmentez la satisfaction client de 85%.
                </p>
                
                <!-- Stats en temps réel -->
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Entreprises Actives</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2M+</div>
                        <div class="stat-label">Tickets Traités</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfaction Client</div>
                    </div>
                </div>
                
                <div class="hero-buttons">
                    <a href="{{ route('companies.index') }}" class="btn btn-hero btn-hero-white">
                        <i data-lucide="rocket" style="width: 20px; height: 20px;"></i>
                        Commencer maintenant
                    </a>
                    <a href="#how-it-works" class="btn btn-hero btn-hero-outline">
                        <i data-lucide="play-circle" style="width: 20px; height: 20px;"></i>
                        Voir la démo
                    </a>
                </div>
                
                <!-- Trust indicators -->
                <div class="hero-trust">
                    <div class="trust-item">
                        <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i>
                        <span>Sécurisé et Fiable</span>
                    </div>
                    <div class="trust-item">
                        <i data-lucide="zap" style="width: 16px; height: 16px;"></i>
                        <span>Rapide et Efficace</span>
                    </div>
                    <div class="trust-item">
                        <i data-lucide="users" style="width: 16px; height: 16px;"></i>
                        <span>Support 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section section-light">
        <div class="container">
            <h2 class="section-title">Fonctionnalités Puissantes</h2>
            <p class="section-subtitle">
                Découvrez comment notre technologie de pointe transforme votre gestion des files d'attente
            </p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="brain" style="width: 40px; height: 40px; color: white;"></i>
                    </div>
                    <h3 class="feature-title">Intelligence Artificielle</h3>
                    <p class="feature-description">
                        Notre algorithme avancé prédit les temps d'attente et optimise automatiquement la répartition des ressources pour une efficacité maximale.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="smartphone" style="width: 40px; height: 40px; color: white;"></i>
                    </div>
                    <h3 class="feature-title">Interface Web Mobile</h3>
                    <p class="feature-description">
                        Permettez à vos clients de prendre un ticket et suivre leur position en temps réel depuis leur smartphone via l'interface web responsive.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="bar-chart-3" style="width: 40px; height: 40px; color: white;"></i>
                    </div>
                    <h3 class="feature-title">Analytics Avancés</h3>
                    <p class="feature-description">
                        Accédez à des tableaux de bord complets avec des métriques en temps réel, des rapports détaillés et des insights prédictifs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="section section-white">
        <div class="container">
            <h2 class="section-title">Comment Ça Marche</h2>
            <p class="section-subtitle">
                Une solution simple en 3 étapes pour révolutionner votre gestion
            </p>
            
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Prise de Ticket</h3>
                    <p class="step-description">
                        Le client accède à l'interface web et sélectionne son service pour obtenir un ticket numérique instantanément.
                    </p>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Suivi en Temps Réel</h3>
                    <p class="step-description">
                        Le client reçoit des notifications automatiques et peut suivre son temps d'attente estimé en temps réel.
                    </p>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Service Optimisé</h3>
                    <p class="step-description">
                        L'IA analyse les données pour optimiser les flux et réduire les temps d'attente futurs de manière proactive.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="section section-light">
        <div class="container">
            <h2 class="section-title">Ce Que Disent Nos Clients</h2>
            <p class="section-subtitle">
                Découvrez pourquoi des milliers d'entreprises nous font confiance
            </p>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="https://picsum.photos/seed/marie/60/60" alt="Marie Dubois" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4>Marie Dubois</h4>
                            <p>Directrice, Banque Central</p>
                        </div>
                    </div>
                    <p class="testimonial-text">
                        "SmartQueue AI a transformé notre service client. Temps d'attente réduit de 70% et satisfaction client augmentée de 85%."
                    </p>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="https://picsum.photos/seed/jean/60/60" alt="Jean Martin" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4>Jean Martin</h4>
                            <p>Manager, Hôpital Saint-Louis</p>
                        </div>
                    </div>
                    <p class="testimonial-text">
                        "L'intelligence artificielle nous permet d'anticiper les pics d'affluence. C'est révolutionnaire pour notre organisation."
                    </p>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="https://picsum.photos/seed/sophie/60/60" alt="Sophie Laurent" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4>Sophie Laurent</h4>
                            <p>CEO, TechCorp</p>
                        </div>
                    </div>
                    <p class="testimonial-text">
                        "Le ROI est incroyable. Nous avons économisé 200h de personnel par mois grâce à l'optimisation automatique."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section section-white">
        <div class="container">
            <h2 class="section-title">Ils Nous Font Confiance</h2>
            <p class="section-subtitle">
                Rejoignez les entreprises leaders qui utilisent déjà SmartQueue AI
            </p>
            
            <div class="stats-grid">
                <div class="stat">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Entreprises</div>
                </div>
                <div class="stat">
                    <div class="stat-number">2M+</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
                <div class="stat">
                    <div class="stat-number">50M+</div>
                    <div class="stat-label">Tickets traités</div>
                </div>
                <div class="stat">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section section-light">
        <div class="container">
            <div class="cta-card">
                <h2 class="cta-title">Prêt à Révolutionner Votre Gestion ?</h2>
                <p class="cta-subtitle">
                    Rejoignez les centaines d'entreprises qui transforment leur expérience client avec l'intelligence artificielle.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('companies.index') }}" class="btn btn-cta btn-cta-white">
                        <i data-lucide="rocket" style="width: 20px; height: 20px;"></i>
                        Commencer Gratuitement
                    </a>
<a href="mailto:contact@smartqueue.ai" class="btn btn-cta btn-cta-outline">
                        <i data-lucide="phone" style="width: 20px; height: 20px;"></i>
                        Contacter les ventes
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>SmartQueue AI</h3>
                    <p style="color: #a0aec0; line-height: 1.6;">
                        La plateforme IA qui réinvente la gestion des files d'attente pour les entreprises modernes.
                    </p>
                </div>
                
                <div class="footer-column">
                    <h3>Produit</h3>
                    <ul>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="#how-it-works">Comment ça marche</a></li>
                        <li><a href="#features">Tarifs</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Entreprise</h3>
                    <ul>
                        <li><a href="#features">À propos</a></li>
                        <li><a href="#testimonials">Carrières</a></li>
                        <li><a href="#features">Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#how-it-works">Aide</a></li>
                        <li><a href="mailto:contact@smartqueue.ai">Contact</a></li>
                        <li><a href="#features">Statut</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p> 2024 SmartQueue AI. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                
                // Skip empty or invalid anchors
                if (!href || href === '#') {
                    return;
                }
                
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
