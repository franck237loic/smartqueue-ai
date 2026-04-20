<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SmartQueue AI</title>
    
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
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="login-container">
        <!-- Logo et Titre -->
        <div class="logo">
            <h1>SmartQueue AI</h1>
            <p>Connectez-vous à votre espace de gestion</p>
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <div class="input-icon">
                    <span class="icon">@</span>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required
                        autocomplete="email"
                        autofocus
                        class="form-input"
                        placeholder="exemple@email.com"
                    >
                </div>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-icon">
                    <span class="icon"> *</span>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        autocomplete="current-password"
                        class="form-input"
                        placeholder="Votre mot de passe"
                    >
                    <button 
                        type="button" 
                        id="togglePassword" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-500 hover:text-gray-700"
                        onclick="togglePassword()"
                    >
                        <span id="eyeIcon">oeil</span>
                    </button>
                </div>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rôle -->
            <div class="form-group">
                <label for="role" class="form-label">Rôle</label>
                <div class="relative">
                    <button 
                        type="button" 
                        id="roleDropdown" 
                        class="form-input text-left flex items-center justify-between cursor-pointer"
                        onclick="toggleDropdown()"
                    >
                        <span id="selectedRoleText">
                            @if(old('role'))
                                @if(old('role') === 'super_admin') Super Admin @elseif(old('role') === 'company_admin') Admin Entreprise @elseif(old('role') === 'agent') Agent @endif
                            @else
                                Sélectionnez un rôle
                            @endif
                        </span>
                        <span>?</span>
                    </button>
                    <input type="hidden" id="role" name="role" value="{{ old('role') }}">
                    
                    <div id="roleDropdownMenu" class="hidden dropdown">
                        <div class="dropdown-item" onclick="selectRole('super_admin')">
                            <strong>Super Admin</strong>
                            <div class="text-sm text-gray-500">Accès global au système</div>
                        </div>
                        <div class="dropdown-item" onclick="selectRole('company_admin')">
                            <strong>Admin Entreprise</strong>
                            <div class="text-sm text-gray-500">Gestion d'entreprise</div>
                        </div>
                        <div class="dropdown-item" onclick="selectRole('agent')">
                            <strong>Agent</strong>
                            <div class="text-sm text-gray-500">Service client</div>
                        </div>
                    </div>
                </div>
                @error('role')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton de connexion -->
            <div class="form-group">
                <button 
                    type="submit" 
                    class="btn btn-primary"
                >
                    Se connecter
                </button>
            </div>
        </form>

        <!-- Lien vers la page d'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900 transition">
                Retour à l'accueil
            </a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById('roleDropdownMenu');
            menu.classList.toggle('hidden');
        }

        function selectRole(role) {
            const roleInput = document.getElementById('role');
            const selectedText = document.getElementById('selectedRoleText');
            const menu = document.getElementById('roleDropdownMenu');
            
            roleInput.value = role;
            
            if (role === 'super_admin') {
                selectedText.textContent = 'Super Admin';
            } else if (role === 'company_admin') {
                selectedText.textContent = 'Admin Entreprise';
            } else if (role === 'agent') {
                selectedText.textContent = 'Agent';
            }
            
            menu.classList.add('hidden');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = 'masquer';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = 'oeil';
            }
        }

        // Fermer le dropdown quand on clique ailleurs
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('roleDropdown');
            const menu = document.getElementById('roleDropdownMenu');
            
            if (!dropdown.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
