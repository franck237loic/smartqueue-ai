
<script>
if (typeof window.tailwind === 'undefined') {
    window.tailwind = { colors: { blue: { 500: '#3b82f6' }, white: '#ffffff', gray: { 500: '#6b7280' } } };
}
</script>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centre d'Appels - {{ $company->name }} | SmartQueue AI</title>
    
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
            
            /* Status Colors */
            --status-waiting: #f59e0b;
            --status-called: #3b82f6;
            --status-serving: #8b5cf6;
            --status-served: #10b981;
            --status-missed: #ef4444;
            --status-cancelled: #6b7280;
            
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
        
        /* Status Colors */
        .status-waiting { color: var(--status-waiting); background: rgba(245, 158, 11, 0.1); }
        .status-called { color: var(--status-called); background: rgba(59, 130, 246, 0.1); }
        .status-serving { color: var(--status-serving); background: rgba(139, 92, 246, 0.1); }
        .status-served { color: var(--status-served); background: rgba(16, 185, 129, 0.1); }
        .status-missed { color: var(--status-missed); background: rgba(239, 68, 68, 0.1); }
        .status-cancelled { color: var(--status-cancelled); background: rgba(107, 114, 128, 0.1); }
        
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
        
        .btn-success {
            background: var(--emerald);
            color: white;
            box-shadow: var(--shadow-lg);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-danger {
            background: var(--ruby);
            color: white;
            box-shadow: var(--shadow-lg);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
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
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-lg {
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all var(--transition-base);
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gunmetal);
        }
        
        /* Call Center Layout */
        .call-center {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 2rem;
            height: calc(100vh - 200px);
        }
        
        /* Queue Panel */
        .queue-panel {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(212, 175, 55, 0.1);
            overflow-y: auto;
        }
        
        .queue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.1);
        }
        
        .queue-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gunmetal);
        }
        
        .queue-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .queue-stat {
            text-align: center;
            flex: 1;
        }
        
        .queue-stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-gold);
        }
        
        .queue-stat-label {
            font-size: 0.75rem;
            color: var(--charcoal);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        /* Ticket List */
        .ticket-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .ticket-item {
            background: var(--ivory);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all var(--transition-base);
            position: relative;
        }
        
        .ticket-item:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .ticket-item.called {
            background: rgba(59, 130, 246, 0.1);
            border-color: var(--status-called);
        }
        
        .ticket-item.serving {
            background: rgba(139, 92, 246, 0.1);
            border-color: var(--status-serving);
        }
        
        .ticket-number {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gunmetal);
            font-family: var(--font-mono);
        }
        
        .ticket-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }
        
        .ticket-service {
            font-size: 0.875rem;
            color: var(--charcoal);
        }
        
        .ticket-wait-time {
            font-size: 0.75rem;
            color: var(--charcoal);
        }
        
        .ticket-status {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .ticket-status.waiting { background: var(--status-waiting); }
        .ticket-status.called { background: var(--status-called); }
        .ticket-status.serving { background: var(--status-serving); }
        .ticket-status.served { background: var(--status-served); }
        .ticket-status.missed { background: var(--status-missed); }
        
        /* Main Display */
        .main-display {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(212, 175, 55, 0.1);
            display: flex;
            flex-direction: column;
        }
        
        .current-ticket {
            text-align: center;
            padding: 3rem;
            background: var(--gradient-secondary);
            border-radius: 16px;
            margin-bottom: 2rem;
        }
        
        .current-number {
            font-size: 6rem;
            font-weight: 900;
            color: var(--primary-gold);
            font-family: var(--font-mono);
            margin-bottom: 1rem;
            line-height: 1;
        }
        
        .current-service {
            font-size: 1.5rem;
            color: var(--gunmetal);
            margin-bottom: 0.5rem;
        }
        
        .current-counter {
            font-size: 1.125rem;
            color: var(--charcoal);
        }
        
        /* Call Controls */
        .call-controls {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .call-btn {
            padding: 1.5rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-base);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .call-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .call-btn.call {
            background: var(--gradient-primary);
            color: white;
        }
        
        .call-btn.serve {
            background: var(--emerald);
            color: white;
        }
        
        .call-btn.miss {
            background: var(--ruby);
            color: white;
        }
        
        .call-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        .call-btn-icon {
            width: 24px;
            height: 24px;
        }
        
        /* Action Panel */
        .action-panel {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .action-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gunmetal);
            margin-bottom: 1.5rem;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        /* Voice Settings */
        .voice-settings {
            background: var(--ivory);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .voice-title {
            font-weight: 600;
            color: var(--gunmetal);
            margin-bottom: 0.75rem;
        }
        
        .voice-controls {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .voice-control {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .voice-label {
            font-size: 0.875rem;
            color: var(--charcoal);
        }
        
        .toggle {
            position: relative;
            width: 48px;
            height: 24px;
            background: var(--gunmetal);
            border-radius: 24px;
            cursor: pointer;
            transition: all var(--transition-base);
        }
        
        .toggle.active {
            background: var(--primary-gold);
        }
        
        .toggle::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: all var(--transition-base);
        }
        
        .toggle.active::after {
            left: 26px;
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
        
        @keyframes blink {
            0%, 50% {
                opacity: 1;
            }
            51%, 100% {
                opacity: 0.3;
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
        
        .animate-blink {
            animation: blink 1s infinite;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .call-center {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .queue-panel,
            .action-panel {
                max-height: 400px;
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
                    <a href="#" class="nav-link">
                        Centre d'Appels
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-primary">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gunmetal mb-2">Centre d'Appels</h1>
                <p class="text-charcoal">{{ $company->name }} - Gestion des Files d'Attente</p>
            </div>
            
            <!-- Call Center Layout -->
            <div class="call-center">
                <!-- Queue Panel -->
                <div class="queue-panel">
                    <div class="queue-header">
                        <h3 class="queue-title">File d'Attente</h3>
                        <span class="status-waiting px-3 py-1 rounded-full text-sm font-medium">
                            {{ $waitingTickets ?? 12 }} en attente
                        </span>
                    </div>
                    
                    <div class="queue-stats">
                        <div class="queue-stat">
                            <div class="queue-stat-value">{{ $waitingTickets ?? 12 }}</div>
                            <div class="queue-stat-label">En attente</div>
                        </div>
                        <div class="queue-stat">
                            <div class="queue-stat-value">{{ $servingTickets ?? 3 }}</div>
                            <div class="queue-stat-label">En service</div>
                        </div>
                        <div class="queue-stat">
                            <div class="queue-stat-value">{{ $servedTickets ?? 45 }}</div>
                            <div class="queue-stat-label">Servis</div>
                        </div>
                    </div>
                    
                    <div class="ticket-list" id="ticketList">
                        @php
                        // Simuler des tickets pour démonstration
                        $tickets = [
                            ['number' => 'A001', 'service' => 'Service Général', 'wait_time' => '5 min', 'status' => 'waiting'],
                            ['number' => 'A002', 'service' => 'Service Prioritaire', 'wait_time' => '8 min', 'status' => 'waiting'],
                            ['number' => 'A003', 'service' => 'Rendez-vous', 'wait_time' => '12 min', 'status' => 'waiting'],
                            ['number' => 'A004', 'service' => 'Information', 'wait_time' => '15 min', 'status' => 'called'],
                            ['number' => 'A005', 'service' => 'Paiement', 'wait_time' => '18 min', 'status' => 'waiting'],
                        ];
                        @endphp
                        
                        @foreach($tickets as $ticket)
                        <div class="ticket-item {{ $ticket['status'] }}" data-ticket="{{ $ticket['number'] }}">
                            <div class="ticket-status {{ $ticket['status'] }}"></div>
                            <div class="ticket-number">{{ $ticket['number'] }}</div>
                            <div class="ticket-info">
                                <span class="ticket-service">{{ $ticket['service'] }}</span>
                                <span class="ticket-wait-time">{{ $ticket['wait_time'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Main Display -->
                <div class="main-display">
                    <div class="current-ticket">
                        <div class="current-number animate-pulse" id="currentTicket">A001</div>
                        <div class="current-service" id="currentService">Service Général</div>
                        <div class="current-counter">Guichet: 3</div>
                    </div>
                    
                    <div class="call-controls">
                        <button class="call-btn call" id="callBtn">
                            <svg class="call-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v13a3 3 0 01-3 3H6a3 3 0 01-3-3V5a3 3 0 013-3h6a3 3 0 013 3z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                            </svg>
                            Appeler
                        </button>
                        <button class="call-btn serve" id="serveBtn" disabled>
                            <svg class="call-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Servir
                        </button>
                        <button class="call-btn miss" id="missBtn" disabled>
                            <svg class="call-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Absent
                        </button>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informations du Ticket</h3>
                        </div>
                        <div id="ticketInfo">
                            <p><strong>Ticket:</strong> <span id="infoTicketNumber">A001</span></p>
                            <p><strong>Service:</strong> <span id="infoService">Service Général</span></p>
                            <p><strong>Client:</strong> <span id="infoClient">Jean Dupont</span></p>
                            <p><strong>Téléphone:</strong> <span id="infoPhone">+33 1 23 45 67 89</span></p>
                            <p><strong>Temps d'attente:</strong> <span id="infoWaitTime">5 minutes</span></p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Panel -->
                <div class="action-panel">
                    <h3 class="action-header">Actions Rapides</h3>
                    
                    <div class="voice-settings">
                        <h4 class="voice-title">Paramètres Vocaux</h4>
                        <div class="voice-controls">
                            <div class="voice-control">
                                <span class="voice-label">Annonces automatiques</span>
                                <div class="toggle active" id="autoAnnounce"></div>
                            </div>
                            <div class="voice-control">
                                <span class="voice-label">Volume</span>
                                <input type="range" min="0" max="100" value="75" class="w-24">
                            </div>
                            <div class="voice-control">
                                <span class="voice-label">Vitesse</span>
                                <input type="range" min="0" max="100" value="50" class="w-24">
                            </div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Transférer
                        </button>
                        <button class="btn btn-secondary btn-sm">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mettre en pause
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Annuler
                        </button>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Statistiques du Jour</h4>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Tickets traités:</span>
                                <strong>{{ $processedTickets ?? 45 }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span>Temps moyen:</span>
                                <strong>{{ $avgTime ?? 8.5 }} min</strong>
                            </div>
                            <div class="flex justify-between">
                                <span>Taux de satisfaction:</span>
                                <strong>{{ $satisfaction ?? 92 }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Call Center Management System
        class CallCenter {
            constructor() {
                this.currentTicket = null;
                this.isCalling = false;
                this.isServing = false;
                this.tickets = this.loadTickets();
                this.settings = {
                    autoAnnounce: true,
                    volume: 75,
                    speed: 50
                };
                
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.startAutoUpdate();
                this.initVoiceSettings();
            }
            
            bindEvents() {
                // Call button
                document.getElementById('callBtn').addEventListener('click', () => {
                    this.callNextTicket();
                });
                
                // Serve button
                document.getElementById('serveBtn').addEventListener('click', () => {
                    this.serveCurrentTicket();
                });
                
                // Miss button
                document.getElementById('missBtn').addEventListener('click', () => {
                    this.markAsMissed();
                });
                
                // Ticket selection
                document.querySelectorAll('.ticket-item').forEach(item => {
                    item.addEventListener('click', () => {
                        this.selectTicket(item);
                    });
                });
                
                // Voice settings
                document.getElementById('autoAnnounce').addEventListener('click', (e) => {
                    e.target.classList.toggle('active');
                    this.settings.autoAnnounce = e.target.classList.contains('active');
                });
            }
            
            loadTickets() {
                // Simuler le chargement des tickets depuis la base de données
                return [
                    { id: 1, number: 'A001', service: 'Service Général', client: 'Jean Dupont', phone: '+33 1 23 45 67 89', waitTime: 5, status: 'waiting' },
                    { id: 2, number: 'A002', service: 'Service Prioritaire', client: 'Marie Martin', phone: '+33 1 23 45 67 90', waitTime: 8, status: 'waiting' },
                    { id: 3, number: 'A003', service: 'Rendez-vous', client: 'Pierre Bernard', phone: '+33 1 23 45 67 91', waitTime: 12, status: 'waiting' },
                    { id: 4, number: 'A004', service: 'Information', client: 'Sophie Petit', phone: '+33 1 23 45 67 92', waitTime: 15, status: 'called' },
                    { id: 5, number: 'A005', service: 'Paiement', client: 'Lucas Dubois', phone: '+33 1 23 45 67 93', waitTime: 18, status: 'waiting' }
                ];
            }
            
            callNextTicket() {
                if (this.isCalling || this.isServing) return;
                
                const nextTicket = this.tickets.find(t => t.status === 'waiting');
                if (!nextTicket) {
                    this.showNotification('Aucun ticket en attente', 'warning');
                    return;
                }
                
                this.currentTicket = nextTicket;
                this.isCalling = true;
                
                // Update UI
                this.updateCurrentTicketDisplay(nextTicket);
                this.updateTicketStatus(nextTicket.id, 'called');
                this.enableCallControls();
                
                // Voice announcement
                if (this.settings.autoAnnounce) {
                    this.announceTicket(nextTicket);
                }
                
                this.showNotification(`Ticket ${nextTicket.number} appelé`, 'success');
            }
            
            serveCurrentTicket() {
                if (!this.currentTicket || !this.isCalling) return;
                
                this.isCalling = false;
                this.isServing = true;
                
                // Update ticket status
                this.updateTicketStatus(this.currentTicket.id, 'serving');
                
                // Update UI
                document.getElementById('callBtn').disabled = true;
                document.getElementById('serveBtn').disabled = true;
                document.getElementById('missBtn').disabled = false;
                
                this.showNotification(`Ticket ${this.currentTicket.number} en service`, 'info');
                
                // Auto complete after 2 minutes (simulation)
                setTimeout(() => {
                    this.completeService();
                }, 120000);
            }
            
            markAsMissed() {
                if (!this.currentTicket) return;
                
                // Update ticket status
                this.updateTicketStatus(this.currentTicket.id, 'missed');
                
                // Reset state
                this.resetState();
                
                this.showNotification(`Ticket ${this.currentTicket.number} marqué comme absent`, 'warning');
                
                // Auto call next ticket after 5 seconds
                setTimeout(() => {
                    this.callNextTicket();
                }, 5000);
            }
            
            completeService() {
                if (!this.currentTicket) return;
                
                // Update ticket status
                this.updateTicketStatus(this.currentTicket.id, 'served');
                
                // Reset state
                this.resetState();
                
                this.showNotification(`Ticket ${this.currentTicket.number} servi`, 'success');
                
                // Auto call next ticket
                setTimeout(() => {
                    this.callNextTicket();
                }, 3000);
            }
            
            selectTicket(ticketElement) {
                const ticketNumber = ticketElement.dataset.ticket;
                const ticket = this.tickets.find(t => t.number === ticketNumber);
                
                if (ticket) {
                    this.updateCurrentTicketDisplay(ticket);
                    this.highlightTicket(ticketElement);
                }
            }
            
            updateCurrentTicketDisplay(ticket) {
                document.getElementById('currentTicket').textContent = ticket.number;
                document.getElementById('currentService').textContent = ticket.service;
                document.getElementById('infoTicketNumber').textContent = ticket.number;
                document.getElementById('infoService').textContent = ticket.service;
                document.getElementById('infoClient').textContent = ticket.client;
                document.getElementById('infoPhone').textContent = ticket.phone;
                document.getElementById('infoWaitTime').textContent = `${ticket.waitTime} minutes`;
            }
            
            updateTicketStatus(ticketId, status) {
                const ticket = this.tickets.find(t => t.id === ticketId);
                if (ticket) {
                    ticket.status = status;
                    this.refreshTicketList();
                }
            }
            
            refreshTicketList() {
                const ticketList = document.getElementById('ticketList');
                ticketList.innerHTML = '';
                
                this.tickets.forEach(ticket => {
                    const ticketElement = this.createTicketElement(ticket);
                    ticketList.appendChild(ticketElement);
                });
            }
            
            createTicketElement(ticket) {
                const div = document.createElement('div');
                div.className = `ticket-item ${ticket.status}`;
                div.dataset.ticket = ticket.number;
                
                div.innerHTML = `
                    <div class="ticket-status ${ticket.status}"></div>
                    <div class="ticket-number">${ticket.number}</div>
                    <div class="ticket-info">
                        <span class="ticket-service">${ticket.service}</span>
                        <span class="ticket-wait-time">${ticket.waitTime} min</span>
                    </div>
                `;
                
                div.addEventListener('click', () => {
                    this.selectTicket(div);
                });
                
                return div;
            }
            
            enableCallControls() {
                document.getElementById('callBtn').disabled = true;
                document.getElementById('serveBtn').disabled = false;
                document.getElementById('missBtn').disabled = false;
            }
            
            resetState() {
                this.currentTicket = null;
                this.isCalling = false;
                this.isServing = false;
                
                document.getElementById('callBtn').disabled = false;
                document.getElementById('serveBtn').disabled = true;
                document.getElementById('missBtn').disabled = true;
            }
            
            highlightTicket(element) {
                document.querySelectorAll('.ticket-item').forEach(item => {
                    item.style.background = '';
                });
                element.style.background = 'rgba(212, 175, 55, 0.1)';
            }
            
            announceTicket(ticket) {
                // Simuler une annonce vocale
                const message = `Ticket numéro ${ticket.number}, service ${ticket.service}, veuillez vous présenter au guichet`;
                console.log('Annonce vocale:', message);
                
                // Integration avec Web Speech API si disponible
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance(message);
                    utterance.lang = 'fr-FR';
                    utterance.rate = this.settings.speed / 50;
                    utterance.volume = this.settings.volume / 100;
                    speechSynthesis.speak(utterance);
                }
            }
            
            initVoiceSettings() {
                // Initialiser les contrôles vocaux
                const volumeSlider = document.querySelector('input[type="range"]');
                const speedSlider = document.querySelectorAll('input[type="range"]')[1];
                
                volumeSlider.addEventListener('input', (e) => {
                    this.settings.volume = e.target.value;
                });
                
                speedSlider.addEventListener('input', (e) => {
                    this.settings.speed = e.target.value;
                });
            }
            
            showNotification(message, type = 'info') {
                // Créer une notification
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    color: white;
                    font-weight: 500;
                    z-index: 1000;
                    animation: slideIn 0.3s ease-out;
                `;
                
                // Couleurs selon le type
                const colors = {
                    success: '#10b981',
                    warning: '#f59e0b',
                    error: '#ef4444',
                    info: '#3b82f6'
                };
                notification.style.background = colors[type] || colors.info;
                
                document.body.appendChild(notification);
                
                // Auto-suppression après 3 secondes
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
            
            startAutoUpdate() {
                // Mettre à jour l'interface toutes les 30 secondes
                setInterval(() => {
                    this.refreshTicketList();
                    this.updateStats();
                }, 30000);
            }
            
            updateStats() {
                // Mettre à jour les statistiques
                const waiting = this.tickets.filter(t => t.status === 'waiting').length;
                const serving = this.tickets.filter(t => t.status === 'serving').length;
                const served = this.tickets.filter(t => t.status === 'served').length;
                
                document.querySelector('.queue-stat-value').textContent = waiting;
                document.querySelectorAll('.queue-stat-value')[1].textContent = serving;
                document.querySelectorAll('.queue-stat-value')[2].textContent = served;
            }
        }
        
        // Initialiser le centre d'appels
        document.addEventListener('DOMContentLoaded', () => {
            new CallCenter();
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
    </script>
</body>
</html>
