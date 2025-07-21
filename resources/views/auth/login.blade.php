@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf

    @if (session('status'))
        <div class="alert alert-success mb-3">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="form-group">
        <label for="email" class="form-label">
            <i class="fas fa-envelope me-2"></i>Email
        </label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-envelope"></i>
            </span>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Masukkan email Anda">
        </div>
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password" class="form-label">
            <i class="fas fa-lock me-2"></i>Kata Sandi
        </label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-lock"></i>
            </span>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Masukkan kata sandi">
            <button type="button" 
                    class="btn btn-outline-secondary toggle-password" 
                    id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
            <input type="checkbox" 
                   name="remember" 
                   id="remember" 
                   class="form-check-input"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                <i class="fas fa-heart me-1"></i>Ingat saya
            </label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-link">
                <i class="fas fa-key me-1"></i>Lupa kata sandi?
            </a>
        @endif
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary" id="loginButton">
            <span class="btn-text">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk
            </span>
            <span class="btn-loading d-none">
                <i class="fas fa-spinner fa-spin me-2"></i>Memproses...
            </span>
        </button>
    </div>

    <div class="divider">
        <span>atau</span>
    </div>

    <div class="text-center">
        <p class="mb-0">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-link">
                <i class="fas fa-user-plus me-1"></i>Daftar sekarang
            </a>
        </p>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    const togglePasswordButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    // Toggle password visibility
    if (togglePasswordButton) {
        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
    
    // Form submission with loading state
    loginForm.addEventListener('submit', function(e) {
        const btnText = loginButton.querySelector('.btn-text');
        const btnLoading = loginButton.querySelector('.btn-loading');
        
        // Show loading state
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        loginButton.disabled = true;
        
        // Add subtle animation
        loginButton.style.transform = 'scale(0.98)';
        
        // Reset after 3 seconds if form doesn't submit (for demo purposes)
        setTimeout(() => {
            if (loginButton.disabled) {
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
                loginButton.disabled = false;
                loginButton.style.transform = 'scale(1)';
            }
        }, 3000);
    });
    
    // Input validation feedback
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
    
    // Auto-focus on first input with error
    const firstError = document.querySelector('.form-control.is-invalid');
    if (firstError) {
        firstError.focus();
    }
    
    // Add floating label effect
    inputs.forEach(input => {
        const label = document.querySelector(`label[for="${input.id}"]`);
        if (label) {
            input.addEventListener('focus', function() {
                label.style.color = '#667eea';
                label.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                label.style.color = '#4a5568';
                label.style.transform = 'translateY(0)';
            });
        }
    });
});
</script>

<style>
/* Additional styles for enhanced form */
.form-control.is-valid {
    border-color: #22c55e;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2322c55e' d='m2.3 6.73.94-.94 1.44 1.44 2.32-2.32.94.94-3.26 3.26z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid {
    border-color: #ef4444;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.5 5.5 1 1m0 0 1 1m-1-1 1-1m-1 1-1 1'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.toggle-password {
    border-left: none;
    background: transparent;
    color: #6b7280;
    transition: all 0.3s ease;
}

.toggle-password:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.btn-primary:disabled {
    opacity: 0.8;
    cursor: not-allowed;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #ef4444;
    margin-top: 0.25rem;
}

.form-label {
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-label i {
    color: #a0aec0;
    font-size: 0.8rem;
}

/* Enhanced input group styling */
.input-group .form-control {
    border-left: none;
}

.input-group .form-control:focus {
    border-left: 2px solid #667eea;
}

.input-group-text {
    background: #f8fafc;
    border-right: none;
    color: #a0aec0;
    transition: all 0.3s ease;
}

.input-group:focus-within .input-group-text {
    background: white;
    color: #667eea;
    border-color: #667eea;
}

/* Animation for form elements */
.form-group {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }
.form-group:nth-child(4) { animation-delay: 0.4s; }
.form-group:nth-child(5) { animation-delay: 0.5s; }
</style>
@endsection