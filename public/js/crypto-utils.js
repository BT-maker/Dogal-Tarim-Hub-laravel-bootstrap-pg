/**
 * Crypto Utilities for Admin Authentication
 * SHA-256 hashing functions for frontend password security
 */

class CryptoUtils {
    /**
     * Hash a string using SHA-256
     * @param {string} message - The string to hash
     * @returns {Promise<string>} - The hexadecimal hash
     */
    static async sha256(message) {
        // Encode the message as UTF-8
        const msgBuffer = new TextEncoder().encode(message);
        
        // Hash the message
        const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
        
        // Convert ArrayBuffer to hex string
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        
        return hashHex;
    }

    /**
     * Hash password with salt for additional security
     * @param {string} password - The password to hash
     * @param {string} salt - Optional salt (defaults to email)
     * @returns {Promise<string>} - The salted and hashed password
     */
    static async hashPassword(password, salt = '') {
        const saltedPassword = salt + password + salt;
        return await this.sha256(saltedPassword);
    }

    /**
     * Generate a random salt
     * @param {number} length - Length of the salt
     * @returns {string} - Random salt string
     */
    static generateSalt(length = 16) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    /**
     * Validate if browser supports Web Crypto API
     * @returns {boolean} - True if supported
     */
    static isSupported() {
        return typeof crypto !== 'undefined' && 
               typeof crypto.subtle !== 'undefined' && 
               typeof crypto.subtle.digest === 'function';
    }
}

// Admin Login Form Handler
class AdminAuth {
    constructor() {
        this.form = null;
        this.emailField = null;
        this.passwordField = null;
        this.submitButton = null;
        this.errorContainer = null;
        
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupForm());
        } else {
            this.setupForm();
        }
    }

    setupForm() {
        this.form = document.getElementById('adminLoginForm');
        if (!this.form) return;

        this.emailField = document.getElementById('email');
        this.passwordField = document.getElementById('password');
        this.submitButton = document.getElementById('loginBtn');
        this.errorContainer = document.getElementById('errorMessage');

        // Check crypto support
        if (!CryptoUtils.isSupported()) {
            this.showError('Bu tarayıcı güvenli şifreleme desteklemiyor. Lütfen modern bir tarayıcı kullanın.');
            return;
        }

        // Add form submit handler
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    async handleLogin() {
        const email = this.emailField.value.trim();
        const password = this.passwordField.value;

        // Validation
        if (!email || !password) {
            this.showError('Email ve şifre alanları zorunludur.');
            return;
        }

        if (!this.isValidEmail(email)) {
            this.showError('Geçerli bir email adresi girin.');
            return;
        }

        try {
            this.setLoading(true);
            this.clearError();

            // Hash password with email as salt
            const hashedPassword = await CryptoUtils.hashPassword(password, email);

            // Create form data
            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', hashedPassword);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // Submit to backend
            const response = await fetch(this.form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (response.ok && result.success) {
                // Store user data if provided (token is now in cookie)
                if (result.user) {
                    localStorage.setItem('admin_user', JSON.stringify(result.user));
                }
                
                // Redirect to admin dashboard
                window.location.href = result.redirect || '/admin';
            } else {
                this.showError(result.message || 'Giriş başarısız. Lütfen bilgilerinizi kontrol edin.');
            }

        } catch (error) {
            console.error('Login error:', error);
            this.showError('Bir hata oluştu. Lütfen tekrar deneyin.');
        } finally {
            this.setLoading(false);
        }
    }

    async handleSubmit(event) {
        event.preventDefault();
        await this.handleLogin();
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showError(message) {
        if (this.errorContainer) {
            const errorText = this.errorContainer.querySelector('#errorText');
            if (errorText) {
                errorText.textContent = message;
            }
            this.errorContainer.style.display = 'block';
        }
    }

    clearError() {
        if (this.errorContainer) {
            this.errorContainer.style.display = 'none';
        }
    }

    setLoading(loading) {
        if (this.submitButton) {
            if (loading) {
                this.submitButton.disabled = true;
                this.submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Giriş yapılıyor...';
            } else {
                this.submitButton.disabled = false;
                this.submitButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Giriş Yap';
            }
        }
    }
}

// Initialize when script loads
new AdminAuth();