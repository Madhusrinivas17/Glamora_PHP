<?php
/**
 * Customer Notifications View
 */
$this->assign('title', 'Notifications - Glamora');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="brand-font text-wine mb-0"><i class="bi bi-bell-fill me-2 text-pink"></i>My Notifications</h2>
        <span class="badge bg-pink text-white rounded-pill px-3 py-2" style="background:#E87A90;"><?= count($notifications) ?> Alerts</span>
      </div>

      <?php if ($notifications->isEmpty()): ?>
        <div class="glamora-card p-5 text-center">
          <i class="bi bi-bell-slash display-4 text-pink mb-3 d-block"></i>
          <h5 class="brand-font text-wine">No Notifications</h5>
          <p class="text-muted mb-0">You don't have any notifications at the moment.</p>
        </div>
      <?php else: ?>
        <div class="list-group shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">
          <?php foreach ($notifications as $n): ?>
            <div class="list-group-item p-4 border-bottom <?= $n->is_read ? 'bg-white' : 'bg-light border-start border-4 border-pink' ?>">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0 text-wine">
                  <i class="bi <?= $n->type === 'success' ? 'bi-check-circle-fill text-success' : 'bi-info-circle-fill text-primary' ?> me-2"></i>
                  <?= h($n->title) ?>
                </h6>
                <small class="text-muted"><?= h($n->created->timeAgoInWords()) ?></small>
              </div>
              <p class="mb-2 text-muted small"><?= h($n->message) ?></p>
              <?php if (!$n->is_read): ?>
                <a href="<?= $this->Url->build(['action' => 'markRead', $n->id]) ?>" class="btn btn-sm btn-link p-0 text-pink text-decoration-none small fw-semibold">
                  <i class="bi bi-check2-all me-1"></i> Mark as Read
                </a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
