@extends('layouts.super-admin')

@section('title', 'Super Admin - Paramètres')

@section('content')
<div class="settings-container">
    <!-- Header Section -->
    <div class="settings-header">
        <div class="header-content">
            <h1 class="page-title">Paramètres Système</h1>
            <p class="page-subtitle">Configuration générale et préférences</p>
        </div>
        <div class="header-right">
            <div class="settings-icon">
                <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <form action="{{ route('super_admin.settings.update') }}" method="POST" class="settings-form">
        @csrf
        @method('PUT')

        <!-- General Settings -->
        <div class="settings-section">
            <div class="section-header">
                <div class="section-icon general">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="section-title">Paramètres Généraux</h2>
            </div>

            <div class="settings-grid">
                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Nom de l'application</h3>
                        <p class="setting-description">Nom affiché dans l'interface et les emails</p>
                    </div>
                    <div class="setting-control">
                        <input type="text" name="app_name" value="{{ \App\Models\Setting::get('app_name', 'SmartQueue AI') }}" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Email par défaut</h3>
                        <p class="setting-description">Email utilisé pour les notifications système</p>
                    </div>
                    <div class="setting-control">
                        <input type="email" name="default_email" value="{{ \App\Models\Setting::get('default_email', 'noreply@smartqueue.ai') }}" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Fuseau horaire</h3>
                        <p class="setting-description">Fuseau horaire par défaut pour l'application</p>
                    </div>
                    <div class="setting-control">
                        <select name="timezone" class="setting-select">
                            <option value="UTC" {{ \App\Models\Setting::get('timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                            <option value="Europe/Paris" {{ \App\Models\Setting::get('timezone') === 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                            <option value="America/New_York" {{ \App\Models\Setting::get('timezone') === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                            <option value="Asia/Tokyo" {{ \App\Models\Setting::get('timezone') === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                        </select>
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Langue par défaut</h3>
                        <p class="setting-description">Langue utilisée dans l'interface</p>
                    </div>
                    <div class="setting-control">
                        <select name="default_locale" class="setting-select">
                            <option value="fr" {{ \App\Models\Setting::get('default_locale') === 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ \App\Models\Setting::get('default_locale') === 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ \App\Models\Setting::get('default_locale') === 'es' ? 'selected' : '' }}>Español</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue Settings -->
        <div class="settings-section">
            <div class="section-header">
                <div class="section-icon queue">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h2 class="section-title">Paramètres de File d'Attente</h2>
            </div>

            <div class="settings-grid">
                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Temps d'attente maximal</h3>
                        <p class="setting-description">Durée maximale avant expiration d'un ticket (minutes)</p>
                    </div>
                    <div class="setting-control">
                        <input type="number" name="max_wait_time" value="{{ \App\Models\Setting::get('max_wait_time', 30) }}" min="1" max="180" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Temps de service moyen</h3>
                        <p class="setting-description">Temps moyen estimé pour un service (minutes)</p>
                    </div>
                    <div class="setting-control">
                        <input type="number" name="avg_service_time" value="{{ \App\Models\Setting::get('avg_service_time', 5) }}" min="1" max="60" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Limite de tickets par jour</h3>
                        <p class="setting-description">Nombre maximum de tickets par entreprise et par jour</p>
                    </div>
                    <div class="setting-control">
                        <input type="number" name="daily_ticket_limit" value="{{ \App\Models\Setting::get('daily_ticket_limit', 1000) }}" min="10" max="10000" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Notification automatique</h3>
                        <p class="setting-description">Envoyer des notifications automatiques aux clients</p>
                    </div>
                    <div class="setting-control">
                        <label class="toggle-switch">
                            <input type="checkbox" name="auto_notifications" {{ \App\Models\Setting::get('auto_notifications', true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="settings-section">
            <div class="section-header">
                <div class="section-icon security">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M12 15l-2-2m0 0l-2 2m2-2v6m-1 1H8a2 2 0 01-2-2V8a2 2 0 012-2h4a2 2 0 012 2v6m-1 1h2a2 2 0 002-2V8a2 2 0 00-2-2h-4a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="section-title">Paramètres de Sécurité</h2>
            </div>

            <div class="settings-grid">
                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Longueur minimale du mot de passe</h3>
                        <p class="setting-description">Nombre minimum de caractères pour les mots de passe</p>
                    </div>
                    <div class="setting-control">
                        <input type="number" name="min_password_length" value="{{ \App\Models\Setting::get('min_password_length', 8) }}" min="6" max="32" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Expiration de session</h3>
                        <p class="setting-description">Durée avant déconnexion automatique (heures)</p>
                    </div>
                    <div class="setting-control">
                        <select name="session_lifetime" class="setting-select">
                            <option value="1" {{ \App\Models\Setting::get('session_lifetime', 8) == 1 ? 'selected' : '' }}>1 heure</option>
                            <option value="8" {{ \App\Models\Setting::get('session_lifetime', 8) == 8 ? 'selected' : '' }}>8 heures</option>
                            <option value="24" {{ \App\Models\Setting::get('session_lifetime', 8) == 24 ? 'selected' : '' }}>24 heures</option>
                            <option value="168" {{ \App\Models\Setting::get('session_lifetime', 8) == 168 ? 'selected' : '' }}>7 jours</option>
                        </select>
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Authentification à deux facteurs</h3>
                        <p class="setting-description">Activer 2FA pour tous les administrateurs</p>
                    </div>
                    <div class="setting-control">
                        <label class="toggle-switch">
                            <input type="checkbox" name="enable_2fa" {{ \App\Models\Setting::get('enable_2fa', false) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Journal des activités</h3>
                        <p class="setting-description">Enregistrer toutes les activités des administrateurs</p>
                    </div>
                    <div class="setting-control">
                        <label class="toggle-switch">
                            <input type="checkbox" name="enable_activity_log" {{ \App\Models\Setting::get('enable_activity_log', true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="settings-section">
            <div class="section-header">
                <div class="section-icon email">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="section-title">Configuration Email</h2>
            </div>

            <div class="settings-grid">
                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Driver SMTP</h3>
                        <p class="setting-description">Service d'envoi d'emails</p>
                    </div>
                    <div class="setting-control">
                        <select name="mail_driver" class="setting-select">
                            <option value="smtp" {{ \App\Models\Setting::get('mail_driver') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="mail" {{ \App\Models\Setting::get('mail_driver') === 'mail' ? 'selected' : '' }}>PHP Mail</option>
                            <option value="sendmail" {{ \App\Models\Setting::get('mail_driver') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        </select>
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Hôte SMTP</h3>
                        <p class="setting-description">Serveur SMTP pour l'envoi d'emails</p>
                    </div>
                    <div class="setting-control">
                        <input type="text" name="mail_host" value="{{ \App\Models\Setting::get('mail_host', 'smtp.gmail.com') }}" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Port SMTP</h3>
                        <p class="setting-description">Port du serveur SMTP</p>
                    </div>
                    <div class="setting-control">
                        <input type="number" name="mail_port" value="{{ \App\Models\Setting::get('mail_port', 587) }}" min="1" max="65535" class="setting-input">
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h3 class="setting-title">Chiffrement SSL/TLS</h3>
                        <p class="setting-description">Méthode de chiffrement pour les emails</p>
                    </div>
                    <div class="setting-control">
                        <select name="mail_encryption" class="setting-select">
                            <option value="tls" {{ \App\Models\Setting::get('mail_encryption') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ \App\Models\Setting::get('mail_encryption') === 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ !\App\Models\Setting::get('mail_encryption') ? 'selected' : '' }}>Aucun</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <div class="actions-left">
                <div class="help-info">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Les changements seront appliqués immédiatement</span>
                </div>
            </div>

            <div class="actions-right">
                <a href="{{ route('super_admin.dashboard') }}" class="btn-cancel">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Sauvegarder les paramètres
                </button>
            </div>
        </div>
    </form>
</div>

<style>
.settings-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.settings-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
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

.settings-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Form Styles */
.settings-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.settings-section {
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

.section-icon.general {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.section-icon.queue {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
}

.section-icon.security {
    background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
}

.section-icon.email {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 2rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.setting-item:hover {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.setting-info {
    flex: 1;
    min-width: 200px;
}

.setting-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.setting-description {
    font-size: 0.9rem;
    color: var(--gray-600);
    line-height: 1.5;
}

.setting-control {
    flex-shrink: 0;
    min-width: 200px;
}

.setting-input,
.setting-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--dark);
}

.setting-input:focus,
.setting-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
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

/* Actions Section */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
}

.actions-left {
    display: flex;
    gap: 1rem;
}

.help-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-500);
    font-size: 0.9rem;
}

.actions-right {
    display: flex;
    gap: 1rem;
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    transform: translateY(-2px);
}

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

/* Responsive */
@media (max-width: 768px) {
    .settings-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .settings-grid {
        grid-template-columns: 1fr;
    }
    
    .setting-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .setting-control {
        width: 100%;
        min-width: auto;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .actions-left,
    .actions-right {
        width: 100%;
        justify-content: center;
    }
    
    .btn-cancel,
    .btn-primary {
        flex: 1;
        justify-content: center;
    }
}
</style>
@endsection
