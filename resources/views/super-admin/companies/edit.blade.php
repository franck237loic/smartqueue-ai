@extends('layouts.super-admin')

@section('title', 'Super Admin - Modifier Entreprise')

@section('content')
<div class="edit-container">
    <!-- Header Section -->
    <div class="edit-header">
        <div class="header-left">
            <a href="{{ route('super_admin.companies') }}" class="back-btn">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="company-info">
                <div class="company-avatar">
                    <span>{{ substr($company->name, 0, 2) }}</span>
                    <div class="status-indicator {{ $company->status === 'active' ? 'active' : ($company->status === 'suspended' ? 'suspended' : 'inactive') }}"></div>
                </div>
                <div>
                    <h1 class="company-name">Modifier {{ $company->name }}</h1>
                    <div class="company-meta">
                        <span class="meta-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            ID: {{ $company->id }}
                        </span>
                        <span class="meta-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Créée le {{ $company->created_at->format('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('super_admin.companies.update', $company) }}" method="POST" class="edit-form">
        @csrf
        @method('PUT')

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
                    <input type="text" name="name" value="{{ old('name', $company->name) }}" required
                        class="form-input @error('name') error @enderror">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $company->slug) }}" required
                        class="form-input @error('slug') error @enderror">
                    @error('slug')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $company->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ old('status', $company->status) === 'suspended' ? 'selected' : '' }}>Suspendue</option>
                        <option value="inactive" {{ old('status', $company->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}"
                        class="form-input @error('email') error @enderror">
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone', $company->phone) }}"
                        class="form-input">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Adresse</label>
                    <textarea name="address" rows="2" class="form-textarea">{{ old('address', $company->address) }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Site web</label>
                    <input type="url" name="website" value="{{ old('website', $company->website) }}"
                        class="form-input @error('website') error @enderror">
                    @error('website')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon stats">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h2 class="section-title">Statistiques</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card users">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $company->users()->count() }}</div>
                        <div class="stat-label">Utilisateurs</div>
                    </div>
                </div>

                <div class="stat-card services">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $company->services()->count() }}</div>
                        <div class="stat-label">Services</div>
                    </div>
                </div>

                <div class="stat-card counters">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $company->counters()->count() }}</div>
                        <div class="stat-label">Guichets</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="form-actions">
            <div class="actions-left">
                <form action="{{ route('super_admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer l'entreprise
                    </button>
                </form>
            </div>

            <div class="actions-right">
                <a href="{{ route('super_admin.companies') }}" class="btn-cancel">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
</div>

<style>
.edit-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.edit-header {
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

.company-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.5rem;
    position: relative;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.status-indicator {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 16px;
    height: 16px;
    border: 3px solid white;
    border-radius: 50%;
}

.status-indicator.active {
    background: var(--success);
}

.status-indicator.suspended {
    background: var(--warning);
}

.status-indicator.inactive {
    background: var(--gray-400);
}

.company-info {
    flex: 1;
}

.company-name {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.company-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Form Styles */
.edit-form {
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

.section-icon.stats {
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

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-card.users .stat-icon {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.stat-card.services .stat-icon {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
}

.stat-card.counters .stat-icon {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-600);
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

.actions-right {
    display: flex;
    gap: 1rem;
}

.btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--error);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
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
    .edit-header {
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
    
    .stats-grid {
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
    
    .btn-danger,
    .btn-cancel,
    .btn-primary {
        flex: 1;
        justify-content: center;
    }
}
</style>
@endsection
