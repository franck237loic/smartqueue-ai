@extends('layouts.super-admin')

@section('title', 'Super Admin - Profil')

@section('content')
<div class="profile-container">
    <!-- Header Section -->
    <div class="profile-header">
        <div class="header-content">
            <h1 class="page-title">Mon Profil</h1>
            <p class="page-subtitle">Gérer vos informations personnelles</p>
        </div>
        <div class="header-right">
            <div class="profile-avatar-large">
                <span>{{ substr(auth()->user()->name, 0, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="profile-grid">
        <!-- Informations Personnelles -->
        <div class="profile-section">
            <div class="section-header">
                <div class="section-icon personal">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="section-title">Informations Personnelles</h2>
            </div>

            <form action="{{ route('super_admin.profile.update') }}" method="POST" class="profile-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" required
                            class="form-input @error('name') error @enderror">
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required
                            class="form-input @error('email') error @enderror">
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                            class="form-input @error('phone') error @enderror" placeholder="+33 1 23 45 67 89">
                        @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>

        <!-- Sécurité -->
        <div class="profile-section">
            <div class="section-header">
                <div class="section-icon security">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M12 15l-2-2m0 0l-2 2m2-2v6m-1 1H8a2 2 0 01-2-2V8a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="section-title">Sécurité</h2>
            </div>

            <div class="security-content">
                <div class="security-item">
                    <div class="security-info">
                        <h3 class="security-title">Mot de passe</h3>
                        <p class="security-description">Dernière modification : {{ auth()->user()->password_changed_at ? auth()->user()->password_changed_at->diffForHumans() : 'Jamais' }}</p>
                    </div>
                    <button onclick="showPasswordModal()" class="btn-secondary">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2h2l5.257-5.257A6 6 0 0121 9z"/>
                        </svg>
                        Modifier
                    </button>
                </div>

                <div class="security-item">
                    <div class="security-info">
                        <h3 class="security-title">Authentification à deux facteurs</h3>
                        <p class="security-description">{{ \App\Models\Setting::get('enable_2fa', false) ? 'Activé' : 'Désactivé' }}</p>
                    </div>
                    <div class="security-status {{ \App\Models\Setting::get('enable_2fa', false) ? 'enabled' : 'disabled' }}">
                        <span>{{ \App\Models\Setting::get('enable_2fa', false) ? 'Activé' : 'Désactivé' }}</span>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-info">
                        <h3 class="security-title">Connexion</h3>
                        <p class="security-description">Dernière connexion : {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d/m/Y H:i') : 'Première connexion' }}</p>
                    </div>
                    <div class="session-info">
                        <span class="session-ip">{{ request()->ip() }}</span>
                        <span class="session-browser">{{ request()->userAgent() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Préférences -->
        <div class="profile-section">
            <div class="section-header">
                <div class="section-icon preferences">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="section-title">Préférences</h2>
            </div>

            <div class="preferences-content">
                <div class="preference-item">
                    <div class="preference-info">
                        <h3 class="preference-title">Notifications par email</h3>
                        <p class="preference-description">Recevoir les notifications importantes par email</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" {{ auth()->user()->email_notifications ?? true ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="preference-item">
                    <div class="preference-info">
                        <h3 class="preference-title">Langue</h3>
                        <p class="preference-description">Langue de l'interface</p>
                    </div>
                    <select class="preference-select">
                        <option value="fr" {{ \App\Models\Setting::get('default_locale') === 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="en" {{ \App\Models\Setting::get('default_locale') === 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ \App\Models\Setting::get('default_locale') === 'es' ? 'selected' : '' }}>Español</option>
                    </select>
                </div>

                <div class="preference-item">
                    <div class="preference-info">
                        <h3 class="preference-title">Fuseau horaire</h3>
                        <p class="preference-description">Fuseau horaire pour l'affichage des dates</p>
                    </div>
                    <select class="preference-select">
                        <option value="UTC" {{ \App\Models\Setting::get('timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="Europe/Paris" {{ \App\Models\Setting::get('timezone') === 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                        <option value="America/New_York" {{ \App\Models\Setting::get('timezone') === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                        <option value="Asia/Tokyo" {{ \App\Models\Setting::get('timezone') === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Statistiques du Compte -->
        <div class="profile-section">
            <div class="section-header">
                <div class="section-icon stats">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h2 class="section-title">Statistiques du Compte</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3m-9 8h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ auth()->user()->created_at->diffForHumans() }}</div>
                        <div class="stat-label">Membre depuis</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ \App\Models\Company::count() }}</div>
                        <div class="stat-label">Entreprises gérées</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ auth()->user()->login_count ?? 0 }}</div>
                        <div class="stat-label">Connexions totales</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier le mot de passe -->
<div id="passwordModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Modifier le mot de passe</h3>
            <button onclick="closePasswordModal()" class="modal-close">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('super_admin.profile.password') }}" method="POST" class="modal-form">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Mot de passe actuel</label>
                    <input type="password" name="current_password" required class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="password" required minlength="8" class="form-input">
                    <small class="form-help">Minimum 8 caractères</small>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="password_confirmation" required minlength="8" class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closePasswordModal()" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<script>
function showPasswordModal() {
    document.getElementById('passwordModal').style.display = 'flex';
}

function closePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
}

// Fermer le modal en cliquant à l'extérieur
window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closePasswordModal();
    }
}
</script>

<style>
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 20px;
    color: white;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1rem;
    opacity: 0.9;
}

.header-right {
    display: flex;
    align-items: center;
}

.profile-avatar-large {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 700;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Profile Grid */
.profile-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.profile-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.section-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.section-icon.personal {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.section-icon.security {
    background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
}

.section-icon.preferences {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
}

.section-icon.stats {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

/* Form Styles */
.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
}

.form-input,
.form-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--gray-50);
    color: var(--dark);
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    background: white;
}

.form-input.error {
    border-color: var(--error);
}

.form-error {
    color: var(--error);
    font-size: 0.8rem;
    font-weight: 500;
}

.form-help {
    color: var(--gray-500);
    font-size: 0.8rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

/* Security Section */
.security-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.security-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
}

.security-info {
    flex: 1;
}

.security-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.security-description {
    font-size: 0.9rem;
    color: var(--gray-600);
}

.security-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.security-status.enabled {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.security-status.disabled {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
}

.session-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    text-align: right;
}

.session-ip,
.session-browser {
    font-size: 0.8rem;
    color: var(--gray-500);
    font-family: monospace;
}

/* Preferences Section */
.preferences-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.preference-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
}

.preference-info {
    flex: 1;
}

.preference-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.preference-description {
    font-size: 0.9rem;
    color: var(--gray-600);
}

.preference-select {
    min-width: 150px;
}

/* Toggle Switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--gray-300);
    transition: .4s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background-color: var(--primary);
}

input:checked + .toggle-slider:before {
    transform: translateX(26px);
}

/* Stats Section */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-600);
}

/* Buttons */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--primary);
    border: 2px solid var(--primary);
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: var(--gray-50);
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.modal-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: var(--gray-100);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: var(--gray-200);
}

.modal-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.modal-body {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.modal-footer {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Responsive */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
    }
    
    .security-item,
    .preference-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .session-info {
        text-align: center;
    }
    
    .modal-content {
        margin: 1rem;
        padding: 1.5rem;
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .btn-cancel,
    .btn-primary {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
