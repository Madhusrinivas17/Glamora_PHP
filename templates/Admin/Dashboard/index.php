<?php
/**
 * Owner & Admin Redesigned Dashboard View
 */
$this->assign('title', 'Admin & Salon Owner Dashboard');
$isOpen = $parlour ? (bool)$parlour->is_open : true;
?>

<!-- Owner Business Status Toggle Card Banner -->
<div class="p-4 bg-white rounded-4 border shadow-sm mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="avatar-circle bg-pink-light rounded-circle d-flex align-items-center justify-content-center text-pink" style="width:54px; height:54px; background:#FDE8ED; border: 2px solid #E87A90;">
        <i class="bi bi-shop fs-3" style="color:#E87A90;"></i>
      </div>
      <div>
        <h4 class="brand-font text-wine mb-1"><?= h($parlour->name ?? 'Glamora Salon & Beauty Spa') ?></h4>
        <div class="d-flex align-items-center gap-2">
          <span class="text-muted small"><i class="bi bi-geo-alt-fill text-pink me-1"></i> <?= h($parlour->address ?? 'Beverly Hills, CA') ?></span>
          <span class="text-muted small">•</span>
          <span id="live-status-badge" class="badge <?= $isOpen ? 'bg-success' : 'bg-danger' ?> px-3 py-1 rounded-pill fw-bold">
            <?= $isOpen ? '🟢 OPEN NOW' : '🔴 CLOSED' ?>
          </span>
        </div>
      </div>
    </div>

    <!-- Business Status AJAX Toggle Switch -->
    <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-4 border">
      <span class="fw-bold text-wine small"><i class="bi bi-power me-1 text-pink"></i> Parlour Live Status:</span>
      <div class="form-check form-switch m-0 fs-4">
        <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="parlourStatusToggle" <?= $isOpen ? 'checked' : '' ?> onchange="toggleParlourStatus()">
      </div>
      <strong id="status-toggle-text" class="small fw-bold text-wine"><?= $isOpen ? 'OPEN' : 'CLOSED' ?></strong>
    </div>
  </div>
</div>

<!-- 10 Metric Widgets Grid -->
<div class="row g-3 mb-4">
  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">PENDING</span>
        <h3 class="fw-bold mb-0 text-warning"><?= $pendingCount ?></h3>
      </div>
      <div class="metric-icon" style="background:#FFF8E1; color:#B78103;">
        <i class="bi bi-clock-history"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">CONFIRMED</span>
        <h3 class="fw-bold mb-0 text-success"><?= $confirmedCount ?></h3>
      </div>
      <div class="metric-icon icon-green">
        <i class="bi bi-check-circle-fill"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">COMPLETED</span>
        <h3 class="fw-bold mb-0 text-primary"><?= $completedCount ?></h3>
      </div>
      <div class="metric-icon" style="background:#E3F2FD; color:#1565C0;">
        <i class="bi bi-check2-all"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">CANCELLED</span>
        <h3 class="fw-bold mb-0 text-danger"><?= $cancelledCount ?></h3>
      </div>
      <div class="metric-icon" style="background:#FFEBEE; color:#C62828;">
        <i class="bi bi-x-circle-fill"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">TOTAL BOOKINGS</span>
        <h3 class="fw-bold mb-0 text-wine"><?= $totalAppointmentsCount ?></h3>
      </div>
      <div class="metric-icon icon-purple">
        <i class="bi bi-calendar-event"></i>
      </div>
    </div>
  </div>



  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">CUSTOMERS</span>
        <h3 class="fw-bold mb-0 text-wine"><?= $totalCustomers ?></h3>
      </div>
      <div class="metric-icon icon-purple">
        <i class="bi bi-people-fill"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">TOTAL REVIEWS</span>
        <h3 class="fw-bold mb-0 text-wine"><?= $totalReviews ?></h3>
      </div>
      <div class="metric-icon icon-gold">
        <i class="bi bi-star-fill"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">PARLOUR REVIEWS</span>
        <h3 class="fw-bold mb-0 text-wine"><?= (int)$totalReviews ?> Feedback</h3>
      </div>
      <div class="metric-icon icon-gold">
        <i class="bi bi-chat-heart-fill"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-md-4 col-sm-6">
    <div class="metric-card d-flex align-items-center justify-content-between">
      <div>
        <span class="text-muted text-xs fw-semibold d-block text-uppercase">TOTAL LIKES</span>
        <h3 class="fw-bold mb-0 text-wine"><?= $totalLikes ?></h3>
      </div>
      <div class="metric-icon icon-pink">
        <i class="bi bi-heart-fill"></i>
      </div>
    </div>
  </div>
</div>

<style>
@media (min-width: 1200px) {
  .col-xl-2-4 {
    flex: 0 0 auto;
    width: 20%;
  }
}
</style>

