@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-person-gear me-2"></i>Edit Profile
                    </h4>
                    <a href="{{ route('profile') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back to Profile
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-person me-2"></i>Personal Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Current Role</label>
                                            <div>
                                                @if($user->isAdmin())
                                                    <span class="badge bg-danger fs-6">
                                                        <i class="bi bi-shield-check me-1"></i>Administrator
                                                    </span>
                                                @else
                                                    <span class="badge bg-primary fs-6">
                                                        <i class="bi bi-person me-1"></i>User
                                                    </span>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                @if($user->isAdmin())
                                                    You have full access to manage games and users.
                                                @else
                                                    You can search games, write reviews, and manage your profile.
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Member Since</label>
                                            <div class="form-control-plaintext">
                                                <i class="bi bi-calendar-event me-2"></i>
                                                {{ $user->created_at->format('F d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-shield-lock me-2"></i>Security Verification
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">
                                        Current Password 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password" 
                                               placeholder="Enter your current password" required>
                                        <button class="btn btn-outline-secondary" type="button" 
                                                onclick="togglePasswordVisibility('current_password')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Required to verify your identity before making any changes
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-key me-2"></i>Change Password (Optional)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Optional:</strong> Leave these fields blank to keep your current password.
                                    Only fill them if you want to change your password.
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">
                                                New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                                       id="new_password" name="new_password" 
                                                       placeholder="Enter new password">
                                                <button class="btn btn-outline-secondary" type="button" 
                                                        onclick="togglePasswordVisibility('new_password')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @error('new_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-text">Minimum 8 characters</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="new_password_confirmation" class="form-label">
                                                Confirm New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" 
                                                       id="new_password_confirmation" name="new_password_confirmation" 
                                                       placeholder="Confirm new password">
                                                <button class="btn btn-outline-secondary" type="button" 
                                                        onclick="togglePasswordVisibility('new_password_confirmation')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            <div class="form-text">Must match new password</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('profile') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-house me-2"></i>Dashboard
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-shield-check me-2"></i>Security Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">✅ Password Best Practices:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check text-success me-2"></i>Use at least 8 characters</li>
                                <li><i class="bi bi-check text-success me-2"></i>Include uppercase and lowercase letters</li>
                                <li><i class="bi bi-check text-success me-2"></i>Add numbers and special characters</li>
                                <li><i class="bi bi-check text-success me-2"></i>Don't reuse old passwords</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">🔒 Account Security:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-info-circle text-info me-2"></i>Keep your email updated</li>
                                <li><i class="bi bi-info-circle text-info me-2"></i>Log out from shared devices</li>
                                <li><i class="bi bi-info-circle text-info me-2"></i>Don't share your password</li>
                                <li><i class="bi bi-info-circle text-info me-2"></i>Update regularly</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    const currentPassword = document.getElementById('current_password');
    const form = document.querySelector('form');
    
    // Validate password confirmation
    function validatePasswordMatch() {
        if (newPassword.value && confirmPassword.value) {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
                confirmPassword.classList.add('is-invalid');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
            }
        }
    }
    
    if (newPassword && confirmPassword) {
        newPassword.addEventListener('input', validatePasswordMatch);
        confirmPassword.addEventListener('input', validatePasswordMatch);
    }
    
    // Form submission validation
    if (form && currentPassword) {
        form.addEventListener('submit', function(e) {
            if (!currentPassword.value.trim()) {
                e.preventDefault();
                alert('Please enter your current password to update your profile.');
                currentPassword.focus();
                return false;
            }
        });
    }
});

// Toggle password visibility
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection
