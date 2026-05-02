@extends('layouts.modern-sidebar')

@section('title', $counter->name . ' - ' . $company->name)

@section('content')
<div class="modern-counter">
    <!-- Premium Header -->
    <header class="premium-header">
        <div class="header-background">
            <div class="gradient-overlay"></div>
            <div class="pattern-overlay"></div>
        </div>
        <div class="header-container">
            <div class="header-left">
                <div class="counter-identity">
                    <h1 class="counter-name">{{ $counter->name }}</h1>
                    <div class="identity-badges">
                        <span class="company-badge">{{ $company->name }}</span>
                        @if($service)
                            <span class="service-badge">{{ $service->name }}</span>
                        @else
                            <span class="service-badge inactive">Non assigné</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('company.agent.dashboard', $company) }}" class="back-action">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Retour</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="main-layout">
        <!-- Sidebar -->
        <aside class="modern-sidebar">
            <!-- User Profile -->
            <div class="user-profile-card">
                <div class="profile-header">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="profile-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Agent Guichet</div>
                    </div>
                </div>
                <div class="profile-actions">
                    <a href="{{ route('company.agent.dashboard', $company) }}" class="profile-action">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a2 2 0 002 2h10a2 2 0 002-2v-10M14 10l2 2m0 0l2-2m-2-2l-2-2m-2 2l-2-2"/>
                        </svg>
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout.post') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="profile-action logout">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            <!-- Counter Status -->
            <div class="status-card">
                <div class="card-header">
                    <h3>Statut Guichet</h3>
                    <div class="status-indicator {{ $counter->isOpen() ? 'online' : 'offline' }}">
                        <div class="indicator-dot"></div>
                        <span>{{ $counter->isOpen() ? 'Actif' : 'Inactif' }}</span>
                    </div>
                </div>
                
                <div class="status-controls">
                    @if($counter->isOpen())
                        <form method="POST" action="{{ route('company.agent.counter.close', [$company, $counter]) }}" class="control-form">
                            @csrf
                            <button type="submit" class="control-btn close">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Fermer
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('company.agent.counter.pause', [$company, $counter]) }}" class="control-form">
                            @csrf
                            <button type="submit" class="control-btn pause">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pause
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('company.agent.counter.open', [$company, $counter]) }}" class="control-form">
                            @csrf
                            <button type="submit" class="control-btn open">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                Ouvrir
                            </button>
                        </form>
                    @endif
                    
                    @if($counter->isPaused())
                        <form method="POST" action="{{ route('company.agent.counter.resume', [$company, $counter]) }}" class="control-form">
                            @csrf
                            <button type="submit" class="control-btn resume">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Reprendre
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Quick Queue -->
            <div class="quick-queue-card">
                <div class="card-header">
                    <h3>File d'Attente</h3>
                    <div class="queue-badge">{{ $waitingTickets->count() }}</div>
                </div>
                
                <div class="quick-queue-list">
                    @forelse($waitingTickets as $ticket)
                        <div class="quick-queue-item">
                            <div class="ticket-info">
                                <span class="ticket-number">{{ $ticket->number }}</span>
                                @if($ticket->guest_name)
                                    <span class="guest-name">{{ $ticket->guest_name }}</span>
                                @endif
                            </div>
                            <div class="ticket-meta">
                                <span class="wait-time">{{ $ticket->created_at->diffForHumans() }}</span>
                                <button onclick="recallTicket({{ $ticket->id }})" class="recall-btn">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="quick-queue-empty">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Aucun ticket</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Statistics -->
            <div class="stats-card">
                <div class="card-header">
                    <h3>Statistiques</h3>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $servedCount ?? 0 }}</div>
                        <div class="stat-label">Servis</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $missedCount ?? 0 }}</div>
                        <div class="stat-label">Absents</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $avgWaitTime ?? 0 }}m</div>
                        <div class="stat-label">Attente</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Current Ticket -->
            <div class="current-ticket-container">
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="status-indicator {{ $currentTicket ? 'active' : 'idle' }}">
                            <div class="indicator-dot"></div>
                        </div>
                        <div class="header-text">
                            <h2>{{ $currentTicket ? 'Ticket Actuel' : 'Prêt à Servir' }}</h2>
                            @if($currentTicket)
                                <span class="ticket-time">{{ $currentTicket->created_at->format('H:i:s') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="ticket-body">
                        @if($currentTicket)
                            <div class="ticket-display">
                                <div class="ticket-number-wrapper">
                                    <div class="ticket-number-bg">{{ $currentTicket->number }}</div>
                                    <div class="ticket-number">{{ $currentTicket->number }}</div>
                                </div>
                                @if($currentTicket->guest_name)
                                    <div class="guest-display">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ $currentTicket->guest_name }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="ticket-status">
                                @if($currentTicket->isCalled())
                                    <div class="status-item called">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Appelé à {{ $currentTicket->called_at?->format('H:i') }}
                                    </div>
                                @elseif($currentTicket->isPresent())
                                    <div class="status-item present">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Présent à {{ $currentTicket->present_at?->format('H:i') }}
                                    </div>
                                @elseif($currentTicket->isServing())
                                    <div class="status-item serving">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 13.255A9 9 0 1112.75 3.5L12 4l-.75-.5A9 9 0 103 13.255L12 21l9-7.745z"/>
                                        </svg>
                                        Service depuis {{ $currentTicket->serving_at?->format('H:i') }}
                                    </div>
                                @endif
                            </div>

                            <div class="ticket-actions">
                                @if($currentTicket->isCalled())
                                    <form method="POST" action="{{ route('company.agent.ticket.present', [$company, $currentTicket]) }}" class="action-form">
                                        @csrf
                                        <button type="submit" class="action-btn present">
                                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Confirmer Présence
                                        </button>
                                    </form>
                                @endif

                                @if($currentTicket->isPresent())
                                    <form method="POST" action="{{ route('company.agent.ticket.serving', [$company, $currentTicket]) }}" class="action-form">
                                        @csrf
                                        <button type="submit" class="action-btn serving">
                                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M21 13.255A9 9 0 1112.75 3.5L12 4l-.75-.5A9 9 0 103 13.255L12 21l9-7.745z"/>
                                            </svg>
                                            Débuter Service
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('company.agent.ticket.serve', [$company, $currentTicket]) }}" class="action-form">
                                    @csrf
                                    <button type="submit" class="action-btn complete">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Terminer Service
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('company.agent.ticket.missed', [$company, $currentTicket]) }}" class="action-form">
                                    @csrf
                                    <button type="submit" class="action-btn missed">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Client Absent
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('company.agent.ticket.recall', [$company, $currentTicket]) }}" class="action-form">
                                    @csrf
                                    <button type="submit" class="action-btn recall">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Rappeler
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="empty-ticket-state">
                                <div class="empty-visual">
                                    <div class="empty-icon">🎫</div>
                                </div>
                                <h3>Aucun ticket en cours</h3>
                                
                                @if($service && $counter->isOpen())
                                    <form method="POST" action="{{ route('company.agent.call-next', [$company]) }}" class="call-form">
                                        @csrf
                                        <input type="hidden" name="counter_id" value="{{ $counter->id }}">
                                        <button type="submit" class="call-next-btn">
                                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            Appeler le Suivant
                                        </button>
                                    </form>
                                @elseif(!$counter->isOpen())
                                    <div class="warning-state">
                                        <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <p>Guichet fermé - Ouvrez le guichet pour appeler</p>
                                    </div>
                                @else
                                    <div class="error-state">
                                        <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p>Aucun service assigné à ce guichet</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Queue Section -->
            <div class="queue-section">
                <div class="queue-card">
                    <div class="queue-header">
                        <h3>File d'Attente Complète</h3>
                        <div class="queue-stats">
                            <span class="queue-count">{{ $waitingTickets->count() }}</span>
                            <span class="queue-label">ticket(s)</span>
                        </div>
                    </div>

                    <div class="queue-list">
                        @forelse($waitingTickets as $ticket)
                            <div class="queue-item">
                                <div class="ticket-info">
                                    <div class="ticket-number">{{ $ticket->number }}</div>
                                    <div class="ticket-details">
                                        @if($ticket->guest_name)
                                            <span class="guest-name">{{ $ticket->guest_name }}</span>
                                        @endif
                                        <div class="ticket-meta">
                                            <span class="wait-time">
                                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $ticket->created_at->diffForHumans() }}
                                            </span>
                                            <span class="priority-badge">
                                                @if($ticket->priority === 'high')
                                                    Urgent
                                                @elseif($ticket->priority === 'medium')
                                                    Moyen
                                                @else
                                                    Normal
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-actions">
                                    <span class="status-badge">En attente</span>
                                    <button onclick="recallTicket({{ $ticket->id }})" class="recall-action">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Rappeler
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="queue-empty">
                                <div class="empty-icon">📋</div>
                                <h4>Aucun ticket en attente</h4>
                                <p>La file d'attente est vide pour le moment</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Modern Counter System