<!-- Quick Actions & Analytics Banner -->
<div class="row g-4 mb-4">
  <div class="col-lg-6">
    <div class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
      <div>
        <h5 class="brand-font text-wine mb-3"><i class="bi bi-lightning-charge-fill me-2 text-gold"></i>Quick Action Shortcuts</h5>
        <p class="text-muted small">Manage services, prices, offers, and salon staff roster:</p>
      </div>

      <div class="row g-2">
        <div class="col-6 col-sm-4">
          <a href="<?= $this->Url->build('/admin/services/add') ?>" class="btn btn-glamora-outline w-100 py-2 small">
            <i class="bi bi-plus-circle me-1"></i> Add Service
          </a>
        </div>
        <div class="col-6 col-sm-4">
          <a href="<?= $this->Url->build('/admin/services') ?>" class="btn btn-glamora-outline w-100 py-2 small">
            <i class="bi bi-scissors me-1"></i> Services
          </a>
        </div>
        <div class="col-6 col-sm-4">
          <a href="<?= $this->Url->build('/admin/offers') ?>" class="btn btn-glamora-outline w-100 py-2 small">
            <i class="bi bi-percent me-1"></i> Offers
          </a>
        </div>
        <div class="col-6 col-sm-4">
          <a href="<?= $this->Url->build('/admin/customer-history') ?>" class="btn btn-glamora-outline w-100 py-2 small">
            <i class="bi bi-journal-text me-1"></i> Reports
          </a>
        </div>
        <div class="col-6 col-sm-4">
          <a href="<?= $this->Url->build('/admin/beauticians') ?>" class="btn btn-glamora-outline w-100 py-2 small">
            <i class="bi bi-people me-1"></i> Staff Roster
          </a>
        </div>
        <div class="col-6 col-sm-4">
          <a href="<?= $this->Url->build('/admin/slots') ?>" class="btn btn-glamora-outline w-100 py-2 small">
            <i class="bi bi-clock me-1"></i> Generate Slots
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
      <h5 class="brand-font text-wine mb-3"><i class="bi bi-star-fill me-2 text-gold"></i>Recent Customer Reviews Stream</h5>
      <?php if (empty($recentReviews) || count($recentReviews) === 0): ?>
        <div class="alert alert-light border text-center py-3 text-muted small">No customer reviews posted yet.</div>
      <?php else: ?>
        <div class="list-group list-group-flush">
          <?php foreach ($recentReviews as $rev): ?>
            <div class="list-group-item px-0 py-2 bg-transparent border-bottom d-flex justify-content-between align-items-center">
              <div>
                <strong class="text-wine small d-block"><?= h($rev->user->full_name ?? 'Client') ?></strong>
                <small class="text-muted" style="font-size:0.78rem;">"<?= h($rev->comment) ?>"</small>
              </div>
              <div class="text-end">
                <span class="small font-semibold text-warning"><i class="bi bi-star-fill me-1"></i><?= (int)$rev->rating ?>/5</span>
                <?= $this->Form->postLink(
                  '<i class="bi bi-trash text-danger"></i>',
                  ['controller' => 'Reviews', 'action' => 'delete', $rev->id],
                  ['escape' => false, 'confirm' => __('Delete review?'), 'class' => 'btn btn-link btn-sm p-0 ms-2']
                ) ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Recent Appointments Stream Table -->
<div class="p-4 bg-white rounded-4 border shadow-sm">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="brand-font text-wine mb-0"><i class="bi bi-list-stars me-2 text-pink"></i>Recent Appointments Stream</h5>
    <a href="<?= $this->Url->build('/admin/appointments') ?>" class="btn btn-glamora-outline btn-sm">View All Bookings</a>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Service</th>
          <th>Stylist</th>
          <th>Date & Time</th>
          <th>Price</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentBookings as $app): ?>
          <tr>
            <td><strong>#<?= $app->id ?></strong></td>
            <td>
              <div class="fw-semibold text-wine"><?= h($app->user->full_name ?? 'Client') ?></div>
              <small class="text-muted"><?= h($app->user->phone ?? '') ?></small>
            </td>
            <td><?= h($app->service->name ?? 'Service') ?></td>
            <td><?= h($app->beautician->name ?? 'Auto-assigned') ?></td>
            <td>
              <div><?= h($app->appointment_date) ?></div>
              <small class="text-muted"><?= date('h:i A', strtotime($app->appointment_time)) ?></small>
            </td>
            <td class="fw-bold text-pink">Rs. <?= number_format((float)$app->total_price, 2) ?></td>
            <td>
              <?php
                $statusClasses = [
                  'Pending' => 'status-pending',
                  'Confirmed' => 'status-confirmed',
                  'Completed' => 'status-completed',
                  'Cancelled' => 'status-cancelled',
                  'Rescheduled' => 'status-rescheduled',
                ];
                $sClass = $statusClasses[$app->status] ?? 'status-pending';
              ?>
              <span class="status-badge <?= $sClass ?>"><?= h($app->status) ?></span>
            </td>
            <td class="text-end">
              <?php if ($app->status === 'Pending'): ?>
                <?= $this->Form->postLink('Accept', ['controller' => 'Appointments', 'action' => 'updateStatus', $app->id, 'Confirmed'], ['class' => 'btn btn-success btn-sm me-1']) ?>
              <?php endif; ?>
              <?php if ($app->status === 'Confirmed'): ?>
                <?= $this->Form->postLink('Complete', ['controller' => 'Appointments', 'action' => 'updateStatus', $app->id, 'Completed'], ['class' => 'btn btn-primary btn-sm me-1']) ?>
              <?php endif; ?>
              <?php if ($app->status !== 'Cancelled'): ?>
                <?= $this->Form->postLink('Cancel', ['controller' => 'Appointments', 'action' => 'updateStatus', $app->id, 'Cancelled'], ['class' => 'btn btn-outline-danger btn-sm me-1', 'confirm' => __('Cancel booking #{0}?', $app->id)]) ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function toggleParlourStatus() {
  fetch('<?= $this->Url->build('/admin/toggle-status') ?>', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const badge = document.getElementById('live-status-badge');
      const text = document.getElementById('status-toggle-text');
      badge.className = 'badge ' + data.badge_class + ' px-3 py-1 rounded-pill fw-bold';
      badge.textContent = data.status_text;
      text.textContent = data.is_open ? 'OPEN' : 'CLOSED';
    }
  });
}
</script>
