@extends('layouts.enterprise-layout')

@section('title', 'Créer un Agent')

@section('content')
<style>
/* Agent Create Styles */
.agent-create-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb a:hover {
    color: #2563eb;
}

.breadcrumb-separator {
    color: #d1d5db;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.page-description {
    color: #6b7280;
    font-size: 1rem;
}

.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.section-icon {
    width: 40px;
    height: 40px;
    background: #3b82f6;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.section-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin: 0.25rem 0 0 0;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-label .required {
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-input,
.form-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: white;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input.error {
    border-color: #ef4444;
}

.form-help {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.form-error {
    font-size: 0.75rem;
    color: #ef4444;
    margin-top: 0.25rem;
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.75rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: #374151;
    transition: color 0.2s;
}

.checkbox-label:hover {
    color: #3b82f6;
}

.checkbox-input {
    width: 16px;
    height: 16px;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    accent-color: #3b82f6;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    border: none;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 2px solid #e5e7eb;
}

.btn-secondary:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
}

.work-schedule {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.schedule-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.time-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .time-grid {
        grid-template-columns: 1fr;
    }
    
    .checkbox-group {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}
</style>

<div class="agent-create-container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('company.admin.agents', $company) }}">Agents</a>
        <span class="breadcrumb-separator">/</span>
        <span>Créer un agent</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header fade-in-up">
        <h1 class="page-title">Créer un Nouvel Agent</h1>
        <p class="page-description">Ajoutez un nouvel agent à votre équipe avec ses informations et horaires de travail</p>
    </div>

    <form action="{{ route('company.admin.agents.store', $company) }}" method="POST">
        @csrf
        
        <!-- Personal Information Section -->
        <div class="form-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-lucide="user" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Informations Personnelles</h2>
                        <p class="section-description">Données de base de l'agent</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Nom Complet<span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               class="form-input"
                               placeholder="Entrez le nom complet">
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Email Professionnel<span class="required">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               class="form-input"
                               placeholder="email@exemple.com">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Mot de Passe<span class="required">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               required 
                               minlength="8"
                               class="form-input"
                               placeholder="Minimum 8 caractères">
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        <span class="form-help">Le mot de passe doit contenir au moins 8 caractères</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Téléphone
                        </label>
                        <input type="tel" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="form-input"
                               placeholder="+237 6XX XXX XXX">
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Assignment Section -->
        <div class="form-card fade-in-up" style="animation-delay: 0.2s;">
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon" style="background: #8b5cf6;">
                        <i data-lucide="shield" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Rôle et Assignation</h2>
                        <p class="section-description">Définissez le rôle et le service de l'agent</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Rôle<span class="required">*</span>
                        </label>
                        <select name="role" required class="form-select">
                            <option value="">Sélectionner un rôle</option>
                            <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>
                                Agent
                            </option>
                            <option value="company_admin" {{ old('role') == 'company_admin' ? 'selected' : '' }}>
                                Administrateur
                            </option>
                        </select>
                        @error('role')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Guichet Assigné
                        </label>
                        <select name="counter_id" class="form-select">
                            <option value="">Non assigné</option>
                            @foreach($counters as $counter)
                                <option value="{{ $counter->id }}" {{ old('counter_id') == $counter->id ? 'selected' : '' }}>
                                    {{ $counter->name }}
                                    @if($counter->service) ({{ $counter->service->name }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <span class="form-help">L'agent ne verra que les tickets de son service</span>
                        @error('counter_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Work Schedule Section -->
        <div class="form-card fade-in-up" style="animation-delay: 0.3s;">
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon" style="background: #10b981;">
                        <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Horaires de Travail</h2>
                        <p class="section-description">Définissez les horaires et jours de travail</p>
                    </div>
                </div>

                <!-- Morning Schedule -->
                <div class="work-schedule">
                    <h3 class="schedule-title">Horaires du Matin</h3>
                    <div class="time-grid">
                        <div class="form-group">
                            <label class="form-label">Heure de Début</label>
                            <input type="time" 
                                   name="heure_debut_matin" 
                                   value="07:00" 
                                   required
                                   class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Heure de Fin (Pause)</label>
                            <input type="time" 
                                   name="heure_fin_matin" 
                                   value="12:00" 
                                   required
                                   class="form-input">
                        </div>
                    </div>
                </div>

                <!-- Afternoon Schedule -->
                <div class="work-schedule">
                    <h3 class="schedule-title">Horaires de l'Après-midi</h3>
                    <div class="time-grid">
                        <div class="form-group">
                            <label class="form-label">Heure de Début (Reprise)</label>
                            <input type="time" 
                                   name="heure_debut_apres_midi" 
                                   value="14:00" 
                                   required
                                   class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Heure de Fin (Journée)</label>
                            <input type="time" 
                                   name="heure_fin_apres_midi" 
                                   value="17:30" 
                                   required
                                   class="form-input">
                        </div>
                    </div>
                </div>

                <!-- Work Days -->
                <div class="work-schedule">
                    <h3 class="schedule-title">Jours de Travail</h3>
                    <div class="checkbox-group">
                        @foreach(['1' => 'Lundi', '2' => 'Mardi', '3' => 'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche'] as $day => $name)
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="jours_travail[]" 
                                       value="{{ $day }}" 
                                       {{ $day <= 5 ? 'checked' : '' }}
                                       class="checkbox-input">
                                <span>{{ $name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <span class="form-help">Cochez les jours de travail de cet agent</span>
                </div>

                <!-- Timezone -->
                <div class="work-schedule">
                    <h3 class="schedule-title">Fuseau Horaire</h3>
                    <div class="form-group">
                        <select name="timezone" required class="form-select">
                            <option value="Africa/Douala" selected>Africa/Douala (Cameroun)</option>
                            <option value="Europe/Paris">Europe/Paris</option>
                            <option value="Europe/London">Europe/London</option>
                            <option value="Europe/Berlin">Europe/Berlin</option>
                            <option value="Europe/Madrid">Europe/Madrid</option>
                            <option value="Europe/Rome">Europe/Rome</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="America/Los_Angeles">America/Los_Angeles</option>
                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-card fade-in-up" style="animation-delay: 0.4s;">
            <div class="form-actions">
                <a href="{{ route('company.admin.agents', $company) }}" class="btn btn-secondary">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
                    Créer l'Agent
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Form validation
    const form = document.querySelector('form');
    const passwordInput = document.querySelector('input[name="password"]');
    const emailInput = document.querySelector('input[name="email"]');
    
    // Real-time validation
    passwordInput.addEventListener('input', function() {
        if (this.value.length < 8) {
            this.classList.add('error');
        } else {
            this.classList.remove('error');
        }
    });
    
    emailInput.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.value) && this.value !== '') {
            this.classList.add('error');
        } else {
            this.classList.remove('error');
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate required fields
        const requiredInputs = form.querySelectorAll('[required]');
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('error');
                isValid = false;
            } else {
                input.classList.remove('error');
            }
        });
        
        // Validate password length
        if (passwordInput.value.length < 8) {
            passwordInput.classList.add('error');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            showToast('Veuillez corriger les erreurs dans le formulaire', 'error');
        }
    });
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: ${type === 'error' ? '#ef4444' : '#10b981'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Add slide animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
