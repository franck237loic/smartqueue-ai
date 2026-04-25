import './bootstrap';

// Import Lucide Icons with all icons
import { createIcons, icons } from 'lucide';

// Initialize Lucide icons when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    createIcons({ icons });
});

// Make lucide available globally for inline scripts
window.lucide = { createIcons, icons };
