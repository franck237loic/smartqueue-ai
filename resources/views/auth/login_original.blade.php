<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SmartQueue AI</title>
    
    <!-- Fonts locaux -->
    <style>
        /* Police Inter de secours */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
    
    <!-- CSS Classique et Élégant -->
    <style>
        /* Reset et styles de base */
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        /* Layout */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .w-full { width: 100%; }
        .min-h-screen { min-height: 100vh; }
        
        /* Espacement */
        .p-8 { padding: 2rem; }
        .py-3 { padding: 0.75rem 0; }
        .pl-12 { padding-left: 3rem; }
        .pr-4 { padding-right: 1rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        
        /* Typographie */
        .text-sm { font-size: 0.875rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .text-center { text-align: center; }
        
        /* Couleurs classiques */
        .text-gray-400 { color: #9ca3af; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-900 { color: #111827; }
        .text-white { color: #ffffff; }
        .bg-white { background-color: #ffffff; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-blue-500 { background-color: #3b82f6; }
        .bg-blue-600 { background-color: #2563eb; }
        
        /* Bordures et ombres classiques */
        .border { border: 1px solid #e5e7eb; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .shadow { box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .shadow-md { box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        
        /* Positionnement */
        .relative { position: relative; }
        .absolute { position: absolute; }
        .inset-y-0 { top: 0; bottom: 0; }
        .left-0 { left: 0; }
        .right-0 { right: 0; }
        .hidden { display: none; }
        .z-10 { z-index: 10; }
        .z-50 { z-index: 50; }
        
        /* Interactions */
        .cursor-pointer { cursor: pointer; }
        .outline-none { outline: none; }
        .pointer-events-none { pointer-events: none; }
        
        /* Transitions */
        .transition { transition: all 0.2s ease; }
        .hover\:bg-gray-50:hover { background-color: #f9fafb; }
        .hover\:text-gray-700:hover { color: #374151; }
        .focus\:border-blue-500:focus { border-color: #3b82f6; }
        .focus\:ring:focus { box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2); }
        
        /* Formulaire classique */
        .login-container {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            outline: none;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border: 1px solid transparent;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-primary:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        
        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            margin-top: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background-color 0.15s ease;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .dropdown-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-item:hover {
            background-color: #f9fafb;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .success-message {
            color: #059669;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        
        .logo p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0.25rem 0 0 0;
        }
        
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        
        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon .form-input {
            padding-left: 2.5rem;
        }
        
        .input-icon .icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            pointer-events: none;
        }
    </style>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Shapes -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full mix-blend-overlay filter blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-300/20 rounded-full mix-blend-overlay filter blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300/10 rounded-full mix-blend-overlay filter blur-3xl animate-pulse-slow"></div>
        
        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    </div>
    
    <!-- Login Card -->
    <div class="w-full max-w-md relative z-10">
        <div class="glass-card rounded-3xl shadow-2xl p-8 relative overflow-hidden">
            <!-- Decorative Line -->

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
                            placeholder="••••••••"
                        >
                        <button 
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition"
                        >
                            <i data-lucide="eye" class="w-5 h-5" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Company Selection -->
                <div class="group" id="company-selection">
                    <label for="company_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Entreprise
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="building" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <select 
                            id="company_id" 
                            name="company_id" 
                            autocomplete="organization"
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all input-focus appearance-none"
                        >
                            <option value="">Sélectionnez une entreprise</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400"></i>
                        </div>
                    </div>
                    @error('company_id')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Info Super Admin -->
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i data-lucide="shield-check" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Super Admin ?</p>
                            <p>En tant que Super Admin, vous n'avez pas besoin de sélectionner une entreprise. Connectez-vous simplement pour accéder au dashboard global.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="ml-2 text-gray-600">Se souvenir de moi</span>
                    </label>
                    <a href="#" class="text-primary-600 font-medium hover:text-primary-700 transition">
                        Mot de passe oublié ?
                    </a>
                </div>
                
                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 rounded-xl gradient-bg text-white font-semibold shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 group"
                >
                    <span>Se connecter</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">ou</span>
                </div>
            </div>
            
            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition">
                        Créer un compte
                    </a>
                </p>
            </div>
            
            <!-- Back to Home -->
            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition group">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-white/70">
            {{ date('Y') }} SmartQueue AI - Tous droits réservés
        </p>
    </div>
    
    <!-- Initialize Icons -->
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            createIcons();
        }

        // Fonctions pour le dropdown personnalisé des rôles
        function toggleRoleDropdown() {
            const dropdown = document.getElementById('role-dropdown');
            const display = document.getElementById('role-display');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                display.classList.add('ring-2', 'ring-primary-500', 'ring-offset-2');
            } else {
                dropdown.classList.add('hidden');
                display.classList.remove('ring-2', 'ring-primary-500', 'ring-offset-2');
            }
        }

        function selectRole(value, text) {
            const hiddenInput = document.getElementById('role');
            const displayText = document.getElementById('role-text');
            const dropdown = document.getElementById('role-dropdown');
            const display = document.getElementById('role-display');
            
            // Mettre à jour les valeurs
            hiddenInput.value = value;
            displayText.textContent = text;
            displayText.classList.remove('text-gray-400');
            displayText.classList.add('text-gray-900');
            
            // Fermer le dropdown
            dropdown.classList.add('hidden');
            display.classList.remove('ring-2', 'ring-primary-500', 'ring-offset-2');
            
            // Déclencher l'événement change pour la logique de masquage d'entreprise
            const event = new Event('change', { bubbles: true });
            hiddenInput.dispatchEvent(event);
            
            // Recréer les icônes locales
            createIcons();
        }

        // Fermer le dropdown si on clique ailleurs
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('role-dropdown');
            const display = document.getElementById('role-display');
            
            if (!display.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
                display.classList.remove('ring-2', 'ring-primary-500', 'ring-offset-2');
            }
        });

        // Hide company selection for Super Admin
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const roleSelect = document.getElementById('role');
            const companySelection = document.getElementById('company-selection');
            
            if (emailInput && roleSelect && companySelection) {
                // Function to toggle company selection based on role
                function toggleCompanySelection() {
                    const selectedRole = roleSelect.value;
                    
                    if (selectedRole === 'super_admin') {
                        companySelection.style.display = 'none';
                    } else {
                        companySelection.style.display = 'block';
                    }
                }
                
                // Event listeners
                roleSelect.addEventListener('change', toggleCompanySelection);
                
                // Mettre à jour le dropdown personnalisé quand l'email change
                emailInput.addEventListener('blur', function() {
                    const email = this.value.toLowerCase();
                    if (email === 'admin@smartqueue.ai') {
                        // Sélectionner automatiquement Super Admin
                        selectRole('super_admin', 'Super Admin');
                        // Désactiver le dropdown
                        document.getElementById('role-display').style.pointerEvents = 'none';
                        document.getElementById('role-display').style.opacity = '0.6';
                    } else {
                        // Réactiver le dropdown
                        document.getElementById('role-display').style.pointerEvents = 'auto';
                        document.getElementById('role-display').style.opacity = '1';
                    }
                    toggleCompanySelection();
                });
                
                                
                // Check on page load
                const email = emailInput.value.toLowerCase();
                if (email === 'admin@smartqueue.ai') {
                    roleSelect.value = 'super_admin';
                    roleSelect.disabled = true;
                }
                
                toggleCompanySelection();
            }
        });
    </script>
</body>
</html>