class ModernCounter {
    constructor() {
        this.refreshInterval = null;
        this.audioContext = null;
        this.init();
    }

    init() {
        this.startAutoRefresh();
        this.initAudio();
        this.initKeyboardShortcuts();
        this.initAnimations();
        this.initNotifications();
    }

    startAutoRefresh() {
        this.refreshInterval = setInterval(() => {
            this.refreshData();
        }, 5000);
    }

    refreshData() {
        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update main content
            const newMainContent = doc.querySelector('.main-content');
            const currentMainContent = document.querySelector('.main-content');
            if (newMainContent && currentMainContent) {
                currentMainContent.innerHTML = newMainContent.innerHTML;
                this.reinitializeComponents();
            }

            // Update sidebar
            const newSidebar = doc.querySelector('.modern-sidebar');
            const currentSidebar = document.querySelector('.modern-sidebar');
            if (newSidebar && currentSidebar) {
                currentSidebar.innerHTML = newSidebar.innerHTML;
            }
        })
        .catch(error => {
            console.log('Erreur lors du rafraîchissement:', error);
        });
    }

    reinitializeComponents() {
        // Reinitialize animations and event listeners
        this.initAnimations();
    }

    initAudio() {
        try {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.log('Audio not supported');
        }
    }

    playSound(type) {
        if (!this.audioContext) return;

        const oscillator = this.audioContext.createOscillator();
        const gainNode = this.audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(this.audioContext.destination);

        switch(type) {
            case 'call':
                oscillator.frequency.value = 800;
                gainNode.gain.value = 0.3;
                break;
            case 'present':
                oscillator.frequency.value = 600;
                gainNode.gain.value = 0.2;
                break;
            case 'serve':
                oscillator.frequency.value = 1000;
                gainNode.gain.value = 0.2;
                break;
            case 'miss':
                oscillator.frequency.value = 300;
                gainNode.gain.value = 0.2;
                break;
            default:
                oscillator.frequency.value = 500;
                gainNode.gain.value = 0.1;
        }
        
        oscillator.start();
        oscillator.stop(this.audioContext.currentTime + 0.1);
    }

    initKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case '1':
                        e.preventDefault();
                        this.clickButton('.call-next-btn');
                        break;
                    case '2':
                        e.preventDefault();
                        this.clickButton('.action-btn.present');
                        break;
                    case '3':
                        e.preventDefault();
                        this.clickButton('.action-btn.complete');
                        break;
                    case '4':
                        e.preventDefault();
                        this.clickButton('.action-btn.missed');
                        break;
                }
            }
        });
    }

    clickButton(selector) {
        const button = document.querySelector(selector);
        if (button) {
            button.click();
        }
    }

    initAnimations() {
        // Add ripple effects to buttons
        document.querySelectorAll('.action-btn, .call-next-btn, .control-btn, .profile-action').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.playSound(this.getSoundType(btn));
                this.createRipple(e, btn);
            });
        });

        // Animate ticket number
        const ticketNumber = document.querySelector('.ticket-number');
        if (ticketNumber) {
            ticketNumber.style.animation = 'glow 2s ease-in-out infinite';
        }

        // Animate status indicators
        document.querySelectorAll('.indicator-dot').forEach(dot => {
            dot.style.animation = 'pulse 2s infinite';
        });
    }

    createRipple(event, button) {
        const ripple = document.createElement('span');
        ripple.className = 'ripple';
        
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px;

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    getSoundType(button) {
        if (button.classList.contains('present')) return 'present';
        if (button.classList.contains('complete') || button.classList.contains('call-next-btn')) return 'serve';
        if (button.classList.contains('missed')) return 'miss';
        if (button.classList.contains('recall') || button.classList.contains('recall-action')) return 'call';
        return 'default';
    }

    initNotifications() {
        // Initialize notification system
        this.notificationContainer = document.createElement('div');
        this.notificationContainer.className = 'notification-container';
        document.body.appendChild(this.notificationContainer);
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-message">${message}</span>
                <button class="notification-close">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
        
        this.notificationContainer.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    destroy() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}

// Global functions
function recallTicket(ticketId) {
    if (confirm('Voulez-vous vraiment rappeler ce ticket ?')) {
        fetch(`/api/tickets/${ticketId}/recall`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modernCounter.showNotification('Ticket rappelé avec succès !', 'success');
                modernCounter.refreshData();
            } else {
                modernCounter.showNotification('Erreur lors du rappel: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            modernCounter.showNotification('Erreur lors du rappel du ticket', 'error');
        });
    }
}

// Initialize Modern Counter
let modernCounter;
document.addEventListener('DOMContentLoaded', function() {
    modernCounter = new ModernCounter();
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (modernCounter) {
        modernCounter.destroy();
    }
});
</script>

<style>
/* Modern Counter Styles */
:root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --primary-light: #60a5fa;
    --secondary: #6366f1;
    --success: #10b981;
    --success-light: #34d399;
    --warning: #f59e0b;
    --error: #ef4444;
    --dark: #1e293b;
    --light: #f8fafc;
    --gray: #64748b;
    --gray-light: #e2e8f0;
    --border: #e2e8f0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.modern-counter {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--dark);
}

