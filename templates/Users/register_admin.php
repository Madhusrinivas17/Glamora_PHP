<?php
/**
 * Admin / Salon Owner Registration Page
 */
$this->assign('title', 'Salon Owner Registration - Glamora');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
      <div class="auth-card shadow-sm">
      <div class="text-center mb-4">
        <h2 class="brand-font mb-1"><i class="bi bi-shop me-2 text-pink"></i>Salon Owner Register</h2>
        <p class="text-muted small">Register your parlour & create owner admin account</p>
      </div>

      <?= $this->Form->create($user, ['url' => ['action' => 'registerAdmin']]) ?>
        
        <!-- Full Name & Parlour Name -->
        <div class="row g-2 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-person me-1"></i> Owner Full Name</label>
            <input type="text" name="full_name" class="form-control" placeholder="Sophia Rodriguez" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-building me-1"></i> Parlour / Salon Name</label>
            <input type="text" name="parlour_name" class="form-control" placeholder="Glamora Luxury Salon" required>
          </div>
        </div>

        <!-- Email & Phone -->
        <div class="row g-2 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-envelope me-1"></i> Business Email</label>
            <input type="email" name="email" class="form-control" placeholder="owner@glamora.com" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-telephone me-1"></i> Contact Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="+1 555-0192" required>
          </div>
        </div>

        <!-- Location -->
        <div class="mb-3">
          <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i> Parlour Location / Address</label>
          <input type="text" name="location" class="form-control" placeholder="Beverly Hills, CA" required>
        </div>

        <!-- Password & Confirm -->
        <div class="row g-2 mb-4">
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-lock me-1"></i> Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-check2-circle me-1"></i> Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
          </div>
        </div>

        <button type="submit" class="btn btn-gold w-100 py-3 mb-3 fs-6">
          <i class="bi bi-shield-lock-fill me-2"></i> Register Salon & Owner Account
        </button>

      <?= $this->Form->end() ?>

      <div class="text-center mt-3 pt-3 border-top">
        <p class="small text-muted mb-0">Already registered as Owner? 
          <a href="<?= $this->Url->build('/login?role=admin') ?>" class="text-wine fw-bold">Admin Portal Login</a>
        </p>
      </div>
      </div>
    </div>
  </div>
</div>
