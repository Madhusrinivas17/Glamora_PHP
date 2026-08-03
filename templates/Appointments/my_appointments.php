<?php
/**
 * Glamora Customer Appointments Hub View - High Contrast Luxury Collapsible List
 */
$this->assign('title', 'My Appointments - Glamora');
?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
      <h2 class="brand-font text-wine mb-1"><i class="bi bi-calendar-check-fill me-2 text-pink"></i>My Salon Appointments</h2>
      <p class="text-muted small mb-0">Click any appointment row below to view full booking details & actions</p>
    </div>
    <a href="<?= $this->Url->build('/book') ?>" class="btn btn-book-gradient-pill px-4 py-2 btn-sm fw-bold">
      <i class="bi bi-plus-lg me-1"></i> Book New Appointment
    </a>
  </div>

  <?php if ($appointments->isEmpty()): ?>
    <div class="glamora-card p-5 text-center rounded-4 shadow-sm bg-white">
      <i class="bi bi-calendar-x display-3 text-pink mb-3 d-block"></i>
      <h4 class="brand-font text-wine">No Appointments Found</h4>
      <p class="text-muted mb-4">You haven't booked any salon appointments yet.</p>
      <a href="<?= $this->Url->build('/book') ?>" class="btn btn-book-gradient-pill px-4 py-2">Book Your First Session</a>
    </div>
  <?php else: ?>
    
    <div class="accordion custom-appointments-accordion" id="appointmentsAccordion">
      <?php foreach ($appointments as $index => $app): ?>
        <?php
          $collapseId = 'appCollapse' . $app->id;
          $headingId = 'appHeading' . $app->id;
          
          $appDateStr = is_object($app->appointment_date) ? $app->appointment_date->format('Y-m-d') : (string)$app->appointment_date;
          $rawTime = $app->appointment_time;
          $appTimeStr = is_object($rawTime) ? $rawTime->format('h:i A') : date('h:i A', strtotime((string)$rawTime));

          // High Contrast Status Badges
          $statusBadges = [
            'Pending' => '<span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #FFF3CD; color: #856404; border: 1px solid #FFEEBA; font-size: 0.8rem;">🟡 PENDING APPROVAL</span>',
            'Confirmed' => '<span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #D4EDDA; color: #155724; border: 1px solid #C3E6CB; font-size: 0.8rem;">🟢 CONFIRMED</span>',
            'Completed' => '<span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #CCE5FF; color: #004085; border: 1px solid #B8DAFF; font-size: 0.8rem;">🔵 COMPLETED</span>',
            'Cancelled' => '<span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #F8D7DA; color: #721C24; border: 1px solid #F5C6CB; font-size: 0.8rem;">🔴 CANCELLED</span>',
            'Rescheduled' => '<span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #E2E3E5; color: #383D41; border: 1px solid #D6D8DB; font-size: 0.8rem;">🔄 RESCHEDULED</span>',
          ];
          $badgeHtml = $statusBadges[$app->status] ?? '<span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">' . h($app->status) . '</span>';
        ?>

        <div class="accordion-item rounded-4 shadow-sm bg-white mb-3 overflow-hidden" style="border: 1px solid #F2E4E8 !important;">
          
          <!-- Horizontal Visible Header Bar -->
          <h2 class="accordion-header" id="<?= $headingId ?>">
            <button class="accordion-button collapsed py-3 px-4 bg-white shadow-none text-dark d-flex align-items-center justify-content-between flex-wrap gap-3" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#<?= $collapseId ?>" 
                    aria-expanded="false" 
                    aria-controls="<?= $collapseId ?>">
              
              <!-- 1. Service Name -->
              <div class="d-flex align-items-center gap-3" style="min-width: 240px;">
                <div class="avatar-circle-sm rounded-circle d-flex align-items-center justify-content-center" style="width:42px; height:42px; background:#FDE8EF; color:#E87A90; font-size:1.1rem;">
                  <i class="bi bi-scissors"></i>
                </div>
                <div>
                  <small class="text-muted d-block fw-bold text-uppercase" style="font-size:0.68rem;">SERVICE NAME</small>
                  <h5 class="brand-font text-wine mb-0 fw-bold fs-6"><?= h($app->service->name ?? 'Salon Treatment') ?></h5>
                </div>
              </div>

              <!-- 2. Status Badge -->
              <div style="min-width: 170px;">
                <small class="text-muted d-block fw-bold text-uppercase mb-1" style="font-size:0.68rem;">STATUS</small>
                <?= $badgeHtml ?>
              </div>

              <!-- 3. Scheduled Date & Time -->
              <div style="min-width: 220px;">
                <small class="text-muted d-block fw-bold text-uppercase mb-1" style="font-size:0.68rem;">SCHEDULED DATE & TIME</small>
                <span class="fw-bold text-wine small">
                  <i class="bi bi-calendar3 me-1 text-pink"></i> <?= h($appDateStr) ?> 
                  <span class="ms-2"><i class="bi bi-clock me-1 text-pink"></i> <?= h($appTimeStr) ?></span>
                </span>
              </div>

            </button>
          </h2>

          <!-- Collapsible Detailed View (Opened on Click) -->
          <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="<?= $headingId ?>" data-bs-parent="#appointmentsAccordion">
            <div class="accordion-body p-4 bg-light-subtle border-top">
              <div class="row g-3 mb-3">
                <div class="col-md-3 col-6">
                  <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">Booking ID</small>
                  <strong class="text-wine fs-6">#GLAM-<?= $app->id ?></strong>
                </div>

                <div class="col-md-3 col-6">
                  <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">Assigned Beautician</small>
                  <strong class="text-wine fs-6"><?= h($app->beautician ? $app->beautician->name : 'Assigned Staff') ?></strong>
                </div>

                <div class="col-md-3 col-6">
                  <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">Total Price</small>
                  <strong class="text-pink fs-6">Rs. <?= number_format((float)$app->total_price, 2) ?></strong>
                </div>

                <div class="col-md-3 col-6">
                  <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.68rem;">Payment Method</small>
                  <strong class="text-wine fs-6"><?= h($app->payment ? $app->payment->payment_method : 'Pay at Salon') ?></strong>
                </div>

                <?php if (!empty($app->notes)): ?>
                  <div class="col-12">
                    <div class="p-3 bg-white rounded-3 border small text-muted">
                      <i class="bi bi-sticky text-pink me-1"></i> <strong>Special Request:</strong> <?= h($app->notes) ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Action Bar -->
              <div class="pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="small text-muted">
                  <i class="bi bi-shield-check text-success me-1"></i> Verified Salon Booking Entry
                </span>

                <?php if ($app->status !== 'Cancelled' && $app->status !== 'Completed'): ?>
                  <?= $this->Form->postLink(
                    '<i class="bi bi-x-circle me-1"></i> Cancel Appointment',
                    ['action' => 'cancel', $app->id],
                    [
                      'escape' => false,
                      'confirm' => __('Are you sure you want to cancel booking #{0}?', $app->id),
                      'class' => 'btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold'
                    ]
                  ) ?>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>
</div>

<style>
.custom-appointments-accordion .accordion-button::after {
  background-size: 1.2rem;
  margin-left: auto;
}
.custom-appointments-accordion .accordion-button:not(.collapsed) {
  background-color: #FAF4F6 !important;
}
</style>
