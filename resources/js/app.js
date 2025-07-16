import './bootstrap';

import Alpine from 'alpinejs';

// Alpine.js plugins and global components
Alpine.data('dropdown', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
}));

Alpine.data('modal', () => ({
    open: false,
    show() {
        this.open = true;
        document.body.classList.add('overflow-hidden');
    },
    hide() {
        this.open = false;
        document.body.classList.remove('overflow-hidden');
    }
}));

Alpine.data('tabs', (defaultTab = null) => ({
    activeTab: defaultTab,
    setActiveTab(tab) {
        this.activeTab = tab;
    }
}));

Alpine.data('notification', (message, type = 'info', duration = 5000) => ({
    show: true,
    message,
    type,
    init() {
        if (duration > 0) {
            setTimeout(() => {
                this.hide();
            }, duration);
        }
    },
    hide() {
        this.show = false;
    }
}));

// Global Alpine methods
Alpine.magic('clipboard', () => {
    return (text) => {
        navigator.clipboard.writeText(text);
    };
});

Alpine.magic('formatDate', () => {
    return (date, format = 'en-US') => {
        return new Date(date).toLocaleDateString(format);
    };
});

window.Alpine = Alpine;

Alpine.start();

// Global helper functions
window.showNotification = function(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 transition-all duration-300 transform translate-x-full`;
    
    const colors = {
        success: 'border-green-500 bg-green-50 text-green-800 dark:bg-green-900 dark:text-green-300',
        error: 'border-red-500 bg-red-50 text-red-800 dark:bg-red-900 dark:text-red-300',
        warning: 'border-yellow-500 bg-yellow-50 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        info: 'border-blue-500 bg-blue-50 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
    };
    
    notification.classList.add(...colors[type].split(' '));
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <button class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
};
