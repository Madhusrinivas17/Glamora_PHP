<?php
/**
 * Glamora Luxury Unified Login Page - Strict Role Access Control & Centered Flash Alerts
 */
$this->assign('title', 'Sign In - Glamora Salon');
$selectedRole = $this->request->getQuery('role') === 'admin' ? 'admin' : 'user';
?>

<div class="d-flex align-items-center justify-content-center py-5 min-vh-100 w-100" style="background: radial-gradient(circle at top right, #FDF0F3 0%, #FAF4F6 60%, #F5E8EC 100%);">
  <div class="auth-card-luxury position-relative bg-white rounded-5 p-4 p-md-5 border shadow-lg w-100" style="max-width: 480px; border-color: #F2E4E8 !important; border-radius: 28px !important;">
    
    <!-- Top Brand Header -->
    <div class="text-center mb-4">
      <a href="<?= $this->Url->build('/') ?>" class="brand-font fs-1 fw-bold text-wine text-decoration-none d-block mb-1">
        glamora<span style="color: #E87A90;">*</span>
      </a>
      <p class="text-muted small mb-0">Sign in to manage appointments & salon services</p>
    </div>

    <!-- Centered Flash Alert Messages -->
    <div class="login-flash-container text-center mb-3">
      <?= $this->Flash->render() ?>
    </div>

    <?= $this->Form->create(null, ['url' => ['action' => 'login'], 'id' => 'loginForm']) ?>
      
      <!-- Role Segmented Control Pill -->
      <div class="mb-4">
        <label class="form-label fw-bold text-wine small text-uppercase d-block text-center mb-2">SELECT ACCOUNT ROLE</label>
        <input type="hidden" name="role_type" id="role-input" value="<?= $selectedRole ?>">
        
        <div class="role-segmented-control d-flex p-1 bg-light rounded-pill border" style="border-color: #F2E4E8 !important;">
          <button type="button" 
                  id="role-btn-user" 
                  class="role-segment-btn flex-fill py-2 rounded-pill border-0 fw-bold small transition-all <?= $selectedRole === 'user' ? 'active' : '' ?>"
                  onclick="selectRole('user')">
            <i class="bi bi-person-fill me-1"></i> Customer
          </button>
          <button type="button" 
                  id="role-btn-admin" 
                  class="role-segment-btn flex-fill py-2 rounded-pill border-0 fw-bold small transition-all <?= $selectedRole === 'admin' ? 'active' : '' ?>"
                  onclick="selectRole('admin')">
            <i class="bi bi-shop me-1"></i> Salon Owner
          </button>
        </div>
      </div>

      <!-- Login Field (Email or Phone Number) -->
      <div class="mb-3">
        <label class="form-label fw-semibold small text-wine"><i class="bi bi-envelope-at me-1 text-pink"></i> Email OR Phone Number</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 rounded-start-4 text-pink" style="border-color: #EEDFE3;"><i class="bi bi-person"></i></span>
          <input type="text" name="login_field" class="form-control bg-light border-start-0 rounded-end-4 py-2" placeholder="Enter email or phone number" required autofocus style="border-color: #EEDFE3;">
        </div>
      </div>

      <!-- Password -->
      <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <label class="form-label fw-semibold small text-wine mb-0"><i class="bi bi-lock me-1 text-pink"></i> Password</label>
        </div>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 rounded-start-4 text-pink" style="border-color: #EEDFE3;"><i class="bi bi-key"></i></span>
          <input type="password" name="password" class="form-control bg-light border-start-0 rounded-end-4 py-2" placeholder="Enter your password" required style="border-color: #EEDFE3;">
        </div>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-book-gradient-pill w-100 py-3 mb-3 fw-bold fs-6 shadow">
        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In to Glamora
      </button>

    <?= $this->Form->end() ?>

    <!-- Register Links -->
    <div class="mt-4 pt-3 border-top text-center">
      <p class="small text-muted mb-2">New to Glamora? Create an account:</p>
      <div class="d-flex justify-content-center gap-3">
        <a href="<?= $this->Url->build('/register') ?>" class="text-wine fw-bold text-decoration-none small">
          <i class="bi bi-person-plus me-1 text-pink"></i> Customer Register
        </a>
        <span class="text-muted small">•</span>
        <a href="<?= $this->Url->build('/register-admin') ?>" class="text-wine fw-bold text-decoration-none small">
          <i class="bi bi-shop me-1 text-pink"></i> Owner Register
        </a>
      </div>
    </div>

  </div>
</div>

<style>
.role-segment-btn {
  background: transparent;
  color: #7E6571;
  transition: all 0.25s ease;
}
.role-segment-btn.active {
  background: linear-gradient(135deg, #7A2E44 0%, #36111C 100%) !important;
  color: #FFFFFF !important;
  box-shadow: 0 4px 12px rgba(54, 17, 28, 0.25);
}
.auth-card-luxury input:focus {
  background-color: #FFFFFF !important;
  box-shadow: 0 0 0 4px rgba(232, 122, 144, 0.15) !important;
  border-color: #E87A90 !important;
}

/* Centered High-Contrast Flash Alert Styling */
.login-flash-container .message,
.login-flash-container .alert {
  text-align: center !important;
  border-radius: 16px !important;
  font-size: 0.85rem !important;
  font-weight: 600 !important;
  padding: 0.75rem 1rem !important;
  margin-bottom: 1rem !important;
}
.login-flash-container .message.error,
.login-flash-container .alert-danger {
  background-color: #FDF0F3 !important;
  color: #7A2E44 !important;
  border: 1px solid #E87A90 !important;
}
.login-flash-container .message.success,
.login-flash-container .alert-success {
  background-color: #D4EDDA !important;
  color: #155724 !important;
  border: 1px solid #C3E6CB !important;
}
</style>

<script>
function selectRole(role) {
  document.getElementById('role-input').value = role;
  const userBtn = document.getElementById('role-btn-user');
  const adminBtn = document.getElementById('role-btn-admin');
  
  if (role === 'user') {
    userBtn.classList.add('active');
    adminBtn.classList.remove('active');
  } else {
    adminBtn.classList.add('active');
    userBtn.classList.remove('active');
  }
}
</script>
