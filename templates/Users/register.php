<?php
/**
 * Customer Registration Page
 */
$this->assign('title', 'Customer Registration - Glamora Salon');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="auth-card shadow-sm">
      <div class="text-center mb-4">
        <h2 class="brand-font mb-1"><i class="bi bi-person-plus-fill me-2 text-pink"></i>Join Glamora</h2>
        <p class="text-muted small">Create your customer account to book appointments</p>
      </div>

      <?= $this->Form->create($user, ['url' => ['action' => 'register']]) ?>
        
        <!-- Full Name -->
        <div class="mb-3">
          <label class="form-label fw-semibold"><i class="bi bi-person me-1"></i> Full Name</label>
          <input type="text" name="full_name" class="form-control" placeholder="Jane Doe" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="form-label fw-semibold"><i class="bi bi-envelope me-1"></i> Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="jane@example.com" required>
        </div>

        <!-- Phone & Location -->
        <div class="row g-2 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-telephone me-1"></i> Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="+1 555-0144" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i> Location / City</label>
            <input type="text" name="location" class="form-control" placeholder="Los Angeles, CA">
          </div>
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

        <button type="submit" class="btn btn-glamora w-100 py-3 mb-3">
          <i class="bi bi-person-check-fill me-2"></i> Register Account
        </button>

      <?= $this->Form->end() ?>

      <div class="text-center mt-3 pt-3 border-top">
        <p class="small text-muted mb-0">Already have an account? 
          <a href="<?= $this->Url->build('/login') ?>" class="text-wine fw-bold">Sign In Here</a>
        </p>
      </div>
      </div>
    </div>
  </div>
</div>
