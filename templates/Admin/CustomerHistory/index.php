<?php
/**
 * Admin Customer History & Visit Logs Page
 */
$this->assign('title', 'Customer History & Visit Records');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="brand-font text-wine mb-1">Customer History & Visit Analytics</h3>
    <p class="text-muted small mb-0">View previous appointments, completed services, and visit frequency per client</p>
  </div>
</div>

<div class="row g-4">
  <!-- Customer Selector List -->
  <div class="col-lg-4">
    <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
      <h5 class="brand-font text-wine mb-3"><i class="bi bi-people me-2 text-pink"></i>Select Customer</h5>

      <div class="list-group list-group-flush">
        <?php foreach ($customers as $c): ?>
          <a href="<?= $this->Url->build(['action' => 'index', '?' => ['user_id' => $c->id]]) ?>" class="list-group-item list-group-item-action py-3 px-2 border-bottom <?= ($userId == $c->id) ? 'active bg-light-pink border-pink' : '' ?>">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <strong class="text-wine"><?= h($c->full_name) ?></strong>
              <span class="badge bg-pink text-white rounded-pill px-2 py-1" style="font-size:0.7rem; background:#E87A90;">
                <?= count($c->customer_histories ?? []) ?> Visits
              </span>
            </div>
            <small class="text-muted d-block"><?= h($c->phone) ?> | <?= h($c->email) ?></small>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Selected Customer Detailed Log -->
  <div class="col-lg-8">
    <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
      <?php if (!$selectedCustomer): ?>
        <div class="text-center py-5 text-muted">
          <i class="bi bi-person-bounding-box display-3 text-pink mb-3 d-block"></i>
          <h5>Select a Customer</h5>
          <p class="small">Choose a customer from the left list to view their treatment history & spending.</p>
        </div>
      <?php else: ?>
        <div class="d-flex justify-content-between align-items-start pb-3 mb-4 border-bottom">
          <div>
            <h4 class="brand-font text-wine mb-1"><?= h($selectedCustomer->full_name) ?></h4>
            <div class="text-muted small">
              <i class="bi bi-telephone me-1"></i> <?= h($selectedCustomer->phone) ?> | 
              <i class="bi bi-envelope me-1"></i> <?= h($selectedCustomer->email) ?> | 
              <i class="bi bi-geo-alt me-1"></i> <?= h($selectedCustomer->location ?: 'N/A') ?>
            </div>
          </div>
          <div class="text-end">
            <span class="badge bg-pink text-white px-3 py-2 rounded-pill font-monospace fs-6" style="background:#E87A90;">
              Total Spent: Rs. <?= number_format((float)array_sum(array_column($customerVisits, 'amount_paid')), 2) ?>
            </span>
          </div>
        </div>

        <h6 class="fw-bold text-wine mb-3"><i class="bi bi-clock-history me-2 text-pink"></i>Salon Visit & Service History Log</h6>

        <?php if (empty($customerVisits)): ?>
          <div class="alert alert-light border text-center py-4">No completed visit history recorded yet for this client.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Visit Date</th>
                  <th>Service Performed</th>
                  <th>Amount Paid</th>
                  <th>Salon Notes</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($customerVisits as $visit): ?>
                  <tr>
                    <td><strong class="text-wine"><?= h($visit->visit_date) ?></strong></td>
                    <td><span class="badge bg-light text-wine border border-pink px-2 py-1"><?= h($visit->service_name) ?></span></td>
                    <td class="fw-bold text-pink">Rs. <?= number_format((float)$visit->amount_paid, 2) ?></td>
                    <td><small class="text-muted"><?= h($visit->notes ?: 'Regular appointment session') ?></small></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

      <?php endif; ?>
    </div>
  </div>
</div>
