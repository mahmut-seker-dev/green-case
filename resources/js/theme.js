// 🎨 THEME SWITCHER
// Dark/Light tema değiştirme sistemi

class ThemeManager {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        // Sayfa yüklendiğinde tema uygula
        this.applyTheme(this.theme);
        
        // Toggle butonu event listener
        document.getElementById('themeToggle')?.addEventListener('click', () => {
            this.toggleTheme();
        });
        
        // Sistem teması değişikliğini dinle (opsiyonel)
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                this.applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }

    toggleTheme() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        this.applyTheme(this.theme);
        localStorage.setItem('theme', this.theme);
    }

    applyTheme(theme) {
        const root = document.documentElement;
        const lightIcon = document.querySelector('.theme-icon-light');
        const darkIcon = document.querySelector('.theme-icon-dark');
        
        // Anında değişim için transition'ları geçici devre dışı bırak
        root.style.setProperty('--transition-speed', '0s');
        
        // Tema uygula
        if (theme === 'dark') {
            root.setAttribute('data-theme', 'dark');
            lightIcon?.classList.add('d-none');
            darkIcon?.classList.remove('d-none');
        } else {
            root.removeAttribute('data-theme');
            lightIcon?.classList.remove('d-none');
            darkIcon?.classList.add('d-none');
        }
        
        this.theme = theme;
        
        // Bir sonraki frame'de transition'ları geri aç
        requestAnimationFrame(() => {
            setTimeout(() => {
                root.style.setProperty('--transition-speed', '0.15s');
            }, 50);
        });
    }

    getTheme() {
        return this.theme;
    }
}

// Sayfa yüklendiğinde başlat
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

export default ThemeManager;
