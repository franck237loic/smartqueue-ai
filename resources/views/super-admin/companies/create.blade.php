@extends('layouts.super-admin')

@section('title', 'Super Admin - Nouvelle Entreprise')

@section('content')
<div class="create-container">
    <!-- Header Section -->
    <div class="create-header">
        <div class="header-left">
            <a href="{{ route('super_admin.companies') }}" class="back-btn">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="header-info">
                <h1 class="page-title">Nouvelle Entreprise</h1>
                <p class="page-subtitle">Créer une entreprise et son administrateur</p>
            </div>
        </div>
        <div class="header-right">
            <div class="creation-icon">
                <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
            </div>
        </div>
    </div>

    <form action="{{ route('super_admin.companies.store') }}" method="POST" class="create-form">
        @csrf

        <!-- Company Information Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon company">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h2 class="section-title">Informations Entreprise</h2>
            </div>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Nom de l'entreprise *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="form-input @error('name') error @enderror" placeholder="Ex: SmartQueue AI">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Slug (optionnel)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="nom-entreprise"
                        class="form-input @error('slug') error @enderror">
                    @error('slug')<span class="form-error">{{ $message }}</span>@enderror
                    <small class="form-help">Utilisé dans les URLs. Si vide, sera généré automatiquement.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspendue</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@entreprise.com"
                        class="form-input @error('email') error @enderror">
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+33 1 23 45 67 89"
                        class="form-input">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Adresse</label>
                    <textarea name="address" rows="2" class="form-textarea" placeholder="123 Rue de la République, 75001 Paris, France">{{ old('address') }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Site web</label>
                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://www.entreprise.com"
                        class="form-input @error('website') error @enderror">
                    @error('website')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <!-- Admin Information Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon admin">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="section-title">Administrateur de l'entreprise</h2>
            </div>

            <div class="admin-info-card">
                <div class="admin-info-header">
                    <div class="admin-avatar">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="admin-info-text">
                        <h3>Création automatique</h3>
                        <p>Un administrateur sera créé automatiquement pour gérer cette entreprise</p>
                    </div>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nom complet *</label>
                    <input type="text" name="admin_name" value="{{ old('admin_name') }}" required
                        class="form-input @error('admin_name') error @enderror" placeholder="Jean Dupont">
                    @error('admin_name')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="admin_email" value="{{ old('admin_email') }}" required
                        class="form-input @error('admin_email') error @enderror" placeholder="admin@entreprise.com">
                    @error('admin_email')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Mot de passe</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="admin_password" placeholder="••••••••"
                            class="form-input @error('admin_password') error @enderror">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <svg class="eye-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-off-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('admin_password')<span class="form-error">{{ $message }}</span>@enderror
                    <small class="form-help">Minimum 8 caractères. Si vide, un mot de passe sécurisé sera généré automatiquement.</small>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="form-actions">
            <div class="actions-left">
                <div class="help-info">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tous les champs marqués d'un * sont obligatoires</span>
                </div>
            </div>

            <div class="actions-right">
                <a href="{{ route('super_admin.companies') }}" class="btn-cancel">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Créer l'entreprise
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const input = document.querySelector('input[name="admin_password"]');
    const eyeIcon = document.querySelector('.eye-icon');
    const eyeOffIcon = document.querySelector('.eye-off-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.style.display = 'none';
        eyeOffIcon.style.display = 'block';
    } else {
        input.type = 'password';
        eyeIcon.style.display = 'block';
        eyeOffIcon.style.display = 'none';
    }
}
</script>

<style>
.create-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.create-header {
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

.header-left {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
}

.back-btn {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.header-info {
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

.creation-icon {
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
.create-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-section {
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

.section-icon.company {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.section-icon.admin {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
.form-select,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--gray-50);
    color: var(--dark);
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    background: white;
}

.form-input.error,
.form-select.error,
.form-textarea.error {
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
    margin-top: 0.25rem;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

/* Admin Info Card */
.admin-info-card {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.admin-info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.admin-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.admin-info-text h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--success);
    margin-bottom: 0.25rem;
}

.admin-info-text p {
    color: var(--gray-600);
    font-size: 0.9rem;
}

/* Password Input */
.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray-400);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    color: var(--primary);
    background: rgba(79, 70, 229, 0.1);
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
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .create-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
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
