@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
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

            <!-- Personal Information Section -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle me-2"></i>My Profile
                    </h5>
                    <div>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">
                            <i class="bi bi-arrow-left me-1"></i>Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-avatar mb-3">
                                <i class="bi bi-person-circle text-primary" style="font-size: 8rem;"></i>
                            </div>
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                            
                            @if($user->isAdmin())
                                <span class="badge bg-danger fs-6 mb-3">
                                    <i class="bi bi-shield-check me-1"></i>Administrator
                                </span>
                            @else
                                <span class="badge bg-primary fs-6 mb-3">
                                    <i class="bi bi-person me-1"></i>User
                                </span>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted mb-3">Account Information</h6>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Full Name:</strong></div>
                                <div class="col-sm-8">{{ $user->name }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email Address:</strong></div>
                                <div class="col-sm-8">{{ $user->email }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Account Type:</strong></div>
                                <div class="col-sm-8">
                                    @if($user->isAdmin())
                                        <span class="badge bg-danger">Administrator</span>
                                        <small class="text-muted d-block">Full system access</small>
                                    @else
                                        <span class="badge bg-primary">User</span>
                                        <small class="text-muted d-block">Standard user access</small>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Member Since:</strong></div>
                                <div class="col-sm-8">
                                    {{ $user->created_at->format('F d, Y') }}
                                    <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Last Updated:</strong></div>
                                <div class="col-sm-8">
                                    {{ $user->updated_at->format('F d, Y g:i A') }}
                                    <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted mb-3">Quick Actions</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card border-primary h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-pencil-square text-primary mb-2" style="font-size: 2rem;"></i>
                                            <h6>Edit Profile</h6>
                                            <p class="small text-muted">Update your name, email, or password</p>
                                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-star-fill text-success mb-2" style="font-size: 2rem;"></i>
                                            <h6>My Reviews</h6>
                                            <p class="small text-muted">View and manage your game reviews</p>
                                            <a href="{{ route('reviews.index') }}" class="btn btn-success btn-sm">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-info h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-search text-info mb-2" style="font-size: 2rem;"></i>
                                            <h6>Browse Games</h6>
                                            <p class="small text-muted">Search and discover new games</p>
                                            <a href="{{ route('games.search') }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-search me-1"></i>Search
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->isAdmin())
            <!-- Admin User Management Section -->
            <div class="card mt-4">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people me-2"></i>User Management
                    </h5>
                    <small class="badge bg-light text-dark">Admin Only</small>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">As an administrator, you can view and manage all users in the system.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $managedUser)
                                <tr>
                                    <td>
                                        <i class="bi bi-person me-2"></i>{{ $managedUser->name }}
                                        @if($managedUser->id === $user->id)
                                            <span class="badge bg-info ms-2">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $managedUser->email }}</td>
                                    <td>
                                        @if($managedUser->isAdmin())
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-check me-1"></i>Admin
                                            </span>
                                        @else
                                            <span class="badge bg-primary">
                                                <i class="bi bi-person me-1"></i>User
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $managedUser->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($managedUser->id !== $user->id)
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="editUser({{ $managedUser->id }}, '{{ $managedUser->name }}', '{{ $managedUser->email }}', '{{ $managedUser->role }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        @else
                                        <span class="text-muted small">Current User</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_user_id" name="user_id">
                            
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role</label>
                                    <select class="form-select" id="edit_role" name="role" required>
                                        <option value="user">User</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                    <div class="form-text">
                                        <strong>Warning:</strong> Changing a user to admin gives them full system access.
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="admin_password" class="form-label">Your Admin Password</label>
                                    <input type="password" class="form-control" id="admin_password" name="current_password" required>
                                    <div class="form-text">Enter your admin password to confirm changes.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_new_password" class="form-label">New Password for User <small class="text-muted">(Optional)</small></label>
                                    <input type="password" class="form-control" id="edit_new_password" name="new_password" 
                                           placeholder="Leave blank to keep current password">
                                    <div class="form-text">If provided, user's password will be changed.</div>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Account Permissions -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-key me-2"></i>Account Permissions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">✅ You Can:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle text-success me-2"></i>View and edit your profile</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Search and browse games</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Write and manage reviews</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Access API documentation</li>
                                @if($user->isAdmin())
                                <li><i class="bi bi-check-circle text-success me-2"></i>Manage all games</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>View and edit all users</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Change user roles</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            @if(!$user->isAdmin())
                            <h6 class="text-muted">❌ Admin Only:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-x-circle text-muted me-2"></i>Create and edit games</li>
                                <li><i class="bi bi-x-circle text-muted me-2"></i>Delete games</li>
                                <li><i class="bi bi-x-circle text-muted me-2"></i>Manage other users</li>
                                <li><i class="bi bi-x-circle text-muted me-2"></i>Change user roles</li>
                            </ul>
                            @else
                            <h6 class="text-warning">⚠️ Admin Responsibilities:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>Manage system content</li>
                                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>Moderate user reviews</li>
                                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>Maintain data integrity</li>
                                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>User account management</li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
@if($user->isAdmin())
function editUser(userId, name, email, role) {
    document.getElementById('edit_user_id').value = userId;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    
    // Clear password fields when opening modal
    document.getElementById('admin_password').value = '';
    document.getElementById('edit_new_password').value = '';
    
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}
@endif
</script>
@endsection