/* Premium Header */
.premium-header {
    position: relative;
    padding: 2rem;
    overflow: hidden;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
}

.header-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(99, 102, 241, 0.9) 100%);
}

.pattern-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.header-container {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    z-index: 1;
}

.counter-identity {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.counter-name {
    font-size: 2.5rem;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: -0.025em;
}

.identity-badges {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.company-badge, .service-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.company-badge {
    background: rgba(255, 255, 255, 0.2);
}

.service-badge {
    background: rgba(16, 185, 129, 0.2);
    color: #86efac;
}

.service-badge.inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.back-action {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 500;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.back-action:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Main Layout */
.main-layout {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Modern Sidebar */
.modern-sidebar {
    width: 320px;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.user-profile-card, .status-card, .quick-queue-card, .stats-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--border);
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.profile-info {
    flex: 1;
}

.user-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.user-role {
    font-size: 0.9rem;
    opacity: 0.9;
}

.profile-actions {
    padding: 1rem 1.5rem;
    display: flex;
    gap: 0.75rem;
}

.profile-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--light);
    border: 1px solid var(--border);
    border-radius: 12px;
    color: var(--dark);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
    flex: 1;
    justify-content: center;
}

.profile-action:hover {
    background: var(--gray-light);
    transform: translateY(-1px);
}

.profile-action.logout {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
    border-color: rgba(239, 68, 68, 0.3);
}

.profile-action.logout:hover {
    background: rgba(239, 68, 68, 0.2);
}

.logout-form {
    display: contents;
}

/* Status Card */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--light);
    border-bottom: 1px solid var(--border);
}

.card-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-indicator.online {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-indicator.offline {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.indicator-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
}

.status-controls {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.control-form {
    display: contents;
}

.control-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    justify-content: center;
}

.control-btn.open, .control-btn.resume {
    background: var(--success);
    color: white;
}

.control-btn.close {
    background: var(--error);
    color: white;
}

.control-btn.pause {
    background: var(--warning);
    color: white;
}

.control-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Quick Queue */
.queue-badge {
    background: var(--primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.quick-queue-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 1rem;
}

.quick-queue-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    border-bottom: 1px solid var(--border);
    transition: background-color 0.2s ease;
}

.quick-queue-item:hover {
    background: var(--light);
}

.quick-queue-item:last-child {
    border-bottom: none;
}

.ticket-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.ticket-number {
    font-weight: 600;
    color: var(--dark);
    font-size: 1rem;
}

.guest-name {
    font-size: 0.8rem;
    color: var(--gray);
}

.ticket-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.wait-time {
    font-size: 0.8rem;
    color: var(--gray);
}

.recall-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--primary);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.recall-btn:hover {
    background: var(--primary-dark);
    transform: scale(1.05);
}

.quick-queue-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 2rem 1rem;
    color: var(--gray);
    text-align: center;
}

.quick-queue-empty svg {
    opacity: 0.5;
}

/* Statistics */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--light);
    border-radius: 12px;
    border: 1px solid var(--border);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--gray);
    font-weight: 500;
}

/* Main Content */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Current Ticket */
.current-ticket-container {
    flex: 1;
}

.ticket-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--border);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.ticket-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
}

.header-text h2 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.ticket-time {
    font-size: 0.9rem;
    opacity: 0.9;
}

