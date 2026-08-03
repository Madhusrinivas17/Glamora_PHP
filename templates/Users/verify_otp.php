<?php
/**
 * Glamora OTP Verification View
 */
$this->assign('title', 'Email OTP Verification - Glamora');
?>

<div class="container py-5">
  <div class="auth-container" style="max-width: 500px;">
    <div class="auth-card text-center">
      <div class="mb-4">
        <div class="avatar-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:70px; height:70px; background:#FDE8ED; border: 2px solid #E87A90; border-radius:50%;">
          <i class="bi bi-shield-lock-fill text-pink fs-2" style="color:#E87A90;"></i>
        </div>
        <h3 class="brand-font text-wine mb-1">Verify Your Email</h3>
        <p class="text-muted small">We sent a 6-digit security OTP code to</p>
        <div class="fw-bold text-wine fs-6 bg-light py-2 px-3 rounded-pill d-inline-block border border-pink">
          <i class="bi bi-envelope-check me-1 text-pink"></i> <?= h($email) ?>
        </div>
      </div>

      <?= $this->Form->create(null, ['url' => ['action' => 'verifyOtp'], 'id' => 'otp-form']) ?>
        <input type="hidden" name="email" value="<?= h($email) ?>">

        <div class="mb-4">
          <label class="form-label fw-semibold text-wine small mb-2 d-block">Enter 6-Digit OTP Code</label>
          <input type="text" name="otp_code" class="form-control text-center font-monospace fs-3 fw-bold tracking-wider py-2" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autofocus style="letter-spacing: 12px; border: 2px solid #E87A90; border-radius: 14px;">
          <small class="text-muted d-block mt-2"><i class="bi bi-clock-history me-1 text-gold"></i> OTP valid for 5 minutes</small>
        </div>

        <button type="submit" class="btn btn-glamora w-100 py-3 mb-3 fs-6 shadow-md">
          <i class="bi bi-check-circle-fill me-2"></i> Verify OTP & Activate Account
        </button>
      <?= $this->Form->end() ?>

      <!-- Resend OTP Section with Cooldown Timer -->
      <div class="mt-4 pt-3 border-top">
        <p class="small text-muted mb-2">Didn't receive the email code?</p>
        <div id="resend-container">
          <?php if ($remainingCooldown > 0): ?>
            <button type="button" class="btn btn-glamora-outline btn-sm disabled opacity-75" id="resend-btn" disabled>
              <i class="bi bi-arrow-clockwise me-1"></i> Resend OTP in <span id="cooldown-timer"><?= (int)$remainingCooldown ?></span>s
            </button>
          <?php else: ?>
            <a href="<?= $this->Url->build(['action' => 'resendOtp', '?' => ['email' => $email]]) ?>" class="btn btn-glamora-outline btn-sm" id="resend-btn">
              <i class="bi bi-arrow-clockwise me-1"></i> Resend OTP Code
            </a>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const timerElement = document.getElementById('cooldown-timer');
  const resendBtn = document.getElementById('resend-btn');
  const resendContainer = document.getElementById('resend-container');
  let seconds = <?= (int)$remainingCooldown ?>;

  if (seconds > 0 && timerElement) {
    const interval = setInterval(function () {
      seconds--;
      timerElement.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(interval);
        resendContainer.innerHTML = `
          <a href="<?= $this->Url->build(['action' => 'resendOtp', '?' => ['email' => $email]]) ?>" class="btn btn-glamora-outline btn-sm">
            <i class="bi bi-arrow-clockwise me-1"></i> Resend OTP Code
          </a>
        `;
      }
    }, 1000);
  }
});
</script>
