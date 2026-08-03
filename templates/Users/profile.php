<?php
/**
 * User Profile View
 */
$this->assign('title', 'My Profile - Glamora');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="glamora-card p-4">
        <h3 class="brand-font mb-4"><i class="bi bi-person-gear me-2 text-pink"></i>My Profile Settings</h3>

        <?= $this->Form->create($user) ?>
          <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?= h($user->full_name) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" name="email" class="form-control" value="<?= h($user->email) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="<?= h($user->phone) ?>" required>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Location / Address</label>
            <input type="text" name="location" class="form-control" value="<?= h($user->location) ?>">
          </div>

          <button type="submit" class="btn btn-glamora">
            <i class="bi bi-save me-2"></i> Save Profile Changes
          </button>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>
