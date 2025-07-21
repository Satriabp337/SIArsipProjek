@extends('layouts.auth')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h3 class="card-title fw-bold text-primary mb-2">Register</h3>
            <!-- <p class="text-muted">Silakan isi data diri Anda untuk mendaftar</p> -->
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">
                    <i class="fas fa-user me-1 text-primary"></i>
                    Nama Lengkap
                </label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Masukkan nama lengkap Anda"
                    autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">
                    <i class="fas fa-envelope me-1 text-primary"></i>
                    Email
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="contoh@email.com"
                    autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">
                    <i class="fas fa-lock me-1 text-primary"></i>
                    Password
                </label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        required
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8">
                    <button 
                        class="btn btn-outline-secondary" 
                        type="button" 
                        id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="form-text">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Password harus minimal 8 karakter
                    </small>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-medium">
                    <i class="fas fa-lock me-1 text-primary"></i>
                    Konfirmasi Password
                </label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        minlength="8">
                    <button 
                        class="btn btn-outline-secondary" 
                        type="button" 
                        id="togglePasswordConfirmation">
                        <i class="fas fa-eye" id="eyeIconConfirmation"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback d-block">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg fw-medium" id="submitBtn">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar Sekarang
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="mb-0 text-muted">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-medium">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    function togglePasswordVisibility(inputId, buttonId, iconId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const icon = document.getElementById(iconId);
        
        button.addEventListener('click', function() {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
    
    // Apply to both password fields
    togglePasswordVisibility('password', 'togglePassword', 'eyeIcon');
    togglePasswordVisibility('password_confirmation', 'togglePasswordConfirmation', 'eyeIconConfirmation');
    
    // Form validation
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    
    // Real-time password confirmation validation
    passwordConfirmation.addEventListener('input', function() {
        if (password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('Password tidak cocok');
            passwordConfirmation.classList.add('is-invalid');
        } else {
            passwordConfirmation.setCustomValidity('');
            passwordConfirmation.classList.remove('is-invalid');
        }
    });
    
    // Form submission loading state
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftar...';
        submitBtn.disabled = true;
    });
    
    // Auto-hide validation errors after typing
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>

<style>
.card {
    border: 0;
    border-radius: 12px;
    max-width: 450px;
    margin: 0 auto;
}

.form-control {
    border-radius: 8px;
    padding: 12px 16px;
    border: 1.5px solid #e3e6f0;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    transform: translateY(-1px);
}

.form-control.is-invalid {
    border-color: #e74a3b;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 20%, 40%, 60%, 80% { transform: translateX(-2px); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(2px); }
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
}

.btn-outline-secondary {
    border-color: #e3e6f0;
    color: #6c757d;
    transition: all 0.2s ease;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fc;
    border-color: #d1d3e2;
}

.form-label {
    color: #5a5c69;
    margin-bottom: 8px;
}

.text-primary {
    color: #4e73df !important;
}

.card-title {
    color: #2d3748;
}

.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 4px;
}

.form-text small {
    font-size: 0.8rem;
}

.input-group .btn {
    border-left: none;
}

.input-group .form-control:focus + .btn {
    border-color: #4e73df;
}
</style>
@endsection