.ticket-body {
    flex: 1;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.ticket-display {
    text-align: center;
    margin-bottom: 2rem;
}

.ticket-number-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.ticket-number-bg {
    font-size: 8rem;
    font-weight: 900;
    color: rgba(59, 130, 246, 0.1);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
}

.ticket-number {
    font-size: 5rem;
    font-weight: 800;
    color: var(--primary);
    position: relative;
    z-index: 2;
    line-height: 1;
    animation: glow 2s ease-in-out infinite;
}

@keyframes glow {
    0%, 100% { text-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
    50% { text-shadow: 0 0 30px rgba(59, 130, 246, 0.8); }
}

.guest-display {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: var(--light);
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 500;
    color: var(--dark);
}

.ticket-status {
    text-align: center;
    margin-bottom: 2rem;
}

.status-item {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: var(--light);
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 500;
}

.status-item.called { color: var(--warning); }
.status-item.present { color: var(--success); }
.status-item.serving { color: var(--secondary); }

/* Actions */
.ticket-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.action-form {
    display: contents;
}

.action-btn, .call-next-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 16px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
}

.action-btn.present, .call-next-btn {
    background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
    color: white;
}

.action-btn.serving {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: white;
}

.action-btn.complete {
    background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
    color: white;
}

.action-btn.missed {
    background: linear-gradient(135deg, var(--error) 0%, #f87171 100%);
    color: white;
}

.action-btn.recall {
    background: linear-gradient(135deg, var(--warning) 0%, #fbbf24 100%);
    color: white;
}

.action-btn:hover, .call-next-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transform: scale(0);
    animation: rippleEffect 0.6s ease-out;
}

@keyframes rippleEffect {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

/* Empty State */
.empty-ticket-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-visual {
    margin-bottom: 2rem;
}

.empty-icon {
    font-size: 6rem;
    margin-bottom: 1rem;
}

.empty-ticket-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 2rem;
}

.call-form {
    display: flex;
    justify-content: center;
}

.call-next-btn {
    font-size: 1.1rem;
    padding: 1.25rem 2rem;
}

.warning-state, .error-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 2rem;
    border-radius: 16px;
    margin-top: 1rem;
}

.warning-state {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.error-state {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.warning-state p, .error-state p {
    font-weight: 500;
}

/* Queue Section */
.queue-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--border);
}

.queue-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: var(--light);
    border-bottom: 1px solid var(--border);
}

.queue-header h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--dark);
}

.queue-stats {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}

.queue-count {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary);
}

.queue-label {
    font-size: 0.9rem;
    color: var(--gray);
}

.queue-list {
    max-height: 400px;
    overflow-y: auto;
}

.queue-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border);
    transition: background-color 0.2s ease;
}

.queue-item:hover {
    background: var(--light);
}

.queue-item .ticket-number {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.queue-item .guest-name {
    font-size: 1rem;
    color: var(--dark);
    font-weight: 500;
}

.queue-item .ticket-meta {
    display: flex;
    gap: 1rem;
    align-items: center;
    margin-top: 0.5rem;
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    background: var(--light);
    color: var(--gray);
    border: 1px solid var(--border);
}

.queue-item .ticket-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.recall-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.recall-action:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.queue-empty {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--gray);
}

.queue-empty .empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.queue-empty h4 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark);
}

.queue-empty p {
    font-size: 0.9rem;
}

/* Notifications */
.notification-container {
    position: fixed;
    top: 2rem;
    right: 2rem;
    z-index: 1000;
    pointer-events: none;
}

.notification {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border);
    margin-bottom: 1rem;
    transform: translateX(100%);
    opacity: 0;
    transition: all 0.3s ease;
    pointer-events: all;
    min-width: 300px;
}

.notification.show {
    transform: translateX(0);
    opacity: 1;
}

.notification.success {
    border-left: 4px solid var(--success);
}

.notification.error {
    border-left: 4px solid var(--error);
}

.notification.info {
    border-left: 4px solid var(--primary);
}

.notification-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    gap: 1rem;
}

.notification-message {
    flex: 1;
    font-weight: 500;
    color: var(--dark);
}

.notification-close {
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 6px;
    transition: background-color 0.2s ease;
}

.notification-close:hover {
    background: var(--light);
}

/* Responsive */
@media (max-width: 1200px) {
    .main-layout {
        flex-direction: column;
    }
    
    .modern-sidebar {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .counter-name {
        font-size: 2rem;
    }
    
    .header-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .identity-badges {
        justify-content: center;
    }
    
    .ticket-number {
        font-size: 4rem;
    }
    
    .ticket-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .action-btn, .call-next-btn {
        justify-content: center;
    }
    
    .queue-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .main-layout {
        padding: 1rem;
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .ticket-body {
        padding: 1.5rem;
    }
    
    .ticket-number {
        font-size: 3rem;
    }
    
    .call-next-btn {
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }
    
    .queue-header {
        padding: 1rem 1.5rem;
    }
    
    .queue-item {
        padding: 1rem 1.5rem;
    }
}
</style>
@endsection
